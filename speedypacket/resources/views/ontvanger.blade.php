@extends('layouts.app')

@section('title', 'Ontvanger Dashboard')

@section('content')
    <div class="card" style="max-width:1200px;margin:0 auto;">
        <h2 style="margin-top:0"><i class="fas fa-inbox"></i> Ontvanger Dashboard</h2>
        <p style="color:var(--muted)">Welkom terug, {{ auth()->user()->name }}. Hier zijn uw pakketten onderweg en hun locaties.</p>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
            <section>
                <h4><i class="fas fa-truck"></i> Pakketten Onderweg</h4>
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

            <section>
                <h4><i class="fas fa-map-marked-alt"></i> Locatie</h4>
                @if($packagesInTransit->count() > 0)
                    <div id="map" style="height: 400px; width: 100%; margin-top: 8px;" data-addresses="{{ json_encode($packagesInTransit->pluck('recipient_address')->toArray()) }}"></div>
                @else
                    <p style="color:var(--muted)">Geen locatie beschikbaar.</p>
                @endif
            </section>
        </div>
    </div>
@endsection
