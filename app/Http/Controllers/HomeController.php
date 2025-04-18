<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categoriesCount = Category::count();  
        $productsCount = Product::count();    
        $ordersCount = Order::count();         

        return view('dashboard', compact('categoriesCount', 'productsCount', 'ordersCount'));
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminDashboard()
    {
        // Get total counts
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        
        // Calculate total revenue
        $totalRevenue = Order::sum('total_price');

        // Get recent orders with all necessary information
        $recentOrders = Order::with(['product'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($order) {
                return [
                    'id' => $order->id,
                    'customer_name' => $order->client_name,
                    'total' => $order->total_price,
                    'status' => $order->is_delivered ? 'Delivered' : 'Pending',
                    'status_color' => $order->is_delivered ? 'success' : 'warning',
                    'created_at' => $order->created_at
                ];
            });

        // Get top products by order count
        $topProducts = Product::withCount('orders')
            ->withSum('orders', 'total_price')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get()
            ->map(function($product) {
                return [
                    'name' => $product->name,
                    'orders_count' => $product->orders_count,
                    'revenue' => $product->orders_sum_total_price
                ];
            });

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalProducts',
            'totalCategories',
            'totalRevenue',
            'recentOrders',
            'topProducts'
        ));
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userDashboard()
    {
        $recentOrders = auth()->user()->orders()->latest()->take(5)->get();
        return view('user.dashboard', compact('recentOrders'));
    }
}
