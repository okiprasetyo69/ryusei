<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataWareHouseInvoice extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_number',
        'type',
        'customer_id',
        'customer_name',
        'customer_reference',
        'transaction_date',
        'due_date',
        'subtotal',
        'due',
        'doc_id',
        'sync_date'
    ];

    public function customer(){
        return $this->belongsTo(SalesChannel::class, 'customer_id','id');
    }
}
