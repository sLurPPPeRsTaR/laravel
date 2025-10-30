@extends('layout.main')

@section('title', 'Edit Mahasiswa')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="bi bi-pencil"></i> Edit Mahasiswa</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('mahasiswa.update', encrypt($mahasiswa->id)) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror" 
                               id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" 
                               placeholder="Contoh: 411231060" required>
                        @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_mahasiswa') is-invalid @enderror" 
                               id="nama_mahasiswa" name="nama_mahasiswa" value="{{ old('nama_mahasiswa', $mahasiswa->nama_mahasiswa) }}" 
                               placeholder="Contoh: Raymond" required>
                        @error('nama_mahasiswa')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="prodi" class="form-label">Program Studi <span class="text-danger">*</span></label>
                        <select class="form-select @error('prodi') is-invalid @enderror" 
                                id="prodi" name="prodi" required>
                            <option value="">Pilih Program Studi</option>
                            <option value="Teknik Informatika" {{ old('prodi', $mahasiswa->prodi) == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                            <option value="Sistem Informasi" {{ old('prodi', $mahasiswa->prodi) == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                            <option value="Teknik Komputer" {{ old('prodi', $mahasiswa->prodi) == 'Teknik Komputer' ? 'selected' : '' }}>Teknik Komputer</option>
                            <option value="Manajemen Informatika" {{ old('prodi', $mahasiswa->prodi) == 'Manajemen Informatika' ? 'selected' : '' }}>Manajemen Informatika</option>
                        </select>
                        @error('prodi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="angkatan" class="form-label">Angkatan <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('angkatan') is-invalid @enderror" 
                               id="angkatan" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan) }}" 
                               min="2000" max="{{ date('Y') }}" required>
                        @error('angkatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Update
                        </button>
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
