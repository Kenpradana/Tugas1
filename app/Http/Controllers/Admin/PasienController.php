<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
    public function index()
    {
        $pasiens = User::where('role', 'pasien')->get();
        return view('admin.pasien.index', compact('pasiens'));
    }

    public function create()
    {
        return view('admin.pasien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255', // <-- UBAH name JADI nama
            'email'    => 'required|email|unique:users,email',
            'no_ktp'   => 'required|numeric|digits:16|unique:users,no_ktp',
            'no_hp'    => 'required|numeric|digits_between:10,15|unique:users,no_hp',
            'alamat'   => 'required|string|min:10',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'nama'     => $request->nama, // <-- UBAH name JADI nama
            'email'    => $request->email,
            'no_ktp'   => $request->no_ktp,
            'no_hp'    => $request->no_hp,
            'alamat'   => $request->alamat,
            'password' => Hash::make($request->password),
            'role'     => 'pasien',
        ]);

        return redirect()->route('pasiens.index')->with('success', 'Pasien berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $pasien = User::where('role', 'pasien')->findOrFail($id);
        return view('admin.pasien.edit', compact('pasien'));
    }

    public function update(Request $request, $id)
    {
        $pasien = User::where('role', 'pasien')->findOrFail($id);

        $rules = [
            'nama'   => 'required|string|max:255', // <-- UBAH name JADI nama
            'no_ktp' => 'required|numeric|digits:16|unique:users,no_ktp,' . $pasien->id,
            'no_hp'  => 'required|numeric|digits_between:10,15|unique:users,no_hp,' . $pasien->id,
            'alamat' => 'required|string|min:10',
        ];

        if ($request->email != $pasien->email) {
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

        $pasien->update($validatedData);

        return redirect()->route('pasiens.index')->with('success', 'Data pasien berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pasien = User::where('role', 'pasien')->findOrFail($id);
        $pasien->delete();

        return redirect()->route('pasiens.index')->with('success', 'Pasien berhasil dihapus!');
    }
}