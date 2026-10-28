<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'nama',
        'nis',
        'ph',
        'pts',
        'pas',
    ];

    protected $casts = [
        'ph' => 'float',
        'pts' => 'float',
        'pas' => 'float',
    ];
}
