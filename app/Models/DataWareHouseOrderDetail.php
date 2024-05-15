<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataWareHouseOrderDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'dwh_order_id',
        'sku_id',
        'tax_id',
        'disc_marketplace',
        'price',
        'qty',
        'unit',
        'qty_in_base',
        'disc_amount',
        'discount',
        'tax_amount',
        'amount',
        'shipped_date',
        'is_bundle',
        'name',
        'description',
        'sku_code',
        'sell_price',
        'original_price',
        'rate',
        'tax_name',
        'qty_picked',
        'sync_date'
    ];

    public function invoice(){
        return $this->belongsTo(DataWareHouseOrder::class, 'dwh_order_id','id');
    }
}
