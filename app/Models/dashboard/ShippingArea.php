<?php

namespace App\Models\dashboard;

use Illuminate\Database\Eloquent\Model;

class ShippingArea extends Model
{
    protected $table = 'shipping_areas';
    protected $fillable = [
        'resturant_id',
        'area',
        'price',
    ];
    public function Resturant()
    {
        return $this->belongsTo(Resturant::class, 'resturant_id');
    }

}
