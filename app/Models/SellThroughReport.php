<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellThroughReport extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'month',
        'year',
        'total_item_in_warehouse',
        'total_item_sold',
        'sell_through',
        'sync_date',
        'percentage'
    ];
}
