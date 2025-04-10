<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Models\dashboard\Order;
use App\Http\Controllers\Controller;
use App\Models\dashboard\Resturant;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function account(){
        $orders = Order::with( 'details')->where("user_id",Auth::user()->id)->get();
        //dd($orders);
        return view("front.user.dashboard",compact("orders"));
    }
    public function logout(Resturant $restaurant){
        Auth::logout();
        return redirect()->route('restaurant.show', ['restaurant' => $restaurant->slug]);;
    }
}
