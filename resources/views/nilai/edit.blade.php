@extends('layout.main')

@section('title', 'Edit Nilai')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Nilai</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('nilai.update', encrypt($nilai->id)) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="mahasiswa_id" class="form-label">Mahasiswa <span class="text-danger">*</span></label>
                        <select class="form-select @error('mahasiswa_id') is-invalid @enderror" 
                                id="mahasiswa_id" name="mahasiswa_id" required>
                            <option value="">Pilih Mahasiswa</option>
                            @foreach($mahasiswa as $mhs)
                            <option value="{{ $mhs->id }}" {{ old('mahasiswa_id', $nilai->mahasiswa_id) == $mhs->id ? 'selected' : '' }}>
                                {{ $mhs->nim }} - {{ $mhs->nama_mahasiswa }}
                            </option>
                            @endforeach
                        </select>
                        @error('mahasiswa_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mata_kuliah" class="form-label">Mata Kuliah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('mata_kuliah') is-invalid @enderror" 
                               id="mata_kuliah" name="mata_kuliah" value="{{ old('mata_kuliah', $nilai->mata_kuliah) }}" 
                               placeholder="Contoh: Pemrograman Web" required>
                        @error('mata_kuliah')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nilai_angka" class="form-label">Nilai Angka <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('nilai_angka') is-invalid @enderror" 
                               id="nilai_angka" name="nilai_angka" value="{{ old('nilai_angka', $nilai->nilai_angka) }}" 
                               min="0" max="100" placeholder="0-100" required>
                        @error('nilai_angka')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <small>
                                Konversi: 85-100 = A, 70-84 = B, 60-69 = C, 50-59 = D, 0-49 = E
                            </small>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Update
                        </button>
                        <a href="{{ route('nilai.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
