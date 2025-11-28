<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\Package;
use App\Http\Controllers\PackageController;

Route::get('/', function () {
    return view('main');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $data = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $credentials = ['username' => $data['username'], 'password' => $data['password']];


    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return Redirect::intended('/dashboard');
    }

    return back()->withErrors(['username' => 'Onjuiste gebruikersnaam of wachtwoord'])->withInput();
})->name('login.attempt');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/dashboard', function () {
    $totalPackages = Package::count();
    $pendingPackages = Package::where('status', 'pending')->count();
    $deliveredPackages = Package::where('status', 'delivered')->count();

    return view('dashboard', compact('totalPackages', 'pendingPackages', 'deliveredPackages'));
})->middleware('auth')->name('dashboard');

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth')->name('profile');

Route::get('/directie', function () {
    $user = Auth::user();
    if (! $user || $user->role !== 'directie') {
        abort(403);
    }

    $totalUsers = User::count();
    $directieCount = User::where('role', 'directie')->count();
    $otherCount = $totalUsers - $directieCount;
    $recentUsers = User::orderBy('created_at', 'desc')->limit(8)->get();

    return view('directie', compact('totalUsers','directieCount','otherCount','recentUsers'));
})->middleware('auth')->name('directie');

Route::get('/bezorger', function () {
    $user = Auth::user();
    if (! $user || $user->role !== 'bezorger') {
        abort(403);
    }

    $packagesInTransit = Package::where('status', 'in_transit')->count();
    $deliveredPackages = Package::where('status', 'delivered')->count();
    $pendingPackages = Package::where('status', 'pending')->count();
    $recentPackages = Package::where('status', 'in_transit')->orderBy('updated_at', 'desc')->limit(10)->get();

    return view('bezorger', compact('packagesInTransit', 'deliveredPackages', 'pendingPackages', 'recentPackages'));
})->middleware('auth')->name('bezorger');

Route::get('/ontvanger', function () {
    $user = Auth::user();
    if (! $user || $user->role !== 'ontvanger') {
        abort(403);
    }

    $packagesInTransit = Package::where('status', 'in_transit')->count();
    $deliveredPackages = Package::where('status', 'delivered')->count();
    $pendingPackages = Package::where('status', 'pending')->count();
    $recentPackages = Package::orderBy('updated_at', 'desc')->limit(10)->get();

    return view('ontvanger', compact('packagesInTransit', 'deliveredPackages', 'pendingPackages', 'recentPackages'));
})->middleware('auth')->name('ontvanger');

Route::get('/magazijn-medewerker', function () {
    $user = Auth::user();
    if (! $user || $user->role !== 'magazijn_medewerker') {
        abort(403);
    }

    $packagesInTransit = Package::where('status', 'in_transit')->count();
    $deliveredPackages = Package::where('status', 'delivered')->count();
    $pendingPackages = Package::where('status', 'pending')->count();
    $recentPackages = Package::orderBy('updated_at', 'desc')->limit(10)->get();

    return view('magazijn_medewerker', compact('packagesInTransit', 'deliveredPackages', 'pendingPackages', 'recentPackages'));
})->middleware('auth')->name('magazijn-medewerker');

Route::get('/api/welcome', function () {
    Log::info('Request received: ' . request()->method() . ' ' . request()->path());
    return response()->json(['message' => 'Welcome to SpeedyPacket!']);
});

// Verzender routes
Route::middleware('auth')->group(function () {
    Route::get('/nieuwe-verzending', [PackageController::class, 'create'])->name('nieuwe-verzending');
    Route::post('/nieuwe-verzending', [PackageController::class, 'store'])->name('nieuwe-verzending.store');
    Route::get('/mijn-verzendingen', [PackageController::class, 'index'])->name('mijn-verzendingen');
    Route::get('/pakketten-volgen', [PackageController::class, 'track'])->name('pakketten-volgen');
});
