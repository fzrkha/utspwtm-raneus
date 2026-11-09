<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;
use App\Models\Murid;
use App\Models\Pelanggaran;
use App\Models\Tanggapan;

class AdminController extends Controller
{
    function index(){
        // echo 'Selamat datang <h1>'.Auth::user()->nama.'</h1>';
        // echo '<br><a href="logout">Logout</a>';

        $jumlahPengguna = Pengguna::count();
        $jumlahAdministrasi = Pengguna::where('level', 'administrasi')->count();
        $jumlahGuruBK = Pengguna::where('level', 'gurubk')->count();
        $jumlahMurid = Murid::count();
        $jumlahPelanggaran = Pelanggaran::count();
        $jumlahTanggapan = Tanggapan::count();

        $sudahDitanggapi = Pelanggaran::has('tanggapan')->count();

        $persentase = $jumlahPelanggaran > 0 ? round(($sudahDitanggapi / $jumlahPelanggaran) * 100) : 0;

        return view('admin.index', [
            'jumlahPengguna' => $jumlahPengguna,
            'jumlahAdministrasi' => $jumlahAdministrasi,
            'jumlahGuruBK' => $jumlahGuruBK,
            'jumlahMurid' => $jumlahMurid,
            'jumlahPelanggaran' => $jumlahPelanggaran,
            'jumlahTanggapan' => $jumlahTanggapan,
            'sudahDitanggapi' => $sudahDitanggapi,
            'persentase' => $persentase,
        ]);
    }
}
