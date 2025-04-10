<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Models\dashboard\Order;
use App\Http\Traits\Message_Trait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use Message_Trait;
    public function index(Request $request)
    {
        if (Auth::guard('admin')->user()->type == 'suberadmin') {
            $query = Order::orderBy('id', 'desc');
        } else {
            $query = Order::where('resturant_id', Auth::guard('admin')->user()->resturant_id)->orderBy('id', 'desc');
        }

        // التحقق مما إذا كان هناك تاريخ محدد في الطلب
        if ($request->has('from_date') && $request->has('to_date')) {
            $query->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
        }

        $orders = $query->paginate(12);

        return view('dashboard.orders.index', compact('orders'));
    }


    public function update(Request $request, $id)
    {
        // التحقق من وجود الطلب

        $order = Order::with('details')->where('id', $id)->first();
        //  dd($order);
        if (!isset($order)) {
            return redirect()->route('orders');
        }
        $user = Auth::guard('admin')->user();
        if ($order->resturant_id != $user->resturant_id) {
            abort(403);
        }
        $notification = $user->unreadNotifications->where('data.order_id', $id)->first();

        // التأكد من وجود الإشعار وجعله مقروءًا
        if ($notification) {
            $notification->markAsRead();
        }
        if ($request->isMethod('post')) {
            try {
                $data = $request->all();
                $order->update([
                    'order_status' => $data['order_status']
                ]);
                return $this->success_message(' تم تعديل حالة الطلب بنجاح  ');
            } catch (\Exception $e) {
                return $this->exception_message($e);
            }
        }
        return view('dashboard.orders.update', compact('order'));
    }

    public function print($id)
    {
        $order = Order::with('details')->where('id', $id)->first();
        if (!isset($order)) {
            abort(404);
        }
        $user = Auth::guard('admin')->user();
        if ($order->resturant_id != $user->resturant_id) {
            abort(403);
        }
        return view('dashboard.orders.print', compact('order'));
    }

    public function delete($id)
    {
        $order = Order::findORFail($id);
        $order->delete();
        return $this->success_message(' تم حذف الطلب ');
    }



}
