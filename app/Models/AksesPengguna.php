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
        'ms_pengguna_id',
    ];

    public function ms_desa()
    {
        return $this->belongsTo(Desa::class, 'ms_desa_id', 'ms_desa_id');
    }
}
