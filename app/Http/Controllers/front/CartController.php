<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Models\front\Cart;
use App\Http\Traits\Message_Trait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\dashboard\ProductVartion;
use App\Models\dashboard\Resturant;

class CartController extends Controller
{
    use Message_Trait;


    public function cart(Resturant $restaurant)
    {
        // dd($restaurant);
        $resturant_id = $restaurant->id;
        $cartItems = Cart::getcartitems($resturant_id);
        $cartcount = $cartItems->count();
        return view('front.cart', compact('cartItems', 'cartcount'));
    }

    public function add(Request $request, Resturant $restaurant)
    {
        // dd($restaurant);
        $cartData = $request->all();
        $product_id = $request->input('product_id');
        $number = $request->input('number');
        $price = $request->input('price');
        $resturant_id = $restaurant->id;
        $vartion_price = null;
        $vartion_size = null;
        $size = null;
        if ($request->has('size')) {
            $vartion = ProductVartion::where('id', $request->input('size'))->first();
            $vartion_price = $vartion->price;
            $vartion_size = $vartion->size;
            $price = $vartion_price;
            $size = $vartion_size;
            //dd($price, $size);
        }

        if (!$product_id || !$number) {
            return response()->json(['error' => 'بيانات غير مكتملة'], 400);
        }

        $session_id = Session::get('session_id');
        if (empty($session_id)) {
            $session_id = Session::getId();
            Session::put('session_id', $session_id);
            Session::regenerate();
        }

        // تحقق إذا كان المنتج موجودًا بالفعل في السلة
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $cartItem = Cart::where(['product_id' => $product_id, 'user_id' => $user_id, 'size' => $size, 'resturant_id' => $resturant_id])->first();
        } else {
            $user_id = 0;
            $cartItem = Cart::where('session_id', $session_id)
                ->where('product_id', $product_id)
                ->where('size', $size)
                ->where('resturant_id', operator: $resturant_id)
                ->first();
        }
        if ($cartItem) {
            // إذا كان المنتج موجودًا في السلة، يتم تحديث الكمية والسعر الإجمالي
            $cartItem->qty += $number;  // زيادة الكمية (يمكنك تعديلها حسب الحاجة)
            $cartItem->total_price = $cartItem->qty * $cartItem->price;  // تحديث السعر الإجمالي
            $cartItem->save();  // حفظ التحديثات
            return $this->success_message(' تم تحديث المنتج في السلة  ');
            // return response()->json([
            //     'message' => 'تم تحديث المنتج في السلة بنجاح',
            //     'cartCount' => Cart::where('session_id', $session_id)->count()  // إرسال العدد المحدث للسلة
            // ]);
        }

        // إذا لم يكن المنتج موجودًا في السلة، يتم إضافته
        $item = new Cart();
        $item->session_id = $session_id;
        $item->user_id = $user_id;
        $item->resturant_id = $resturant_id;
        $item->product_id = $product_id;
        $item->qty = $number;
        $item->price = $price;
        $item->size = $size;
        $item->total_price = $number * $price;
        $item->save();
        return $this->success_message(' تم اضافة المنتج الي السلة  ');
        // return response()->json([
        //     'message' => 'تم إضافة المنتج للسلة بنجاح',
        //     'cartCount' => Cart::where('session_id', $session_id)->count()  // إرسال العدد المحدث للسلة
        // ]);
    }




    public function getCartItems()
    {
        $cartItems = [];

        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $cartItems = Cart::with('productdata')->where('user_id', $user_id)->get();
        } else {
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            }
            $cartItems = Cart::with('productdata')->where('session_id', $session_id)->get();
        }

        // إرجاع البيانات المحدثة كـ JSON
        return response()->json([
            'html' => view('front.partials.cart_items', compact('cartItems'))->render(), // رندر الـ HTML
            'cartCount' => $cartItems->count(), // تحديث عداد السلة
        ]);
    }

    // public function delete($id,Resturant $restaurant)
    public function delete(Request $request, Resturant $restaurant, $id)
    {
        // dd($restaurant);
        try {
            $item = Cart::findOrFail($id);
            $resturant_id = $restaurant->id;
            if ($item->resturant_id != $resturant_id) {
                return $this->error_message(' لا يمكن حذف المنتج من سلة مطعم اخر  ');
            }
            $item->delete();
            return $this->success_message(' تم حذف المنتج من سلة المشتريات  ');
        } catch (\Exception $e) {
            return $this->exception_message($e);
        }
    }

    public function updateCart(Request $request,Resturant $restaurant)
    {
        $restaurant_id = $restaurant->id;
        $cartItem = Cart::find($request->item_id); // إيجاد العنصر في السلة
        if ($cartItem) {
            $cartItem->qty = $request->quantity; // تحديث الكمية
            $cartItem->total_price = $request->quantity * $cartItem['price'];
            $cartItem->save(); // حفظ التحديثات

            // حساب المجموع للمنتج الواحد
            $itemTotal = $cartItem['total_price'];

            // حساب المجموع الفرعي (Subtotal)
            $subtotal = Cart::getcartitems($restaurant_id)->sum(function ($item) {
                return $item['total_price'];
            });
            return response()->json([
                'itemTotal' => $itemTotal,
                'subtotal' => $subtotal
            ]);
        }
        return response()->json(['error' => 'Item not found'], 404);
    }

}
