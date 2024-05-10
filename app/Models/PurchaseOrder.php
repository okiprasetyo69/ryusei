<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'purchaseorder_number',
        'batch_number',
        'type',
        'vendor_id',
        'vendor_reference',
        'vendor_phone',
        'date',
        'delivery_date',
        'day',
        'category_invoice_id',
        'warehouse_id',
        'transaction_date',
        'note',
        'subtotal',
        'discount_invoice',
        'additional_char',
        'tax',
        'grand_total',
        'down_pmt',
        'state',
        'is_deleted',
        'bills',
        'purchaseorder_id',
        'status',
        'sync_date',
    ];

    public function vendor(){
        return $this->belongsTo(Vendor::class, 'vendor_id','id');
    }
}
