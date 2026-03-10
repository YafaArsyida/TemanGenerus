<?php

namespace App\Http\Livewire\Laporan\Kelompok\KegiatanRutin\Report;

use App\Models\Kegiatan;
use App\Models\Kelompok;
use App\Models\PresensiKegiatan;
use Livewire\Component;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AttendanceMatrix extends Component
{
    public $ms_kegiatan_id;
    public $ms_kelompok_id;

    public $kegiatan;

    public $nama_kelompok = '-';

    public $search = '';
    public $gender = '';
    public $startDate;
    public $endDate;

    public $tanggalMatrix = [];

    protected $listeners = [
        'setParameter' => 'setParameter'
    ];

    public function setParameter($kegiatanId, $kelompokId)
    {
        $this->ms_kegiatan_id = $kegiatanId;
        $this->ms_kelompok_id = $kelompokId;

        // load kegiatan
        $this->kegiatan = Kegiatan::find($kegiatanId);

        // Default periode bulan ini
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate   = now()->endOfMonth()->format('Y-m-d');

        $kelompok = Kelompok::find($kelompokId);
        $this->nama_kelompok = $kelompok?->nama_kelompok ?? '-';

        $this->loadTanggalMatrix();
    }

    public function updatedStartDate()
    {
        $this->loadTanggalMatrix();

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Tanggal mulai diperbarui'
        ]);
    }

    public function updatedEndDate()
    {
        $this->loadTanggalMatrix();

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Tanggal akhir diperbarui'
        ]);
    }

    public function resetTanggal()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate   = now()->endOfMonth()->format('Y-m-d');

        $this->loadTanggalMatrix();

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Periode diperbarui'
        ]);
    }

    public function loadTanggalMatrix()
    {
        $this->tanggalMatrix = [];

        if (!$this->kegiatan || !$this->startDate || !$this->endDate) {
            return;
        }

        if (Carbon::parse($this->endDate)->lt(Carbon::parse($this->startDate))) {
            return;
        }

        $hariRutin = $this->kegiatan->hari_rutin ?? [];

        $period = CarbonPeriod::create($this->startDate, $this->endDate);

        foreach ($period as $tanggal) {

            $hari = strtolower($tanggal->locale('id')->dayName);

            if (in_array($hari, $hariRutin)) {
                $this->tanggalMatrix[] = $tanggal->format('Y-m-d');
            }
        }
    }
    
    public function getGenerusProperty()
    {
        if (!$this->kegiatan) return collect();

        $query = $this->kegiatan->targetPesertaQuery();

        if ($this->ms_kelompok_id) {
            $query->where('ms_kelompok_id', $this->ms_kelompok_id);
        }

        if ($this->search) {
            $query->where('nama_generus', 'like', "%{$this->search}%");
        }

        if ($this->gender) {
            $query->where('jenis_kelamin', $this->gender);
        }

        return $query
            ->with('ms_kelompok')
            ->orderBy('nama_generus')
            ->get();
    }

    public function getPresensiMapProperty()
    {
        if (!$this->ms_kegiatan_id) return collect();

        return PresensiKegiatan::where('ms_kegiatan_id', $this->ms_kegiatan_id)
            ->whereBetween('waktu_hadir', [$this->startDate, $this->endDate])
            ->get()
            ->keyBy(function ($item) {
                return $item->ms_generus_id . '_' . date('Y-m-d', strtotime($item->waktu_hadir));
            });
    }

    public function status($generusId, $tanggal)
    {
        $key = $generusId . '_' . $tanggal;

        if (!isset($this->presensiMap[$key])) {
            return 'A';
        }

        return $this->presensiMap[$key]->status_hadir;
    }
    
    public function render()
    {
        return view('livewire.laporan.kelompok.kegiatan-rutin.report.attendance-matrix',[
            'generusList' => $this->generus,
            'tanggalMatrix' => $this->tanggalMatrix
        ]);
    }
}
