<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMartSellThrough extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sku_code',
        'product_name',
        'total_unit_received',
        'total_unit_sold',
        'sell_through',
        'sync_date',
        'name',
        'transaction_date'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'sku_code','sku');
    }
}
