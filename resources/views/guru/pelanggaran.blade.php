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

    <button type="button" class="btn-outline theme-primary"
        data-bs-toggle="dialog" data-bs-target="#modalTambah">
        <i class="fa-solid fa-plus me-1"></i>
        Tambah Pelanggaran
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
                        <th>ID Pelanggaran</th>
                        <th>NIS</th>
                        <th>Nama Murid</th>
                        <th>Isi Pelanggaran</th>
                        <th>Tanggal</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
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

                            <td class="text-center">
                                @if($pelanggaran->status=='menunggu')
                                    <button type="button"
                                        class="btn-outline theme-warning btn-sm btn-edit"
                                        data-bs-toggle="dialog"
                                        data-bs-target="#modalEdit"
                                        data-url="{{ route('guru.pelanggaran.update', $pelanggaran->id) }}"
                                        data-idplg="{{ $pelanggaran->id_plg }}"
                                        data-nis="{{ $pelanggaran->nis }}"
                                        data-isi="{{ $pelanggaran->isi_pel }}"
                                        data-tanggal="{{ $pelanggaran->tgl_pel }}"
                                        data-status="{{ $pelanggaran->status }}"
                                        data-foto="{{ $pelanggaran->foto }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>

                                    <button type="button"
                                        class="btn-outline theme-danger btn-sm btn-delete"
                                        data-bs-toggle="dialog"
                                        data-bs-target="#modalHapus"
                                        data-url="{{ route('guru.pelanggaran.destroy', $pelanggaran->id) }}"
                                        data-idplg="{{ $pelanggaran->id_plg }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @else
                                    -
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


{{-- MODAL TAMBAH --}}
<dialog class="dialog" id="modalTambah">
    <div class="dialog-header">
        <h5 class="dialog-title fw-bold">
            Tambah Pelanggaran
        </h5>

        <button type="button" class="btn-close"
            data-bs-dismiss="dialog" aria-label="Close"></button>
    </div>

    <form action="{{ route('guru.pelanggaran.store') }}"
        method="POST" enctype="multipart/form-data">

        @csrf

        <div class="dialog-body">

            <div class="mb-3">
                <label class="form-label">ID Pelanggaran</label>
                <input type="text" name="id_plg"
                    class="form-control" maxlength="10" required>
            </div>

            <div class="mb-3">
                <label class="form-label">NIS / Nama Murid</label>

                <select name="nis" class="form-select select-murid"
                    required>
                    <option value="">Cari NIS atau nama murid...</option>

                    @foreach ($murid as $siswa)
                        <option value="{{ $siswa->nis }}">
                            {{ $siswa->nis }} - {{ $siswa->nama }}
                        </option>
                    @endforeach
                </select>

                <small class="text-muted">
                    Cari berdasarkan NIS atau nama murid.
                </small>
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Pelanggaran</label>
                <textarea name="isi_pel" class="form-control"
                    rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Pelanggaran</label>
                <input type="date" name="tgl_pel"
                    class="form-control" required>
            </div>

            <div>
                <label class="form-label">Foto Bukti</label>
                <input type="file" name="foto"
                    class="form-control"
                    accept="image/jpeg,image/png,image/jpg" required>

                <small class="text-muted">
                    Format JPG, JPEG, atau PNG.
                </small>
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


{{-- MODAL EDIT --}}
<dialog class="dialog" id="modalEdit">
    <div class="dialog-header">
        <h5 class="dialog-title fw-bold">
            Edit Pelanggaran
        </h5>

        <button type="button" class="btn-close"
            data-bs-dismiss="dialog" aria-label="Close"></button>
    </div>

    <form id="formEdit" method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="dialog-body">

            <div class="mb-3">
                <label class="form-label">ID Pelanggaran</label>
                <input type="text" id="editIdPlg"
                    class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">NIS / Nama Murid</label>

                <select name="nis" id="editNis"
                    class="form-select select-murid" required>

                    <option value="">Cari NIS atau nama murid...</option>

                    @foreach ($murid as $siswa)
                        <option value="{{ $siswa->nis }}">
                            {{ $siswa->nis }} - {{ $siswa->nama }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Pelanggaran</label>
                <textarea name="isi_pel" id="editIsi"
                    class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Pelanggaran</label>
                <input type="date" name="tgl_pel" id="editTanggal"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Saat Ini</label>

                <div id="fotoSaatIni" class="mb-2">
                    <span class="text-muted">Tidak ada foto.</span>
                </div>

                <label class="form-label">Ganti Foto</label>
                <input type="file" name="foto"
                    class="form-control"
                    accept="image/jpeg,image/png,image/jpg">

                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti foto.
                </small>
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


{{-- MODAL HAPUS --}}
<dialog class="dialog dialog-sm" id="modalHapus">
    <div class="dialog-header">
        <h5 class="dialog-title fw-bold">
            Hapus Pelanggaran
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
                Yakin ingin menghapus data pelanggaran:
            </p>

            <strong id="hapusIdPlg"></strong>
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
    const fotoDialog = document.getElementById('fotoDialog');
    const fotoPreview = document.getElementById('fotoPreview');

    const zoomIn = document.getElementById('zoomIn');
    const zoomOut = document.getElementById('zoomOut');
    const zoomReset = document.getElementById('zoomReset');
    const zoomValue = document.getElementById('zoomValue');

    let zoomLevel = 1;

    document.querySelectorAll('.btn-foto').forEach(button => {
        button.addEventListener('click', function () {
            fotoPreview.src = this.dataset.foto;

            zoomLevel = 1;
            updateZoom();
        });
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

    $(document).ready(function () {

        // DROPDOWN MURID
        $('#modalTambah .select-murid').select2({
            placeholder: 'Cari NIS atau nama murid...',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#modalTambah')
        });

        $('#modalEdit .select-murid').select2({
            placeholder: 'Cari NIS atau nama murid...',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#modalEdit')
        });


        // EDIT PELANGGARAN
        $('.btn-edit').on('click', function () {

            let url = $(this).data('url');
            let idPlg = $(this).data('idplg');
            let nis = $(this).data('nis');
            let isi = $(this).data('isi');
            let tanggal = $(this).data('tanggal');
            let foto = $(this).data('foto');

            $('#formEdit').attr('action', url);

            $('#editIdPlg').val(idPlg);
            $('#editNis').val(String(nis)).trigger('change');
            $('#editIsi').val(isi);
            $('#editTanggal').val(tanggal);

            // FOTO SAAT INI
            if (foto) {
                let fotoUrl = "{{ asset('') }}" + foto;

                $('#fotoSaatIni').html(
                    '<a href="' + fotoUrl + '" target="_blank">' +
                    '<img src="' + fotoUrl + '" ' +
                    'style="max-width:150px;max-height:120px;border-radius:8px;">' +
                    '</a>'
                );
            } else {
                $('#fotoSaatIni').html(
                    '<span class="text-muted">Tidak ada foto.</span>'
                );
            }

        });


        // HAPUS PELANGGARAN
        $('.btn-delete').on('click', function () {

            let url = $(this).data('url');
            let idPlg = $(this).data('idplg');

            $('#formHapus').attr('action', url);
            $('#hapusIdPlg').text(idPlg);

        });

    });
</script>

@endsection