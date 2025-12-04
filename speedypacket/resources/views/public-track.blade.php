@extends('layouts.app')

@section('title', 'Pakket Details')

@section('content')
    <div class="card">
        <h2 style="margin-bottom: 24px;"><i class="fas fa-box"></i> Pakket Details</h2>

        @if(!$package)
            <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 18px; border: 1px solid #fecaca;">
                <i class="fas fa-exclamation-triangle"></i> Geen pakket gevonden met dit tracking nummer.
            </div>
        @else
            <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 12px; padding: 24px;">
                <h3 style="margin: 0 0 18px; color: #0c4a6e;"><i class="fas fa-box"></i> Pakket Informatie</h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 24px;">
                    <div>
                        <strong>Tracking Nummer:</strong><br>
                        {{ $package->tracking_number }}
                    </div>
                    <div>
                        <strong>Status:</strong><br>
                        @if($package->status === 'pending')
                            <span style="background: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 4px;">
                                <i class="fas fa-clock"></i> In Behandeling
                            </span>
                        @elseif($package->status === 'in_transit')
                            <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 4px;">
                                <i class="fas fa-truck"></i> Onderweg
                            </span>
                        @elseif($package->status === 'delivered')
                            <span style="background: #d1fae5; color: #065f46; padding: 4px 8px; border-radius: 4px;">
                                <i class="fas fa-check-circle"></i> Bezorgd
                            </span>
                        @elseif($package->status === 'billed')
                            <span style="background: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 4px;">
                                <i class="fas fa-dollar-sign"></i> Gefactureerd
                            </span>
                        @endif
                    </div>
                    <div>
                        <strong>Ontvanger:</strong><br>
                        {{ $package->recipient_name }}
                    </div>
                    <div>
                        <strong>Gewicht:</strong><br>
                        {{ $package->weight ? $package->weight . ' kg' : 'Niet opgegeven' }}
                    </div>
                    <div>
                        <strong>Koerier:</strong><br>
                        {{ $package->koerier ? $package->koerier->name : 'Nog niet toegewezen' }}
                    </div>
                    <div>
                        <strong>Rayon:</strong><br>
                        {{ $package->rayon }}
                    </div>
                    <div style="grid-column: span 2;">
                        <strong>Adres:</strong><br>
                        {{ $package->recipient_address }}
                    </div>
                    @if($package->description)
                        <div style="grid-column: span 2;">
                            <strong>Beschrijving:</strong><br>
                            {{ $package->description }}
                        </div>
                    @endif
                </div>

                <div style="border-top: 1px solid #bae6fd; padding-top: 18px;">
                    <strong>Aangemaakt op:</strong> {{ $package->created_at->format('d-m-Y H:i') }}<br>
                    <strong>Laatst bijgewerkt:</strong> {{ $package->updated_at->format('d-m-Y H:i') }}
                </div>
            </div>
        @endif

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <a href="{{ route('login') }}" class="btn secondary">
                <i class="fas fa-sign-in-alt"></i> Inloggen
            </a>
            <a href="/" class="btn secondary">
                <i class="fas fa-home"></i> Home
            </a>
        </div>
    </div>
@endsection
