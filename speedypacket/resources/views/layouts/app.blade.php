<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SpeedyPacket - @yield('title', 'Home')</title>
    <style>
        body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; margin:0; padding:0; background:#f7f7fb; color:#222 }
        .container { max-width:900px; margin:32px auto; padding:20px; background:#fff; border-radius:8px; box-shadow:0 6px 18px rgba(0,0,0,0.06)}
        header { display:flex; justify-content:space-between; align-items:center }
        nav a { margin-left:12px; color:#0b5fff; text-decoration:none }
        .btn { display:inline-block; padding:8px 12px; background:#0b5fff; color:#fff; border-radius:6px; text-decoration:none }
        form input, form button { font-size:16px; padding:8px; margin-top:6px }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div>
                <h1 style="margin:0; font-size:20px">SpeedyPacket</h1>
                <div style="font-size:12px; color:#666">Een eenvoudige demo-app</div>
            </div>
            <nav>
                <a href="{{ url('/') }}">Home</a>
                @auth
                    <span style="margin-left:12px">Welkom, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button class="btn" type="submit" style="margin-left:12px">Uitloggen</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Inloggen</a>
                @endauth
            </nav>
        </header>

        <main style="margin-top:20px">
            @yield('content')
        </main>
    </div>
</body>
</html>
