<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data dari tabel 'coba'
        $data = Mahasiswa::all();
        return response()->json($data);
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
        try {
            // Validasi data
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'nilai' => 'required|string',
                'alamat' => 'required|string|max:255',
                'tempat' => 'required|string|max:255',
                'lahir' => 'required|date',
                'email' => 'required|email|unique:tb_mahasiswa,email',
                'nisn' => 'required|string|unique:tb_mahasiswa,nim',
                'no' => 'required|string',
                'metodePembayaran' => 'required|string',
            ]);

            // Simpan data ke tb_mahasiswa
            $mahasiswa = Mahasiswa::create([
                'nim' => $validated['nisn'],
                'nama' => $validated['nama'],
                'alamat' => $validated['alamat'],
                'tempat' => $validated['tempat'], 
                'tgl_lahir' => $validated['lahir'],
                'email' => $validated['email'],
                'status_pembayaran' => 'BELUM_LUNAS',
            ]);

            // Simpan data ke tb_pembayaran
            Pembayaran::create([
                'nim' => $validated['nisn'],
                'nama' => $validated['nama'],
                'nominal' => 300000, // Nominal pembayaran belum ada di form
                'metode_pembayaran' => $validated['metodePembayaran'],
                'status_pembayaran' => 'BELUM_LUNAS',
            ]);

            return response()->json(['message' => 'Pendaftaran berhasil disimpan!'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
