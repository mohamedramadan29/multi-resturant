<?php

namespace App\Models\dashboard;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function details()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }
    public function resturant()
    {
        return $this->belongsTo(Resturant::class, 'resturant_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function shippingarea()
    {
        return $this->belongsTo(ShippingArea::class, 'area');
    }
}
