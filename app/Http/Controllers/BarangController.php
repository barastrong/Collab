<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Category;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $category_id = $request->query('category');
        
        $barangs = Barang::when($category_id, function($query) use ($category_id) {
            return $query->where('category_id', $category_id);
        })->get();
        
        return view('barang.index', compact('barangs', 'categories'));
    }

    public function table()
    {
        $barangs = Barang::with('category')->get();
        return view('barang.tablebarang', compact('barangs'));
    }

    public function add()
    {
        $categories = Category::all();
        return view('barang.add', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|min:5|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $image = $request->file('gambar');
        $newName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $newName);

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'category_id' => $request->category_id,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $newName,
        ]);

        return redirect()->route('tablebarang')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $barang = Barang::find($id);
        $categories = Category::all();
        return view('barang.edit', compact('barang', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|min:5|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $barang = Barang::find($id);

        if ($request->hasFile('gambar')) {
            // Delete old image
            if (file_exists(public_path('images/' . $barang->gambar))) {
                unlink(public_path('images/' . $barang->gambar));
            }

            $image = $request->file('gambar');
            $newName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $newName);
            $barang->gambar = $newName;
        }

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'category_id' => $request->category_id,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        return redirect()->route('tablebarang')->with('success', 'Barang berhasil diupdate');
    }
}