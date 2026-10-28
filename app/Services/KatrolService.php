<?php

namespace App\Services;

class KatrolService
{
    /**
     * Hitung Nilai Akhir murni berdasarkan persentase bobot PH, PTS, dan PAS.
     */
    public function hitungNilaiAkhir(float $ph, float $pts, float $pas, array $bobot): float
    {
        $wPh = (float)($bobot['ph'] ?? 40);
        $wPts = (float)($bobot['pts'] ?? 30);
        $wPas = (float)($bobot['pas'] ?? 30);

        $nilai = ($ph * $wPh + $pts * $wPts + $pas * $wPas) / 100.0;
        return round($nilai, 1);
    }

    /**
     * Terapkan rumus metode katrol ke suatu nilai dengan clamping 0 - 100.
     */
    public function terapkanKatrol(float $nilai, string $metode, array $param = [], array $semuaNilai = []): float
    {
        $hasil = $nilai;

        switch ($metode) {
            case 'tambah':
                $bonus = (float)($param['tambah'] ?? 5);
                $hasil = $nilai + $bonus;
                break;

            case 'skalaMax':
                $max = !empty($semuaNilai) ? max($semuaNilai) : 85.0;
                $max = $max > 0 ? $max : 100.0;
                $hasil = ($nilai / $max) * 100.0;
                break;

            case 'akar':
                $hasil = sqrt(max(0, $nilai)) * 10.0;
                break;

            case 'minmax':
                $minTarget = (float)($param['minmaxMin'] ?? 70);
                $maxTarget = (float)($param['minmaxMax'] ?? 100);
                $minAsal = !empty($semuaNilai) ? min($semuaNilai) : 50.0;
                $maxAsal = !empty($semuaNilai) ? max($semuaNilai) : 95.0;
                $rentangAsal = ($maxAsal - $minAsal) ?: 1.0;
                $hasil = $minTarget + (($nilai - $minAsal) / $rentangAsal) * ($maxTarget - $minTarget);
                break;

            case 'none':
            default:
                $hasil = $nilai;
                break;
        }

        // Clamp nilai ke interval 0 sampai 100
        $clamped = min(100.0, max(0.0, $hasil));
        return round($clamped, 1);
    }

    /**
     * Hitung agregasi statistik komparasi sebelum vs sesudah katrol.
     */
    public function hitungStatistik(array $pasanganNilai, int $kkm = 75): array
    {
        if (empty($pasanganNilai)) {
            return [
                'remedialSebelum' => 0,
                'remedialSesudah' => 0,
                'rataSebelum' => 0.0,
                'rataSesudah' => 0.0,
                'tertinggiSebelum' => 0.0,
                'tertinggiSesudah' => 0.0,
                'terendahSebelum' => 0.0,
                'terendahSesudah' => 0.0,
                'sebaranSebelum' => [0, 0, 0, 0, 0],
                'sebaranSesudah' => [0, 0, 0, 0, 0],
            ];
        }

        $sebelum = array_column($pasanganNilai, 'sebelum');
        $sesudah = array_column($pasanganNilai, 'sesudah');

        $hitungRemed = fn(array $arr) => count(array_filter($arr, fn($n) => $n < $kkm));
        $hitungRata = fn(array $arr) => count($arr) > 0 ? round(array_sum($arr) / count($arr), 1) : 0.0;

        $hitungSebaran = function (array $arr) {
            $bins = [0, 0, 0, 0, 0];
            foreach ($arr as $val) {
                if ($val < 60) $bins[0]++;
                elseif ($val < 70) $bins[1]++;
                elseif ($val < 75) $bins[2]++;
                elseif ($val < 85) $bins[3]++;
                else $bins[4]++;
            }
            return $bins;
        };

        return [
            'remedialSebelum' => $hitungRemed($sebelum),
            'remedialSesudah' => $hitungRemed($sesudah),
            'rataSebelum' => $hitungRata($sebelum),
            'rataSesudah' => $hitungRata($sesudah),
            'tertinggiSebelum' => round(max($sebelum), 1),
            'tertinggiSesudah' => round(max($sesudah), 1),
            'terendahSebelum' => round(min($sebelum), 1),
            'terendahSesudah' => round(min($sesudah), 1),
            'sebaranSebelum' => $hitungSebaran($sebelum),
            'sebaranSesudah' => $hitungSebaran($sesudah),
        ];
    }

    /**
     * Validasi total bobot komponen nilai.
     */
    public function validasiBobot(array $bobot): array
    {
        $ph = (int)($bobot['ph'] ?? 0);
        $pts = (int)($bobot['pts'] ?? 0);
        $pas = (int)($bobot['pas'] ?? 0);
        $total = $ph + $pts + $pas;

        return [
            'valid' => ($total === 100),
            'total' => $total,
        ];
    }
}

