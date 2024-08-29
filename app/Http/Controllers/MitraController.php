<?php

namespace App\Http\Controllers;

use App\Mail\VerificationEmail;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Mail;
use Storage;
use Str;
use Validator;

class MitraController extends Controller
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
        $query = Mitra::query();

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
        $mitras = $query->get();

        return response()->json([
            'message' => "Mitra berhasil ditampilkan",
            'mitras' => $mitras
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:10420',
            'nama_perusahaan' => 'required|string',
            'name' => 'required|string',
            'no_telepon' => 'required|string',
            'alamat' => 'nullable',
            'password' => 'required|string',
            'deskripsi' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Jenis gambar tidak didukung!',
                'errors' => $validator->errors()
            ], 422);
        }

        $verificationToken = Str::random(32);

        $imageName = "Mitra_" . Str::random(32) . '.' . $request->image->getClientOriginalExtension();

        $mitra = Mitra::create([
            'email' => $request->email,
            'name' => $request->name,
            'image' => "images/mitra/" . $imageName,
            'nama_perusahaan' => $request->nama_perusahaan,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat ?? null,
            'password' => $request->password,
            'verification_token' => $verificationToken,
            'deskripsi' => $request->deskripsi ?? null,

        ]);

        Storage::disk('public')->put("images/mitra/{$imageName}", file_get_contents($request->image));

        Mail::to($mitra->email)->send(new VerificationEmail($mitra));


        return response()->json([
            'message' => "Mitra Berhasil dibuat, silahkan cek email untuk aktivasi akun.",
            'mitra' => $mitra
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mitra = Mitra::with('laporans')->find($id);
        if(!$mitra){
            return response()->json([
                'message' => 'Mitra tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Mitra ditemukan',
            'mitra' => $mitra
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|email',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:10420',
            'nama_perusahaan' => 'nullable|string',
            'name' => 'nullable|string',
            'no_telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'password' => 'nullable|string',
            'deskripsi' => 'nullable|string'
        ]);

        // Jika validasi gagal, kembalikan respons error
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Jenis gambar tidak didukung!',
                'errors' => $validator->errors()
            ], 422);
        }

        // Temukan Mitra berdasarkan ID
        $mitra = Mitra::find($id);

        if (!$mitra) {
            return response()->json([
                'message' => 'Mitra tidak ditemukan'
            ], 404);
        }

        // Perbarui data mitra hanya jika ada di dalam request
        if ($request->has('email')) {
            $mitra->email = $request->email;
        }

        if ($request->has('name')) {
            $mitra->name = $request->name;
        }

        if ($request->has('nama_perusahaan')) {
            $mitra->nama_perusahaan = $request->nama_perusahaan;
        }

        if ($request->has('no_telepon')) {
            $mitra->no_telepon = $request->no_telepon;
        }

        if ($request->has('alamat')) {
            $mitra->alamat = $request->alamat;
        }

        if ($request->has('deskripsi')) {
            $mitra->deskripsi = $request->deskripsi;
        }

        // Jika ada password baru, perbarui password
        if ($request->has('password')) {
            $mitra->password = $request->password;
        }


        // Jika ada password baru, perbarui password
        if ($request->has('password')) {
            $mitra->password = $request->password;
        }

        // Jika ada gambar baru, simpan gambar dan perbarui field 'image'
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($mitra->image) {
                Storage::disk('public')->delete($mitra->image);
            }

            $imageName = "Mitra_" . Str::random(32) . '.' . $request->image->getClientOriginalExtension();
            $mitra->image = "images/mitra/" . $imageName;

            Storage::disk('public')->put("images/mitra/{$imageName}", file_get_contents($request->image));
        }

        // Simpan perubahan pada database
        $mitra->save();

        return response()->json([
            'message' => "Mitra berhasil diperbarui"
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mitra = Mitra::query()->where('id', $id)->first();

        if (!$mitra) {
            return response()->json([
                'message' => "Mitra tidak ditemukan"
            ], 404);
        }

        if ($mitra->is_active == false) {
            $mitra->is_active = true;
            $mitra->save();

            return response()->json([
                'message' => "Berhasil mengaktifkan  Mitra kembali"
            ], 200);
        }

        $mitra->is_active = false;
        $mitra->save();

        return response()->json([
            'message' => "Berhasil menonaktifkan  Mitra"
        ], 200);
    }
}
