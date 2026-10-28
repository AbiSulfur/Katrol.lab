<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Katrol.Lab - Simulator Katrol & Bobot Nilai')</title>

    <!-- Favicon & App Icons -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

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
            <a href="/" style="display:flex; align-items:center; gap:12px; flex-shrink:0; text-decoration:none;">
                <svg width="34" height="34" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;">
                    <rect width="64" height="64" rx="4" fill="#0E0E0E"/>
                    <rect x="0.5" y="0.5" width="63" height="63" rx="3.5" stroke="#262626"/>
                    <rect x="13.5" y="11" width="6.5" height="42" rx="1.8" fill="#F0EDE7"/>
                    <rect x="7" y="32" width="11" height="3" rx="1.2" fill="#4BFFA0"/>
                    <circle cx="36" cy="33" r="13" fill="#181818" stroke="#FF4D00" stroke-width="3.5"/>
                    <circle cx="36" cy="33" r="7.5" stroke="#2E2E2E" stroke-width="1.6"/>
                    <circle cx="36" cy="33" r="4.2" fill="#FF4D00"/>
                    <circle cx="36" cy="33" r="1.6" fill="#0E0E0E"/>
                    <path d="M 36 20 L 50.5 11.5" stroke="#FF4D00" stroke-width="4.5" stroke-linecap="round"/>
                    <path d="M 44.5 9.5 L 53.5 10 L 52 19" fill="none" stroke="#FF4D00" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M 36 46 L 50.5 54.5" stroke="#F0EDE7" stroke-width="4.5" stroke-linecap="round"/>
                    <rect x="47.5" y="50" width="8" height="8" rx="1.8" fill="#FF4D00"/>
                </svg>
                <div>
                    <div style="font-family:var(--font-display); font-weight:800; font-size:15px; color:var(--paper); letter-spacing:-0.02em; line-height:1;">Katrol.Lab</div>
                    <div class="label-caps" style="margin-top:1px;">Simulator Nilai Guru</div>
                </div>
            </a>

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
