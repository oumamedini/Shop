<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $orders = Order::with('product')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::all();
        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'client_name' => 'required|string|max:255',
            'client_address' => 'required|string|max:255',
            'client_phone' => 'required|string|max:15',
            'shipping_method' => 'required|string|max:50',
            'payment_method' => 'required|string|max:50'
        ]);

        $product = Product::find($request->product_id);
        $total_price = $product->price * $request->quantity;

        Order::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
            'status' => 'pending',
            'is_delivered' => false,
            'client_name' => $request->client_name,
            'client_address' => $request->client_address,
            'client_phone' => $request->client_phone,
            'shipping_method' => $request->shipping_method,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'tracking_number' => null
        ]);

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    public function edit(Order $order)
    {
        $products = Product::all();
        return view('orders.edit', compact('order', 'products'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
            'tracking_number' => 'nullable|string|max:100',
            'payment_status' => 'required|string|in:pending,paid,failed,refunded',
            'shipping_method' => 'required|string|max:50',
            'payment_method' => 'required|string|max:50',
            'is_delivered' => 'boolean'
        ]);

        $order->update($request->all());
        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update([
            'status' => $request->status,
            'is_delivered' => $request->status === 'delivered'
        ]);

        return redirect()->route('orders.index')->with('success', 'Order status updated successfully!');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|string|in:pending,paid,failed,refunded'
        ]);

        $order->update(['payment_status' => $request->payment_status]);
        return redirect()->route('orders.index')->with('success', 'Payment status updated successfully!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }

    public function updateDeliveryStatus(Request $request, Order $order)
    {
        try {
            $request->validate([
                'is_delivered' => 'required|boolean',
            ]);
            $order->update([
                'is_delivered' => $request->is_delivered
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Delivery status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating delivery status: ' . $e->getMessage()
            ], 500);
        }
    }
}
