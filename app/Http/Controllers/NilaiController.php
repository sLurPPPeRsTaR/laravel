<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Crypt;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Nilai::with('mahasiswa');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('mata_kuliah', 'like', "%{$search}%")
                  ->orWhereHas('mahasiswa', function($q) use ($search) {
                      $q->where('nama_mahasiswa', 'like', "%{$search}%");
                  });
        }

        $nilai = $query->paginate(5);
        return view('nilai.index', compact('nilai'));
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::all();
        return view('nilai.create', compact('mahasiswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'mata_kuliah' => 'required|max:100',
            'nilai_angka' => 'required|integer|min:0|max:100',
        ]);

        // Konversi nilai angka ke huruf
        $nilaiHuruf = $this->convertNilaiToHuruf($request->nilai_angka);

        Nilai::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'mata_kuliah' => $request->mata_kuliah,
            'nilai_angka' => $request->nilai_angka,
            'nilai_huruf' => $nilaiHuruf,
        ]);

        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil ditambahkan!');
    }

    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $nilai = Nilai::findOrFail($id);
            $mahasiswa = Mahasiswa::all();
            return view('nilai.edit', compact('nilai', 'mahasiswa'));
        } catch (\Exception $e) {
            return redirect()->route('nilai.index')->with('error', 'Data tidak ditemukan!');
        }
    }

    public function update(Request $request, $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $nilai = Nilai::findOrFail($id);

            $request->validate([
                'mahasiswa_id' => 'required|exists:mahasiswa,id',
                'mata_kuliah' => 'required|max:100',
                'nilai_angka' => 'required|integer|min:0|max:100',
            ]);

            $nilaiHuruf = $this->convertNilaiToHuruf($request->nilai_angka);

            $nilai->update([
                'mahasiswa_id' => $request->mahasiswa_id,
                'mata_kuliah' => $request->mata_kuliah,
                'nilai_angka' => $request->nilai_angka,
                'nilai_huruf' => $nilaiHuruf,
            ]);

            return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->route('nilai.index')->with('error', 'Gagal mengupdate data!');
        }
    }

    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $nilai = Nilai::findOrFail($id);
            $nilai->delete();

            return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('nilai.index')->with('error', 'Gagal menghapus data!');
        }
    }

    private function convertNilaiToHuruf($nilaiAngka)
    {
        if ($nilaiAngka >= 85) return 'A';
        if ($nilaiAngka >= 70) return 'B';
        if ($nilaiAngka >= 60) return 'C';
        if ($nilaiAngka >= 50) return 'D';
        return 'E';
    }
}
