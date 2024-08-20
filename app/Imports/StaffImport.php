<?php

namespace App\Imports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * 
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Staff([
            'name'       => strtoupper($row['name']),
            'no_pekerja' => $row['no_pekerja'],
            'email'      => $row['email'],
            'attendance' => $row['attendance'],
            'category'   => $row['category'],
            'department' => $row['department'],
            'campus'     => $row['campus'],
            'club'       => $row['club'],
            'payment' => $row['payment'] ?? null,
            'status'     => $row['status'] ?? "Pending",
            'created_at' => $row['created_at'], // Ensure this matches your Excel file column
        ]);
    }
}
