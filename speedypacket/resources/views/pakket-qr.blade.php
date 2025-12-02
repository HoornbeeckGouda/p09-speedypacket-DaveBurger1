@extends('layouts.app')

@section('title', 'Pakket QR Code')

@section('content')
    <div class="card">
        <h2 style="margin-bottom: 24px;"><i class="fas fa-qrcode"></i> Pakket QR Code</h2>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <div>
                <h3 style="margin-bottom: 16px; color: var(--accent);">Pakket Informatie</h3>
                <div style="margin-bottom: 12px;">
                    <strong>Tracking Nummer:</strong> {{ $package->tracking_number }}
                </div>
                <div style="margin-bottom: 12px;">
                    <strong>Ontvanger:</strong> {{ $package->recipient_name }}
                </div>
                <div style="margin-bottom: 12px;">
                    <strong>Adres:</strong> {{ $package->recipient_address }}
                </div>
                <div style="margin-bottom: 12px;">
                    <strong>Rayon:</strong> {{ $package->rayon }}
                </div>
                <div style="margin-bottom: 12px;">
                    <strong>Magazijn Locatie:</strong> {{ $package->warehouse_location }}
                </div>
                <div style="margin-bottom: 12px;">
                    <strong>Gewicht:</strong> {{ $package->weight ? $package->weight . ' kg' : '-' }}
                </div>
                <div style="margin-bottom: 12px;">
                    <strong>Status:</strong>
                    @if($package->status === 'in_warehouse')
                        <span style="background: #e0e7ff; color: #3730a3; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            <i class="fas fa-warehouse"></i> In Magazijn
                        </span>
                    @elseif($package->status === 'pending')
                        <span style="background: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            <i class="fas fa-clock"></i> In Behandeling
                        </span>
                    @elseif($package->status === 'in_transit')
                        <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            <i class="fas fa-truck"></i> Onderweg
                        </span>
                    @elseif($package->status === 'delivered')
                        <span style="background: #d1fae5; color: #065f46; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            <i class="fas fa-check-circle"></i> Bezorgd
                        </span>
                    @elseif($package->status === 'billed')
                        <span style="background: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            <i class="fas fa-file-invoice-dollar"></i> Gefactureerd
                        </span>
                    @elseif($package->status === 'paid')
                        <span style="background: #d1fae5; color: #065f46; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            <i class="fas fa-check-circle"></i> Betaald
                        </span>
                    @endif
                </div>
            </div>

            <div>
                <h3 style="margin-bottom: 16px; color: var(--accent);">QR Code</h3>
                @if($package->qr_code)
                    <div style="text-align: center; padding: 20px; background: #f9fafb; border-radius: 8px; border: 1px solid #e5e7eb;">
                        <div style="display: inline-block; max-width: 300px; max-height: 300px;">
                            {!! $package->qr_code !!}
                        </div>
                    </div>
                @else
                    <div style="text-align: center; padding: 20px; background: #fef2f2; border-radius: 8px; border: 1px solid #fecaca;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: #dc2626; margin-bottom: 16px;"></i>
                        <p style="color: #dc2626;">QR code niet beschikbaar voor dit pakket.</p>
                    </div>
                @endif
            </div>
        </div>

        <div style="margin-top: 24px;">
            <a href="{{ route('magazijn') }}" class="btn secondary">
                <i class="fas fa-arrow-left"></i> Terug naar Magazijn Dashboard
            </a>
        </div>
    </div>
@endsection
