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
            
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'nilai' => 'required|string',
                'alamat' => 'required|string|max:255',
                'tempat' => 'required|string|max:255',
                'lahir' => 'required|date',
                'email' => 'required|email|unique:mahasiswa,email',
                'nisn' => 'required|string|unique:mahasiswa,nisn',
                'no' => 'required|string',
                'metodePembayaran' => 'required|string',
            ]);

            // Simpan data ke tb_mahasiswa
            $mahasiswa = Mahasiswa::create([
                'nisn' => $validated['nisn'],
                'nama' => $validated['nama'],
                'alamat' => $validated['alamat'],
                'tempat' => $validated['tempat'], 
                'tgl_lahir' => $validated['lahir'],
                'email' => $validated['email'],
                'no_tlp' => $validated['no'],
                'status_pembayaran' => 'BELUM_LUNAS',
            ]);

            // Simpan data ke tb_pembayaran
            Pembayaran::create([
                'mhs_id' => $mahasiswa->id,
                'nama' => $mahasiswa->nama,
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
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'transaction_id' => 'required|exists:pembayarans,id', // Validasi transaksi ada dalam tabel pembayaran
        ]);

        // Cari pembayaran berdasarkan transaction_id
        $pembayaran = Pembayaran::find($request->transaction_id);

        if (!$pembayaran) {
            return redirect()->back()->with('error', 'Pembayaran tidak ditemukan!');
        }

        // Update status pembayaran menjadi 'LUNAS'
        $pembayaran->status_pembayaran = 'LUNAS'; // Ganti dengan status sesuai kebutuhan
        $pembayaran->save();

        // Mengarahkan kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
