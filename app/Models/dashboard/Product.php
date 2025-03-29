<?php

namespace App\Models\dashboard;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{


    public function Main_Category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function variations()
    {
        return $this->hasMany(ProductVartion::class, 'product_id');
    }

    public function getImage()
    {
        return asset('assets/uploads/' . $this->resturant_id . '/' . 'product_images/' . $this->image);
    }

}
