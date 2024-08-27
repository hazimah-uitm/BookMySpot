<?php

namespace App\Exports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StaffExport implements FromCollection, WithHeadings, WithMapping
{
    protected $type;
    protected $attendance;
    protected $status;

    public function __construct($type = null, $attendance = null, $status = null)
    {
        $this->type = $type;
        $this->attendance = $attendance;
        $this->status = $status;
    }

    public function collection()
    {
        $query = Staff::query();

        if ($this->type) {
            $query->where('type', $this->type);
        }

        if ($this->attendance) {
            $query->where('attendance', $this->attendance);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $staffList = $query->get();

        // Count totals for each filter
        $totalStaff = Staff::count();
        $totalStaf = Staff::where('type', 'Staf')->count();
        $totalBukanStaf = Staff::where('type', 'Bukan Staf')->count();
        $totalHadir = Staff::where('attendance', 'Hadir')->count();
        $totalTidakHadir = Staff::where('attendance', 'Tidak Hadir')->count();
        $totalSelesaiTempah = Staff::where('status', 'Selesai Tempah')->count();
        $totalBelumTempah = Staff::where('status', 'Belum Tempah')->count();

        // Ensure keys match what map() expects
        $summary = (object)[
            'name' => 'SUMMARY',
            'total_staff' => $totalStaff,
            'total_staf' => $totalStaf,
            'total_bukan_staf' => $totalBukanStaf,
            'total_hadir' => $totalHadir,
            'total_tidak_hadir' => $totalTidakHadir,
            'total_selesai_tempah' => $totalSelesaiTempah,
            'total_belum_tempah' => $totalBelumTempah,
        ];

        // Add summary as the last row
        $staffList->push($summary);

        return $staffList;
    }


    public function headings(): array
    {
        return [
            'Nama',
            'No. Pekerja',
            'Kehadiran',
            'Jenis Pengguna',
            'Status',
        ];
    }

    public function map($staff): array
    {
        // Check if the object is the summary row
        if (isset($staff->name) && $staff->name === 'SUMMARY') {
            return [
                'Ringkasan',
                '',
                'Jumlah Pengguna: ' . ($staff->total_staff ?? ''),
                'Jumlah Staf: ' . ($staff->total_staf ?? ''),
                'Jumlah Bukan Staf: ' . ($staff->total_bukan_staf ?? ''),
                'Jumlah Hadir: ' . ($staff->total_hadir ?? ''),
                'Jumlah Tidak Hadir: ' . ($staff->total_tidak_hadir ?? ''),
                'Jumlah Selesai Tempah: ' . ($staff->total_selesai_tempah ?? ''),
                'Jumlah Belum Tempah: ' . ($staff->total_belum_tempah ?? ''),
            ];
        }

        // Map the regular staff row
        return [
            $staff->name,
            $staff->no_pekerja,
            $staff->attendance,
            $staff->type,
            $staff->status,
        ];
    }
}
