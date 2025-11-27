@extends('layouts.app')

@section('title', 'Inloggen')

@section('content')
    <h2>Inloggen</h2>
    <p>Voer je gegevens in om in te loggen.</p>

    @if($errors->any())
        <div style="color:#b00020; margin-bottom:12px">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.attempt') }}" style="max-width:420px">
        @csrf

        <label for="username">Gebruikersnaam</label><br />
        <input id="username" name="username" type="text" value="{{ old('username') }}" placeholder="gebruikersnaam" style="width:100%" />

        <label for="password" style="margin-top:8px; display:block">Wachtwoord</label>
        <input id="password" name="password" type="password" placeholder="Wachtwoord" style="width:100%" />

        <button type="submit" class="btn" style="margin-top:12px">Inloggen</button>
    </form>

    <p style="margin-top:12px"><a href="{{ url('/') }}">Terug naar Home</a></p>
@endsection
