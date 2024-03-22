<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sales_channel_id',
        'order_number',
        'tracking_number',
        'sku_id',
        'qty',
        'unit_price',
        'order_date',
        'process_order_date',
        'group_id',
        'payment_method_id',
        'postal_code',
        'total',
        'admin_charge',
        'total_net',
        'discount'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'sku_id','id');
    }

    public function payment(){
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id','id');
    }

    public function channel(){
        return $this->belongsTo(SalesChannel::class, 'sales_channel_id','id');
    }

    public function postalcode(){
        return $this->belongsTo(Locality::class, 'postal_code','postal_code');
    }
}
