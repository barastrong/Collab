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
        <div>
            <div>
                <h5>Detail Pembelian</h5>
                <span>
                    {{ ucfirst($purchase->status) }}
                </span>
            </div>
            <div>
                @if(session('success'))
                    <div>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div>
                        {{ session('error') }}
                    </div>
                @endif

                <div>
                    <div>
                        <h6>Kode Pembelian</h6>
                        <p>{{ $purchase->purchase_code }}</p>
                    </div>
                    <div>
                        <h6>Tanggal Pembelian</h6>
                        <p>{{ $purchase->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div>
                    <div>
                        <h6>Detail Produk</h6>
                    </div>
                    <div>
                        <div>
                            <h6>Nama Produk</h6>
                            <p>{{ $purchase->barang->nama_barang }}</p>
                        </div>
                        <div>
                            <h6>Ukuran</h6>
                            <p>{{ $purchase->size }}</p>
                        </div>
                        <div>
                            <h6>Jumlah</h6>
                            <p>{{ $purchase->quantity }} pcs</p>
                        </div>
                    </div>
                    <div>
                        <div>
                            <h6>Harga Satuan</h6>
                            <p>Rp {{ number_format($purchase->price, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <h6>Total Harga</h6>
                            <p>{{ number_format($purchase->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <div>
                        <h6>Informasi Pengiriman</h6>
                    </div>
                    <div>
                        <div>
                            <h6>Alamat Pengiriman</h6>
                            <p>{{ $purchase->shipping_address }}</p>
                        </div>
                        <div>
                            <h6>Nomor Telepon</h6>
                            <p>{{ $purchase->phone_number }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <a href="{{ route('index') }}">
                        Kembali ke Daftar Pembelian
                    </a>
                    
                    @if($purchase->status === 'pending')
                        <form action="{{ route('purchases.cancel', $purchase->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin membatalkan pembelian ini?')">
                                Batalkan Pembelian
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
@endsection