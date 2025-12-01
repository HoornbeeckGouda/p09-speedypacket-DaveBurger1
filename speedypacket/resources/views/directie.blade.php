@extends('layouts.app')

@section('title', 'Directie Home')

@section('content')
    <div class="card" style="width:100%;max-width:none;margin:0;padding:24px;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.1)">
        <h2 style="margin-top:0;margin-bottom:8px;font-size:32px;font-weight:700">Directie — Overzicht</h2>
        <p style="color:var(--muted);margin-bottom:24px;font-size:16px">Hier vind je kernstatistieken en snelle links naar systeemonderdelen.</p>

        <!-- Tab Navigation -->
        <div style="display:flex;gap:8px;margin-bottom:24px;border-bottom:1px solid #e5e7eb">
            <button id="users-tab" class="tab-button active" style="padding:12px 24px;border:none;border-radius:8px 8px 0 0;background:#f3f4f6;color:#374151;font-weight:500;cursor:pointer;transition:all 0.2s">Gebruikers</button>
            <button id="packages-tab" class="tab-button" style="padding:12px 24px;border:none;border-radius:8px 8px 0 0;background:#fff;color:#6b7280;font-weight:500;cursor:pointer;transition:all 0.2s">Pakketten</button>
        </div>

        <!-- Users Tab Content -->
        <div id="users-content" class="tab-content">
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:32px">
                <div class="stat-card" style="background:#fff;padding:24px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);transition:transform 0.2s,box-shadow 0.2s">
                    <div style="font-size:28px;font-weight:700;color:#0b5fff">{{ $totalUsers }}</div>
                    <div style="color:var(--muted);margin-top:8px;font-size:14px">Totaal gebruikers</div>
                </div>
                <div class="stat-card" style="background:#fff;padding:24px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);transition:transform 0.2s,box-shadow 0.2s">
                    <div style="font-size:28px;font-weight:700;color:#0b5fff">{{ $directieCount }}</div>
                    <div style="color:var(--muted);margin-top:8px;font-size:14px">Directie accounts</div>
                </div>
                <div class="stat-card" style="background:#fff;padding:24px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);transition:transform 0.2s,box-shadow 0.2s">
                    <div style="font-size:28px;font-weight:700;color:#0b5fff">{{ $otherCount }}</div>
                    <div style="color:var(--muted);margin-top:8px;font-size:14px">Overige accounts</div>
                </div>
            </div>

            <section>
                <h4 style="margin-bottom:16px;font-size:20px;font-weight:600">Recente gebruikers</h4>
                <div style="background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.1)">
                    <table style="width:100%;border-collapse:collapse">
                        <thead style="background:#f9fafb;text-align:left">
                            <tr>
                                <th style="padding:16px;font-weight:600;color:#374151;font-size:14px">Naam</th>
                                <th style="padding:16px;font-weight:600;color:#374151;font-size:14px">Gebruikersnaam</th>
                                <th style="padding:16px;font-weight:600;color:#374151;font-size:14px">Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($recentUsers as $u)
                            <tr style="border-top:1px solid #f3f4f6">
                                <td style="padding:16px;color:#111827">{{ $u->name }}</td>
                                <td style="padding:16px;color:#111827">{{ $u->username }}</td>
                                <td style="padding:16px;color:#111827">{{ $u->role }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <!-- Packages Tab Content -->
        <div id="packages-content" class="tab-content" style="display:none">
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:32px">
                <div class="stat-card" style="background:#fff;padding:24px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);transition:transform 0.2s,box-shadow 0.2s">
                    <div style="font-size:28px;font-weight:700;color:#0b5fff">{{ $totalPackages }}</div>
                    <div style="color:var(--muted);margin-top:8px;font-size:14px">Totaal pakketten</div>
                </div>
                <div class="stat-card" style="background:#fff;padding:24px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);transition:transform 0.2s,box-shadow 0.2s">
                    <div style="font-size:28px;font-weight:700;color:#f59e0b">{{ $pendingPackages }}</div>
                    <div style="color:var(--muted);margin-top:8px;font-size:14px">In afwachting</div>
                </div>
                <div class="stat-card" style="background:#fff;padding:24px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);transition:transform 0.2s,box-shadow 0.2s">
                    <div style="font-size:28px;font-weight:700;color:#3b82f6">{{ $inTransitPackages }}</div>
                    <div style="color:var(--muted);margin-top:8px;font-size:14px">Onderweg</div>
                </div>
                <div class="stat-card" style="background:#fff;padding:24px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);transition:transform 0.2s,box-shadow 0.2s">
                    <div style="font-size:28px;font-weight:700;color:#10b981">{{ $deliveredPackages }}</div>
                    <div style="color:var(--muted);margin-top:8px;font-size:14px">Bezorgd</div>
                </div>
            </div>

            <section>
                <h4 style="margin-bottom:16px;font-size:20px;font-weight:600">Recente pakketten</h4>
                <div style="background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.1)">
                    <table style="width:100%;border-collapse:collapse">
                        <thead style="background:#f9fafb;text-align:left">
                            <tr>
                                <th style="padding:16px;font-weight:600;color:#374151;font-size:14px">Tracking Nummer</th>
                                <th style="padding:16px;font-weight:600;color:#374151;font-size:14px">Ontvanger</th>
                                <th style="padding:16px;font-weight:600;color:#374151;font-size:14px">Status</th>
                                <th style="padding:16px;font-weight:600;color:#374151;font-size:14px">Verzender</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($recentPackages as $p)
                            <tr style="border-top:1px solid #f3f4f6">
                                <td style="padding:16px;color:#111827;font-family:monospace">{{ $p->tracking_number }}</td>
                                <td style="padding:16px;color:#111827">{{ $p->recipient_name }}</td>
                                <td style="padding:16px">
                                    <span style="padding:4px 8px;border-radius:6px;font-size:12px;font-weight:500;
                                        @if($p->status == 'pending') background:#fef3c7;color:#d97706;
                                        @elseif($p->status == 'in_transit') background:#dbeafe;color:#2563eb;
                                        @elseif($p->status == 'delivered') background:#d1fae5;color:#065f46;
                                        @elseif($p->status == 'in_warehouse') background:#e0e7ff;color:#3730a3;
                                        @endif">
                                        @if($p->status == 'in_warehouse') In afwachting
                                        @else {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                                        @endif
                                    </span>
                                </td>
                                <td style="padding:16px;color:#111827">{{ $p->user->name ?? 'N/A' }}</td>
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

            usersTab.addEventListener('click', function() {
                usersTab.classList.add('active');
                packagesTab.classList.remove('active');
                usersContent.style.display = 'block';
                packagesContent.style.display = 'none';
            });

            packagesTab.addEventListener('click', function() {
                packagesTab.classList.add('active');
                usersTab.classList.remove('active');
                packagesContent.style.display = 'block';
                usersContent.style.display = 'none';
            });

            // Add hover effects to stat cards
            document.querySelectorAll('.stat-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 4px 16px rgba(0,0,0,0.15)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
                });
            });
        });
    </script>

    <style>
        .tab-button.active {
            background: #0b5fff !important;
            color: white !important;
        }
        .tab-button:hover:not(.active) {
            background: #f3f4f6 !important;
        }
    </style>
@endsection
