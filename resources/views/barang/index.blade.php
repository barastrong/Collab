@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Our Products</h1>

    <!-- Category Tabs -->
    <ul class="nav nav-tabs mb-4 justify-content-center">
        <li class="nav-item">
            <a class="nav-link {{ !request('category') ? 'active' : '' }}" href="{{ route('barang') }}">
                All Products
            </a>
        </li>
        @foreach($categories as $category)
            <li class="nav-item">
                <a class="nav-link {{ request('category') == $category->id ? 'active' : '' }}" 
                   href="{{ route('barang', ['category' => $category->id]) }}">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>

    <!-- Products Grid -->
    <div class="row">
        @forelse($barangs as $brg)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if ($brg->gambar)
                        <img src="{{ asset('images/' . $brg->gambar) }}" 
                             class="card-img-top"
                             alt="{{ $brg->nama_barang }}"
                             style="height: 250px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" 
                             style="height: 250px;">
                            <span class="text-muted">No Image</span>
                        </div>
                    @endif
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $brg->nama_barang }}</h5>
                        <p class="card-text">
                            <span class="badge bg-primary">{{ $brg->category->name }}</span>
                        </p>
                        <p class="card-text mb-0">
                            <strong>Price:</strong> Rp {{ number_format($brg->harga, 0, ',', '.') }}
                        </p>
                        <p class="card-text">
                            <strong>Stock:</strong> {{ $brg->stok }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No products available in this category
                </div>
            </div>
        @endforelse
    </div>

    <!-- Admin Actions -->
    <div class="position-fixed bottom-0 end-0 p-3">
        <a href="{{ route('barangadd') }}" class="btn btn-primary btn-lg rounded-circle shadow">
            <i class="fas fa-plus"></i>
        </a>
    </div>
</div>

<style>
.nav-tabs {
    border-bottom: 2px solid #dee2e6;
}

.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 500;
    padding: 1rem 1.5rem;
}

.nav-tabs .nav-link:hover {
    border: none;
    color: #0d6efd;
}

.nav-tabs .nav-link.active {
    border: none;
    border-bottom: 2px solid #0d6efd;
    color: #0d6efd;
}

.card {
    transition: transform 0.2s;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card:hover {
    transform: translateY(-5px);
}

.badge {
    font-weight: 500;
    padding: 0.5em 1em;
}
</style>
@endsection