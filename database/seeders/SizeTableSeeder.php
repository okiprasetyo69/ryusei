<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Size;

class SizeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $size = [
            [
                'id' => 1,
                'name' => 'S'
            ],
            [
                'id' => 2,
                'name' => 'M',
            ], 
            [
                'id' => 3,
                'name' => 'L',
            ], 
            [
                'id' => 4,
                'name' => 'XL',
            ], 
            [
                'id' => 5,
                'name' => 'XXL',
            ], 
            [
                'id' => 6,
                'name' => '3XL',
            ], 
            [
                'id' => 7,
                'name' => 'FS',
            ],
            [
                'id' => 8,
                'name' => '26',
            ],
            [
                'id' => 9,
                'name' => '27',
            ],
            [
                'id' => 10,
                'name' => '28',
            ],
            [
                'id' => 11,
                'name' => '29',
            ],
            [
                'id' => 12,
                'name' => '30',
            ],
            [
                'id' => 13,
                'name' => '31',
            ],
            [
                'id' => 14,
                'name' => '32',
            ],
            [
                'id' => 15,
                'name' => '33',
            ],
            [
                'id' => 16,
                'name' => '34',
            ],
            [
                'id' => 17,
                'name' => '35',
            ],
            [
                'id' => 18,
                'name' => '36',
            ],
            [
                'id' => 19,
                'name' => '37',
            ],
            [
                'id' => 20,
                'name' => '38',
            ],
            [
                'id' => 21,
                'name' => '39',
            ],
            [
                'id' => 22,
                'name' => '40',
            ],
            [
                'id' => 23,
                'name' => '41',
            ],
            [
                'id' => 24,
                'name' => '42',
            ],
            [
                'id' => 25,
                'name' => '43',
            ],
            [
                'id' => 26,
                'name' => '44',
            ],
        ];
  
        foreach ($size as $key => $value) {
            Size::create($value);
        }
    }
}
