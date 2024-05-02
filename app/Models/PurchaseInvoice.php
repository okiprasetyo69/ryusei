<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_number',
        'batch_number',
        'type',
        'customer_id',
        'customer_reference',
        'customer_phone',
        'category_invoice_id',
        'date',
        'due_date',
        'day',
        'warehouse_id',
        'sales_person',
        'journal_memo',
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
