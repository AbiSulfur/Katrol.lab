@extends('layouts.app')

@section('title', 'Katrol.Lab - Simulator Katrol & Bobot Nilai')

@section('header_actions')
    <button
        type="button"
        @click="$dispatch('trigger-reset')"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded bg-[#1a1a1a] text-[#A8A39A] border border-[#303030] font-sans text-xs font-semibold hover:text-[#F0EDE7] hover:bg-[#242424] transition-colors cursor-pointer"
        title="Muat ulang 12 data siswa standar"
    >
        Reset Data
    </button>
    <button
        type="button"
        @click="$dispatch('trigger-simpan')"
        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded bg-[#FF4D00] text-[#080808] font-sans text-xs font-bold hover:bg-[#FF6020] transition-colors shadow-lg shadow-[#FF4D00]/20 cursor-pointer"
    >
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
        </svg>
        Simpan
    </button>
@endsection

@section('content')
<div x-data="simulatorApp(@js($siswa), @js($defaultSettings))" x-init="init()" @trigger-simpan.window="simpanKeDatabase()" @trigger-reset.window="resetKeDataContoh()" class="flex flex-col lg:flex-row w-full h-full overflow-hidden">

    <!-- ==================================================
         TOAST NOTIFICATION
         ================================================== -->
    <div
        x-show="toast.tampil"
        x-transition:enter="transition duration-200"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed bottom-6 right-6 z-50 px-5 py-3 rounded border font-sans text-xs font-semibold shadow-2xl flex items-center gap-2"
        :class="toast.sukses ? 'bg-[#1a1a1a] text-[#4BFFA0] border-[#4BFFA0]/30' : 'bg-[#1a1a1a] text-[#FF3366] border-[#FF3366]/30'"
        style="display:none;"
    >
        <span class="w-2 h-2 rounded-full bg-current shrink-0"></span>
        <span x-text="toast.pesan"></span>
    </div>

    <!-- ==================================================
         SIDEBAR: Control Panel Kiri
         ================================================== -->
    <aside class="w-full lg:w-80 shrink-0 border-r border-[#303030] bg-[#111111] overflow-y-auto flex flex-col no-print">

        <!-- SECTION 1: KKM & Bobot -->
        <div class="p-5 border-b border-[#242424]">
            <div class="font-mono text-[10px] font-semibold tracking-widest uppercase text-[#585450] mb-4">Standar Kelulusan</div>

            <!-- KKM -->
            <div class="mb-5">
                <div class="flex items-center justify-between mb-2">
                    <label class="text-[11px] font-semibold text-[#A8A39A]">KKM</label>
                    <span class="font-mono text-sm font-bold text-[#FF4D00]" x-text="kkm"></span>
                </div>
                <!-- Quick preset -->
                <div class="flex gap-1.5 mb-2.5">
                    <template x-for="preset in [65, 70, 75, 80]">
                        <button
                            type="button"
                            @click="kkm = preset"
                            class="px-2.5 py-1 text-xs font-mono font-bold rounded transition-colors cursor-pointer"
                            :class="kkm === preset ? 'bg-[#FF4D00] text-[#080808]' : 'bg-[#1a1a1a] text-[#A8A39A] hover:bg-[#242424] hover:text-[#F0EDE7] border border-[#303030]'"
                            x-text="preset"
                        ></button>
                    </template>
                </div>
                <input
                    type="number"
                    min="0"
                    max="100"
                    x-model.number="kkm"
                    class="w-full bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-3 py-1.5 font-mono text-xs focus:border-[#FF4D00] focus:ring-1 focus:ring-[#FF4D00] outline-none transition-colors"
                    placeholder="Ketik KKM (0-100)"
                >
            </div>

            <!-- Bobot Komponen -->
            <div>
                <div class="flex items-center justify-between mb-2.5">
                    <span class="text-[11px] font-semibold text-[#A8A39A]">Bobot Komponen</span>
                    <span
                        class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded font-mono text-[11px] font-bold border"
                        :class="bobotTotal === 100 ? 'bg-[#4BFFA0]/15 text-[#4BFFA0] border-[#4BFFA0]/30' : 'bg-[#FF3366]/15 text-[#FF3366] border-[#FF3366]/30'"
                    >
                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                        <span x-text="`${bobotTotal}%`"></span>
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-2 mb-2.5">
                    <!-- PH -->
                    <div class="bg-[#1a1a1a] border border-[#242424] rounded p-2 text-center">
                        <div class="font-mono text-[10px] font-semibold tracking-wider uppercase text-[#FF4D00] mb-1">PH</div>
                        <input type="number" min="0" max="100" x-model.number="bobot.ph" class="w-full bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-1.5 py-1 font-mono text-xs text-center focus:border-[#FF4D00] outline-none">
                        <div class="font-mono text-[9px] text-[#585450] mt-1">Harian</div>
                    </div>
                    <!-- PTS -->
                    <div class="bg-[#1a1a1a] border border-[#242424] rounded p-2 text-center">
                        <div class="font-mono text-[10px] font-semibold tracking-wider uppercase text-[#4BFFA0] mb-1">PTS</div>
                        <input type="number" min="0" max="100" x-model.number="bobot.pts" class="w-full bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-1.5 py-1 font-mono text-xs text-center focus:border-[#4BFFA0] outline-none">
                        <div class="font-mono text-[9px] text-[#585450] mt-1">Tengah</div>
                    </div>
                    <!-- PAS -->
                    <div class="bg-[#1a1a1a] border border-[#242424] rounded p-2 text-center">
                        <div class="font-mono text-[10px] font-semibold tracking-wider uppercase text-[#7BA7F5] mb-1">PAS</div>
                        <input type="number" min="0" max="100" x-model.number="bobot.pas" class="w-full bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-1.5 py-1 font-mono text-xs text-center focus:border-[#7BA7F5] outline-none">
                        <div class="font-mono text-[9px] text-[#585450] mt-1">Akhir</div>
                    </div>
                </div>

                <!-- Bobot bar visual -->
                <div class="h-1 w-full bg-[#242424] flex overflow-hidden rounded-none">
                    <div class="bg-[#FF4D00] transition-all duration-300" :style="`width:${Math.min(100, (bobot.ph/Math.max(bobotTotal,1))*100)}%`"></div>
                    <div class="bg-[#4BFFA0] transition-all duration-300" :style="`width:${Math.min(100, (bobot.pts/Math.max(bobotTotal,1))*100)}%`"></div>
                    <div class="bg-[#7BA7F5] transition-all duration-300" :style="`width:${Math.min(100, (bobot.pas/Math.max(bobotTotal,1))*100)}%`"></div>
                </div>
                <div class="flex justify-between mt-1 text-[9px] font-mono">
                    <span class="text-[#FF4D00]" x-text="`PH ${bobot.ph}%`"></span>
                    <span class="text-[#4BFFA0]" x-text="`PTS ${bobot.pts}%`"></span>
                    <span class="text-[#7BA7F5]" x-text="`PAS ${bobot.pas}%`"></span>
                </div>

                <!-- Peringatan bobot tidak valid -->
                <div
                    x-show="bobotTotal !== 100"
                    class="mt-2.5 p-2 bg-[#FF3366]/15 border border-[#FF3366]/30 rounded text-xs text-[#FF3366]"
                    style="display:none;"
                >
                    Bobot harus tepat 100%. Sekarang: <strong x-text="bobotTotal + '%'"></strong>
                </div>
            </div>
        </div>

        <!-- SECTION 2: Metode Katrol -->
        <div class="p-5 border-b border-[#242424]">
            <div class="font-mono text-[10px] font-semibold tracking-widest uppercase text-[#585450] mb-3.5">Formula Katrol</div>

            <div class="space-y-1.5">
                <button type="button" @click="metode = 'none'" class="w-full text-left p-2.5 rounded border transition-colors cursor-pointer flex flex-col gap-0.5" :class="metode === 'none' ? 'bg-[#FF4D00]/15 border-[#FF4D00]/40' : 'bg-[#1a1a1a] border-[#242424] hover:bg-[#242424] hover:border-[#303030]'">
                    <span class="font-sans text-xs font-semibold" :class="metode === 'none' ? 'text-[#FF4D00]' : 'text-[#A8A39A]'">Tanpa Katrol</span>
                    <span class="font-mono text-[10px] text-[#585450]">Nilai murni bobot</span>
                </button>
                <button type="button" @click="metode = 'tambah'" class="w-full text-left p-2.5 rounded border transition-colors cursor-pointer flex flex-col gap-0.5" :class="metode === 'tambah' ? 'bg-[#FF4D00]/15 border-[#FF4D00]/40' : 'bg-[#1a1a1a] border-[#242424] hover:bg-[#242424] hover:border-[#303030]'">
                    <span class="font-sans text-xs font-semibold" :class="metode === 'tambah' ? 'text-[#FF4D00]' : 'text-[#A8A39A]'">+ Poin Tetap</span>
                    <span class="font-mono text-[10px] text-[#585450]">Nilai + X</span>
                </button>
                <button type="button" @click="metode = 'skalaMax'" class="w-full text-left p-2.5 rounded border transition-colors cursor-pointer flex flex-col gap-0.5" :class="metode === 'skalaMax' ? 'bg-[#FF4D00]/15 border-[#FF4D00]/40' : 'bg-[#1a1a1a] border-[#242424] hover:bg-[#242424] hover:border-[#303030]'">
                    <span class="font-sans text-xs font-semibold" :class="metode === 'skalaMax' ? 'text-[#FF4D00]' : 'text-[#A8A39A]'">Skala Maksimum</span>
                    <span class="font-mono text-[10px] text-[#585450]">(N / Max) x 100</span>
                </button>
                <button type="button" @click="metode = 'akar'" class="w-full text-left p-2.5 rounded border transition-colors cursor-pointer flex flex-col gap-0.5" :class="metode === 'akar' ? 'bg-[#FF4D00]/15 border-[#FF4D00]/40' : 'bg-[#1a1a1a] border-[#242424] hover:bg-[#242424] hover:border-[#303030]'">
                    <span class="font-sans text-xs font-semibold" :class="metode === 'akar' ? 'text-[#FF4D00]' : 'text-[#A8A39A]'">Akar Kuadrat</span>
                    <span class="font-mono text-[10px] text-[#585450]">sqrt(N) x 10</span>
                </button>
                <button type="button" @click="metode = 'minmax'" class="w-full text-left p-2.5 rounded border transition-colors cursor-pointer flex flex-col gap-0.5" :class="metode === 'minmax' ? 'bg-[#FF4D00]/15 border-[#FF4D00]/40' : 'bg-[#1a1a1a] border-[#242424] hover:bg-[#242424] hover:border-[#303030]'">
                    <span class="font-sans text-xs font-semibold" :class="metode === 'minmax' ? 'text-[#FF4D00]' : 'text-[#A8A39A]'">Min-Max</span>
                    <span class="font-mono text-[10px] text-[#585450]">Rentang [A, B]</span>
                </button>
            </div>

            <!-- Parameter Dinamis -->
            <div class="mt-4">
                <template x-if="metode === 'none'">
                    <div class="text-[11px] text-[#585450] leading-relaxed">
                        Nilai akhir dihitung murni dari bobot komponen. Tidak ada katrol diterapkan.
                    </div>
                </template>

                <template x-if="metode === 'tambah'">
                    <div>
                        <div class="text-[11px] text-[#585450] mb-2 leading-relaxed">Tambahkan poin yang sama ke semua siswa. Dibatasi maksimal 100.</div>
                        <div class="flex items-center gap-2">
                            <label class="font-mono text-[10px] text-[#A8A39A] uppercase">Bonus:</label>
                            <input id="param-tambah" type="number" min="1" max="50" x-model.number="param.tambah" class="w-20 bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-2.5 py-1 font-mono text-xs focus:border-[#FF4D00] outline-none">
                            <span class="font-mono text-xs text-[#585450]">poin</span>
                        </div>
                    </div>
                </template>

                <template x-if="metode === 'skalaMax'">
                    <div class="text-[11px] text-[#585450] leading-relaxed">
                        Nilai tertinggi di kelas dijadikan 100. Siswa lain dinaikkan secara proporsional.
                    </div>
                </template>

                <template x-if="metode === 'akar'">
                    <div class="text-[11px] text-[#585450] leading-relaxed">
                        Formula non-linear. Siswa berkemampuan rendah mendapat kenaikan lebih signifikan.
                    </div>
                </template>

                <template x-if="metode === 'minmax'">
                    <div>
                        <div class="text-[11px] text-[#585450] mb-2.5 leading-relaxed">Petakan sebaran nilai ke interval target [A, B].</div>
                        <div class="flex gap-3">
                            <div>
                                <label class="font-mono text-[10px] text-[#A8A39A] block mb-1">Target Min (A)</label>
                                <input type="number" min="0" max="100" x-model.number="param.minmaxMin" class="w-18 bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-2.5 py-1 font-mono text-xs focus:border-[#FF4D00] outline-none">
                            </div>
                            <div>
                                <label class="font-mono text-[10px] text-[#A8A39A] block mb-1">Target Max (B)</label>
                                <input type="number" min="0" max="100" x-model.number="param.minmaxMax" class="w-18 bg-[#080808] text-[#F0EDE7] border border-[#303030] rounded px-2.5 py-1 font-mono text-xs focus:border-[#FF4D00] outline-none">
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- SECTION 3: Aksi -->
        <div class="p-5 mt-auto flex flex-col gap-2">
            <button type="button" @click="eksporCSV()" class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded bg-[#1a1a1a] text-[#A8A39A] border border-[#303030] font-sans text-xs font-semibold hover:text-[#F0EDE7] hover:bg-[#242424] transition-colors cursor-pointer">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Ekspor CSV
            </button>
            <button type="button" @click="window.print()" class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded bg-[#1a1a1a] text-[#A8A39A] border border-[#303030] font-sans text-xs font-semibold hover:text-[#F0EDE7] hover:bg-[#242424] transition-colors cursor-pointer">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Cetak Laporan
            </button>
            <div class="mt-3 text-[10px] font-mono text-[#585450] text-center leading-relaxed">
                Data tersimpan di database ini saja
            </div>
        </div>

    </aside>

    <!-- ==================================================
         WORKSPACE: Area utama kanan
         ================================================== -->
    <main class="flex-1 min-w-0 overflow-y-auto bg-[#080808] p-4 sm:p-6 max-w-[1400px]">

        <!-- ============================================
             ROW 1: 4 METRIC CARDS
             ============================================ -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">

            <!-- Metric: Remedial -->
            <div class="bg-[#111111] border border-[#242424] rounded p-4 relative overflow-hidden" :class="(stats.remedialSebelum - stats.remedialSesudah) > 0 ? 'border-l-2 border-l-[#FF4D00]' : ''">
                <div class="font-mono text-[10px] font-semibold tracking-widest uppercase text-[#585450] mb-2.5">Siswa Remedial</div>
                <div class="flex items-baseline gap-2 flex-wrap">
                    <span class="font-mono text-base font-semibold text-[#585450] line-through" x-text="stats.remedialSebelum"></span>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-[#585450] shrink-0"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    <span class="font-display text-2xl sm:text-3xl font-extrabold text-[#FF3366]" x-text="stats.remedialSesudah"></span>
                </div>
                <div class="mt-2.5">
                    <span
                        class="inline-block px-2 py-0.5 rounded text-[10px] font-mono font-bold tracking-wider uppercase"
                        :class="(stats.remedialSebelum - stats.remedialSesudah) > 0 ? 'bg-[#4BFFA0]/15 text-[#4BFFA0]' : 'bg-[#FF3366]/15 text-[#FF3366]'"
                        x-text="(stats.remedialSebelum - stats.remedialSesudah) > 0 ? `Turun ${stats.remedialSebelum - stats.remedialSesudah} siswa` : 'Tidak ada perubahan'"
                    ></span>
                </div>
            </div>

            <!-- Metric: Rata-rata -->
            <div class="bg-[#111111] border border-[#242424] rounded p-4 relative overflow-hidden" :class="(parseFloat(stats.rataSesudah) - parseFloat(stats.rataSebelum)) > 0 ? 'border-l-2 border-l-[#FF4D00]' : ''">
                <div class="font-mono text-[10px] font-semibold tracking-widest uppercase text-[#585450] mb-2.5">Rata-Rata Kelas</div>
                <div class="flex items-baseline gap-2 flex-wrap">
                    <span class="font-mono text-base font-semibold text-[#585450] line-through" x-text="stats.rataSebelum"></span>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-[#585450] shrink-0"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    <span class="font-display text-2xl sm:text-3xl font-extrabold text-[#F0EDE7]" x-text="stats.rataSesudah"></span>
                </div>
                <div class="mt-2.5">
                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-mono font-bold tracking-wider uppercase bg-[#7BA7F5]/15 text-[#7BA7F5]" x-text="`+${(parseFloat(stats.rataSesudah) - parseFloat(stats.rataSebelum)).toFixed(1)} poin`"></span>
                </div>
            </div>

            <!-- Metric: Tertinggi -->
            <div class="bg-[#111111] border border-[#242424] rounded p-4 relative overflow-hidden">
                <div class="font-mono text-[10px] font-semibold tracking-widest uppercase text-[#585450] mb-2.5">Nilai Tertinggi</div>
                <div class="flex items-baseline gap-2 flex-wrap">
                    <span class="font-mono text-base font-semibold text-[#585450] line-through" x-text="stats.tertinggiSebelum"></span>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-[#585450] shrink-0"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    <span class="font-display text-2xl sm:text-3xl font-extrabold text-[#F0EDE7]" x-text="stats.tertinggiSesudah"></span>
                </div>
                <div class="mt-2.5 text-[11px] font-mono text-[#585450]">Puncak capaian kelas</div>
            </div>

            <!-- Metric: Terendah -->
            <div class="bg-[#111111] border border-[#242424] rounded p-4 relative overflow-hidden">
                <div class="font-mono text-[10px] font-semibold tracking-widest uppercase text-[#585450] mb-2.5">Nilai Terendah</div>
                <div class="flex items-baseline gap-2 flex-wrap">
                    <span class="font-mono text-base font-semibold text-[#585450] line-through" x-text="stats.terendahSebelum"></span>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-[#585450] shrink-0"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    <span class="font-display text-2xl sm:text-3xl font-extrabold text-[#F0EDE7]" x-text="stats.terendahSesudah"></span>
                </div>
                <div class="mt-2.5 text-[11px] font-mono text-[#585450]">Batas bawah setelah katrol</div>
            </div>
        </div>

        <!-- ============================================
             ROW 2: LEDGER SISWA + HASIL KOMPARASI
             ============================================ -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 mb-6">

            <!-- Kolom kiri: Input siswa -->
            <div class="bg-[#111111] border border-[#242424] rounded overflow-hidden">
                <!-- Header tile -->
                <div class="px-5 py-3.5 border-b border-[#242424] flex items-center justify-between">
                    <div>
                        <div class="font-display font-bold text-sm text-[#F0EDE7]">Lembar Nilai Komponen Siswa</div>
                        <div class="font-mono text-[10px] text-[#585450] mt-0.5" x-text="`${daftarSiswa.length} siswa`"></div>
                    </div>
                    <div class="flex gap-1.5">
                        <button type="button" @click="tambahSiswa()" class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-[#1a1a1a] text-[#A8A39A] border border-[#303030] font-sans text-xs font-semibold hover:text-[#F0EDE7] hover:bg-[#242424] transition-colors cursor-pointer">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Siswa
                        </button>
                    </div>
                </div>

                <!-- Tabel siswa editable -->
                <div class="max-h-[460px] overflow-y-auto overflow-x-auto">
                    <table class="w-full border-collapse font-mono text-xs">
                        <thead class="sticky top-0 z-10 bg-[#161616] border-b border-[#303030]">
                            <tr>
                                <th class="w-9 px-3 py-2.5 text-center text-[10px] font-semibold text-[#585450] uppercase tracking-wider">#</th>
                                <th class="px-3 py-2.5 text-left text-[10px] font-semibold text-[#585450] uppercase tracking-wider">Nama</th>
                                <th class="w-16 px-2 py-2.5 text-right text-[10px] font-semibold text-[#585450] uppercase tracking-wider">PH</th>
                                <th class="w-16 px-2 py-2.5 text-right text-[10px] font-semibold text-[#585450] uppercase tracking-wider">PTS</th>
                                <th class="w-16 px-2 py-2.5 text-right text-[10px] font-semibold text-[#585450] uppercase tracking-wider">PAS</th>
                                <th class="w-9 px-2 py-2.5 text-center"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#1a1a1a]">
                            <template x-for="(s, index) in daftarSiswa" :key="s.id || index">
                                <tr class="hover:bg-[#181818] transition-colors">
                                    <td class="text-center text-[#585450] text-[11px] py-1.5" x-text="index + 1"></td>
                                    <td class="px-2 py-1.5">
                                        <input type="text" x-model="s.nama" placeholder="Nama siswa" class="w-full bg-transparent text-[#F0EDE7] border border-transparent hover:border-[#303030] focus:border-[#FF4D00] focus:bg-[#1a1a1a] rounded px-2 py-1 font-sans text-xs outline-none transition-colors">
                                    </td>
                                    <td class="px-1 py-1.5">
                                        <input type="number" min="0" max="100" x-model.number="s.ph" class="w-full bg-transparent text-[#F0EDE7] border border-transparent hover:border-[#303030] focus:border-[#FF4D00] focus:bg-[#1a1a1a] rounded px-1.5 py-1 font-mono text-xs text-right outline-none transition-colors">
                                    </td>
                                    <td class="px-1 py-1.5">
                                        <input type="number" min="0" max="100" x-model.number="s.pts" class="w-full bg-transparent text-[#F0EDE7] border border-transparent hover:border-[#303030] focus:border-[#FF4D00] focus:bg-[#1a1a1a] rounded px-1.5 py-1 font-mono text-xs text-right outline-none transition-colors">
                                    </td>
                                    <td class="px-1 py-1.5">
                                        <input type="number" min="0" max="100" x-model.number="s.pas" class="w-full bg-transparent text-[#F0EDE7] border border-transparent hover:border-[#303030] focus:border-[#FF4D00] focus:bg-[#1a1a1a] rounded px-1.5 py-1 font-mono text-xs text-right outline-none transition-colors">
                                    </td>
                                    <td class="text-center px-1 py-1.5">
                                        <button type="button" @click="hapusSiswa(index)" class="text-[#585450] hover:text-[#FF3366] transition-colors p-1 rounded cursor-pointer" title="Hapus baris">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Kolom kanan: Hasil komparasi -->
            <div class="bg-[#111111] border border-[#242424] rounded overflow-hidden">
                <div class="px-5 py-3.5 border-b border-[#242424] flex items-center justify-between">
                    <div>
                        <div class="font-display font-bold text-sm text-[#F0EDE7]">Hasil Komparasi Kelulusan</div>
                        <div class="font-mono text-[10px] text-[#585450] mt-0.5">Sebelum vs sesudah katrol</div>
                    </div>
                </div>

                <!-- Peringatan bobot tidak valid -->
                <div x-show="bobotTotal !== 100" class="p-4 bg-[#FF3366]/15 border-b border-[#FF3366]/30 text-xs text-[#FF3366]" style="display:none;">
                    Perbaiki bobot nilai agar total 100% sebelum kalkulasi dapat ditampilkan.
                </div>

                <div x-show="bobotTotal === 100" class="max-h-[460px] overflow-y-auto overflow-x-auto">
                    <table class="w-full border-collapse font-mono text-xs">
                        <thead class="sticky top-0 z-10 bg-[#161616] border-b border-[#303030]">
                            <tr>
                                <th class="w-8 px-2 py-2.5 text-center text-[10px] font-semibold text-[#585450] uppercase tracking-wider">#</th>
                                <th class="px-3 py-2.5 text-left text-[10px] font-semibold text-[#585450] uppercase tracking-wider">Nama</th>
                                <th class="w-14 px-2 py-2.5 text-right text-[10px] font-semibold text-[#585450] uppercase tracking-wider">Awal</th>
                                <th class="w-18 px-2 py-2.5 text-center text-[10px] font-semibold text-[#585450] uppercase tracking-wider">Status</th>
                                <th class="w-14 px-2 py-2.5 text-right text-[10px] font-semibold text-[#585450] uppercase tracking-wider">Katrol</th>
                                <th class="w-18 px-2 py-2.5 text-center text-[10px] font-semibold text-[#585450] uppercase tracking-wider">Status</th>
                                <th class="w-14 px-2 py-2.5 text-right text-[10px] font-semibold text-[#585450] uppercase tracking-wider">Delta</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#1a1a1a]">
                            <template x-for="(item, idx) in hasilKomparasi" :key="item.id || idx">
                                <tr class="hover:bg-[#181818] transition-colors">
                                    <td class="text-center text-[#585450] text-[11px] py-2" x-text="idx + 1"></td>
                                    <td class="px-3 py-2 font-sans font-medium text-[#F0EDE7] text-xs max-w-[130px] truncate" x-text="item.nama"></td>
                                    <td class="text-right text-[#A8A39A] px-2 py-2" x-text="item.nilaiAwal.toFixed(1)"></td>
                                    <td class="text-center px-2 py-2">
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-mono font-bold tracking-wider uppercase" :class="item.nilaiAwal >= kkm ? 'bg-[#4BFFA0]/15 text-[#4BFFA0]' : 'bg-[#FF3366]/15 text-[#FF3366]'" x-text="item.nilaiAwal >= kkm ? 'Tuntas' : 'Remedial'"></span>
                                    </td>
                                    <td class="text-right font-bold text-[#F0EDE7] px-2 py-2" x-text="item.nilaiKatrol.toFixed(1)"></td>
                                    <td class="text-center px-2 py-2">
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-mono font-bold tracking-wider uppercase" :class="item.nilaiKatrol >= kkm ? 'bg-[#4BFFA0]/15 text-[#4BFFA0]' : 'bg-[#FF3366]/15 text-[#FF3366]'" x-text="item.nilaiKatrol >= kkm ? 'Tuntas' : 'Remedial'"></span>
                                    </td>
                                    <td class="text-right text-xs px-2 py-2" :class="item.selisih > 0 ? 'text-[#4BFFA0]' : item.selisih < 0 ? 'text-[#FF3366]' : 'text-[#585450]'">
                                        <span x-text="`${item.selisih >= 0 ? '+' : ''}${item.selisih.toFixed(1)}`"></span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- ============================================
             ROW 3: GRAFIK DISTRIBUSI
             ============================================ -->
        <div class="bg-[#111111] border border-[#242424] rounded overflow-hidden">
            <div class="px-5 py-3.5 border-b border-[#242424]">
                <div class="font-display font-bold text-sm text-[#F0EDE7]">Sebaran Distribusi Frekuensi Nilai</div>
                <div class="font-mono text-[10px] text-[#585450] mt-0.5">Komparasi jumlah siswa per kelompok interval</div>
            </div>
            <div class="p-5 relative h-60">
                <canvas id="chartBentoSebaran"></canvas>
            </div>
        </div>

    </main>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
let chartBentoInstance = null;

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

        init() {
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

            if (chartBentoInstance) {
                chartBentoInstance.data.datasets[0].data = binsSebelum;
                chartBentoInstance.data.datasets[1].data = binsSesudah;
                chartBentoInstance.update();
                return;
            }

            const ctx = canvas.getContext('2d');
            chartBentoInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Sebelum Katrol',
                            data: binsSebelum,
                            backgroundColor: 'rgba(64, 48, 48, 0.9)',
                            borderColor: 'rgba(88, 84, 80, 1)',
                            borderWidth: 1,
                            borderRadius: 0
                        },
                        {
                            label: 'Sesudah Katrol',
                            data: binsSesudah,
                            backgroundColor: 'rgba(255, 77, 0, 0.8)',
                            borderColor: 'rgba(255, 77, 0, 1)',
                            borderWidth: 1,
                            borderRadius: 0
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'start',
                            labels: {
                                boxWidth: 10,
                                boxHeight: 10,
                                color: '#A8A39A',
                                font: {
                                    family: "'JetBrains Mono', monospace",
                                    size: 10
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: {
                                color: '#585450',
                                font: {
                                    family: "'JetBrains Mono', monospace",
                                    size: 10
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: {
                                stepSize: 1,
                                color: '#585450',
                                font: {
                                    family: "'JetBrains Mono', monospace",
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
        },

        tambahSiswa() {
            this.daftarSiswa.push({
                nama: 'Siswa Baru ' + (this.daftarSiswa.length + 1),
                nis: '',
                ph: 75,
                pts: 75,
                pas: 75
            });
        },

        hapusSiswa(index) {
            this.daftarSiswa.splice(index, 1);
        },

        async simpanKeDatabase() {
            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const resp = await fetch("{{ route('api.siswa.simpan', [], false) }}", {
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
                const resp = await fetch("{{ route('api.siswa.reset', [], false) }}", {
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

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('api.ekspor.csv', [], false) }}";
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
