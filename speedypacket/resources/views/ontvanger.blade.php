@extends('layouts.app')

@section('title', 'Ontvanger Dashboard')

@section('content')
    <style>
        .even-row { background-color: #f9fafb; }
        .odd-row { background-color: #ffffff; }
        .even-row:hover, .odd-row:hover { background-color: #f3f4f6; }
        @media (max-width: 768px) {
            .ontvanger-grid { grid-template-columns: 1fr !important; }
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
        <h2 style="margin-top:0"><i class="fas fa-inbox dashboard-icon"></i> Ontvanger Dashboard</h2>
        <p style="color:var(--muted)">Welkom terug, {{ auth()->user()->name }}. Hier zijn uw pakketten onderweg en hun locaties.</p>

        <div class="ontvanger-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
            <section>
                <h4><i class="fas fa-truck dashboard-icon"></i> Pakketten Onderweg</h4>
                @if($packagesInTransit->count() > 0)
                    <table style="width:100%;border-collapse:collapse;margin-top:8px">
                        <thead style="text-align:left;color:var(--muted);font-size:13px">
                            <tr><th style="padding:8px;border-bottom:1px solid #eef2ff">Tracking Nummer</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Verzender</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Adres</th></tr>
                        </thead>
                        <tbody>
                        @foreach($packagesInTransit as $package)
                            <tr>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->tracking_number }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->user->name }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->recipient_address }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="color:var(--muted)">Geen pakketten onderweg.</p>
                @endif
            </section>

            <section class="map-container">
                <h4><i class="fas fa-map-marked-alt dashboard-icon"></i> Locatie</h4>
                @if($packagesInTransit->count() > 0)
                    <div id="map" style="height: 400px; width: 100%; margin-top: 8px;" data-addresses='@json($packagesInTransit->pluck("recipient_address")->toArray())'></div>
                @else
                    <p style="color:var(--muted)">Geen locatie beschikbaar.</p>
                @endif
            </section>
        </div>

        <div style="margin-top:24px;">
            <section style="background:#fff;border:1px solid #e6eef8;border-radius:12px;padding:20px;box-shadow:0 4px 12px rgba(15,23,42,0.08);">
                <h4 style="margin:0 0 16px 0;color:#111;"><i class="fas fa-file-invoice-dollar" style="color:#f59e0b;"></i> Gefactureerde Pakketten (Betaling Vereist)</h4>
                @if($billedPackages->count() > 0)
                    <table style="width:100%;border-collapse:collapse;margin-top:8px">
                        <thead style="text-align:left;color:var(--muted);font-size:13px">
                            <tr><th style="padding:8px;border-bottom:1px solid #eef2ff">Tracking Nummer</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Verzender</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Gewicht</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Gefactureerd</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Actie</th></tr>
                        </thead>
                        <tbody>
                        @foreach($billedPackages as $index => $package)
                            <tr class="{{ $index % 2 == 0 ? 'even-row' : 'odd-row' }}">
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->tracking_number }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->user->name ?? 'Onbekend' }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->weight ? $package->weight . ' kg' : 'N/A' }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->updated_at->format('d-m-Y H:i') }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">
                                    <form method="POST" action="{{ route('ontvanger.pay', $package->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" style="background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 4px; font-size: 12px; cursor: pointer;">
                                            <i class="fas fa-credit-card"></i> Betalen
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="color:var(--muted)">Geen gefactureerde pakketten die betaling vereisen.</p>
                @endif
            </section>
        </div>
    </div>
@endsection
