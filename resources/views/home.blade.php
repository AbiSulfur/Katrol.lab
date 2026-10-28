@extends('layouts.app')

@section('title', 'Beranda - Katrol.Lab Simulator Nilai Guru')

@section('header_actions')
    <a href="{{ route('simulator.index') }}" class="btn btn-primary btn-sm">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="5 3 19 12 5 21 5 3"/>
        </svg>
        Buka Simulator
    </a>
@endsection

@section('content')
<div style="height: 100%; overflow-y: auto; padding: 48px 24px; max-width: 1200px; margin: 0 auto;">

    <!-- HERO SECTION -->
    <div style="text-align: center; margin-bottom: 56px;">
        <div class="label-caps" style="color: var(--accent); margin-bottom: 14px;">Katrol.Lab Workbench v2.0</div>
        <h1 style="font-family: var(--font-display); font-size: clamp(32px, 5vw, 54px); font-weight: 800; color: var(--paper); letter-spacing: -0.03em; line-height: 1.1; max-width: 860px; margin: 0 auto 20px;">
            Atur bobot, uji katrol, lihat dampaknya sebelum nilai dikunci.
        </h1>
        <p style="font-size: 16px; color: var(--paper-dim); max-width: 680px; margin: 0 auto 32px; line-height: 1.6;">
            Simulator kalkulasi nilai dan katrol untuk guru SMA dan SMK Indonesia. Hitung cepat proyeksi ketuntasan siswa dengan 4 metode matematis terukur sebelum nilai diserahkan ke raport.
        </p>
        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('simulator.index') }}" class="btn btn-primary" style="padding: 12px 28px; font-size: 14px;">
                Buka Simulator Sekarang
            </a>
            <a href="{{ route('profil.index') }}" class="btn btn-secondary" style="padding: 12px 24px; font-size: 14px;">
                Atur Profil Guru
            </a>
        </div>
    </div>

    <!-- PREVIEW STATISTIK MINI -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 48px;">
        <div class="card" style="padding: 20px;">
            <div class="label-caps" style="margin-bottom: 8px;">Proyeksi Remedial</div>
            <div style="display: flex; align-items: baseline; gap: 10px;">
                <span style="font-family: var(--font-mono); font-size: 28px; font-weight: 800; color: #FF4D4D;">7</span>
                <span style="color: var(--muted); font-size: 16px;">&rarr;</span>
                <span style="font-family: var(--font-mono); font-size: 28px; font-weight: 800; color: var(--status-tuntas);">2</span>
                <span style="font-size: 12px; color: var(--status-tuntas); font-weight: 700;">(-71%)</span>
            </div>
            <div style="font-size: 12px; color: var(--paper-dim); margin-top: 6px;">Turun signifikan setelah katrol terukur</div>
        </div>

        <div class="card" style="padding: 20px;">
            <div class="label-caps" style="margin-bottom: 8px;">Kenaikan Rata-Rata</div>
            <div style="display: flex; align-items: baseline; gap: 10px;">
                <span style="font-family: var(--font-mono); font-size: 28px; font-weight: 800; color: var(--paper);">71.0</span>
                <span style="color: var(--muted); font-size: 16px;">&rarr;</span>
                <span style="font-family: var(--font-mono); font-size: 28px; font-weight: 800; color: var(--accent);">79.5</span>
                <span style="font-size: 12px; color: var(--accent); font-weight: 700;">(+8.5)</span>
            </div>
            <div style="font-size: 12px; color: var(--paper-dim); margin-top: 6px;">Sebaran naik proporsional tanpa ada nilai turun</div>
        </div>

        <div class="card" style="padding: 20px;">
            <div class="label-caps" style="margin-bottom: 8px;">Kompatibilitas Format</div>
            <div style="font-family: var(--font-display); font-size: 20px; font-weight: 700; color: var(--paper); margin-top: 6px;">
                Ekspor CSV Raport
            </div>
            <div style="font-size: 12px; color: var(--paper-dim); margin-top: 6px;">Langsung buka di Microsoft Excel dengan UTF-8 BOM</div>
        </div>
    </div>

    <!-- TIGA MASALAH & TIGA CARA KERJA (BENTO GRID) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-bottom: 48px;">
        
        <!-- Kolom Masalah -->
        <div class="card" style="padding: 28px;">
            <div class="label-caps" style="color: #FF6B6B; margin-bottom: 12px;">Tiga Masalah Klasik Penilaian</div>
            <h3 style="font-family: var(--font-display); font-size: 20px; font-weight: 700; color: var(--paper); margin-bottom: 16px;">
                Mengapa Simulator Ini Diperlukan?
            </h3>
            <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 14px;">
                <li style="border-left: 2px solid #FF4D4D; padding-left: 12px;">
                    <strong style="color: var(--paper); font-size: 13px;">1. Bobot Asal Pasang</strong>
                    <p style="font-size: 12px; color: var(--paper-dim); margin-top: 2px; line-height: 1.4;">
                        Menetapkan bobot tanpa simulasi sering kali membuat nilai akhir anjlok mendadak karena satu ujian yang sulit.
                    </p>
                </li>
                <li style="border-left: 2px solid #FF4D4D; padding-left: 12px;">
                    <strong style="color: var(--paper); font-size: 13px;">2. Katrol Subjektif</strong>
                    <p style="font-size: 12px; color: var(--paper-dim); margin-top: 2px; line-height: 1.4;">
                        Menambah nilai tanpa formula transparan berisiko menimbulkan kecemburuan antar siswa dan melanggar objektivitas.
                    </p>
                </li>
                <li style="border-left: 2px solid #FF4D4D; padding-left: 12px;">
                    <strong style="color: var(--paper); font-size: 13px;">3. Terlambat Tahu Dampak</strong>
                    <p style="font-size: 12px; color: var(--paper-dim); margin-top: 2px; line-height: 1.4;">
                        Banyak guru baru menyadari 60% kelas remedial setelah nilai diserahkan ke bagian kurikulum sekolah.
                    </p>
                </li>
            </ul>
        </div>

        <!-- Kolom Cara Kerja -->
        <div class="card" style="padding: 28px;">
            <div class="label-caps" style="color: var(--status-tuntas); margin-bottom: 12px;">Tiga Langkah Kerja</div>
            <h3 style="font-family: var(--font-display); font-size: 20px; font-weight: 700; color: var(--paper); margin-bottom: 16px;">
                Alur Praktis untuk Guru
            </h3>
            <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 14px;">
                <li style="border-left: 2px solid var(--status-tuntas); padding-left: 12px;">
                    <strong style="color: var(--paper); font-size: 13px;">Langkah 1: Atur Standar & Bobot</strong>
                    <p style="font-size: 12px; color: var(--paper-dim); margin-top: 2px; line-height: 1.4;">
                        Masukkan KKM target dan porsi bobot PH, PTS, serta PAS agar tepat 100%.
                    </p>
                </li>
                <li style="border-left: 2px solid var(--status-tuntas); padding-left: 12px;">
                    <strong style="color: var(--paper); font-size: 13px;">Langkah 2: Masukkan Nilai Siswa</strong>
                    <p style="font-size: 12px; color: var(--paper-dim); margin-top: 2px; line-height: 1.4;">
                        Ketik langsung pada tabel lembar nilai atau muat 12 data contoh standar untuk mulai simulasi.
                    </p>
                </li>
                <li style="border-left: 2px solid var(--status-tuntas); padding-left: 12px;">
                    <strong style="color: var(--paper); font-size: 13px;">Langkah 3: Pilih Metode & Ekspor</strong>
                    <p style="font-size: 12px; color: var(--paper-dim); margin-top: 2px; line-height: 1.4;">
                        Uji 4 metode katrol secara langsung, amati grafik sebaran nilai, lalu unduh berkas CSV.
                    </p>
                </li>
            </ul>
        </div>

    </div>

    <!-- METODE KATROL -->
    <div class="card" style="padding: 28px; margin-bottom: 48px;">
        <div class="label-caps" style="color: var(--accent); margin-bottom: 10px;">Empat Metode Katrol Matematis</div>
        <h3 style="font-family: var(--font-display); font-size: 20px; font-weight: 700; color: var(--paper); margin-bottom: 20px;">
            Formula Transparan Tanpa Kompromi Keadilan
        </h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
            <div style="background: var(--surface); padding: 16px; border: 1px solid var(--border);">
                <div style="font-weight: 700; color: var(--paper); font-size: 14px;">1. Tambah Tetap (+X)</div>
                <div style="font-family: var(--font-mono); font-size: 11px; color: var(--accent); margin: 6px 0;">y = min(100, x + X)</div>
                <div style="font-size: 11px; color: var(--paper-dim); line-height: 1.4;">Menambahkan poin tetap ke seluruh siswa secara merata.</div>
            </div>
            <div style="background: var(--surface); padding: 16px; border: 1px solid var(--border);">
                <div style="font-weight: 700; color: var(--paper); font-size: 14px;">2. Skala ke Maksimum</div>
                <div style="font-family: var(--font-mono); font-size: 11px; color: var(--accent); margin: 6px 0;">y = (x / maks) * 100</div>
                <div style="font-size: 11px; color: var(--paper-dim); line-height: 1.4;">Mengangkat nilai tertinggi kelas menjadi 100 dan menyetarakan siswa lain.</div>
            </div>
            <div style="background: var(--surface); padding: 16px; border: 1px solid var(--border);">
                <div style="font-weight: 700; color: var(--paper); font-size: 14px;">3. Akar Kuadrat</div>
                <div style="font-family: var(--font-mono); font-size: 11px; color: var(--accent); margin: 6px 0;">y = &radic;x * 10</div>
                <div style="font-size: 11px; color: var(--paper-dim); line-height: 1.4;">Memberi dongkrak lebih besar pada nilai bawah, kurva melandai di atas.</div>
            </div>
            <div style="background: var(--surface); padding: 16px; border: 1px solid var(--border);">
                <div style="font-weight: 700; color: var(--paper); font-size: 14px;">4. Rentang Min-Max</div>
                <div style="font-family: var(--font-mono); font-size: 11px; color: var(--accent); margin: 6px 0;">y = A + [(x - min)/(maks - min)] * (B - A)</div>
                <div style="font-size: 11px; color: var(--paper-dim); line-height: 1.4;">Memetakan interval nilai terendah dan tertinggi ke target baru.</div>
            </div>
        </div>
    </div>

    <!-- PRIVASI & ETIKA -->
    <div style="border: 1px solid var(--border); background: #0E0E0E; padding: 24px; text-align: center;">
        <div class="label-caps" style="margin-bottom: 8px;">Komitmen Privasi & Etika Guru</div>
        <p style="font-size: 13px; color: var(--paper-dim); max-width: 720px; margin: 0 auto; line-height: 1.6;">
            Katrol.Lab beroperasi langsung di browser dan server SQLite lokal milik sekolah Anda. Tidak ada data nilai siswa yang dikirimkan ke pihak ketiga, server analitik komersial, ataupun akun luar. Nilai siswa sepenuhnya berada di bawah kendali profesional guru.
        </p>
    </div>

</div>
@endsection
