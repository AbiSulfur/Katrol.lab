<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulasiKatrol extends Model
{
    use HasFactory;

    protected $table = 'simulasi_katrols';

    protected $fillable = [
        'judul',
        'kkm',
        'bobot_ph',
        'bobot_pts',
        'bobot_pas',
        'metode',
        'parameter',
        'ringkasan_statistik',
    ];

    protected $casts = [
        'parameter' => 'array',
        'ringkasan_statistik' => 'array',
        'kkm' => 'integer',
        'bobot_ph' => 'integer',
        'bobot_pts' => 'integer',
        'bobot_pas' => 'integer',
    ];
}
