@extends('layouts.app')

@section('title', 'Magazijn Medewerker Dashboard')

@section('content')
    <style>
        .warehouse-hero {
            background: linear-gradient(135deg, #a16207, #92400e, #6b7280);
            color: #fff;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }
        .warehouse-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(59,130,246,0.1) 0%, transparent 70%);
            animation: warehouse-float 10s ease-in-out infinite;
        }
        @keyframes warehouse-float {
            0%, 100% { transform: translate(-50%, -50%) rotate(0deg); }
            50% { transform: translate(-50%, -50%) rotate(180deg); }
        }
        .warehouse-hero h2 {
            margin: 0;
            font-size: 36px;
            font-weight: 800;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }
        .warehouse-hero p {
            margin: 16px 0 0;
            opacity: 0.9;
            font-size: 20px;
            position: relative;
            z-index: 1;
            font-weight: 400;
        }
        .warehouse-stats-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 32px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border-left: 4px solid;
        }
        .warehouse-stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #0f172a, #1e293b);
        }
        .warehouse-stats-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 64px rgba(0,0,0,0.15);
        }
        .warehouse-stats-card.storage { border-left-color: #0f172a; }
        .warehouse-stats-card.transit { border-left-color: #f59e0b; }
        .warehouse-stats-card.delivered { border-left-color: #10b981; }
        .warehouse-stats-card i {
            font-size: 40px;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .warehouse-stats-card h3 {
            margin: 0;
            font-size: 42px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 12px;
        }
        .warehouse-stats-card p {
            margin: 0;
            color: #64748b;
            font-size: 18px;
            font-weight: 600;
        }

        .warehouse-section {
            background: #fff;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            margin-bottom: 32px;
            animation: fadeInUp 0.5s ease-out;
        }
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .warehouse-table {
            width: 100%;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .warehouse-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .warehouse-table thead {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            display: table-header-group;
        }
        .warehouse-table tbody {
            display: table-row-group;
        }
        .warehouse-table tr {
            display: table-row;
        }
        .warehouse-table th, .warehouse-table td {
            display: table-cell;
            vertical-align: middle;
        }
        .warehouse-table th {
            padding: 20px;
            font-weight: 700;
            color: #1e293b;
            font-size: 16px;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
        }
        .warehouse-table td {
            padding: 20px;
            color: #374151;
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s ease;
        }
        .warehouse-table tr:hover td {
            background: rgba(15,23,42,0.02);
        }
        .warehouse-action-btn {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            padding: 12px 24px;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(15,23,42,0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }
        .warehouse-action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(15,23,42,0.4);
            text-decoration: none;
            color: #fff;
        }
        .warehouse-action-btn.secondary {
            background: linear-gradient(135deg, #059669, #047857);
            box-shadow: 0 4px 16px rgba(5,150,105,0.3);
        }
        .warehouse-action-btn.secondary:hover {
            box-shadow: 0 8px 24px rgba(5,150,105,0.4);
        }
        .warehouse-action-btn i {
            margin-right: 8px;
            font-size: 16px;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-in_warehouse { background: #dbeafe; color: #1e40af; }
        .status-in_transit { background: #fef3c7; color: #d97706; }
        .status-delivered { background: #dcfce7; color: #059669; }
        .alert-enhanced {
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
            border: 1px solid;
            position: relative;
            overflow: hidden;
            animation: slideIn 0.3s ease-out;
        }
        .alert-enhanced::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }
        .alert-success {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            color: #166534;
            border-color: #bbf7d0;
        }
        .alert-success::before { background: #16a34a; }
        .alert-error {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #991b1b;
            border-color: #fecaca;
        }
        .alert-error::before { background: #dc2626; }
        .alert-enhanced i {
            margin-right: 8px;
            font-size: 18px;
        }
        @keyframes slideIn {
            0% { transform: translateX(-100%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }
        .warehouse-location-badge {
            display: inline-block;
            padding: 4px 8px;
            background: #e0f2fe;
            color: #0369a1;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
        }
        .rayon-badge {
            display: inline-block;
            padding: 4px 8px;
            background: #f0f9ff;
            color: #0c4a6e;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
        }

        @media (max-width: 768px) {
            .warehouse-hero {
                padding: 24px;
                margin-bottom: 24px;
            }
            .warehouse-hero h2 {
                font-size: 28px;
            }
            .warehouse-hero p {
                font-size: 16px;
            }
            .warehouse-stats-card {
                padding: 24px;
            }
            .warehouse-stats-card h3 {
                font-size: 32px;
            }
            .warehouse-section {
                padding: 20px;
            }
            .warehouse-table th,
            .warehouse-table td {
                padding: 12px 8px;
                font-size: 14px;
            }
        }
    </style>
    <!-- Enhanced Alert Messages -->
    @if(session('success'))
        <div class="alert-enhanced alert-success">
            <i class="fas fa-check-circle"></i>
            <strong>Succes:</strong> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-enhanced alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <strong>Fout:</strong> {{ session('error') }}
        </div>
    @endif

    <div class="card" style="margin:0 auto;" id="magazijn-page">
        <!-- Enhanced Warehouse Hero Section -->
        <div class="warehouse-hero" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2><i class="fas fa-warehouse"></i> Welkom terug, {{ auth()->user()->name }}!</h2>
                <p>Beheer de magazijnvoorraad en logistiek overzichtelijk.</p>
            </div>
            <div style="position: relative; z-index: 2;">
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button class="btn logout-btn" type="submit" data-route="magazijn_medewerker" style="margin: 0;">Uitloggen</button>
                </form>
            </div>
        </div>

        <!-- Enhanced Stats Cards with Mini Charts -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px;">
            <div class="warehouse-stats-card storage">
                <i class="fas fa-box"></i>
                <h3>{{ $packagesInStorage->count() }}</h3>
                <p>In Magazijn</p>
            </div>
            <div class="warehouse-stats-card transit">
                <i class="fas fa-truck"></i>
                <h3>{{ $packagesInTransit->count() }}</h3>
                <p>In Transit</p>
            </div>
            <div class="warehouse-stats-card delivered">
                <i class="fas fa-check-circle"></i>
                <h3>{{ $packagesDelivered->count() }}</h3>
                <p>Bezorgd</p>
            </div>
        </div>

        <!-- Enhanced Package Management Sections -->
        <div style="display: grid; grid-template-columns: 1fr; gap: 32px;">

            <!-- Packages in Storage Section -->
            <div class="warehouse-section">
                <h4 style="margin-bottom: 24px; font-size: 24px; font-weight: 700; color: #1e293b;">
                    <i class="fas fa-box" style="margin-right: 12px; color: #0f172a;"></i>Pakketten in Magazijn
                </h4>
                @if($packagesInStorage->count() > 0)
                    <div class="warehouse-table">
                        <table>
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag" style="margin-right: 8px;"></i>Tracking Nummer</th>
                                    <th><i class="fas fa-user" style="margin-right: 8px;"></i>Ontvanger</th>
                                    <th><i class="fas fa-weight-hanging" style="margin-right: 8px;"></i>Gewicht</th>
                                    <th><i class="fas fa-tags" style="margin-right: 8px;"></i>Rayon</th>
                                    <th><i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i>Locatie</th>
                                    <th><i class="fas fa-calendar" style="margin-right: 8px;"></i>Aangemaakt</th>
                                    <th><i class="fas fa-cogs" style="margin-right: 8px;"></i>Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($packagesInStorage as $package)
                                <tr>
                                    <td>
                                        <code style="background: #dbeafe; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-family: 'Courier New', monospace; color: #1e40af;">
                                            {{ $package->tracking_number }}
                                        </code>
                                    </td>
                                    <td>{{ $package->recipient_name }}</td>
                                    <td>
                                        {{ $package->weight ? $package->weight . ' kg' : 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $package->rayon }}
                                        <span class="rayon-badge">{{ $package->rayon }}</span>
                                    </td>
                                    <td>
                                        {{ $package->warehouse_location }}
                                        <span class="warehouse-location-badge">{{ $package->warehouse_location }}</span>
                                    </td>
                                    <td>{{ $package->created_at->format('d-m-Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('pakket.qr', $package->id) }}" class="warehouse-action-btn" style="padding: 8px 16px; font-size: 12px;">
                                            <i class="fas fa-qrcode"></i>QR
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 40px; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
                        <i class="fas fa-inbox" style="font-size: 64px; color: #cbd5e1; margin-bottom: 24px;"></i>
                        <h5 style="color: #64748b; margin: 0 0 8px; font-size: 18px;">Geen Pakketten in Magazijn</h5>
                        <p style="color: #94a3b8; margin: 0; font-size: 16px;">Alle pakketten zijn verzonden of bezorgd.</p>
                    </div>
                @endif
            </div>

            <!-- Packages in Transit Section -->
            <div class="warehouse-section">
                <h4 style="margin-bottom: 24px; font-size: 24px; font-weight: 700; color: #1e293b;">
                    <i class="fas fa-truck" style="margin-right: 12px; color: #f59e0b;"></i>Pakketten in Transit
                </h4>
                @if($packagesInTransit->count() > 0)
                    <div class="warehouse-table">
                        <table>
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag" style="margin-right: 8px;"></i>Tracking Nummer</th>
                                    <th><i class="fas fa-user" style="margin-right: 8px;"></i>Ontvanger</th>
                                    <th><i class="fas fa-user-tie" style="margin-right: 8px;"></i>Koerier</th>
                                    <th><i class="fas fa-clock" style="margin-right: 8px;"></i>Status</th>
                                    <th><i class="fas fa-calendar" style="margin-right: 8px;"></i>Bijgewerkt</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($packagesInTransit as $package)
                                <tr>
                                    <td>
                                        <code style="background: #fef3c7; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-family: 'Courier New', monospace; color: #d97706;">
                                            {{ $package->tracking_number }}
                                        </code>
                                    </td>
                                    <td>{{ $package->recipient_name }}</td>
                                    <td>
                                        @if($package->koerier)
                                            <span style="display: inline-flex; align-items: center; background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                                <i class="fas fa-user-tie" style="margin-right: 4px;"></i>{{ $package->koerier->name }}
                                            </span>
                                        @else
                                            <span style="color: #94a3b8; font-style: italic;">Niet toegewezen</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge status-in_transit">In Transit</span>
                                    </td>
                                    <td>{{ $package->updated_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 40px; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
                        <i class="fas fa-truck" style="font-size: 64px; color: #cbd5e1; margin-bottom: 24px;"></i>
                        <h5 style="color: #64748b; margin: 0 0 8px; font-size: 18px;">Geen Pakketten in Transit</h5>
                        <p style="color: #94a3b8; margin: 0; font-size: 16px;">Alle pakketten zijn in het magazijn of bezorgd.</p>
                    </div>
                @endif
            </div>

            <!-- Packages Delivered Section -->
            <div class="warehouse-section">
                <h4 style="margin-bottom: 24px; font-size: 24px; font-weight: 700; color: #1e293b;">
                    <i class="fas fa-check-circle" style="margin-right: 12px; color: #10b981;"></i>Pakketten Bezorgd
                </h4>
                @if($packagesDelivered->count() > 0)
                    <div class="warehouse-table">
                        <table>
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag" style="margin-right: 8px;"></i>Tracking Nummer</th>
                                    <th><i class="fas fa-user" style="margin-right: 8px;"></i>Ontvanger</th>
                                    <th><i class="fas fa-user-tie" style="margin-right: 8px;"></i>Koerier</th>
                                    <th><i class="fas fa-check" style="margin-right: 8px;"></i>Status</th>
                                    <th><i class="fas fa-calendar-check" style="margin-right: 8px;"></i>Bezorgd</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($packagesDelivered as $package)
                                <tr>
                                    <td>
                                        <code style="background: #dcfce7; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-family: 'Courier New', monospace; color: #059669;">
                                            {{ $package->tracking_number }}
                                        </code>
                                    </td>
                                    <td>{{ $package->recipient_name }}</td>
                                    <td>
                                        @if($package->koerier)
                                            <span style="display: inline-flex; align-items: center; background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                                <i class="fas fa-user-tie" style="margin-right: 4px;"></i>{{ $package->koerier->name }}
                                            </span>
                                        @else
                                            <span style="color: #94a3b8; font-style: italic;">Niet toegewezen</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge status-delivered">Bezorgd</span>
                                    </td>
                                    <td>{{ $package->updated_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 40px; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
                        <i class="fas fa-check-circle" style="font-size: 64px; color: #cbd5e1; margin-bottom: 24px;"></i>
                        <h5 style="color: #64748b; margin: 0 0 8px; font-size: 18px;">Geen Pakketten Bezorgd</h5>
                        <p style="color: #94a3b8; margin: 0; font-size: 16px;">Nog geen pakketten succesvol bezorgd.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>


@endsection
