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
    <h1>Our Products</h1>

    <ul>
        <li>
            <a href="{{ route('barang') }}">
                All Products
            </a>
        </li>
        @foreach($categories as $category)
            <li>
                <a href="{{ route('barang', ['category' => $category->id]) }}">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
    <div>
        @forelse($barangs as $brg)
            <div>
                <div>
                    @if ($brg->gambar)
                        <img src="{{ asset('images/' . $brg->gambar) }}" 
                             alt="{{ $brg->nama_barang }}">
                    @else
                        <div>
                            <span>No Image</span>
                        </div>
                    @endif
                    
                    <div>
                        <h5>{{ $brg->nama_barang }}</h5>
                        <p>
                            <span>{{ $brg->category->name }}</span>
                        </p>
                        <p>
                            <strong>Price:</strong> Rp {{ number_format($brg->harga, 0, ',', '.') }}
                        </p>
                        <p>
                            <strong>Stock:</strong> {{ $brg->stok }}
                        </p>
                        <a href="{{ route('purchases.create', $brg->id) }}">
                            Beli Sekarang
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div>
                <div>
                    No products available in this category
                </div>
            </div>
        @endforelse
    </div>
</div>
</body>
</html>
@endsection