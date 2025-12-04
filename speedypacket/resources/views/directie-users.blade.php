@extends('layouts.app')

@section('title', 'Gebruikers Beheer')

@section('content')
    <div class="card" style="width:100%;max-width:none;margin:0;padding:24px;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.1)">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
            <div>
                <h2 style="margin-top:0;margin-bottom:8px;font-size:32px;font-weight:700">Gebruikers Beheer</h2>
                <p style="color:var(--muted);margin-bottom:0;font-size:16px">Beheer alle gebruikers in het systeem.</p>
            </div>
            <a href="{{ route('directie.users.create') }}" style="display:inline-block;padding:12px 24px;background:#10b981;color:white;text-decoration:none;border-radius:8px;font-weight:500">Nieuwe Gebruiker</a>
        </div>

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

        <div style="background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.1)">
            <table style="width:100%;border-collapse:collapse">
                <thead style="background:#f9fafb;text-align:left">
                    <tr>
                        <th style="padding:16px;font-weight:600;color:#374151;font-size:14px">ID</th>
                        <th style="padding:16px;font-weight:600;color:#374151;font-size:14px">Naam</th>
                        <th style="padding:16px;font-weight:600;color:#374151;font-size:14px">Gebruikersnaam</th>
                        <th style="padding:16px;font-weight:600;color:#374151;font-size:14px">Email</th>
                        <th style="padding:16px;font-weight:600;color:#374151;font-size:14px">Rol</th>
                        <th style="padding:16px;font-weight:600;color:#374151;font-size:14px">Locatie</th>
                        <th style="padding:16px;font-weight:600;color:#374151;font-size:14px">Acties</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr style="border-top:1px solid #f3f4f6">
                        <td style="padding:16px;color:#111827">{{ $user->id }}</td>
                        <td style="padding:16px;color:#111827">{{ $user->name }}</td>
                        <td style="padding:16px;color:#111827">{{ $user->username }}</td>
                        <td style="padding:16px;color:#111827">{{ $user->email }}</td>
                        <td style="padding:16px;color:#111827">{{ $user->role }}</td>
                        <td style="padding:16px;color:#111827">{{ $user->location ?? 'Niet opgegeven' }}</td>
                        <td style="padding:16px;color:#111827">
                            <div style="display:flex;gap:8px">
                                <a href="{{ route('directie.user', $user->id) }}" style="background:none;border:none;cursor:pointer;color:#0b5fff;font-size:14px;text-decoration:none;">
                                    <i class="fas fa-eye"></i> Bekijken
                                </a>
                                <a href="{{ route('directie.users.edit', $user->id) }}" style="background:none;border:none;cursor:pointer;color:#f59e0b;font-size:14px;text-decoration:none;">
                                    <i class="fas fa-edit"></i> Bewerken
                                </a>
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('directie.users.destroy', $user->id) }}" style="display:inline" onsubmit="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background:none;border:none;cursor:pointer;color:#ef4444;font-size:14px;text-decoration:none;">
                                            <i class="fas fa-trash"></i> Verwijderen
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding:32px;text-align:center;color:#6b7280">Geen gebruikers gevonden.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:24px;text-align:center">
            {{ $users->links() }}
        </div>

        <div style="margin-top:24px;text-align:center">
            <a href="{{ route('directie') }}" style="display:inline-block;padding:12px 24px;background:#6b7280;color:white;text-decoration:none;border-radius:8px;font-weight:500">Terug naar Directie Dashboard</a>
        </div>
    </div>
@endsection
