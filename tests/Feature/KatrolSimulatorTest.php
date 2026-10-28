<?php

namespace Tests\Feature;

use App\Models\Siswa;
use App\Services\KatrolService;
use Tests\TestCase;

class KatrolSimulatorTest extends TestCase
{
    public function test_halaman_simulator_berhasil_dimuat(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Katrol.Lab');
        $response->assertSee('Standar Kelulusan');
        $response->assertSee('Lembar Nilai Komponen Siswa');
    }

    public function test_api_reset_siswa_mengembalikan_12_data_contoh(): void
    {
        $response = $this->postJson('/api/siswa/reset');
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $this->assertEquals(12, Siswa::count());
    }

    public function test_api_simpan_siswa_memperbarui_database(): void
    {
        $payload = [
            'siswa' => [
                ['nama' => 'Test Siswa Baru', 'nis' => '9999', 'ph' => 88, 'pts' => 85, 'pas' => 90],
            ],
            'syncAll' => false,
        ];

        $response = $this->postJson('/api/siswa/simpan', $payload);
        $response->assertStatus(200);
        $this->assertDatabaseHas('siswas', ['nama' => 'Test Siswa Baru']);
    }

    public function test_api_simpan_riwayat_simulasi(): void
    {
        $payload = [
            'judul' => 'Uji Coba Katrol PAS Ganjil',
            'kkm' => 75,
            'bobot_ph' => 40,
            'bobot_pts' => 30,
            'bobot_pas' => 30,
            'metode' => 'tambah',
            'parameter' => ['tambah' => 5],
            'ringkasan_statistik' => ['rataSesudah' => 80.5],
        ];

        $response = $this->postJson('/api/simulasi/simpan', $payload);
        $response->assertStatus(200);
        $this->assertDatabaseHas('simulasi_katrols', ['judul' => 'Uji Coba Katrol PAS Ganjil']);
    }

    public function test_layanan_katrol_service(): void
    {
        $service = new KatrolService();

        // Uji nilai akhir murni: (80*40 + 70*30 + 90*30) / 100 = (32 + 21 + 27) = 80.0
        $na = $service->hitungNilaiAkhir(80, 70, 90, ['ph' => 40, 'pts' => 30, 'pas' => 30]);
        $this->assertEquals(80.0, $na);

        // Uji metode tambah 5 poin: 80 + 5 = 85.0
        $katrolTambah = $service->terapkanKatrol(80.0, 'tambah', ['tambah' => 5]);
        $this->assertEquals(85.0, $katrolTambah);

        // Uji clamping maksimum 100: 98 + 5 = 103 -> clamp ke 100.0
        $katrolClamp = $service->terapkanKatrol(98.0, 'tambah', ['tambah' => 5]);
        $this->assertEquals(100.0, $katrolClamp);

        // Uji validasi bobot
        $validasiBenar = $service->validasiBobot(['ph' => 40, 'pts' => 30, 'pas' => 30]);
        $this->assertTrue($validasiBenar['valid']);
        $this->assertEquals(100, $validasiBenar['total']);
    }
}

