@extends('layouts.app')

@section('title', 'Two-Factor Authentication')

@section('content')
    <div class="card" style="max-width:640px;margin:0 auto;">
        <div style="max-width:400px;margin:0 auto;">
            <h2 style="margin-top:0">Two-Factor Authentication</h2>
            <p style="color:var(--muted)">Voer de verificatiecode in die naar je e-mail is gestuurd.</p>

            @if($errors->any())
                <div style="color:#b00020;margin-top:10px">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('verify.twofactor') }}" style="margin-top:12px">
                @csrf

                <label for="code">Verificatiecode</label>
                <div class="form-row"><input id="code" name="code" type="text" placeholder="123456" required /></div>

                <div style="margin-top:14px">
                    <button type="submit" class="btn">Verifiëren</button>
                    <a href="{{ route('login') }}" class="btn secondary" style="margin-left:8px">Terug</a>
                </div>
            </form>
        </div>
    </div>
@endsection
