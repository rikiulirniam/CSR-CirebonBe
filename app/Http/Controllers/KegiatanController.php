<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Validator;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil nilai query parameter untuk pagination dan sorting
        $pStart = $request->query('pStart');
        $pEnd = $request->query('pEnd');
        $sortByDate = $request->query('sortByDate');

        // Query dasar untuk mengambil data
        $query = Kegiatan::query();

        // Tambahkan logika sorting jika parameter 'sortByDate' ada
        if ($sortByDate) {
            if ($sortByDate === 'oldest') {
                $query->orderBy('updated_at', 'asc');
            } else if ($sortByDate === 'latest') {
                $query->orderBy('updated_at', 'desc');
            }
        }

        // Tambahkan logika pagination jika parameter 'pStart' dan 'pEnd' ada
        if ($pStart !== null && $pEnd !== null) {
            $query->skip($pStart - 1)->take($pEnd - $pStart + 1);
        }

        // Ambil hasil query
        $kegiatans = $query->get();

        return response()->json([
            'message' => "Kegiatan berhasil ditampilkan",
            'kegiatan' => $kegiatans
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari request
        $validator = Validator::make($request->all(), [
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
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





        $slug = join("_", explode(' ', $request->judul));

        $kegiatan = new Kegiatan();
        $kegiatan->thumbnail = 'images/kegiatan/' + $request->thumbnail;


        $kegiatan->slug = $slug;
        $kegiatan->judul = $request->judul;
        $kegiatan->tags = $request->tags;
        $kegiatan->status = $request->status;
        $kegiatan->save();

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'kegiatan' => $kegiatan,
        ], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $kegiatan = Kegiatan::query()->where('slug', $slug)->first();

        return response()->json(['message' => "Detail kegiatan berhasil ditampilkan", "kegiatan" => $kegiatan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
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
                'message' => "Form tidak lengkap atau tipe gambar tidak didukung",
                'errors' => $validator->errors()
            ], 422);
        }

        // Temukan kegiatan berdasarkan slug
        $kegiatan = Kegiatan::where('slug', $slug)->first();

        if (!$kegiatan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Periksa apakah ada gambar yang diunggah
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            // Buat nama file unik
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            // Simpan gambar di folder public/images/kegiatan/
            $image->move(public_path('images/kegiatan/'), $imageName);

            // Hapus gambar lama jika ada (opsional)
            if ($kegiatan->thumbnail && file_exists(public_path($kegiatan->thumbnail))) {
                unlink(public_path($kegiatan->thumbnail));
            }

            // Update path gambar
            $kegiatan->thumbnail = 'images/kegiatan/' . $imageName;
        }

        // Update data lain
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
    public function destroy(string $slug)
    {
        // Temukan kegiatan berdasarkan slug
        $kegiatan = Kegiatan::where('slug', $slug)->first();

        if (!$kegiatan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Dapatkan path asli dari gambar yang tersimpan
        $imagePath = public_path($kegiatan->thumbnail);
        $realImagePath = realpath($imagePath);

        // Cek apakah path valid dan file ada
        if ($realImagePath && file_exists($realImagePath)) {
            unlink($realImagePath);
        }

        // Hapus entri dari database
        $kegiatan->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus' // Untuk debugging, dapat dihapus di produksi
        ], 200);
    }
}
