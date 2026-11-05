@extends('layouts.app')

@section('title', 'Beranda - Katrol.Lab Simulator Nilai Guru')

@section('header_actions')
    <a href="{{ route('simulator.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded bg-[#FF4D00] text-[#080808] font-sans text-xs font-bold hover:bg-[#FF6020] transition-all duration-150 shadow-lg shadow-[#FF4D00]/20">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="5 3 19 12 5 21 5 3"/>
        </svg>
        Buka Simulator
    </a>
@endsection

@section('content')
<div class="h-full overflow-y-auto px-4 sm:px-6 py-12 max-w-6xl mx-auto w-full">

    <!-- HERO SECTION -->
    <div class="text-center mb-14">
        <div class="font-mono text-[10px] font-semibold tracking-widest uppercase text-[#FF4D00] mb-3">Katrol.Lab Workbench v2.0</div>
        <h1 class="font-display text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-[#F0EDE7] tracking-tight leading-[1.1] max-w-3xl mx-auto mb-5">
            Atur bobot, uji katrol, lihat dampaknya sebelum nilai dikunci.
        </h1>
        <p class="text-base text-[#A8A39A] max-w-2xl mx-auto mb-8 leading-relaxed">
            Simulator kalkulasi nilai dan katrol untuk guru SMA dan SMK Indonesia. Hitung cepat proyeksi ketuntasan siswa dengan 4 metode matematis terukur sebelum nilai diserahkan ke raport.
        </p>
        <div class="flex items-center justify-center gap-3 flex-wrap">
            <a href="{{ route('simulator.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded bg-[#FF4D00] text-[#080808] font-sans text-sm font-bold hover:bg-[#FF6020] transition-all duration-150 shadow-lg shadow-[#FF4D00]/25 hover:-translate-y-0.5">
                Buka Simulator Sekarang
            </a>
            <a href="{{ route('profil.index') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded bg-[#1a1a1a] text-[#F0EDE7] border border-[#303030] font-sans text-sm font-semibold hover:bg-[#242424] hover:border-[#404040] transition-all duration-150 hover:-translate-y-0.5">
                Atur Profil Guru
            </a>
        </div>
    </div>

    <!-- PREVIEW STATISTIK MINI -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-12">
        <div class="bg-[#111111] border border-[#242424] rounded p-5 relative overflow-hidden group hover:border-[#303030] transition-colors">
            <div class="font-mono text-[10px] font-semibold tracking-widest uppercase text-[#585450] mb-2">Proyeksi Remedial</div>
            <div class="flex items-baseline gap-2.5">
                <span class="font-mono text-3xl font-extrabold text-[#FF4D4D]">7</span>
                <span class="text-[#585450] text-base">&rarr;</span>
                <span class="font-mono text-3xl font-extrabold text-[#4BFFA0]">2</span>
                <span class="text-xs text-[#4BFFA0] font-bold">(-71%)</span>
            </div>
            <div class="text-xs text-[#A8A39A] mt-2">Turun signifikan setelah katrol terukur</div>
        </div>

        <div class="bg-[#111111] border border-[#242424] rounded p-5 relative overflow-hidden group hover:border-[#303030] transition-colors">
            <div class="font-mono text-[10px] font-semibold tracking-widest uppercase text-[#585450] mb-2">Kenaikan Rata-Rata</div>
            <div class="flex items-baseline gap-2.5">
                <span class="font-mono text-3xl font-extrabold text-[#F0EDE7]">71.0</span>
                <span class="text-[#585450] text-base">&rarr;</span>
                <span class="font-mono text-3xl font-extrabold text-[#FF4D00]">79.5</span>
                <span class="text-xs text-[#FF4D00] font-bold">(+8.5)</span>
            </div>
            <div class="text-xs text-[#A8A39A] mt-2">Sebaran naik proporsional tanpa ada nilai turun</div>
        </div>

        <div class="bg-[#111111] border border-[#242424] rounded p-5 relative overflow-hidden group hover:border-[#303030] transition-colors sm:col-span-2 lg:col-span-1">
            <div class="font-mono text-[10px] font-semibold tracking-widest uppercase text-[#585450] mb-2">Kompatibilitas Format</div>
            <div class="font-display text-xl font-bold text-[#F0EDE7] mt-1.5">
                Ekspor CSV Raport
            </div>
            <div class="text-xs text-[#A8A39A] mt-2">Langsung buka di Microsoft Excel dengan UTF-8 BOM</div>
        </div>
    </div>

    <!-- TIGA MASALAH & TIGA CARA KERJA (BENTO GRID) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-12">
        
        <!-- Kolom Masalah -->
        <div class="bg-[#111111] border border-[#242424] rounded p-7">
            <div class="font-mono text-[10px] font-semibold tracking-widest uppercase text-[#FF6B6B] mb-3">Tiga Masalah Klasik Penilaian</div>
            <h3 class="font-display text-xl font-bold text-[#F0EDE7] mb-4">
                Mengapa Simulator Ini Diperlukan?
            </h3>
            <ul class="space-y-4">
                <li class="border-l-2 border-[#FF4D4D] pl-3">
                    <strong class="text-xs text-[#F0EDE7] block">1. Bobot Asal Pasang</strong>
                    <p class="text-xs text-[#A8A39A] mt-1 leading-relaxed">
                        Menetapkan bobot tanpa simulasi sering kali membuat nilai akhir anjlok mendadak karena satu ujian yang sulit.
                    </p>
                </li>
                <li class="border-l-2 border-[#FF4D4D] pl-3">
                    <strong class="text-xs text-[#F0EDE7] block">2. Katrol Subjektif</strong>
                    <p class="text-xs text-[#A8A39A] mt-1 leading-relaxed">
                        Menambah nilai tanpa formula transparan berisiko menimbulkan kecemburuan antar siswa dan melanggar objektivitas.
                    </p>
                </li>
                <li class="border-l-2 border-[#FF4D4D] pl-3">
                    <strong class="text-xs text-[#F0EDE7] block">3. Terlambat Tahu Dampak</strong>
                    <p class="text-xs text-[#A8A39A] mt-1 leading-relaxed">
                        Banyak guru baru menyadari 60% kelas remedial setelah nilai diserahkan ke bagian kurikulum sekolah.
                    </p>
                </li>
            </ul>
        </div>

        <!-- Kolom Cara Kerja -->
        <div class="bg-[#111111] border border-[#242424] rounded p-7">
            <div class="font-mono text-[10px] font-semibold tracking-widest uppercase text-[#4BFFA0] mb-3">Tiga Langkah Kerja</div>
            <h3 class="font-display text-xl font-bold text-[#F0EDE7] mb-4">
                Alur Praktis untuk Guru
            </h3>
            <ul class="space-y-4">
                <li class="border-l-2 border-[#4BFFA0] pl-3">
                    <strong class="text-xs text-[#F0EDE7] block">Langkah 1: Atur Standar & Bobot</strong>
                    <p class="text-xs text-[#A8A39A] mt-1 leading-relaxed">
                        Masukkan KKM target dan porsi bobot PH, PTS, serta PAS agar tepat 100%.
                    </p>
                </li>
                <li class="border-l-2 border-[#4BFFA0] pl-3">
                    <strong class="text-xs text-[#F0EDE7] block">Langkah 2: Masukkan Nilai Siswa</strong>
                    <p class="text-xs text-[#A8A39A] mt-1 leading-relaxed">
                        Ketik langsung pada tabel lembar nilai atau muat 12 data contoh standar untuk mulai simulasi.
                    </p>
                </li>
                <li class="border-l-2 border-[#4BFFA0] pl-3">
                    <strong class="text-xs text-[#F0EDE7] block">Langkah 3: Pilih Metode & Ekspor</strong>
                    <p class="text-xs text-[#A8A39A] mt-1 leading-relaxed">
                        Uji 4 metode katrol secara langsung, amati grafik sebaran nilai, lalu unduh berkas CSV.
                    </p>
                </li>
            </ul>
        </div>

    </div>

    <!-- METODE KATROL -->
    <div class="bg-[#111111] border border-[#242424] rounded p-7 mb-12">
        <div class="font-mono text-[10px] font-semibold tracking-widest uppercase text-[#FF4D00] mb-2.5">Empat Metode Katrol Matematis</div>
        <h3 class="font-display text-xl font-bold text-[#F0EDE7] mb-5">
            Formula Transparan Tanpa Kompromi Keadilan
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-[#1a1a1a] p-4 border border-[#242424] rounded">
                <div class="font-bold text-[#F0EDE7] text-sm">1. Tambah Tetap (+X)</div>
                <div class="font-mono text-[11px] text-[#FF4D00] my-1.5">y = min(100, x + X)</div>
                <div class="text-[11px] text-[#A8A39A] leading-relaxed">Menambahkan poin tetap ke seluruh siswa secara merata.</div>
            </div>
            <div class="bg-[#1a1a1a] p-4 border border-[#242424] rounded">
                <div class="font-bold text-[#F0EDE7] text-sm">2. Skala ke Maksimum</div>
                <div class="font-mono text-[11px] text-[#FF4D00] my-1.5">y = (x / maks) * 100</div>
                <div class="text-[11px] text-[#A8A39A] leading-relaxed">Mengangkat nilai tertinggi kelas menjadi 100 dan menyetarakan siswa lain.</div>
            </div>
            <div class="bg-[#1a1a1a] p-4 border border-[#242424] rounded">
                <div class="font-bold text-[#F0EDE7] text-sm">3. Akar Kuadrat</div>
                <div class="font-mono text-[11px] text-[#FF4D00] my-1.5">y = &radic;x * 10</div>
                <div class="text-[11px] text-[#A8A39A] leading-relaxed">Memberi dongkrak lebih besar pada nilai bawah, kurva melandai di atas.</div>
            </div>
            <div class="bg-[#1a1a1a] p-4 border border-[#242424] rounded">
                <div class="font-bold text-[#F0EDE7] text-sm">4. Rentang Min-Max</div>
                <div class="font-mono text-[11px] text-[#FF4D00] my-1.5">y = A + [(x - min)/(maks - min)] * (B - A)</div>
                <div class="text-[11px] text-[#A8A39A] leading-relaxed">Memetakan interval nilai terendah dan tertinggi ke target baru.</div>
            </div>
        </div>
    </div>

    <!-- PRIVASI & ETIKA -->
    <div class="border border-[#242424] bg-[#0E0E0E] rounded p-6 text-center">
        <div class="font-mono text-[10px] font-semibold tracking-widest uppercase text-[#585450] mb-2">Komitmen Privasi & Etika Guru</div>
        <p class="text-xs text-[#A8A39A] max-w-2xl mx-auto leading-relaxed">
            Katrol.Lab beroperasi langsung di browser dan server SQLite lokal milik sekolah Anda. Tidak ada data nilai siswa yang dikirimkan ke pihak ketiga, server analitik komersial, ataupun akun luar. Nilai siswa sepenuhnya berada di bawah kendali profesional guru.
        </p>
    </div>

</div>
@endsection
