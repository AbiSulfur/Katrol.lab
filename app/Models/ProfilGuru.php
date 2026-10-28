<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilGuru extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip',
        'sekolah',
        'mapel',
        'kelas',
        'tahun_ajaran',
        'semester',
        'default_kkm',
        'default_bobot_ph',
        'default_bobot_pts',
        'default_bobot_pas',
        'default_metode',
        'default_jangan_turunkan',
    ];

    protected $casts = [
        'default_kkm' => 'integer',
        'default_bobot_ph' => 'integer',
        'default_bobot_pts' => 'integer',
        'default_bobot_pas' => 'integer',
        'default_jangan_turunkan' => 'boolean',
    ];
}
