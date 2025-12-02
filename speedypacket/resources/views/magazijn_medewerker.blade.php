@extends('layouts.app')

@section('title', 'Magazijn Medewerker Dashboard')

@section('content')
    <style>
        .even-row { background-color: #f9fafb; }
        .odd-row { background-color: #ffffff; }
        .even-row:hover, .odd-row:hover { background-color: #f3f4f6; }
        @media (max-width: 768px) {
            .grid-container { grid-template-columns: 1fr !important; }
        }
        .dashboard-icon {
            font-size: 1.5em;
            color: var(--accent);
            margin-right: 10px;
            background: rgba(11, 95, 255, 0.1);
            padding: 8px;
            border-radius: 50%;
            display: inline-block;
        }
    </style>
    <div class="card" style="max-width:1200px;margin:0 auto;">
        <h2 style="margin-top:0"><i class="fas fa-warehouse dashboard-icon"></i> Magazijn Medewerker Dashboard</h2>
        <p style="color:var(--muted)">Welkom terug, {{ auth()->user()->name }}. Hier ziet u de status van pakketten in het magazijn.</p>

        <!-- Stats Overview -->
        <div style="display:flex;gap:24px;margin-bottom:32px;flex-wrap:wrap;">
            <div style="flex:1;min-width:200px;padding:20px;border:1px solid #e6eef8;border-radius:12px;text-align:center;background:#fbfdff;">
                <i class="fas fa-box" style="font-size:24px;color:var(--accent);margin-bottom:8px;"></i>
                <div style="font-size:28px;font-weight:600;color:#111;">{{ $packagesInStorage->count() }}</div>
                <div style="color:var(--muted);font-size:14px;">In Magazijn</div>
            </div>
            <div style="flex:1;min-width:200px;padding:20px;border:1px solid #e6eef8;border-radius:12px;text-align:center;background:#fbfdff;">
                <i class="fas fa-truck" style="font-size:24px;color:#f59e0b;margin-bottom:8px;"></i>
                <div style="font-size:28px;font-weight:600;color:#111;">{{ $packagesInTransit->count() }}</div>
                <div style="color:var(--muted);font-size:14px;">In Transit</div>
            </div>
            <div style="flex:1;min-width:200px;padding:20px;border:1px solid #e6eef8;border-radius:12px;text-align:center;background:#fbfdff;">
                <i class="fas fa-check-circle" style="font-size:24px;color:#10b981;margin-bottom:8px;"></i>
                <div style="font-size:28px;font-weight:600;color:#111;">{{ $packagesDelivered->count() }}</div>
                <div style="color:var(--muted);font-size:14px;">Bezorgd</div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr;gap:24px;">
            <section style="background:#fff;border:1px solid #e6eef8;border-radius:12px;padding:20px;box-shadow:0 4px 12px rgba(15,23,42,0.08);">
                <h4 style="margin:0 0 16px 0;color:#111;"><i class="fas fa-box" style="color:var(--accent);"></i> Pakketten in Magazijn</h4>
                @if($packagesInStorage->count() > 0)
                    <table style="width:100%;border-collapse:collapse;margin-top:8px">
                        <thead style="text-align:left;color:var(--muted);font-size:13px">
                            <tr><th style="padding:8px;border-bottom:1px solid #eef2ff">Tracking Nummer</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Ontvanger</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Gewicht</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Aangemaakt</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Acties</th></tr>
                        </thead>
                        <tbody>
                        @foreach($packagesInStorage as $index => $package)
                            <tr class="{{ $index % 2 == 0 ? 'even-row' : 'odd-row' }}">
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->tracking_number }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->recipient_name }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->weight ? $package->weight . ' kg' : 'N/A' }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->created_at->format('d-m-Y H:i') }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">
                                    <a href="{{ route('pakket.qr', $package->id) }}" class="btn btn-sm" style="background:#0ea5e9;color:white;padding:4px 8px;border-radius:4px;text-decoration:none;font-size:12px;"><i class="fas fa-qrcode"></i> QR</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="color:var(--muted)">Geen pakketten in magazijn.</p>
                @endif
            </section>

            <section style="background:#fff;border:1px solid #e6eef8;border-radius:12px;padding:20px;box-shadow:0 4px 12px rgba(15,23,42,0.08);">
                <h4 style="margin:0 0 16px 0;color:#111;"><i class="fas fa-truck" style="color:#f59e0b;"></i> Pakketten in Transit</h4>
                @if($packagesInTransit->count() > 0)
                    <table style="width:100%;border-collapse:collapse;margin-top:8px">
                        <thead style="text-align:left;color:var(--muted);font-size:13px">
                            <tr><th style="padding:8px;border-bottom:1px solid #eef2ff">Tracking Nummer</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Ontvanger</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Koerier</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Bijgewerkt</th></tr>
                        </thead>
                        <tbody>
                        @foreach($packagesInTransit as $index => $package)
                            <tr class="{{ $index % 2 == 0 ? 'even-row' : 'odd-row' }}">
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->tracking_number }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->recipient_name }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->koerier ? $package->koerier->name : 'N/A' }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->updated_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="color:var(--muted)">Geen pakketten in transit.</p>
                @endif
            </section>

            <section style="background:#fff;border:1px solid #e6eef8;border-radius:12px;padding:20px;box-shadow:0 4px 12px rgba(15,23,42,0.08);">
                <h4 style="margin:0 0 16px 0;color:#111;"><i class="fas fa-check-circle" style="color:#10b981;"></i> Pakketten Bezorgd</h4>
                @if($packagesDelivered->count() > 0)
                    <table style="width:100%;border-collapse:collapse;margin-top:8px">
                        <thead style="text-align:left;color:var(--muted);font-size:13px">
                            <tr><th style="padding:8px;border-bottom:1px solid #eef2ff">Tracking Nummer</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Ontvanger</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Koerier</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Bezorgd</th></tr>
                        </thead>
                        <tbody>
                        @foreach($packagesDelivered as $index => $package)
                            <tr class="{{ $index % 2 == 0 ? 'even-row' : 'odd-row' }}">
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->tracking_number }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->recipient_name }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->koerier ? $package->koerier->name : 'N/A' }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->updated_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="color:var(--muted)">Geen bezorgde pakketten.</p>
                @endif
            </section>
        </div>
    </div>
@endsection
