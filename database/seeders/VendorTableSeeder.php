<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'id'=> 1,
                'vendor_code' =>'"AND"',
                'name'=>'Anindira Konveksi',
                'is_tax_on_purchase'=> 1,
                'balance'=> 0,
            ],
            [
                'id'=> 2,
                'vendor_code' =>'Baju Maker',
                'name'=>'Andi Friadi',
                'is_tax_on_purchase'=> 1,
                'balance'=> 0,
            ],
            [
                'id'=> 3,
                'vendor_code' =>'CAG',
                'name'=>'CAG',
                'is_tax_on_purchase'=> 1,
                'balance'=> 0,
            ],
            [
                'id'=> 4,
                'vendor_code' =>'DB',
                'name'=>'Dunia Benang',
                'is_tax_on_purchase'=> 1,
                'balance'=> 0,
            ],
            [
                'id'=> 5,
                'vendor_code' =>'ITD',
                'name'=>'ITD',
                'is_tax_on_purchase'=> 1,
                'balance'=> 0,
            ],
            [
                'id'=> 6,
                'vendor_code' =>'LGA',
                'name'=>'LGA',
                'is_tax_on_purchase'=> 1,
                'balance'=> 0,
            ],
            [
                'id'=> 7,
                'vendor_code' =>'Livia',
                'name'=>'Livia Head Wear',
                'is_tax_on_purchase'=> 1,
                'balance'=> 0,
            ],
            [
                'id'=> 8,
                'vendor_code' =>'MDI',
                'name'=>'Roby Sugama',
                'is_tax_on_purchase'=> 1,
                'balance'=> 0,
            ],
            [
                'id'=> 9,
                'vendor_code' =>'RIAN',
                'name'=>'Rian',
                'is_tax_on_purchase'=> 1,
                'balance'=> 0,
            ],
            [
                'id'=> 10,
                'vendor_code' =>'SFI',
                'name'=>'PT Solo Future Indogarment',
                'is_tax_on_purchase'=> 1,
                'balance'=> 0,
            ],
            [
                'id'=> 11,
                'vendor_code' =>'Tonomi',
                'name'=>'Tonomi',
                'is_tax_on_purchase'=> 1,
                'balance'=> 0,
            ],
            [
                'id'=> 12,
                'vendor_code' =>'V0000001',
                'name'=>'Siana Garment',
                'is_tax_on_purchase'=> 1,
                'balance'=> 0,
            ],
            [
                'id'=> 13,
                'vendor_code' =>'V0000002',
                'name'=>'Global Mandiri',
                'is_tax_on_purchase'=> 1,
                'balance'=> 0,
            ],
            [
                'id'=> 14,
                'vendor_code' =>'V0000003',
                'name'=>'CV. Adikarya Nusantara',
                'is_tax_on_purchase'=> 1,
                'balance'=> 0,
            ],
            [
                'id'=> 15,
                'vendor_code' =>'V0000005',
                'name'=>'CV Sigma Apparel',
                'is_tax_on_purchase'=> 1,
                'balance'=> 0,
            ],
            
           
        ];
  
        foreach ($user as $key => $value) {
            Vendor::create($value);
        }
    }
}
