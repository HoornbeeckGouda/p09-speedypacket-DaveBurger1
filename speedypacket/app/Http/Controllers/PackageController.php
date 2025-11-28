<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Package;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'verzender') {
            abort(403);
        }

        return view('nieuwe-verzending');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'verzender') {
            abort(403);
        }

        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_email' => 'nullable|email|max:255',
            'recipient_phone' => 'nullable|string|max:20',
            'recipient_address' => 'required|string',
            'description' => 'nullable|string|max:1000',
            'weight' => 'nullable|numeric|min:0|max:999999.99',
        ]);

        $trackingNumber = 'SP' . strtoupper(Str::random(10));

        Package::create([
            'user_id' => $user->id,
            'recipient_name' => $validated['recipient_name'],
            'recipient_email' => $validated['recipient_email'],
            'recipient_phone' => $validated['recipient_phone'],
            'recipient_address' => $validated['recipient_address'],
            'description' => $validated['description'],
            'weight' => $validated['weight'],
            'status' => 'pending',
            'tracking_number' => $trackingNumber,
        ]);

        return Redirect::route('mijn-verzendingen')->with('success', 'Nieuwe verzending aangemaakt met tracking nummer: ' . $trackingNumber);
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'verzender') {
            abort(403);
        }

        $packages = Package::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('mijn-verzendingen', compact('packages'));
    }

    public function track(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'verzender') {
            abort(403);
        }

        $package = null;
        $trackingNumber = $request->input('tracking_number');

        if ($trackingNumber) {
            $package = Package::where('tracking_number', $trackingNumber)->first();
            if (!$package || $package->user_id !== $user->id) {
                $package = null;
            }
        }

        return view('pakketten-volgen', compact('package', 'trackingNumber'));
    }
}
