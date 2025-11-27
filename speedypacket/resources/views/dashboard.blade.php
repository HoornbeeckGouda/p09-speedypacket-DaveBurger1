@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="card" style="max-width:900px;margin:0 auto;">
        <h2 style="margin-top:0">Dashboard</h2>
        <p style="color:var(--muted)">Welkom terug, {{ auth()->user()->name }}. Gebruik het menu of de links hieronder.</p>

        <div style="display:grid;grid-template-columns:1fr 280px;gap:18px;margin-top:18px">
            <div>
                <section style="margin-top:6px">
                    <h4>Acties</h4>
                    <ul style="color:var(--muted)">
                        <li><a href="{{ route('profile') }}">Bekijk profiel</a></li>
                        @if(auth()->user()->role === 'directie')
                            <li><a href="{{ route('directie') }}">Directie Home</a></li>
                        @endif
                        <li>Bekijk rapportages (nog te implementeren)</li>
                    </ul>
                </section>
            </div>

            <aside>
                <div style="background:#fff;border:1px solid #eef2ff;border-radius:10px;padding:12px">
                    <strong>Snel</strong>
                    <div style="margin-top:8px;color:var(--muted)">
                        Uitloggen via knop in de header.
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
