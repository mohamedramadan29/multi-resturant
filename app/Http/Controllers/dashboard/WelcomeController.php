<?php

namespace App\Http\Controllers\dashboard;

use App\Models\dashboard\Category;
use Illuminate\Http\Request;
use App\Models\dashboard\Resturant;
use App\Http\Controllers\Controller;
use App\Models\dashboard\Order;
use App\Models\dashboard\Product;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index(){
        $user = Auth::guard('admin')->user();
        if($user['resturant_id'] == null){
            $ordersCount = Order::count();
            $products = Product::count();
            $categories = Category::count();
        }else{
            $ordersCount = Order::where('resturant_id',$user['resturant_id'])->count();
            $products = Product::where('resturant_id',$user['resturant_id'])->count();
            $categories = Category::where('resturant_id',$user['resturant_id'])->count();
        }

        $returants = Resturant::all();
        return view('dashboard.welcome',compact('returants','ordersCount','products','categories'));
    }
}
