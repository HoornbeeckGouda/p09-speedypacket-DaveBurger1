@extends('layouts.app')

@section('title', 'Main')

@section('content')
    <style>
        header { display: none; }
        .container { margin: 0; padding: 0; }
        main { margin: 0; padding: 0; min-height: 100vh; }
    </style>
    <!-- Hero Section -->
    <div style="background: linear-gradient(135deg, #0b5fff 0%, #667eea 100%); color: white; padding: 60px 20px; border-radius: 12px; text-align: center; margin-bottom: 40px; box-shadow: 0 10px 30px rgba(11,95,255,0.3);">
        <h1 style="font-size: 3rem; margin: 0 0 10px 0; font-weight: 700;">Welkom bij SpeedyPacket</h1>
        <p style="font-size: 1.2rem; margin: 0 0 30px 0; opacity: 0.9;">Snelle, betrouwbare verzendingen voor al uw pakketten.</p>
        <a href="{{ route('dashboard') }}" class="btn" style="background: white; color: #0b5fff; padding: 12px 24px; font-weight: 600; text-decoration: none; border-radius: 8px; display: inline-block;">Ga naar Login</a>
    </div>

    <!-- Features Section -->
    <div style="display: flex; justify-content: space-between; gap: 20px; flex-wrap: wrap;">
        <div class="card" style="flex: 1; min-width: 250px; text-align: center; padding: 30px 20px;">
            <i class="fas fa-shipping-fast" style="font-size: 3rem; color: #0b5fff; margin-bottom: 15px;"></i>
            <h3 style="margin: 0 0 10px 0; color: #111;">Snelle Levering</h3>
            <p style="color: #6b7280; margin: 0;">Uw pakketten worden razendsnel bezorgd, waar ter wereld.</p>
        </div>
        <div class="card" style="flex: 1; min-width: 250px; text-align: center; padding: 30px 20px;">
            <i class="fas fa-search-location" style="font-size: 3rem; color: #0b5fff; margin-bottom: 15px;"></i>
            <h3 style="margin: 0 0 10px 0; color: #111;">Realtime Tracking</h3>
            <p style="color: #6b7280; margin: 0;">Volg uw pakketten in realtime met onze geavanceerde trackingtechnologie.</p>
        </div>
        <div class="card" style="flex: 1; min-width: 250px; text-align: center; padding: 30px 20px;">
            <i class="fas fa-shield-alt" style="font-size: 3rem; color: #0b5fff; margin-bottom: 15px;"></i>
            <h3 style="margin: 0 0 10px 0; color: #111;">Veilige Verzending</h3>
            <p style="color: #6b7280; margin: 0;">Uw pakketten zijn altijd veilig dankzij onze beveiligde processen.</p>
        </div>
    </div>
@endsection
