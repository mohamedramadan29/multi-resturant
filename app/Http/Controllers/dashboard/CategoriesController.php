<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Traits\Slug_Trait;
use App\Models\dashboard\Product;
use App\Http\Traits\Message_Trait;
use App\Http\Traits\Upload_Images;
use App\Models\dashboard\Category;
use App\Models\dashboard\Resturant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    use Message_Trait;
    use Slug_Trait;
    use Upload_Images;
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        if ($admin->role_id == 1) {
            $categories = Category::with('Resturant')->orderby('id', 'desc')->get();
        } else {
            $categories = Category::with('Resturant')->where('resturant_id', $admin['resturant_id'])->orderby('id', 'desc')->get();
        }

        return view('dashboard.MainCategory.index', compact('categories'));
    }
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->isMethod('post')) {
                try {
                    $alldata = $request->all();
                    // Make Validation
                    $rules = [
                        'name' => 'required',
                        'status' => 'required',
                        'image' => 'image|required|mimes:jpg,png,jpeg,webp',
                    ];
                    $customeMessage = [
                        'name.required' => 'من فضلك ادخل اسم القسم',
                        'status.required' => 'حدد حالة القسم ',
                        'image.mimes' =>
                            'من فضلك يجب ان يكون نوع الصورة jpg,png,jpeg,webp',
                        'image.image' => 'من فضلك ادخل الصورة بشكل صحيح',
                    ];
                    $validator = Validator::make($alldata, $rules, $customeMessage);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                    /// Upload Admin Photo
                    if ($request->hasFile('image')) {
                        $file_name = $this->saveImage($request->image, public_path('assets/uploads/' . $alldata['resturant_id'] . '/category_images'));
                    }
                    $new_category = new Category();
                    $new_category->name = $alldata['name'];
                    $new_category->slug = $this->CustomeSlug($alldata['name']);
                    $new_category->description = $alldata['description'];
                    $new_category->status = $alldata['status'];
                    $new_category->resturant_id = $alldata['resturant_id'];
                    $new_category->meta_title = $alldata['meta_title'];
                    $new_category->meta_description = $alldata['meta_description'];
                    $new_category->meta_keywords = $alldata['meta_keywords'];
                    $new_category->image = $file_name;
                    $new_category->save();
                    return $this->success_message(' تمت اضافة التصنيف  بنجاح ');
                } catch (\Exception $e) {
                    return $this->exception_message($e);
                }
            }
        }
        $resturants = Resturant::where('status', 1)->get();
        return view('dashboard.MainCategory.add', compact('resturants'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $admin = Auth::guard('admin')->user();
        if ($admin->resturant_id != null) {
            if ($admin->resturant_id != $category->resturant_id) {
                return abort(403);
                // return $this->error_message('لا يمكنك تعديل قسم ليس لك');
            }
        }
        if ($request->isMethod('post')) {
            try {
                $alldata = $request->all();
                // Make Validation
                $rules = [
                    'name' => 'required',
                    'status' => 'required',
                ];
                if ($request->hasFile('image')) {
                    $rules['image'] = 'image|mimes:jpg,png,jpeg,webp';
                }
                $customeMessage = [
                    'name.required' => 'من فضلك ادخل اسم القسم',
                    'status.required' => 'حدد حالة القسم ',
                    'image.mimes' =>
                        'من فضلك يجب ان يكون نوع الصورة jpg,png,jpeg,webp',
                    'image.image' => 'من فضلك ادخل الصورة بشكل صحيح',
                ];
                $validator = Validator::make($alldata, $rules, $customeMessage);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                /// Upload Category Image
                if ($request->hasFile('image')) {
                    ////// Delete Old Image
                    $old_image = 'assets/uploads/' . $category->resturant_id . '/' . 'category_images/' . $category['image'];
                    if (file_exists($old_image)) {
                        @unlink($old_image);
                    }
                    $file_name = $this->saveImage($request->image, public_path('assets/uploads/' . $alldata['resturant_id'] . '/category_images'));
                    $category->update([
                        'image' => $file_name,
                    ]);
                }
                $category->update([
                    "name" => $alldata['name'],
                    "slug" => $this->CustomeSlug($alldata['name']),
                    "description" => $alldata['description'],
                    "resturant_id" => $alldata['resturant_id'],
                    "status" => $alldata['status'],
                    "meta_title" => $alldata['meta_title'],
                    "meta_description" => $alldata['meta_description'],
                    "meta_keywords" => $alldata['meta_keywords'],
                ]);
                return $this->success_message(' تم تعديل القسم بنجاح  ');
            } catch (\Exception $e) {
                return $this->exception_message($e);
            }

        }
        $resturants = Resturant::where('status', 1)->get();
        return view('dashboard.MainCategory.update', compact('category', 'resturants'));
    }


    public function destroy($id)
    {

        try {
            // Find the main category
            $category = Category::findOrFail($id);
            $admin = Auth::guard('admin')->user();
            if ($admin->resturant_id != null) {
                if ($admin->resturant_id != $category->resturant_id) {
                    return abort(403);
                    // return $this->error_message('لا يمكنك تعديل قسم ليس لك');
                }
            }
            // Delete all products associated with this main category
            $products = Product::where('category_id', $id)->get();
            foreach ($products as $product) {
                // Delete product images if any
                $productImage = public_path('assets/uploads/product_images/' . $product['image']);
                if (file_exists($productImage)) {
                    @unlink($productImage);
                }
                // Delete the product
                $product->delete();
            }

            // Delete the main category image
            $old_image = public_path('assets/uploads/category_images/' . $category['image']);
            if (file_exists($old_image)) {
                @unlink($old_image);
            }

            // Delete the main category
            $category->delete();
            return $this->success_message('تم حذف القسم الرئيسي وجميع المنتجات المرتبطة بنجاح');
        } catch (\Exception $e) {
            return $this->exception_message($e);
        }
    }

}
