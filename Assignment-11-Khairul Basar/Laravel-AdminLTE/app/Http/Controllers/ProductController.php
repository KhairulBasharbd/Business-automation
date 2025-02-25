<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    if ($request->ajax()) {
        $products = Product::query();
        return DataTables::of($products)
            ->addColumn('actions', function ($product) {
                return '
                    <a href="'.route('products.edit', $product->id).'" class="btn btn-sm btn-primary">Edit</a>
                    <form action="'.route('products.destroy', $product->id).'" method="POST" style="display:inline;">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    return view('dashboard'); // Redirect to the dashboard view
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'stock' => 'required|integer',
            'status' => 'required|in:active,inactive',
            'seo_tags' => 'nullable|string',
        ]);
    
        $product = Product::create($request->all());
    
        return response()->json(['success' => true, 'message' => 'Product added successfully']);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $product = Product::findOrFail($id);
        return response()->json($product);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        Product::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Product deleted successfully']);
    }
    
}
