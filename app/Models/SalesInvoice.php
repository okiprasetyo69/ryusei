<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
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
        'date',
        'due_date',
        'day',
        'category_invoice_id',
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
    ];

    public function customer(){
        return $this->belongsTo(SalesChannel::class, 'customer_id','id');
    }
}
