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
</div>

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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
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
@endsection