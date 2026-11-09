<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MuridController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Murid::all();
        $user = Auth::user();

        if ($user->level == 'administrasi') {
            return view('admin.murid', compact('data'));
        } elseif ($user->level == 'gurubk') {
            return view('guru.murid', compact('data'));
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
        $request->validate([
            'nis' => 'required|string|size:4|unique:murid,nis',
            'nama' => 'required|string|max:40',
            'kelas' => 'required|string|max:10',
        ]);

        Murid::create($request->only([
            'nis',
            'nama',
            'kelas'
        ]));

        return redirect('/admin/murid')->with('success', 'Data murid berhasil ditambahkan.');
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
        $murid = Murid::where('id', $id)->firstOrFail();

        $request->validate([
            'nama' => 'required|string|max:40',
            'kelas' => 'required|string|max:10',
        ]);

        $murid->update($request->only([
            'nama',
            'kelas'
        ]));

        return redirect('/admin/murid')->with('success', 'Data murid berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $murid = Murid::where('id', $id)->firstOrFail();

        if ($murid->pelanggaran()->exists()) {
            return redirect('/admin/murid')->with('error', 'Murid masih memiliki data pelanggaran.');
        }

        $murid->delete();

        return redirect('/admin/murid')->with('success', 'Data murid berhasil dihapus.');
    }
}