<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Pelanggaran;
use App\Models\Murid;

class PelanggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pelanggaran::with('murid')->orderBy('tgl_pel', 'desc')->get();
        $murid = \App\Models\Murid::orderBy('nama', 'asc')->get();

        $user = Auth::user();

        if ($user->level == 'administrasi') {
            return view('admin.pelanggaran', compact('data', 'murid'));
        } elseif ($user->level == 'gurubk') {
            return view('guru.pelanggaran', compact('data', 'murid'));
        }

        abort(403);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->level != 'gurubk') {
            abort(403);
        }

        $data = $request->validate([
            'id_plg' => 'required|string|max:10|unique:pelanggaran,id_plg',
            'nis' => 'required|string|exists:murid,nis',
            'isi_pel' => 'required|string',
            'tgl_pel' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:24000',
        ]);

        if ($request->hasFile('foto')) {
            $folder = public_path('img/pelanggaran');

            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            $namaFoto = Str::uuid() . '.' . $request->file('foto')->extension();

            $request->file('foto')->move($folder, $namaFoto);

            $data['foto'] = 'img/pelanggaran/' . $namaFoto;
        }

        $data['status'] = 'menunggu';

        Pelanggaran::create($data);

        return redirect('/guru/pelanggaran')->with('success', 'Data pelanggaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::user()->level != 'gurubk') {
            abort(403);
        }

        $pelanggaran = Pelanggaran::where('id', $id)->firstOrFail();

        $data = $request->validate([
            'nis' => 'required|string|exists:murid,nis',
            'isi_pel' => 'required|string',
            'tgl_pel' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:24000',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($pelanggaran->foto) {

                if (str_starts_with($pelanggaran->foto, 'img/')) {
                    File::delete(public_path($pelanggaran->foto));
                } else {
                    Storage::disk('public')->delete($pelanggaran->foto);
                }
            }

            // Buat folder jika belum tersedia
            $folder = public_path('img/pelanggaran');

            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            // Upload foto baru
            $namaFoto = Str::uuid() . '.' . $request->file('foto')->extension();

            $request->file('foto')->move($folder, $namaFoto);

            $data['foto'] = 'img/pelanggaran/' . $namaFoto;
        }

        $pelanggaran->update($data);

        return redirect('/guru/pelanggaran')->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::user()->level != 'gurubk') {
            abort(403);
        }

        $pelanggaran = Pelanggaran::where('id', $id)->firstOrFail();

        if ($pelanggaran->foto) {
            if (str_starts_with($pelanggaran->foto, 'img/')) {
                File::delete(public_path($pelanggaran->foto));
            } else {
                Storage::disk('public')->delete($pelanggaran->foto);
            }
        }

        $pelanggaran->delete();

        return redirect('/guru/pelanggaran')->with('success', 'Data pelanggaran berhasil dihapus.');
    }
}
