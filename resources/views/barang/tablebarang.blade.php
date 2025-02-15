@extends ('layouts.app')

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
    <h1>Welcome to my Laravel application</h1>

    <div>
        <a href="{{ route('barangadd') }}">Tambah barang</a>
    </div>

    <div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Category</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $index => $brg)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if ($brg->gambar)
                                <img src="{{ asset('images/' . $brg->gambar) }}" 
                                     alt="Image" 
                                     style="max-width: 100px;">
                            @else
                                No image
                            @endif
                        </td>
                        <td>{{ $brg->nama_barang }}</td>
                        <td>{{ $brg->stok }}</td>
                        <td>{{ $brg->category->name ?? 'Tidak ada kategori' }}</td>
                        <td>Rp {{ number_format($brg->harga, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Tidak ada barang tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

@endsection