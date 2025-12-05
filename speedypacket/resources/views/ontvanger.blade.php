@extends('layouts.app')

@section('title', 'Ontvanger Dashboard')

@section('content')
<style>
    .receiver-hero {
        background: linear-gradient(135deg, #dc2626, #b91c1c, #991b1b);
        color: #fff;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 40px;
        position: relative;
    }
    .receiver-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        animation: receiver-float 8s ease-in-out infinite;
    }
    @keyframes receiver-float {
        0%, 100% { transform: translate(-50%, -50%) rotate(0deg); }
        50% { transform: translate(-50%, -50%) rotate(180deg); }
    }
    .receiver-hero h2 {
        margin: 0;
        font-size: 36px;
        font-weight: 800;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    .receiver-hero p {
        margin: 16px 0 0;
        opacity: 0.9;
        font-size: 20px;
        position: relative;
        z-index: 1;
        font-weight: 400;
    }
    .receiver-stats-card {
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
    .receiver-stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #059669, #047857);
    }
    .receiver-stats-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 64px rgba(0,0,0,0.15);
    }
    .receiver-stats-card.in-transit { border-left-color: #059669; }
    .receiver-stats-card.billed { border-left-color: #f59e0b; }
    .receiver-stats-card.delivered { border-left-color: #10b981; }
    .receiver-stats-card i {
        font-size: 40px;
        margin-bottom: 16px;
        background: linear-gradient(135deg, #059669, #047857);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .receiver-stats-card h3 {
        margin: 0;
        font-size: 42px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 12px;
    }
    .receiver-stats-card p {
        margin: 0;
        color: #64748b;
        font-size: 18px;
        font-weight: 600;
    }

    .receiver-section {
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
    .receiver-table {
        width: 100%;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .receiver-table table {
        width: 100%;
        border-collapse: collapse;
    }
    .receiver-table thead {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        display: table-header-group;
    }
    .receiver-table tbody {
        display: table-row-group;
    }
    .receiver-table tr {
        display: table-row;
    }
    .receiver-table th, .receiver-table td {
        display: table-cell;
        vertical-align: middle;
    }
    .receiver-table th {
        padding: 20px;
        font-weight: 700;
        color: #1e293b;
        font-size: 16px;
        text-align: left;
        border-bottom: 2px solid #e2e8f0;
    }
    .receiver-table td {
        padding: 20px;
        color: #374151;
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.2s ease;
    }
    .receiver-table tr:hover td {
        background: rgba(5,150,105,0.02);
    }
    .receiver-action-btn {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        padding: 12px 24px;
        background: linear-gradient(135deg, #059669, #047857);
        color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(5,150,105,0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
    }
    .receiver-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(5,150,105,0.4);
        text-decoration: none;
        color: #fff;
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
    .status-billed { background: #fef3c7; color: #d97706; }
    .status-delivered { background: #d1fae5; color: #059669; }
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
    @media (max-width: 768px) {
        .receiver-hero {
            padding: 24px;
            margin-bottom: 24px;
        }
        .receiver-hero h2 {
            font-size: 28px;
        }
        .receiver-hero p {
            font-size: 16px;
        }
        .receiver-stats-card {
            padding: 24px;
        }
        .receiver-stats-card h3 {
            font-size: 32px;
        }
        .receiver-section {
            padding: 20px;
        }
        .receiver-table th,
        .receiver-table td {
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

<div class="card" style="margin:0 auto;" id="ontvanger-page">
    <!-- Enhanced Receiver Hero Section -->
    <div class="receiver-hero">
        <h2><i class="fas fa-inbox"></i> Welkom terug, {{ auth()->user()->name }}!</h2>
        <p>Beheer uw ontvangen pakketten en betalingen overzichtelijk.</p>
    </div>

    <!-- Enhanced Stats Cards with Mini Charts -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px;">
        <div class="receiver-stats-card in-transit">
            <i class="fas fa-truck"></i>
            <h3>{{ $packagesInTransit->count() }}</h3>
            <p>Pakketten Onderweg</p>
        </div>
        <div class="receiver-stats-card billed">
            <i class="fas fa-file-invoice-dollar"></i>
            <h3>{{ $billedPackages->count() }}</h3>
            <p>Gefactureerde Pakketten</p>
        </div>
        <div class="receiver-stats-card delivered">
            <i class="fas fa-check-circle"></i>
            <h3>{{ $deliveredPackages->count() }}</h3>
            <p>Ontvangen Pakketten</p>
        </div>
    </div>

    <!-- Enhanced Package Tracking Section -->
    <div style="display: grid; grid-template-columns: 1fr; gap: 32px;">

        <!-- Packages in Transit Section -->
        <div class="receiver-section">
            <h4 style="margin-bottom: 24px; font-size: 24px; font-weight: 700; color: #1e293b;">
                <i class="fas fa-truck" style="margin-right: 12px; color: #059669;"></i>Pakketten Onderweg
            </h4>
            @if($packagesInTransit->count() > 0)
                <div class="receiver-table">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag" style="margin-right: 8px;"></i>Tracking Nummer</th>
                                <th><i class="fas fa-user" style="margin-right: 8px;"></i>Verzender</th>
                                <th><i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i>Adres</th>
                                <th><i class="fas fa-info-circle" style="margin-right: 8px;"></i>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($packagesInTransit as $package)
                            <tr>
                                <td>
                                    <code style="background: #dbeafe; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-family: 'Courier New', monospace; color: #1e40af;">
                                        {{ $package->tracking_number }}
                                    </code>
                                </td>
                                <td>{{ $package->user->name }}</td>
                                <td>{{ $package->recipient_address }}</td>
                                <td>
                                    <span class="status-badge status-{{ $package->status }}">
                                        {{ ucfirst(str_replace('_', ' ', $package->status)) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 40px; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
                    <i class="fas fa-inbox" style="font-size: 64px; color: #cbd5e1; margin-bottom: 24px;"></i>
                    <h5 style="color: #64748b; margin: 0 0 8px; font-size: 18px;">Geen Pakketten Onderweg</h5>
                    <p style="color: #94a3b8; margin: 0; font-size: 16px;">Alle pakketten zijn succesvol ontvangen.</p>
                </div>
            @endif
        </div>

        <!-- Location Map Section -->
        <section class="map-container">
            <h4 style="margin-bottom: 12px; font-size: 24px; font-weight: 700; color: #1e293b;">
                <i class="fas fa-map-marked-alt" style="margin-right: 12px; color: #64748b;"></i>Pakket Locaties
            </h4>
            @if($packagesInTransit->count() > 0)
                <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
                    <div id="map" style="height: 400px; width: 100%; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);" data-addresses='@json($packagesInTransit->pluck("recipient_address")->toArray())'></div>
                </div>
            @else
                <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 40px; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
                    <i class="fas fa-map-marked-alt" style="font-size: 64px; color: #cbd5e1; margin-bottom: 24px;"></i>
                    <h5 style="color: #64748b; margin: 0 0 8px; font-size: 18px;">Geen Locatie Beschikbaar</h5>
                    <p style="color: #94a3b8; margin: 0; font-size: 16px;">Er zijn geen pakketten om te volgen.</p>
                </div>
            @endif
        </section>

        <!-- Billed Packages Section -->
        <div class="receiver-section">
            <h4 style="margin-bottom: 24px; font-size: 24px; font-weight: 700; color: #1e293b;">
                <i class="fas fa-file-invoice-dollar" style="margin-right: 12px; color: #f59e0b;"></i>Gefactureerde Pakketten (Betaling Vereist)
            </h4>
            @if($billedPackages->count() > 0)
                <div class="receiver-table">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag" style="margin-right: 8px;"></i>Tracking Nummer</th>
                                <th><i class="fas fa-user" style="margin-right: 8px;"></i>Verzender</th>
                                <th><i class="fas fa-weight-hanging" style="margin-right: 8px;"></i>Gewicht</th>
                                <th><i class="fas fa-calendar-alt" style="margin-right: 8px;"></i>Gefactureerd</th>
                                <th><i class="fas fa-credit-card" style="margin-right: 8px;"></i>Actie</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($billedPackages as $package)
                            <tr>
                                <td>
                                    <code style="background: #dbeafe; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-family: 'Courier New', monospace; color: #1e40af;">
                                        {{ $package->tracking_number }}
                                    </code>
                                </td>
                                <td>{{ $package->user->name ?? 'Onbekend' }}</td>
                                <td>{{ $package->weight ? $package->weight . ' kg' : 'N/A' }}</td>
                                <td>{{ $package->updated_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('ontvanger.pay', $package->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="receiver-action-btn">
                                            <i class="fas fa-credit-card"></i> Betalen
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
                    <i class="fas fa-check-circle" style="font-size: 64px; color: #cbd5e1; margin-bottom: 24px;"></i>
                    <h5 style="color: #64748b; margin: 0 0 8px; font-size: 18px;">Geen Uitstaande Betalingen</h5>
                    <p style="color: #94a3b8; margin: 0; font-size: 16px;">Alle gefactureerde pakketten zijn betaald.</p>
                </div>
            @endif
        </div>

        <!-- Delivered Packages Section for Returns -->
        <div class="receiver-section">
            <h4 style="margin-bottom: 24px; font-size: 24px; font-weight: 700; color: #1e293b;">
                <i class="fas fa-box-open" style="margin-right: 12px; color: #10b981;"></i>Ontvangen Pakketten (Retour Mogelijk)
            </h4>
            @if($deliveredPackages->count() > 0)
                <div class="receiver-table">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag" style="margin-right: 8px;"></i>Tracking Nummer</th>
                                <th><i class="fas fa-user" style="margin-right: 8px;"></i>Verzender</th>
                                <th><i class="fas fa-weight-hanging" style="margin-right: 8px;"></i>Gewicht</th>
                                <th><i class="fas fa-calendar-alt" style="margin-right: 8px;"></i>Ontvangen Op</th>
                                <th><i class="fas fa-undo" style="margin-right: 8px;"></i>Retour</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($deliveredPackages as $package)
                            <tr>
                                <td>
                                    <code style="background: #dbeafe; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-family: 'Courier New', monospace; color: #1e40af;">
                                        {{ $package->tracking_number }}
                                    </code>
                                </td>
                                <td>{{ $package->user->name ?? 'Onbekend' }}</td>
                                <td>{{ $package->weight ? $package->weight . ' kg' : 'N/A' }}</td>
                                <td>{{ $package->updated_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('ontvanger.initiate-return', $package->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="receiver-action-btn" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                                            <i class="fas fa-undo"></i> Retourneren
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
                    <i class="fas fa-box-open" style="font-size: 64px; color: #cbd5e1; margin-bottom: 24px;"></i>
                    <h5 style="color: #64748b; margin: 0 0 8px; font-size: 18px;">Geen Ontvangen Pakketten</h5>
                    <p style="color: #94a3b8; margin: 0; font-size: 16px;">Er zijn geen pakketten om te retourneren.</p>
                </div>
            @endif
        </div>

        <!-- Returned Packages Section -->
        <div class="receiver-section">
            <h4 style="margin-bottom: 24px; font-size: 24px; font-weight: 700; color: #1e293b;">
                <i class="fas fa-undo-alt" style="margin-right: 12px; color: #8b5cf6;"></i>Geretourneerde Pakketten
            </h4>
            @php
                $returnedPackages = \App\Models\Package::where('recipient_email', auth()->user()->email)->where('status', 'returned')->get();
            @endphp
            @if($returnedPackages->count() > 0)
                <div class="receiver-table">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag" style="margin-right: 8px;"></i>Tracking Nummer</th>
                                <th><i class="fas fa-user" style="margin-right: 8px;"></i>Verzender</th>
                                <th><i class="fas fa-weight-hanging" style="margin-right: 8px;"></i>Gewicht</th>
                                <th><i class="fas fa-calendar-alt" style="margin-right: 8px;"></i>Geretourneerd Op</th>
                                <th><i class="fas fa-download" style="margin-right: 8px;"></i>Retourbon</th>
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
                                <td>{{ $package->user->name ?? 'Onbekend' }}</td>
                                <td>{{ $package->weight ? $package->weight . ' kg' : 'N/A' }}</td>
                                <td>{{ $package->updated_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('ontvanger.retourbon', $package->id) }}" class="receiver-action-btn" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);" target="_blank">
                                        <i class="fas fa-download"></i> Download PDF
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 40px; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,0.08);">
                    <i class="fas fa-undo-alt" style="font-size: 64px; color: #cbd5e1; margin-bottom: 24px;"></i>
                    <h5 style="color: #64748b; margin: 0 0 8px; font-size: 18px;">Geen Geretourneerde Pakketten</h5>
                    <p style="color: #94a3b8; margin: 0; font-size: 16px;">Er zijn geen geretourneerde pakketten.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
