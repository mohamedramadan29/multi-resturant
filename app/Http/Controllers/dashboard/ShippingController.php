<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Traits\Message_Trait;
use App\Http\Controllers\Controller;
use App\Models\dashboard\Resturant;
use Illuminate\Support\Facades\Auth;
use App\Models\dashboard\ShippingArea;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    use Message_Trait;

    public function index()
    {
        $admin = Auth::guard('admin')->user();
        if($admin->role_id == 1){
            $shippings = ShippingArea::all();
        }else{
            $shippings = ShippingArea::where('resturant_id', Auth::guard('admin')->user()->resturant_id)->get();
        }

        return view('dashboard.shipping.index', compact('shippings'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $resturant_id = Auth::guard('admin')->user()->resturant_id;
            $rules = [
                'resturant_id' => 'required|exists:resturants,id',
                'area' => 'required|unique:shipping_areas,area,NULL,id,resturant_id,' . $resturant_id,
                'price' => 'required|numeric',
            ];
            $messages = [
                'resturant_id.required' => 'المطعم مطلوب',
                'resturant_id.exists' => 'المطعم غير موجود',
                'area.required' => 'المنطقة مطلوبة',
                'area.unique' => 'المنطقة موجودة بالفعل',
                'price.required' => 'السعر مطلوب',
                'price.numeric' => 'السعر يجب ان يكون رقم',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            $shipping = new ShippingArea();
            $shipping->resturant_id = $data['resturant_id'];
            $shipping->area = $data['area'];
            $shipping->price = $data['price'];
            $shipping->save();
            return $this->success_message('تم اضافة منطقة بنجاح');
        }
        $resturants = Resturant::all();
        return view('dashboard.shipping.create', compact('resturants'));
    }
    public function update(Request $request, $id)
    {
        $shipping = ShippingArea::find($id);
        if (!isset($shipping)) {
            abort(404);
        }
        if ($shipping->resturant_id != Auth::guard('admin')->user()->resturant_id) {
            abort(403);
        }
        if ($request->isMethod('post')) {
            $resturant_id = Auth::guard('admin')->user()->resturant_id;

            $data = $request->all();
            $rules = [
                //'area' => 'required|unique:shipping_areas,area,NULL,id,resturant_id,' . $resturant_id,
                'area' => 'required|unique:shipping_areas,area,' . $shipping->id . ',id,resturant_id,' . $resturant_id,
                'price' => 'required|numeric',
            ];
            $messages = [
                'area.required' => 'المنطقة مطلوبة',
                'area.unique' => 'المنطقة موجودة بالفعل',
                'price.required' => 'السعر مطلوب',
                'price.numeric' => 'السعر يجب ان يكون رقم',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            $shipping->area = $data['area'];
            $shipping->price = $data['price'];
            $shipping->save();
            return $this->success_message('تم تعديل منطقة بنجاح');
        }
        return view('dashboard.shipping.update', compact('shipping'));
    }
    public function destroy($id)
    {
        $shipping = ShippingArea::find($id);
        if (!isset($shipping)) {
            abort(404);
        }
        if ($shipping->resturant_id != Auth::guard('admin')->user()->resturant_id) {
            abort(403);
        }
        $shipping->delete();
        return $this->success_message('تم حذف منطقة بنجاح');
    }
}
