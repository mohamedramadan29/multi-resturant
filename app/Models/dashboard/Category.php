<?php

namespace App\Models\dashboard;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    public function Resturant()
    {
        return $this->belongsTo(Resturant::class, 'resturant_id');
    }

    public function getImage()
    {
        return asset('assets/uploads/' . $this->resturant_id . '/' . 'category_images/' . $this->image);
    }
    public function products()
    {
        return $this->hasMany(Product::class,'category_id');
    }
}
