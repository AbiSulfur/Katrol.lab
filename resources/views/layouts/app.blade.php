<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Katrol.Lab - Simulator Katrol & Bobot Nilai')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,700;12..96,800&family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-shell">

    <!-- ======================================================
         HEADER — Solid black, Cuberto-signature, no blur
         ====================================================== -->
    <header class="site-header no-print" x-data="{}">
        <div style="max-width:1600px; width:100%; margin:0 auto; padding:0 20px; display:flex; align-items:center; justify-content:space-between; gap:12px;">

            <!-- Brand -->
            <div style="display:flex; align-items:center; gap:12px; flex-shrink:0;">
                <div class="logo-mark">K</div>
                <div>
                    <div style="font-family:var(--font-display); font-weight:800; font-size:15px; color:var(--paper); letter-spacing:-0.02em; line-height:1;">Katrol.Lab</div>
                    <div class="label-caps" style="margin-top:1px;">Simulator Nilai Guru</div>
                </div>
            </div>

            <!-- Header actions slot -->
            <div style="display:flex; align-items:center; gap:8px;">
                @yield('header_actions')
            </div>

        </div>
    </header>

    <!-- ======================================================
         MAIN WORKBENCH
         ====================================================== -->
    <div class="workbench" style="height: calc(100dvh - var(--header-h));">
        @yield('content')
    </div>

    <!-- Footer tidak ditampilkan di workbench layout -->
    <footer class="no-print" style="display:none;"></footer>

    @stack('scripts')
</body>
</html>
