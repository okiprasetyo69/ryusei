<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataWareHouseDetailInvoice extends Model
{
    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_id',
        'sku_id',
        'sku_code',
        'name',
        'description',
        'qty',
        'price',
        'discount',
        'disc_amount',
        'amount',
        'tax_amount',
        'unit',
        'sell_price',
        'original_price',

    ];

    public function invoice(){
        return $this->belongsTo(DataWareHouseInvoice::class, 'invoice_id','id');
    }

}
