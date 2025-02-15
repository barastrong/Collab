@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div>
    <div>
        <div>
            <div>
                <div>
                    <h5>Form Pembelian</h5>
                </div>
                <div>
                    @if(session('error'))
                        <div>
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('purchases.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="barang_id" value="{{ $barang->id }}">
                        
                        <div>
                            <label>Gambar Produk</label>
                            @if($barang->gambar)
                                <div>
                                    <img src="{{ asset('images/' . $barang->gambar) }}" 
                                         alt="{{ $barang->nama_barang }}">
                                </div>
                            @endif
                        </div>

                        <div>
                            <label>Nama Produk</label>
                            <input type="text" value="{{ $barang->nama_barang }}" readonly>
                        </div>

                        <div>
                            <label>Harga</label>
                            <input type="text" value="Rp {{ number_format($barang->harga, 0, ',', '.') }}" readonly>
                        </div>

                        <div>
                            <label>Stok Tersedia</label>
                            <input type="text" value="{{ $barang->stok }}" readonly>
                        </div>

                        <div>
                            <label>Ukuran</label>
                            <select name="size" required>
                                <option value="">Pilih Ukuran</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                            </select>
                            @error('size')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label>Jumlah</label>
                            <input type="number" name="quantity" min="1" max="{{ $barang->stok }}" required>
                            @error('quantity')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label>Alamat Pengiriman</label>
                            <textarea name="shipping_address" rows="3" required></textarea>
                            @error('shipping_address')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label>Nomor Telepon</label>
                            <input type="text" name="phone_number" required>
                            @error('phone_number')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <button type="submit">Buat Pembelian</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
@endsection