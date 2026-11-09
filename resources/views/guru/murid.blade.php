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

<!-- Tabel DataTables -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="tabelMurid" class="table table-hover align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th class="border-0">No.</th>
                        <th class="border-0">NIS</th>
                        <th class="border-0">Nama Murid</th>
                        <th class="border-0">Kelas</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $murid)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $murid->nis }}</td>
                            <td>{{ $murid->nama }}</td>
                            <td>{{ $murid->kelas }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    // Inisialisasi DataTables
    $('#tabelMurid').DataTable({
        "pageLength": 10,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
        }
    });
});
</script>
@endsection