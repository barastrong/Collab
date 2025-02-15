@extends ('layouts.app')

@section ('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Barang</title>
</head>
<body>
<div>
    <div>
        <div>
            <div>
                <div>Tambah Barang</div>
                <div>
                    <form action="{{ route('barangstore') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            <div>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div>
                            <label for="gambar">Gambar Barang</label>
                            <input type="file" 
                                   id="gambar" 
                                   name="gambar" 
                                   accept="image/jpeg,image/png,image/jpg" 
                                   required>
                        </div>

                        <div>
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" 
                                   id="nama_barang" 
                                   name="nama_barang" 
                                   value="{{ old('nama_barang') }}" 
                                   required>
                        </div>

                        <div>
                            <label for="category">Kategori</label>
                            <select id="category" 
                                    name="category_id" 
                                    required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="stok">Stok</label>
                            <input type="number" 
                                   id="stok" 
                                   name="stok" 
                                   value="{{ old('stok') }}" 
                                   required>
                        </div>

                        <div>
                            <label for="harga">Harga</label>
                            <input type="number" 
                                   id="harga" 
                                   name="harga" 
                                   value="{{ old('harga') }}" 
                                   required>
                        </div>

                        <div>
                            <button type="submit">Tambah</button>
                            <a href="{{ route('tablebarang') }}">Kembali</a>
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