<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/welcome', function () {
    Log::info('Request received: ' . request()->method() . ' ' . request()->path());
    return response()->json(['message' => 'Welcome to SpeedyPacket!']);
});
