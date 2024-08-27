<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromQuery, WithHeadings, WithMapping
{
    protected $type;
    protected $rowNumber = 0; // To keep track of the row number

    // untuk tambah filter
    public function __construct($type = null)
    {
        $this->type = $type;
    }

    public function query()
    {
        $query = Attendance::query();

        if ($this->type) {
            $query->where('type', $this->type);
        }

        return $query->orderBy('check_in', 'asc');
    }

    // tambah data
    public function map($attendance): array
    {
        $this->rowNumber++; // Increment the row number

        return [
            $this->rowNumber,
            $attendance->staff->name,
            $attendance->staff->no_pekerja,
            $attendance->staff->booking->booking_no ?? 'N/A', // Using 'N/A' if booking_no is not available
            $attendance->check_in, 
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Name',
            'No. Pekerja',
            'No. Tempahan',
            'Check In',
        ];
    }
}
