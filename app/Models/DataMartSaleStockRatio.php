<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMartSaleStockRatio extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_date',
        'sku_code',
        'salesorder_no',
        'dwh_order_id',
        'total_stock',
        'amount',
        'total_inventory',
        'sync_date',
        'total_item_sold',
        'total_sell_price'
    ];
}
