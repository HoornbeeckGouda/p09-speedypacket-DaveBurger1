@extends('layouts.app')

@section('title', 'Main')

@section('content')
    <div class="card">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap">
            <div style="flex:1;min-width:220px">
                <h2 style="margin-top:0">Welkom bij SpeedyPacket</h2>
                <p style="color:var(--muted)">Een kleine demo-app om gebruikers, rollen en eenvoudige taken te tonen.</p>
                <p style="margin-top:12px;color:var(--muted)">Om in te loggen ga naar <a href="/login" style="color:var(--accent)">/login</a>.</p>
            </div>

            <div style="width:300px;min-width:220px">
                <div style="background:#f8fafc;border-radius:10px;padding:12px">
                    <strong>Quick links</strong>
                    <ul style="margin:8px 0 0;padding-left:18px;color:var(--muted)">
                        <li>Bekijk gebruikers (dev)</li>
                        <li>Seed & migrate database</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
