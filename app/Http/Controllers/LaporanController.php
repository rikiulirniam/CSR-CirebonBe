<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;
use Str;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporan = Laporan::query()->with('kecamatan')->with('mitra')->get();
        return response()->json([
            'laporan' => $laporan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string',
            'dana_realisasi' => 'required|integer',
            'tgl_realisasi' => 'required|date',
            'status' => 'nullable|in:ditolak,diterima,revisi,draf',
            'tanggapan' => 'nullable|string', // Validasi untuk tanggapan
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'proyek_id' => 'required|exists:proyeks,id'
        ]);

        // Jika validasi gagal, kembalikan respons error
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed!',
                'errors' => $validator->errors()
            ], 422);
        }

        // Simpan gambar
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = "Laporan_" . Str::random(16) . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->put("images/laporan/{$imageName}", $image);
                $imagePaths[] = $imageName;
            }
        }

        // Buat entitas Laporan baru
        $laporan = Laporan::create([
            'judul' => $request->judul,
            'dana_realisasi' => $request->dana_realisasi,
            'tgl_realisasi' => $request->tgl_realisasi,
            'status' => 'draf', // Default ke 'draf' jika tidak disediakan
            'tanggapan' => $request->tanggapan, // Simpan tanggapan
            'images' => json_encode($imagePaths),
            'kecamatan_id' => $request->kecamatan_id,
            'proyek_id' => $request->proyek_id
        ]);

        // Kembalikan respons sukses
        return response()->json([
            'message' => 'Laporan sedang diajukan.',
            'laporan' => $laporan
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $laporan = Laporan::with(['mitra', 'kecamatan', 'proyek'])->findOrFail($id);

        if ($laporan->images) {
            $imagePaths = json_decode($laporan->images, true);
            $imageUrls = array_map(function ($image) {
                return asset('storage/images/' . $image);
            }, $imagePaths);

            $laporan->images = $imageUrls; // Menggunakan 'images' sebagai properti untuk menyimpan URL gambar
        }

        return response()->json([
            'laporan' => $laporan,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Cari entitas Laporan berdasarkan ID
        $laporan = Laporan::find($id);

        if (!$laporan) {
            return response()->json([
                'message' => "Laporan tidak ditemukan"
            ], 404);
        }

        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'judul' => 'nullable|string',
            'dana_realisasi' => 'nullable|integer',
            'tgl_realisasi' => 'nullable|date',
            'status' => 'nullable|in:ditolak,diterima,revisi,draf',
            'tanggapan' => 'nullable|string', // Validasi untuk tanggapan
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kecamatan_id' => 'nullable|exists:kecamatans,id',
            'proyek_id' => 'nullable|exists:proyeks,id'
        ]);

        // Jika validasi gagal, kembalikan respons error
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed!',
                'errors' => $validator->errors()
            ], 422);
        }

        // Perbarui data jika ada dalam request
        if ($request->has('judul')) {
            $laporan->judul = $request->judul;
        }
        if ($request->has('dana_realisasi')) {
            $laporan->dana_realisasi = $request->dana_realisasi;
        }
        if ($request->has('tgl_realisasi')) {
            $laporan->tgl_realisasi = $request->tgl_realisasi;
        }
        if ($request->has('status')) {
            $laporan->status = $request->status;
        }
        if ($request->has('tanggapan')) {
            $laporan->tanggapan = $request->tanggapan;
        }
        if ($request->has('kecamatan_id')) {
            $laporan->kecamatan_id = $request->kecamatan_id;
        }
        if ($request->has('proyek_id')) {
            $laporan->proyek_id = $request->proyek_id;
        }

        // Simpan gambar baru jika ada
        if ($request->hasFile('images')) {
            $imagePaths = json_decode($laporan->images, true) ?: [];

            // Hapus gambar lama dari storage
            foreach ($imagePaths as $oldImage) {
                Storage::disk('public')->delete("images/laporan/{$oldImage}");
            }

            // Simpan gambar baru
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imageName = "Laporan_" . Str::random(16) . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->put("images/laporan/{$imageName}", $image);
                $imagePaths[] = $imageName;
            }
            $laporan->images = json_encode($imagePaths);
        }

        // Simpan perubahan ke database
        $laporan->save();

        // Kembalikan respons sukses
        return response()->json([
            'message' => 'Laporan berhasil diperbarui.',
            'laporan' => $laporan
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
