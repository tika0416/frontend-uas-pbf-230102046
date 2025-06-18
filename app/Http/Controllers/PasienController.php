<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PasienController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:8080/pasien');

        if ($response->successful()) {
            $mahasiswa = collect($response->json())->sortBy('id')->values();
            return view('Pasien.index', compact('pasien'));
        } else {
            return back()->with('error', 'Gagal ambil data');
        }
    }

    public function create()
    {
        return view('Pasien.create');
    }

    public function store(Request $request)
    {
        $response = Http::post('http://localhost:8080/pasien', [
            'npm_mhs' => $request->npm_mhs,
            'nama_mhs' => $request->nama_mhs,
            'prodi' => $request->prodi,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
        ]);

        if ($response->successful()) {
            return redirect()->route('Pasien.index')->with('success', 'Pasien berhasil ditambahkan');
        } else {
            return back()->with('error', 'Gagal menambahkan data');
        }
    }

    public function show($id)
    {
        $response = Http::get("http://localhost:8080/mahasiswa/$id");

        if ($response->successful()) {
            $mahasiswa = $response->json();
            return view('Pasien.show', compact('Pasien'));
        } else {
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function edit($id)
    {
        $response = Http::get("http://localhost:8080/pasien/$id");

        if ($response->successful()) {
            $mahasiswa = $response->json();
            return view('Pasien.edit', compact('pasien'));
        } else {
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $npm)
    {
        $response = Http::put("http://localhost:8080/mahasiswa/$npm", [
            'nama_mhs' => $request->nama_mhs,
            'prodi' => $request->prodi,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
        ]);

        if ($response->successful()) {
            return redirect()->route('Mahasiswa.index')->with('success', 'Data berhasil diupdate');
        } else {
            return back()->with('error', 'Gagal mengupdate data');
        }
    }

    public function destroy($npm)
    {
        $response = Http::delete("http://localhost:8080/mahasiswa/$npm");

        if ($response->successful()) {
            return redirect()->route('Mahasiswa.index')->with('success', 'Data berhasil dihapus');
        } else {
            return back()->with('error', 'Gagal menghapus data');
        }
    }
}
