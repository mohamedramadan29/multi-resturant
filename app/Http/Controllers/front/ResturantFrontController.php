<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Models\dashboard\Category;
use App\Models\dashboard\Resturant;
use App\Http\Controllers\Controller;

class ResturantFrontController extends Controller
{
    public function show(Resturant $restaurant)
    {
        if(!$restaurant){
            abort(404);
        }
        $categories = Category::where('status', 1)->where('resturant_id', $restaurant->id)
            ->with([
                'products' => function ($query) {
                    $query->where('status', 1); // لو تحب المنتجات تكون مفعلة أيضًا
                }
            ])
            ->get()
            ->filter(function ($category) {
                return $category->products->isNotEmpty();
            })
            ->values(); // لإعادة ترتيب المفاتيح

        return view('front.restaurants.show', compact('categories'));
    }
}
