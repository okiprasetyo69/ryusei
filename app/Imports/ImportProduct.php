<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; 
use App\Models\Size;

class ImportProduct implements ToModel, WithHeadingRow 
{
    protected $code, $categoryId, $status, $name, $imageName;

    public function __construct($code, $categoryId, $name, $status, $imageName)
    {
        $this->code = $code;
        $this->categoryId = $categoryId;
        $this->name = $name;
        $this->status = $status;
        $this->imageName = $imageName;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $codes =  $this->code;
        $categoryId = $this->categoryId;
        $name =  $this->name;
        $status =  $this->status;
        $sizeId = Size::where("name", $row["size"])->first();
        $size = $sizeId->id;
        $imageName = $this->imageName;

        return new Product([
            'code' => $codes,
            'sku' => $row["kode_sku"],
            'article' => $row["nama_artikel"],
            'name' => $name,
            'size' => $size,
            'price' => $row["harga"],
            'category_id' =>  $categoryId,
            'status' => $status,
            'image_path' => $imageName
        ]);
    }
}
