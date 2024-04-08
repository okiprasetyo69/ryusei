<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ItemUnit;

class ItemUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itemUnit = [
            [
                'id' => 1,
                'name' => 'Pcs'
            ],
            [
                'id' => 2,
                'name' => 'Hour'
            ],
            [
                'id' => 3,
                'name' => 'Kg'
            ],
            [
                'id' => 4,
                'name' => 'M'
            ],
            [
                'id' => 5,
                'name' => 'Yards'
            ],
            [
                'id' => 6,
                'name' => 'Dz'
            ],
            [
                'id' => 7,
                'name' => 'Roll'
            ],
        ];

        foreach ($itemUnit as $key => $value) {
            ItemUnit::create($value);
        }
    }
}
