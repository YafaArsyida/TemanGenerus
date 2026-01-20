<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiKegiatan extends Model
{
    use HasFactory;

    protected $table = 'ms_presensi_kegiatan'; // Nama tabel
    protected $primaryKey = 'ms_presensi_kegiatan_id'; // Nama kolom primary key

    protected $fillable = [
        'ms_kegiatan_id',
        'ms_generus_id',
        'waktu_hadir',
        'status_hadir',
        'verifikasi',  //kartu, manual
        'deskripsi',
    ];

    public function ms_kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'ms_kegiatan_id', 'ms_kegiatan_id');
    }

    public function ms_generus()
    {
        return $this->belongsTo(Generus::class, 'ms_generus_id', 'ms_generus_id');
    }
}
