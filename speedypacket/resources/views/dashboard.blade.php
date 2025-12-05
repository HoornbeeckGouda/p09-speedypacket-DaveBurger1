@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .verzender-hero {
        background: linear-gradient(135deg, #2563eb, #1d4ed8, #1e40af);
        color: #fff;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 40px;
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
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        animation: verzender-float 8s ease-in-out infinite;
    }
    @keyframes verzender-float {
        0%, 100% { transform: translate(-50%, -50%) rotate(0deg); }
        50% { transform: translate(-50%, -50%) rotate(180deg); }
    }
    .verzender-hero h2 {
        margin: 0;
        font-size: 36px;
        font-weight: 800;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    .verzender-hero p {
        margin: 16px 0 0;
        opacity: 0.9;
        font-size: 20px;
        position: relative;
        z-index: 1;
        font-weight: 400;
    }
    .verzender-stats-card {
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
    .verzender-stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #2563eb, #1d4ed8);
    }
    .verzender-stats-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 64px rgba(0,0,0,0.15);
    }
    .verzender-stats-card.total { border-left-color: #2563eb; }
    .verzender-stats-card.pending { border-left-color: #f59e0b; }
    .verzender-stats-card.delivered { border-left-color: #10b981; }
    .verzender-stats-card i {
        font-size: 40px;
        margin-bottom: 16px;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .verzender-stats-card h3 {
        margin: 0;
        font-size: 42px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 12px;
    }
    .verzender-stats-card p {
        margin: 0;
        color: #64748b;
        font-size: 18px;
        font-weight: 600;
    }
    .mini-chart {
        width: 100%;
        height: 60px;
        margin-top: 16px;
        background: linear-gradient(90deg, rgba(37,99,235,0.1), rgba(29,78,216,0.1));
        border-radius: 8px;
        position: relative;
        overflow: hidden;
    }
    .mini-chart::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background: linear-gradient(90deg, #2563eb, #1d4ed8);
        border-radius: 8px;
        animation: chart-fill 2s ease-out;
    }
    @keyframes chart-fill {
        0% { width: 0%; }
        100% { width: 75%; }
    }
    .verzender-section {
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
    .verzender-action-btn {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        padding: 16px 32px;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(37,99,235,0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 600;
        font-size: 18px;
        border: none;
        cursor: pointer;
    }
    .verzender-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(37,99,235,0.4);
        text-decoration: none;
        color: #fff;
    }
    .verzender-action-btn i {
        margin-right: 8px;
        font-size: 18px;
    }
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
    @media (max-width: 768px) {
        .verzender-hero {
            padding: 24px;
            margin-bottom: 24px;
        }
        .verzender-hero h2 {
            font-size: 28px;
        }
        .verzender-hero p {
            font-size: 16px;
        }
        .verzender-stats-card {
            padding: 24px;
        }
        .verzender-stats-card h3 {
            font-size: 32px;
        }
        .verzender-section {
            padding: 20px;
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

<div class="card" style="margin:0 auto;" id="verzender-page">
    <!-- Enhanced Verzender Hero Section -->
    <div class="verzender-hero">
        <h2><i class="fas fa-paper-plane"></i> Welkom terug, {{ auth()->user()->name }}!</h2>
        <p>Beheer uw verzendingen eenvoudig en efficiënt als verzender.</p>
    </div>

    <!-- Enhanced Stats Cards with Mini Charts -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px;">
        <div class="verzender-stats-card total">
            <i class="fas fa-box"></i>
            <h3>{{ $totalPackages }}</h3>
            <p>Totaal Verzendingen</p>
            <div class="mini-chart"></div>
        </div>
        <div class="verzender-stats-card pending">
            <i class="fas fa-clock"></i>
            <h3>{{ $pendingPackages }}</h3>
            <p>In Behandeling</p>
            <div class="mini-chart"></div>
        </div>
        <div class="verzender-stats-card delivered">
            <i class="fas fa-check-circle"></i>
            <h3>{{ $deliveredPackages }}</h3>
            <p>Bezorgd</p>
            <div class="mini-chart"></div>
        </div>
    </div>

    <!-- Enhanced Verzender Actions Section -->
    <div class="verzender-section">
        <h4 style="margin-bottom: 24px; font-size: 24px; font-weight: 700; color: #1e293b;">
            <i class="fas fa-tasks" style="margin-right: 12px; color: #2563eb;"></i>Verzender Acties
        </h4>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px;">
            <a href="{{ route('nieuwe-verzending') }}" class="verzender-action-btn">
                <i class="fas fa-plus-circle"></i> Nieuwe Verzending Aanmaken
            </a>
            <a href="{{ route('mijn-verzendingen') }}" class="verzender-action-btn">
                <i class="fas fa-list"></i> Mijn Verzendingen Bekijken
            </a>
            <a href="{{ route('pakketten-volgen') }}" class="verzender-action-btn">
                <i class="fas fa-search"></i> Pakketten Volgen
            </a>
        </div>
    </div>
</div>
@endsection
