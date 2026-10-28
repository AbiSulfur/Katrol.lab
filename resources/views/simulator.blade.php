@extends('layouts.app')

@section('title', 'Katrol.Lab - Simulator Katrol & Bobot Nilai')

@section('header_actions')
    <button 
        type="button" 
        @click="simpanKeDatabase()" 
        class="inline-flex items-center px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm transition-spring"
    >
        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
        </svg>
        Simpan Perubahan
    </button>
@endsection

@section('content')
<div x-data="simulatorApp(@js($siswa), @js($defaultSettings))" x-init="init()" class="space-y-6">

    <!-- Notifikasi Toast -->
    <div 
        x-show="toast.tampil" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="fixed top-20 right-6 z-50 px-4 py-3 rounded-lg shadow-hard flex items-center space-x-3 text-sm font-semibold border"
        :class="toast.sukses ? 'bg-emerald-50 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-200 border-emerald-300 dark:border-emerald-700' : 'bg-rose-50 dark:bg-rose-950 text-rose-800 dark:text-rose-200 border-rose-300 dark:border-rose-700'"
        style="display: none;"
    >
        <span x-text="toast.pesan"></span>
    </div>

    <!-- BENTO ROW 1: KONTROL BOBOT & METODE KATROL -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Tile 1: Konfigurasi KKM & Bobot Komponen (5 Cols) -->
        <div class="lg:col-span-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center space-x-2">
                    <h2 class="font-display font-bold text-base text-slate-900 dark:text-white">Standar Kelulusan &amp; Bobot</h2>
                </div>
                <div 
                    class="text-xs font-mono font-semibold px-2.5 py-0.5 rounded-full border"
                    :class="bobotTotal === 100 ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800' : 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/60 dark:text-rose-300 dark:border-rose-800'"
                >
                    <span x-text="`Total: ${bobotTotal}%`"></span>
                    <span x-text="bobotTotal === 100 ? ' (Valid)' : ' (Wajib 100%)'"></span>
                </div>
            </div>

            <!-- Input KKM -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="input-kkm" class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        Kriteria Ketuntasan Minimal (KKM)
                    </label>
                    <span class="text-xs font-mono font-bold text-indigo-600 dark:text-indigo-400" x-text="kkm"></span>
                </div>
                <div class="flex items-center space-x-2">
                    <input 
                        id="input-kkm" 
                        type="number" 
                        min="0" 
                        max="100" 
                        x-model.number="kkm" 
                        class="w-24 px-3 py-1.5 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg font-mono text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    >
                    <!-- Preset KKM Cepat -->
                    <div class="flex items-center space-x-1">
                        <button type="button" @click="kkm = 70" class="px-2 py-1 text-xs rounded font-mono font-medium bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300">70</button>
                        <button type="button" @click="kkm = 75" class="px-2 py-1 text-xs rounded font-mono font-medium bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300">75</button>
                        <button type="button" @click="kkm = 80" class="px-2 py-1 text-xs rounded font-mono font-medium bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300">80</button>
                    </div>
                </div>
            </div>

            <!-- Tiga Komponen Bobot Nilai -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">
                    Distribusi Bobot Nilai (%)
                </label>
                <div class="grid grid-cols-3 gap-3">
                    <div class="p-2.5 rounded-lg bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/80">
                        <span class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-1">PH (Harian)</span>
                        <div class="flex items-center space-x-1">
                            <input 
                                type="number" 
                                min="0" 
                                max="100" 
                                x-model.number="bobot.ph" 
                                class="w-full px-2 py-1 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded font-mono text-sm font-bold text-slate-900 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:outline-none"
                            >
                            <span class="text-xs text-slate-400 font-mono">%</span>
                        </div>
                    </div>
                    <div class="p-2.5 rounded-lg bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/80">
                        <span class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-1">PTS (Tengah)</span>
                        <div class="flex items-center space-x-1">
                            <input 
                                type="number" 
                                min="0" 
                                max="100" 
                                x-model.number="bobot.pts" 
                                class="w-full px-2 py-1 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded font-mono text-sm font-bold text-slate-900 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:outline-none"
                            >
                            <span class="text-xs text-slate-400 font-mono">%</span>
                        </div>
                    </div>
                    <div class="p-2.5 rounded-lg bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/80">
                        <span class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-1">PAS (Akhir)</span>
                        <div class="flex items-center space-x-1">
                            <input 
                                type="number" 
                                min="0" 
                                max="100" 
                                x-model.number="bobot.pas" 
                                class="w-full px-2 py-1 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded font-mono text-sm font-bold text-slate-900 dark:text-white focus:ring-1 focus:ring-indigo-500 focus:outline-none"
                            >
                            <span class="text-xs text-slate-400 font-mono">%</span>
                        </div>
                    </div>
                </div>

                <!-- Visual Bar Breakdown -->
                <div class="mt-3 w-full h-2 rounded-full bg-slate-200 dark:bg-slate-700 flex overflow-hidden">
                    <div class="bg-indigo-500 transition-all duration-300" :style="`width: ${Math.min(100, bobot.ph)}%`" title="PH"></div>
                    <div class="bg-sky-500 transition-all duration-300" :style="`width: ${Math.min(100, bobot.pts)}%`" title="PTS"></div>
                    <div class="bg-amber-500 transition-all duration-300" :style="`width: ${Math.min(100, bobot.pas)}%`" title="PAS"></div>
                </div>
            </div>
        </div>

        <!-- Tile 2: Pilihan Metode Katrol & Parameter Dinamis (7 Cols) -->
        <div class="lg:col-span-7 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center space-x-2">
                    <h2 class="font-display font-bold text-base text-slate-900 dark:text-white">Pilihan Formula Katrol</h2>
                </div>
            </div>

            <!-- Selector Metode Katrol -->
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
                <button 
                    type="button" 
                    @click="metode = 'none'"
                    :class="metode === 'none' ? 'bg-indigo-600 text-white shadow-hard-sm border-indigo-600' : 'bg-slate-50 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800'"
                    class="p-2.5 rounded-lg border text-left transition-spring"
                >
                    <span class="block text-xs font-bold">Murni</span>
                    <span class="text-[10px] opacity-75 font-mono">Tanpa Katrol</span>
                </button>
                <button 
                    type="button" 
                    @click="metode = 'tambah'"
                    :class="metode === 'tambah' ? 'bg-indigo-600 text-white shadow-hard-sm border-indigo-600' : 'bg-slate-50 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800'"
                    class="p-2.5 rounded-lg border text-left transition-spring"
                >
                    <span class="block text-xs font-bold">+ Poin Tetap</span>
                    <span class="text-[10px] opacity-75 font-mono">Nilai + X</span>
                </button>
                <button 
                    type="button" 
                    @click="metode = 'skalaMax'"
                    :class="metode === 'skalaMax' ? 'bg-indigo-600 text-white shadow-hard-sm border-indigo-600' : 'bg-slate-50 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800'"
                    class="p-2.5 rounded-lg border text-left transition-spring"
                >
                    <span class="block text-xs font-bold">Skala Maks</span>
                    <span class="text-[10px] opacity-75 font-mono">(N / Max) &times; 100</span>
                </button>
                <button 
                    type="button" 
                    @click="metode = 'akar'"
                    :class="metode === 'akar' ? 'bg-indigo-600 text-white shadow-hard-sm border-indigo-600' : 'bg-slate-50 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800'"
                    class="p-2.5 rounded-lg border text-left transition-spring"
                >
                    <span class="block text-xs font-bold">Akar Kuadrat</span>
                    <span class="text-[10px] opacity-75 font-mono">&radic;N &times; 10</span>
                </button>
                <button 
                    type="button" 
                    @click="metode = 'minmax'"
                    :class="metode === 'minmax' ? 'bg-indigo-600 text-white shadow-hard-sm border-indigo-600' : 'bg-slate-50 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800'"
                    class="p-2.5 rounded-lg border text-left transition-spring col-span-2 sm:col-span-1"
                >
                    <span class="block text-xs font-bold">Min-Max</span>
                    <span class="text-[10px] opacity-75 font-mono">Rentang [A, B]</span>
                </button>
            </div>

            <!-- Parameter Dinamis Sesuai Metode -->
            <div class="p-3.5 rounded-lg bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/80 text-xs text-slate-600 dark:text-slate-300">
                <template x-if="metode === 'none'">
                    <div>
                        <strong class="text-slate-900 dark:text-white">Tanpa Katrol:</strong>
                        Nilai akhir murni dihitung murni dari persentase bobot PH (<span x-text="bobot.ph"></span>%), PTS (<span x-text="bobot.pts"></span>%), dan PAS (<span x-text="bobot.pas"></span>%).
                    </div>
                </template>

                <template x-if="metode === 'tambah'">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <strong class="text-slate-900 dark:text-white">Tambah Poin Tetap (+X):</strong>
                            Setiap siswa mendapat tambahan poin yang sama. Nilai dibatasi maksimal 100.
                        </div>
                        <div class="flex items-center space-x-2 shrink-0">
                            <label for="param-tambah" class="font-bold text-slate-700 dark:text-slate-200">Bonus:</label>
                            <input 
                                id="param-tambah" 
                                type="number" 
                                min="1" 
                                max="50" 
                                x-model.number="param.tambah" 
                                class="w-20 px-2.5 py-1 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded font-mono font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-indigo-500"
                            >
                            <span class="font-mono text-slate-400">Poin</span>
                        </div>
                    </div>
                </template>

                <template x-if="metode === 'skalaMax'">
                    <div>
                        <strong class="text-slate-900 dark:text-white">Skala Maksimum:</strong>
                        Nilai tertinggi di kelas dijadikan 100. Nilai siswa lainnya dinaikkan sebanding secara proporsional.
                    </div>
                </template>

                <template x-if="metode === 'akar'">
                    <div>
                        <strong class="text-slate-900 dark:text-white">Akar Kuadrat (&radic;Nilai &times; 10):</strong>
                        Formula non-linear yang memberikan persentase kenaikan lebih signifikan kepada siswa berkemampuan awal rendah.
                    </div>
                </template>

                <template x-if="metode === 'minmax'">
                    <div class="space-y-2">
                        <div>
                            <strong class="text-slate-900 dark:text-white">Transformasi Min-Max:</strong>
                            Memetakan sebaran nilai terendah dan tertinggi kelas ke dalam target interval [A, B].
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <label class="font-bold text-slate-700 dark:text-slate-200">Target Min (A):</label>
                                <input 
                                    type="number" 
                                    min="0" 
                                    max="100" 
                                    x-model.number="param.minmaxMin" 
                                    class="w-16 px-2 py-1 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded font-mono font-bold text-slate-900 dark:text-white"
                                >
                            </div>
                            <div class="flex items-center space-x-2">
                                <label class="font-bold text-slate-700 dark:text-slate-200">Target Max (B):</label>
                                <input 
                                    type="number" 
                                    min="0" 
                                    max="100" 
                                    x-model.number="param.minmaxMax" 
                                    class="w-16 px-2 py-1 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded font-mono font-bold text-slate-900 dark:text-white"
                                >
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

    </div>

    <!-- BENTO ROW 2: 4 KARTU METRIK DAMPAK -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        
        <!-- Metric 1: Siswa Remedial -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-4 shadow-sm relative overflow-hidden">
            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                Siswa Remedial
            </span>
            <div class="mt-2 flex items-baseline space-x-2">
                <span class="text-lg font-mono line-through text-slate-400" x-text="stats.remedialSebelum"></span>
                <span class="text-slate-400 font-bold">&rarr;</span>
                <span class="text-2xl sm:text-3xl font-mono font-black text-rose-600 dark:text-rose-400" x-text="stats.remedialSesudah"></span>
                <span class="text-xs text-slate-400">Siswa</span>
            </div>
            <div class="mt-2 flex items-center">
                <span 
                    class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold"
                    :class="(stats.remedialSebelum - stats.remedialSesudah) > 0 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400'"
                >
                    <span x-text="(stats.remedialSebelum - stats.remedialSesudah) > 0 ? `Turun ${stats.remedialSebelum - stats.remedialSesudah} Siswa` : 'Tidak Ada Perubahan'"></span>
                </span>
            </div>
        </div>

        <!-- Metric 2: Rata-Rata Kelas -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-4 shadow-sm">
            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                Rata-Rata Nilai
            </span>
            <div class="mt-2 flex items-baseline space-x-2">
                <span class="text-lg font-mono line-through text-slate-400" x-text="stats.rataSebelum"></span>
                <span class="text-slate-400 font-bold">&rarr;</span>
                <span class="text-2xl sm:text-3xl font-mono font-black text-indigo-600 dark:text-indigo-400" x-text="stats.rataSesudah"></span>
            </div>
            <div class="mt-2 flex items-center">
                <span class="text-xs font-mono font-semibold text-indigo-600 dark:text-indigo-400">
                    <span x-text="`Selisih: +${(stats.rataSesudah - stats.rataSebelum).toFixed(1)} poin`"></span>
                </span>
            </div>
        </div>

        <!-- Metric 3: Nilai Tertinggi -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-4 shadow-sm">
            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                Nilai Tertinggi
            </span>
            <div class="mt-2 flex items-baseline space-x-2">
                <span class="text-lg font-mono line-through text-slate-400" x-text="stats.tertinggiSebelum"></span>
                <span class="text-slate-400 font-bold">&rarr;</span>
                <span class="text-2xl sm:text-3xl font-mono font-black text-slate-900 dark:text-white" x-text="stats.tertinggiSesudah"></span>
            </div>
            <div class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                Puncak capaian kelas
            </div>
        </div>

        <!-- Metric 4: Nilai Terendah -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-4 shadow-sm">
            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                Nilai Terendah
            </span>
            <div class="mt-2 flex items-baseline space-x-2">
                <span class="text-lg font-mono line-through text-slate-400" x-text="stats.terendahSebelum"></span>
                <span class="text-slate-400 font-bold">&rarr;</span>
                <span class="text-2xl sm:text-3xl font-mono font-black text-slate-900 dark:text-white" x-text="stats.terendahSesudah"></span>
            </div>
            <div class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                Batas bawah setelah katrol
            </div>
        </div>

    </div>

    <!-- BENTO ROW 3: DUAL SPLIT LEDGER (INPUT SISWA VS HASIL & CHART) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Kolom Kiri: Lembar Data Siswa Editable (6 Cols) -->
        <div class="lg:col-span-6 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 shadow-sm space-y-4">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center space-x-2">
                    <h3 class="font-display font-bold text-base text-slate-900 dark:text-white">Lembar Nilai Komponen Siswa</h3>
                    <span class="text-xs font-mono text-slate-400" x-text="`(${daftarSiswa.length} Siswa)`"></span>
                </div>
                <div class="flex items-center space-x-2">
                    <button 
                        type="button" 
                        @click="resetKeDataContoh()" 
                        class="px-2.5 py-1 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 text-xs font-medium transition-colors"
                        title="Muat ulang 12 data siswa standar"
                    >
                        Reset Data
                    </button>
                    <button 
                        type="button" 
                        @click="tambahSiswa()" 
                        class="px-2.5 py-1 rounded bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 text-xs font-bold transition-colors inline-flex items-center"
                    >
                        <span class="mr-1 font-mono text-sm">+</span> Siswa
                    </button>
                </div>
            </div>

            <!-- Tabel Siswa Input -->
            <div class="overflow-x-auto max-h-[460px] overflow-y-auto border border-slate-200 dark:border-slate-800 rounded-lg">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="sticky top-0 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-mono uppercase text-[11px] border-b border-slate-200 dark:border-slate-700 z-10">
                        <tr>
                            <th class="py-2.5 px-3 w-10 text-center">No</th>
                            <th class="py-2.5 px-3">Nama Siswa</th>
                            <th class="py-2.5 px-2 w-16 text-right">PH</th>
                            <th class="py-2.5 px-2 w-16 text-right">PTS</th>
                            <th class="py-2.5 px-2 w-16 text-right">PAS</th>
                            <th class="py-2.5 px-2 w-12 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 font-mono">
                        <template x-for="(s, index) in daftarSiswa" :key="s.id || index">
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-2 px-3 text-center text-slate-400 font-bold" x-text="index + 1"></td>
                                <td class="py-1 px-2 font-sans">
                                    <input 
                                        type="text" 
                                        x-model="s.nama" 
                                        placeholder="Nama Siswa"
                                        class="w-full px-2 py-1 bg-transparent hover:bg-white dark:hover:bg-slate-800 border border-transparent focus:border-indigo-500 rounded text-xs text-slate-900 dark:text-slate-100 focus:outline-none"
                                    >
                                </td>
                                <td class="py-1 px-1">
                                    <input 
                                        type="number" 
                                        min="0" 
                                        max="100" 
                                        x-model.number="s.ph" 
                                        class="w-16 px-1.5 py-1 bg-transparent hover:bg-white dark:hover:bg-slate-800 border border-transparent focus:border-indigo-500 rounded text-xs text-right text-slate-900 dark:text-slate-100 focus:outline-none"
                                    >
                                </td>
                                <td class="py-1 px-1">
                                    <input 
                                        type="number" 
                                        min="0" 
                                        max="100" 
                                        x-model.number="s.pts" 
                                        class="w-16 px-1.5 py-1 bg-transparent hover:bg-white dark:hover:bg-slate-800 border border-transparent focus:border-indigo-500 rounded text-xs text-right text-slate-900 dark:text-slate-100 focus:outline-none"
                                    >
                                </td>
                                <td class="py-1 px-1">
                                    <input 
                                        type="number" 
                                        min="0" 
                                        max="100" 
                                        x-model.number="s.pas" 
                                        class="w-16 px-1.5 py-1 bg-transparent hover:bg-white dark:hover:bg-slate-800 border border-transparent focus:border-indigo-500 rounded text-xs text-right text-slate-900 dark:text-slate-100 focus:outline-none"
                                    >
                                </td>
                                <td class="py-1 px-2 text-center">
                                    <button 
                                        type="button" 
                                        @click="hapusSiswa(index)" 
                                        class="text-rose-500 hover:text-rose-700 p-1 rounded hover:bg-rose-50 dark:hover:bg-rose-950 transition-colors"
                                        title="Hapus baris"
                                    >
                                        &times;
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Petunjuk Cepat -->
            <div class="text-[11px] text-slate-400 dark:text-slate-500">
                Nilai dapat diedit langsung pada tabel.
            </div>
        </div>

        <!-- Kolom Kanan: Hasil Komparasi & Visualisasi Chart (6 Cols) -->
        <div class="lg:col-span-6 space-y-6">
            
            <!-- Card Tabel Komparasi Hasil -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center space-x-2">
                        <h3 class="font-display font-bold text-base text-slate-900 dark:text-white">Hasil Komparasi Kelulusan</h3>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button 
                            type="button" 
                            @click="eksporCSV()" 
                            class="px-2.5 py-1 rounded bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-semibold inline-flex items-center"
                        >
                            Ekspor CSV
                        </button>
                        <button 
                            type="button" 
                            @click="window.print()" 
                            class="px-2.5 py-1 rounded bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-semibold inline-flex items-center"
                        >
                            Cetak
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto max-h-[260px] overflow-y-auto border border-slate-200 dark:border-slate-800 rounded-lg">
                    <table class="w-full text-left text-xs border-collapse font-mono">
                        <thead class="sticky top-0 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 uppercase text-[11px] border-b border-slate-200 dark:border-slate-700 z-10">
                            <tr>
                                <th class="py-2 px-3 w-8 text-center">No</th>
                                <th class="py-2 px-3">Nama</th>
                                <th class="py-2 px-2 text-right">Awal</th>
                                <th class="py-2 px-2 text-center">Status</th>
                                <th class="py-2 px-2 text-right">Katrol</th>
                                <th class="py-2 px-2 text-center">Status</th>
                                <th class="py-2 px-2 text-right">Selisih</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            <template x-for="(item, idx) in hasilKomparasi" :key="item.id || idx">
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                                    <td class="py-1.5 px-3 text-center text-slate-400" x-text="idx + 1"></td>
                                    <td class="py-1.5 px-3 font-sans font-medium text-slate-800 dark:text-slate-200 truncate max-w-[140px]" x-text="item.nama"></td>
                                    <td class="py-1.5 px-2 text-right text-slate-600 dark:text-slate-400 font-bold" x-text="item.nilaiAwal.toFixed(1)"></td>
                                    <td class="py-1.5 px-2 text-center">
                                        <span 
                                            class="inline-block px-1.5 py-0.5 rounded text-[10px] font-bold"
                                            :class="item.nilaiAwal >= kkm ? 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-200' : 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300'"
                                            x-text="item.nilaiAwal >= kkm ? 'Tuntas' : 'Remedial'"
                                        ></span>
                                    </td>
                                    <td class="py-1.5 px-2 text-right font-black text-indigo-600 dark:text-indigo-400" x-text="item.nilaiKatrol.toFixed(1)"></td>
                                    <td class="py-1.5 px-2 text-center">
                                        <span 
                                            class="inline-block px-1.5 py-0.5 rounded text-[10px] font-bold"
                                            :class="item.nilaiKatrol >= kkm ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300'"
                                            x-text="item.nilaiKatrol >= kkm ? 'Tuntas' : 'Remedial'"
                                        ></span>
                                    </td>
                                    <td class="py-1.5 px-2 text-right font-bold" :class="item.selisih > 0 ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400'">
                                        <span x-text="`${item.selisih >= 0 ? '+' : ''}${item.selisih.toFixed(1)}`"></span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card Visualisasi Grafik Sebaran Nilai -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-5 shadow-sm space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <h4 class="font-display font-bold text-sm text-slate-900 dark:text-white">Sebaran Distribusi Frekuensi Nilai</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Komparasi jumlah siswa pada tiap kelompok interval nilai</p>
                    </div>
                </div>
                <div class="relative h-56 w-full">
                    <canvas id="chartBentoSebaran"></canvas>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
function simulatorApp(initialSiswa, initialSettings) {
    return {
        daftarSiswa: initialSiswa || [],
        kkm: initialSettings.kkm || 75,
        bobot: {
            ph: initialSettings.bobot.ph || 40,
            pts: initialSettings.bobot.pts || 30,
            pas: initialSettings.bobot.pas || 30
        },
        metode: initialSettings.metode || 'none',
        param: {
            tambah: initialSettings.param.tambah || 5,
            minmaxMin: initialSettings.param.minmaxMin || 70,
            minmaxMax: initialSettings.param.minmaxMax || 100
        },
        toast: {
            tampil: false,
            pesan: '',
            sukses: true
        },
        chartObj: null,

        init() {
            // Watchers untuk kalkulasi ulang dan update chart saat ada perubahan
            this.$watch('daftarSiswa', () => this.refreshGrafik());
            this.$watch('kkm', () => this.refreshGrafik());
            this.$watch('bobot.ph', () => this.refreshGrafik());
            this.$watch('bobot.pts', () => this.refreshGrafik());
            this.$watch('bobot.pas', () => this.refreshGrafik());
            this.$watch('metode', () => this.refreshGrafik());
            this.$watch('param.tambah', () => this.refreshGrafik());
            this.$watch('param.minmaxMin', () => this.refreshGrafik());
            this.$watch('param.minmaxMax', () => this.refreshGrafik());

            this.$nextTick(() => {
                this.refreshGrafik();
            });
        },

        get bobotTotal() {
            return (Number(this.bobot.ph) || 0) + (Number(this.bobot.pts) || 0) + (Number(this.bobot.pas) || 0);
        },

        hitungNilaiAwal(s) {
            const ph = Number(s.ph) || 0;
            const pts = Number(s.pts) || 0;
            const pas = Number(s.pas) || 0;
            const wPh = Number(this.bobot.ph) || 40;
            const wPts = Number(this.bobot.pts) || 30;
            const wPas = Number(this.bobot.pas) || 30;

            const res = (ph * wPh + pts * wPts + pas * wPas) / 100;
            return Math.round(res * 10) / 10;
        },

        terapkanRumusKatrol(nilai, semuaNilai) {
            let res = nilai;
            if (this.metode === 'tambah') {
                const bonus = Number(this.param.tambah) || 5;
                res = nilai + bonus;
            } else if (this.metode === 'skalaMax') {
                const max = Math.max(...semuaNilai, 85);
                const pembagi = max > 0 ? max : 100;
                res = (nilai / pembagi) * 100;
            } else if (this.metode === 'akar') {
                res = Math.sqrt(Math.max(0, nilai)) * 10;
            } else if (this.metode === 'minmax') {
                const minTarget = Number(this.param.minmaxMin) || 70;
                const maxTarget = Number(this.param.minmaxMax) || 100;
                const minAsal = Math.min(...semuaNilai, 50);
                const maxAsal = Math.max(...semuaNilai, 95);
                const rentang = (maxAsal - minAsal) || 1;
                res = minTarget + ((nilai - minAsal) / rentang) * (maxTarget - minTarget);
            }
            // Clamp 0 - 100
            const clamped = Math.min(100, Math.max(0, res));
            return Math.round(clamped * 10) / 10;
        },

        get hasilKomparasi() {
            if (this.daftarSiswa.length === 0) return [];

            const awalList = this.daftarSiswa.map(s => this.hitungNilaiAwal(s));

            return this.daftarSiswa.map((s, idx) => {
                const nilaiAwal = awalList[idx];
                const nilaiKatrol = this.terapkanRumusKatrol(nilaiAwal, awalList);
                const selisih = Math.round((nilaiKatrol - nilaiAwal) * 10) / 10;

                return {
                    id: s.id,
                    nama: s.nama || 'Tanpa Nama',
                    ph: s.ph,
                    pts: s.pts,
                    pas: s.pas,
                    nilaiAwal,
                    nilaiKatrol,
                    selisih
                };
            });
        },

        get stats() {
            const list = this.hasilKomparasi;
            if (list.length === 0) {
                return {
                    remedialSebelum: 0,
                    remedialSesudah: 0,
                    rataSebelum: '0.0',
                    rataSesudah: '0.0',
                    tertinggiSebelum: '0.0',
                    tertinggiSesudah: '0.0',
                    terendahSebelum: '0.0',
                    terendahSesudah: '0.0',
                    sebaranSebelum: [0, 0, 0, 0, 0],
                    sebaranSesudah: [0, 0, 0, 0, 0]
                };
            }

            const sebelum = list.map(d => d.nilaiAwal);
            const sesudah = list.map(d => d.nilaiKatrol);

            const hitungRemed = arr => arr.filter(n => n < this.kkm).length;
            const hitungRata = arr => (arr.reduce((a, b) => a + b, 0) / arr.length).toFixed(1);

            const hitungBins = arr => {
                const bins = [0, 0, 0, 0, 0];
                arr.forEach(n => {
                    if (n < 60) bins[0]++;
                    else if (n < 70) bins[1]++;
                    else if (n < 75) bins[2]++;
                    else if (n < 85) bins[3]++;
                    else bins[4]++;
                });
                return bins;
            };

            return {
                remedialSebelum: hitungRemed(sebelum),
                remedialSesudah: hitungRemed(sesudah),
                rataSebelum: hitungRata(sebelum),
                rataSesudah: hitungRata(sesudah),
                tertinggiSebelum: Math.max(...sebelum).toFixed(1),
                tertinggiSesudah: Math.max(...sesudah).toFixed(1),
                terendahSebelum: Math.min(...sebelum).toFixed(1),
                terendahSesudah: Math.min(...sesudah).toFixed(1),
                sebaranSebelum: hitungBins(sebelum),
                sebaranSesudah: hitungBins(sesudah)
            };
        },

        refreshGrafik() {
            const canvas = document.getElementById('chartBentoSebaran');
            if (!canvas || typeof Chart === 'undefined') return;

            const binsSebelum = this.stats.sebaranSebelum;
            const binsSesudah = this.stats.sebaranSesudah;
            const labels = ['< 60', '60-69', '70-74', '75-84', '85-100'];

            if (this.chartObj) {
                this.chartObj.data.datasets[0].data = binsSebelum;
                this.chartObj.data.datasets[1].data = binsSesudah;
                this.chartObj.update();
                return;
            }

            const ctx = canvas.getContext('2d');
            this.chartObj = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Sebelum Katrol',
                            data: binsSebelum,
                            backgroundColor: '#64748B',
                            borderColor: '#475569',
                            borderWidth: 1,
                            borderRadius: 4
                        },
                        {
                            label: 'Sesudah Katrol',
                            data: binsSesudah,
                            backgroundColor: '#4F46E5',
                            borderColor: '#4338CA',
                            borderWidth: 1,
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    family: "'JetBrains Mono', monospace",
                                    size: 11
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: { family: "'JetBrains Mono', monospace" }
                            },
                            grid: { color: 'rgba(148, 163, 184, 0.15)' }
                        },
                        x: {
                            ticks: { font: { family: "'JetBrains Mono', monospace" } },
                            grid: { display: false }
                        }
                    }
                }
            });
        },

        tambahSiswa() {
            this.daftarSiswa.push({
                id: null,
                nama: '',
                nis: '',
                ph: 70,
                pts: 70,
                pas: 70
            });
        },

        hapusSiswa(index) {
            this.daftarSiswa.splice(index, 1);
        },

        async simpanKeDatabase() {
            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const resp = await fetch("{!! route('api.siswa.simpan') !!}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        siswa: this.daftarSiswa,
                        syncAll: true
                    })
                });

                const data = await resp.json();
                if (data.success) {
                    this.daftarSiswa = data.data;
                    this.munculkanToast('Data siswa berhasil disimpan!', true);
                } else {
                    this.munculkanToast('Gagal menyimpan: ' + (data.message || 'Terjadi kesalahan'), false);
                }
            } catch (err) {
                console.error(err);
                this.munculkanToast('Terjadi kendala jaringan saat menyimpan.', false);
            }
        },

        async resetKeDataContoh() {
            if (!confirm('Kembalikan data siswa ke nilai awal?')) return;

            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const resp = await fetch("{!! route('api.siswa.reset') !!}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token || '',
                        'Accept': 'application/json'
                    }
                });

                const data = await resp.json();
                if (data.success) {
                    this.daftarSiswa = data.data;
                    this.kkm = 75;
                    this.bobot = { ph: 40, pts: 30, pas: 30 };
                    this.metode = 'none';
                    this.param = { tambah: 5, minmaxMin: 70, minmaxMax: 100 };
                    this.munculkanToast('Data siswa berhasil dimuat ulang!', true);
                }
            } catch (err) {
                console.error(err);
                this.munculkanToast('Gagal mereset data siswa.', false);
            }
        },

        async eksporCSV() {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const dataToExport = this.hasilKomparasi.map(item => ({
                nama: item.nama,
                ph: item.ph,
                pts: item.pts,
                pas: item.pas,
                nilaiAwal: item.nilaiAwal,
                statusAwal: item.nilaiAwal >= this.kkm ? 'Tuntas' : 'Remedial',
                nilaiKatrol: item.nilaiKatrol,
                statusAkhir: item.nilaiKatrol >= this.kkm ? 'Tuntas' : 'Remedial',
                selisih: item.selisih
            }));

            // Kirim permintaan download via form atau fetch blob
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{!! route('api.ekspor.csv') !!}";
            form.target = '_blank';

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = token || '';
            form.appendChild(csrfInput);

            const dataInput = document.createElement('input');
            dataInput.type = 'hidden';
            dataInput.name = 'data';
            dataInput.value = JSON.stringify(dataToExport);
            form.appendChild(dataInput);

            // Append input baris satu per satu agar diparsing array oleh Laravel
            dataToExport.forEach((row, i) => {
                Object.keys(row).forEach(k => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `data[${i}][${k}]`;
                    input.value = row[k];
                    form.appendChild(input);
                });
            });

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        },

        munculkanToast(pesan, sukses = true) {
            this.toast.pesan = pesan;
            this.toast.sukses = sukses;
            this.toast.tampil = true;
            setTimeout(() => {
                this.toast.tampil = false;
            }, 3000);
        }
    };
}
</script>
@endpush

