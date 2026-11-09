<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pengguna::orderBy('nip', 'asc')->get();

        return view('admin.pengguna', compact('data'));
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
        $data = $request->validate([
            'nip' => 'required|string|size:10|unique:pengguna,nip',
            'nama' => 'required|string|max:40',
            'username' => 'required|string|max:30|unique:pengguna,username',
            'password' => 'required|string|min:8|max:100',
            'telp' => 'required|string|max:15',
            'email' => 'required|email|max:100|unique:pengguna,email',
            'level' => 'required|in:administrasi,gurubk',
        ]);

        $data['password'] = Hash::make($data['password']);

        Pengguna::create($data);

        return redirect('/admin/pengguna')->with('success', 'Data pengguna berhasil ditambahkan.');
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
        $pengguna = Pengguna::where('id', $id)->firstOrFail();

        $data = $request->validate([
            'nama' => 'required|string|max:40',
            'username' => [
                'required',
                'string',
                'max:30',
                Rule::unique('pengguna', 'username')->ignore($pengguna->id, 'id'),
            ],
            'password' => 'nullable|string|min:8|max:100',
            'telp' => 'required|string|max:15',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('pengguna', 'email')->ignore($pengguna->id, 'id'),
            ],
            'level' => 'required|in:administrasi,gurubk',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $pengguna->update($data);

        return redirect('/admin/pengguna')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengguna = Pengguna::where('id', $id)->firstOrFail();

        $pengguna->delete();

        return redirect('/admin/pengguna')->with('success', 'Data pengguna berhasil dihapus.');
    }
}
