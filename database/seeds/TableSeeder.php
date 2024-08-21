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
        $tables = [];

        // Generate 60 tables with table numbers from T01 to T60
        for ($i = 1; $i <= 60; $i++) {
            $tableNo = sprintf('T%02d', $i); // Format table number with leading zeroes
            $tables[] = [
                'table_no' => $tableNo,
                'total_seat' => 8,
                'available_seat' => 8,
                'status' => 'Available',
            ];
        }

        // Insert all tables into the database
        Table::insert($tables);
    }
}
