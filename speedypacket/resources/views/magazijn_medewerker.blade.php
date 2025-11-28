@extends('layouts.app')

@section('title', 'Magazijn Medewerker Dashboard')

@section('content')
    <div class="card" style="max-width:1200px;margin:0 auto;">
        <h2 style="margin-top:0"><i class="fas fa-warehouse"></i> Magazijn Medewerker Dashboard</h2>
        <p style="color:var(--muted)">Welkom terug, {{ auth()->user()->name }}. Hier ziet u de status van pakketten in het magazijn.</p>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
            <section>
                <h4><i class="fas fa-box"></i> Pakketten in Magazijn</h4>
                @if($packagesInStorage->count() > 0)
                    <table style="width:100%;border-collapse:collapse;margin-top:8px">
                        <thead style="text-align:left;color:var(--muted);font-size:13px">
                            <tr><th style="padding:8px;border-bottom:1px solid #eef2ff">Tracking Nummer</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Ontvanger</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Gewicht</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Aangemaakt</th></tr>
                        </thead>
                        <tbody>
                        @foreach($packagesInStorage as $package)
                            <tr>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->tracking_number }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->recipient_name }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->weight ? $package->weight . ' kg' : 'N/A' }}</td>
                                <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $package->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="color:var(--muted)">Geen pakketten in magazijn.</p>
                @endif
            </section>

            <section>
                <h4><i class="fas fa-truck"></i> Pakketten in Transit</h4>
                @if($packagesInTransit->count() > 0)
                    <table style="width:100%;border-collapse:collapse;margin-top:8px">
                        <thead style="text-align:left;color:var(--muted);font-size:13px">
                            <tr><th style="padding:8px;border-bottom:1px solid #eef2ff">Tracking Nummer</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Ontvanger</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Koerier</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Bijgewerkt</th></tr>
                        </thead>
                        <tbody>
                        @foreach($packagesInTransit as $package)
                            <tr>
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

            <section>
                <h4><i class="fas fa-check-circle"></i> Pakketten Bezorgd</h4>
                @if($packagesDelivered->count() > 0)
                    <table style="width:100%;border-collapse:collapse;margin-top:8px">
                        <thead style="text-align:left;color:var(--muted);font-size:13px">
                            <tr><th style="padding:8px;border-bottom:1px solid #eef2ff">Tracking Nummer</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Ontvanger</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Koerier</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Bezorgd</th></tr>
                        </thead>
                        <tbody>
                        @foreach($packagesDelivered as $package)
                            <tr>
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
