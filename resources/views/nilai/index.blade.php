@extends('layout.main')

@section('title', 'Data Nilai')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-card-list"></i> Data Nilai Mahasiswa</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <a href="{{ route('nilai.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Tambah Nilai
                        </a>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('nilai.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari nama mahasiswa atau mata kuliah..." 
                                       value="{{ request('search') }}">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                                @if(request('search'))
                                <a href="{{ route('nilai.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x"></i> Reset
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Mata Kuliah</th>
                                <th>Nilai Angka</th>
                                <th>Nilai Huruf</th>
                                <th width="15%">Act</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($nilai as $item)
                            <tr>
                                <td>{{ $nilai->firstItem() + $loop->index }}</td>
                                <td>{{ $item->mahasiswa->nim }}</td>
                                <td>{{ $item->mahasiswa->nama_mahasiswa }}</td>
                                <td>{{ $item->mata_kuliah }}</td>
                                <td>{{ $item->nilai_angka }}</td>
                                <td>
                                    <span class="badge 
                                        @if($item->nilai_huruf == 'A') bg-success
                                        @elseif($item->nilai_huruf == 'B') bg-primary
                                        @elseif($item->nilai_huruf == 'C') bg-warning
                                        @elseif($item->nilai_huruf == 'D') bg-danger
                                        @else bg-dark
                                        @endif">
                                        {{ $item->nilai_huruf }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('nilai.edit', encrypt($item->id)) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $item->id }}, '{{ $item->mahasiswa->nama_mahasiswa }}', '{{ $item->mata_kuliah }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $item->id }}" 
                                          action="{{ route('nilai.destroy', encrypt($item->id)) }}" 
                                          method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    @if(request('search'))
                                        Tidak ada data nilai yang sesuai dengan pencarian "{{ request('search') }}"
                                    @else
                                        Tidak ada data nilai
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $nilai->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus nilai <strong id="courseName"></strong> dari mahasiswa <strong id="studentName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let deleteFormId = null;
    
    function confirmDelete(id, studentName, courseName) {
        deleteFormId = id;
        document.getElementById('studentName').textContent = studentName;
        document.getElementById('courseName').textContent = courseName;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
    
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (deleteFormId) {
            document.getElementById('delete-form-' + deleteFormId).submit();
        }
    });
</script>
@endsection
