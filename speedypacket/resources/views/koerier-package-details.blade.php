@extends('layouts.app')

@section('title', 'Pakket Details')

@section('content')
    <div class="card">
        <h2 style="margin-bottom: 24px;"><i class="fas fa-box"></i> Pakket Details</h2>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <div>
                <h3 style="margin-bottom: 16px; color: var(--accent);">Algemene Informatie</h3>
                <div style="margin-bottom: 12px;">
                    <strong>Tracking Nummer:</strong> {{ $package->tracking_number }}
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
                <div style="margin-bottom: 12px;">
                    <strong>Gewicht:</strong> {{ $package->weight ? $package->weight . ' kg' : '-' }}
                </div>
                <div style="margin-bottom: 12px;">
                    <strong>Aangemaakt:</strong> {{ $package->created_at->format('d-m-Y H:i') }}
                </div>
                <div style="margin-bottom: 12px;">
                    <strong>Bijgewerkt:</strong> {{ $package->updated_at->format('d-m-Y H:i') }}
                </div>
            </div>

            <div>
                <h3 style="margin-bottom: 16px; color: var(--accent);">Ontvanger Informatie</h3>
                <div style="margin-bottom: 12px;">
                    <strong>Naam:</strong> {{ $package->recipient_name }}
                </div>
                <div style="margin-bottom: 12px;">
                    <strong>Email:</strong> {{ $package->recipient_email }}
                </div>
                <div style="margin-bottom: 12px;">
                    <strong>Telefoon:</strong> {{ $package->recipient_phone ?: '-' }}
                </div>
                <div style="margin-bottom: 12px;">
                    <strong>Adres:</strong> {{ $package->recipient_address }}
                </div>
            </div>
        </div>

        <div style="margin-top: 24px;">
            <h3 style="margin-bottom: 16px; color: var(--accent);">Beschrijving</h3>
            <p style="background: #f9fafb; padding: 12px; border-radius: 8px; border: 1px solid #e5e7eb;">
                {{ $package->description ?: 'Geen beschrijving beschikbaar.' }}
            </p>
        </div>

        @if($package->status === 'in_transit')
            <div style="margin-top: 24px; display: flex; gap: 12px;">
                <form method="POST" action="{{ route('koerier.deliver', $package->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn" onclick="return confirm('Weet je zeker dat je dit pakket wilt markeren als bezorgd?')">
                        <i class="fas fa-check-circle"></i> Markeren als Bezorgd
                    </button>
                </form>
            </div>
        @endif

        <div style="margin-top: 24px;">
            <a href="{{ route('koerier') }}" class="btn secondary">
                <i class="fas fa-arrow-left"></i> Terug naar Koerier Dashboard
            </a>
        </div>
    </div>
@endsection
