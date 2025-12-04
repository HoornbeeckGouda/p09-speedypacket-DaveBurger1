@extends('layouts.app')

@section('title', 'Gebruiker Details')

@section('content')
    <div class="card" style="width:100%;max-width:800px;margin:0 auto;padding:24px;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.1)">
        <h2 style="margin-top:0;margin-bottom:8px;font-size:32px;font-weight:700">Gebruiker Details</h2>
        <p style="color:var(--muted);margin-bottom:24px;font-size:16px">Informatie over de geselecteerde gebruiker.</p>

        <div style="background:#fff;border-radius:12px;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,0.1)">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div>
                    <label style="font-weight:600;color:#374151">ID</label>
                    <p style="margin:4px 0;color:#111827">{{ $viewedUser->id }}</p>
                </div>
                <div>
                    <label style="font-weight:600;color:#374151">Naam</label>
                    <p style="margin:4px 0;color:#111827">{{ $viewedUser->name }}</p>
                </div>
                <div>
                    <label style="font-weight:600;color:#374151">Gebruikersnaam</label>
                    <p style="margin:4px 0;color:#111827">{{ $viewedUser->username }}</p>
                </div>
                <div>
                    <label style="font-weight:600;color:#374151">Email</label>
                    <p style="margin:4px 0;color:#111827">{{ $viewedUser->email }}</p>
                </div>
                <div>
                    <label style="font-weight:600;color:#374151">Rol</label>
                    <p style="margin:4px 0;color:#111827">{{ $viewedUser->role }}</p>
                </div>
                <div>
                    <label style="font-weight:600;color:#374151">Locatie</label>
                    <p style="margin:4px 0;color:#111827">{{ $viewedUser->location ?? 'Niet opgegeven' }}</p>
                </div>
                <div>
                    <label style="font-weight:600;color:#374151">Aangemaakt op</label>
                    <p style="margin:4px 0;color:#111827">{{ $viewedUser->created_at->format('d-m-Y H:i') }}</p>
                </div>
                <div>
                    <label style="font-weight:600;color:#374151">Laatst bijgewerkt</label>
                    <p style="margin:4px 0;color:#111827">{{ $viewedUser->updated_at->format('d-m-Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div style="margin-top:24px;text-align:center">
            <div style="display:flex;gap:12px;justify-content:center;margin-bottom:16px">
                <a href="{{ route('directie.users.edit', $viewedUser->id) }}" style="display:inline-block;padding:12px 24px;background:#0b5fff;color:white;text-decoration:none;border-radius:8px;font-weight:500">Gebruiker Bewerken</a>
            </div>
            <a href="{{ route('directie') }}" style="display:inline-block;padding:12px 24px;background:#9ca3af;color:white;text-decoration:none;border-radius:8px;font-weight:500">Terug naar Directie Dashboard</a>
        </div>
    </div>
@endsection
