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

        $package = null;
        $trackingNumber = $request->input('tracking_number');

        if ($trackingNumber) {
            $package = Package::with('koerier')->where('tracking_number', $trackingNumber)->first();
            if (!$package || $package->user_id !== $user->id) {
                $package = null;
            }
        }

        return view('pakketten-volgen', compact('package', 'trackingNumber'));
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

        return view('pakketten-volgen', compact('package', 'trackingNumber'));
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
}
