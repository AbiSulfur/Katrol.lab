@extends('layouts.app')

@section('title', 'Katrol.Lab - Simulator Katrol & Bobot Nilai')

@section('header_actions')
    <button
        type="button"
        @click="$dispatch('trigger-reset')"
        class="btn btn-ghost btn-sm"
        title="Muat ulang 12 data siswa standar"
    >
        Reset Data
    </button>
    <button
        type="button"
        @click="$dispatch('trigger-simpan')"
        class="btn btn-primary btn-sm"
    >
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
        </svg>
        Simpan
    </button>
@endsection

@section('content')
<div x-data="simulatorApp(@js($siswa), @js($defaultSettings))" x-init="init()" @trigger-simpan.window="simpanKeDatabase()" @trigger-reset.window="resetKeDataContoh()" style="display:flex; width:100%; height:100%; overflow:hidden;">

    <!-- ==================================================
         TOAST NOTIFICATION
         ================================================== -->
    <div
        x-show="toast.tampil"
        x-transition:enter="transition"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="toast"
        :class="toast.sukses ? 'toast-sukses' : 'toast-gagal'"
        style="display:none;"
    >
        <!-- dot indicator -->
        <span style="width:7px; height:7px; border-radius:50%; background:currentColor; flex-shrink:0;"></span>
        <span x-text="toast.pesan"></span>
    </div>

    <!-- ==================================================
         SIDEBAR — Control Panel Kiri
         ================================================== -->
    <aside class="sidebar no-print" style="overflow-y:auto; overflow-x:hidden;">

        <!-- SECTION 1: KKM & Bobot -->
        <div class="panel-section">
            <div class="label-caps" style="margin-bottom:16px;">Standar Kelulusan</div>

            <!-- KKM -->
            <div style="margin-bottom:20px;">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                    <label style="font-size:11px; font-weight:600; color:var(--paper-dim);">KKM</label>
                    <span style="font-family:var(--font-mono); font-size:14px; font-weight:700; color:var(--accent);" x-text="kkm"></span>
                </div>
                <!-- Quick preset -->
                <div style="display:flex; gap:6px; margin-bottom:10px;">
                    <template x-for="preset in [65, 70, 75, 80]">
                        <button
                            type="button"
                            @click="kkm = preset"
                            :class="kkm === preset ? 'btn btn-primary btn-sm' : 'btn btn-ghost btn-sm'"
                            x-text="preset"
                        ></button>
                    </template>
                </div>
                <input
                    type="number"
                    min="0"
                    max="100"
                    x-model.number="kkm"
                    class="inp inp-sm"
                    placeholder="Ketik KKM (0-100)"
                >
            </div>

            <!-- Bobot Komponen -->
            <div>
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                    <span style="font-size:11px; font-weight:600; color:var(--paper-dim);">Bobot Komponen</span>
                    <span
                        class="bobot-indicator"
                        :class="bobotTotal === 100 ? 'bobot-valid' : 'bobot-invalid'"
                    >
                        <span style="width:5px; height:5px; border-radius:50%; background:currentColor;"></span>
                        <span x-text="`${bobotTotal}%`"></span>
                    </span>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:8px; margin-bottom:10px;">
                    <!-- PH -->
                    <div style="background:var(--ink-2); border:1px solid var(--ink-3); border-radius:3px; padding:10px 8px;">
                        <div class="label-caps" style="margin-bottom:6px; color:var(--accent);">PH</div>
                        <input type="number" min="0" max="100" x-model.number="bobot.ph" class="inp inp-sm" style="text-align:center;">
                        <div style="font-family:var(--font-mono); font-size:9px; color:var(--paper-faint); text-align:center; margin-top:4px;">Harian</div>
                    </div>
                    <!-- PTS -->
                    <div style="background:var(--ink-2); border:1px solid var(--ink-3); border-radius:3px; padding:10px 8px;">
                        <div class="label-caps" style="margin-bottom:6px; color:var(--tuntas);">PTS</div>
                        <input type="number" min="0" max="100" x-model.number="bobot.pts" class="inp inp-sm" style="text-align:center;">
                        <div style="font-family:var(--font-mono); font-size:9px; color:var(--paper-faint); text-align:center; margin-top:4px;">Tengah</div>
                    </div>
                    <!-- PAS -->
                    <div style="background:var(--ink-2); border:1px solid var(--ink-3); border-radius:3px; padding:10px 8px;">
                        <div class="label-caps" style="margin-bottom:6px; color:var(--promoted);">PAS</div>
                        <input type="number" min="0" max="100" x-model.number="bobot.pas" class="inp inp-sm" style="text-align:center;">
                        <div style="font-family:var(--font-mono); font-size:9px; color:var(--paper-faint); text-align:center; margin-top:4px;">Akhir</div>
                    </div>
                </div>

                <!-- Bobot bar visual — tanpa rounded, Cuberto style -->
                <div class="bobot-bar">
                    <div class="bobot-bar-ph" :style="`width:${Math.min(100, (bobot.ph/Math.max(bobotTotal,1))*100)}%`"></div>
                    <div class="bobot-bar-pts" :style="`width:${Math.min(100, (bobot.pts/Math.max(bobotTotal,1))*100)}%`"></div>
                    <div class="bobot-bar-pas" :style="`width:${Math.min(100, (bobot.pas/Math.max(bobotTotal,1))*100)}%`"></div>
                </div>
                <div style="display:flex; justify-content:space-between; margin-top:5px;">
                    <span style="font-family:var(--font-mono); font-size:9px; color:var(--accent);" x-text="`PH ${bobot.ph}%`"></span>
                    <span style="font-family:var(--font-mono); font-size:9px; color:var(--tuntas);" x-text="`PTS ${bobot.pts}%`"></span>
                    <span style="font-family:var(--font-mono); font-size:9px; color:var(--promoted);" x-text="`PAS ${bobot.pas}%`"></span>
                </div>

                <!-- Peringatan bobot tidak valid -->
                <div
                    x-show="bobotTotal !== 100"
                    style="margin-top:10px; padding:8px 10px; background:var(--remedial-dim); border:1px solid rgba(255,51,102,0.2); border-radius:3px; font-size:11px; color:var(--remedial); display:none;"
                >
                    Bobot harus tepat 100%. Sekarang: <strong x-text="bobotTotal + '%'"></strong>
                </div>
            </div>
        </div>

        <!-- SECTION 2: Metode Katrol -->
        <div class="panel-section">
            <div class="label-caps" style="margin-bottom:14px;">Formula Katrol</div>

            <div class="method-tabs" style="gap:6px;">
                <button type="button" @click="metode = 'none'" class="method-tab" :class="metode === 'none' ? 'active' : ''">
                    <span class="method-name">Tanpa Katrol</span>
                    <span class="method-formula">Nilai murni bobot</span>
                </button>
                <button type="button" @click="metode = 'tambah'" class="method-tab" :class="metode === 'tambah' ? 'active' : ''">
                    <span class="method-name">+ Poin Tetap</span>
                    <span class="method-formula">Nilai + X</span>
                </button>
                <button type="button" @click="metode = 'skalaMax'" class="method-tab" :class="metode === 'skalaMax' ? 'active' : ''">
                    <span class="method-name">Skala Maksimum</span>
                    <span class="method-formula">(N / Max) x 100</span>
                </button>
                <button type="button" @click="metode = 'akar'" class="method-tab" :class="metode === 'akar' ? 'active' : ''">
                    <span class="method-name">Akar Kuadrat</span>
                    <span class="method-formula">sqrt(N) x 10</span>
                </button>
                <button type="button" @click="metode = 'minmax'" class="method-tab" :class="metode === 'minmax' ? 'active' : ''">
                    <span class="method-name">Min-Max</span>
                    <span class="method-formula">Rentang [A, B]</span>
                </button>
            </div>

            <!-- Parameter Dinamis -->
            <div style="margin-top:14px;">
                <template x-if="metode === 'none'">
                    <div style="font-size:11px; color:var(--paper-faint); line-height:1.6;">
                        Nilai akhir dihitung murni dari bobot komponen. Tidak ada katrol diterapkan.
                    </div>
                </template>

                <template x-if="metode === 'tambah'">
                    <div>
                        <div style="font-size:11px; color:var(--paper-faint); margin-bottom:10px; line-height:1.6;">Tambahkan poin yang sama ke semua siswa. Dibatasi maksimal 100.</div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <label class="label-caps">Bonus:</label>
                            <input id="param-tambah" type="number" min="1" max="50" x-model.number="param.tambah" class="inp inp-sm" style="width:80px;">
                            <span style="font-family:var(--font-mono); font-size:11px; color:var(--paper-faint);">poin</span>
                        </div>
                    </div>
                </template>

                <template x-if="metode === 'skalaMax'">
                    <div style="font-size:11px; color:var(--paper-faint); line-height:1.6;">
                        Nilai tertinggi di kelas dijadikan 100. Siswa lain dinaikkan secara proporsional.
                    </div>
                </template>

                <template x-if="metode === 'akar'">
                    <div style="font-size:11px; color:var(--paper-faint); line-height:1.6;">
                        Formula non-linear. Siswa berkemampuan rendah mendapat kenaikan lebih signifikan.
                    </div>
                </template>

                <template x-if="metode === 'minmax'">
                    <div>
                        <div style="font-size:11px; color:var(--paper-faint); margin-bottom:10px; line-height:1.6;">Petakan sebaran nilai ke interval target [A, B].</div>
                        <div style="display:flex; gap:12px;">
                            <div>
                                <label class="label-caps" style="display:block; margin-bottom:5px;">Target Min (A)</label>
                                <input type="number" min="0" max="100" x-model.number="param.minmaxMin" class="inp inp-sm" style="width:70px;">
                            </div>
                            <div>
                                <label class="label-caps" style="display:block; margin-bottom:5px;">Target Max (B)</label>
                                <input type="number" min="0" max="100" x-model.number="param.minmaxMax" class="inp inp-sm" style="width:70px;">
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- SECTION 3: Aksi -->
        <div class="panel-section" style="margin-top:auto;">
            <div style="display:flex; flex-direction:column; gap:8px;">
                <button type="button" @click="eksporCSV()" class="btn btn-ghost" style="width:100%; justify-content:center;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Ekspor CSV
                </button>
                <button type="button" @click="window.print()" class="btn btn-ghost" style="width:100%; justify-content:center;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Cetak Laporan
                </button>
            </div>
            <div style="margin-top:16px; font-size:10px; color:var(--paper-faint); text-align:center; line-height:1.5;">
                Data tersimpan di database ini saja
            </div>
        </div>

    </aside>

    <!-- ==================================================
         WORKSPACE — Area utama kanan
         ================================================== -->
    <main class="workspace" style="overflow-y:auto; overflow-x:hidden;">
        <div style="padding:24px; max-width:1280px;">

            <!-- ============================================
                 ROW 1: 4 METRIC CARDS
                 ============================================ -->
            <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:12px; margin-bottom:24px;">

                <!-- Metric: Remedial -->
                <div class="metric-tile" :class="(stats.remedialSebelum - stats.remedialSesudah) > 0 ? 'has-change' : ''">
                    <div class="label-caps" style="margin-bottom:12px;">Siswa Remedial</div>
                    <div style="display:flex; align-items:baseline; gap:8px; flex-wrap:wrap;">
                        <span style="font-family:var(--font-mono); font-size:18px; font-weight:600; color:var(--paper-faint); text-decoration:line-through;" x-text="stats.remedialSebelum"></span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--paper-faint); flex-shrink:0;"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        <span class="stat-number" style="color:var(--remedial);" x-text="stats.remedialSesudah"></span>
                    </div>
                    <div style="margin-top:10px;">
                        <span
                            class="badge"
                            :class="(stats.remedialSebelum - stats.remedialSesudah) > 0 ? 'badge-tuntas' : 'badge-remedial'"
                            x-text="(stats.remedialSebelum - stats.remedialSesudah) > 0 ? `Turun ${stats.remedialSebelum - stats.remedialSesudah} siswa` : 'Tidak ada perubahan'"
                        ></span>
                    </div>
                </div>

                <!-- Metric: Rata-rata -->
                <div class="metric-tile" :class="(parseFloat(stats.rataSesudah) - parseFloat(stats.rataSebelum)) > 0 ? 'has-change' : ''">
                    <div class="label-caps" style="margin-bottom:12px;">Rata-Rata Kelas</div>
                    <div style="display:flex; align-items:baseline; gap:8px; flex-wrap:wrap;">
                        <span style="font-family:var(--font-mono); font-size:18px; font-weight:600; color:var(--paper-faint); text-decoration:line-through;" x-text="stats.rataSebelum"></span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--paper-faint); flex-shrink:0;"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        <span class="stat-number" style="color:var(--paper);" x-text="stats.rataSesudah"></span>
                    </div>
                    <div style="margin-top:10px;">
                        <span class="badge badge-promoted" x-text="`+${(parseFloat(stats.rataSesudah) - parseFloat(stats.rataSebelum)).toFixed(1)} poin`"></span>
                    </div>
                </div>

                <!-- Metric: Tertinggi -->
                <div class="metric-tile">
                    <div class="label-caps" style="margin-bottom:12px;">Nilai Tertinggi</div>
                    <div style="display:flex; align-items:baseline; gap:8px; flex-wrap:wrap;">
                        <span style="font-family:var(--font-mono); font-size:18px; font-weight:600; color:var(--paper-faint); text-decoration:line-through;" x-text="stats.tertinggiSebelum"></span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--paper-faint); flex-shrink:0;"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        <span class="stat-number" x-text="stats.tertinggiSesudah"></span>
                    </div>
                    <div style="margin-top:10px; font-size:11px; color:var(--paper-faint);">Puncak capaian kelas</div>
                </div>

                <!-- Metric: Terendah -->
                <div class="metric-tile">
                    <div class="label-caps" style="margin-bottom:12px;">Nilai Terendah</div>
                    <div style="display:flex; align-items:baseline; gap:8px; flex-wrap:wrap;">
                        <span style="font-family:var(--font-mono); font-size:18px; font-weight:600; color:var(--paper-faint); text-decoration:line-through;" x-text="stats.terendahSebelum"></span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--paper-faint); flex-shrink:0;"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        <span class="stat-number" x-text="stats.terendahSesudah"></span>
                    </div>
                    <div style="margin-top:10px; font-size:11px; color:var(--paper-faint);">Batas bawah setelah katrol</div>
                </div>
            </div>

            <!-- ============================================
                 ROW 2: LEDGER SISWA + HASIL KOMPARASI
                 ============================================ -->
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">

                <!-- Kolom kiri: Input siswa -->
                <div class="tile" style="padding:0;">
                    <!-- Header tile -->
                    <div style="padding:16px 20px; border-bottom:1px solid var(--ink-3); display:flex; align-items:center; justify-content:space-between;">
                        <div>
                            <div style="font-family:var(--font-display); font-weight:700; font-size:14px; color:var(--paper);">Lembar Nilai Komponen Siswa</div>
                            <div class="label-caps" style="margin-top:2px;" x-text="`${daftarSiswa.length} siswa`"></div>
                        </div>
                        <div style="display:flex; gap:6px;">
                            <button type="button" @click="tambahSiswa()" class="btn btn-ghost btn-sm">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                Siswa
                            </button>
                        </div>
                    </div>

                    <!-- Tabel siswa editable -->
                    <div style="max-height:460px; overflow-y:auto; overflow-x:auto;">
                        <table class="ledger">
                            <thead>
                                <tr>
                                    <th style="width:36px; text-align:center;">#</th>
                                    <th>Nama</th>
                                    <th style="width:60px; text-align:right;">PH</th>
                                    <th style="width:60px; text-align:right;">PTS</th>
                                    <th style="width:60px; text-align:right;">PAS</th>
                                    <th style="width:36px; text-align:center;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(s, index) in daftarSiswa" :key="s.id || index">
                                    <tr>
                                        <td style="text-align:center; color:var(--paper-faint); font-size:11px;" x-text="index + 1"></td>
                                        <td style="padding:6px 12px;">
                                            <input type="text" x-model="s.nama" placeholder="Nama siswa" class="ledger-input" style="font-family:var(--font-sans); font-size:12px;">
                                        </td>
                                        <td style="padding:6px 4px;">
                                            <input type="number" min="0" max="100" x-model.number="s.ph" class="ledger-input" style="text-align:right; width:55px;">
                                        </td>
                                        <td style="padding:6px 4px;">
                                            <input type="number" min="0" max="100" x-model.number="s.pts" class="ledger-input" style="text-align:right; width:55px;">
                                        </td>
                                        <td style="padding:6px 4px;">
                                            <input type="number" min="0" max="100" x-model.number="s.pas" class="ledger-input" style="text-align:right; width:55px;">
                                        </td>
                                        <td style="text-align:center; padding:6px 4px;">
                                            <button type="button" @click="hapusSiswa(index)" style="color:var(--paper-faint); background:none; border:none; cursor:pointer; padding:4px; border-radius:2px; transition:color 0.12s;" onmouseover="this.style.color='var(--remedial)'" onmouseout="this.style.color='var(--paper-faint)'" title="Hapus baris">
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
                <div class="tile" style="padding:0;">
                    <div style="padding:16px 20px; border-bottom:1px solid var(--ink-3); display:flex; align-items:center; justify-content:space-between;">
                        <div>
                            <div style="font-family:var(--font-display); font-weight:700; font-size:14px; color:var(--paper);">Hasil Komparasi Kelulusan</div>
                            <div class="label-caps" style="margin-top:2px;">Sebelum vs sesudah katrol</div>
                        </div>
                    </div>

                    <!-- Peringatan bobot tidak valid -->
                    <div x-show="bobotTotal !== 100" style="padding:12px 20px; background:var(--remedial-dim); border-bottom:1px solid rgba(255,51,102,0.2); font-size:12px; color:var(--remedial); display:none;">
                        Perbaiki bobot nilai agar total 100% sebelum kalkulasi dapat ditampilkan.
                    </div>

                    <div x-show="bobotTotal === 100" style="max-height:460px; overflow-y:auto; overflow-x:auto;">
                        <table class="ledger">
                            <thead>
                                <tr>
                                    <th style="width:28px; text-align:center;">#</th>
                                    <th>Nama</th>
                                    <th style="width:52px; text-align:right;">Awal</th>
                                    <th style="width:64px; text-align:center;">Status</th>
                                    <th style="width:52px; text-align:right;">Katrol</th>
                                    <th style="width:64px; text-align:center;">Status</th>
                                    <th style="width:48px; text-align:right;">Delta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(item, idx) in hasilKomparasi" :key="item.id || idx">
                                    <tr>
                                        <td style="text-align:center; color:var(--paper-faint); font-size:11px;" x-text="idx + 1"></td>
                                        <td style="font-family:var(--font-sans); font-weight:500; color:var(--paper); font-size:12px; max-width:130px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" x-text="item.nama"></td>
                                        <td style="text-align:right; color:var(--paper-dim);" x-text="item.nilaiAwal.toFixed(1)"></td>
                                        <td style="text-align:center;">
                                            <span class="badge" :class="item.nilaiAwal >= kkm ? 'badge-tuntas' : 'badge-remedial'" x-text="item.nilaiAwal >= kkm ? 'Tuntas' : 'Remedial'"></span>
                                        </td>
                                        <td style="text-align:right; font-weight:700; color:var(--paper);" x-text="item.nilaiKatrol.toFixed(1)"></td>
                                        <td style="text-align:center;">
                                            <span class="badge" :class="item.nilaiKatrol >= kkm ? 'badge-tuntas' : 'badge-remedial'" x-text="item.nilaiKatrol >= kkm ? 'Tuntas' : 'Remedial'"></span>
                                        </td>
                                        <td style="text-align:right; font-size:12px;" :style="item.selisih > 0 ? 'color:var(--tuntas)' : item.selisih < 0 ? 'color:var(--remedial)' : 'color:var(--paper-faint)'">
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
            <div class="tile" style="padding:0;">
                <div style="padding:16px 20px; border-bottom:1px solid var(--ink-3);">
                    <div style="font-family:var(--font-display); font-weight:700; font-size:14px; color:var(--paper);">Sebaran Distribusi Frekuensi Nilai</div>
                    <div class="label-caps" style="margin-top:2px;">Komparasi jumlah siswa per kelompok interval</div>
                </div>
                <div style="padding:20px; position:relative; height:240px;">
                    <canvas id="chartBentoSebaran"></canvas>
                </div>
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
                                borderRadius: 0,
                                color: '#A8A39A',
                                font: {
                                    family: "'JetBrains Mono', monospace",
                                    size: 11
                                },
                                padding: 16
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: '#585450',
                                font: { family: "'JetBrains Mono', monospace", size: 11 }
                            },
                            grid: { color: 'rgba(36, 36, 36, 1)' }
                        },
                        x: {
                            ticks: { color: '#585450', font: { family: "'JetBrains Mono', monospace", size: 11 } },
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
