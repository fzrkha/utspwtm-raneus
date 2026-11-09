@extends('layouts.user')
@section('title', 'Data Murid')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Data Pengguna</h3>
        <p class="text-muted mb-0">
            Kelola seluruh data pengguna.
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
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>{{ $pengguna->nip }}</td>

                            <td>{{ $pengguna->nama }}</td>

                            <td>{{ $pengguna->username }}</td>

                            <td>{{ $pengguna->telp }}</td>

                            <td>{{ $pengguna->email }}</td>

                            <td>{{ $pengguna->level }}</td>

                            <td class="text-center">
                                <button type="button"
                                    class="btn-outline theme-warning btn-sm btn-edit"
                                    data-bs-toggle="dialog"
                                    data-bs-target="#modalEdit"
                                    data-url="{{ route('admin.pengguna.update', $pengguna->id) }}"
                                    data-nis="{{ $pengguna->nis }}"
                                    data-nama="{{ $pengguna->nama }}"
                                    data-kelas="{{ $pengguna->kelas }}"
                                >
                                    <i class="fa-solid fa-pen"></i>

                                </button>

                                <button type="button"
                                    class="btn-outline theme-danger btn-sm btn-delete"
                                    data-bs-toggle="dialog"
                                    data-bs-target="#modalHapus"
                                    data-url="{{ route('admin.pengguna.destroy', $pengguna->id) }}"
                                    data-nama="{{ $pengguna->nama }}"
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
        Total {{ $data->count() }} data pengguna.
    </div>
</div>

@endsection