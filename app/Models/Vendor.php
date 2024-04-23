<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vendor_code',
        'name',
        'alias',
        'branch',
        'category',
        'currency',
        'phone',
        'mobile',
        'email',
        'is_tax_on_purchase',
        'balance',
        'city,'
    ];
}
