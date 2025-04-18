<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(12);
        $categories = Category::all();
        return view('shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('shop.show', compact('product'));
    }

    public function category(Category $category)
    {
        $products = Product::where('category_id', $category->id)->paginate(12);
        $categories = Category::all();
        return view('shop.index', compact('products', 'categories', 'category'));
    }

    public function cart()
    {
        return view('shop.cart');
    }

    public function addToCart(Product $product)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function updateCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart');
        if(isset($cart[$product->id])) {
            $cart[$product->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Cart updated successfully');
    }

    public function removeFromCart(Product $product)
    {
        $cart = session()->get('cart');
        if(isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Product removed from cart successfully');
    }

    public function checkout()
    {
        $cart = session()->get('cart');
        if(!$cart) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }
        return view('shop.checkout');
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_address' => 'required|string|max:255',
            'client_phone' => 'required|string|max:15',
        ]);

        $cart = session()->get('cart');
        if(!$cart) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        foreach($cart as $productId => $item) {
            $product = Product::find($productId);
            if (!$product) {
                continue;
            }

            Order::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'total_price' => $item['quantity'] * $item['price'],
                'client_name' => $request->client_name,
                'client_address' => $request->client_address,
                'client_phone' => $request->client_phone,
            ]);
        }

        session()->forget('cart');
        return redirect()->route('shop.orders')->with('success', 'Order placed successfully!');
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
                      ->with('product')
                      ->orderBy('created_at', 'desc')
                      ->get();
        return view('shop.orders', compact('orders'));
    }
}
