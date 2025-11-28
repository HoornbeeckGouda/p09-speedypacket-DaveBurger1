@extends('layouts.app')

@section('title', 'Inloggen')

@section('content')
    <div class="card" style="max-width:640px;margin:0 auto;">
        <div style="max-width:400px;margin:0 auto;">
            <h2 style="margin-top:0">Inloggen</h2>
            <p style="color:var(--muted)">Voer je gebruikersnaam en wachtwoord in om door te gaan.</p>

            @if($errors->any())
                <div style="color:#b00020;margin-top:10px">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" style="margin-top:12px">
                @csrf

                <label for="username">Gebruikersnaam</label>
                <div class="form-row"><input id="username" name="username" type="text" value="{{ old('username') }}" placeholder="gebruikersnaam of e-mail" /></div>

                <label for="password">Wachtwoord</label>
                <div class="form-row"><input id="password" name="password" type="password" placeholder="Wachtwoord" /></div>

                <div style="margin-top:14px">
                    <button type="submit" class="btn">Inloggen</button>
                    <a href="{{ url('/') }}" class="btn secondary" style="margin-left:8px">Terug</a>
                </div>
            </form>
        </div>
    </div>
@endsection
