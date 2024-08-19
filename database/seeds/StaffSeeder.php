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
                'staff_id' => '100001',
                'name' => 'John Doe',
                'status' => 'Pending'
            ],
            [
                'staff_id' => '100002',
                'name' => 'Jane Smith',
                'status' => 'Pending'
            ],
            [
                'staff_id' => '100003',
                'name' => 'Alice Johnson',
                'status' => 'Pending'
            ],
            [
                'staff_id' => '100004',
                'name' => 'Bob Brown',
                'status' => 'Pending'
            ],
            [
                'staff_id' => '100005',
                'name' => 'Charlie Black',
                'status' => 'Pending'
            ],
            [
                'staff_id' => '100006',
                'name' => 'Diana White',
                'status' => 'Booked'
            ],
            [
                'staff_id' => '100007',
                'name' => 'Edward Green',
                'status' => 'Booked'
            ],
            [
                'staff_id' => '100008',
                'name' => 'Fiona Blue',
                'status' => 'Booked'
            ]
        ]);
    }
}
