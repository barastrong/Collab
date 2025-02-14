<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = ['nama_barang', 'category_id', 'harga', 'stok', 'gambar'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
