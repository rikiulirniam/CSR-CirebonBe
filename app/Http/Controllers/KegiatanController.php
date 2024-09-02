<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Storage;
use Str;
use Validator;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pStart = $request->query('pStart');
        $pEnd = $request->query('pEnd');

        $query = Kegiatan::query();

        if ($pStart !== null) {
            if ($pEnd !== null) {
                $query->skip($pStart - 1)->take($pEnd - $pStart + 1);
            } else {
                $query->skip($pStart - 1)->take(PHP_INT_MAX);
            }
        }

        $kegiatan = $query->get();

        return response()->json([
            'message' => "Kegiatan berhasil ditampilkan",
            'kegiatan' => $kegiatan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari request
        $validator = Validator::make($request->all(), [
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:10240',
            'judul' => 'required|min:3',
            'tags' => 'required|string',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => "Form tidak lengkap atau tipe gambar tidak didukung",
                'errors' => $validator->errors()
            ]);
        }

        $imageName = "Kegiatan_".Str::random(32) . "." . $request->thumbnail->getClientOriginalExtension();

        $kegiatan = Kegiatan::create([
            'name' => $request->name,
            'thumbnail' => "/images/kegiatan/" . $imageName,
            'deskripsi' => $request->description,
            'judul' => $request->judul,
            'tags' => $request->tags,
            'status' => $request->status,
        ]);

        // Save Image in Storage folder
        Storage::disk('public')->put("images/kegiatan/{$imageName}", file_get_contents($request->thumbnail));

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'kegiatan' => $kegiatan,
        ], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kegiatan = Kegiatan::query()->where('id', $id)->first();

        return response()->json(['message' => "Detail kegiatan berhasil ditampilkan", "kegiatan" => $kegiatan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input dari request
        $validator = Validator::make($request->all(), [
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'judul' => 'nullable|min:3',
            'tags' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => "Tipe gambar tidak didukung!",
                'errors' => $validator->errors()
            ], 422);
        }
        

        // Temukan kegiatan berdasarkan ID
        $kegiatan = Kegiatan::where('id', $id)->first();

        if (!$kegiatan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Perbarui data lain
        if ($request->has('judul')) {
            $kegiatan->judul = $request->judul;
        }
        if ($request->has('tags')) {
            $kegiatan->tags = $request->tags;
        }
        if ($request->has('deskripsi')) {
            $kegiatan->deskripsi = $request->deskripsi;
        }
        if ($request->has('status')) {
            $kegiatan->status = $request->status;
        }

        // Simpan gambar jika ada
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = "Kegiatan_".Str::random(32) . "." . $image->getClientOriginalExtension();

            // Simpan gambar baru di folder public/images/kegiatan/
            Storage::disk('public')->put("images/kegiatan/{$imageName}", file_get_contents($image));

            // Hapus gambar lama jika ada
            if ($kegiatan->thumbnail && Storage::disk('public')->exists(ltrim($kegiatan->thumbnail, '/'))) {
                Storage::disk('public')->delete(ltrim($kegiatan->thumbnail, '/'));
            }

            // Update path gambar
            $kegiatan->thumbnail = "images/kegiatan/{$imageName}";
        }

        // Simpan perubahan ke database
        $kegiatan->save();

        return response()->json([
            'message' => 'Data berhasil diperbarui',
            'kegiatan' => $kegiatan,
        ], 200);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Temukan kegiatan berdasarkan ID
        $kegiatan = Kegiatan::where('id', $id)->first();

        if (!$kegiatan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Dapatkan path asli dari gambar yang tersimpan
        if ($kegiatan->thumbnail && Storage::disk('public')->exists($kegiatan->thumbnail)) {
            Storage::disk('public')->delete($kegiatan->thumbnail);
        }

        // Hapus entri dari database
        $kegiatan->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus'
        ], 200);
    }
}
