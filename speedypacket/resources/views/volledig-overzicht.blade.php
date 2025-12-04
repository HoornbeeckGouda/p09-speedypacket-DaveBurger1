@extends('layouts.app')

@section('title', 'Volledig Overzicht')

@section('content')
<style>
    .overview-hero {
        background: linear-gradient(135deg, #1e293b, #334155, #475569);
        color: #fff;
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
    }
    .overview-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        animation: overview-float 8s ease-in-out infinite;
    }
    @keyframes overview-float {
        0%, 100% { transform: translate(-50%, -50%) rotate(0deg); }
        50% { transform: translate(-50%, -50%) rotate(180deg); }
    }
    .overview-hero h2 {
        margin: 0;
        font-size: 36px;
        font-weight: 800;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    .overview-hero p {
        margin: 16px 0 0;
        opacity: 0.9;
        font-size: 20px;
        position: relative;
        z-index: 1;
        font-weight: 400;
    }
    .overview-stats-card {
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
    .overview-stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #1e293b, #334155);
    }
    .overview-stats-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 64px rgba(0,0,0,0.15);
    }
    .overview-stats-card.all { border-left-color: #1e293b; }
    .overview-stats-card.delivered { border-left-color: #059669; }
    .overview-stats-card.billed { border-left-color: #d97706; }
    .overview-stats-card i {
        font-size: 40px;
        margin-bottom: 16px;
        background: linear-gradient(135deg, #1e293b, #334155);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .overview-stats-card h3 {
        margin: 0;
        font-size: 42px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 12px;
    }
    .overview-stats-card p {
        margin: 0;
        color: #64748b;
        font-size: 18px;
        font-weight: 600;
    }
    .mini-chart {
        width: 100%;
        height: 60px;
        margin-top: 16px;
        background: linear-gradient(90deg, rgba(30,41,59,0.1), rgba(51,65,85,0.1));
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
        background: linear-gradient(90deg, #1e293b, #334155);
        border-radius: 8px;
        animation: chart-fill 2s ease-out;
    }
    @keyframes chart-fill {
        0% { width: 0%; }
        100% { width: 75%; }
    }
    .overview-tabs {
        display: flex;
        gap: 4px;
        margin-bottom: 32px;
        border-bottom: 2px solid #e2e8f0;
        background: #f8fafc;
        padding: 8px;
        border-radius: 16px 16px 0 0;
    }
    .overview-tab-button {
        padding: 16px 32px;
        border: none;
        border-radius: 12px;
        background: transparent;
        color: #64748b;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        flex: 1;
    }
    .overview-tab-button.active {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: white;
        box-shadow: 0 4px 16px rgba(30,41,59,0.3);
        transform: translateY(-2px);
    }
    .overview-tab-button:hover:not(.active) {
        background: rgba(30,41,59,0.1);
        color: #1e293b;
    }
    .overview-tab-content {
        background: #fff;
        border-radius: 0 0 20px 20px;
        padding: 32px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.08);
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
    .overview-table {
        width: 100%;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }
    .overview-table table {
        width: 100%;
        border-collapse: collapse;
    }
    .overview-table thead {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        display: table-header-group;
    }
    .overview-table tbody {
        display: table-row-group;
    }
    .overview-table tr {
        display: table-row;
    }
    .overview-table th, .overview-table td {
        display: table-cell;
        vertical-align: middle;
    }
    .overview-table th {
        padding: 20px;
        font-weight: 700;
        color: #374151;
        font-size: 16px;
        text-align: left;
        border-bottom: 2px solid #e2e8f0;
    }
    .overview-table td {
        padding: 20px;
        color: #374151;
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.2s ease;
    }
    .overview-table tr:hover td {
        background: rgba(30,41,59,0.02);
    }
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-pending { background: #fef3c7; color: #d97706; }
    .status-in_transit { background: #dbeafe; color: #2563eb; }
    .status-delivered { background: #d1fae5; color: #065f46; }
    .status-in_warehouse { background: #e0e7ff; color: #3730a3; }
    .status-billed { background: #fef3c7; color: #d97706; }
    .status-paid { background: #d1fae5; color: #065f46; }
    .overview-action-btn {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        padding: 12px 24px;
        background: linear-gradient(135deg, #1e293b, #334155);
        color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(30,41,59,0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 600;
        font-size: 16px;
    }
    .overview-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(30,41,59,0.4);
        text-decoration: none;
        color: #fff;
    }
    .overview-action-btn i {
        margin-right: 8px;
        font-size: 18px;
    }
</style>

<!-- Overview Hero Section -->
<div class="overview-hero">
    <h2><i class="fas fa-chart-line"></i> Volledig Overzicht</h2>
    <p>Compleet overzicht van alle pakketten in het systeem</p>
</div>

<!-- Overview Dashboard Container -->
<div style="background: linear-gradient(135deg, #f8fafc, #f1f5f9); border-radius: 24px; padding: 40px; box-shadow: 0 12px 48px rgba(0,0,0,0.08);">

    <!-- Enhanced Tab Navigation -->
    <div class="overview-tabs">
        <button id="all-tab" class="overview-tab-button active">
            <i class="fas fa-boxes" style="margin-right: 8px;"></i>Alle Pakketten
        </button>
        <button id="delivered-tab" class="overview-tab-button">
            <i class="fas fa-check-circle" style="margin-right: 8px;"></i>Bezorgd
        </button>
        <button id="billed-tab" class="overview-tab-button">
            <i class="fas fa-file-invoice-dollar" style="margin-right: 8px;"></i>Gefactureerd
        </button>
    </div>

    <!-- All Packages Tab Content -->
    <div id="all-content" class="overview-tab-content">
        <!-- Enhanced Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px;">
            <div class="overview-stats-card all">
                <i class="fas fa-boxes"></i>
                <h3>{{ $allPackages->count() }}</h3>
                <p>Totaal Pakketten</p>
                <div class="mini-chart"></div>
            </div>
            <div class="overview-stats-card delivered">
                <i class="fas fa-check-circle"></i>
                <h3>{{ $deliveredPackages->count() }}</h3>
                <p>Bezorgd</p>
                <div class="mini-chart"></div>
            </div>
            <div class="overview-stats-card billed">
                <i class="fas fa-file-invoice-dollar"></i>
                <h3>{{ $billedPackages->count() }}</h3>
                <p>Gefactureerd</p>
                <div class="mini-chart"></div>
            </div>
        </div>

        <!-- All Packages Table Section -->
        <section>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h4 style="margin: 0; font-size: 24px; font-weight: 700; color: #1e293b;">
                    <i class="fas fa-boxes" style="margin-right: 12px; color: #64748b;"></i>Alle Pakketten
                </h4>
            </div>
            <div class="overview-table">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag" style="margin-right: 8px;"></i>Tracking Nummer</th>
                            <th><i class="fas fa-user" style="margin-right: 8px;"></i>Ontvanger</th>
                            <th><i class="fas fa-info-circle" style="margin-right: 8px;"></i>Status</th>
                            <th><i class="fas fa-user-tie" style="margin-right: 8px;"></i>Verzender</th>
                            <th><i class="fas fa-truck" style="margin-right: 8px;"></i>Koerier</th>
                            <th><i class="fas fa-calendar" style="margin-right: 8px;"></i>Aangemaakt</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($allPackages as $p)
                        <tr>
                            <td><code style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-family: 'Courier New', monospace;">{{ $p->tracking_number }}</code></td>
                            <td>{{ $p->recipient_name }}</td>
                            <td>
                                <span class="status-badge
                                    @if($p->status == 'delivered') status-delivered
                                    @elseif($p->status == 'in_transit') status-in_transit
                                    @elseif($p->status == 'pending' || $p->status == 'in_warehouse') status-pending
                                    @elseif($p->status == 'billed') status-billed
                                    @else status-in_warehouse
                                    @endif">
                                    @if($p->status == 'in_warehouse') In Afwachting
                                    @else {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                                    @endif
                                </span>
                            </td>
                            <td>{{ $p->user->name ?? 'N/A' }}</td>
                            <td>{{ $p->koerier->name ?? 'N/A' }}</td>
                            <td>{{ $p->created_at ? $p->created_at->format('d-m-Y') : 'N/A' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- Delivered Packages Tab Content -->
    <div id="delivered-content" class="overview-tab-content" style="display: none;">
        <section>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h4 style="margin: 0; font-size: 24px; font-weight: 700; color: #1e293b;">
                    <i class="fas fa-check-circle" style="margin-right: 12px; color: #16a34a;"></i>Bezorgde Pakketten
                </h4>
            </div>
            <div class="overview-table">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag" style="margin-right: 8px;"></i>Tracking Nummer</th>
                            <th><i class="fas fa-user" style="margin-right: 8px;"></i>Ontvanger</th>
                            <th><i class="fas fa-weight-hanging" style="margin-right: 8px;"></i>Gewicht</th>
                            <th><i class="fas fa-calendar-check" style="margin-right: 8px;"></i>Bezorgd Op</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($deliveredPackages as $p)
                        <tr>
                            <td><code style="background: #f0fdf4; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-family: 'Courier New', monospace; color: #065f46;">{{ $p->tracking_number }}</code></td>
                            <td>{{ $p->recipient_name }}</td>
                            <td>{{ $p->weight ? $p->weight . ' kg' : 'N/A' }}</td>
                            <td>{{ $p->updated_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- Billed Packages Tab Content -->
    <div id="billed-content" class="overview-tab-content" style="display: none;">
        <section>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h4 style="margin: 0; font-size: 24px; font-weight: 700; color: #1e293b;">
                    <i class="fas fa-file-invoice-dollar" style="margin-right: 12px; color: #d97706;"></i>Gefactureerde Pakketten
                </h4>
            </div>
            <div class="overview-table">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag" style="margin-right: 8px;"></i>Tracking Nummer</th>
                            <th><i class="fas fa-user" style="margin-right: 8px;"></i>Ontvanger</th>
                            <th><i class="fas fa-weight-hanging" style="margin-right: 8px;"></i>Gewicht</th>
                            <th><i class="fas fa-calendar-check" style="margin-right: 8px;"></i>Gefactureerd Op</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($billedPackages as $p)
                        <tr>
                            <td><code style="background: #fef3c7; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-family: 'Courier New', monospace; color: #92400e;">{{ $p->tracking_number }}</code></td>
                            <td>{{ $p->recipient_name }}</td>
                            <td>{{ $p->weight ? $p->weight . ' kg' : 'N/A' }}</td>
                            <td>{{ $p->updated_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const allTab = document.getElementById('all-tab');
        const deliveredTab = document.getElementById('delivered-tab');
        const billedTab = document.getElementById('billed-tab');
        const allContent = document.getElementById('all-content');
        const deliveredContent = document.getElementById('delivered-content');
        const billedContent = document.getElementById('billed-content');

        function switchTab(activeTab, inactiveTab1, inactiveTab2, activeContent, inactiveContent1, inactiveContent2) {
            activeTab.classList.add('active');
            inactiveTab1.classList.remove('active');
            inactiveTab2.classList.remove('active');

            activeContent.style.opacity = '0';
            activeContent.style.display = 'block';

            setTimeout(() => {
                activeContent.style.opacity = '1';
                inactiveContent1.style.display = 'none';
                inactiveContent2.style.display = 'none';
            }, 50);
        }

        allTab.addEventListener('click', function() {
            switchTab(allTab, deliveredTab, billedTab, allContent, deliveredContent, billedContent);
        });

        deliveredTab.addEventListener('click', function() {
            switchTab(deliveredTab, allTab, billedTab, deliveredContent, allContent, billedContent);
        });

        billedTab.addEventListener('click', function() {
            switchTab(billedTab, allTab, deliveredTab, billedContent, allContent, deliveredContent);
        });

        // Hover effects for stats cards
        document.querySelectorAll('.overview-stats-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
                this.style.boxShadow = '0 20px 64px rgba(0,0,0,0.15)';
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
        document.querySelectorAll('.overview-table tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.background = 'rgba(30,41,59,0.05)';
                this.style.transform = 'scale(1.01)';
                this.style.transition = 'all 0.2s ease';
            });
            row.addEventListener('mouseleave', function() {
                this.style.background = 'transparent';
                this.style.transform = 'scale(1)';
            });
        });
    });
</script>

@endsection
