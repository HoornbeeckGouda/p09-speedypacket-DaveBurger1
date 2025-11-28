@extends('layouts.app')

@section('title', 'Mijn Verzendingen')

@section('content')
    <div class="card">
        <h2 style="margin-bottom: 24px;"><i class="fas fa-list"></i> Mijn Verzendingen</h2>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 18px; border: 1px solid #a7f3d0;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($packages->isEmpty())
            <div style="text-align: center; padding: 48px; color: var(--muted);">
                <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px;"></i>
                <p>Je hebt nog geen verzendingen aangemaakt.</p>
                <a href="{{ route('nieuwe-verzending') }}" class="btn" style="margin-top: 16px;">
                    <i class="fas fa-plus-circle"></i> Eerste Verzending Aanmaken
                </a>
            </div>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 24px;">
                    <thead>
                        <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                            <th style="padding: 12px; text-align: left; font-weight: 600;">Tracking Nummer</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600;">Ontvanger</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600;">Status</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600;">Koerier</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600;">Gewicht</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600;">Aangemaakt</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600;">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $package)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 12px;">{{ $package->tracking_number }}</td>
                                <td style="padding: 12px;">
                                    {{ $package->recipient_name }}<br>
                                    <small style="color: var(--muted);">{{ $package->recipient_address }}</small>
                                </td>
                                <td style="padding: 12px;">
                                    @if($package->status === 'pending')
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
                                    @endif
                                </td>
                                <td style="padding: 12px;">{{ $package->koerier ? $package->koerier->name : 'Nog niet toegewezen' }}</td>
                                <td style="padding: 12px;">{{ $package->weight ? $package->weight . ' kg' : '-' }}</td>
                                <td style="padding: 12px;">{{ $package->created_at->format('d-m-Y H:i') }}</td>
                                <td style="padding: 12px;">
                                    <a href="{{ route('pakketten-volgen', ['tracking_number' => $package->tracking_number]) }}" class="btn secondary" style="font-size: 12px; padding: 6px 12px;">
                                        <i class="fas fa-search"></i> Volgen
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="display: flex; gap: 12px;">
                <a href="{{ route('nieuwe-verzending') }}" class="btn">
                    <i class="fas fa-plus-circle"></i> Nieuwe Verzending
                </a>
                <a href="{{ route('dashboard') }}" class="btn secondary">
                    <i class="fas fa-arrow-left"></i> Terug naar Dashboard
                </a>
            </div>
        @endif
    </div>
@endsection
