<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemStock extends Model
{
    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'sku_id',
        'qty',
        'check_in_date',
        'warehouse_id'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'sku_id','id');
    }

    public function warehouse(){
        return $this->belongsTo(Product::class, 'warehouse_id','id');
    }
}
