<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $size = [
            [
                'id' => 1,
                'name' => 'Aksesorris'
            ],
            [
                'id' => 2,
                'name' => 'Blouse Olahraga Wanita',
            ], 
            [
                'id' => 3,
                'name' => 'Blouse Wanita',
            ], 
            [
                'id' => 4,
                'name' => 'Cardigan Wanita',
            ], 
            [
                'id' => 5,
                'name' => 'Celana Panjang Pria',
            ], 
            [
                'id' => 6,
                'name' => 'Celana Pendek Pria',
            ], 
            [
                'id' => 7,
                'name' => 'Denim Pria',
            ],
            [
                'id' => 8,
                'name' => 'Denim Wanita',
            ],
            [
                'id' => 9,
                'name' => 'Dress Anak',
            ],
            [
                'id' => 10,
                'name' => 'Hoodie Pria',
            ],
            [
                'id' => 11,
                'name' => 'Jaket Pria',
            ],
            [
                'id' => 12,
                'name' => 'Jaket Wanita',
            ],
            [
                'id' => 13,
                'name' => 'Jeep Bag',
            ],
            [
                'id' => 14,
                'name' => 'Jogger Anak',
            ],
            [
                'id' => 15,
                'name' => 'Jogger Pria',
            ],
            [
                'id' => 16,
                'name' => 'Jogger Wanita',
            ],
            [
                'id' => 17,
                'name' => 'Kaos Anak',
            ],
            [
                'id' => 18,
                'name' => 'Kaos Olahraga Pria',
            ],
            [
                'id' => 19,
                'name' => 'Kaos Olahraga Wanita',
            ],
            [
                'id' => 20,
                'name' => 'Kaos Pria',
            ],
            [
                'id' => 21,
                'name' => 'Kaos Wanita',
            ],
            [
                'id' => 22,
                'name' => 'Kemeja Pria',
            ],
            [
                'id' => 23,
                'name' => 'Kemeja Wanita',
            ],
            [
                'id' => 24,
                'name' => 'Kimono',
            ],
            [
                'id' => 25,
                'name' => 'Masker',
            ],
            [
                'id' => 26,
                'name' => 'Pakaian Dalam Anak',
            ],
            [
                'id' => 27,
                'name' => 'Pakaian Dalam Pria',
            ],
            [
                'id' => 28,
                'name' => 'Pakaian Dalam Wanita',
            ],
            [
                'id' => 29,
                'name' => 'Polo Dress',
            ],
            [
                'id' => 30,
                'name' => 'Poloshirt Anak',
            ],
            [
                'id' => 31,
                'name' => 'Poloshirt Pria',
            ],
            [
                'id' => 32,
                'name' => 'Poloshirt Wanita',
            ],
            [
                'id' => 33,
                'name' => 'Sepatu',
            ],
            [
                'id' => 34,
                'name' => 'Sticker',
            ],
            [
                'id' => 35,
                'name' => 'Sweater Anak',
            ],
            [
                'id' => 36,
                'name' => 'Sweater Crop Wanita',
            ],
            [
                'id' => 37,
                'name' => 'Sweater Pria',
            ],
            [
                'id' => 38,
                'name' => 'Sweater Wanita',
            ],
            [
                'id' => 39,
                'name' => 'T-shirt Dress',
            ],
            [
                'id' => 40,
                'name' => 'TankTops',
            ],
            [
                'id' => 41,
                'name' => 'Topi',
            ],
        ];
  
        foreach ($size as $key => $value) {
            Category::create($value);
        }
    }
}
