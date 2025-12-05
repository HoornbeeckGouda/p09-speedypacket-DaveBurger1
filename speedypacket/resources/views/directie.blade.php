@extends('layouts.app')

@section('title', 'Directie Home')

@section('content')
<style>
        .management-hero {
            background: linear-gradient(135deg, #dc2626, #b91c1c, #991b1b);
            color: #fff;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }
        .management-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            animation: management-float 8s ease-in-out infinite;
        }
        @keyframes management-float {
            0%, 100% { transform: translate(-50%, -50%) rotate(0deg); }
            50% { transform: translate(-50%, -50%) rotate(180deg); }
        }
        .management-hero h2 {
            margin: 0;
            font-size: 36px;
            font-weight: 800;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        .management-hero p {
            margin: 16px 0 0;
            opacity: 0.9;
            font-size: 20px;
            position: relative;
            z-index: 1;
            font-weight: 400;
        }
        .management-stats-card {
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
        .management-stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #dc2626, #b91c1c);
        }
        .management-stats-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 64px rgba(0,0,0,0.15);
        }
        .management-stats-card.users { border-left-color: #1e293b; }
        .management-stats-card.packages { border-left-color: #059669; }
        .management-stats-card.revenue { border-left-color: #d97706; }
        .management-stats-card.efficiency { border-left-color: #7c3aed; }
        .management-stats-card i {
            font-size: 40px;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #1e293b, #334155);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .management-stats-card h3 {
            margin: 0;
            font-size: 42px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 12px;
        }
        .management-stats-card p {
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
        .management-tabs {
            display: flex;
            gap: 4px;
            margin-bottom: 32px;
            border-bottom: 2px solid #e2e8f0;
            background: #f8fafc;
            padding: 8px;
            border-radius: 16px 16px 0 0;
        }
        .management-tab-button {
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
        .management-tab-button.active {
            background: linear-gradient(135deg, #1e293b, #334155);
            color: white;
            box-shadow: 0 4px 16px rgba(30,41,59,0.3);
            transform: translateY(-2px);
        }
        .management-tab-button:hover:not(.active) {
            background: rgba(30,41,59,0.1);
            color: #1e293b;
        }
        .management-tab-content {
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
        .management-table {
            width: 100%;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        }
        .management-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .management-table thead {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            display: table-header-group;
        }
        .management-table tbody {
            display: table-row-group;
        }
        .management-table tr {
            display: table-row;
        }
        .management-table th, .management-table td {
            display: table-cell;
            vertical-align: middle;
        }
        .management-table th {
            padding: 20px;
            font-weight: 700;
            color: #374151;
            font-size: 16px;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
        }
        .management-table td {
            padding: 20px;
            color: #374151;
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s ease;
        }
        .management-table tr:hover td {
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
        .management-action-btn {
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
        .management-action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(30,41,59,0.4);
            text-decoration: none;
            color: #fff;
        }
        .management-action-btn i {
            margin-right: 8px;
            font-size: 18px;
        }
    </style>

    <!-- Management Hero Section -->
    <div class="management-hero" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2><i class="fas fa-crown"></i> Directie Dashboard</h2>
            <p>Overzicht van systeemprestaties en management inzichten</p>
        </div>
    </div>

    <!-- Management Dashboard Container -->
    <div style="background: linear-gradient(135deg, #f8fafc, #f1f5f9); border-radius: 24px; padding: 40px; box-shadow: 0 12px 48px rgba(0,0,0,0.08);">

        <!-- Enhanced Tab Navigation -->
        <div class="management-tabs">
            <button id="users-tab" class="management-tab-button active">
                <i class="fas fa-users" style="margin-right: 8px;"></i>Gebruikers
            </button>
            <button id="packages-tab" class="management-tab-button">
                <i class="fas fa-box" style="margin-right: 8px;"></i>Pakketten
            </button>
        </div>

        <!-- Users Tab Content -->
        <div id="users-content" class="management-tab-content">
            <!-- Enhanced Stats Cards with Mini Charts -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px;">
                <div class="management-stats-card users">
                    <i class="fas fa-users"></i>
                    <h3>{{ $totalUsers }}</h3>
                    <p>Totaal Gebruikers</p>
                    <div class="mini-chart"></div>
                </div>
                <div class="management-stats-card users">
                    <i class="fas fa-crown"></i>
                    <h3>{{ $directieCount }}</h3>
                    <p>Directie Accounts</p>
                    <div class="mini-chart"></div>
                </div>
                <div class="management-stats-card users">
                    <i class="fas fa-user-friends"></i>
                    <h3>{{ $otherCount }}</h3>
                    <p>Overige Accounts</p>
                    <div class="mini-chart"></div>
                </div>
            </div>

            <!-- Enhanced Users Table Section -->
            <section>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h4 style="margin: 0; font-size: 24px; font-weight: 700; color: #1e293b;">
                        <i class="fas fa-clock" style="margin-right: 12px; color: #64748b;"></i>Recente Gebruikers
                    </h4>
                    <a href="{{ route('directie.users') }}" class="management-action-btn">
                        <i class="fas fa-cog"></i>Alle Gebruikers Beheren
                    </a>
                </div>
                <div class="management-table">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-user" style="margin-right: 8px;"></i>Naam</th>
                                <th><i class="fas fa-at" style="margin-right: 8px;"></i>Gebruikersnaam</th>
                                <th><i class="fas fa-shield-alt" style="margin-right: 8px;"></i>Rol</th>
                                <th><i class="fas fa-calendar" style="margin-right: 8px;"></i>Aangemaakt</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($recentUsers as $u)
                            <tr>
                                <td>{{ $u->name }}</td>
                                <td><code style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-size: 14px;">{{ $u->username }}</code></td>
                                <td>
                                    <span class="status-badge
                                        @if($u->role == 'directie') status-delivered
                                        @elseif($u->role == 'koerier') status-in_transit
                                        @elseif($u->role == 'verzender') status-pending
                                        @else status-in_warehouse
                                        @endif">
                                        {{ ucfirst($u->role) }}
                                    </span>
                                </td>
                                <td>{{ $u->created_at ? $u->created_at->format('d-m-Y') : 'N/A' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <!-- Packages Tab Content -->
        <div id="packages-content" class="management-tab-content" style="display: none;">
            <!-- Enhanced Package Stats Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px;">
                <div class="management-stats-card packages">
                    <i class="fas fa-boxes"></i>
                    <h3>{{ $totalPackages }}</h3>
                    <p>Totaal Pakketten</p>
                    <div class="mini-chart"></div>
                </div>
                <div class="management-stats-card packages">
                    <i class="fas fa-clock"></i>
                    <h3>{{ $pendingPackages }}</h3>
                    <p>In Afwachting</p>
                    <div class="mini-chart"></div>
                </div>
                <div class="management-stats-card packages">
                    <i class="fas fa-truck"></i>
                    <h3>{{ $inTransitPackages }}</h3>
                    <p>Onderweg</p>
                    <div class="mini-chart"></div>
                </div>
                <div class="management-stats-card packages">
                    <i class="fas fa-check-circle"></i>
                    <h3>{{ $deliveredPackages }}</h3>
                    <p>Bezorgd</p>
                    <div class="mini-chart"></div>
                </div>
            </div>

            <!-- Enhanced Packages Table Section -->
            <section>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h4 style="margin: 0; font-size: 24px; font-weight: 700; color: #1e293b;">
                        <i class="fas fa-clock" style="margin-right: 12px; color: #64748b;"></i>Recente Pakketten
                    </h4>
                    <a href="{{ route('volledig-overzicht') }}" class="management-action-btn">
                        <i class="fas fa-chart-line"></i>Volledig Overzicht
                    </a>
                </div>
                <div class="management-table">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag" style="margin-right: 8px;"></i>Tracking Nummer</th>
                                <th><i class="fas fa-user" style="margin-right: 8px;"></i>Ontvanger</th>
                                <th><i class="fas fa-info-circle" style="margin-right: 8px;"></i>Status</th>
                                <th><i class="fas fa-user-tie" style="margin-right: 8px;"></i>Verzender</th>
                                <th><i class="fas fa-calendar" style="margin-right: 8px;"></i>Aangemaakt</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($recentPackages as $p)
                            <tr>
                                <td><code style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-family: 'Courier New', monospace;">{{ $p->tracking_number }}</code></td>
                                <td>{{ $p->recipient_name }}</td>
                                <td>
                                    <span class="status-badge
                                        @if($p->status == 'delivered') status-delivered
                                        @elseif($p->status == 'in_transit') status-in_transit
                                        @elseif($p->status == 'pending' || $p->status == 'in_warehouse') status-pending
                                        @else status-in_warehouse
                                        @endif">
                                        @if($p->status == 'in_warehouse') In Afwachting
                                        @else {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                                        @endif
                                    </span>
                                </td>
                                <td>{{ $p->user->name ?? 'N/A' }}</td>
                                <td>{{ $p->created_at ? $p->created_at->format('d-m-Y') : 'N/A' }}</td>
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
            const usersTab = document.getElementById('users-tab');
            const packagesTab = document.getElementById('packages-tab');
            const usersContent = document.getElementById('users-content');
            const packagesContent = document.getElementById('packages-content');

            // Enhanced tab switching with smooth animations
            function switchTab(activeTab, inactiveTab, activeContent, inactiveContent) {
                activeTab.classList.add('active');
                inactiveTab.classList.remove('active');

                // Add fade effect
                activeContent.style.opacity = '0';
                activeContent.style.display = 'block';

                setTimeout(() => {
                    activeContent.style.opacity = '1';
                    inactiveContent.style.display = 'none';
                }, 50);
            }

            usersTab.addEventListener('click', function() {
                switchTab(usersTab, packagesTab, usersContent, packagesContent);
            });

            packagesTab.addEventListener('click', function() {
                switchTab(packagesTab, usersTab, packagesContent, usersContent);
            });

            // Enhanced hover effects for management stats cards
            document.querySelectorAll('.management-stats-card').forEach(card => {
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
            document.querySelectorAll('.management-table tr').forEach(row => {
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

            // Enhanced action button effects
            document.querySelectorAll('.management-action-btn').forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px) scale(1.05)';
                    this.style.boxShadow = '0 8px 24px rgba(30,41,59,0.4)';
                });
                btn.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                    this.style.boxShadow = '0 4px 16px rgba(30,41,59,0.3)';
                });
            });

            // Function to show user info with enhanced modal
            window.showUserInfo = function(button) {
                const id = button.getAttribute('data-user-id');
                const name = button.getAttribute('data-user-name');
                const username = button.getAttribute('data-user-username');
                const email = button.getAttribute('data-user-email');
                const role = button.getAttribute('data-user-role');

                // Create enhanced modal
                const modal = document.createElement('div');
                modal.style.cssText = `
                    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                    background: rgba(0,0,0,0.5); display: flex; align-items: center;
                    justify-content: center; z-index: 1000; animation: fadeIn 0.3s ease;
                `;
                modal.innerHTML = `
                    <div style="
                        background: white; padding: 32px; border-radius: 20px;
                        box-shadow: 0 20px 64px rgba(0,0,0,0.3); max-width: 400px;
                        width: 90%; animation: slideIn 0.3s ease; position: relative;
                    ">
                        <button onclick="this.parentElement.parentElement.remove()"
                                style="
                                    position: absolute; top: 16px; right: 16px;
                                    background: none; border: none; font-size: 24px;
                                    cursor: pointer; color: #64748b;
                                ">&times;</button>
                        <h3 style="margin: 0 0 24px; color: #1e293b; font-size: 24px;">
                            <i class="fas fa-user" style="margin-right: 12px;"></i>Gebruiker Informatie
                        </h3>
                        <div style="display: grid; gap: 16px;">
                            <div><strong>ID:</strong> ${id}</div>
                            <div><strong>Naam:</strong> ${name}</div>
                            <div><strong>Gebruikersnaam:</strong> ${username}</div>
                            <div><strong>Email:</strong> ${email}</div>
                            <div><strong>Rol:</strong> ${role}</div>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);

                // Close modal on background click
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) modal.remove();
                });
            };

            // Add loading animation to tab content
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
                @keyframes slideIn { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
            `;
            document.head.appendChild(style);
        });
    </script>


@endsection
