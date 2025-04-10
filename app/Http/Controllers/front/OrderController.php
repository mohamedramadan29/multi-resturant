<?php

namespace App\Http\Controllers\front;

use App\Models\User;
use App\Models\front\Cart;
use Illuminate\Http\Request;
use App\Models\dashboard\Admin;
use App\Models\dashboard\Order;
use App\Notifications\NewOrder;
use App\Models\dashboard\Product;
use App\Models\dashboard\Setting;
use App\Http\Traits\Message_Trait;
use Illuminate\Support\Facades\DB;
use App\Models\dashboard\Resturant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\dashboard\OrderDetails;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    use Message_Trait;

    public function store(Request $request, Resturant $restaurant)
    {
        try {
            $resturant_id = $restaurant->id;
            $data = $request->all();
            // dd($data);
            // $user = User::where('phone', $data['phone'])->where('resturant_id', $restaurant->id)->first();
            // if (!$user) {
            //     abort(404);
            // }
            // dd($data);
            $coupon_amount = Session::has('coupon_amount') ? Session::get('coupon_amount') : 0;
            $coupon = Session::has('coupon_code') ? Session::get('coupon_code') : null;
            $cartItems = Cart::getcartitems($resturant_id);
            // dd($cartItems);
            $total_price = Cart::getcarttotal($resturant_id);
            // dd($total_price);
            $rules = [
               // 'name' => 'required',
               // 'phone' => 'required',
                'table_number' => 'required|integer',

            ];
            $messages = [
              //  'name.required' => ' من فضلك ادخل الاسم  ',
               // 'phone.required' => ' من فضلك ادخل رقم الهاتف  ',
                'table_number.required' => ' من فضلك ادخل رقم الطاولة  ',
                'table_number.integer' => ' رقم الطاولة يجب ان يكون رقم صحيح  ',
            ];

            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            DB::beginTransaction();
            $order = new Order();
            $order->user_id = null;
            $order->resturant_id = $resturant_id;
           // $order->name = $data['name'];
           // $order->phone = $data['phone'];
            $order->table_number = $data['table_number'];
            $order->notes = $data['notes'];
            $order->time_delivery = 'now';
            $order->payment_method = 'cash';
            $order->coupon_code = $coupon;
            $order->coupon_amount = $coupon_amount;
            $order->order_status = 'لم يبدا';
            $order->grand_total = $total_price;
            $order->save();
           // $user->name = $data['name'];
           // $user->save();
            //  dd($order->id);

            foreach ($cartItems as $item) {
                $order_details = new OrderDetails();
                $order_details->resturant_id = $resturant_id;
                $order_details->order_id = $order->id;
                $order_details->product_id = $item['product_id'];
                $getproductdata = Product::where('id', $item['product_id'])->first();
                $order_details->product_name = $getproductdata['name'];
                $order_details->product_price = $item['price'];
                $order_details->product_qty = $item['qty'];
                $order_details->total_price = $item['total_price'];
                $order_details->size = $item['size'];
                $order_details->save();
            }
            $admins = Admin::where('resturant_id', $resturant_id)->get();

            foreach ($admins as $admin) {
                Notification::send($admin, new NewOrder($order->id));
            }
            Session::put('order_id', $order->id);
            // return $this->success_message(' تم اضافة الطلب الخاص بك بنجاح  ');
            DB::commit();
            return Redirect::route('thanks', ['restaurant' => $restaurant->slug]);


        } catch (\Exception $e) {
            return $this->exception_message($e);
        }

    }

    public function thanks()
    {

        $session_id = Session::get('session_id');
        if (Session::has('order_id')) {
            // Empty The Cart
           // Cart::where('user_id', Auth::user()->id)->orWhere('session_id', $session_id)->delete();
            Cart::Where('session_id', $session_id)->delete();
            return view('front.restaurants.thanks');
        } else {
            return redirect('/');
        }
    }
}
