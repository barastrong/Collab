<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get counts
        $totalProducts = Barang::count();
        $totalUsers = User::count();
        $totalOrders = Purchase::count();
        $totalRevenue = Purchase::where('status', 'completed')->sum('total_price');
        
        // Get recent orders
        $recentOrders = Purchase::with(['user', 'barang'])
            ->latest()
            ->take(5)
            ->get();
            
        // Get low stock products
        $lowStockProducts = Barang::where('stok', '<', 10)
            ->with('category')
            ->get();
            
        // Get monthly sales data
        $monthlySales = Purchase::where('status', 'completed')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalUsers',
            'totalOrders',
            'totalRevenue',
            'recentOrders',
            'lowStockProducts',
            'monthlySales'
        ));
    }

    public function orders()
    {
        $orders = Purchase::with(['user', 'barang'])
            ->latest()
            ->paginate(10);
            
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Purchase $purchase)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        $purchase->update([
            'status' => $request->status
        ]);

        // If order is cancelled, restore the stock
        if ($request->status === 'cancelled') {
            $barang = $purchase->barang;
            $barang->update([
                'stok' => $barang->stok + $purchase->quantity
            ]);
        }

        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    public function orderDetail(Purchase $purchase)
    {
        $purchase->load(['user', 'barang']);
        return view('admin.order-detail', compact('purchase'));
    }

    public function exportOrders(Request $request)
    {
        $orders = Purchase::with(['user', 'barang'])->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="orders.csv"',
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'Purchase Code',
                'Customer Name',
                'Product',
                'Quantity',
                'Size',
                'Price',
                'Total Price',
                'Status',
                'Shipping Address',
                'Phone Number',
                'Order Date'
            ]);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->purchase_code,
                    $order->user->name,
                    $order->barang->nama_barang,
                    $order->quantity,
                    $order->size,
                    $order->price,
                    $order->total_price,
                    $order->status,
                    $order->shipping_address,
                    $order->phone_number,
                    $order->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}