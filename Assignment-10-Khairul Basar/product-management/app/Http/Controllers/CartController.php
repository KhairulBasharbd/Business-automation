<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;


class CartController extends Controller
{
    public function addToCart($id)
    {
        $product = Product::find($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->selling_price,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);
        return response()->json(['success' => 'Product added to cart!']);
    }

    public function showCart()
    {
        return view('cart.index', ['cart' => session('cart', [])]);
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->id;

        if ($request->type == 'increase') {
            $cart[$id]['quantity']++;
        } elseif ($request->type == 'decrease' && $cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
        } elseif ($request->type == 'delete') {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);
        return response()->json(['success' => 'Cart updated!']);
    }

    public function pay()
    {
        session()->forget('cart');
        return response()->json(['success' => 'Payment successful!']);
    }
}
