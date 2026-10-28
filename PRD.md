# PRD: Katrol.Lab

> Simulator Bobot Nilai & Katrol untuk Guru

| Field | Isi |
|---|---|
| **Nama Produk** | Katrol.Lab |
| **Versi Dokumen** | 1.0 (MVP) |
| **Status** | Draft, siap dikerjakan |
| **Tim** | Benedictus Abigail Triwiyatno & Syihabuddin Hanif |
| **Konteks** | Tugas sekolah RPL: aplikasi yang berguna untuk guru |
| **Platform** | Web (single-page, client-side only) |
| **Batas Waktu** | 135 menit (07.00 s.d. 09.15 WIB) |
| **Tanggal** | 28 Oktober 2026 |

---

## 1. Ringkasan Eksekutif

Katrol.Lab adalah aplikasi web satu halaman yang membantu guru **menentukan bobot nilai dan menguji metode katrol sebelum nilai dikunci ke rapor**. Guru memasukkan nilai PH, PTS, dan PAS, memilih bobot dan metode katrol, lalu langsung melihat perbandingan **sebelum vs sesudah** (jumlah remedial, rata-rata, sebaran nilai).

Aplikasi berjalan 100% di browser: tanpa login, tanpa server, dan data tersimpan lokal di perangkat guru.

## 2. Latar Belakang & Masalah

Pengolahan nilai akhir masih sering dilakukan manual di Excel atau kalkulator.

| # | Masalah | Dampak |
|---|---|---|
| P1 | Guru bingung menentukan bobot PH/PTS/PAS yang adil | Keputusan bobot berdasarkan perasaan, bukan simulasi |
| P2 | Dampak katrol baru ketahuan setelah nilai final | Sulit mundur kalau hasilnya tidak diinginkan |
| P3 | Membandingkan beberapa metode katrol memakan waktu | Guru memilih satu metode tanpa tahu alternatifnya |
| P4 | Tidak ada jejak yang mudah dijelaskan ke siswa, orang tua, atau wali kelas | Nilai terasa tidak transparan |

**Kenapa tidak cukup dengan Google Classroom?** Classroom mencatat dan menghitung nilai tugas, tetapi tidak menyediakan simulasi bobot lintas komponen (PH/PTS/PAS) dan perbandingan metode katrol sebelum dan sesudah.

## 3. Tujuan & Non-Tujuan

### 3.1 Goals
- **G1.** Guru bisa mendapatkan hasil simulasi dalam **kurang dari 2 menit** sejak membuka aplikasi (dengan data contoh).
- **G2.** Guru bisa membandingkan efek **minimal 4 metode katrol** terhadap kelas yang sama.
- **G3.** Hasil bisa diekspor (CSV) atau dicetak sebagai arsip.
- **G4.** Berfungsi baik di HP maupun laptop tanpa instalasi.
- **G5.** Desain khas dan tidak terlihat seperti template AI.

### 3.2 Non-Goals (di luar MVP)
- Bukan pengganti e-rapor atau sistem penilaian resmi sekolah.
- Tidak ada akun, login, atau sinkronisasi antar perangkat.
- Tidak ada penyimpanan di server dan tidak ada pengiriman data siswa ke pihak ketiga.
- Tidak mengelola presensi, perilaku, RPP, kuis, atau fitur lain di luar pengolahan nilai akhir.
- Tidak ada fitur AI.

## 4. Target Pengguna

| Persona | Deskripsi | Kebutuhan utama |
|---|---|---|
| **Bu Rina (Guru Mapel)** | Mengajar 6 kelas, mengolah nilai tiap akhir semester | Cepat memilih bobot dan katrol tanpa Excel rumit |
| **Pak Dani (Wali Kelas)** | Mengecek kelayakan nilai kelas sebelum rapat nilai | Melihat jumlah remedial sebelum vs sesudah |
| **Pengguna sekunder: Kepala Kurikulum** | Meminta dasar angka atas kebijakan katrol | Bukti dampak yang jelas dan bisa dicetak |

## 5. User Stories

| ID | Sebagai | Saya ingin | Supaya |
|---|---|---|---|
| US-01 | Guru | mengisi nilai PH, PTS, PAS tiap siswa | nilai akhir bisa dihitung otomatis |
| US-02 | Guru | menandai bobot komponen dan melihat total harus 100% | tidak salah hitung |
| US-03 | Guru | memilih metode katrol dan mengatur parameternya | bisa menguji kebijakan yang berbeda |
| US-04 | Guru | melihat nilai sebelum dan sesudah katrol berdampingan | memahami perubahan tiap siswa |
| US-05 | Guru | melihat jumlah remedial sebelum dan sesudah | menilai dampak keputusan |
| US-06 | Guru | mengisi data contoh dengan satu klik | mencoba aplikasi tanpa input manual |
| US-07 | Guru | mengekspor hasil ke CSV atau mencetak | menyimpan arsip dan mendiskusikannya |
| US-08 | Guru | mengimpor daftar siswa dari CSV | tidak mengetik ulang data |
| US-09 | Guru | yakin data tidak keluar dari perangkat | privasi siswa terjaga |

## 6. Ruang Lingkup

### 6.1 MVP (wajib selesai hari ini)
Input data siswa, pengaturan KKM dan bobot, 5 opsi metode katrol (termasuk "tanpa katrol"), hasil sebelum vs sesudah, statistik dampak, grafik perbandingan, data contoh, reset, ekspor CSV, cetak, dan penyimpanan lokal.

### 6.2 Nice-to-have (jika waktu cukup)
Impor CSV, opsi "jangan turunkan nilai", toggle pembulatan, mode gelap.

### 6.3 Future (di luar tugas ini)
Simpan banyak kelas dan mapel, bandingkan dua skenario side-by-side, ekspor PDF, PWA offline, berbagi skenario via link.

## 7. Kebutuhan Fungsional

Prioritas: **P0** = wajib, **P1** = sebaiknya ada, **P2** = bonus.

### FR-01 Header & Aksi Global (P0)
- Menampilkan logo teks "Katrol.Lab" dan tagline.
- Tombol **[Isi data contoh]** dan **[Reset]**.
- **AC:** Klik "Isi data contoh" mengisi 12 siswa dan memperbarui semua panel. Reset meminta konfirmasi lalu mengosongkan data dan mengembalikan pengaturan ke default.

### FR-02 Pengaturan KKM (P0)
- Input angka KKM, default **75**, rentang 0–100.
- **AC:** Nilai di luar rentang ditolak dengan pesan inline. Perubahan KKM langsung memperbarui status Tuntas/Remedial.

### FR-03 Pengaturan Bobot (P0)
- Tiga input: PH (default 40), PTS (30), PAS (30), tipe angka 0–100.
- Indikator total bobot secara langsung.
- **AC:** Jika total ≠ 100, tampil peringatan merah "Total bobot harus 100%" dan perhitungan hasil ditahan (panel hasil menampilkan pesan, bukan angka salah).

### FR-04 Pemilihan Metode Katrol (P0)
- Dropdown berisi: Tanpa katrol, Tambah poin tetap, Skala ke nilai tertinggi, Akar kuadrat, Min-max ke rentang.
- Tiap metode punya deskripsi satu kalimat dan parameter dinamis (lihat bagian 8).
- **AC:** Mengganti metode memperbarui hasil dalam kurang dari 200 ms untuk 100 siswa.

### FR-05 Tabel Data Siswa (P0)
- Kolom: No, Nama, PH, PTS, PAS, aksi hapus.
- Tombol **[+ Tambah siswa]**. Sel nilai menerima angka 0–100.
- **AC:** Input di luar 0–100 ditandai error dan tidak ikut dihitung. Baris dengan komponen kosong berstatus "Belum lengkap" dan dikecualikan dari statistik. Maksimal 100 baris.

### FR-06 Tabel Hasil (P0)
- Kolom: Nama, Nilai Akhir (sebelum), Nilai Akhir (sesudah katrol), Selisih, Status (Tuntas/Remedial).
- **AC:** Status ditentukan dari nilai **sesudah katrol** dan dibandingkan dengan KKM. Siswa yang berubah status (Remedial → Tuntas) diberi penanda khusus.

### FR-07 Panel Dampak (P0)
- Kartu statistik: jumlah remedial (sebelum → sesudah), rata-rata (sebelum → sesudah), nilai tertinggi, nilai terendah.
- Grafik perbandingan sebaran nilai sebelum vs sesudah (bar, rentang 10 poin: <50, 50–59, ..., 90–100).
- **AC:** Semua angka konsisten dengan tabel hasil.

### FR-08 Persistensi Lokal (P0)
- Seluruh state disimpan ke `localStorage` (key `katrollab:v1`) setiap ada perubahan (debounce 300 ms).
- **AC:** Refresh halaman tidak menghilangkan data. Jika localStorage gagal atau kosong, aplikasi tetap tampil dengan state default tanpa error.

### FR-09 Ekspor CSV (P0)
- Mengunduh file `katrollab-hasil-YYYYMMDD.csv` berisi nama, PH, PTS, PAS, nilai sebelum, nilai sesudah, status.
- **AC:** File terbuka benar di Excel dan Google Sheets (UTF-8 dengan BOM, pemisah koma).

### FR-10 Cetak (P0)
- Tombol **[Cetak]** memanggil `window.print()` dengan stylesheet cetak: sembunyikan tombol, tampilkan pengaturan, tabel hasil, dan ringkasan.
- **AC:** Hasil cetak muat di A4 dan terbaca hitam putih.

### FR-11 Impor CSV (P1)
- Impor file CSV dengan header `nama,ph,pts,pas`.
- **AC:** Baris tidak valid dilewati dan jumlahnya dilaporkan. Data lama diganti setelah konfirmasi.

### FR-12 Opsi "Jangan Turunkan Nilai" (P1)
- Checkbox default **aktif**: hasil katrol minimal sama dengan nilai sebelum katrol.
- **AC:** Dengan opsi aktif, tidak ada siswa yang nilainya turun setelah katrol.

### FR-13 Catatan Etika (P1)
- Teks tetap di footer: "Alat bantu simulasi. Keputusan katrol mengikuti kebijakan sekolah."

### FR-14 Mode Gelap (P2)
- Mengikuti `prefers-color-scheme: dark` dengan palet gelap senada.

## 8. Aturan Bisnis & Rumus

### 8.1 Nilai Akhir (sebelum katrol)

```
NilaiAkhir = (PH × bobotPH + PTS × bobotPTS + PAS × bobotPAS) / 100
```

Syarat: bobotPH + bobotPTS + bobotPAS = 100.

### 8.2 Metode Katrol

Misalkan `n` = nilai akhir sebelum katrol. Hasil selalu di-clamp ke 0–100.

| Kode | Metode | Rumus | Parameter | Default |
|---|---|---|---|---|
| `none` | Tanpa katrol | `n` | – | – |
| `tambah` | Tambah poin tetap | `n + X` | X (0–30) | 5 |
| `skalaMax` | Skala ke nilai tertinggi | `n / maks × 100` | – | – |
| `akar` | Akar kuadrat | `√n × 10` | – | – |
| `minmax` | Min-max ke rentang | `A + (n − min) / (maks − min) × (B − A)` | A, B (0–100, A < B) | 70, 100 |

Keterangan: `maks` dan `min` adalah nilai akhir tertinggi dan terendah dari siswa yang datanya lengkap.

### 8.3 Status
- **Tuntas** jika `nilaiSesudah ≥ KKM`.
- **Remedial** jika `nilaiSesudah < KKM`.

### 8.4 Pembulatan
- Perhitungan memakai presisi penuh. Tampilan **1 desimal**. Status dihitung dari nilai yang sudah dibulatkan 1 desimal supaya konsisten dengan yang terlihat di layar.

### 8.5 Contoh Perhitungan

Data: PH 80, PTS 70, PAS 60, bobot 40/30/30.

```
NilaiAkhir = (80×40 + 70×30 + 60×30) / 100 = 71,0
```

Dengan `maks` kelas = 90 dan KKM 75:

| Metode | Hasil | Status |
|---|---|---|
| Tanpa katrol | 71,0 | Remedial |
| Tambah +5 | 76,0 | Tuntas |
| Skala ke nilai tertinggi | 78,9 | Tuntas |
| Akar kuadrat | 84,3 | Tuntas |

## 9. Kasus Tepi & Penanganan

| Kasus | Penanganan |
|---|---|
| Total bobot ≠ 100 | Peringatan, hasil ditahan |
| Sel nilai kosong | Baris berstatus "Belum lengkap", dikecualikan dari statistik |
| Nilai < 0 atau > 100 atau bukan angka | Ditandai error, tidak dihitung |
| `maks = min` pada metode min-max | Peringatan "Semua nilai sama, katrol dilewati", nilai tidak berubah |
| `maks = 0` pada skala ke nilai tertinggi | Peringatan, katrol dilewati |
| A ≥ B pada min-max | Validasi error pada input parameter |
| Nama kosong | Otomatis diberi label "Siswa N" |
| Tidak ada siswa | Panel hasil dan dampak menampilkan empty state dengan ajakan "Isi data contoh" |
| localStorage tidak tersedia | Aplikasi tetap berjalan tanpa persistensi |
| Lebih dari 100 siswa | Tombol tambah dinonaktifkan dengan pesan |
| Hasil katrol > 100 | Di-clamp menjadi 100 |

## 10. Kebutuhan Non-Fungsional

| Kategori | Persyaratan |
|---|---|
| **Performa** | Render ulang < 200 ms untuk 100 siswa. Muat awal < 2 detik pada koneksi 4G |
| **Kompatibilitas** | Chrome, Edge, Firefox, Safari (2 versi terakhir). Android dan iOS |
| **Responsif** | Lebar 360 px sampai 1440 px. Tabel scroll horizontal di dalam kontainer, bukan di body |
| **Privasi** | Tidak ada pengiriman data ke server. Tidak ada analytics atau pelacak |
| **Keamanan** | Semua input di-escape sebelum dirender (hindari injeksi HTML). Tidak memakai `eval` |
| **Aksesibilitas** | Kontras teks minimal WCAG AA, label untuk setiap input, navigasi keyboard, fokus terlihat |
| **Ketahanan** | Semua akses localStorage dibungkus try/catch. Tidak ada crash jika data rusak |
| **Maintainability** | Satu file `index.html`, kode dibagi blok berkomentar |
| **Bahasa** | Seluruh UI dalam Bahasa Indonesia |

## 11. Informasi Arsitektur & UX

### 11.1 Urutan Halaman

1. **Header**: logo, tagline, tombol Isi data contoh dan Reset
2. **Panel 1: Pengaturan**: KKM, bobot, metode, parameter
3. **Panel 2: Data siswa**: tabel editable
4. **Panel 3: Hasil**: sebelum vs sesudah
5. **Panel 4: Dampak**: kartu statistik dan grafik
6. **Footer**: Ekspor CSV, Cetak, catatan privasi dan etika

### 11.2 Wireframe (kasar)

```
+--------------------------------------------------+
| KATROL.LAB   Atur bobot, uji katrol...  [Contoh][Reset]
+--------------------------------------------------+
| 01 PENGATURAN                                    |
| KKM [75]  PH [40] PTS [30] PAS [30]  Total: 100% |
| Metode [Tambah poin tetap v]  X [5]              |
+--------------------------------------------------+
| 02 DATA SISWA                       [+ Tambah]   |
| No | Nama        | PH | PTS | PAS | x             |
+--------------------------------------------------+
| 03 HASIL                                         |
| Nama | Sebelum | Sesudah | Selisih | Status       |
+--------------------------------------------------+
| 04 DAMPAK                                        |
| Remedial 7 -> 2 | Rata-rata 71,2 -> 76,2         |
| [grafik sebaran sebelum vs sesudah]              |
+--------------------------------------------------+
| [Ekspor CSV] [Cetak]   Data tersimpan di browser |
+--------------------------------------------------+
```

### 11.3 Alur Pengguna Utama

1. Buka aplikasi, lalu klik **Isi data contoh**.
2. Ubah bobot dan KKM sesuai kebijakan.
3. Ganti metode katrol, lalu amati perubahan di Panel Hasil dan Dampak.
4. Pilih skenario terbaik, lalu **Ekspor CSV** atau **Cetak**.

## 12. Desain Visual (Design System)

**Prinsip:** editorial seperti lembar kerja cetak. Tidak boleh terlihat seperti template AI.

### 12.1 Larangan
Gradient ungu/biru, glassmorphism, kartu rounded seragam dengan shadow lembut, ikon emoji, font Inter, Poppins, dan Roboto.

### 12.2 Token

| Token | Nilai |
|---|---|
| `--bg` | `#F4EFE6` (krem) |
| `--ink` | `#1B1B1B` |
| `--accent` | `#E4572E` |
| `--line` | `#1B1B1B`, tebal 1.5 px |
| `--radius` | 0–4 px |
| `--shadow-btn` | `4px 4px 0 #1B1B1B` (hanya tombol utama) |
| Font judul | Bricolage Grotesque (tebal) |
| Font angka dan tabel | JetBrains Mono |

### 12.3 Aturan
- Label kecil huruf kapital berspasi, angka statistik berukuran besar.
- Status **Remedial** memakai warna aksen, **Tuntas** memakai tinta gelap.
- Ornamen khas: garis diagonal tipis "katrol" di header.
- Mode gelap memakai palet gelap yang senada.
- Semua warna dan spacing melalui CSS variables di `:root`.

## 13. Model Data

### 13.1 State

```js
state = {
  version: 1,
  kkm: 75,
  bobot: { ph: 40, pts: 30, pas: 30 },
  metode: "none", // "none" | "tambah" | "skalaMax" | "akar" | "minmax"
  param: { tambah: 5, minmaxMin: 70, minmaxMax: 100 },
  janganTurunkan: true,
  siswa: [
    { id: "s1", nama: "Nama", ph: 80, pts: 70, pas: 60 }
  ]
}
```

### 13.2 Penyimpanan
- Key: `katrollab:v1`, berisi JSON dari `state`.
- Saat muat: validasi struktur. Jika rusak, fallback ke state default.

### 13.3 Format CSV

Ekspor:

```
nama,ph,pts,pas,nilai_sebelum,nilai_sesudah,status
```

Impor (minimal): `nama,ph,pts,pas`. Pemisah koma, header wajib.

## 14. Arsitektur Teknis

- **Stack:** HTML, CSS, dan JavaScript vanilla dalam satu file `index.html`.
- **Library (opsional):** Chart.js 4.4.x via CDN jsDelivr dengan versi di-pin. Jika gagal memuat, grafik diganti bar sederhana buatan CSS.
- **Hosting:** Netlify Drop atau Vercel (drag and drop), hasilnya URL publik.
- **Struktur kode:** `/* STATE */ /* UTIL */ /* LOGIKA */ /* RENDER */ /* EVENT */ /* INIT */`.

### 14.1 Fungsi Utama

| Fungsi | Tugas |
|---|---|
| `hitungNilaiAkhir(siswa, bobot)` | Nilai akhir berbobot |
| `terapkanKatrol(nilai, metode, param, semuaNilai)` | Hasil katrol, di-clamp 0–100 |
| `hitungStatistik(daftarNilai, kkm)` | Rata-rata, maks, min, jumlah remedial |
| `validasiBobot(bobot)` | Total = 100 |
| `simpanState()` / `muatState()` | Persistensi |
| `isiDataContoh()` | 12 siswa fiktif realistis |
| `renderPengaturan/TabelSiswa/Hasil/Dampak/Semua()` | Render UI |
| `eksporCSV()` / `imporCSV(file)` | Ekspor dan impor |

### 14.2 Alur Data

`Input pengguna → update state → hitung → render → simpan ke localStorage`

## 15. Rencana Pengujian

### 15.1 Test Case Akseptasi

| ID | Skenario | Hasil yang diharapkan |
|---|---|---|
| TC-01 | PH 80, PTS 70, PAS 60, bobot 40/30/30 | Nilai akhir **71,0** |
| TC-02 | TC-01 + metode Tambah X=5 | **76,0**, status Tuntas (KKM 75) |
| TC-03 | Nilai 64, metode Akar | **80,0** |
| TC-04 | Nilai 64, min=50, maks=90, rentang 70–100 | **80,5** |
| TC-05 | Bobot 40/30/20 | Peringatan, hasil ditahan |
| TC-06 | Semua nilai akhir sama + metode min-max | Peringatan, nilai tidak berubah |
| TC-07 | Klik "Isi data contoh" | 12 baris, semua panel terisi |
| TC-08 | Refresh halaman | Data tetap ada |
| TC-09 | Klik Reset lalu konfirmasi | Data kosong, pengaturan default |
| TC-10 | Ekspor CSV lalu buka di Excel | Kolom rapi, karakter benar |
| TC-11 | Cetak | Muat A4, tombol tersembunyi |
| TC-12 | Layar 360 px | Tidak ada scroll samping di body |
| TC-13 | Opsi "jangan turunkan nilai" aktif | Tidak ada nilai yang turun |
| TC-14 | Input nilai 120 atau "abc" | Ditandai error, tidak dihitung |

### 15.2 Uji Manual Lintas Perangkat
Chrome desktop, Safari iOS, dan Chrome Android. Uji juga mode incognito untuk memastikan link terbuka.

## 16. Metrik Keberhasilan

| Metrik | Target |
|---|---|
| Waktu dari buka sampai hasil simulasi pertama | < 2 menit |
| Jumlah test case P0 yang lolos | 100% |
| Error pada console saat alur utama | 0 |
| Guru yang memberi ACC | 2 dari 4 (Pak Faris, Pak Wasis, Ms. Cindy, Ms. Shinta) |
| Link aplikasi dan slide terbuka di incognito | Ya |

## 17. Deliverables Tugas

| # | Deliverable | Catatan |
|---|---|---|
| 1 | Aplikasi web Katrol.Lab (URL publik) | Harus selesai hari ini |
| 2 | Poster desain, diunggah ke IG kelas | 1080×1350, bukan template mentah |
| 3 | Presentasi cara pakai (Canva atau Google Slides), 6 slide | Link di caption IG, akses "Anyone with the link: Viewer" |
| 4 | Caption IG berisi link aplikasi dan link slide | Link tidak terbuka berarti dianggap tidak mengumpulkan |
| 5 | ACC dari 2 guru | Tiap guru maksimal 6 kelompok |

**Kepatuhan aturan:** aplikasi unik (tidak sama dengan kelompok lain), desain tidak template AI, dan demo dilakukan tanpa mengganggu guru, kegiatan TKA, atau kegiatan belajar mengajar (hindari demerit).

## 18. Jadwal Pengerjaan (135 menit)

| Waktu | Aktivitas |
|---|---|
| 07.00–07.20 | Kunci ide, bagi tugas, siapkan prompt |
| 07.20–08.00 | Generate kerangka dan logika aplikasi, buat poster dan slide paralel |
| 08.00–08.15 | Poles desain |
| 08.15–08.25 | Deploy dan uji di HP dan laptop |
| 08.25–08.50 | Demo dan ACC ke 2 guru |
| 08.50–09.05 | Finalisasi poster, slide, dan unggah ke IG |
| 09.05–09.15 | Cek link di incognito dan buffer |

## 19. Risiko & Mitigasi

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Waktu tidak cukup | Aplikasi tidak selesai | Dahulukan fitur P0, lewati P1 dan P2 |
| Desain terlihat template AI | Kena penilaian desain | Terapkan design system bagian 12 secara ketat |
| Rumus katrol dianggap tidak adil | Guru menolak | Beri deskripsi tiap metode, opsi "jangan turunkan nilai", dan catatan etika |
| Link slide tidak bisa dibuka | Dianggap tidak mengumpulkan | Atur akses publik dan cek di incognito |
| Kuota ACC guru habis (6 kelompok per guru) | Telat ACC | Cari ACC lebih awal dan siapkan demo 1 menit |
| CDN grafik gagal dimuat | Grafik kosong | Fallback bar CSS |
| Demo mengganggu guru | Demerit | Demo saat jeda, tanpa suara, tidak berombongan |

## 20. Pertanyaan Terbuka

1. Apakah status Tuntas/Remedial sebaiknya memakai nilai bulat (bukan 1 desimal), sesuai kebiasaan rapor sekolah?
2. Perlukah komponen nilai tambahan (misalnya tugas atau praktik) selain PH, PTS, PAS?
3. Apakah satu skenario cukup, atau perlu dua skenario berdampingan (versi lanjutan)?

## 21. Glosarium

| Istilah | Arti |
|---|---|
| **KKM** | Kriteria Ketuntasan Minimal |
| **PH** | Penilaian Harian |
| **PTS** | Penilaian Tengah Semester |
| **PAS** | Penilaian Akhir Semester |
| **Katrol** | Penyesuaian nilai (menaikkan atau menyesuaikan sebaran) sesuai kebijakan guru atau sekolah |
| **Remedial** | Perbaikan bagi siswa yang nilainya di bawah KKM |
| **Clamp** | Membatasi nilai agar tetap dalam rentang tertentu (0–100) |
