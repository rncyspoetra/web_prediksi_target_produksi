<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataHistoris extends Model
{
    protected $table = 'data_historis';
    protected $primaryKey = 'id_data';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'total_tenaga',
        'tenaga_produktif',
        'jam_kerja',
        'target_produksi',
    ];

    public function prediksi()
    {
        return $this->hasOne(
            Prediksi::class,
            'id_data',
            'id_data'
        );
    }
}
