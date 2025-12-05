@extends('layouts.app')

@section('title', 'Pakketten Volgen')

@section('content')
    <div class="card">
        <h2 style="margin-bottom: 24px;"><i class="fas fa-search"></i> Pakketten Volgen</h2>

        <form action="{{ route('pakketten-volgen') }}" method="GET" class="form-enhanced" style="margin-bottom: 24px;">
            <div style="display: flex; gap: 12px; align-items: end;">
                <div style="flex: 1;">
                    <label for="tracking_number" style="display: block; margin-bottom: 6px; font-weight: 600;">Tracking Nummer</label>
                    <input type="text" id="tracking_number" name="tracking_number" value="{{ $trackingNumber }}"
                           placeholder="Voer tracking nummer in" required class="input-enhanced">
                </div>
            </div>
        </form>

        @if($trackingNumber && !$package)
            <div class="alert-enhanced" style="margin-bottom: 18px;">
                <i class="fas fa-exclamation-triangle"></i> Geen pakket gevonden met dit tracking nummer, of het pakket behoort niet tot jou.
            </div>
        @endif

        @if($package)
            <!-- Status Timeline -->
            <div class="card-enhanced" style="margin-bottom: 24px;">
                <h3 style="margin: 0 0 18px; color: #334155;"><i class="fas fa-history"></i> Status Geschiedenis</h3>
                <div class="progress-bar-container">
                    <div class="progress-bar">
                        <div class="progress-fill {{ $package->status === 'delivered' ? 'progress-100' : ($package->status === 'in_transit' ? 'progress-66' : 'progress-33') }}"></div>
                    </div>
                    <div class="progress-labels">
                        <span class="active">Aangemaakt</span>
                        <span class="{{ $package->status === 'in_transit' || $package->status === 'delivered' ? 'active' : '' }}">Onderweg</span>
                        <span class="{{ $package->status === 'delivered' ? 'active' : '' }}">Bezorgd</span>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div class="timeline-item" style="border-left-color: #10b981;">
                        <div class="timeline-dot" style="background: #10b981;"></div>
                        <div class="timeline-content">
                            <strong>Aangemaakt</strong><br>
                            <small>{{ $package->created_at->format('d-m-Y H:i') }}</small>
                        </div>
                    </div>
                    @if($package->status === 'in_transit' || $package->status === 'delivered')
                        <div class="timeline-item" style="border-left-color: #3b82f6;">
                            <div class="timeline-dot" style="background: #3b82f6;"></div>
                            <div class="timeline-content">
                                <strong>Onderweg</strong><br>
                                <small>{{ $package->updated_at->format('d-m-Y H:i') }}</small>
                                <div class="timeline-icon"><i class="fas fa-truck-moving"></i></div>
                            </div>
                        </div>
                    @endif
                    @if($package->status === 'delivered')
                        <div class="timeline-item" style="border-left-color: #059669;">
                            <div class="timeline-dot" style="background: #059669;"></div>
                            <div class="timeline-content">
                                <strong>Bezorgd</strong><br>
                                <small>{{ $package->updated_at->format('d-m-Y H:i') }}</small>
                                <div class="timeline-icon"><i class="fas fa-check-circle"></i></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="package-details-card" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #f0f9ff 100%); border: 2px solid transparent; border-image: linear-gradient(135deg, #bae6fd, #93c5fd, #bae6fd) 1; border-radius: 20px; padding: 32px; position: relative; overflow: hidden;">
                <div class="card-decoration decoration-1"></div>
                <div class="card-decoration decoration-2"></div>
                <div class="card-decoration decoration-3"></div>
                <h3 style="margin: 0 0 18px; color: #0c4a6e; position: relative; z-index: 2;"><i class="fas fa-box-open"></i> Pakket Details</h3>

                <div class="grid-enhanced">
                    <div class="grid-item">
                        <strong>Tracking Nummer:</strong><br>
                        {{ $package->tracking_number }}
                    </div>
                    <div class="grid-item">
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
                    <div class="grid-item">
                        <strong>Verzender:</strong><br>
                        {{ $package->user ? $package->user->name : 'Onbekend' }}
                    </div>
                    <div class="grid-item">
                        <strong>Ontvanger:</strong><br>
                        {{ $package->recipient_name }}
                    </div>
                    <div class="grid-item">
                        <strong>Gewicht:</strong><br>
                        {{ $package->weight ? $package->weight . ' kg' : 'Niet opgegeven' }}
                    </div>
                    <div class="grid-item">
                        <strong>Koerier:</strong><br>
                        {{ $package->koerier ? $package->koerier->name : 'Nog niet toegewezen' }}
                    </div>
                    <div class="grid-item">
                        <strong>Geschatte Bezorging:</strong><br>
                        {{ $estimatedDelivery ?? 'Niet beschikbaar' }}
                    </div>
                    <div class="grid-item" style="grid-column: span 2;">
                        <strong>Adres:</strong><br>
                        {{ $package->recipient_address }}
                    </div>
                    @if($package->description)
                        <div class="grid-item" style="grid-column: span 2;">
                            <strong>Beschrijving:</strong><br>
                            {{ $package->description }}
                        </div>
                    @endif
                </div>

                <!-- QR Code Section -->
                @if($package->qr_code)
                    <div style="border-top: 1px solid #bae6fd; padding-top: 18px; margin-bottom: 18px;">
                        <h4 style="margin: 0 0 12px; color: #0c4a6e;"><i class="fas fa-qrcode"></i> QR Code</h4>
                        <div class="qr-container">
                            {!! $package->qr_code !!}
                        </div>
                    </div>
                @endif

                <div style="border-top: 1px solid #bae6fd; padding-top: 18px;">
                    <strong>Aangemaakt op:</strong> {{ $package->created_at->format('d-m-Y H:i') }}<br>
                    <strong>Laatst bijgewerkt:</strong> {{ $package->updated_at->format('d-m-Y H:i') }}
                </div>
            </div>
        @endif

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <a href="{{ route('mijn-verzendingen') }}" class="btn-enhanced secondary">
                <i class="fas fa-list"></i> Mijn Verzendingen
            </a>
            <a href="{{ route('dashboard') }}" class="btn-enhanced secondary">
                <i class="fas fa-arrow-left"></i> Terug naar Dashboard
            </a>
        </div>
    </div>
@endsection
