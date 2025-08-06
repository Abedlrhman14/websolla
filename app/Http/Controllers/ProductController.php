<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // show all products
    public function index(){
        $products = Product::latest()->paginate(10);
        return view('products.index',compact('products'));
    }

    // add product form
    public function create(){
        return view('products.create');
    }

    // store products
    public function store(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('products' , 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('product added successfuly');
    }

    // update product form
        public function edit(Product $product){
            return view('products.edit', compact('product'));

        }
    // update product
    public function update(Request $request , Product $product){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('products','public');
        }

        $product->update($data);

               return response()->json([
                    'message' => 'Product updated successfully!',
                    'redirect' => route('products.index')
            ]);

    }

    // Delete product
      public function destroy(Product $product)
    {
        $product->delete();
      return response()->json([
        'message' => 'Product deleted successfully'
        ]);
    }
}
