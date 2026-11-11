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
            <table id="tabelPelanggaran" class="table table-hover align-middle w-100">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>ID Pelanggaran</th>
                        <th>NIS</th>
                        <th>Nama Murid</th>
                        <th>Isi Pelanggaran</th>
                        <th>Tanggal</th>
                        <th data-orderable="false" class="text-center">Foto</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $pelanggaran)
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

                            <td class="text-center">
                                @if ($pelanggaran->foto)
                                    <button type="button"
                                            class="btn-outline theme-accent btn-sm btn-foto"
                                            data-foto="{{ asset($pelanggaran->foto) }}"
                                            data-bs-toggle="dialog"
                                            data-bs-target="#fotoDialog"
                                            data-bs-backdrop="static"
                                            data-bs-keyboard="false">

                                        <i class="fa-solid fa-image"></i>
                                        Lihat
                                    </button>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<dialog class="dialog dialog-lg"
        id="fotoDialog"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        aria-labelledby="fotoDialogLabel">

    <div class="dialog-header">
        <h5 class="dialog-title fw-bold" id="fotoDialogLabel">
            Foto Pelanggaran
        </h5>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="dialog"
                aria-label="Close">
        </button>
    </div>

    <div class="dialog-body">
        <div class="foto-preview">
            <img id="fotoPreview"
                 src=""
                 alt="Foto Pelanggaran">
        </div>

        <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
            <button type="button"
                    class="btn-solid theme-secondary btn-sm"
                    id="zoomOut"
                    title="Perkecil">
                <i class="fa-solid fa-minus"></i>
            </button>

            <span id="zoomValue" class="fw-semibold">
                100%
            </span>

            <button type="button"
                    class="btn-solid theme-secondary btn-sm"
                    id="zoomIn"
                    title="Perbesar">
                <i class="fa-solid fa-plus"></i>
            </button>

            <button type="button"
                    class="btn-solid theme-secondary btn-sm"
                    id="zoomReset">
                Reset
            </button>
        </div>
    </div>

    <div class="dialog-footer">
        <button type="button"
                class="btn-solid theme-accent"
                data-bs-dismiss="dialog">
            Close
        </button>
    </div>
</dialog>

<style>
    .foto-preview {
        width: 100%;
        max-height: 65vh;
        overflow: auto;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 10px;
    }

    .foto-preview img {
        width: 100%;
        max-width: none;
        height: auto;
        object-fit: contain;
        display: block;
    }
</style>

<script>
    $(document).ready(function () {
        // Inisialisasi DataTables
        $('#tabelPelanggaran').DataTable({
            "pageLength": 10,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
            }
        });

        // Script Foto Viewer
        const fotoPreview = document.getElementById('fotoPreview');
        const zoomIn = document.getElementById('zoomIn');
        const zoomOut = document.getElementById('zoomOut');
        const zoomReset = document.getElementById('zoomReset');
        const zoomValue = document.getElementById('zoomValue');
        let zoomLevel = 1;

        // Gunakan Event Delegation agar klik tombol foto berfungsi di semua pagination
        $(document).on('click', '.btn-foto', function () {
            fotoPreview.src = $(this).data('foto');
            zoomLevel = 1;
            updateZoom();
        });

        function updateZoom() {
            fotoPreview.style.width = (zoomLevel * 100) + '%';
            zoomValue.textContent = Math.round(zoomLevel * 100) + '%';
            zoomOut.disabled = zoomLevel <= 0.5;
            zoomIn.disabled = zoomLevel >= 3;
        }

        zoomIn.addEventListener('click', function () {
            if (zoomLevel < 3) {
                zoomLevel = Math.min(zoomLevel + 0.25, 3);
                updateZoom();
            }
        });

        zoomOut.addEventListener('click', function () {
            if (zoomLevel > 0.5) {
                zoomLevel = Math.max(zoomLevel - 0.25, 0.5);
                updateZoom();
            }
        });

        zoomReset.addEventListener('click', function () {
            zoomLevel = 1;
            updateZoom();
        });
    });
</script>
@endsection