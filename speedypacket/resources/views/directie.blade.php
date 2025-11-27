@extends('layouts.app')

@section('title', 'Directie Home')

@section('content')
    <div class="card" style="max-width:980px;margin:0 auto">
        <h2 style="margin-top:0">Directie — Overzicht</h2>
        <p style="color:var(--muted)">Hier vind je kernstatistieken en snelle links naar systeemonderdelen.</p>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:16px">
            <div style="background:#fff;padding:14px;border-radius:10px;box-shadow:inset 0 0 0 1px rgba(11,95,255,0.06)">
                <div style="font-size:20px;font-weight:700">{{ $totalUsers }}</div>
                <div style="color:var(--muted);margin-top:6px">Totaal gebruikers</div>
            </div>

            <div style="background:#fff;padding:14px;border-radius:10px;box-shadow:inset 0 0 0 1px rgba(11,95,255,0.06)">
                <div style="font-size:20px;font-weight:700">{{ $directieCount }}</div>
                <div style="color:var(--muted);margin-top:6px">Directie accounts</div>
            </div>

            <div style="background:#fff;padding:14px;border-radius:10px;box-shadow:inset 0 0 0 1px rgba(11,95,255,0.06)">
                <div style="font-size:20px;font-weight:700">{{ $otherCount }}</div>
                <div style="color:var(--muted);margin-top:6px">Overige accounts</div>
            </div>
        </div>

        <section style="margin-top:18px">
            <h4>Recente gebruikers</h4>
            <table style="width:100%;border-collapse:collapse;margin-top:8px">
                <thead style="text-align:left;color:var(--muted);font-size:13px">
                    <tr><th style="padding:8px;border-bottom:1px solid #eef2ff">Naam</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Gebruikersnaam</th><th style="padding:8px;border-bottom:1px solid #eef2ff">Rol</th></tr>
                </thead>
                <tbody>
                @foreach($recentUsers as $u)
                    <tr>
                        <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $u->name }}</td>
                        <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $u->username }}</td>
                        <td style="padding:8px;border-bottom:1px solid #f3f6ff">{{ $u->role }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
    </div>
@endsection
