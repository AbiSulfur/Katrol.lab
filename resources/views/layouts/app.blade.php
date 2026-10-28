<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('katrollab_dark') === 'true' }" :class="{ 'dark': darkMode }" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Katrol.Lab - Simulator Katrol & Bobot Nilai')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800&family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 flex flex-col antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Brand & Tagline -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-indigo-600 dark:bg-indigo-500 flex items-center justify-center text-white font-display font-black text-xl shadow-hard-sm">
                        K
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="font-display font-extrabold text-xl tracking-tight text-slate-900 dark:text-white">Katrol.Lab</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900/60 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                Laravel 12
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 hidden sm:block">
                            Simulator Katrol &amp; Bobot Nilai Guru Indonesia
                        </p>
                    </div>
                </div>

                <!-- Navigation Controls -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    
                    <!-- Indikator Database SQLite -->
                    <div class="hidden md:flex items-center space-x-1.5 px-2.5 py-1 rounded-md bg-slate-100 dark:bg-slate-800 text-xs font-mono text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>SQLite DB</span>
                    </div>

                    <!-- Tombol Ganti Tema (Dark / Light) -->
                    <button 
                        type="button"
                        @click="darkMode = !darkMode; localStorage.setItem('katrollab_dark', darkMode)"
                        class="p-2 rounded-lg text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                        title="Alihkan tema gelap / terang"
                    >
                        <template x-if="!darkMode">
                            <!-- Icon Bulan -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </template>
                        <template x-if="darkMode">
                            <!-- Icon Matahari -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </template>
                    </button>

                    <!-- Tombol Reset / Isi Data Contoh -->
                    @yield('header_actions')
                </div>

            </div>
        </div>
    </header>

    <!-- Main Content Slot -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="no-print mt-auto border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 py-6 text-sm text-slate-500 dark:text-slate-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-2">
                <span class="font-display font-bold text-slate-700 dark:text-slate-300">Katrol.Lab v2.0</span>
                <span>&bull;</span>
                <span>Arsitektur Laravel 12 + Tailwind CSS + Alpine.js</span>
            </div>
            <div class="text-xs text-slate-400 dark:text-slate-500">
                Penyimpanan ganda: SQLite Database &amp; LocalStorage Browser.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
