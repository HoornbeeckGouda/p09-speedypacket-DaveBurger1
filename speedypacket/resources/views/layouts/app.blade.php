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
        header{display:flex;align-items:center;justify-content:space-between;background:#fff;border-radius:12px;padding:12px 24px;margin-bottom:18px;box-shadow:0 4px 16px rgba(0,0,0,0.08)}
        .desktop-logout{display:flex;align-items:center}
        .brand h1{margin:0;font-size:20px}
        .brand p{margin:2px 0 0;font-size:13px;color:var(--muted)}
        nav{display:flex;align-items:center}
        nav a{color:var(--accent);text-decoration:none;margin-left:16px;font-weight:500}
        .btn{display:inline-block;padding:8px 14px;background:var(--accent);color:#fff;border-radius:8px;text-decoration:none;border:none;cursor:pointer}
        .btn.secondary{background:transparent;color:var(--accent);border:1px solid rgba(11,95,255,0.12)}
        .logout-btn{padding:6px 12px;font-size:14px;margin-left:8px;border-radius:6px;background:#fff;color:#0b5fff;border:1px solid #0b5fff;transition:all 0.3s ease}
        .logout-btn:hover{background:#0b5fff;color:#fff}
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

        .progress-bar-container { position: relative; margin-bottom: 24px; }
        .progress-bar { width: 100%; height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden; position: relative; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #3b82f6, #1d4ed8); border-radius: 4px; transition: width 0.3s ease; }
        .progress-33 { width: 33%; }
        .progress-66 { width: 66%; }
        .progress-100 { width: 100%; }
        .progress-labels { display: flex; justify-content: space-between; margin-top: 12px; position: relative; }
        .progress-labels span { font-size: 14px; color: #6b7280; font-weight: 500; position: relative; }
        .progress-labels span.active { color: #1d4ed8; font-weight: 600; }
        .progress-labels span.active::after { content: ''; position: absolute; bottom: -8px; left: 50%; transform: translateX(-50%); width: 8px; height: 8px; background: #1d4ed8; border-radius: 50%; }

        /* Enhanced form and card styles */
        .form-enhanced { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .input-enhanced { border: 2px solid #e2e8f0; border-radius: 8px; padding: 12px 16px; font-size: 16px; transition: all 0.3s ease; background: #ffffff; }
        .input-enhanced:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); outline: none; }
        .alert-enhanced { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 1px solid #f59e0b; border-radius: 8px; padding: 16px; color: #92400e; }
        .card-enhanced { background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .btn-enhanced { display: inline-flex; align-items: center; gap: 8px; padding: 12px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; border: none; cursor: pointer; }
        .btn-enhanced.secondary { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
        .btn-enhanced.secondary:hover { background: #e2e8f0; transform: translateY(-1px); }
        .grid-enhanced { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px; }
        .grid-item { background: rgba(255,255,255,0.8); padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0; }
        .qr-container { display: flex; justify-content: center; align-items: center; padding: 16px; background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; }
        .timeline-item { display: flex; align-items: flex-start; gap: 12px; padding: 12px; background: rgba(255,255,255,0.6); border-radius: 8px; border-left: 4px solid #10b981; }
        .timeline-dot { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; margin-top: 4px; }
        .timeline-content { flex: 1; }
        .timeline-icon { margin-top: 4px; color: #6b7280; }
        .package-details-card { position: relative; }
        .card-decoration { position: absolute; border-radius: 50%; opacity: 0.1; }
        .decoration-1 { width: 100px; height: 100px; background: #3b82f6; top: -20px; right: -20px; }
        .decoration-2 { width: 80px; height: 80px; background: #06b6d4; bottom: -15px; left: -15px; }
        .decoration-3 { width: 60px; height: 60px; background: #8b5cf6; top: 50%; left: 50%; transform: translate(-50%, -50%); }

        /* Floating particles animation */
        .floating-particles { position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; overflow: hidden; }
        .particle { position: absolute; border-radius: 50%; animation: float 6s ease-in-out infinite; }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

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
                @auth
                    <a href="{{ url('/') }}">Home</a>
                @endauth
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

            {{-- Desktop logout button --}}
            @auth
                <div class="desktop-logout">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="logout-btn" type="submit" data-route="{{ Route::currentRouteName() }}">
                            <i class="fas fa-sign-out-alt"></i> Uitloggen
                        </button>
                    </form>
                </div>
            @endauth
        </header>

        <main>
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
