<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Str;
use Validator;

class MitraAuthController extends Controller
{

    public function index()
    {
        $mitra = Auth::guard('mitra')->user();


        if ($mitra) {
            return response()->json([
                'message' => 'Berhasil menampilkan kredensial mitra',
                'user' => $mitra,
            ]);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nama_perusahaan' => 'required',
            'nama_mitra' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Kredensial salah',
                'errors' => $validator->errors()
            ], 422);
        }

        // Buat pengguna baru
        $user = Mitra::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama_perusahaan' => $request->nama_perusahaan,
            'nama_mitra' => $request->nama_mitra,
            'role' => false
        ]);

        return response()->json([
            'message' => 'User berhasil terdaftar',
            'user' => $user,
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Email atau Password tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        $mitra = Mitra::query()->where('email', $request->email)->first();

        if ($mitra && Hash::check($request->password, $mitra->password)) {
            $mitra->token = $mitra->createToken(Str::random(100))->plainTextToken;
            return response()->json(['message' => 'Login Berhasil', 'user' => $mitra], 200);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('mitra');
        if ($user->check()) {
            $token = PersonalAccessToken::where('token', hash('sha256', explode('|', $request->bearerToken())[1]))->first();
            $user->user()->tokens()->where('id', $token->id)->delete();

            return response()->json([
                'message' => 'Berhasil logout!',
            ], 200);
        }
    }
}
