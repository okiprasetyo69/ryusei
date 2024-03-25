<?php

namespace App\Imports;

use App\Models\Locality;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; 

class ImportLocality implements ToModel, WithHeadingRow 
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Locality([
            'postal_code' => $row["no_kode_pos"],
            'village' => $row["kelurahan"],
            'district' =>  $row["kecamatan"],
            'city' =>  $row["kabupaten"],
            'province' => $row["provinsi"],
        ]);
    }
}
