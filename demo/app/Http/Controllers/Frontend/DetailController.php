<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function productDetail($id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();
        return view('frontend.detail.detail', compact('product', 'user'));
    }
}
