@extends('layouts.app')

@section('title', 'Koerier Dashboard')

@section('content')
    <div class="card" style="max-width:1200px;margin:0 auto;">
        <h2 style="margin-top:0"><i class="fas fa-truck"></i> Koerier Dashboard</h2>
        <p style="color:var(--muted)">Welkom terug, {{ auth()->user()->name }}. Hier zijn uw pakketten om te bezorgen en uw route.</p>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
            <section>
                <h4><i class="fas fa-box"></i> Pakketten om te Bezorgen</h4>
                @if($packagesToDeliver->count() > 0)
                    <table style="width:100%;border-collapse:collapse;margin-top:8px">
                        <thead style="text-align:left;color:var(--muted);font-size:13px">
                            <tr><th style="padding:8px;border-bottom:1px solid #eef2ff">Tracking Nummer</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Ontvanger</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Adres</th></tr>
                        </thead>
                        <tbody>
                        @foreach($packagesToDeliver as $package)
                            <tr>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->tracking_number }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->recipient_name }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->recipient_address }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="color:var(--muted)">Geen pakketten om te bezorgen.</p>
                @endif
            </section>

            <section>
                <h4><i class="fas fa-hand-paper"></i> Beschikbare Pakketten</h4>
                @if($pendingPackages->count() > 0)
                    <table style="width:100%;border-collapse:collapse;margin-top:8px">
                        <thead style="text-align:left;color:var(--muted);font-size:13px">
                            <tr><th style="padding:8px;border-bottom:1px solid #eef2ff">Tracking Nummer</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Ontvanger</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Adres</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Actie</th></tr>
                        </thead>
                        <tbody>
                        @foreach($pendingPackages as $package)
                            <tr>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->tracking_number }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->recipient_name }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->recipient_address }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">
                                    <form method="POST" action="{{ route('koerier.take', $package->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" style="background-color:var(--accent);color:white;border:none;padding:4px 8px;border-radius:4px;cursor:pointer;">Neem</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="color:var(--muted)">Geen beschikbare pakketten.</p>
                @endif
            </section>

            <section>
                <h4><i class="fas fa-route"></i> Route</h4>
                @if($packagesToDeliver->count() > 0)
                    <div id="map" style="height: 400px; width: 100%; margin-top: 8px;" data-addresses="{{ json_encode(collect([$startAddress])->merge($packagesToDeliver->pluck('recipient_address'))->toArray()) }}"></div>
                    <ol style="margin-top:8px;color:var(--muted); font-size: 14px;">
                        <li style="margin-bottom: 8px;">Start: {{ $startAddress }}</li>
                    @foreach($packagesToDeliver as $index => $package)
                        <li style="margin-bottom: 8px;">{{ $index + 1 }}. {{ $package->recipient_address }} ({{ $package->recipient_name }})</li>
                    @endforeach
                    </ol>
                @else
                    <p style="color:var(--muted)">Geen route beschikbaar.</p>
                @endif
            </section>
        </div>
    </div>
@endsection
