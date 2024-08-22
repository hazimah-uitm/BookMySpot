<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'Admin',
                'staff_id' => '111111',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'position_id' => 1,
                'campus_id' => 2,
                'office_phone_no' => '082111111',
                'publish_status' => true
            ],
            [
                'name' => 'Admin2',
                'staff_id' => '222222',
                'email' => 'admin2@gmail.com',
                'password' => Hash::make('admin123'),
                'position_id' => 1,
                'campus_id' => 2,
                'office_phone_no' => '082111111',
                'publish_status' => true
            ],
        ]);
    }
}
