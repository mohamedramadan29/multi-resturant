<?php

namespace App\Models\front;

use App\Models\dashboard\Product;
use App\Models\dashboard\Resturant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function productdata()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function resturant()
    {
        return $this->belongsTo(Resturant::class,'resturant_id');
    }

    public static function getcartitems($resturant_id)
    {
        if (Auth::check()) {
            // if User Logged In // Pick The User Id
            $user_id = Auth::user()->id;
            $getcartItems = Cart::with('productdata')
            ->where('user_id', $user_id)
            ->where('resturant_id', $resturant_id)
            ->get();
        } else {
            // If User Not Login // Pick The Session ID
            $session_id = Session::get('session_id');
            $getcartItems = Cart::with(['productdata' => function ($query) {
                $query->select('name', 'id', 'price', 'image', 'discount','slug');
            }])->where('session_id', $session_id)
            ->where('resturant_id', $resturant_id)
            ->get();
        }
        return $getcartItems;
    }
    public static function getcarttotal($resturant_id)
    {
        if (Auth::check()) {
            // if User Logged In // Pick The User Id
            $user_id = Auth::user()->id;
            $getcarttotal = Cart::with('productdata')
            ->where('user_id', $user_id)
            ->where('resturant_id', $resturant_id)
            ->sum('total_price');
        } else {
            // If User Not Login // Pick The Session ID
            $session_id = Session::get('session_id');
            $getcarttotal = Cart::with(['productdata' => function ($query) {
                $query->select('name', 'id', 'price', 'image', 'discount','slug');
            }])->where('session_id', $session_id)
            ->where('resturant_id', $resturant_id)
            ->sum('total_price');
        }
        return $getcarttotal;
    }


}
