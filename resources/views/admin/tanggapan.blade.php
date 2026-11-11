@extends('layouts.user')
@section('title', 'Data Tanggapan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Data Tanggapan</h3>
        <p class="text-muted mb-0">
            Kelola tanggapan terhadap pelanggaran murid.
        </p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="tabelTanggapan" class="table table-hover align-middle w-100">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>ID Tanggapan</th>
                        <th>ID Pelanggaran</th>
                        <th>Nama Murid</th>
                        <th>Isi Tanggapan</th>
                        <th>Tanggal</th>
                        <th>Guru BK</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $tanggapan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $tanggapan->id_tgp }}</td>
                            <td>{{ $tanggapan->id_plg }}</td>
                            <td>{{ $tanggapan->pelanggaran->murid->nama ?? '-' }}</td>
                            <td>{{ $tanggapan->isi_tgp }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($tanggapan->tgl_tgp)->format('d/m/Y') }}
                            </td>
                            <td>{{ $tanggapan->pengguna->nama ?? '-' }}</td>
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
        $('#tabelTanggapan').DataTable({
            "pageLength": 10,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
            }
        });
    });
</script>
@endsection