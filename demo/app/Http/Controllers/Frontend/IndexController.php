<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Product::select('id_category')->distinct()->get();
        $brands = Product::select('id_brand')->distinct()->get();
        return view('frontend.home.home', compact('products', 'categories', 'brands'));
    }

    public function search(Request $request)
    {
        $query = Product::query();
    
        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
    
        if ($request->filled('category')) {
            $query->where('id_category', $request->category);
        }
    
        if ($request->filled('brand')) {
            $query->where('id_brand', $request->brand);
        }
    
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        if ($request->filled('price')) {
            switch ($request->price) {
                case '<50':
                    $query->where('price', '<', 50);
                    break;
                case '50-100':
                    $query->whereBetween('price', [50, 100]);
                    break;
                case '100-200':
                    $query->whereBetween('price', [100, 200]);
                    break;
                case '200-500':
                    $query->whereBetween('price', [200, 500]);
                    break;
                case '>500':
                    $query->where('price', '>', 500);
                    break;
            }
        }  
        
        if ($request->filled('price_min') && $request->filled('price_max')) {
            $priceMin = $request->price_min;
            $priceMax = $request->price_max;
            $query->whereBetween('price', [$priceMin, $priceMax]);
        }
                    
        $products = $query->get();
    
        if ($request->ajax()) {
            return view('frontend.home.products', compact('products'))->render();
        }
    
        $categories = Product::select('id_category')->distinct()->get();
        $brands = Product::select('id_brand')->distinct()->get();
            
        return view('frontend.home.home', compact('products', 'categories', 'brands'));
    }
        
    public function filterProducts(Request $request)
    {
        $priceRange = explode(':', $request->price_range);
        $minPrice = $priceRange[0];
        $maxPrice = $priceRange[1];

        $products = Product::whereBetween('price', [$minPrice, $maxPrice])->get();

        return view('frontend.home.products', compact('products'));
    }
    
    public function detail($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('member-home')->with('error', 'Product not found.');
        }

        $user = auth()->check() ? auth()->user() : null;
        return view('frontend.detail.detail', compact('product', 'user'));
    }
}
