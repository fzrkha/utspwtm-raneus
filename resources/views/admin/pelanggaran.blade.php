@extends('layouts.user')
@section('title', 'Data Pelanggaran')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Data Pelanggaran</h3>
        <p class="text-muted mb-0">
            Kelola seluruh data pelanggaran murid.
        </p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>ID Pelanggaran</th>
                        <th>NIS</th>
                        <th>Nama Murid</th>
                        <th>Isi Pelanggaran</th>
                        <th>Tanggal</th>
                        <th>Foto</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($data as $pelanggaran)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pelanggaran->id_plg }}</td>
                            <td>{{ $pelanggaran->nis }}</td>
                            <td>{{ $pelanggaran->murid->nama ?? '-' }}</td>

                            <td>
                                {{ $pelanggaran->isi_pel }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($pelanggaran->tgl_pel)->format('d/m/Y') }}
                            </td>

                            <td>
                                @if ($pelanggaran->foto)
                                    <a href="{{ asset($pelanggaran->foto) }}"
                                        target="_blank"
                                        class="btn-outline theme-primary btn-sm">
                                        <i class="fa-solid fa-image"></i>
                                        Lihat
                                    </a>
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                @if ($pelanggaran->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">
                                        Menunggu
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        Ditanggapi
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                Belum ada data pelanggaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer bg-white text-muted">
        Total {{ $data->count() }} data pelanggaran.
    </div>
</div>
@endsection