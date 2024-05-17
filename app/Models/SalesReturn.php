<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturn extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'doc_id',
        'doc_number',
        'customer_id',
        'customer_name',
        'customer_reference',
        'customer_phone',
        'invoice_number',
        'transaction_date',
        'due_date',
        'sub_total',
        'grand_total',
        'due',
        'downpayment_amount',
        'doc_type',
        'age',
        'age_due',
        'store_name',
        'return_type',
        'note',
        'total_tax',
        'total_disc',
        'add_disc',
        'add_fee',
        'service_fee',
        'salesorder_no',
        'sync_date'
    ];

    public function customer(){
        return $this->belongsTo(SalesChannel::class, 'customer_id','id');
    }
}
