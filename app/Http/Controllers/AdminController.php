<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Murid;
use App\Models\Pelanggaran;
use App\Models\Tanggapan;

class AdminController extends Controller
{
    function index(){
        // echo 'Selamat datang <h1>'.Auth::user()->nama.'</h1>';
        // echo '<br><a href="logout">Logout</a>';

        $jumlahMurid = Murid::count();
        $jumlahPelanggaran = Pelanggaran::count();
        $jumlahTanggapan = Tanggapan::count();

        $sudahDitanggapi = Pelanggaran::has('tanggapan')->count();

        $persentase = $jumlahPelanggaran > 0 ? round(($sudahDitanggapi / $jumlahPelanggaran) * 100) : 0;

        return view('admin.index', [
            'jumlahMurid' => $jumlahMurid,
            'jumlahPelanggaran' => $jumlahPelanggaran,
            'jumlahTanggapan' => $jumlahTanggapan,
            'sudahDitanggapi' => $sudahDitanggapi,
            'persentase' => $persentase,
        ]);
    }
}
