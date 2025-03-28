<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Traits\Slug_Trait;
use App\Models\dashboard\Admin;
use App\Http\Traits\Message_Trait;
use App\Http\Traits\Upload_Images;
use App\Models\dashboard\Resturant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ResturantController extends Controller
{
    use Message_Trait;
    use Slug_Trait;
    use Upload_Images;
    public function index()
    {
        $resturants = Resturant::orderBy("created_at", "desc")->paginate(10);
        return view('dashboard.resturants.index', compact('resturants'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $slug = $this->CustomeSlug($data['name']);
            $rules = [
                'name' => 'required|unique:resturants,name',
                'owner_id' => 'required',
                'email' => 'required|email|unique:resturants,email',
                'phone' => 'required|unique:resturants,phone',
                'address' => 'required',
                'logo' => 'required|image|mimes:jpg,png,jpeg,svg,webp',
            ];
            $messages = [
                'name.required' => 'من فضلك ادخل اسم المطعم',
                'name.unique' => ' اسم المطعم موجود من قبل ',
                'owner_id.required' => ' من فضلك حدد مالك المطعم  ',
                'email.required' => 'من فضلك ادخل البريد الإلكتروني',
                'email.email' => 'البريد الإلكتروني غير صالح',
                'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل',
                'phone.required' => 'من فضلك ادخل رقم الهاتف',
                'phone.unique' => 'رقم الهاتف مستخدم بالفعل',
                'address.required' => ' من فضلك ادخل العنوان  ',
                'logo.required' => ' من فضلك ادخل اللوجو  ',
                'logo.image' => ' اللوجو يجب ان يكون من نوع صورة فقط ',
                'logo.mimes' => ' الانواع المتاحة للوجو jpg,png,jpeg,svg,webp',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $restaurant = new Resturant();
            $restaurant->name = $data['name'];
            $restaurant->slug = $data['slug'];
            $restaurant->owner_id = $data['owner_id'];
            $restaurant->email = $data['email'];
            $restaurant->phone = $data['phone'];
            $restaurant->address = $data['address'];
            $restaurant->description = $data['description'];
            $restaurant->status = $data['status'];
            $restaurant->save();
            $restaurantId = $restaurant->id;
            ######### Logo
            if ($request->hasFile('logo')) {
                $filename = $this->saveImage($request->file('logo'), public_path(asset('assets/uploads/' . $restaurantId . 'logo/')));
            }
            $restaurant->logo = $filename;
            $restaurant->save();
            return $this->success_message(' تم اضافة المطعم بنجاح ');
        }
        $admins = Admin::where('type', "!=", 'superadmin')->get();
        return view('dashboard.resturants.create', compact('admins'));
    }

    public function update(Request $request, $id)
    {
        $restaurant = Resturant::find($id);
        if (!$restaurant) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            $slug = $this->CustomeSlug($data['name']);
            $rules = [
                'name' => 'required|unique:resturants,name,' . $restaurant->id,
                'owner_id' => 'required',
                'email' => 'required|email|unique:resturants,email,' . $restaurant->id,
                'phone' => 'required|unique:resturants,phone,' . $restaurant->id,
                'address' => 'required',
                'logo' => 'nullable|image|mimes:jpg,png,jpeg,svg,webp',
            ];
            $messages = [
                'name.required' => 'من فضلك ادخل اسم المطعم',
                'name.unique' => ' اسم المطعم موجود من قبل ',
                'owner_id.required' => ' من فضلك حدد مالك المطعم  ',
                'email.required' => 'من فضلك ادخل البريد الإلكتروني',
                'email.email' => 'البريد الإلكتروني غير صالح',
                'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل',
                'phone.required' => 'من فضلك ادخل رقم الهاتف',
                'phone.unique' => 'رقم الهاتف مستخدم بالفعل',
                'address.required' => ' من فضلك ادخل العنوان  ',
                'logo.image' => ' اللوجو يجب ان يكون من نوع صورة فقط ',
                'logo.mimes' => ' الانواع المتاحة للوجو jpg,png,jpeg,svg,webp',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $restaurant->name = $data['name'];
            $restaurant->slug = $data['slug'];
            $restaurant->owner_id = $data['owner_id'];
            $restaurant->email = $data['email'];
            $restaurant->phone = $data['phone'];
            $restaurant->address = $data['address'];
            $restaurant->description = $data['description'];
            $restaurant->status = $data['status'];
            $restaurant->save();
            $restaurantId = $restaurant->id;
            ######### Logo
            if ($request->hasFile('logo')) {
                ##### Delete Old Image
                $oldLogo = public_path(asset('assets/uploads/' . $restaurant->id . 'logo/' . $restaurant['logo']));
                if (file_exists($oldLogo)) {
                    @unlink($oldLogo);
                }
                $filename = $this->saveImage($request->file('logo'), public_path(asset('assets/uploads/' . $restaurantId . 'logo/')));
                $restaurant->logo = $filename;
                $restaurant->save();
            }
            return $this->success_message(' تم اضافة المطعم بنجاح ');
        }
        $admins = Admin::where('type', "!=", 'superadmin')->get();
        return view('dashboard.resturants.create', compact('admins'));
    }

    public function delete($id)
    {
        $restaurant = Resturant::find($id);
        if (!$restaurant) {
            abort(404);
        }
        ######### Delete All Files
        $restaurantId = $restaurant->id;
        $restaurantFolder = public_path(asset('assets/uploads/' . $restaurantId));
        $restaurant->delete();
        // حذف المجلد إذا كان موجودًا
        if (File::exists($restaurantFolder)) {
            File::deleteDirectory($restaurantFolder);
        }

        return $this->success_message(' تم حذف المطعم بنجاح ');


    }
}
