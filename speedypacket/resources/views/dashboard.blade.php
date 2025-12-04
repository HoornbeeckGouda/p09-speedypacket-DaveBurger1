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
        .verzender-hero {
            background: linear-gradient(135deg, #dc2626, #b91c1c, #991b1b);
            color: #fff;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
        }
        .verzender-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translate(-50%, -50%) rotate(0deg); }
            50% { transform: translate(-50%, -50%) rotate(180deg); }
        }
        .verzender-hero h2 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }
        .verzender-hero p {
            margin: 12px 0 0;
            opacity: 0.95;
            font-size: 18px;
            position: relative;
            z-index: 1;
        }
        .stats-card {
            background: #fff;
            border: 1px solid #e6eef8;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), #06b6d4);
        }
        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
        }
        .stats-card i {
            font-size: 32px;
            margin-bottom: 12px;
            background: linear-gradient(135deg, var(--accent), #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .stats-card h3 {
            margin: 0;
            font-size: 36px;
            font-weight: 700;
            color: #111;
            margin-bottom: 8px;
        }
        .stats-card p {
            margin: 0;
            color: var(--muted);
            font-size: 16px;
            font-weight: 500;
        }
        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e6eef8;
            border-radius: 4px;
            margin-top: 12px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--accent), #06b6d4);
            border-radius: 4px;
            transition: width 1s ease;
        }
        .action-btn {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            padding: 14px 20px;
            background: linear-gradient(135deg, var(--accent), #06b6d4);
            color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(11,95,255,0.3);
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 16px;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(11,95,255,0.4);
            text-decoration: none;
            color: #fff;
        }
        .action-btn i {
            margin-right: 8px;
            font-size: 18px;
        }
        .action-btn.secondary {
            background: linear-gradient(135deg, #6b7280, #9ca3af);
            box-shadow: 0 4px 16px rgba(107,114,128,0.3);
        }
        .action-btn.secondary:hover {
            box-shadow: 0 8px 24px rgba(107,114,128,0.4);
        }
        .pending-icon {
            background: linear-gradient(135deg, #f59e0b, #d97706) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }
        .delivered-icon {
            background: linear-gradient(135deg, #10b981, #059669) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }
        .total-fill {
            width: 100% !important;
        }
        .pending-fill {
            background: linear-gradient(90deg, #f59e0b, #d97706) !important;
        }
        .delivered-fill {
            background: linear-gradient(90deg, #10b981, #059669) !important;
        }
    </style>
    <div class="card">
        <!-- Hero Section -->
        <div class="verzender-hero" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2><i class="fas fa-paper-plane"></i> Welkom terug, {{ auth()->user()->name }}!</h2>
                <p>Beheer uw verzendingen eenvoudig en efficiënt als verzender.</p>
            </div>
            <div style="position: relative; z-index: 2;">
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button class="btn logout-btn" type="submit" data-route="dashboard" style="margin: 0;">Uitloggen</button>
                </form>
            </div>
        </div>

        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 32px;">
            <div class="stats-card">
                <i class="fas fa-box"></i>
                <h3>{{ $totalPackages }}</h3>
                <p>Totaal Verzendingen</p>
                <div class="progress-bar">
                    <div class="progress-fill total-fill"></div>
                </div>
            </div>
            <div class="stats-card">
                <i class="fas fa-clock pending-icon"></i>
                <h3>{{ $pendingPackages }}</h3>
                <p>In Behandeling</p>
                <div class="progress-bar">
                    <div class="progress-fill pending-fill" data-width="{{ $totalPackages > 0 ? round(($pendingPackages / $totalPackages) * 100) : 0 }}"></div>
                </div>
            </div>
            <div class="stats-card">
                <i class="fas fa-check-circle delivered-icon"></i>
                <h3>{{ $deliveredPackages }}</h3>
                <p>Bezorgd</p>
                <div class="progress-bar">
                    <div class="progress-fill delivered-fill" data-width="{{ $totalPackages > 0 ? round(($deliveredPackages / $totalPackages) * 100) : 0 }}"></div>
                </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate progress bars
            const progressFills = document.querySelectorAll('.progress-fill[data-width]');
            progressFills.forEach(fill => {
                const width = fill.getAttribute('data-width');
                setTimeout(() => {
                    fill.style.width = width + '%';
                }, 500);
            });
        });
    </script>
@endsection
