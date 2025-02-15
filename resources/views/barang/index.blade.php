@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div>
    <div>
        <h1>Daftar Barang</h1>

        <!-- Products Grid -->
        <div>
            @forelse($barangs as $barang)
                <div>
                    <!-- Product Image -->
                    <div>
                        <img src="{{ asset('images/' . $barang->gambar) }}" 
                             alt="{{ $barang->nama_barang }}">
                    </div>
                    
                    <!-- Product Details -->
                    <div>
                        <h2>{{ $barang->nama_barang }}</h2>
                        <div>
                            <span>
                                Rp {{ number_format($barang->harga, 0, ',', '.') }}
                            </span>
                            <span>
                                Stok: {{ $barang->stok }}
                            </span>
                        </div>
                        
                        <div>
                            @if($barang->stok > 0)
                                <button>
                                    Beli Sekarang
                                </button>
                            @else
                                <button disabled>
                                    Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div>
                    <p>
                    No items available.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
</body>
</html>
@endsection