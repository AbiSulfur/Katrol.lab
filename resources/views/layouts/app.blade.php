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
<body class="min-h-screen bg-[#080808] text-[#F0EDE7] antialiased flex flex-col font-sans select-none selection:bg-[#FF4D00] selection:text-[#080808]">

    <!-- ======================================================
         HEADER: Solid black, Cuberto-signature, no blur
         ====================================================== -->
    <header class="sticky top-0 z-50 h-14 bg-[#080808] border-b border-[#303030] flex items-center no-print">
        <div class="max-w-[1600px] w-full mx-auto px-5 flex items-center justify-between gap-3">

            <!-- Brand -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0 no-underline group">
                <svg width="34" height="34" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0 transition-transform duration-200 group-hover:scale-105">
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
                    <div class="font-display font-extrabold text-[15px] text-[#F0EDE7] tracking-tight leading-none">Katrol.Lab</div>
                    <div class="font-mono text-[9px] font-semibold tracking-widest uppercase text-[#585450] mt-0.5">Simulator Nilai Guru</div>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="flex items-center gap-1.5">
                <a href="{{ route('home') }}" class="font-display text-xs font-semibold px-3 py-1.5 rounded transition-all duration-200 {{ request()->routeIs('home') ? 'text-[#FF4D00] bg-[#FF4D00]/15 border border-[#FF4D00]/30' : 'text-[#A8A39A] hover:text-[#F0EDE7] hover:bg-[#1a1a1a] border border-transparent' }}">
                    Beranda
                </a>
                <a href="{{ route('simulator.index') }}" class="font-display text-xs font-semibold px-3 py-1.5 rounded transition-all duration-200 {{ (request()->routeIs('simulator.index') || request()->routeIs('simulator.view')) ? 'text-[#FF4D00] bg-[#FF4D00]/15 border border-[#FF4D00]/30' : 'text-[#A8A39A] hover:text-[#F0EDE7] hover:bg-[#1a1a1a] border border-transparent' }}">
                    Simulator
                </a>
                <a href="{{ route('profil.index') }}" class="font-display text-xs font-semibold px-3 py-1.5 rounded transition-all duration-200 {{ request()->routeIs('profil.index') ? 'text-[#FF4D00] bg-[#FF4D00]/15 border border-[#FF4D00]/30' : 'text-[#A8A39A] hover:text-[#F0EDE7] hover:bg-[#1a1a1a] border border-transparent' }}">
                    Profil Guru
                </a>
            </nav>

            <!-- Header actions slot -->
            <div class="flex items-center gap-2">
                @php
                    $navProfil = \App\Models\ProfilGuru::first();
                @endphp
                @if($navProfil && !empty($navProfil->nama))
                    <a href="{{ route('profil.index') }}" title="Profil Guru: {{ $navProfil->nama }}" class="inline-flex items-center gap-2 px-2.5 py-1 bg-[#1a1a1a] border border-[#303030] text-inherit no-underline rounded hover:border-[#FF4D00]/40 transition-colors">
                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-[#FF4D00] text-[#080808] text-[10px] font-extrabold font-mono">
                            {{ strtoupper(substr($navProfil->nama, 0, 1)) }}
                        </span>
                        <span class="text-xs font-semibold text-[#F0EDE7] max-w-[120px] truncate hidden sm:inline">
                            {{ $navProfil->nama }}
                        </span>
                    </a>
                @endif
                @yield('header_actions')
            </div>

        </div>
    </header>

    <!-- ======================================================
         MAIN CONTENT / WORKBENCH
         ====================================================== -->
    <main class="flex-1 min-h-0 flex flex-col h-[calc(100dvh-3.5rem)] overflow-hidden">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
