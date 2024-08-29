<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationEmail;
use App\Models\Mitra;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Mail;
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

    public function verifyEmail($token)
    {
        $user = Mitra::where('verification_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Token tidak valid!'], 400);
        }

        $user->email_verified_at = now();
        $user->save();

        return response()->json(['message' => 'Email berhasil diverifikasi!'], 200);
    }



    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:mitras',
            'password' => 'required|min:8',
            'nama_perusahaan' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Email sudah terdaftar!',
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate verification token
        $verificationToken = Str::random(32);

        // Buat pengguna baru
        $user = Mitra::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama_perusahaan' => $request->nama_perusahaan,
            'name' => $request->name,
            'role' => false,
            'verification_token' => $verificationToken,
            'is_active' => true,
        ]);

        // Kirim email verifikasi
        Mail::to($user->email)->send(new VerificationEmail($user));

        return response()->json([
            'message' => 'Mitra berhasil terdaftar. Silakan cek email untuk aktivasi akun.',
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

        if (!$mitra) {
            return response()->json(['message' => 'User tidak ditemukan!'], 401);
        }

        // Cek apakah email sudah diverifikasi
        if (!is_null($mitra->verification_token)) {
            return response()->json(['message' => 'Akun belum diverifikasi. Silakan cek email Anda untuk verifikasi.'], 403);
        }

        if (Hash::check($request->password, $mitra->password)) {

            if ($mitra->is_active == false) {
                return response()->json(['message' => "Mitra ini telah di nonaktifkan!"], 403);
            }

            $mitra->token = $mitra->createToken(Str::random(100))->plainTextToken;

            return response()->json(['message' => 'Login Berhasil', 'user' => $mitra], 200);
        }

        return response()->json(['message' => 'Email atau Password salah'], 401);
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
