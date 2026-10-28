# Katrol.Lab

Simulator Katrol dan Bobot Nilai untuk guru SMA/SMK Indonesia.

Aplikasi web berbasis satu berkas (single file `index.html`) tanpa dependensi build tool, backend, atau framework. Dibangun dengan pendekatan visual editorial bertema lembar kerja cetak, tipografi berkarakter (Bricolage Grotesque & JetBrains Mono), palet krem-tinta-oranye, dan Chart.js 4.4.2 untuk visualisasi perbandingan sebaran nilai.

## Fitur Kerangka (Skeleton)
- **Header**: Tagline, ornamen garis diagonal katrol, tombol isi data contoh, dan reset.
- **Panel 1 - Pengaturan**: Konfigurasi KKM (default 75), bobot komponen PH/PTS/PAS dengan indikator validasi 100%, serta 5 pilihan metode katrol dan parameter dinamis.
- **Panel 2 - Data Siswa**: Tabel data siswa interaktif (tambah baris, edit inline, hapus baris) dan tombol impor CSV placeholder.
- **Panel 3 - Hasil**: Tabel komparasi nilai awal vs nilai setelah katrol beserta status Tuntas atau Remedial.
- **Panel 4 - Dampak**: Kartu statistik perubahan (jumlah remedial, rata-rata, nilai tertinggi/terendah) dan grafik histogram sebaran nilai.
- **Penyimpanan**: Menggunakan `localStorage` browser dengan kunci `katrollab:v1`.

## Menjalankan Aplikasi
Buka berkas `index.html` langsung di peramban web modern (Chrome, Firefox, Safari, Edge).
