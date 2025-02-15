<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_code',
        'user_id',
        'barang_id',
        'quantity',
        'size',
        'price',
        'total_price',
        'shipping_address',
        'phone_number',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public static function generatePurchaseCode()
    {
        $prefix = 'INV';
        $date = now()->format('Ymd');
        $random = str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        return $prefix . $date . $random;
    }
}