<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SalesChannel;

class SalesChannelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salesChannel = [
            [
                'id' => 1,
                'name'=>'SHOPEE ID',
                'admin_charge' => 12.30
            ],
            [
                'id' => 2,
                'name'=>'BLIBLI',
                'admin_charge' => 10.30
            ], 
            [
                'id' => 3,
                'name'=>'SHOPEE MY',
                'admin_charge' => 12.30
            ], 
            [
                'id' => 4,
                'name'=>'TOKOPEDIA',
                'admin_charge' => 12.30
            ], 
            [
                'id' => 5,
                'name'=>'ZALORA',
                'admin_charge' => 12.50
            ], 
            [
                'id' => 6,
                'name'=>'SHOPEE SG',
                'admin_charge' => 12.30
            ], 
            [
                'id' => 7,
                'name'=>'TIKTOK',
                'admin_charge' => 7.30
            ], 
            [
                'id' => 8,
                'name'=>'LAZADA',
                'admin_charge' => 6.30
            ], 
            [
                'id' => 9,
                'name'=>'WEBSITE',
                'admin_charge' => NULL
            ], 
        ];
  
        foreach ($salesChannel as $key => $value) {
            SalesChannel::create($value);
        }
    }
}
