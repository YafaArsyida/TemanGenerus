<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kegiatan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ms_kegiatan'; // Nama tabel
    protected $primaryKey = 'ms_kegiatan_id'; // Nama kolom primary key

    protected $fillable = [
        'scope',
        'token',
        'ms_kelompok_id', //di isi ketika khusus acara kelmpok
        'ms_desa_id', //di isi ketika khusus acara desa
        'nama_kegiatan',
        'jenjang',
        'tempat',
        'alamat',
        'peta',
        'tanggal',
        'waktu',
        'status',
        'deskripsi',
    ];
    protected static function booted()
    {
        static::creating(function ($kegiatan) {
            if (empty($kegiatan->token)) {
                $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
                do {
                    $token = '';
                    for ($i = 0; $i < 8; $i++) {
                        $token .= $chars[random_int(0, strlen($chars) - 1)];
                    }
                    $kegiatan->token = $token;
                } while (self::where('token', $token)->exists());
            }
        });
    }
    public function ms_kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'ms_kelompok_id', 'ms_kelompok_id');
    }

    /** 🔗 Relasi ke Desa */
    public function ms_desa()
    {
        return $this->belongsTo(Desa::class, 'ms_desa_id', 'ms_desa_id');
    }

    // Lokasi final
    public function getLokasiFinalAttribute(): array
    {
        // 1️⃣ Custom dari kegiatan
        if ($this->tempat || $this->alamat || $this->peta) {
            return [
                'tempat' => $this->tempat ?? '-',
                'alamat' => $this->alamat ?? '-',
                'peta' => $this->peta,
            ];
        }

        // 2️⃣ Scope kelompok
        if ($this->scope === 'kelompok' && $this->ms_kelompok) {
            return [
                'tempat' => $this->ms_kelompok->nama_masjid ?? '-',
                'alamat' => $this->ms_kelompok->alamat ?? '-',
                'peta' => $this->ms_kelompok->peta,
            ];
        }

        // 3️⃣ Scope desa
        if ($this->scope === 'desa' && $this->ms_desa) {
            return [
                'tempat' => $this->ms_desa->nama_masjid ?? '-',
                'alamat' => $this->ms_desa->alamat ?? '-',
                'peta' => $this->ms_desa->peta,
            ];
        }

        // 4️⃣ Scope daerah (hardcode)
        if ($this->scope === 'daerah') {
            return [
                'tempat' => 'Masjid Roudhotul Jannah Solo Selatan',
                'alamat' => 'Jl. Porong, Pucangsawit, Kec. Jebres, Kota Surakarta, Jawa Tengah 57125',
                'peta' => 'https://maps.app.goo.gl/UMT2cpkYGkmrKYVn7',
            ];
        }

        // Default fallback
        return [
            'tempat' => '-',
            'alamat' => '-',
            'peta'   => null,
        ];
    }
}
