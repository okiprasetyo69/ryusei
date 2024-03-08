<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name'=>'Super Admin',
                'phone' => '081312345678',
                'email'=>'superadmin@test.com',
                'role_id'=> 1,
                'password'=> bcrypt('12345678'),
            ],
            [
                'name'=>'Admin',
                'phone' => '088912345678',
                'email'=>'admin@test.com',
                'role_id'=> 2,
                'password'=> bcrypt('12345678'),
            ], 
        ];
  
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
