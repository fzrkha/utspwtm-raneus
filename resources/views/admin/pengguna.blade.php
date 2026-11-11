@extends('layouts.user')
@section('title', 'Data Pengguna')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Data Pengguna</h3>
        <p class="text-muted mb-0">
            Kelola seluruh data pengguna.
        </p>
    </div>

    <button type="button" class="btn-outline theme-primary"
        data-bs-toggle="dialog" data-bs-target="#modalTambah">
        <i class="fa-solid fa-plus me-1"></i>
        Tambah Pengguna
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
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>No. Telp</th>
                        <th>Email</th>
                        <th>Jabatan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($data as $pengguna)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pengguna->nip }}</td>
                            <td>{{ $pengguna->nama }}</td>
                            <td>{{ $pengguna->username }}</td>
                            <td>{{ $pengguna->telp }}</td>
                            <td>{{ $pengguna->email }}</td>

                            <td>
                                {{ $pengguna->level == 'gurubk' ? 'Guru BK' : 'Administrasi' }}
                            </td>

                            <td class="text-center">
                                @if($pengguna->level != 'administrasi')
                                    <button type="button"
                                        class="btn-outline theme-warning btn-sm btn-edit"
                                        data-bs-toggle="dialog"
                                        data-bs-target="#modalEdit"
                                        data-url="{{ route('admin.pengguna.update', $pengguna->id) }}"
                                        data-nip="{{ $pengguna->nip }}"
                                        data-nama="{{ $pengguna->nama }}"
                                        data-username="{{ $pengguna->username }}"
                                        data-telp="{{ $pengguna->telp }}"
                                        data-email="{{ $pengguna->email }}"
                                        data-level="{{ $pengguna->level }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>

                                    <button type="button"
                                        class="btn-outline theme-danger btn-sm btn-delete"
                                        data-bs-toggle="dialog"
                                        data-bs-target="#modalHapus"
                                        data-url="{{ route('admin.pengguna.destroy', $pengguna->id) }}"
                                        data-nama="{{ $pengguna->nama }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                Belum ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer bg-white text-muted">
        Total {{ $data->count() }} data pengguna.
    </div>
</div>

<dialog class="dialog" id="modalTambah">
    <div class="dialog-header">
        <h5 class="dialog-title fw-bold">
            Tambah Pengguna
        </h5>

        <button type="button" class="btn-close"
            data-bs-dismiss="dialog" aria-label="Close"></button>
    </div>

    <form action="{{ route('admin.pengguna.store') }}" method="POST">
        @csrf

        <div class="dialog-body">

            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text" name="nip" class="form-control"
                    maxlength="10" minlength="10" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control"
                    maxlength="40" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control"
                    maxlength="30" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" minlength="8"
                    maxlength="100" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="tel" name="telp" class="form-control"
                    maxlength="15" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                    maxlength="100" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Level</label>

                <select name="level" class="form-select select-level" required>
                    <option value=""></option>
                    <option value="administrasi">Administrasi</option>
                    <option value="gurubk">Guru BK</option>
                </select>
            </div>
        </div>

        <div class="dialog-footer">
            <button type="button" class="btn-solid theme-inverse"
                data-bs-dismiss="dialog">
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
            Edit Pengguna
        </h5>

        <button type="button" class="btn-close"
            data-bs-dismiss="dialog" aria-label="Close"></button>
    </div>

    <form id="formEdit" method="POST">
        @csrf
        @method('PUT')

        <div class="dialog-body">

            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text" id="editNip" class="form-control"
                    readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" id="editNama"
                    class="form-control" maxlength="40" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" id="editUsername"
                    class="form-control" maxlength="30" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="editPassword"
                    class="form-control" maxlength="100"
                    placeholder="Kosongkan jika tidak ingin mengganti password.">
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="tel" name="telp" id="editTelp"
                    class="form-control" maxlength="15" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="editEmail"
                    class="form-control" maxlength="100" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Level</label>

                <select name="level" id="editLevel"
                    class="form-select select-level" required>
                    <option value="administrasi">Administrasi</option>
                    <option value="gurubk">Guru BK</option>
                </select>
            </div>

        </div>

        <div class="dialog-footer">
            <button type="button" class="btn-solid theme-inverse"
                data-bs-dismiss="dialog">
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
            Hapus Pengguna
        </h5>

        <button type="button" class="btn-close"
            data-bs-dismiss="dialog" aria-label="Close"></button>
    </div>

    <form id="formHapus" method="POST">
        @csrf
        @method('DELETE')

        <div class="dialog-body text-center">
            <i class="fa-solid fa-trash text-danger fa-3x mb-3"></i>

            <p class="mb-1">
                Yakin ingin menghapus pengguna:
            </p>

            <strong id="hapusNama"></strong>
        </div>

        <div class="dialog-footer justify-content-center">
            <button type="button" class="btn-solid theme-inverse"
                data-bs-dismiss="dialog">
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
        // DROPDOWN LEVEL
        $('#modalTambah .select-level').select2({
            placeholder: 'Pilih level...',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#modalTambah')
        });

        $('#modalEdit .select-level').select2({
            width: '100%',
            dropdownParent: $('#modalEdit')
        });

        // EDIT PENGGUNA
        $('.btn-edit').on('click', function () {

            let url = $(this).data('url');
            let nip = $(this).data('nip');
            let nama = $(this).data('nama');
            let username = $(this).data('username');
            let telp = $(this).data('telp');
            let email = $(this).data('email');
            let level = $(this).data('data-level');

            $('#formEdit').attr('action', url);

            $('#editNip').val(nip);
            $('#editNama').val(nama);
            $('#editUsername').val(username);
            $('#editPassword').val('');
            $('#editTelp').val(telp);
            $('#editEmail').val(email);
            $('#editLevel').val(level).trigger('change');

        });

        // HAPUS PENGGUNA
        $('.btn-delete').on('click', function () {

            let url = $(this).data('url');
            let nama = $(this).data('nama');

            $('#formHapus').attr('action', url);
            $('#hapusNama').text(nama);

        });

    });
</script>

@endsection