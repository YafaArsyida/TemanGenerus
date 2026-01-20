<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Desa extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'ms_desa'; // Nama tabel
    protected $primaryKey = 'ms_desa_id'; // Nama kolom primary key

    protected $fillable = [
        'nama_desa',
        'nama_masjid',
        'alamat',
        'peta',
        'deskripsi',
    ];

    public function ms_pengguna()
    {
        return $this->belongsToMany(User::class, 'ms_akses_pengguna', 'ms_desa_id', 'ms_pengguna_id')
            ->withTimestamps();
    }
    // Relasi baru
    public function ms_kelompok()
    {
        return $this->hasMany(Kelompok::class, 'ms_desa_id', 'ms_desa_id');
    }
    public function ms_kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'ms_desa_id', 'ms_desa_id');
    }
}
