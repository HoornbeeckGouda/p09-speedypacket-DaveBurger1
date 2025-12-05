<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\Models\Package;
use Illuminate\Support\Str;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;


class PackageController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'verzender') {
            abort(403);
        }

        $ontvangers = \App\Models\User::ontvangers();

        return view('nieuwe-verzending', compact('ontvangers'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'verzender') {
            abort(403);
        }

        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'recipient_address' => 'required|string',
            'description' => 'nullable|string|max:1000',
            'weight' => 'nullable|numeric|min:0|max:999999.99',
        ]);

        $recipient = \App\Models\User::findOrFail($validated['recipient_id']);
        if ($recipient->role !== 'ontvanger') {
            abort(403, 'Selected user is not an ontvanger.');
        }

        $trackingNumber = 'SP' . strtoupper(Str::random(10));

        // Generate QR code with URL
        $url = url('/track/' . $trackingNumber);
        $qrCode = new QrCode($url);
        $writer = new SvgWriter();
        $result = $writer->write($qrCode);
        $qrCodeData = $result->getString(); // SVG is already a string
        // Resize SVG to 200x200
        $qrCodeData = str_replace(['width="320px"', 'height="320px"'], ['width="200px"', 'height="200px"'], $qrCodeData);

        // Assign rayon based on address (simple logic: check for province keywords)
        $address = strtolower($validated['recipient_address']);
        $rayon = 'Noord-Holland'; // default
        if (strpos($address, 'zuid-holland') !== false || strpos($address, 'rotterdam') !== false || strpos($address, 'den haag') !== false) {
            $rayon = 'Zuid-Holland';
        } elseif (strpos($address, 'noord-brabant') !== false || strpos($address, 'eindhoven') !== false || strpos($address, 'tilburg') !== false) {
            $rayon = 'Noord-Brabant';
        } elseif (strpos($address, 'gelderland') !== false || strpos($address, 'arnhem') !== false || strpos($address, 'nijmegen') !== false) {
            $rayon = 'Gelderland';
        }

        // Assign warehouse location based on rayon
        $warehouseLocations = [
            'Noord-Holland' => 'Amsterdam Warehouse',
            'Zuid-Holland' => 'Rotterdam Warehouse',
            'Noord-Brabant' => 'Eindhoven Warehouse',
            'Gelderland' => 'Arnhem Warehouse',
        ];
        $warehouseLocation = $warehouseLocations[$rayon] ?? 'Amsterdam Warehouse';

        Package::create([
            'user_id' => $user->id,
            'recipient_name' => $recipient->name,
            'recipient_email' => $recipient->email,
            'recipient_phone' => $recipient->phone,
            'recipient_address' => $validated['recipient_address'],
            'description' => $validated['description'],
            'weight' => $validated['weight'],
            'status' => 'pending',
            'tracking_number' => $trackingNumber,
            'qr_code' => $qrCodeData,
            'rayon' => $rayon,
            'warehouse_location' => $warehouseLocation,
        ]);

        return Redirect::route('mijn-verzendingen')->with('success', 'Nieuwe verzending aangemaakt met tracking nummer: ' . $trackingNumber);
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'verzender') {
            abort(403);
        }

        $packages = Package::with('koerier')->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('mijn-verzendingen', compact('packages'));
    }

    public function track(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'verzender') {
            abort(403);
        }

        $validated = $request->validate([
            'tracking_number' => 'nullable|string|regex:/^SP[A-Z0-9]{10}$/',
        ]);

        $package = null;
        $trackingNumber = $validated['tracking_number'] ?? null;

        if ($trackingNumber) {
            $package = Package::with('koerier', 'user')->where('tracking_number', $trackingNumber)->first();
            if (!$package || $package->user_id !== $user->id) {
                $package = null;
            }
        }

        // Calculate estimated delivery if package exists
        $estimatedDelivery = null;
        if ($package) {
            $estimatedDelivery = $this->calculateEstimatedDelivery($package);
        }

        return view('pakketten-volgen', compact('package', 'trackingNumber', 'estimatedDelivery'));
    }

    public function ontvangerTrack(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'ontvanger') {
            abort(403);
        }

        $package = null;
        $trackingNumber = $request->input('tracking_number');

        if ($trackingNumber) {
            $package = Package::where('tracking_number', $trackingNumber)->first();
            if (!$package || $package->recipient_email !== $user->email) {
                $package = null;
            }
        }

        // Calculate estimated delivery if package exists
        $estimatedDelivery = null;
        if ($package) {
            $estimatedDelivery = $this->calculateEstimatedDelivery($package);
        }

        return view('pakketten-volgen', compact('package', 'trackingNumber', 'estimatedDelivery'));
    }

    public function take(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'koerier') {
            abort(403);
        }

        $package = Package::findOrFail($id);

        if ($package->status !== 'pending') {
            return redirect()->route('koerier')->with('error', 'Pakket is niet beschikbaar om te nemen.');
        }

        $package->update([
            'status' => 'in_transit',
            'koerier_id' => $user->id
        ]);

        return redirect()->route('koerier')->with('success', 'Pakket genomen voor bezorging.');
    }

    public function deliver(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'koerier') {
            abort(403);
        }

        $package = Package::findOrFail($id);

        if ($package->status !== 'in_transit' || $package->koerier_id !== $user->id) {
            return redirect()->route('koerier')->with('error', 'Pakket kan niet worden bezorgd.');
        }

        $package->update([
            'status' => 'delivered'
        ]);

        return redirect()->route('koerier')->with('success', 'Pakket succesvol bezorgd.');
    }

    public function pickupReturn(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'koerier') {
            abort(403);
        }

        $package = Package::findOrFail($id);

        if ($package->status !== 'returned') {
            return redirect()->route('koerier')->with('error', 'Pakket is niet beschikbaar voor retour ophaling.');
        }

        $package->update([
            'status' => 'in_warehouse',
            'koerier_id' => $user->id
        ]);

        return redirect()->route('koerier')->with('success', 'Retour pakket succesvol opgehaald en teruggebracht naar het magazijn.');
    }

    public function getDeliveredPackages()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'backoffice') {
            abort(403);
        }

        $packages = Package::where('status', 'delivered')->with('user', 'koerier')->get();

        return response()->json($packages);
    }

    public function billPackage(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'backoffice') {
            abort(403);
        }

        $package = Package::findOrFail($id);

        if ($package->status !== 'delivered') {
            return redirect()->route('backoffice')->with('error', 'Pakket is niet bezorgd.');
        }

        $package->update(['status' => 'billed']);

        return redirect()->route('backoffice')->with('success', 'Pakket succesvol gefactureerd.');
    }
    public function payPackage(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'ontvanger') {
            abort(403);
        }

        $package = Package::findOrFail($id);

        if ($package->status !== 'billed' || $package->recipient_email !== $user->email) {
            return redirect()->route('ontvanger')->with('error', 'Pakket kan niet worden betaald.');
        }

        $package->update(['status' => 'delivered']);

        return redirect()->route('ontvanger')->with('success', 'Bedankt voor uw betaling! Het pakket is succesvol bezorgd.');
    }

    public function koerierPackageDetails(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'koerier') {
            abort(403);
        }

        $package = Package::with('koerier')->findOrFail($id);

        if ($package->koerier_id !== $user->id) {
            abort(403, 'U heeft geen toegang tot dit pakket.');
        }

        return view('koerier-package-details', compact('package'));
    }

    public function showQr(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'magazijn') {
            abort(403);
        }

        $package = Package::findOrFail($id);

        // Allow access to packages in warehouse for scanning/verification
        if ($package->status !== 'pending') {
            abort(403, 'Dit pakket is niet in het magazijn.');
        }

        // Generate QR code if not present
        if (!$package->qr_code) {
            $url = url('/track/' . $package->tracking_number);
            $qrCode = new QrCode($url);
            $writer = new SvgWriter();
            $result = $writer->write($qrCode);
            $qrCodeData = $result->getString(); // SVG is already a string
            // Resize SVG to 200x200
            $qrCodeData = str_replace(['width="320px"', 'height="320px"'], ['width="200px"', 'height="200px"'], $qrCodeData);
            $package->update(['qr_code' => $qrCodeData]);
        }

        return view('pakket-qr', compact('package'));
    }

    public function publicTrack($trackingNumber)
    {
        // Validate tracking number format
        if (!preg_match('/^SP[A-Z0-9]{10}$/', $trackingNumber)) {
            abort(404);
        }

        $package = Package::with('koerier')->where('tracking_number', $trackingNumber)->first();

        return view('public-track', compact('package'));
    }

    public function initiateReturn(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'ontvanger') {
            abort(403);
        }

        $package = Package::findOrFail($id);

        if ($package->recipient_email !== $user->email || !in_array($package->status, ['delivered', 'paid'])) {
            return redirect()->route('ontvanger')->with('error', 'Pakket kan niet worden geretourneerd.');
        }

        $package->update(['status' => 'returned']);

        return redirect()->route('ontvanger')->with('success', 'Retour is succesvol geïnitieerd.');
    }

    public function generateRetourbonPDF($id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'ontvanger') {
            abort(403);
        }

        $package = Package::findOrFail($id);

        if ($package->recipient_email !== $user->email || $package->status !== 'returned') {
            abort(403, 'Geen toegang tot deze retourbon.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('retourbon', compact('package', 'user'));

        return $pdf->download('retourbon-' . $package->tracking_number . '.pdf');
    }

    private function calculateEstimatedDelivery($package)
    {
        // Simple estimation: 2-5 days from creation, depending on status
        $created = $package->created_at;
        $days = 2; // default

        if ($package->status === 'in_transit') {
            $days = 3;
        } elseif ($package->status === 'delivered') {
            return $package->updated_at->format('d-m-Y'); // already delivered
        }

        return $created->addDays($days)->format('d-m-Y');
    }
}
