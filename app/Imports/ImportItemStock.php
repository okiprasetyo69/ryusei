<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; 
use App\Models\Product;
use App\Models\ItemStock;

class ImportItemStock implements  ToModel, WithHeadingRow 
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $product = Product::where("sku", $row["kode_sku"])->first();
        $sku_id = $product->id;
        $categoryId = $product->category_id;
        $checkinDate = date('Y-m-d');

        return new ItemStock([
            'category_id' => $categoryId,
            'sku_id' =>$sku_id,
            'qty' => $row["qty"],
            'check_in_date' => $checkinDate
        ]);
    }
}
