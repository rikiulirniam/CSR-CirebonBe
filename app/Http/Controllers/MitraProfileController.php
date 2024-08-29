<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;
use Str;

class MitraProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('mitra')->user();
        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'nama_perusahaan' => 'nullable|string',
            'no_telepon' => 'nullable|string',
            'alamat' => 'nullable|text',
            'deskripsi' => 'nullable|text'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Tipe gambar tidak didukung!',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Mitra::query()->where('id', Auth::guard('mitra')->user()->id)->first();

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if($request->has('nama_perusahaan')) {
            $user->nama_perusahaan = $request->nama_perusahaan;
        }

        if($request->has('no_telepon')){
            $user->no_telepon = $request->no_telepon;
        }

        if($request->has('alamat')){
            $user->alamat = $request->alamat;
        }

        if($request->has('deskripsi')){
            $user->deskripsi = $request->deskripsi;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = "Profile_" . Str::random(32) . "." . $image->getClientOriginalExtension();

            Storage::disk('public')->put("images/mitra/{$imageName}", file_get_contents($image));
            if ($user->image && Storage::disk('public')->exists(ltrim($user->image, '/'))) {
                Storage::disk("public")->delete(ltrim($user->image, '/'));
            }

            $user->image = "images/mitra/{$imageName}";
        }

        $user->save();

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
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
