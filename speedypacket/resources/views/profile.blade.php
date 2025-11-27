@extends('layouts.app')

@section('title', 'Profiel')

@section('content')
    <div class="card" style="max-width:760px;margin:0 auto">
        <h2 style="margin-top:0">Profiel</h2>
        <p style="color:var(--muted)">Hier staan je accountgegevens. Alleen zichtbaar voor jou.</p>

        <div style="background:#fbfdff;padding:14px;border-radius:10px;margin-top:12px">
            <div style="margin-bottom:8px"><strong>Naam:</strong> {{ auth()->user()->name }}</div>
            <div style="margin-bottom:8px"><strong>Gebruikersnaam:</strong> {{ auth()->user()->username }}</div>
            <div style="margin-bottom:8px"><strong>Email:</strong> {{ auth()->user()->email }}</div>
            <div style="margin-bottom:8px"><strong>Rol:</strong> {{ auth()->user()->role }}</div>
            <div style="margin-bottom:8px"><strong>Telefoon:</strong> {{ auth()->user()->phone ?? '-' }}</div>
            <div style="margin-bottom:8px"><strong>Adres:</strong> <div style="color:var(--muted);margin-top:6px">{{ auth()->user()->address ?? '-' }}</div></div>
        </div>

        <p style="margin-top:12px"><a href="{{ url()->previous() ?? url('/') }}" class="btn secondary">Terug</a></p>
    </div>
@endsection
