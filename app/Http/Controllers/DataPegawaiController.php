<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPegawai;
use Illuminate\Support\Facades\Storage;

class DataPegawaiController extends Controller
{
    // Menampilkan data pegawai
    public function index()
    {
        $pegawai = DataPegawai::all();
        return view('data_pegawai', compact('pegawai'));
    }

    // Simpan data pegawai baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'posisi_pegawai' => 'required|string|max:255',
            'alamat_pegawai' => 'required|string',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'gaji_pegawai' => 'required|integer',
            'foto_pegawai' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $foto = $request->hasFile('foto_pegawai')
            ? $request->file('foto_pegawai')->store('pegawai', 'public')
            : null;

        DataPegawai::create([
            'nama_pegawai' => $request->nama_pegawai,
            'posisi_pegawai' => $request->posisi_pegawai,
            'alamat_pegawai' => $request->alamat_pegawai,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'gaji_pegawai' => $request->gaji_pegawai,
            'foto_pegawai' => $foto
        ]);

        return redirect()->back()->with('success', 'Pegawai berhasil ditambahkan');
    }

    // Update data pegawai
    public function update(Request $request, $id)
    {
        $pegawai = DataPegawai::findOrFail($id);

        $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'posisi_pegawai' => 'required|string|max:255',
            'alamat_pegawai' => 'required|string',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'gaji_pegawai' => 'required|integer',
            'foto_pegawai' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only([
            'nama_pegawai','posisi_pegawai','alamat_pegawai',
            'jam_masuk','jam_pulang','gaji_pegawai'
        ]);

        if ($request->hasFile('foto_pegawai')) {
            if ($pegawai->foto_pegawai) {
                Storage::disk('public')->delete($pegawai->foto_pegawai);
            }
            $data['foto_pegawai'] = $request->file('foto_pegawai')->store('pegawai','public');
        }

        $pegawai->update($data);

        return redirect()->back()->with('success', 'Pegawai berhasil diupdate');
    }

    // Hapus data pegawai
    public function destroy($id)
    {
        $pegawai = DataPegawai::findOrFail($id);

        if ($pegawai->foto_pegawai) {
            Storage::disk('public')->delete($pegawai->foto_pegawai);
        }

        $pegawai->delete();

        return redirect()->back()->with('success', 'Pegawai berhasil dihapus');
    }
}
