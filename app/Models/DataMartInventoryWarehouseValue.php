<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMartInventoryWarehouseValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'by_month',
        'by_year',
        'sku_code',
        'qty',
        'sell_price',
        'total_inventory_item',
        'sync_date',
    ];
}
