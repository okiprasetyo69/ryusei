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
        'vendor__reference',
        'vendor__phone',
        'category_invoice_id',
        'date',
        'delivery_date',
        'day',
        'warehouse_id',
        'note',
        'additional_char',
        'down_pmt',
        'tax',
        'pph_percent',
        'subtotal',
        'discount',
        'grand_total',
        'balance_due',
        'state',
        'is_deleted',
        'doc_id'
    ];

    public function vendor(){
        return $this->belongsTo(Vendor::class, 'vendor_id','id');
    }
}
