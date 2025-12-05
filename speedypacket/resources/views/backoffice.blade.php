@extends('layouts.app')

@section('title', 'Backoffice Dashboard')

@section('content')
<style>
    .billing-hero {
        background: linear-gradient(135deg, #7c3aed, #6d28d9, #581c87);
        color: #fff;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
    }
    .billing-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        animation: billing-float 8s ease-in-out infinite;
    }
    @keyframes billing-float {
        0%, 100% { transform: translate(-50%, -50%) rotate(0deg); }
        50% { transform: translate(-50%, -50%) rotate(180deg); }
    }
    .billing-hero h2 {
        margin: 0;
        font-size: 36px;
        font-weight: 800;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    .billing-hero p {
        margin: 16px 0 0;
        opacity: 0.9;
        font-size: 20px;
        position: relative;
        z-index: 1;
        font-weight: 400;
    }
    .billing-stats-card {
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
    .billing-stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #7c3aed, #6d28d9);
    }
    .billing-stats-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 64px rgba(0,0,0,0.15);
    }
    .billing-stats-card.delivered { border-left-color: #7c3aed; }
    .billing-stats-card.billed { border-left-color: #d97706; }
    .billing-stats-card i {
        font-size: 40px;
        margin-bottom: 16px;
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .billing-stats-card h3 {
        margin: 0;
        font-size: 42px;
        font-weight: 800;
        color: #581c87;
        margin-bottom: 12px;
    }
    .billing-stats-card p {
        margin: 0;
        color: #64748b;
        font-size: 18px;
        font-weight: 600;
    }
    .mini-chart {
        width: 100%;
        height: 60px;
        margin-top: 16px;
        background: linear-gradient(90deg, rgba(124,58,237,0.1), rgba(109,40,217,0.1));
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
        background: linear-gradient(90deg, #7c3aed, #6d28d9);
        border-radius: 8px;
        animation: chart-fill 2s ease-out;
    }
    @keyframes chart-fill {
        0% { width: 0%; }
        100% { width: 75%; }
    }
    .billing-section {
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
    .billing-table {
        width: 100%;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .billing-table table {
        width: 100%;
        border-collapse: collapse;
    }
    .billing-table thead {
        background: linear-gradient(135deg, #f3e8ff, #e9d5ff);
        display: table-header-group;
    }
    .billing-table tbody {
        display: table-row-group;
    }
    .billing-table tr {
        display: table-row;
    }
    .billing-table th, .billing-table td {
        display: table-cell;
        vertical-align: middle;
    }
    .billing-table th {
        padding: 20px;
        font-weight: 700;
        color: #581c87;
        font-size: 16px;
        text-align: left;
        border-bottom: 2px solid #d8b4fe;
    }
    .billing-table td {
        padding: 20px;
        color: #374151;
        border-bottom: 1px solid #f3e8ff;
        transition: background-color 0.2s ease;
    }
    .billing-table tr:hover td {
        background: rgba(124,58,237,0.02);
    }
    .billing-action-btn {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        padding: 12px 24px;
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(124,58,237,0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
    }
    .billing-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(124,58,237,0.4);
        text-decoration: none;
        color: #fff;
    }
    .billing-action-btn i {
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
    .status-delivered { background: #e9d5ff; color: #581c87; }
    .status-billed { background: #fef3c7; color: #d97706; }
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
        background: linear-gradient(135deg, #f3e8ff, #e9d5ff);
        color: #6b21a8;
        border-color: #d8b4fe;
    }
    .alert-success::before { background: #8b5cf6; }
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
        .billing-hero {
            padding: 24px;
            margin-bottom: 24px;
        }
        .billing-hero h2 {
            font-size: 28px;
        }
        .billing-hero p {
            font-size: 16px;
        }
        .billing-stats-card {
            padding: 24px;
        }
        .billing-stats-card h3 {
            font-size: 32px;
        }
        .billing-section {
            padding: 20px;
        }
        .billing-table th,
        .billing-table td {
            padding: 12px 8px;
            font-size: 14px;
        }
    }
</style>

<!-- Billing Hero Section -->
<div class="billing-hero">
    <h2><i class="fas fa-calculator"></i> Backoffice Dashboard</h2>
    <p>Beheer facturering en financiële administratie van pakketten</p>
</div>

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

<!-- Billing Dashboard Container -->
<div style="background: linear-gradient(135deg, #f0fdf4, #dcfce7); border-radius: 24px; padding: 40px; box-shadow: 0 12px 48px rgba(0,0,0,0.08);">

    <!-- Enhanced Stats Cards with Mini Charts -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px;">
        <div class="billing-stats-card delivered">
            <i class="fas fa-check-circle"></i>
            <h3>{{ $deliveredPackages->count() }}</h3>
            <p>Bezorgd & Klaar voor Facturering</p>
            <div class="mini-chart"></div>
        </div>
        <div class="billing-stats-card billed">
            <i class="fas fa-file-invoice-dollar"></i>
            <h3>{{ $billedPackages->count() }}</h3>
            <p>Gefactureerd</p>
            <div class="mini-chart"></div>
        </div>
    </div>

    <!-- Delivered Packages Section -->
    <div class="billing-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h4 style="margin: 0; font-size: 24px; font-weight: 700; color: #065f46;">
                <i class="fas fa-check-circle" style="margin-right: 12px; color: #16a34a;"></i>Bezorgde Pakketten (Klaar voor Facturering)
            </h4>
        </div>

        @if($deliveredPackages->count() > 0)
            <div class="billing-table">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag" style="margin-right: 8px;"></i>Tracking Nummer</th>
                            <th><i class="fas fa-user" style="margin-right: 8px;"></i>Ontvanger</th>
                            <th><i class="fas fa-weight-hanging" style="margin-right: 8px;"></i>Gewicht</th>
                            <th><i class="fas fa-calendar-check" style="margin-right: 8px;"></i>Bezorgd Op</th>
                            <th><i class="fas fa-cogs" style="margin-right: 8px;"></i>Actie</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($deliveredPackages as $package)
                        <tr>
                            <td>
                                <code style="background: #f0fdf4; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-family: 'Courier New', monospace; color: #065f46;">
                                    {{ $package->tracking_number }}
                                </code>
                            </td>
                            <td>{{ $package->recipient_name }}</td>
                            <td>{{ $package->weight ? $package->weight . ' kg' : 'N/A' }}</td>
                            <td>{{ $package->updated_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <form method="POST" action="{{ route('backoffice.bill', $package->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="billing-action-btn">
                                        <i class="fas fa-file-invoice-dollar"></i>Factureren
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: #64748b;">
                <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                <p style="font-size: 18px; margin: 0;">Geen bezorgde pakketten om te factureren.</p>
            </div>
        @endif
    </div>

    <!-- Billed Packages Section -->
    <div class="billing-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h4 style="margin: 0; font-size: 24px; font-weight: 700; color: #065f46;">
                <i class="fas fa-file-invoice-dollar" style="margin-right: 12px; color: #d97706;"></i>Gefactureerde Pakketten
            </h4>
        </div>

        @if($billedPackages->count() > 0)
            <div class="billing-table">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag" style="margin-right: 8px;"></i>Tracking Nummer</th>
                            <th><i class="fas fa-user" style="margin-right: 8px;"></i>Ontvanger</th>
                            <th><i class="fas fa-weight-hanging" style="margin-right: 8px;"></i>Gewicht</th>
                            <th><i class="fas fa-calendar-check" style="margin-right: 8px;"></i>Gefactureerd Op</th>
                            <th><i class="fas fa-info-circle" style="margin-right: 8px;"></i>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($billedPackages as $package)
                        <tr>
                            <td>
                                <code style="background: #fef3c7; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-family: 'Courier New', monospace; color: #92400e;">
                                    {{ $package->tracking_number }}
                                </code>
                            </td>
                            <td>{{ $package->recipient_name }}</td>
                            <td>{{ $package->weight ? $package->weight . ' kg' : 'N/A' }}</td>
                            <td>{{ $package->updated_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <span class="status-badge status-billed">
                                    Gefactureerd
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: #64748b;">
                <i class="fas fa-file-invoice" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                <p style="font-size: 18px; margin: 0;">Geen gefactureerde pakketten.</p>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced hover effects for billing stats cards
        document.querySelectorAll('.billing-stats-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
                this.style.boxShadow = '0 20px 64px rgba(5,150,105,0.15)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = '0 8px 32px rgba(0,0,0,0.08)';
            });
        });

        // Mini chart animations
        document.querySelectorAll('.mini-chart').forEach(chart => {
            chart.addEventListener('mouseenter', function() {
                this.style.transform = 'scaleY(1.2)';
                this.style.transition = 'transform 0.3s ease';
            });
            chart.addEventListener('mouseleave', function() {
                this.style.transform = 'scaleY(1)';
            });
        });

        // Table row hover effects
        document.querySelectorAll('.billing-table tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.background = 'rgba(5,150,105,0.05)';
                this.style.transform = 'scale(1.01)';
                this.style.transition = 'all 0.2s ease';
            });
            row.addEventListener('mouseleave', function() {
                this.style.background = 'transparent';
                this.style.transform = 'scale(1)';
            });
        });

        // Enhanced action button effects
        document.querySelectorAll('.billing-action-btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px) scale(1.05)';
                this.style.boxShadow = '0 8px 24px rgba(5,150,105,0.4)';
            });
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = '0 4px 16px rgba(5,150,105,0.3)';
            });
        });

        // Add loading animation to sections
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
            @keyframes slideIn { from { transform: translateX(-100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        `;
        document.head.appendChild(style);

        // Trigger mini chart animations after page load
        setTimeout(() => {
            document.querySelectorAll('.mini-chart').forEach(chart => {
                chart.classList.add('animate');
            });
        }, 100);
    });
</script>
@endsection
