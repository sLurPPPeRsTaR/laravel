@extends('layout.main')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-people-fill"></i> Data Mahasiswa</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="{{ route('mahasiswa.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Tambah Mahasiswa
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Prodi</th>
                                <th>Angkatan</th>
                                <th width="15%">Act</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mahasiswa as $item)
                            <tr>
                                <td>{{ $mahasiswa->firstItem() + $loop->index }}</td>
                                <td>{{ $item->nim }}</td>
                                <td>{{ $item->nama_mahasiswa }}</td>
                                <td>{{ $item->prodi }}</td>
                                <td>{{ $item->angkatan }}</td>
                                <td>
                                    <a href="{{ route('mahasiswa.edit', encrypt($item->id)) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $item->id }}, '{{ $item->nama_mahasiswa }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $item->id }}" 
                                          action="{{ route('mahasiswa.destroy', encrypt($item->id)) }}" 
                                          method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data mahasiswa</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $mahasiswa->links('pagination::bootstrap-5') }}
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
                <p>Apakah Anda yakin ingin menghapus data mahasiswa <strong id="studentName"></strong>?</p>
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
    
    function confirmDelete(id, name) {
        deleteFormId = id;
        document.getElementById('studentName').textContent = name;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
    
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (deleteFormId) {
            document.getElementById('delete-form-' + deleteFormId).submit();
        }
    });
</script>
@endsection
