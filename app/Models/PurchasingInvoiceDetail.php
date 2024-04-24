<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasingInvoiceDetail extends Model
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
        'description',
        'qty',
        'unit_id',
        'price',
        'discount',
        'total',
        'tax_code',
    ];

    public function invoice(){
        return $this->belongsTo(PurchaseInvoice::class, 'invoice_id','id');
    }

    public function unit(){
        return $this->belongsTo(ItemUnit::class, 'unit_id','id');
    }

}
