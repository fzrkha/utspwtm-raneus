@extends('layouts.user')
@section('title', 'Administrasi')
@section('content')
<style>
    .dashboard-wrapper {
        padding: 12px 0 24px;
    }

    .welcome-section {
        background: #f1f6ff;
        border-radius: 12px;
        padding: 28px;
        margin-bottom: 28px;
    }

    .welcome-section h3 {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .welcome-section p {
        margin: 0;
        color: #64748b;
    }

    .section-title {
        font-size: 19px;
        font-weight: 700;
        margin-bottom: 16px;
        color: #212529;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 30px;
    }

    .stats-card {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 18px;
        min-width: 0;
        box-shadow: 0 3px 12px rgba(0,0,0,0.04);
        transition: transform 0.2s ease;
    }

    .stats-card:hover {
        transform: translateY(-3px);
    }

    .stats-icon {
        width: 55px;
        height: 55px;
        min-width: 55px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
    }

    .stats-info p {
        color: #64748b;
        margin: 0 0 5px;
        font-size: 14px;
    }

    .stats-info h3 {
        font-size: 27px;
        font-weight: 700;
        margin: 0;
        color: #212529;
    }

    .icon-blue {
        background: #e7f1ff;
        color: #0d6efd;
    }

    .icon-red {
        background: #ffe8eb;
        color: #dc3545;
    }

    .icon-green {
        background: #e5f7ed;
        color: #198754;
    }

    .icon-violet {
        background: #d9b8ff;
        color: #4600b6;
    }

    .icon-pink {
        background: #fdd9ff;
        color: #ee6bff;
    }

    .icon-black {
        background: #000000;
        color: #797979;
    }

    .progress-card {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        padding: 28px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.04);
    }

    .progress-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 65px;
        padding: 15px;
    }

    .progress-circle {
        width: 170px;
        height: 170px;
        min-width: 170px;
        border-radius: 50%;
        background: conic-gradient(
            #0d6efd {{ $persentase }}%,
            #e9ecef {{ $persentase }}%
        );
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .progress-circle::before {
        content: '';
        position: absolute;
        width: 135px;
        height: 135px;
        background: white;
        border-radius: 50%;
    }

    .progress-value {
        position: relative;
        z-index: 1;
        font-size: 30px;
        font-weight: 700;
        color: #212529;
    }

    .progress-description {
        max-width: 350px;
    }

    .progress-description h5 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .progress-description p {
        color: #64748b;
        margin-bottom: 0;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .progress-content {
            flex-direction: column;
            gap: 25px;
            text-align: center;
        }

        .welcome-section h3 {
            font-size: 22px;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stats-card {
            padding: 20px;
        }

        .welcome-section {
            padding: 22px;
        }
    }
</style>

<div class="container-fluid px-3 px-lg-4 dashboard-wrapper">
    <div class="welcome-section">
        <h3>
            Selamat datang, {{ Auth::user()->nama }}!
        </h3>

        <p>
            Selamat bekerja. Berikut ringkasan data aplikasi
            Pelanggaran Murid hari ini.
        </p>
    </div>

    <h5 class="section-title">Ringkasan Data</h5>

    <div class="stats-grid">
        <div class="stats-card">
            <div class="stats-icon icon-black">
                <i class="fa-solid fa-users"></i>
            </div>

            <div class="stats-info">
                <p>Total Pengguna</p>
                <h3>{{ $jumlahPengguna }}</h3>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-icon icon-violet">
                <i class="fa-solid fa-users"></i>
            </div>

            <div class="stats-info">
                <p>Jumlah Admin</p>
                <h3>{{ $jumlahAdministrasi }}</h3>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-icon icon-pink">
                <i class="fa-solid fa-users"></i>
            </div>

            <div class="stats-info">
                <p>Jumlah Guru BK</p>
                <h3>{{ $jumlahGuruBK }}</h3>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-icon icon-blue">
                <i class="fa-solid fa-user-graduate"></i>
            </div>

            <div class="stats-info">
                <p>Total Murid</p>
                <h3>{{ $jumlahMurid }}</h3>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-icon icon-red">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>

            <div class="stats-info">
                <p>Total Pelanggaran</p>
                <h3>{{ $jumlahPelanggaran }}</h3>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-icon icon-green">
                <i class="fa-solid fa-comments"></i>
            </div>

            <div class="stats-info">
                <p>Total Tanggapan</p>
                <h3>{{ $jumlahTanggapan }}</h3>
            </div>
        </div>
    </div>

    <h5 class="section-title">Status Penanganan Pelanggaran</h5>

    <div class="progress-card">

        <div class="progress-content">
            <div class="progress-circle">
                <span class="progress-value">
                    {{ $persentase }}%
                </span>
            </div>

            <div class="progress-description">
                <h5>Persentase Pelanggaran Tertangani</h5>

                <p>
                    <strong>{{ $sudahDitanggapi }}</strong>
                    dari
                    <strong>{{ $jumlahPelanggaran }}</strong>
                    pelanggaran telah ditanggapi.
                </p>

                <p style="margin-top: 10px;">
                    @if ($persentase == 100)
                        Seluruh pelanggaran telah ditanggapi.
                    @elseif ($persentase == 0)
                        Belum ada pelanggaran yang ditanggapi.
                    @else
                        Masih terdapat
                        <strong>
                            {{ $jumlahPelanggaran - $sudahDitanggapi }}
                        </strong>
                        pelanggaran yang belum ditanggapi.
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection