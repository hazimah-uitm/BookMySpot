<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Booking::with(['table', 'staff'])->get()->map(function ($booking) {
            return [
                'id' => $booking->id,
                'table_no' => $booking->table->table_no ?? 'N/A',
                'staff_name' => $booking->staff->name ?? 'N/A',
                'staff_no_pekerja' => $booking->staff->no_pekerja ?? 'N/A',
                'booking_no' => $booking->booking_no,
                'created_at' => $booking->created_at->format('d-m-Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'No. Meja',
            'Nama',
            'No. Pekerja',
            'No. Tempahan',
            'Tarikh Tempahan',
        ];
    }
}
