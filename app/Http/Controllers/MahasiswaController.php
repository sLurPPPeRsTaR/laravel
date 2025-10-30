<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Crypt;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::paginate(5);
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswa,nim|max:20',
            'nama_mahasiswa' => 'required|max:100',
            'prodi' => 'required|max:50',
            'angkatan' => 'required|integer',
        ]);

        Mahasiswa::create($request->all());

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan!');
    }

    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $mahasiswa = Mahasiswa::findOrFail($id);
            return view('mahasiswa.edit', compact('mahasiswa'));
        } catch (\Exception $e) {
            return redirect()->route('mahasiswa.index')->with('error', 'Data tidak ditemukan!');
        }
    }

    public function update(Request $request, $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $mahasiswa = Mahasiswa::findOrFail($id);

            $request->validate([
                'nim' => 'required|max:20|unique:mahasiswa,nim,' . $id,
                'nama_mahasiswa' => 'required|max:100',
                'prodi' => 'required|max:50',
                'angkatan' => 'required|integer',
            ]);

            $mahasiswa->update($request->all());

            return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->route('mahasiswa.index')->with('error', 'Gagal mengupdate data!');
        }
    }

    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $mahasiswa = Mahasiswa::findOrFail($id);
            $mahasiswa->delete();

            return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('mahasiswa.index')->with('error', 'Gagal menghapus data!');
        }
    }
}
