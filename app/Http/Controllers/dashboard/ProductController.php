<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Traits\Slug_Trait;
use App\Models\dashboard\Product;
use App\Http\Traits\Message_Trait;
use App\Http\Traits\Upload_Images;
use App\Models\dashboard\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\dashboard\ProductVartion;
use App\Models\dashboard\Resturant;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use Message_Trait;
    use Slug_Trait;
    use Upload_Images;

    public function index()
    {
        $admin = Auth::guard('admin')->user();
        if ($admin->role_id == 1) {
            $products = Product::with('Main_Category')->orderBy('id', 'desc')->get();
        } else {
            $products = Product::with('Main_Category')->where('resturant_id', $admin['resturant_id'])->orderBy('id', 'desc')->get();
        }

        $MainCategories = Category::where('status', '1')->get();
        return view('dashboard.products.index', compact('products', 'MainCategories'));
    }
    public function create(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if ($admin->role_id == 1) {
            $MainCategories = Category::where('status', '1')->get();
        } else {
            $MainCategories = Category::where('status', '1')->where('resturant_id', $admin['resturant_id'])->get();
        }

        if ($request->isMethod('post')) {
            try {
                $data = $request->all();
                $sizes = $request->input('sizes');
                $prices = $request->input('prices');
                $rules = [
                    'name' => 'required',
                    'category_id' => 'required',
                    'description' => 'required'
                ];
                if ($request->hasFile('image')) {
                    $rules['image'] = 'image|mimes:jpg,png,jpeg,webp';
                }
                $messages = [
                    'name.required' => ' من فضلك ادخل اسم المنتج  ',
                    'category_id.required' => ' من فضلك حدد القسم الرئيسي للمنتج  ',
                    'description.required' => ' من فضلك ادخل الوصف الخاص بالمنتج ',
                    'image.mimes' =>
                        'من فضلك يجب ان يكون نوع الصورة jpg,png,jpeg,webp',
                    'image.image' => 'من فضلك ادخل الصورة بشكل صحيح',
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }
                if ($request->hasFile('image')) {
                    $file_name = $this->saveImage($request->image, public_path('assets/uploads/' . $data['resturant_id'] . '/product_images'));
                }
                /////// Check if This Product In Db Or Not
                ///
                $count_old_product = Product::where('name', $data['name'])->count();
                if ($count_old_product > 0) {
                    return Redirect::back()->withInput()->withErrors(' اسم المنتج متواجد من قبل من فضلك ادخل منتج جديد  ');
                }
                DB::beginTransaction();
                $product = new Product();
                $product->name = $data['name'];
                $slug = $this->CustomeSlug($data['name']);
                $product->slug = $slug;
                $product->category_id = $data['category_id'];
                $product->status = $data['status'];
                $product->short_description = $data['short_description'];
                $product->description = $data['description'];
                $product->price = $data['price'];
                $product->meta_title = $data['meta_title'];
                $product->meta_keywords = $data['meta_keywords'];
                $product->meta_description = $data['meta_description'];
                $product->image = $file_name;
                $product->product_type = $data['product_type'];
                $product->carb = $data['carb'];
                $product->is_featured = $data['is_featured'];
                $product->resturant_id = $data['resturant_id'];
                $product->save();
                if ($data['product_type'] == 'variable') {
                    foreach ($sizes as $index => $size) {
                        ProductVartion::create([
                            'product_id' => $product->id,
                            'size' => $size,
                            'price' => $prices[$index],
                        ]);
                    }
                }
                DB::commit();
                return $this->success_message(' تم اضافة المنتج بنجاح  ');
            } catch (\Exception $e) {
                return $this->exception_message($e);
            }
        }
        $resturants = Resturant::where('status', 1)->get();
        return view('dashboard.products.create', compact('MainCategories', 'resturants'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        // جلب الفئات الرئيسية والفرعية والعلامات التجارية والسمات
        $admin = Auth::guard('admin')->user();
        if ($admin->role_id == 1) {
            $MainCategories = Category::where('status', '1')->get();
        } else {
            $MainCategories = Category::where('status', '1')->where('resturant_id', $admin['resturant_id'])->get();
        }
        // جلب المنتج مع الفئة الفرعية والمتغيرات المرتبطة به
        $product = Product::where('id', $id)->first();
        if ($admin->resturant_id != null) {
            if ($admin->resturant_id != $product->resturant_id) {
                return abort(403);
                // return $this->error_message('لا يمكنك تعديل قسم ليس لك');
            }
        }
        if (!$product) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            try {
                // التحقق من صحة المدخلات
                $request->validate([
                    'name' => 'required|string|max:255',
                    'category_id' => 'required|integer',
                ]);
                DB::beginTransaction();
                if ($request->hasFile('image')) {
                    ////// Delete Old Image
                    $old_image = 'assets/uploads/' . $product->resturant_id . '/' . 'product_images/' . $product['image'];
                    if (file_exists($old_image)) {
                        @unlink($old_image);
                    }
                    $file_name = $this->saveImage($request->image, public_path('assets/uploads/' . $data['resturant_id'] . '/product_images'));


                    $product->update([
                        'image' => $file_name
                    ]);
                }



                //dd($data);
                // البحث عن المنتج للتعديل
                // $product = Product::find();  // استبدال $productId بالمعرّف الخاص بالمنتج

                // تحديث معلومات المنتج
                $product->name = $data['name'];
                $product->slug = $this->CustomeSlug($data['name']);
                $product->category_id = $data['category_id'];
                $product->status = $data['status'];
                $product->short_description = $data['short_description'];
                $product->description = $data['description'];
                $product->price = $data['price'];
                $product->meta_title = $data['meta_title'];
                $product->meta_keywords = $data['meta_keywords'];
                $product->meta_description = $data['meta_description'];
                $product->product_type = $data['product_type'];
                $product->carb = $data['carb'];
                $product->is_featured = $data['is_featured'];
                $product->resturant_id = $data['resturant_id'];
                $product->save();

                // حذف الأحجام القديمة
                if ($data['product_type'] == 'variable') {
                    // حفظ الأحجام والأسعار الجديدة
                    $sizes = $request->input('sizes');
                    $prices = $request->input('prices');
                    $product->variations()->delete();
                    foreach ($sizes as $index => $size) {
                        ProductVartion::create([
                            'product_id' => $product->id,
                            'size' => $size,
                            'price' => $prices[$index],
                        ]);
                    }
                }

                DB::commit();
                // بعد تحديث المنتج بنجاح
                return Redirect::route('product.update', ['slug' => $product->slug])
                    ->with('Success_message', 'تم تعديل المنتج بنجاح');
            } catch (\Exception $e) {
                DB::rollback();
                return $this->error_message('حدث خطأ أثناء عملية التعديل.');
            }
        }
        $resturants = Resturant::where('status', 1)->get();
        // عرض صفحة التعديل
        return view('dashboard.products.update', compact('product', 'MainCategories', 'resturants'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return $this->success_message(' تم حذف المنتج بنجاح  ');
    }

    // public function delete_image_gallary($id)
    // {
    //     $imageGallary = ProductGallary::findOrFail($id);
    //     $oldimage = public_path('assets/uploads/product_gallery/' . $imageGallary['image']);
    //     if (file_exists($oldimage)) {
    //         @unlink($oldimage);
    //     }
    //     $imageGallary->delete();
    //     return $this->success_message(' تم حذف الصورة بنجاح  ');
    // }
}
