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
    <form action="{{ route('barang.search') }}" method="GET" class="d-flex">
    <input type="text" name="query" class="form-control me-2" 
           value="{{ request('query') }}" 
           placeholder="Cari nama barang atau harga...">
    {{-- Add a hidden input to track the current page --}}
    <input type="hidden" name="return_to" value="{{ Route::currentRouteName() }}">
    <button type="submit" class="btn btn-primary">Cari</button>
</form>
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
                            <a href="{{ route('purchases.create', $barang->id) }}">
                            <button>
                                    Beli Sekarang
                                </button>
                            </a>
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