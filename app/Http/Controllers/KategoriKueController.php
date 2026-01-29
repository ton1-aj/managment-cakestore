<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriKue;
use Illuminate\Support\Facades\Storage;

class KategoriKueController extends Controller
{
    /**
     * Menampilkan semua kategori
     */
    public function index()
    {
        return view('kategori_kue', [
            'kategori' => KategoriKue::all()
        ]);
    }

    /**
     * Menyimpan data kategori kue
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori_kue'   => 'required|string|max:255',
            'gambar_kategori_kue' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // upload gambar (jika ada)
        if ($request->hasFile('gambar_kategori_kue')) {
            $gambar = $request->file('gambar_kategori_kue')
                            ->store('kategori_kue', 'public');
        } else {
            $gambar = null;
        }

        KategoriKue::create([
            'nama_kategori_kue'   => $request->nama_kategori_kue,
            'gambar_kategori_kue' => $gambar
        ]);

        return redirect()->back()->with('success', 'Kategori kue berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori_kue' => 'required',
            'gambar_kategori_kue' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $kategori = KategoriKue::findOrFail($id);

        $data = [
            'nama_kategori_kue' => $request->nama_kategori_kue
        ];

        if ($request->hasFile('gambar_kategori_kue')) {
            $data['gambar_kategori_kue'] =
                $request->file('gambar_kategori_kue')
                ->store('kategori', 'public');
        }

        $kategori->update($data);

        return redirect()->route('kategori_kue')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        $kategori = KategoriKue::findOrFail($id);

        // hapus gambar jika ada
        if ($kategori->gambar_kategori_kue) {
            Storage::disk('public')->delete($kategori->gambar_kategori_kue);
        }

        $kategori->delete();

        return redirect()->route('kategori_kue')
            ->with('success', 'Kategori berhasil dihapus');
    }

}
