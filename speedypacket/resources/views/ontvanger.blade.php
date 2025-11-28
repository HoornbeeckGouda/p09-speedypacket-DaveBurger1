@extends('layouts.app')

@section('title', 'Ontvanger Dashboard')

@section('content')
    <div class="card" style="max-width:1200px;margin:0 auto;">
        <h2 style="margin-top:0"><i class="fas fa-inbox"></i> Ontvanger Dashboard</h2>
        <p style="color:var(--muted)">Welkom terug, {{ auth()->user()->name }}. Hier kunt u uw ontvangen pakketten beheren.</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 18px; margin-bottom: 24px;">
            <div style="background: #fff; border: 1px solid #eef2ff; border-radius: 12px; padding: 18px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <i class="fas fa-clock" style="font-size: 24px; color: #f59e0b; margin-bottom: 8px;"></i>
                <h3 style="margin: 0; font-size: 24px; color: #111;">{{ $pendingPackages }}</h3>
                <p style="margin: 4px 0 0; color: var(--muted); font-size: 14px;">In Behandeling</p>
            </div>
            <div style="background: #fff; border: 1px solid #eef2ff; border-radius: 12px; padding: 18px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <i class="fas fa-shipping-fast" style="font-size: 24px; color: var(--accent); margin-bottom: 8px;"></i>
                <h3 style="margin: 0; font-size: 24px; color: #111;">{{ $packagesInTransit }}</h3>
                <p style="margin: 4px 0 0; color: var(--muted); font-size: 14px;">Onderweg</p>
            </div>
            <div style="background: #fff; border: 1px solid #eef2ff; border-radius: 12px; padding: 18px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <i class="fas fa-check-circle" style="font-size: 24px; color: #10b981; margin-bottom: 8px;"></i>
                <h3 style="margin: 0; font-size: 24px; color: #111;">{{ $deliveredPackages }}</h3>
                <p style="margin: 4px 0 0; color: var(--muted); font-size: 14px;">Ontvangen</p>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 320px;gap:24px;">
            <div>
                <section style="margin-bottom: 24px;">
                    <h4><i class="fas fa-tasks"></i> Acties</h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 12px;">
                        <a href="#" class="btn secondary" style="display: flex; align-items: center; text-decoration: none; padding: 12px 16px;">
                            <i class="fas fa-list" style="margin-right: 8px;"></i> Bekijk Ontvangen Pakketten
                        </a>
                        <a href="#" class="btn secondary" style="display: flex; align-items: center; text-decoration: none; padding: 12px 16px;">
                            <i class="fas fa-check" style="margin-right: 8px;"></i> Bevestig Ontvangst
                        </a>
                        <a href="#" class="btn secondary" style="display: flex; align-items: center; text-decoration: none; padding: 12px 16px;">
                            <i class="fas fa-phone" style="margin-right: 8px;"></i> Contact Bezorgers
                        </a>
                        <a href="{{ route('profile') }}" class="btn secondary" style="display: flex; align-items: center; text-decoration: none; padding: 12px 16px;">
                            <i class="fas fa-user" style="margin-right: 8px;"></i> Bekijk Profiel
                        </a>
                    </div>
                </section>

                <section>
                    <h4><i class="fas fa-box"></i> Recente Ontvangen Pakketten</h4>
                    <table style="width:100%;border-collapse:collapse;margin-top:8px">
                        <thead style="text-align:left;color:var(--muted);font-size:13px">
                            <tr><th style="padding:8px;border-bottom:1px solid #eef2ff">Tracking Nummer</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Verzender</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Status</th></tr>
                        </thead>
                        <tbody>
                        @foreach($recentPackages as $package)
                            <tr>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->tracking_number }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->user->name }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ ucfirst($package->status) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </section>
            </div>

            <aside>
                <div style="background:#fff;border:1px solid #eef2ff;border-radius:12px;padding:18px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <strong><i class="fas fa-lightbulb"></i> Snelle Tips</strong>
                    <div style="margin-top:12px;color:var(--muted); font-size: 14px;">
                        <p>Bevestig ontvangst van pakketten om de status bij te werken.</p>
                        <p>Contacteer bezorgers voor vragen over leveringen.</p>
                    </div>
                </div>
                <div style="background:#fff;border:1px solid #eef2ff;border-radius:12px;padding:18px;margin-top:18px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <strong><i class="fas fa-bell"></i> Recente Activiteiten</strong>
                    <ul style="margin-top:12px;color:var(--muted); font-size: 14px; list-style: none; padding: 0;">
                        <li style="margin-bottom: 8px;"><i class="fas fa-circle" style="color: #10b981; font-size: 8px; margin-right: 8px;"></i> Pakket #1234 ontvangen</li>
                        <li style="margin-bottom: 8px;"><i class="fas fa-circle" style="color: #f59e0b; font-size: 8px; margin-right: 8px;"></i> Nieuwe levering onderweg</li>
                        <li><i class="fas fa-circle" style="color: var(--accent); font-size: 8px; margin-right: 8px;"></i> Ontvangst bevestigd</li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
@endsection
