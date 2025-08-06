<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // this function to show the orders in cart page
    public function index() {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }
        // this function to find product by id and send this product to cart
    public function add(Request $request){
        $productId = $request->input('product_id');

        $product = Product::find($productId);
        if(! $product){
            return response()->json([
                'message' => 'product not found'
            ],404);
        }

        $cart = session()->get('cart',[]);

        if(isset($cart[$productId])){
            $cart[$productId]['quantity']++;
        }else{
             $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
            ];
        }
        session()->put('cart',$cart);
        return response()->json(['message' => 'Product added to cart successfully.']);
    }


    //this function for chekout the order
    public function storeOrder(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $oldCart = session()->get('cart', []);
        $quantities = $request->input('quantities', []);

        $newCart = [];

        foreach ($quantities as $productId => $qty) {
            if (isset($oldCart[$productId])) {
                $newCart[$productId] = $oldCart[$productId];
                $newCart[$productId]['quantity'] = $qty;
            }
        }
        $cart = $newCart;
        if(empty($cart)){
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        Order::create([
             'customer_name' => $request->name,
             'phone' => $request->phone,
             'address' => $request->address,
             'cart' => json_encode($cart),

        ]);
        session()->forget('cart');
        return redirect('/')->with('success', 'Order placed successfully!');
    }

        //this function to show orders user make it
    public function showOrders(){
        $orders = Order::latest()->get();
        return view('products.orders', compact('orders'));
    }
}
