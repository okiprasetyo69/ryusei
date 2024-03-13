<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'sku',
        'article',
        'name',
        'size',
        'price',
        'status',
        'category_id',
        'image_path'
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id','id');
    }
}
