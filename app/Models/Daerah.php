<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daerah extends Model
{
    use HasFactory;
    protected $table = 'ms_daerah';
    protected $primaryKey = 'ms_daerah_id';

    protected $fillable = [
        'nama_daerah',
        'nama_masjid',
        'alamat',
        'peta',
        'deskripsi',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi (opsional, tapi disiapkan)
    |--------------------------------------------------------------------------
    */

    public function ms_desa()
    {
        return $this->hasMany(Desa::class, 'ms_daerah_id', 'ms_daerah_id');
    }
}
