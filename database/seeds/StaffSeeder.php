<?php

use App\Models\Staff;
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
                'no_pekerja' => '100001',
                'name' => 'John Doe',
                'status' => 'Pending'
            ],
            [
                'no_pekerja' => '100002',
                'name' => 'Jane Smith',
                'status' => 'Pending'
            ],
            [
                'no_pekerja' => '100003',
                'name' => 'Alice Johnson',
                'status' => 'Pending'
            ],
            [
                'no_pekerja' => '100004',
                'name' => 'Bob Brown',
                'status' => 'Pending'
            ],
            [
                'no_pekerja' => '100005',
                'name' => 'Charlie Black',
                'status' => 'Pending'
            ],
            [
                'no_pekerja' => '100006',
                'name' => 'Diana White',
                'status' => 'Booked'
            ],
            [
                'no_pekerja' => '100007',
                'name' => 'Edward Green',
                'status' => 'Booked'
            ],
            [
                'no_pekerja' => '100008',
                'name' => 'Fiona Blue',
                'status' => 'Booked'
            ]
        ]);
    }
}
