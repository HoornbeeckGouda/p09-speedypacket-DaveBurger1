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
    $user = Auth::user();

    // Redirect to role-specific dashboard
    switch ($user->role) {
        case 'directie':
            return redirect()->route('directie');
        case 'koerier':
            return redirect()->route('koerier');
        case 'ontvanger':
            return redirect()->route('ontvanger');
        case 'magazijn':
            return redirect()->route('magazijn');
        case 'backoffice':
            return redirect()->route('backoffice');
        default:
            // Fallback to general dashboard for other roles
            $totalPackages = Package::count();
            $pendingPackages = Package::where('status', 'pending')->count();
            $deliveredPackages = Package::where('status', 'delivered')->count();
            return view('dashboard', compact('totalPackages', 'pendingPackages', 'deliveredPackages'));
    }
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

    // Package statistics
    $totalPackages = Package::count();
    $pendingPackages = Package::where('status', 'pending')->count();
    $inTransitPackages = Package::where('status', 'in_transit')->count();
    $deliveredPackages = Package::where('status', 'delivered')->count();
    $recentPackages = Package::with('user')->orderBy('created_at', 'desc')->limit(8)->get();

    return view('directie', compact('totalUsers','directieCount','otherCount','recentUsers','totalPackages','pendingPackages','inTransitPackages','deliveredPackages','recentPackages'));
})->middleware('auth')->name('directie');

Route::get('/koerier', function () {
    $user = Auth::user();
    if (! $user || $user->role !== 'koerier') {
        abort(403);
    }

    $packagesToDeliver = Package::where('status', 'in_transit')->orderBy('id')->get();
    $pendingPackages = Package::where('status', 'pending')->orderBy('id')->get();
    $startAddress = 'Overslagweg 2, Waddinxveen, Netherlands';

    return view('koerier', compact('packagesToDeliver', 'pendingPackages', 'startAddress'));
})->middleware('auth')->name('koerier');

Route::post('/koerier/take/{id}', [PackageController::class, 'take'])->middleware('auth')->name('koerier.take');
Route::post('/koerier/deliver/{id}', [PackageController::class, 'deliver'])->middleware('auth')->name('koerier.deliver');

Route::post('/magazijn/assign/{id}', [PackageController::class, 'assign'])->middleware('auth')->name('magazijn.assign');

Route::get('/ontvanger', function () {
    $user = Auth::user();
    if (! $user || $user->role !== 'ontvanger') {
        abort(403);
    }

    $packagesInTransit = Package::where('status', 'in_transit')->where('recipient_email', $user->email)->get();
    $deliveredPackages = Package::where('status', 'delivered')->where('recipient_email', $user->email)->count();
    $pendingPackages = Package::where('status', 'pending')->where('recipient_email', $user->email)->count();
    $billedPackages = Package::where('status', 'billed')->where('recipient_email', $user->email)->get();
    $recentPackages = Package::where('recipient_email', $user->email)->orderBy('updated_at', 'desc')->limit(10)->get();

    // Get koerier locations for packages in transit
    $koerierLocations = $packagesInTransit->map(function ($package) {
        $koerier = $package->koerier;
        return [
            'package_id' => $package->id,
            'address' => $package->recipient_address,
            'koerier_name' => $koerier ? $koerier->name : 'Unknown Koerier',
            'latitude' => $koerier ? $koerier->latitude : null,
            'longitude' => $koerier ? $koerier->longitude : null
        ];
    });

    return view('ontvanger', compact('packagesInTransit', 'deliveredPackages', 'pendingPackages', 'billedPackages', 'recentPackages', 'koerierLocations'));
})->middleware('auth')->name('ontvanger');

Route::get('/magazijn', function () {
    $user = Auth::user();
    if (! $user || $user->role !== 'magazijn') {
        abort(403);
    }

    $packagesInStorage = Package::where('status', 'pending')->orderBy('created_at', 'desc')->get();
    $packagesInTransit = Package::with('koerier')->where('status', 'in_transit')->orderBy('updated_at', 'desc')->get();
    $packagesDelivered = Package::where('status', 'delivered')->orderBy('updated_at', 'desc')->get();

    return view('magazijn_medewerker', compact('packagesInStorage', 'packagesInTransit', 'packagesDelivered'));
})->middleware('auth')->name('magazijn');

Route::get('/backoffice', function () {
    $user = Auth::user();
    if (! $user || $user->role !== 'backoffice') {
        abort(403);
    }

    $deliveredPackages = Package::where('status', 'delivered')->orderBy('updated_at', 'desc')->get();
    $billedPackages = Package::where('status', 'billed')->orderBy('updated_at', 'desc')->get();

    return view('backoffice', compact('deliveredPackages', 'billedPackages'));
})->middleware('auth')->name('backoffice');

Route::post('/backoffice/bill/{id}', [PackageController::class, 'billPackage'])->middleware('auth')->name('backoffice.bill');

Route::post('/ontvanger/pay/{id}', [PackageController::class, 'payPackage'])->middleware('auth')->name('ontvanger.pay');

Route::get('/api/welcome', function () {
    Log::info('Request received: ' . request()->method() . ' ' . request()->path());
    return response()->json(['message' => 'Welcome to SpeedyPacket!']);
});

Route::middleware('auth')->group(function () {
    Route::get('/api/delivered-packages', [PackageController::class, 'getDeliveredPackages']);
    Route::post('/api/delivered-packages/{id}/bill', [PackageController::class, 'billPackage']);
});

// Verzender routes
Route::middleware('auth')->group(function () {
    Route::get('/nieuwe-verzending', [PackageController::class, 'create'])->name('nieuwe-verzending');
    Route::post('/nieuwe-verzending', [PackageController::class, 'store'])->name('nieuwe-verzending.store');
    Route::get('/mijn-verzendingen', [PackageController::class, 'index'])->name('mijn-verzendingen');
    Route::post('/pakketten/send/{id}', [PackageController::class, 'send'])->name('pakketten.send');
    Route::get('/pakketten-volgen', [PackageController::class, 'track'])->name('pakketten-volgen');
});

// Ontvanger routes
Route::middleware('auth')->group(function () {
    Route::get('/ontvanger-pakketten-volgen', [PackageController::class, 'ontvangerTrack'])->name('ontvanger-pakketten-volgen');
});
