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
        html, body{scroll-behavior: smooth; overflow-x: hidden}
        html{overflow-y: auto}
        body{font-family:Inter, system-ui, -apple-system, "Segoe UI", Roboto, Arial; margin:0; padding:0; background:linear-gradient(to bottom right, #dbeafe, #bfdbfe); color:#111}
        .wrap{width:100%;max-width:1200px;margin:0 auto;padding:34px}
        .card{background:#fff;border-radius:12px;padding:24px;box-shadow:0 8px 24px rgba(15,23,42,0.06);width:100%;box-sizing:border-box}
        header{display:flex;align-items:center;justify-content:space-between}
        .brand h1{margin:0;font-size:20px}
        .brand p{margin:2px 0 0;font-size:13px;color:var(--muted)}
        nav{display:flex;align-items:center}
        nav a{color:var(--accent);text-decoration:none;margin-left:16px;font-weight:500}
        .btn{display:inline-block;padding:8px 14px;background:var(--accent);color:#fff;border-radius:8px;text-decoration:none;border:none;cursor:pointer}
        .btn.secondary{background:transparent;color:var(--accent);border:1px solid rgba(11,95,255,0.12)}
        .logout-btn{padding:6px 12px;font-size:14px;margin-left:8px;border-radius:6px;background:rgba(255,255,255,0.1);color:#fff;border:1px solid rgba(255,255,255,0.3);transition:all 0.3s ease}
        .logout-btn:hover{background:rgba(255,255,255,0.2);border-color:rgba(255,255,255,0.5);color:#fff}
        input[type="text"], input[type="password"], input[type="email"], textarea{width:100%;padding:10px 12px;border:1px solid #e6eef8;border-radius:8px;background:#fbfdff;font-size:15px}
        input:focus, textarea:focus{outline:none;border-color:var(--accent);box-shadow:0 6px 18px rgba(11,95,255,0.08)}
        label{font-size:14px;color:#111;display:block;margin-top:12px}
        .form-row{margin-top:8px}
        main{margin-top:18px}
        .alert{background:#fef3c7;color:#92400e;padding:12px 16px;border-radius:8px;margin-bottom:16px;border-left:4px solid #f59e0b}
        .alert.error{background:#fee2e2;color:#991b1b;border-left-color:#dc2626}
        .alert.success{background:#d1fae5;color:#065f46;border-left-color:#10b981}

        /* mobile toggle and menu (hidden by default on desktop) */
        .mobile-toggle{display:none;background:transparent;border:0;font-size:20px;cursor:pointer;padding:6px}
        .mobile-menu{display:none;background:#fff;border-radius:8px;padding:12px;box-shadow:0 8px 24px rgba(15,23,42,0.06);margin-top:6px}
        .mobile-menu a{display:block;color:var(--accent);text-decoration:none;margin:8px 0;font-weight:600}
        .mobile-menu .btn{display:block;width:100%;text-align:center}

        @media (max-width: 640px) {
            main{margin-top:0}
            header{display:flex;flex-direction:column;align-items:flex-start;gap:8px;padding:12px}
            /* hide desktop nav on small screens and show mobile toggle */
            .desktop-nav{display:none}
            .mobile-toggle{display:inline-flex}
            .mobile-menu{display:none;width:100%}
            .mobile-menu.open{display:block}
            .wrap{padding:0}
            .card{background:none;border:none;padding:0;margin:0}
            #koerier-page{background:#fff;border-radius:0;padding:16px;margin:0}
            #koerier-grid{grid-template-columns:1fr !important;gap:0 !important}
            #map{height:300px !important;width:100% !important;display:block !important}
            div[style*="height: 400px"]{height:300px !important}
        }
    </style>
</head>
<body>
    <div class="wrap">
        <header>
            <button class="mobile-toggle" aria-expanded="false" aria-label="Open menu">☰</button>

            <nav class="desktop-nav">
            </nav>

            {{-- Mobile menu (duplicate links for mobile toggle) --}}
            <div class="mobile-menu" aria-hidden="true">
                @guest
                    <a href="{{ route('login') }}">Login</a>
                @endguest
                @auth
                    <a href="{{ url('/') }}">Home</a>
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" style="margin-top:8px">
                        @csrf
                        <button class="btn logout-btn" type="submit" data-route="{{ Route::currentRouteName() }}">Uitloggen</button>
                    </form>
                @endauth
            </div>
        </header>

        <main>
            @if(session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert error">{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            var btn = document.querySelector('.mobile-toggle');
            var menu = document.querySelector('.mobile-menu');
            if(!btn || !menu) return;
            btn.addEventListener('click', function(){
                var open = menu.classList.toggle('open');
                btn.setAttribute('aria-expanded', open);
                menu.setAttribute('aria-hidden', !open);
                btn.textContent = open ? '✕' : '☰';
            });
        });
    </script>
</body>
</html>
