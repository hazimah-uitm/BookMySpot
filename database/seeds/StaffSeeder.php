<?php

use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 5 staff members with "Pending" status
        Staff::insert([
            [
                'email' => 'example1@example.com',
                'name' => 'John Doe',
                'no_pekerja' => 12345,
                'attendance' => 'Hadir',
                'category' => 'Staf Akademik',
                'department' => 'Department A',
                'campus' => 'Campus X',
                'club' => 'Ahli KEKiTA',
                'payment' => 'Paid',
                'status' => 'Pending',
            ],
            [
                'email' => 'example2@example.com',
                'name' => 'Jane Smith',
                'no_pekerja' => 123666,
                'attendance' => 'Hadir',
                'category' => 'Staf Pentadbiran',
                'department' => 'Department A',
                'campus' => 'Campus X',
                'club' => 'Ahli KEKiTA',
                'payment' => 'Paid',
                'status' => 'Pending',
            ],
        ]);
    }
}
