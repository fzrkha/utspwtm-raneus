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

    <button type="button" class="btn-outline theme-primary"
        data-bs-toggle="dialog" data-bs-target="#modalTambah">
        <i class="fa-solid fa-plus me-1"></i>
        Tambah Tanggapan
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
                        <th class="text-center" data-orderable="false">Aksi</th>
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

                            <td class="text-center">
                                <button type="button"
                                    class="btn-outline theme-warning btn-sm btn-edit"
                                    data-bs-toggle="dialog"
                                    data-bs-target="#modalEdit"
                                    data-url="{{ route('guru.tanggapan.update', $tanggapan->id) }}"
                                    data-idtgp="{{ $tanggapan->id_tgp }}"
                                    data-idplg="{{ $tanggapan->id_plg }}"
                                    data-isi="{{ $tanggapan->isi_tgp }}"
                                    data-tanggal="{{ $tanggapan->tgl_tgp }}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>

                                <button type="button"
                                    class="btn-outline theme-danger btn-sm btn-delete"
                                    data-bs-toggle="dialog"
                                    data-bs-target="#modalHapus"
                                    data-url="{{ route('guru.tanggapan.destroy', $tanggapan->id) }}"
                                    data-idtgp="{{ $tanggapan->id_tgp }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


{{-- MODAL TAMBAH --}}
<dialog class="dialog" id="modalTambah">
    <div class="dialog-header">
        <h5 class="dialog-title fw-bold">
            Tambah Tanggapan
        </h5>

        <button type="button" class="btn-close"
            data-bs-dismiss="dialog" aria-label="Close"></button>
    </div>

    <form action="{{ route('guru.tanggapan.store') }}" method="POST">
        @csrf

        <div class="dialog-body">

            <div class="mb-3">
                <label class="form-label">ID Tanggapan</label>
                <input type="text" name="id_tgp"
                    class="form-control" maxlength="10" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Pelanggaran Murid</label>

                <select name="id_plg" class="form-select select-pelanggaran"
                    required>
                    <option value="">Cari ID pelanggaran atau nama murid...</option>

                    @foreach ($pelanggaran as $item)
                        @if ($item->status == 'menunggu')
                            <option value="{{ $item->id_plg }}">
                                {{ $item->id_plg }} - {{ $item->murid->nama ?? '-' }}
                            </option>
                        @endif
                    @endforeach
                </select>

                <small class="text-muted">
                    Hanya pelanggaran yang belum ditanggapi.
                </small>
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Tanggapan</label>
                <textarea name="isi_tgp" class="form-control"
                    rows="4" required></textarea>
            </div>

            <div>
                <label class="form-label">Tanggal Tanggapan</label>
                <input type="date" name="tgl_tgp"
                    class="form-control" required>
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
            Edit Tanggapan
        </h5>

        <button type="button" class="btn-close"
            data-bs-dismiss="dialog" aria-label="Close"></button>
    </div>

    <form id="formEdit" method="POST">
        @csrf
        @method('PUT')

        <div class="dialog-body">

            <div class="mb-3">
                <label class="form-label">ID Tanggapan</label>
                <input type="text" id="editIdTgp"
                    class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Pelanggaran Murid</label>

                <select name="id_plg" id="editIdPlg"
                    class="form-select select-pelanggaran" required>

                    <option value="">Cari ID pelanggaran atau nama murid...</option>

                    @foreach ($pelanggaran as $item)
                        @if ($item->status == 'menunggu' || $item->tanggapan)
                            <option value="{{ $item->id_plg }}">
                                {{ $item->id_plg }} - {{ $item->murid->nama ?? '-' }}
                            </option>
                        @endif
                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Tanggapan</label>
                <textarea name="isi_tgp" id="editIsi"
                    class="form-control" rows="4" required></textarea>
            </div>

            <div>
                <label class="form-label">Tanggal Tanggapan</label>
                <input type="date" name="tgl_tgp" id="editTanggal"
                    class="form-control" required>
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
            Hapus Tanggapan
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
                Yakin ingin menghapus data tanggapan:
            </p>

            <strong id="hapusIdTgp"></strong>
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

        // INISIALISASI DATATABLES
        $('#tabelTanggapan').DataTable({
            "pageLength": 10,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
            }
        });

        // DROPDOWN PELANGGARAN
        $('#modalTambah .select-pelanggaran').select2({
            placeholder: 'Cari ID pelanggaran atau nama murid...',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#modalTambah')
        });

        $('#modalEdit .select-pelanggaran').select2({
            placeholder: 'Cari ID pelanggaran atau nama murid...',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#modalEdit')
        });


        // EDIT TANGGAPAN - EVENT DELEGATION
        $(document).on('click', '.btn-edit', function () {

            let url = $(this).data('url');
            let idTgp = $(this).data('idtgp');
            let idPlg = $(this).data('idplg');
            let isi = $(this).data('isi');
            let tanggal = $(this).data('tanggal');

            $('#formEdit').attr('action', url);

            $('#editIdTgp').val(idTgp);
            $('#editIdPlg').val(String(idPlg)).trigger('change');
            $('#editIsi').val(isi);
            $('#editTanggal').val(tanggal);

        });


        // HAPUS TANGGAPAN - EVENT DELEGATION
        $(document).on('click', '.btn-delete', function () {

            let url = $(this).data('url');
            let idTgp = $(this).data('idtgp');

            $('#formHapus').attr('action', url);
            $('#hapusIdTgp').text(idTgp);

        });

    });
</script>

@endsection