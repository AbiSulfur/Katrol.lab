# Katrol.Lab (Laravel 12 Edition)

Simulator Katrol dan Bobot Nilai untuk guru SMA/SMK Indonesia berbasis **Laravel 12**, **Tailwind CSS**, dan **Alpine.js**.

Mengusung konsep antarmuka **Bento Grid & Modern Academic Ledger** dengan kalkulasi real-time interaktif, integrasi database SQLite, dan visualisasi distribusi perbandingan sebaran nilai menggunakan Chart.js.

---

## Arsitektur & Teknologi
- **Backend Framework**: Laravel 12 (PHP 8.3+)
- **Database**: SQLite (termasuk migrasi tabel `siswas` dan `simulasi_katrols`)
- **Frontend Reactive**: Alpine.js (kalkulasi simulasi real-time per keystroke tanpa jeda jaringan)
- **Styling**: Tailwind CSS via Vite
- **Chart & Visualisasi**: Chart.js (histogram sebaran frekuensi nilai)
- **Tipografi**:
  - `Bricolage Grotesque` (Judul dan brand)
  - `JetBrains Mono` (Angka nilai, tabel, dan statistik)
  - `Plus Jakarta Sans` (Teks antarmuka)

---

## Fitur Utama

1. **Bento Grid Dashboard**:
   - Tata letak asimetris dan modular yang mempertemukan kontrol bobot, pilihan formula katrol, metrik dampak, dan tabel lembar kerja.
2. **Standar Kelulusan & Bobot Interaktif**:
   - Konfigurasi KKM (default 75) dan distribusi bobot komponen (PH, PTS, PAS) dengan validasi total 100% dan indikator visual progress bar.
3. **5 Metode Katrol Standar Guru**:
   - Murni (Tanpa Katrol)
   - Tambah Poin Tetap (+X) dengan parameter dinamis
   - Skala ke Nilai Tertinggi Kelas (Nilai / Max &times; 100)
   - Transformasi Akar Kuadrat (&radic;Nilai &times; 10)
   - Pemetaan Min-Max ke Target Rentang [A, B]
4. **4 Kartu Metrik Dampak**:
   - Perbandingan Siswa Remedial (Sebelum &rarr; Sesudah Katrol)
   - Rata-Rata Nilai Kelas dengan selisih poin
   - Nilai Tertinggi dan Terendah
5. **Lembar Nilai Komponen Siswa**:
   - Tabel dapat diedit langsung (inline editable) dengan kalkulasi otomatis.
   - Tombol tambah siswa dan hapus siswa per baris.
   - Tombol simpan perubahan massal ke SQLite.
6. **Ekspor & Cetak**:
   - Ekspor lembar hasil komparasi ke berkas CSV (UTF-8 BOM siap Excel).
   - Cetak laporan siap pakai (ramah printer, tombol otomatis tersembunyi).
7. **Tema Gelap & Terang**:
   - Tombol alih tema dengan persistensi di browser dan warna kontras tinggi standar WCAG 2.1 AA.

---

## Menjalankan Proyek

### 1. Jalankan Server Pengembangan Laravel
```bash
php artisan serve
```
Akses aplikasi melalui peramban di `http://127.0.0.1:8000` atau melalui virtual host Laragon di `http://app-guru.test`.

### 2. Jalankan Build Asset (Jika Melakukan Kustomisasi)
```bash
npm run build
# atau untuk dev server:
npm run dev
```

### 3. Menjalankan Unit & Feature Test
```bash
php artisan test
```
