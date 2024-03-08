<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = [
            [
                'name'=>'Super Admin',
            ],
            [
                'name'=>'Admin',
            ], 
            [
                'name'=>'Finance',
            ], 
            [
                'name'=>'Marketing',
            ], 
            [
                'name'=>'Finance',
            ], 
            [
                'name'=>'Warehouse',
            ], 
        ];
  
        foreach ($role as $key => $value) {
            Role::create($value);
        }
    }
}
