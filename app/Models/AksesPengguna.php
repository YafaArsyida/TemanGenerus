<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesPengguna extends Model
{
    use HasFactory;
    protected $table = 'ms_akses_pengguna'; // Nama tabel
    protected $primaryKey = 'ms_akses_pengguna_id'; // Nama kolom primary key

    protected $fillable = [
        'ms_desa_id',
        'scope_type',
        'scope_id',
        'ms_pengguna_id',
    ];

    // relasi level
    public function ms_daerah()
    {
        return $this->belongsTo(Daerah::class, 'scope_id', 'ms_daerah_id');
    }

    public function ms_desa()
    {
        return $this->belongsTo(Desa::class, 'scope_id', 'ms_desa_id');
    }

    public function ms_kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'scope_id', 'ms_kelompok_id');
    }
}
