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

        return $query->get();
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
        return [
            $staff->name,
            $staff->no_pekerja,
            $staff->attendance,
            $staff->type,
            $staff->status,
        ];
    }
}
