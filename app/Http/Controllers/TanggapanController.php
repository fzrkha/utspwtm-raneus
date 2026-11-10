<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Tanggapan;
use App\Models\Pelanggaran;

class TanggapanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Tanggapan::with(['pelanggaran.murid', 'pengguna'])->orderBy('tgl_tgp', 'desc')->get();

        $pelanggaran = Pelanggaran::with(['murid', 'tanggapan'])->orderBy('tgl_pel', 'desc')->get();

        $user = Auth::user();

        if ($user->level == 'administrasi') {
            return view('admin.tanggapan', compact('data'));
        } elseif ($user->level == 'gurubk') {
            return view('guru.tanggapan', compact('data', 'pelanggaran'));
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
            'id_tgp' => 'required|string|max:10|unique:tanggapan,id_tgp',
            'id_plg' => 'required|string|exists:pelanggaran,id_plg|unique:tanggapan,id_plg',
            'isi_tgp' => 'required|string',
            'tgl_tgp' => 'required|date',
        ]);

        DB::transaction(function () use ($data) {
            $pelanggaran = Pelanggaran::where('id_plg', $data['id_plg'])->firstOrFail();

            $data['nip'] = Auth::user()->nip;

            Tanggapan::create($data);

            $pelanggaran->update([
                'status' => 'ditanggapi',
            ]);
        });

        return redirect('/guru/tanggapan')->with('success', 'Data tanggapan berhasil ditambahkan.');
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

        $tanggapan = Tanggapan::where('id', $id)->firstOrFail();

        $data = $request->validate([
            'id_plg' => [
                'required',
                'string',
                'exists:pelanggaran,id_plg',
                Rule::unique('tanggapan', 'id_plg')->ignore($tanggapan->id, 'id'),
            ],
            'isi_tgp' => 'required|string',
            'tgl_tgp' => 'required|date',
        ]);

        DB::transaction(function () use ($tanggapan, $data) {
            $idPlgLama = $tanggapan->id_plg;

            $pelanggaran = Pelanggaran::where('id_plg', $data['id_plg'])->firstOrFail();

            $tanggapan->update($data);

            if ($idPlgLama != $data['id_plg']) {
                Pelanggaran::where('id_plg', $idPlgLama)
                    ->update(['status' => 'menunggu']);
            }

            $pelanggaran->update([
                'status' => 'ditanggapi',
            ]);
        });

        return redirect('/guru/tanggapan')->with('success', 'Data tanggapan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::user()->level != 'gurubk') {
            abort(403);
        }

        $tanggapan = Tanggapan::where('id', $id)->firstOrFail();

        DB::transaction(function () use ($tanggapan) {
            $idPlg = $tanggapan->id_plg;

            $tanggapan->delete();

            Pelanggaran::where('id_plg', $idPlg)->update([
                'status' => 'menunggu',
            ]);
        });

        return redirect('/guru/tanggapan')->with('success', 'Data tanggapan berhasil dihapus.');
    }
}
