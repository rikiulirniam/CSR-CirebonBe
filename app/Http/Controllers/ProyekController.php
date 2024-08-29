<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Http\Request;
use Storage;
use Str;
use Validator;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proyeks = Proyek::query()
            ->withCount(['laporans as mitra_count' => function ($query) {
                $query->where('status', 'diterima')->distinct('mitra_id');
            }])
            ->with('kecamatan')->get();

        return response()->json([
            'message' => "Proyek showed",
            'proyek' => $proyeks
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'deskripsi' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:10420', // max 10 MB
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'sektor_id' => 'required|exists:sektors,id',
            'program_id' => 'required|exists:programs,id',
        ]);

        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data yang diberikan tidak valid!',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Generate nama file untuk gambar
        $imageName = "Proyek_" . Str::random(32) . '.' . $request->image->getClientOriginalExtension();

        // Simpan gambar ke dalam storage
        Storage::disk('public')->put("images/proyek/{$imageName}", file_get_contents($request->image));

        // Buat data proyek baru
        $proyek = Proyek::create([
            'nama' => $request->nama,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'deskripsi' => $request->deskripsi ?? null,
            'image' => "images/proyek/{$imageName}",
            'status' => $request->status ?? true,
            'kecamatan_id' => $request->kecamatan_id,
            'sektor_id' => $request->sektor_id,
            'program_id' => $request->program_id,
        ]);

        // Return response dengan data proyek yang berhasil dibuat
        return response()->json([
            'message' => 'Proyek berhasil dibuat',
            'proyek' => $proyek,
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $proyek = Proyek::with('mitras')->with('kecamatan')->with('laporans')->where('id', $id)->first();

        return response()->json([
            'message' => "Proyek showed",
            'proyek' => $proyek
        ]);
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
