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

        'tipe_kegiatan',     // ENUM('rutin','sekali')
        'hari_rutin',
        
        'deskripsi',
    ];

    protected $casts = [
        'hari_rutin' => 'array',
    ];

    public function getHariLabelAttribute()
    {
        if ($this->tipe_kegiatan !== 'rutin' || empty($this->hari_rutin)) {
            return null;
        }

        $map = [
            'senin'  => 'Senin',
            'selasa' => 'Selasa',
            'rabu'   => 'Rabu',
            'kamis'  => 'Kamis',
            'jumat'  => 'Jumat',
            'sabtu'  => 'Sabtu',
            'minggu' => 'Minggu',
        ];

        $labels = collect($this->hari_rutin)
            ->map(fn($h) => $map[$h] ?? ucfirst($h))
            ->implode(', ');

        return $labels;
    }

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

    public function ms_presensi()
    {
        return $this->hasMany(PresensiKegiatan::class, 'ms_kegiatan_id');
    }

    public function targetPesertaQuery()
    {
        $query = Generus::query()->with('ms_kelompok.ms_desa');

        // Scope kegiatan
        if ($this->scope === 'desa' && $this->ms_desa_id) {
            $query->whereHas('ms_kelompok', function ($q) {
                $q->where('ms_desa_id', $this->ms_desa_id);
            });
        }

        if ($this->scope === 'kelompok' && $this->ms_kelompok_id) {
            $query->where('ms_kelompok_id', $this->ms_kelompok_id);
        }

        // Jenjang usia
        if ($this->jenjang && $this->jenjang !== 'semua') {
            [$min, $max] = Generus::jenjangUsiaMap()[$this->jenjang] ?? [0, 100];

            $startDate = now()->subYears($max)->startOfDay();
            $endDate   = now()->subYears($min)->endOfDay();

            $query->whereBetween('tanggal_lahir', [$startDate, $endDate]);
        }

        return $query;
    }

    /**
     * Total target peserta sesuai scope + jenjang kegiatan
     */
    public function targetPeserta()
    {
        return $this->targetPesertaQuery()->count();
    }

    /**
     * Total hadir global
     */
    public function totalHadir()
    {
        return $this->ms_presensi()
            ->where('status_hadir', 'hadir')
            ->count();
    }

    /**
     * Total izin global
     */
    public function totalIzin()
    {
        return $this->ms_presensi()
            ->where('status_hadir', 'izin')
            ->count();
    }

    /**
     * Total alfa global
     * Alfa = target - (hadir + izin + sakit)
     */
    public function totalAlfa()
    {
        $target = $this->targetPeserta();

        $hadirIzinSakit = $this->ms_presensi()
            ->whereIn('status_hadir', ['hadir', 'izin', 'sakit'])
            ->count();

        return max(0, $target - $hadirIzinSakit);
    }

    /**
     * Presentase hadir global
     */
    public function presentaseHadir()
    {
        $target = $this->targetPeserta();
        if ($target == 0) return 0;

        return round(($this->totalHadir() / $target) * 100, 1);
    }

    /**
     * Presentase izin global
     */
    public function presentaseIzin()
    {
        $target = $this->targetPeserta();
        if ($target == 0) return 0;

        return round(($this->totalIzin() / $target) * 100, 1);
    }

    /**
     * Presentase alfa global
     */
    public function presentaseAlfa()
    {
        $target = $this->targetPeserta();
        if ($target == 0) return 0;

        return round(($this->totalAlfa() / $target) * 100, 1);
    }

    public function insightGlobal()
    {
        $p = $this->presentaseHadir();

        if ($p >= 85) return "🔥 Partisipasi Kegiatan sangat baik";
        if ($p >= 65) return "👍 Partisipasi Kegiatan cukup baik";
        if ($p >= 40) return "⚠️ Partisipasi Kegiatan rendah";
        return "🚨 Partisipasi Kegiatan sangat rendah, perlu evaluasi";
    }
}
