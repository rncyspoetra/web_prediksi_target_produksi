<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerhitunganRegresi extends Model
{
    use HasFactory;
    protected $table = 'perhitungan_regresi';
    protected $primaryKey = 'id_perhitungan_regresi';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'intercept',
        'beta1',
        'beta2',
        'beta3',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
