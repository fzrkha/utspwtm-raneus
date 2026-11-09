@extends('layouts.user')
@section('title', 'Data Murid')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Data Murid</h3>
        <p class="text-muted mb-0">
            Kelola seluruh data murid.
        </p>
    </div>

    <button type="button" class="btn-outline theme-primary" data-bs-toggle="dialog" data-bs-target="#modalTambah">
        <i class="fa-solid fa-plus me-1"></i>
        Tambah Murid
    </button>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>NIS</th>
                        <th>Nama Murid</th>
                        <th>Kelas</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($data as $murid)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>{{ $murid->nis }}</td>

                            <td>{{ $murid->nama }}</td>

                            <td>{{ $murid->kelas }}</td>

                            <td class="text-center">
                                <button type="button"
                                    class="btn-outline theme-warning btn-sm btn-edit"
                                    data-bs-toggle="dialog"
                                    data-bs-target="#modalEdit"
                                    data-url="{{ route('admin.murid.update', $murid->id) }}"
                                    data-nis="{{ $murid->nis }}"
                                    data-nama="{{ $murid->nama }}"
                                    data-kelas="{{ $murid->kelas }}"
                                >
                                    <i class="fa-solid fa-pen"></i>

                                </button>

                                <button type="button"
                                    class="btn-outline theme-danger btn-sm btn-delete"
                                    data-bs-toggle="dialog"
                                    data-bs-target="#modalHapus"
                                    data-url="{{ route('admin.murid.destroy', $murid->id) }}"
                                    data-nama="{{ $murid->nama }}"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                Belum ada data murid.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer bg-white text-muted">
        Total {{ $data->count() }} data murid.
    </div>
</div>

<dialog class="dialog" id="modalTambah">
    <div class="dialog-header">
        <h5 class="dialog-title fw-bold">
            Tambah Murid
        </h5>

        <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Close"></button>
    </div>

    <form action="{{ route('admin.murid.store') }}" method="POST">
        @csrf
        <div class="dialog-body">
            <div class="mb-3">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" class="form-control" maxlength="4" minlength="4" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Murid</label>
                <input type="text" name="nama" class="form-control" maxlength="40" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control" maxlength="10" required>
            </div>
        </div>

        <div class="dialog-footer">
            <button type="button" class="btn-solid theme-inverse" data-bs-dismiss="dialog">
                Batal
            </button>

            <button type="submit" class="btn-solid theme-primary">
                Simpan
            </button>
        </div>
    </form>
</dialog>

<dialog class="dialog" id="modalEdit">
    <div class="dialog-header">
        <h5 class="dialog-title fw-bold">
            Edit Murid
        </h5>

        <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Close"></button>
    </div>

    <form id="formEdit" method="POST">
        @csrf
        @method('PUT')
        <div class="dialog-body">
            <div class="mb-3">
                <label class="form-label">NIS</label>
                <input type="text" id="editNis" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Murid</label>
                <input type="text" name="nama" id="editNama" class="form-control" maxlength="40" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" id="editKelas" class="form-control" maxlength="10"required>
            </div>
        </div>

        <div class="dialog-footer">
            <button type="button" class="btn-solid theme-inverse" data-bs-dismiss="dialog">
                Batal
            </button>

            <button type="submit" class="btn-solid theme-warning">
                Perbarui
            </button>
        </div>
    </form>
</dialog>

<dialog class="dialog dialog-sm" id="modalHapus">
    <div class="dialog-header">
        <h5 class="dialog-title fw-bold">
            Hapus Murid
        </h5>

        <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Close"></button>
    </div>

    <form id="formHapus" method="POST">
        @csrf
        @method('DELETE')
        <div class="dialog-body text-center">
            <i class="fa-solid fa-trash text-danger fa-3x mb-3"></i>

            <p class="mb-1">
                Yakin ingin menghapus murid:
            </p>

            <strong id="hapusNama"></strong>
        </div>

        <div class="dialog-footer justify-content-center">
            <button type="button" class="btn-solid theme-inverse" data-bs-dismiss="dialog">
                Batal
            </button>

            <button type="submit" class="btn-solid theme-danger">
                Hapus
            </button>
        </div>
    </form>
</dialog>

<script>
$(document).ready(function () {

    // Dialog Edit Murid
    $('.btn-edit').on('click', function () {

        // Mengambil data dari tombol
        let url = $(this).data('url');
        let nis = $(this).data('nis');
        let nama = $(this).data('nama');
        let kelas = $(this).data('kelas');

        // Mengatur action form
        $('#formEdit').attr('action', url);

        // Mengisi data murid
        $('#editNis').val(nis);
        $('#editNama').val(nama);
        $('#editKelas').val(kelas);

    });


    // Dialog Hapus Murid
    $('.btn-delete').on('click', function () {

        // Mengambil data dari tombol
        let url = $(this).data('url');
        let nama = $(this).data('nama');

        // Mengatur action form
        $('#formHapus').attr('action', url);

        // Menampilkan nama murid
        $('#hapusNama').text(nama);

    });

});
</script>

@endsection