<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethod = [
            [
                'name'=>'REGULER',
            ],
            [
                'name'=>'COD',
            ], 
        ];
  
        foreach ($paymentMethod as $key => $value) {
            PaymentMethod::create($value);
        }
    }
}
