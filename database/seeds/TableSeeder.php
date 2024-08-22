<?php

use App\Models\Table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = [
            ['table_no' => 'D1', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'VVIP', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'KK/PW/BDU', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka',  'status' => 'Penuh'],
            ['table_no' => 'P2', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'P1', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'AL1', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'AL2', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'AL3', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'D2', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'A1', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'A2', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'A3', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'A4', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'A5', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'A6', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'A7', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'A8', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'A9', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'G1', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'G2', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'G3', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'G4', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'G5', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'G6', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'G7', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'G8', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'PS1', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'PS2', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'MEDIA', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'PROTOKOL', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'URUSETIA', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'AJK(EARLY DINNER)', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Ditempah',  'status' => 'Penuh'],
            ['table_no' => 'S1', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka', 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S2', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka', 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S3', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka', 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S4', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka', 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S5', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka', 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S6', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka', 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S7', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka', 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S8', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka', 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S9', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka', 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S10', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka', 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S11', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka', 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S12', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka', 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S13', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka', 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S14', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka', 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S15', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka', 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S16', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S17', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S18', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S19', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S20', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S21', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S22', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S23', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S24', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S25', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S26', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S27', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S28', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka',  'status' => 'Tersedia'],
            ['table_no' => 'S29', 'total_seat' => 10, 'available_seat' => 10, 'type' => 'Terbuka',  'status' => 'Tersedia'],
        ];

        // Insert all tables into the database
        Table::insert($tables);
    }
}
