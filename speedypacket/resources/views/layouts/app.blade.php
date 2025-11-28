<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SpeedyPacket - @yield('title', 'Home')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root{--accent:#0b5fff;--muted:#6b7280;--bg:#f3f4f6}
        *{box-sizing:border-box}
        body{font-family:Inter, system-ui, -apple-system, "Segoe UI", Roboto, Arial; margin:0; padding:0; background:var(--bg); color:#111}
        .wrap{max-width:980px;margin:34px auto;padding:18px}
        .card{background:#fff;border-radius:12px;padding:24px;box-shadow:0 8px 24px rgba(15,23,42,0.06);width:100%;box-sizing:border-box}
        header{display:flex;align-items:center;justify-content:space-between}
        .brand h1{margin:0;font-size:20px}
        .brand p{margin:2px 0 0;font-size:13px;color:var(--muted)}
        nav{display:flex;align-items:center}
        nav a{color:var(--accent);text-decoration:none;margin-left:16px;font-weight:500}
        .btn{display:inline-block;padding:8px 14px;background:var(--accent);color:#fff;border-radius:8px;text-decoration:none;border:none;cursor:pointer}
        .btn.secondary{background:transparent;color:var(--accent);border:1px solid rgba(11,95,255,0.12)}
        input[type="text"], input[type="password"], input[type="email"], textarea{width:100%;padding:10px 12px;border:1px solid #e6eef8;border-radius:8px;background:#fbfdff;font-size:15px}
        input:focus, textarea:focus{outline:none;border-color:var(--accent);box-shadow:0 6px 18px rgba(11,95,255,0.08)}
        label{font-size:14px;color:#111;display:block;margin-top:12px}
        .form-row{margin-top:8px}
        main{margin-top:18px}
        @media (max-width:640px){.wrap{margin:18px;padding:12px}.card{padding:16px}}
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div>
                
            </div>
            <nav>
                @guest
                    <a href="{{ route('login') }}">Login</a>
                @endguest
                @auth
                    <a href="{{ url('/') }}">Home</a>
                    <a href="{{ route('dashboard') }}" style="margin-left:16px">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button class="btn" type="submit" style="margin-left:12px">Uitloggen</button>
                    </form>
                @endauth
            </nav>
        </header>

        <main>
            @yield('content')
        </main>
    </div>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</body>
</html>
