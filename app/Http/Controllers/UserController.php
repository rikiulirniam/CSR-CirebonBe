<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data dari tabel User dan Mitra
        $users = User::all();
        $mitras = Mitra::all();

        // Gabungkan koleksi dari kedua tabel
        $combined = $users->concat($mitras);

        // Urutkan hasil gabungan berdasarkan created_at
        $sorted = $combined->sortByDesc(function ($item) {
            return $item->created_at;
        });

        // Reset kunci setelah pengurutan
        $users = $sorted->values();

        // Kembalikan hasil sebagai JSON
        return response()->json(['users' => $users]);
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

        return response()->json(['message' => 'Route tidak ditemukan'], 404);
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

    public function userAdmin($id)
    {
        // Cari user berdasarkan ID di tabel 'users'
        $user = User::find($id);

        if ($user) {
            return response()->json([
                'message' => 'User Admin found',
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'User Admin not found'
            ], 404);
        }
    }

    // Fungsi untuk mendapatkan detail user mitra berdasarkan ID
    public function userMitra($id)
    {
        // Cari mitra berdasarkan ID di tabel 'mitras'
        $mitra = Mitra::find($id);

        if ($mitra) {
            return response()->json([
                'message' => 'User Mitra found',
                'user' => $mitra
            ], 200);
        } else {
            return response()->json([
                'message' => 'User Mitra not found'
            ], 404);
        }
    }

    public function updateAdmin(Request $request, $id)
    {
        // Temukan user berdasarkan ID di tabel Mitra
        $mitra = Mitra::find($id);

        if ($mitra) {
            // Hapus user dari tabel Mitra
            $mitra->delete();

            // Tambahkan user ke tabel Admin
            $admin = new User();
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->phone = $request->phone;
            $admin->address = $request->address;
            $admin->image = $request->image;
            $admin->role = true; // Set role sebagai admin
            $admin->save();

            return response()->json(['message' => 'User updated to Admin successfully'], 200);
        }

        return response()->json(['message' => 'User not found in Mitra'], 404);
    }

    public function updateMitra(Request $request, $id)
    {
        // Temukan user berdasarkan ID di tabel Admin
        $admin = User::find($id);

        if ($admin) {
            // Hapus user dari tabel Admin
            $admin->delete();

            // Tambahkan user ke tabel Mitra
            $mitra = new Mitra();
            $mitra->name = $request->name;
            $mitra->email = $request->email;
            $mitra->phone = $request->phone;
            $mitra->address = $request->address;
            $mitra->image = $request->image;
            $mitra->role = false; // Set role sebagai mitra
            $mitra->save();

            return response()->json(['message' => 'User updated to Mitra successfully'], 200);
        }

        return response()->json(['message' => 'User not found in Admin'], 404);
    }
}
