<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMartProductDetail extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sku_id',
        'sku_code',
        'product_name',
        'category_id',
        'category_name',
        'channel_id',
        'channel_name',
        'qty_sold',
        'grand_total',
        'date',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'sku_id','id');
    }
    public function channel(){
        return $this->belongsTo(SalesChannel::class, 'channel_id','id');
    }
}
