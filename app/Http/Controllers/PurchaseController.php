<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    // Hapus method __construct dengan middleware
    // Dan pindahkan middleware ke routes

    public function create(Barang $barang)
    {
        return view('purchase.create', compact('barang'));
    }

    public function store(Request $request)
    {
        Log::info('Purchase store method called', $request->all());
    
        // Validasi input
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|in:S,M,L,XL,XXL',
            'shipping_address' => 'required|string',
            'phone_number' => 'required|string'
        ]);
    
        try {
            DB::beginTransaction();
    
            // Ambil data barang
            $barang = Barang::findOrFail($request->barang_id);
    
            // Cek stok
            if ($barang->stok < $request->quantity) {
                return redirect()->back()
                    ->with('error', 'Stok tidak mencukupi.');
            }
    
            // Hitung total harga
            $total_price = $barang->harga * $request->quantity;
    
            // Buat purchase
            $purchase = Purchase::create([
                'purchase_code' => $this->generatePurchaseCode(),
                'user_id' => auth()->id(),
                'barang_id' => $request->barang_id,
                'quantity' => $request->quantity,
                'size' => $request->size,
                'price' => $barang->harga,
                'total_price' => $total_price,
                'shipping_address' => $request->shipping_address,
                'phone_number' => $request->phone_number,
                'status' => 'pending'
            ]);
    
            // Kurangi stok barang
            $barang->decrement('stok', $request->quantity);
    
            DB::commit();
    
            return redirect()->route('purchases.show', $purchase->id)
                ->with('success', 'Pembelian berhasil dibuat!');
    
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in purchase store: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pembelian.');
        }
    }

    private function generatePurchaseCode()
    {
        $prefix = 'BAR';
        $timestamp = now()->format('YmdHis');
        $random = str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        return $prefix . $timestamp . $random;
    }

    public function show(Purchase $purchase)
    {
        // Pastikan user hanya bisa melihat pembeliannya sendiri
        if ($purchase->user_id !== auth()->id()) {
            abort(403);
        }

        return view('purchase.show', compact('purchase'));
    }

    public function cancel(Purchase $purchase)
    {
        // Validasi kepemilikan purchase
        if ($purchase->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    
        // Validasi status pembelian
        if ($purchase->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya pembelian dengan status pending yang dapat dibatalkan.');
        }
    
        try {
            DB::beginTransaction();
    
            // Update status pembelian
            $purchase->update([
                'status' => 'cancelled'
            ]);
    
            // Kembalikan stok barang
            $purchase->barang->increment('stock', $purchase->quantity);
    
            DB::commit();
    
            return redirect()->route('purchases.show', $purchase->id)
                ->with('success', 'Pembelian berhasil dibatalkan.');
    
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error cancelling purchase: ' . $e->getMessage());
    
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membatalkan pembelian.');
        }
    }

    public function index()
    {
        $purchases = Purchase::with(['barang'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('purchase.index', compact('purchases'));
    }
    public function table(){
        $buy = Purchase::with(['barang'])
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();
        return view('purchase.orders', compact('buy'));
    }
    public function updateStatus(Request $request, Purchase $purchase)
{
    // Validate the request
    $request->validate([
        'status' => 'required|in:pending,processing,shipped,completed,cancelled'
    ]);

    try {
        DB::beginTransaction();

        // Update the status
        $purchase->update([
            'status' => $request->status
        ]);

        // If status is changed to cancelled and it was not cancelled before,
        // return the stock
        if ($request->status === 'cancelled' && $purchase->getOriginal('status') !== 'cancelled') {
            $purchase->barang->increment('stok', $purchase->quantity);
        }
        // If status is changed from cancelled to something else,
        // deduct the stock again
        else if ($purchase->getOriginal('status') === 'cancelled' && $request->status !== 'cancelled') {
            $purchase->barang->decrement('stok', $purchase->quantity);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui'
        ]);

    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Error updating purchase status: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat memperbarui status'
        ], 500);
    }
}
}