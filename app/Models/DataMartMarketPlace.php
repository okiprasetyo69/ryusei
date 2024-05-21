<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMartMarketPlace extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'channel_id',
        'channel_name',
        'store_name',
        'grand_total',
        'transaction_date',
        'sync_date',
    ];

    public function channel(){
        return $this->belongsTo(SalesChannel::class, 'channel_id','id');
    }
}
