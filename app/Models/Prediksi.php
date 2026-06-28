<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prediksi extends Model
{
    use HasFactory;
    protected $table = 'prediksi';
    protected $primaryKey = 'id_prediksi';
    public $timestamps = false;

    protected $fillable = [
        'id_data',
        'hasil_prediksi',
        'nilai_error',
        'persentase_error',
    ];

    public function dataHistoris()
    {
        return $this->belongsTo(
            DataHistoris::class,
            'id_data',
            'id_data'
        );
    }
}
