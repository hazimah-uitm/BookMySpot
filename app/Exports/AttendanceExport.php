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

    public function map($attendance): array
    {
        $this->rowNumber++; // Increment the row number

        return [
            $this->rowNumber,
            $attendance->name,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Name',
        ];
    }
}
