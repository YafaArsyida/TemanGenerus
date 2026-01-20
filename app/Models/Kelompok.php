<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelompok extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ms_kelompok';
    protected $primaryKey = 'ms_kelompok_id';
    protected $fillable = [
        'ms_desa_id',
        'nama_kelompok',
        'nama_masjid',
        'alamat',
        'peta',
        'deskripsi',
    ];

    public function ms_generus()
    {
        return $this->hasMany(Generus::class, 'ms_kelompok_id', 'ms_kelompok_id');
    }

    public function jumlah_generus()
    {
        return $this->ms_generus()->count();
    }

    public function ms_desa()
    {
        return $this->belongsTo(Desa::class, 'ms_desa_id', 'ms_desa_id');
    }

    public function ms_kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'ms_kelompok_id', 'ms_kelompok_id');
    }
}
