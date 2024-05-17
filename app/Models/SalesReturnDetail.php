<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturnDetail extends Model
{
    use HasFactory;
      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sales_return_id',
        'sku_id',
        'sku_code',
        'description',
        'price',
        'qty',
        'qty_in_base',
        'amount',
        'cogs',
        'tax_amount',
        'discount',
        'disc_amount',
        'sku_code',
        'name',
        'sell_price',
        'original_price',
        'rate',
        'tax_name',
        'available_qty'
    ];

    public function returnitem(){
        return $this->belongsTo(SalesReturn::class, 'sales_return_id','id');
    }

    public function product(){
        return $this->belongsTo(ItemUnit::class, 'sku_id','id');
    }
}
