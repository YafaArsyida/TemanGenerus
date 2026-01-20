<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Generus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ms_generus'; // Nama tabel
    protected $primaryKey = 'ms_generus_id'; // Nama kolom primary key

    protected $fillable = [
        'ms_kelompok_id',
        'nama_generus',
        'nomor_kartu',
        'nomor_telepon',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'deskripsi',
    ];

    public static function jenjangUsiaMap(): array
    {
        return [
            'caberawit' => [0, 11],
            'remaja'    => [12, 30],
            'gp'        => [12, 23],
            'pra_nikah' => [19, 23],
            'mandiri'   => [23, 30],
        ];
    }

    public function getUsiaAttribute(): ?int
    {
        return $this->tanggal_lahir
            ? Carbon::parse($this->tanggal_lahir)->age
            : null;
    }

    public function getJenjangUsiaAttribute(): array
    {
        if (!$this->usia) {
            return [];
        }

        $jenjang = [];

        foreach (self::jenjangUsiaMap() as $nama => [$min, $max]) {
            if ($this->usia >= $min && $this->usia <= $max) {
                $jenjang[] = $nama;
            }
        }

        return $jenjang;
    }
    public function ms_kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'ms_kelompok_id', 'ms_kelompok_id');
    }
}
