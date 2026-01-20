<?php

namespace App\Imports;

use App\Http\Controllers\HelperController;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ImportGenerus implements ToCollection, WithHeadingRow
{
    protected $generusCollection;

    public function __construct()
    {
        $this->generusCollection = collect();
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // Skip baris kosong
            if (empty($row['nama_generus'])) {
                continue;
            }

            $this->generusCollection->push([
                'nama_generus'   => trim($row['nama_generus']),
                'nomor_telepon'    => HelperController::normalizePhoneNumber($row['nomor_telepon'] ?? null), // Normalisasi telepon
                'tempat_lahir'  => trim($row['tempat_lahir'] ?? null),
                'tanggal_lahir' => $this->parseDate($row['tanggal_lahir'] ?? null),
                'jenis_kelamin' => $this->normalizeGender($row['jenis_kelamin'] ?? null),
            ]);
        }
    }

    protected function normalizePhone($phone)
    {
        if (!$phone) {
            return null;
        }

        // hapus spasi, strip, dll
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // contoh normalisasi Indonesia
        if (str_starts_with($phone, '62')) {
            return $phone;
        }

        if (str_starts_with($phone, '0')) {
            return '62' . substr($phone, 1);
        }

        return $phone;
    }

    protected function normalizeGender($gender)
    {
        if (!$gender) {
            return null;
        }

        $gender = strtolower(trim($gender));

        return match ($gender) {
            'l', 'laki', 'laki-laki', 'pria' => 'laki-laki',
            'p', 'perempuan', 'wanita'      => 'perempuan',
            default                         => 'laki-laki',
        };
    }

    protected function parseDate($value)
    {
        if (!$value) {
            return null;
        }

        // Kalau format Excel serial number
        if (is_numeric($value)) {
            try {
                return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        // Kalau string tanggal biasa
        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getCollection()
    {
        return $this->generusCollection;
    }
}
