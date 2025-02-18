<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
        ]);

        try {
            Product::create([
                'name' => $request->name,
                'type' => $request->type,
                'purchase_price' => $request->purchase_price,
                'selling_price' => $request->selling_price,
            ]);

            return response()->json(['success' => 'Product added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add product!'], 500);
        }
    }

    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }
}
