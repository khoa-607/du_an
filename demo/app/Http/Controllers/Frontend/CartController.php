<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $product = Product::find($productId);

        if ($product) {
            $cart = session()->get('cart', []);

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
            } else {
                $cart[$productId] = [
                    "name" => $product->name,
                    "quantity" => $quantity,
                    "price" => $product->price,
                    "image" => $product->image
                ];
            }

            session()->put('cart', $cart);

            $cartQuantity = array_sum(array_column($cart, 'quantity'));

            return response()->json(['cartQuantity' => $cartQuantity]);
        }

        return response()->json(['error' => 'Product not found'], 404);
    }

    public function updateCart(Request $request)
    {
        if ($request->has('product_id') && $request->has('quantity')) {
            $cart = session()->get('cart', []);

            if (isset($cart[$request->product_id])) {
                $cart[$request->product_id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);

                $cartTotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

                return response()->json(['success' => true, 'cartTotal' => $cartTotal]);
            }
        }

        return response()->json(['error' => 'Product not found'], 404);
    }

    public function removeFromCart(Request $request)
    {
        if ($request->has('product_id')) {
            $cart = session()->get('cart', []);

            if (isset($cart[$request->product_id])) {
                unset($cart[$request->product_id]);
                session()->put('cart', $cart);

                $cartTotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

                return response()->json(['success' => true, 'cartTotal' => $cartTotal]);
            }

            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json(['error' => 'Product ID not provided'], 400);
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart has been cleared successfully.');
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('frontend.cart.cart', compact('cart'));
    }
}
