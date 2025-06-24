<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorLog extends Model
{
    protected $fillable = [
        'logged_at',
        'suhu',
        'kelembapan',
        'kecepatan_angin',
        'debit_air',
        'ketinggian_air',
        'curah_hujan',
        'source',
        'created_at',
        'updated_at',
    ];
}
