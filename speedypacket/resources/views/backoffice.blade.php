@extends('layouts.app')

@section('title', 'Backoffice Dashboard')

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
        <h2 style="margin-top:0"><i class="fas fa-calculator dashboard-icon"></i> Backoffice Dashboard</h2>
        <p style="color:var(--muted)">Welkom terug, {{ auth()->user()->name }}. Hier kunt u pakketten factureren.</p>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 18px; border: 1px solid #a7f3d0;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 18px; border: 1px solid #fecaca;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Stats Overview -->
        <div style="display:flex;gap:24px;margin-bottom:32px;flex-wrap:wrap;">
            <div style="flex:1;min-width:200px;padding:20px;border:1px solid #e6eef8;border-radius:12px;text-align:center;background:#fbfdff;">
                <i class="fas fa-check-circle" style="font-size:24px;color:#10b981;margin-bottom:8px;"></i>
                <div style="font-size:28px;font-weight:600;color:#111;">{{ $deliveredPackages->count() }}</div>
                <div style="color:var(--muted);font-size:14px;">Bezorgd</div>
            </div>
            <div style="flex:1;min-width:200px;padding:20px;border:1px solid #e6eef8;border-radius:12px;text-align:center;background:#fbfdff;">
                <i class="fas fa-file-invoice-dollar" style="font-size:24px;color:#f59e0b;margin-bottom:8px;"></i>
                <div style="font-size:28px;font-weight:600;color:#111;">{{ $billedPackages->count() }}</div>
                <div style="color:var(--muted);font-size:14px;">Gefactureerd</div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr;gap:24px;">
            <section style="background:#fff;border:1px solid #e6eef8;border-radius:12px;padding:20px;box-shadow:0 4px 12px rgba(15,23,42,0.08);">
                <h4 style="margin:0 0 16px 0;color:#111;"><i class="fas fa-check-circle" style="color:#10b981;"></i> Bezorgde Pakketten (Klaar voor Facturering)</h4>
                @if($deliveredPackages->count() > 0)
                    <table style="width:100%;border-collapse:collapse;margin-top:8px">
                        <thead style="text-align:left;color:var(--muted);font-size:13px">
                            <tr><th style="padding:8px;border-bottom:1px solid #eef2ff">Tracking Nummer</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Ontvanger</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Gewicht</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Bezorgd</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Actie</th></tr>
                        </thead>
                        <tbody>
                        @foreach($deliveredPackages as $index => $package)
                            <tr class="{{ $index % 2 == 0 ? 'even-row' : 'odd-row' }}">
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->tracking_number }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->recipient_name }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->weight ? $package->weight . ' kg' : 'N/A' }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->updated_at->format('d-m-Y H:i') }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">
                                    <form method="POST" action="{{ route('backoffice.bill', $package->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" style="background:#10b981;color:white;border:none;padding:6px 12px;border-radius:6px;cursor:pointer;font-size:12px;">Factureren</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="color:var(--muted)">Geen bezorgde pakketten om te factureren.</p>
                @endif
            </section>

            <section style="background:#fff;border:1px solid #e6eef8;border-radius:12px;padding:20px;box-shadow:0 4px 12px rgba(15,23,42,0.08);">
                <h4 style="margin:0 0 16px 0;color:#111;"><i class="fas fa-file-invoice-dollar" style="color:#f59e0b;"></i> Gefactureerde Pakketten</h4>
                @if($billedPackages->count() > 0)
                    <table style="width:100%;border-collapse:collapse;margin-top:8px">
                        <thead style="text-align:left;color:var(--muted);font-size:13px">
                            <tr><th style="padding:8px;border-bottom:1px solid #eef2ff">Tracking Nummer</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Ontvanger</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Gewicht</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Gefactureerd</th></tr>
                        </thead>
                        <tbody>
                        @foreach($billedPackages as $index => $package)
                            <tr class="{{ $index % 2 == 0 ? 'even-row' : 'odd-row' }}">
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->tracking_number }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->recipient_name }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->weight ? $package->weight . ' kg' : 'N/A' }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->updated_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="color:var(--muted)">Geen gefactureerde pakketten.</p>
                @endif
            </section>
        </div>
    </div>
@endsection
