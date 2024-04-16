<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InvoiceCategory;

class InvoiceCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $invoiceCategory = [
            [
                'id' => 1,
                'name' => 'Biaya Gaji'
            ],
            [
                'id' => 2,
                'name' => 'Biaya Heritage'
            ],
            [
                'id' => 3,
                'name' => 'Biaya Jasa Pembelian'
            ],
            [
                'id' => 4,
                'name' => 'Biaya Service'
            ],
            [
                'id' => 5,
                'name' => 'Biaya Zalora'
            ],
            [
                'id' => 6,
                'name' => 'Facebook Ads Report'
            ],
            [
                'id' => 7,
                'name' => 'Hutang Dagang Perusahaan'
            ],
            [
                'id' => 8,
                'name' => 'Pembayaran Iklan'
            ],
            [
                'id' => 9,
                'name' => 'Pencatatan Biaya'
            ],
            [
                'id' => 10,
                'name' => 'Pencatatan Biaya Blibli'
            ],
            [
                'id' => 11,
                'name' => 'Pencatatan Biaya Cimory'
            ],
            [
                'id' => 12,
                'name' => 'Pencatatan Biaya Heritage'
            ],
            [
                'id' => 13,
                'name' => 'Pencatatan Biaya Heritage 30 %'
            ],
            [
                'id' => 14,
                'name' => 'Pencatatan Biaya Iklan'
            ],
            [
                'id' => 15,
                'name' => 'Pencatatan Biaya Shopee'
            ],
            [
                'id' => 16,
                'name' => 'Pencatatan Biaya Kas Tokopedia'
            ],
            [
                'id' => 17,
                'name' => 'Pencatatan Biaya Kas Kecil'
            ],
            [
                'id' => 18,
                'name' => 'Pencatatan Biaya Kas untuk biaya Cimory'
            ],
            [
                'id' => 19,
                'name' => 'Pengeluaran Kas untuk biaya Cimory'
            ],
            [
                'id' => 20,
                'name' => 'Pengeluaran Kas  untuk biaya Heritage'
            ],
            [
                'id' => 21,
                'name' => 'Shirt'
            ],

        ];

        foreach ($invoiceCategory as $key => $value) {
            InvoiceCategory::create($value);
        }
    }
}
