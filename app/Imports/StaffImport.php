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
            'email'      => $row['email'] ?? null,
            'attendance' => $row['attendance'],
            'category'   => $row['category'] ?? null,
            'department' => $row['department'] ?? null,
            'campus'     => $row['campus'] ?? null,
            'club'       => $row['club'] ?? null,
            'payment' => $row['payment'] ?? null,
            'type'     => $row['type'],
            'status'     => $row['status'] ?? "Belum Tempah",
            'created_at' => $row['created_at'],
        ]);
    }
}
