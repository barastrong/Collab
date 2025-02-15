@extends ('layouts.app')

@section ('content')
<!-- resources/views/barang/edit.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
</head>
<body>
    <h2>Edit Barang</h2>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label>Nama Barang:</label>
            <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}" required>
        </div>

        <div>
            <label>Kategori:</label>
            <select name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $barang->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Harga:</label>
            <input type="number" name="harga" value="{{ $barang->harga }}" required>
        </div>

        <div>
            <label>Stok:</label>
            <input type="number" name="stok" value="{{ $barang->stok }}" required>
        </div>

        <div>
            <label>Gambar Saat Ini:</label>
            <img src="{{ asset('images/'.$barang->gambar) }}" width="100">
        </div>

        <div>
            <label>Ganti Gambar (Opsional):</label>
            <input type="file" name="gambar">
        </div>

        <button type="submit">Update Barang</button>
    </form>

    <a href="{{ route('tablebarang') }}">Kembali</a>
</body>
</html>
@endsection