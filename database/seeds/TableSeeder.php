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
        Table::insert([
            [
                'table_no' => 'T01',
                'total_seat' => 8,
                'available_seat' => 8,
                'status' => 'Available',
            ],
            [
                'table_no' => 'T02',
                'total_seat' => 8,
                'available_seat' => 1,
                'status' => 'Available',
            ],
            [
                'table_no' => 'T03',
                'total_seat' => 8,
                'available_seat' => 8,
                'status' => 'Booked',
            ],
            [
                'table_no' => 'T04',
                'total_seat' => 8,
                'available_seat' => 1,
                'status' => 'Available',
            ],
            [
                'table_no' => 'T05',
                'total_seat' => 8,
                'available_seat' => 8,
                'status' => 'Booked',
            ],
        ]);
    }
}
