<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrediksiTarget extends Model
{
    protected $table = 'prediksi_target';
    protected $primaryKey = 'id_prediksi_target';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'tanggal',
        'total_tenaga',
        'tenaga_produktif',
        'jam_kerja',
        'hasil_prediksi',
    ];

    public function getRouteKeyName()
    {
        return 'id_prediksi_target';
    }
}
