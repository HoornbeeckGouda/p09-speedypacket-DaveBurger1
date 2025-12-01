@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <style>
        .dashboard-icon {
            font-size: 1.5em;
            color: var(--accent);
            margin-right: 10px;
            background: rgba(11, 95, 255, 0.1);
            padding: 8px;
            border-radius: 50%;
            display: inline-block;
        }
    </style>
    <div class="card">
        <!-- Hero Section -->
        <div style="background: linear-gradient(135deg, var(--accent), #4f46e5); color: #fff; border-radius: 12px; padding: 24px; margin-bottom: 24px;">
            <h2 style="margin: 0; font-size: 28px;"><i class="fas fa-tachometer-alt dashboard-icon"></i> Welkom terug, {{ auth()->user()->name }}!</h2>
            <p style="margin: 8px 0 0; opacity: 0.9;">Beheer uw verzendingen eenvoudig en efficiënt.</p>
        </div>

        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 18px; margin-bottom: 24px;">
            <div style="background: #fff; border: 1px solid #eef2ff; border-radius: 12px; padding: 18px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <i class="fas fa-box" style="font-size: 24px; color: var(--accent); margin-bottom: 8px;"></i>
                <h3 style="margin: 0; font-size: 24px; color: #111;">{{ $totalPackages }}</h3>
                <p style="margin: 4px 0 0; color: var(--muted); font-size: 14px;">Totaal Verzendingen</p>
            </div>
            <div style="background: #fff; border: 1px solid #eef2ff; border-radius: 12px; padding: 18px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <i class="fas fa-clock" style="font-size: 24px; color: #f59e0b; margin-bottom: 8px;"></i>
                <h3 style="margin: 0; font-size: 24px; color: #111;">{{ $pendingPackages }}</h3>
                <p style="margin: 4px 0 0; color: var(--muted); font-size: 14px;">In Behandeling</p>
            </div>
            <div style="background: #fff; border: 1px solid #eef2ff; border-radius: 12px; padding: 18px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <i class="fas fa-check-circle" style="font-size: 24px; color: #10b981; margin-bottom: 8px;"></i>
                <h3 style="margin: 0; font-size: 24px; color: #111;">{{ $deliveredPackages }}</h3>
                <p style="margin: 4px 0 0; color: var(--muted); font-size: 14px;">Bezorgd</p>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 320px;gap:24px;">
            <div>
                <!-- Verzender Actions -->
                <section style="margin-bottom: 24px;">
                    <h4 style="margin-bottom: 12px;"><i class="fas fa-tasks"></i> Verzender Acties</h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 12px;">
                        <a href="{{ route('nieuwe-verzending') }}" class="btn" style="display: flex; align-items: center; text-decoration: none; padding: 12px 16px; background: var(--accent); color: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(11,95,255,0.2);">
                            <i class="fas fa-plus-circle" style="margin-right: 8px;"></i> Nieuwe Verzending Aanmaken
                        </a>
                        <a href="{{ route('mijn-verzendingen') }}" class="btn secondary" style="display: flex; align-items: center; text-decoration: none; padding: 12px 16px;">
                            <i class="fas fa-list" style="margin-right: 8px;"></i> Mijn Verzendingen Bekijken
                        </a>
                        <a href="{{ route('pakketten-volgen') }}" class="btn secondary" style="display: flex; align-items: center; text-decoration: none; padding: 12px 16px;">
                            <i class="fas fa-search" style="margin-right: 8px;"></i> Pakketten Volgen
                        </a>
                    </div>
                </section>
                <section>
                    <ul style="color:var(--muted); list-style: none; padding: 0;">
                        @if(auth()->user()->role === 'directie')
                            <li style="margin-bottom: 8px;"><a href="{{ route('directie') }}" style="color: var(--accent); text-decoration: none;"><i class="fas fa-building"></i> Directie Home</a></li>
                        @endif
                        @if(auth()->user()->role === 'koerier')
                            <li style="margin-bottom: 8px;"><a href="{{ route('koerier') }}" style="color: var(--accent); text-decoration: none;"><i class="fas fa-truck"></i> Koerier Dashboard</a></li>
                        @endif
                        @if(auth()->user()->role === 'ontvanger')
                            <li style="margin-bottom: 8px;"><a href="{{ route('ontvanger') }}" style="color: var(--accent); text-decoration: none;"><i class="fas fa-inbox"></i> Ontvanger Dashboard</a></li>
                        @endif
                        @if(auth()->user()->role === 'magazijn_medewerker')
                            <li style="margin-bottom: 8px;"><a href="{{ route('magazijn_medewerker') }}" style="color: var(--accent); text-decoration: none;"><i class="fas fa-warehouse"></i> Magazijn Medewerker Dashboard</a></li>
                        @endif
                    </ul>
                </section>
            </div>
        </div>
    </div>
@endsection
