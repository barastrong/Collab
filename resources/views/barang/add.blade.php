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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Barang</div>
                <div class="card-body">
                    <form action="{{ route('barangstore') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger mb-3">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group mb-3">
                            <label for="gambar" class="form-label">Gambar Barang</label>
                            <input type="file" 
                                   class="form-control @error('gambar') is-invalid @enderror" 
                                   id="gambar" 
                                   name="gambar" 
                                   accept="image/jpeg,image/png,image/jpg" 
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" 
                                   class="form-control @error('nama_barang') is-invalid @enderror" 
                                   id="nama_barang" 
                                   name="nama_barang" 
                                   value="{{ old('nama_barang') }}" 
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" 
                                    id="category" 
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

                        <div class="form-group mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" 
                                   class="form-control @error('stok') is-invalid @enderror" 
                                   id="stok" 
                                   name="stok" 
                                   value="{{ old('stok') }}" 
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" 
                                   class="form-control @error('harga') is-invalid @enderror" 
                                   id="harga" 
                                   name="harga" 
                                   value="{{ old('harga') }}" 
                                   required>
                        </div>

                        <div class="form-group d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                            <a href="{{ route('tablebarang') }}" class="btn btn-secondary">Kembali</a>
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