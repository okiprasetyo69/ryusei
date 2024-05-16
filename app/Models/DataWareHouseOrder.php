<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataWareHouseOrder extends Model
{
    use HasFactory;

    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $fillable = [
        'salesorder_id',
        'salesorder_no',
        'invoice_number',
        'invoice_created_date',
        'transaction_date',
        'is_paid',
        'shipping_full_name',
        'customer_name',
        'grand_total',
        'store_name',
        'channel_id',
        'channel_name',
        'shipper',
        'store',
        'package_count',
        'cancel_reason',
        'cancel_reason_detail',
        'wms_status',
        'note',
        'ref_no',
        'tracking_number',
        'is_cod',
        'sync_date',
        'sub_total',
        'total_disc',
        'total_tax',
        'payment_method'
   ];

   public function channel(){
       return $this->belongsTo(SalesChannel::class, 'channel_id','id');
   }
}
