@extends('layouts.app')

@section('title', 'Inloggen')

@section('header')
@endsection

@section('content')
<style>
body { overflow: hidden; height: 100vh; }
</style>
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-100 to-blue-200">
        <div class="card bg-gradient-to-br from-blue-500 to-blue-100 shadow-2xl rounded-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 hover:scale-105">
            <div class="text-center mb-6">
                <!-- SpeedyPacket Logo: Truck with Wings -->
                <svg width="120" height="80" viewBox="0 0 120 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4">
                    <!-- Wings -->
                    <path d="M10 20 L30 10 L50 20 L30 30 Z" fill="#ffffff" stroke="#0b5fff" stroke-width="2"/>
                    <path d="M70 20 L90 10 L110 20 L90 30 Z" fill="#ffffff" stroke="#0b5fff" stroke-width="2"/>
                    <!-- Truck Body -->
                    <rect x="20" y="35" width="80" height="30" rx="5" fill="#0b5fff"/>
                    <!-- Wheels -->
                    <circle cx="35" cy="70" r="8" fill="#ffffff" stroke="#0b5fff" stroke-width="2"/>
                    <circle cx="85" cy="70" r="8" fill="#ffffff" stroke="#0b5fff" stroke-width="2"/>
                    <!-- Package -->
                    <rect x="45" y="40" width="15" height="15" fill="#ffffff" stroke="#0b5fff" stroke-width="1"/>
                    <line x1="45" y1="45" x2="60" y2="45" stroke="#0b5fff"/>
                    <line x1="52.5" y1="40" x2="52.5" y2="55" stroke="#0b5fff"/>
                </svg>
                <h1 class="text-4xl font-bold text-black mb-2">SpeedyPacket</h1>
                <p class="text-black text-lg">Snelle en betrouwbare verzendingen</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-inner">
                <h2 class="text-3xl font-semibold text-black mb-4 text-center">Inloggen</h2>
                <p class="text-black mb-6 text-center text-lg">Voer je gebruikersnaam en wachtwoord in om door te gaan.</p>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-black px-4 py-3 rounded mb-4">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login.attempt') }}">
                    @csrf

                    <label for="username" class="block text-base font-medium text-black mb-2">Gebruikersnaam</label>
                    <input id="username" name="username" type="text" value="{{ old('username') }}" placeholder="gebruikersnaam of e-mail"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 mb-4">

                    <label for="password" class="block text-base font-medium text-black mb-2">Wachtwoord</label>
                    <input id="password" name="password" type="password" placeholder="Wachtwoord"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 mb-6">

                    <div class="flex space-x-4">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-black font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg text-lg">Inloggen</button>
                        <a href="{{ url('/') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-black font-semibold py-3 px-4 rounded-lg transition-all duration-200 text-center shadow-lg text-lg">Terug</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
