@extends('layouts.app')

@section('title', 'Inloggen')

@section('content')
    <div class="card" style="max-width:640px;margin:0 auto;">
        <div style="display:flex;gap:20px;align-items:flex-start;flex-wrap:wrap">
            <div style="flex:1;min-width:260px">
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

            <div style="width:260px;min-width:200px">
                <div style="background:#f8fafc;padding:12px;border-radius:8px">
                    <strong>Test-accounts</strong>
                    <div style="margin-top:8px;color:var(--muted)">
                        directie / password<br />
                        backoffice / password<br />
                        magazijn1 / password
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
