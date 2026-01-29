<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kue;
use App\Models\KategoriKue;

class KueController extends Controller
{
    public function index()
{
    $kue = Kue::with('kategoriKue')->get();
    $kategori = KategoriKue::all();

    return view('kue', compact('kue', 'kategori'));
}

public function store(Request $request)
{
    $request->validate([
        'id_kategori_kue' => 'required',
        'nama_kue' => 'required',
        'harga_kue' => 'required|numeric',
        'stok_kue' => 'required|numeric',
        'komposisi_kue' => 'required',
        'foto_kue' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    // upload foto (jika ada)
    if ($request->hasFile('foto_kue')) {
    $foto = $request->file('foto_kue')->store('kue', 'public');
} else {
    $foto = null;
}


    Kue::create([
        'id_kategori_kue' => $request->id_kategori_kue,
        'nama_kue'        => $request->nama_kue,
        'harga_kue'       => $request->harga_kue,
        'stok_kue'        => $request->stok_kue,
        'komposisi_kue'   => $request->komposisi_kue,
        'foto_kue'        => $foto
    ]);

    return redirect()->route('kue')->with('success', 'Data kue berhasil disimpan');
}

public function update(Request $request, $id)
{
    $kue = Kue::findOrFail($id);

    $kue->update($request->except('foto_kue'));

    if ($request->hasFile('foto_kue')) {
        $kue->foto_kue = $request->file('foto_kue')->store('kue', 'public');
        $kue->save();
    }

    return redirect()->back()->with('success', 'Data berhasil diupdate');
}


    /**
     * HAPUS DATA KUE
     */
public function destroy($id)
{
    Kue::findOrFail($id)->delete();
    return redirect()->back()->with('success', 'Data berhasil dihapus');
}

}
