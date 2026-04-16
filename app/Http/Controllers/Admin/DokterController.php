<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Poli; // <-- TAMBAHKAN INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    public function index()
    {
        // Hanya ambil user yang rolenya 'dokter'
        $dokters = User::where('role', 'dokter')->get();
        return view('admin.dokter.index', compact('dokters'));
    }

   public function create()
    {   
        $polis = Poli::all(); // <-- TAMBAHKAN INI
        return view('admin.dokter.create', compact('polis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'no_ktp'   => 'required|numeric|digits:16|unique:users,no_ktp',
            'no_hp'    => 'required|numeric|digits_between:10,15|unique:users,no_hp',
            'alamat'   => 'required|string|min:10',
            'password' => 'required|string|min:8',
            'id_poli'  => 'required|exists:poli,id', // <-- TAMBAHKAN INI
        ]);

        User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'no_ktp'   => $request->no_ktp,
            'no_hp'    => $request->no_hp,
            'alamat'   => $request->alamat,
            'password' => Hash::make($request->password),
            'role'     => 'dokter',
            'id_poli'  => $request->id_poli, // <-- TAMBAHKAN INI
        ]);

        return redirect()->route('dokters.index')->with('success', 'Dokter berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $dokter = User::where('role', 'dokter')->findOrFail($id);
        $polis = Poli::all(); // <-- TAMBAHKAN INI
        return view('admin.dokter.edit', compact('dokter', 'polis'));
    }


    public function update(Request $request, $id)
    {
        $dokter = User::where('role', 'dokter')->findOrFail($id);

        $rules = [
            'nama'   => 'required|string|max:255',
            'no_ktp' => 'required|numeric|digits:16|unique:users,no_ktp,' . $dokter->id,
            'no_hp'  => 'required|numeric|digits_between:10,15|unique:users,no_hp,' . $dokter->id,
            'alamat' => 'required|string|min:10',
            'id_poli'=> 'required|exists:poli,id', // <-- TAMBAHKAN INI
        ];

        if ($request->email != $dokter->email) {
            $rules['email'] = 'required|email|unique:users,email';
        } else {
            $rules['email'] = 'required|email';
        }

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8';
        }

        $validatedData = $request->validate($rules);

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        $dokter->update($validatedData);

        return redirect()->route('dokters.index')->with('success', 'Data dokter berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $dokter = User::where('role', 'dokter')->findOrFail($id);
        $dokter->delete();

        return redirect()->route('dokters.index')->with('success', 'Dokter berhasil dihapus!');
    }
}