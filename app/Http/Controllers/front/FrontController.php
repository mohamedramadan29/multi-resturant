<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Models\dashboard\Category;
use App\Http\Controllers\Controller;

class FrontController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 1)
            ->with(['products' => function($query) {
                $query->where('status', 1); // لو تحب المنتجات تكون مفعلة أيضًا
            }])
            ->get()
            ->filter(function ($category) {
                return $category->products->isNotEmpty();
            })
            ->values(); // لإعادة ترتيب المفاتيح

        return view('front.index', compact('categories'));
    }

}
