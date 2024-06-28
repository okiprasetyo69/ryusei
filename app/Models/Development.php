<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Development extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'received_design_date',
        'sample_date',
        'design_image',
        'sample_image',
        'description',
        'article', 
        'category_id',
        'vendor_id',
        'qty_per_size',
        'qty',
        'status',
        'film_date'
    ];

    protected $appends = [
        'design_image_url',
        'sample_image_url'
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id','id');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class, 'vendor_id','id');
    }

    public function getDesignImageUrlAttribute()
    {
        $url = "";
        if($this->design_image != null){
            $url = asset('/uploads/production/development/design/'. $this->design_image);
        }
        return $url;
    }

    public function getSampleImageUrlAttribute()
    {
        $url = "";
        if($this->sample_image != null){
            $url =  asset('/uploads/production/development/sample/'. $this->sample_image);
        }
        return $url;
    }
}
