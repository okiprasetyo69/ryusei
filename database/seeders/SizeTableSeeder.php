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
                'name' => 'XS',
            ], 
            [
                'id' => 5,
                'name' => 'XL',
            ], 
            [
                'id' => 6,
                'name' => 'XXL',
            ], 
            [
                'id' => 7,
                'name' => '3XL',
            ], 
            [
                'id' => 8,
                'name' => 'FS',
            ],
            [
                'id' => 9,
                'name' => '26',
            ],
            [
                'id' => 10,
                'name' => '27',
            ],
            [
                'id' => 11,
                'name' => '28',
            ],
            [
                'id' => 12,
                'name' => '29',
            ],
            [
                'id' => 13,
                'name' => '30',
            ],
            [
                'id' => 14,
                'name' => '31',
            ],
            [
                'id' => 15,
                'name' => '32',
            ],
            [
                'id' => 16,
                'name' => '33',
            ],
            [
                'id' => 17,
                'name' => '34',
            ],
            [
                'id' => 18,
                'name' => '35',
            ],
            [
                'id' => 19,
                'name' => '36',
            ],
            [
                'id' => 20,
                'name' => '37',
            ],
            [
                'id' => 21,
                'name' => '38',
            ],
            [
                'id' => 22,
                'name' => '39',
            ],
            [
                'id' => 23,
                'name' => '40',
            ],
            [
                'id' => 24,
                'name' => '41',
            ],
            [
                'id' => 25,
                'name' => '42',
            ],
            [
                'id' => 26,
                'name' => '43',
            ],
            [
                'id' => 27,
                'name' => '44',
            ],
            [
                'id' => 28,
                'name' => 'All Size',
            ],
            [
                'id' => 29,
                'name' => 'A',
            ],
            [
                'id' => 30,
                'name' => 'B',
            ],
            [
                'id' => 31,
                'name' => 4,
            ],
            [
                'id' => 32,
                'name' => 5,
            ],
            [
                'id' => 33,
                'name' => 6,
            ],
            [
                'id' => 34,
                'name' => 7,
            ],
            [
                'id' => 35,
                'name' => 8,
            ],
            [
                'id' => 36,
                'name' => 9,
            ],
            [
                'id' => 37,
                'name' => 10,
            ],
            [
                'id' => 38,
                'name' => 11,
            ],
            [
                'id' => 39,
                'name' => 12,
            ],
            [
                'id' => 40,
                'name' => 13,
            ],
            [
                'id' => 41,
                'name' => 14,
            ],
        ];
  
        foreach ($size as $key => $value) {
            Size::create($value);
        }
    }
}
