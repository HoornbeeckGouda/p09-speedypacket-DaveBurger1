@extends('layouts.app')

@section('title', 'Koerier Dashboard')

@section('content')
    <style>
        .even-row { background-color: #f9fafb; }
        .odd-row { background-color: #ffffff; }
        .even-row:hover, .odd-row:hover { background-color: #f3f4f6; }
        @media (max-width: 768px) {
            .koerier-grid { grid-template-columns: 1fr !important; }
        }
    </style>
    <div class="card" style="margin:0 auto;" id="koerier-page">
        <!-- Hero Section -->
        <div style="background: linear-gradient(135deg, var(--accent), #4f46e5); color: #fff; border-radius: 12px; padding: 24px; margin-bottom: 24px;">
            <h2 style="margin: 0; font-size: 28px;"><i class="fas fa-truck"></i> Welkom terug, {{ auth()->user()->name }}!</h2>
            <p style="margin: 8px 0 0; opacity: 0.9;">Beheer uw bezorgingen efficiënt en overzichtelijk.</p>
        </div>

        <section class="koerier-section-span map-container" style="margin-bottom: 24px;">
            <h4 style="margin-bottom: 12px;"><i class="fas fa-route"></i> Route</h4>
            @if($packagesToDeliver->count() > 0)
                <div style="background: #fff; border: 1px solid #eef2ff; border-radius: 8px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <div id="map" style="height: 400px; width: 100%; border-radius: 8px;" data-addresses='@json(collect([$startAddress])->merge($packagesToDeliver->pluck("recipient_address")->toArray()))'></div>
                    <div style="margin-top:16px; padding: 16px; background: #f8fafc; border-radius: 8px;">
                        <h5 style="margin: 0 0 12px; color: #111;">Route Overzicht</h5>
                        <ol style="margin:0; padding-left: 20px; color:var(--muted); font-size: 14px;">
                            <li style="margin-bottom: 8px;"><strong>Start:</strong> {{ $startAddress }}</li>
                        @foreach($packagesToDeliver as $index => $package)
                            <li style="margin-bottom: 8px;"><strong>{{ $index + 1 }}.</strong> {{ $package->recipient_address }} ({{ $package->recipient_name }})</li>
                        @endforeach
                        </ol>
                    </div>
                </div>
            @else
                <div style="background: #fff; border: 1px solid #eef2ff; border-radius: 8px; padding: 24px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <i class="fas fa-map" style="font-size: 48px; color: var(--muted); margin-bottom: 16px;"></i>
                    <p style="color:var(--muted); margin: 0;">Geen route beschikbaar.</p>
                </div>
            @endif
        </section>

        <div class="koerier-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:24px;" id="koerier-grid">
            <section>
                <h4 style="margin-bottom: 12px;"><i class="fas fa-box"></i> Pakketten om te Bezorgen</h4>
                @if($packagesToDeliver->count() > 0)
                    <div class="table-container" style="background: #fff; border: 1px solid #eef2ff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <table style="width:100%;border-collapse:collapse;">
                            <thead style="background: #f8fafc; text-align:left;color:var(--muted);font-size:13px">
                                <tr><th style="padding:12px 16px;border-bottom:1px solid #eef2ff">Tracking Nummer</th><th style="padding:12px 16px;border-bottom:1px solid #eef2ff">Ontvanger</th><th style="padding:12px 16px;border-bottom:1px solid #eef2ff">Adres</th></tr>
                            </thead>
                            <tbody>
                            @foreach($packagesToDeliver as $package)
                                <tr style="transition: background-color 0.2s;">
                                    <td style="padding:12px 16px;border-bottom:1px solid #f1f5f9">{{ $package->tracking_number }}</td>
                                    <td style="padding:12px 16px;border-bottom:1px solid #f1f5f9">{{ $package->recipient_name }}</td>
                                    <td style="padding:12px 16px;border-bottom:1px solid #f1f5f9">{{ $package->recipient_address }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="background: #fff; border: 1px solid #eef2ff; border-radius: 8px; padding: 24px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <i class="fas fa-inbox" style="font-size: 48px; color: var(--muted); margin-bottom: 16px;"></i>
                        <p style="color:var(--muted); margin: 0;">Geen pakketten om te bezorgen.</p>
                    </div>
                @endif
            </section>

            <section>
                <h4 style="margin-bottom: 12px;"><i class="fas fa-hand-paper"></i> Beschikbare Pakketten</h4>
                @if($pendingPackages->count() > 0)
                    <div class="table-container" style="background: #fff; border: 1px solid #eef2ff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <table style="width:100%;border-collapse:collapse;">
                            <thead style="background: #f8fafc; text-align:left;color:var(--muted);font-size:13px">
                                <tr><th style="padding:12px 16px;border-bottom:1px solid #eef2ff">Tracking Nummer</th><th style="padding:12px 16px;border-bottom:1px solid #eef2ff">Ontvanger</th><th style="padding:12px 16px;border-bottom:1px solid #eef2ff">Adres</th><th style="padding:12px 16px;border-bottom:1px solid #eef2ff">Actie</th></tr>
                            </thead>
                            <tbody>
                            @foreach($pendingPackages as $index => $package)
                                <tr class="{{ $index % 2 == 0 ? 'even-row' : 'odd-row' }}">
                                    <td style="padding:12px 16px;border-bottom:1px solid #f1f5f9">{{ $package->tracking_number }}</td>
                                    <td style="padding:12px 16px;border-bottom:1px solid #f1f5f9">{{ $package->recipient_name }}</td>
                                    <td style="padding:12px 16px;border-bottom:1px solid #f1f5f9">{{ $package->recipient_address }}</td>
                                    <td style="padding:12px 16px;border-bottom:1px solid #f1f5f9">
                                        <form method="POST" action="{{ route('koerier.take', $package->id) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" style="background-color:var(--accent);color:white;border:none;padding:6px 12px;border-radius:6px;cursor:pointer;font-size:14px; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#0056b3'" onmouseout="this.style.backgroundColor='var(--accent)'">Neem</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="background: #fff; border: 1px solid #eef2ff; border-radius: 8px; padding: 24px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <i class="fas fa-inbox" style="font-size: 48px; color: var(--muted); margin-bottom: 16px;"></i>
                        <p style="color:var(--muted); margin: 0;">Geen beschikbare pakketten.</p>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection
