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
            <h5>Riwayat Pembelian</h5>
        </div>
        <div>
            @if(session('success'))
                <div>
                    {{ session('success') }}
                </div>
            @endif

            @if($purchases->isEmpty())
                <div>
                    <p>Belum ada riwayat pembelian</p>
                </div>
            @else
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Kode Pembelian</th>
                                <th>Gambar</th>
                                <th>Produk</th>
                                <th>Ukuran</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $purchase)
                                <tr>
                                    <td>
                                        <span>{{ $purchase->purchase_code }}</span>
                                    </td>
                                    <td>
                                        @if($purchase->barang->gambar)
                                            <img src="{{ asset('images/' . $purchase->barang->gambar) }}" 
                                                alt="{{ $purchase->barang->nama_barang }}">
                                        @else
                                            <div>
                                                <i></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $purchase->barang->nama_barang }}</td>
                                    <td>{{ $purchase->size }}</td>
                                    <td>{{ $purchase->quantity }}</td>
                                    <td>Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        <span>
                                            {{ ucfirst($purchase->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $purchase->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ route('purchases.show', $purchase->id) }}" title="Lihat Detail">
                                                <i></i>
                                            </a>
                                            @if($purchase->status === 'pending')
                                                <form action="{{ route('purchases.cancel', $purchase->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin membatalkan pembelian ini?')" title="Batalkan Pembelian">
                                                        <i></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $purchases->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
</body>
</html>
@endsection