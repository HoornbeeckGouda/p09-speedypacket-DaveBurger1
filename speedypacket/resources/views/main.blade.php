@extends('layouts.app')

@section('title', 'Main')

@section('content')
    <h2>Welkom bij SpeedyPacket</h2>
    <p>Dit is de hoofdpagina van de demo-app. Gebruik de link rechtsboven om in te loggen.</p>

    <section style="margin-top:20px">
        <h3>Wat kun je hier doen?</h3>
        <ul>
            <li>Snel testen van routes en views</li>
            <li>Voorbeeldpagina's maken</li>
        </ul>
    </section>

    <p style="margin-top:18px"><a class="btn" href="{{ route('login') }}">Naar inlogpagina</a></p>
@endsection
