@extends('layouts.app')

@section('title', 'Pakketten Volgen')

@section('content')
    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <h2 style="margin-bottom: 24px;"><i class="fas fa-search"></i> Pakketten Volgen</h2>

        <form action="{{ route('pakketten-volgen') }}" method="GET" style="margin-bottom: 24px;">
            <div style="display: flex; gap: 12px; align-items: end;">
                <div style="flex: 1;">
                    <label for="tracking_number" style="display: block; margin-bottom: 6px; font-weight: 600;">Tracking Nummer</label>
                    <input type="text" id="tracking_number" name="tracking_number" value="{{ $trackingNumber }}"
                           placeholder="Voer tracking nummer in" required
                           style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                </div>
                <button type="submit" class="btn">
                    <i class="fas fa-search"></i> Zoeken
                </button>
            </div>
        </form>

        @if($trackingNumber && !$package)
            <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 18px; border: 1px solid #fecaca;">
                <i class="fas fa-exclamation-triangle"></i> Geen pakket gevonden met dit tracking nummer, of het pakket behoort niet tot jou.
            </div>
        @endif

        @if($package)
            <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 12px; padding: 24px;">
                <h3 style="margin: 0 0 18px; color: #0c4a6e;"><i class="fas fa-box"></i> Pakket Details</h3>

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
            <a href="{{ route('mijn-verzendingen') }}" class="btn secondary">
                <i class="fas fa-list"></i> Mijn Verzendingen
            </a>
            <a href="{{ route('dashboard') }}" class="btn secondary">
                <i class="fas fa-arrow-left"></i> Terug naar Dashboard
            </a>
        </div>
    </div>
@endsection
