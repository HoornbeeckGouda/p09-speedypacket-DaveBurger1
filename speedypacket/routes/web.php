<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

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
    return view('dashboard');
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

Route::get('/api/welcome', function () {
    Log::info('Request received: ' . request()->method() . ' ' . request()->path());
    return response()->json(['message' => 'Welcome to SpeedyPacket!']);
});
