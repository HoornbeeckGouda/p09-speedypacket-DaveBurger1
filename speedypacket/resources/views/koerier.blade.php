@extends('layouts.app')

@section('title', 'Koerier Dashboard')

@section('content')
<style>
    .courier-hero {
        background: linear-gradient(135deg, #16a34a, #15803d, #166534);
        color: #fff;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 40px;
        position: relative;
    }
    .courier-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        animation: courier-float 8s ease-in-out infinite;
    }
    @keyframes courier-float {
        0%, 100% { transform: translate(-50%, -50%) rotate(0deg); }
        50% { transform: translate(-50%, -50%) rotate(180deg); }
    }
    .courier-hero h2 {
        margin: 0;
        font-size: 36px;
        font-weight: 800;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    .courier-hero p {
        margin: 16px 0 0;
        opacity: 0.9;
        font-size: 20px;
        position: relative;
        z-index: 1;
        font-weight: 400;
    }
    .courier-stats-card {
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
    .courier-stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #16a34a, #15803d);
    }
    .courier-stats-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 64px rgba(0,0,0,0.15);
    }
    .courier-stats-card.deliveries { border-left-color: #2563eb; }
    .courier-stats-card.available { border-left-color: #059669; }
    .courier-stats-card.efficiency { border-left-color: #d97706; }
    .courier-stats-card i {
        font-size: 40px;
        margin-bottom: 16px;
        background: linear-gradient(135deg, #16a34a, #15803d);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .courier-stats-card h3 {
        margin: 0;
        font-size: 42px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 12px;
    }
    .courier-stats-card p {
        margin: 0;
        color: #64748b;
        font-size: 18px;
        font-weight: 600;
    }

    .courier-section {
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
    .courier-table {
        width: 100%;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .courier-table table {
        width: 100%;
        border-collapse: collapse;
    }
    .courier-table thead {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        display: table-header-group;
    }
    .courier-table tbody {
        display: table-row-group;
    }
    .courier-table tr {
        display: table-row;
    }
    .courier-table th, .courier-table td {
        display: table-cell;
        vertical-align: middle;
    }
    .courier-table th {
        padding: 20px;
        font-weight: 700;
        color: #1e293b;
        font-size: 16px;
        text-align: left;
        border-bottom: 2px solid #e2e8f0;
    }
    .courier-table td {
        padding: 20px;
        color: #374151;
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.2s ease;
    }
    .courier-table tr:hover td {
        background: rgba(22,163,74,0.02);
    }
    .courier-action-btn {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        padding: 12px 24px;
        background: linear-gradient(135deg, #16a34a, #15803d);
        color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(22,163,74,0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
    }
    .courier-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(22,163,74,0.4);
        text-decoration: none;
        color: #fff;
    }
    .courier-action-btn.secondary {
        background: linear-gradient(135deg, #059669, #047857);
        box-shadow: 0 4px 16px rgba(5,150,105,0.3);
    }
    .courier-action-btn.secondary:hover {
        box-shadow: 0 8px 24px rgba(5,150,105,0.4);
    }
    .courier-action-btn i {
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
    .status-in_transit { background: #dbeafe; color: #2563eb; }
    .status-pending { background: #fef3c7; color: #d97706; }
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
    .map-container {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        margin-bottom: 32px;
    }
    .route-overview {
        margin-top: 16px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 8px;
    }
    .route-overview h5 {
        margin: 0 0 12px;
        color: #1e293b;
    }
    .route-overview ol {
        margin: 0;
        padding-left: 20px;
        color: #64748b;
        font-size: 14px;
    }
    .route-overview li {
        margin-bottom: 8px;
    }
    @media (max-width: 768px) {
        .courier-hero {
            padding: 24px;
            margin-bottom: 24px;
        }
        .courier-hero h2 {
            font-size: 28px;
        }
        .courier-hero p {
            font-size: 16px;
        }
        .courier-stats-card {
            padding: 24px;
        }
        .courier-stats-card h3 {
            font-size: 32px;
        }
        .courier-section {
            padding: 20px;
        }
        .courier-table th,
        .courier-table td {
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

<div class="card" style="margin:0 auto;" id="koerier-page">
    <!-- Enhanced Courier Hero Section -->
    <div class="courier-hero" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2><i class="fas fa-truck"></i> Welkom terug, {{ auth()->user()->name }}!</h2>
            <p>Beheer uw bezorgingen efficiënt en overzichtelijk.</p>
        </div>
    </div>

    <!-- Enhanced Stats Cards with Mini Charts -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px;">
        <div class="courier-stats-card deliveries">
            <i class="fas fa-box"></i>
            <h3>{{ $packagesToDeliver->count() }}</h3>
            <p>Pakketten om te Bezorgen</p>
        </div>
        <div class="courier-stats-card available">
            <i class="fas fa-hand-paper"></i>
            <h3>{{ $pendingPackages->count() }}</h3>
            <p>Beschikbare Pakketten</p>
        </div>
        <div class="courier-stats-card efficiency">
            <i class="fas fa-tachometer-alt"></i>
            <h3>{{ $packagesToDeliver->count() > 0 ? round(($packagesToDeliver->where('status', 'delivered')->count() / $packagesToDeliver->count()) * 100) : 0 }}%</h3>
            <p>Bezorg Efficiëntie</p>
        </div>
    </div>

    <!-- Enhanced Route Section -->
    <section class="map-container">
        <h4 style="margin-bottom: 12px; font-size: 24px; font-weight: 700; color: #1e293b;">
            <i class="fas fa-route" style="margin-right: 12px; color: #64748b;"></i>Route Planning
        </h4>
        @if($packagesToDeliver->count() > 0)
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
                <div id="map" style="height: 400px; width: 100%; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);" data-addresses='@json(collect([$startAddress])->merge($packagesToDeliver->pluck("recipient_address")->toArray()))' data-road-closures='@json($roadClosures)'></div>
                <div class="route-overview">
                    <h5 style="font-size: 18px; font-weight: 600;">
                        <i class="fas fa-list-ol" style="margin-right: 8px;"></i>Route Overzicht
                    </h5>
                    <ol style="margin:0; padding-left: 20px; color:#64748b; font-size: 14px;">
                        <li style="margin-bottom: 8px;"><strong style="color: #2563eb;">Start:</strong> {{ $startAddress }}</li>
                        @foreach($packagesToDeliver as $index => $package)
                            <li style="margin-bottom: 8px;">
                                <strong style="color: #059669;">{{ $index + 1 }}.</strong>
                                {{ $package->recipient_address }}
                                <span style="color: #6b7280;">({{ $package->recipient_name }})</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        @else
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 40px; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
                <i class="fas fa-map-marked-alt" style="font-size: 64px; color: #cbd5e1; margin-bottom: 24px;"></i>
                <h5 style="color: #64748b; margin: 0 0 8px; font-size: 18px;">Geen Route Beschikbaar</h5>
                <p style="color: #94a3b8; margin: 0; font-size: 16px;">Neem eerst pakketten aan om uw route te plannen.</p>
            </div>
        @endif
    </section>

    <!-- Enhanced Package Management Sections -->
    <div style="display: grid; grid-template-columns: 1fr; gap: 32px;">

        <!-- Packages to Deliver Section -->
        <div class="courier-section">
            <h4 style="margin-bottom: 24px; font-size: 24px; font-weight: 700; color: #1e293b;">
                <i class="fas fa-box" style="margin-right: 12px; color: #2563eb;"></i>Pakketten om te Bezorgen
            </h4>
            @if($packagesToDeliver->count() > 0)
                <div class="courier-table">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag" style="margin-right: 8px;"></i>Tracking Nummer</th>
                                <th><i class="fas fa-user" style="margin-right: 8px;"></i>Ontvanger</th>
                                <th><i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i>Adres</th>
                                <th><i class="fas fa-cogs" style="margin-right: 8px;"></i>Actie</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($packagesToDeliver as $package)
                            <tr>
                                <td>
                                    <code style="background: #dbeafe; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-family: 'Courier New', monospace; color: #1e40af;">
                                        {{ $package->tracking_number }}
                                    </code>
                                </td>
                                <td>{{ $package->recipient_name }}</td>
                                <td>{{ $package->recipient_address }}</td>
                                <td>
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        <a href="{{ route('koerier.package.details', $package->id) }}" class="courier-action-btn" style="padding: 8px 16px; font-size: 12px;">
                                            <i class="fas fa-qrcode"></i>QR Code
                                        </a>
                                        <form method="POST" action="{{ route('koerier.deliver', $package->id) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="courier-action-btn secondary" style="padding: 8px 16px; font-size: 12px;">
                                                <i class="fas fa-check"></i>Bezorgd
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 40px; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
                    <i class="fas fa-inbox" style="font-size: 64px; color: #cbd5e1; margin-bottom: 24px;"></i>
                    <h5 style="color: #64748b; margin: 0 0 8px; font-size: 18px;">Geen Pakketten om te Bezorgen</h5>
                    <p style="color: #94a3b8; margin: 0; font-size: 16px;">Alle pakketten zijn succesvol bezorgd.</p>
                </div>
            @endif
        </div>

        <!-- Available Packages Section -->
        <div class="courier-section">
            <h4 style="margin-bottom: 24px; font-size: 24px; font-weight: 700; color: #1e293b;">
                <i class="fas fa-hand-paper" style="margin-right: 12px; color: #059669;"></i>Beschikbare Pakketten
            </h4>
            @if($pendingPackages->count() > 0)
                <div class="courier-table">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag" style="margin-right: 8px;"></i>Tracking Nummer</th>
                                <th><i class="fas fa-user" style="margin-right: 8px;"></i>Ontvanger</th>
                                <th><i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i>Adres</th>
                                <th><i class="fas fa-plus" style="margin-right: 8px;"></i>Actie</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($pendingPackages as $package)
                            <tr>
                                <td>
                                    <code style="background: #dbeafe; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-family: 'Courier New', monospace; color: #1e40af;">
                                        {{ $package->tracking_number }}
                                    </code>
                                </td>
                                <td>{{ $package->recipient_name }}</td>
                                <td>{{ $package->recipient_address }}</td>
                                <td>
                                    <form method="POST" action="{{ route('koerier.take', $package->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="courier-action-btn" style="padding: 8px 16px; font-size: 12px;">
                                            <i class="fas fa-plus"></i>Neem Aan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 40px; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
                    <i class="fas fa-inbox" style="font-size: 64px; color: #cbd5e1; margin-bottom: 24px;"></i>
                    <h5 style="color: #64748b; margin: 0 0 8px; font-size: 18px;">Geen Beschikbare Pakketten</h5>
                    <p style="color: #94a3b8; margin: 0; font-size: 16px;">Alle pakketten zijn al toegewezen aan koeriers.</p>
                </div>
            @endif
        </div>

        <!-- Returned Packages Section -->
        <div class="courier-section">
            <h4 style="margin-bottom: 24px; font-size: 24px; font-weight: 700; color: #1e293b;">
                <i class="fas fa-undo" style="margin-right: 12px; color: #dc2626;"></i>Retour Pakketten
            </h4>
            @if($returnedPackages->count() > 0)
                <div class="courier-table">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag" style="margin-right: 8px;"></i>Tracking Nummer</th>
                                <th><i class="fas fa-user" style="margin-right: 8px;"></i>Ontvanger</th>
                                <th><i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i>Adres</th>
                                <th><i class="fas fa-truck" style="margin-right: 8px;"></i>Actie</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($returnedPackages as $package)
                            <tr>
                                <td>
                                    <code style="background: #dbeafe; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-family: 'Courier New', monospace; color: #1e40af;">
                                        {{ $package->tracking_number }}
                                    </code>
                                </td>
                                <td>{{ $package->recipient_name }}</td>
                                <td>{{ $package->recipient_address }}</td>
                                <td>
                                    <form method="POST" action="{{ route('koerier.pickup.return', $package->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="courier-action-btn" style="padding: 8px 16px; font-size: 12px; background: linear-gradient(135deg, #dc2626, #b91c1c);">
                                            <i class="fas fa-hand-paper"></i>Pickup Return
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 40px; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
                    <i class="fas fa-inbox" style="font-size: 64px; color: #cbd5e1; margin-bottom: 24px;"></i>
                    <h5 style="color: #64748b; margin: 0 0 8px; font-size: 18px;">Geen Retour Pakketten</h5>
                    <p style="color: #94a3b8; margin: 0; font-size: 16px;">Er zijn momenteel geen retour pakketten om op te halen.</p>
                </div>
            @endif
        </div>
    </div>


@endsection
