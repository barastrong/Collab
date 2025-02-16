<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Category;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('barang.index', compact('barangs'));
    }
    public function category(Request $request)
    {
        $categories = Category::all();
        $category_id = $request->query('category');
        
        $barangs = Barang::when($category_id, function($query) use ($category_id) {
            return $query->where('category_id', $category_id);
        })->get();
        
        return view('barang.category', compact('barangs', 'categories'));
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
    
        $data = $request->all();
    
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $newName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $newName);
            $data['gambar'] = $newName;
        }
    
        Barang::create($data);
    
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
    
        $barang = Barang::findOrFail($id);
        $data = $request->except('gambar');
    
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($barang->gambar && file_exists(public_path('images/' . $barang->gambar))) {
                unlink(public_path('images/' . $barang->gambar));
            }
    
            $image = $request->file('gambar');
            $newName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $newName);
            $data['gambar'] = $newName;
        }
    
        $barang->update($data);
    
        return redirect()->route('tablebarang')->with('success', 'Barang berhasil diupdate');
    }

    public function delete($id)
    {
        $barang = Barang::findOrFail($id);
        
        if ($barang->gambar && file_exists(public_path('images/' . $barang->gambar))) {
            unlink(public_path('images/' . $barang->gambar));
        }
        
        $barang->delete();
        
        return redirect()->route('tablebarang')->with('success', 'Barang berhasil dihapus');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $returnTo = $request->input('return_to', 'index');
        
        $barangs = Barang::where('nama_barang', 'LIKE', "%{$query}%")
                         ->orWhere('harga', 'LIKE', "%{$query}%")
                         ->with('category')
                         ->get();
        
        $categories = Category::all();
        
        // Return to the appropriate view based on the source
        switch($returnTo) {
            case 'category':
                return view('barang.category', compact('barangs', 'categories', 'query'));
            case 'tablebarang':
                return view('barang.tablebarang', compact('barangs', 'query'));
            default:
                return view('barang.index', compact('barangs', 'query'));
        }
    }
}