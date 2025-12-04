@extends('layouts.app')

@section('title', 'Nieuwe Gebruiker Aanmaken')

@section('content')
    <div class="card" style="width:100%;max-width:600px;margin:0 auto;padding:24px;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.1)">
        <h2 style="margin-top:0;margin-bottom:8px;font-size:32px;font-weight:700">Nieuwe Gebruiker Aanmaken</h2>
        <p style="color:var(--muted);margin-bottom:24px;font-size:16px">Maak een nieuwe gebruiker aan voor het systeem.</p>

        @if($errors->any())
            <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:8px;margin-bottom:16px;border:1px solid #fecaca">
                <ul style="margin:0;padding-left:16px">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('directie.users.store') }}" style="background:#fff;border-radius:12px;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,0.1)">
            @csrf

            <div style="margin-bottom:16px">
                <label for="name" style="display:block;font-weight:600;color:#374151;margin-bottom:4px">Naam *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required style="width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:16px">
            </div>

            <div style="margin-bottom:16px">
                <label for="username" style="display:block;font-weight:600;color:#374151;margin-bottom:4px">Gebruikersnaam *</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required style="width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:16px">
            </div>

            <div style="margin-bottom:16px">
                <label for="email" style="display:block;font-weight:600;color:#374151;margin-bottom:4px">Email *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required style="width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:16px">
            </div>

            <div style="margin-bottom:16px">
                <label for="password" style="display:block;font-weight:600;color:#374151;margin-bottom:4px">Wachtwoord *</label>
                <input type="password" id="password" name="password" required style="width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:16px">
            </div>

            <div style="margin-bottom:16px">
                <label for="role" style="display:block;font-weight:600;color:#374151;margin-bottom:4px">Rol *</label>
                <select id="role" name="role" required style="width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:16px">
                    <option value="">Selecteer een rol</option>
                    <option value="directie" {{ old('role') == 'directie' ? 'selected' : '' }}>Directie</option>
                    <option value="koerier" {{ old('role') == 'koerier' ? 'selected' : '' }}>Koerier</option>
                    <option value="ontvanger" {{ old('role') == 'ontvanger' ? 'selected' : '' }}>Ontvanger</option>
                    <option value="magazijn" {{ old('role') == 'magazijn' ? 'selected' : '' }}>Magazijn</option>
                    <option value="backoffice" {{ old('role') == 'backoffice' ? 'selected' : '' }}>Backoffice</option>
                </select>
            </div>



            <div style="display:flex;gap:12px">
                <button type="submit" style="flex:1;padding:12px;background:#10b981;color:white;border:none;border-radius:8px;font-weight:500;font-size:16px;cursor:pointer">Gebruiker Aanmaken</button>
                <a href="{{ route('directie.users') }}" style="flex:1;padding:12px;background:#6b7280;color:white;text-decoration:none;border-radius:8px;font-weight:500;font-size:16px;text-align:center">Annuleren</a>
            </div>
        </form>
    </div>
@endsection
