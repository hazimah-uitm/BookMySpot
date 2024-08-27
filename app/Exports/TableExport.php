<?php

namespace App\Exports;

use App\Models\Table;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TableExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Table::all()->map(function ($table) {
            return [
                'id' => $table->id,
                'table_no' => $table->table_no,
                'total_seat' => $table->total_seat,
                'available_seat' => $table->available_seat,
                'type' => $table->type,
                'status' => $table->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'No. Meja',
            'Jumlah Tempat Duduk',
            'Jumlah Tempat Duduk Kosong',
            'Jenis Meja',
            'Status',
        ];
    }
}
