<?php

namespace App\Http\Controllers;

use App\Models\ProfilGuru;
use App\Models\Siswa;
use App\Models\SimulasiKatrol;
use App\Services\KatrolService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KatrolController extends Controller
{
    protected KatrolService $service;

    public function __construct(KatrolService $service)
    {
        $this->service = $service;
    }

    /**
     * Halaman Landing / Beranda publik.
     */
    public function home()
    {
        $profil = ProfilGuru::first();
        return view('home', compact('profil'));
    }

    /**
     * Halaman utama Workbench Simulator Katrol.Lab.
     */
    public function index()
    {
        $siswa = Siswa::orderBy('id', 'asc')->get();
        $riwayat = SimulasiKatrol::latest()->take(5)->get();
        $profil = ProfilGuru::first();

        $defaultSettings = [
            'kkm' => $profil ? $profil->default_kkm : 75,
            'bobot' => [
                'ph' => $profil ? $profil->default_bobot_ph : 40,
                'pts' => $profil ? $profil->default_bobot_pts : 30,
                'pas' => $profil ? $profil->default_bobot_pas : 30,
            ],
            'metode' => $profil ? $profil->default_metode : 'none',
            'janganTurunkan' => $profil ? (bool)$profil->default_jangan_turunkan : true,
            'param' => ['tambah' => 5, 'minmaxMin' => 70, 'minmaxMax' => 100],
        ];

        return view('simulator', compact('siswa', 'riwayat', 'defaultSettings', 'profil'));
    }

    /**
     * Halaman Modul Profil Guru.
     */
    public function profil()
    {
        $profil = ProfilGuru::first() ?? new ProfilGuru([
            'default_kkm' => 75,
            'default_bobot_ph' => 40,
            'default_bobot_pts' => 30,
            'default_bobot_pas' => 30,
            'default_metode' => 'none',
            'default_jangan_turunkan' => true,
        ]);

        return view('profil', compact('profil'));
    }

    /**
     * Simpan pembaruan profil guru ke database SQLite.
     */
    public function simpanProfil(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'nullable|string|max:50',
            'sekolah' => 'nullable|string|max:150',
            'mapel' => 'nullable|string|max:100',
            'kelas' => 'nullable|string|max:50',
            'tahun_ajaran' => ['nullable', 'string', 'regex:/^\d{4}\/\d{4}$/'],
            'semester' => 'nullable|string|max:20',
            'default_kkm' => 'required|integer|min:0|max:100',
            'default_bobot_ph' => 'required|integer|min:0|max:100',
            'default_bobot_pts' => 'required|integer|min:0|max:100',
            'default_bobot_pas' => 'required|integer|min:0|max:100',
            'default_metode' => 'required|string|in:none,tambah,skalaMax,akar,minmax',
            'default_jangan_turunkan' => 'nullable|boolean',
        ], [
            'nama.required' => 'Nama lengkap guru wajib diisi.',
            'tahun_ajaran.regex' => 'Format tahun ajaran harus YYYY/YYYY (contoh: 2024/2025).',
        ]);

        $totalBobot = (int)$validated['default_bobot_ph'] + (int)$validated['default_bobot_pts'] + (int)$validated['default_bobot_pas'];
        if ($totalBobot !== 100) {
            return response()->json([
                'success' => false,
                'message' => 'Total bobot default PH, PTS, dan PAS harus tepat 100% (saat ini: ' . $totalBobot . '%).'
            ], 422);
        }

        $validated['default_jangan_turunkan'] = $request->boolean('default_jangan_turunkan', true);

        $profil = ProfilGuru::first();
        if ($profil) {
            $profil->update($validated);
        } else {
            $profil = ProfilGuru::create($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profil dan preferensi guru berhasil disimpan.',
            'data' => $profil
        ]);
    }

    /**
     * Simpan pembaruan data siswa secara massal ke database.
     */
    public function simpanSiswa(Request $request): JsonResponse
    {
        $dataSiswa = $request->input('siswa', []);

        if (!is_array($dataSiswa)) {
            return response()->json(['success' => false, 'message' => 'Format data tidak valid'], 422);
        }

        $savedIds = [];
        foreach ($dataSiswa as $item) {
            $nama = trim($item['nama'] ?? '');
            if (empty($nama)) continue;

            $record = null;
            if (!empty($item['id']) && is_numeric($item['id'])) {
                $record = Siswa::find($item['id']);
            }

            $payload = [
                'nama' => $nama,
                'nis' => $item['nis'] ?? null,
                'ph' => (float)($item['ph'] ?? 0),
                'pts' => (float)($item['pts'] ?? 0),
                'pas' => (float)($item['pas'] ?? 0),
            ];

            if ($record) {
                $record->update($payload);
                $savedIds[] = $record->id;
            } else {
                $baru = Siswa::create($payload);
                $savedIds[] = $baru->id;
            }
        }

        // Hapus siswa yang tidak ada di daftar kiriman jika dikirimkan semua
        if ($request->boolean('syncAll', false) && !empty($savedIds)) {
            Siswa::whereNotIn('id', $savedIds)->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil disimpan ke database SQLite',
            'data' => Siswa::orderBy('id', 'asc')->get()
        ]);
    }

    /**
     * Reset data siswa ke 12 data contoh realistis.
     */
    public function resetSiswa(): JsonResponse
    {
        Siswa::truncate();

        $dataContoh = [
            ['nama' => 'Ahmad Fauzi', 'nis' => '1001', 'ph' => 70, 'pts' => 65, 'pas' => 68],
            ['nama' => 'Siti Nurhaliza', 'nis' => '1002', 'ph' => 85, 'pts' => 88, 'pas' => 82],
            ['nama' => 'Budi Santoso', 'nis' => '1003', 'ph' => 60, 'pts' => 55, 'pas' => 58],
            ['nama' => 'Dewi Lestari', 'nis' => '1004', 'ph' => 90, 'pts' => 92, 'pas' => 88],
            ['nama' => 'Eko Prasetyo', 'nis' => '1005', 'ph' => 72, 'pts' => 70, 'pas' => 68],
            ['nama' => 'Fitri Handayani', 'nis' => '1006', 'ph' => 78, 'pts' => 80, 'pas' => 76],
            ['nama' => 'Gilang Ramadhan', 'nis' => '1007', 'ph' => 58, 'pts' => 62, 'pas' => 54],
            ['nama' => 'Hani Wijaya', 'nis' => '1008', 'ph' => 92, 'pts' => 95, 'pas' => 90],
            ['nama' => 'I Made Artha', 'nis' => '1009', 'ph' => 75, 'pts' => 74, 'pas' => 76],
            ['nama' => 'Joko Supriyadi', 'nis' => '1010', 'ph' => 64, 'pts' => 60, 'pas' => 62],
            ['nama' => 'Kartika Putri', 'nis' => '1011', 'ph' => 82, 'pts' => 84, 'pas' => 80],
            ['nama' => 'Larasati Kusuma', 'nis' => '1012', 'ph' => 88, 'pts' => 85, 'pas' => 86],
        ];

        foreach ($dataContoh as $item) {
            Siswa::create($item);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil direset ke 12 data contoh standar',
            'data' => Siswa::orderBy('id', 'asc')->get()
        ]);
    }

    /**
     * Simpan log riwayat simulasi katrol ke database.
     */
    public function simpanSimulasi(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'judul' => 'nullable|string|max:100',
            'kkm' => 'required|integer',
            'bobot_ph' => 'required|integer',
            'bobot_pts' => 'required|integer',
            'bobot_pas' => 'required|integer',
            'metode' => 'required|string',
            'parameter' => 'nullable|array',
            'ringkasan_statistik' => 'nullable|array',
        ]);

        $simulasi = SimulasiKatrol::create([
            'judul' => $validated['judul'] ?? ('Simulasi ' . date('d M Y H:i')),
            'kkm' => $validated['kkm'],
            'bobot_ph' => $validated['bobot_ph'],
            'bobot_pts' => $validated['bobot_pts'],
            'bobot_pas' => $validated['bobot_pas'],
            'metode' => $validated['metode'],
            'parameter' => $validated['parameter'] ?? [],
            'ringkasan_statistik' => $validated['ringkasan_statistik'] ?? [],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Riwayat simulasi berhasil disimpan',
            'data' => $simulasi
        ]);
    }

    /**
     * Ekspor lembar hasil katrol ke berkas CSV.
     */
    public function eksporCSV(Request $request): StreamedResponse
    {
        $barisData = $request->input('data', []);
        $namaFile = 'KatrolLab_Hasil_' . date('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($barisData) {
            $handle = fopen('php://output', 'w');
            // Menambahkan BOM UTF-8 agar kompatibel dengan Microsoft Excel
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, ['No', 'Nama Siswa', 'PH', 'PTS', 'PAS', 'Nilai Awal', 'Status Awal', 'Nilai Katrol', 'Status Akhir', 'Selisih']);

            foreach ($barisData as $i => $row) {
                fputcsv($handle, [
                    $i + 1,
                    $row['nama'] ?? '',
                    $row['ph'] ?? 0,
                    $row['pts'] ?? 0,
                    $row['pas'] ?? 0,
                    $row['nilaiAwal'] ?? 0,
                    $row['statusAwal'] ?? '',
                    $row['nilaiKatrol'] ?? 0,
                    $row['statusAkhir'] ?? '',
                    $row['selisih'] ?? 0,
                ]);
            }

            fclose($handle);
        }, $namaFile, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$namaFile}\"",
        ]);
    }
}
