<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMartInventoryValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'by_month',
        'by_year',
        'sku_code',
        'total_sold',
        'grand_total',
        'sync_date',
    ];
}
