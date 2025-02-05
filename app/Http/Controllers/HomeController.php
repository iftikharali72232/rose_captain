<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use Carbon\Carbon;

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
        if (Auth::check()) {
            // Get the current user
            $user = Auth::user();

            // Check the user type condition (user type not equal to 0)
            if ($user->user_type != 0) {
                // Log out the user
                Auth::logout();

                // Redirect to the login page or any other page
                return redirect()->route('login')->with('error', trans('lang.not_valid_user'));
            }
        }
    
        // print_r($today_total); exit;
        return view('home');
    }
    private function topSellingProducts()
    {
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(item_quantity) as total_qty, SUM(item_total) as item_total'))
            ->groupBy('product_id')
            ->orderByDesc('item_total')
            ->limit(10)
            ->get();

        // Extract product IDs from the result
        $productIds = $topProducts->pluck('product_id');

        // Retrieve product details for the top products
        $products = Product::whereIn('id', $productIds)
            ->get(['id', 'p_name', 'price']);

        // Combine product details with total sales and item_total
        $result = $topProducts->map(function ($item) use ($products) {
            $product = $products->where('id', $item->product_id)->first();
            return [
                'product_id' => $item->product_id,
                'product_name' => isset($product->p_name) ? $product->p_name : "",
                'total_qty' => $item->total_qty,
                'item_price' => isset($product->price) ? $product->price : 0,
                'item_total' => isset($item->item_total) ? $item->item_total : 0,
            ];
        });
        return $result;
    }
    public function getLastFiveOrdersWithNames()
    {
        $lastFiveOrders = Order::latest()->where('manual_order', 0)->take(10)->get();

        $result = [];

        foreach ($lastFiveOrders as $order) {
            $user = User::find($order->user_id);
            $seller = User::find($order->seller_id);

            $result[] = [
                'order_id' => $order->id,
                'total' => $order->total,
                'status' => $order->order_status,
                'user_name' => $user->name,
                'seller_name' => $seller->name,
                // Add other relevant order details here
            ];
        }

        // Return the result
        return $result;
    }
    private function getTopSellers($startDate)
    {
        $topSellers = DB::table('orders')
            ->select('seller_id', DB::raw('SUM(paid) as total_sales'))
            ->whereDate('created_at', '>=', $startDate)
            ->groupBy('seller_id')
            ->orderByDesc('paid')
            ->limit(10)
            ->get();

        // Output or further processing
        return $topSellers;
    }

    public function profile()
    {
        $user = auth()->user();
        return view('users.profile', ['user' => $user]);
    }
}
