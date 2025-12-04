@extends('layouts.app')

@section('title', 'Gebruiker Bewerken')

@section('content')
    <div class="card" style="width:100%;max-width:600px;margin:0 auto;padding:24px;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.1)">
        <h2 style="margin-top:0;margin-bottom:8px;font-size:32px;font-weight:700">Gebruiker Bewerken</h2>
        <p style="color:var(--muted);margin-bottom:24px;font-size:16px">Bewerk de gegevens van deze gebruiker.</p>

        @if(session('success'))
            <div style="background:#d1fae5;color:#065f46;padding:12px;border-radius:8px;margin-bottom:16px;border:1px solid #a7f3d0">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:8px;margin-bottom:16px;border:1px solid #fecaca">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:8px;margin-bottom:16px;border:1px solid #fecaca">
                <ul style="margin:0;padding-left:16px">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('directie.users.update', $viewedUser->id) }}" style="background:#fff;border-radius:12px;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,0.1)">
            @csrf
            @method('PUT')

            <div style="margin-bottom:16px">
                <label for="name" style="display:block;font-weight:600;color:#374151;margin-bottom:4px">Naam</label>
                <input type="text" id="name" name="name" value="{{ old('name', $viewedUser->name) }}" required style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">
            </div>

            <div style="margin-bottom:16px">
                <label for="username" style="display:block;font-weight:600;color:#374151;margin-bottom:4px">Gebruikersnaam</label>
                <input type="text" id="username" name="username" value="{{ old('username', $viewedUser->username) }}" required style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">
            </div>

            <div style="margin-bottom:16px">
                <label for="email" style="display:block;font-weight:600;color:#374151;margin-bottom:4px">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $viewedUser->email) }}" required style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">
            </div>

            <div style="margin-bottom:16px">
                <label for="role" style="display:block;font-weight:600;color:#374151;margin-bottom:4px">Rol</label>
                <select id="role" name="role" required style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">
                    <option value="directie" {{ old('role', $viewedUser->role) == 'directie' ? 'selected' : '' }}>Directie</option>
                    <option value="koerier" {{ old('role', $viewedUser->role) == 'koerier' ? 'selected' : '' }}>Koerier</option>
                    <option value="ontvanger" {{ old('role', $viewedUser->role) == 'ontvanger' ? 'selected' : '' }}>Ontvanger</option>
                    <option value="magazijn" {{ old('role', $viewedUser->role) == 'magazijn' ? 'selected' : '' }}>Magazijn</option>
                    <option value="backoffice" {{ old('role', $viewedUser->role) == 'backoffice' ? 'selected' : '' }}>Backoffice</option>
                </select>
            </div>

            <div style="margin-bottom:16px">
                <label for="location" style="display:block;font-weight:600;color:#374151;margin-bottom:4px">Locatie</label>
                <input type="text" id="location" name="location" value="{{ old('location', $viewedUser->location) }}" style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">
            </div>

            <div style="margin-bottom:24px">
                <label for="password" style="display:block;font-weight:600;color:#374151;margin-bottom:4px">Nieuw wachtwoord (laat leeg om niet te wijzigen)</label>
                <input type="password" id="password" name="password" style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">
            </div>

            <div style="display:flex;gap:12px">
                <button type="submit" style="flex:1;padding:12px 24px;background:#0b5fff;color:white;border:none;border-radius:8px;font-weight:500;cursor:pointer">Opslaan</button>
                <a href="{{ route('directie.user', $viewedUser->id) }}" style="flex:1;padding:12px 24px;background:#6b7280;color:white;text-decoration:none;border-radius:8px;font-weight:500;text-align:center">Annuleren</a>
            </div>
        </form>
    </div>
@endsection
