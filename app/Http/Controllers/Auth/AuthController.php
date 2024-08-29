<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User; // Tambahkan jika model User belum ada
use Hash;
use Laravel\Sanctum\PersonalAccessToken;


class AuthController extends Controller
{
    public function check()
    {
        $user = Auth::guard('admin')->user() ?? Auth::guard('mitra')->user();
        if ($user) {
            $role = Auth::guard('admin')->check() ? true : false;
            return response()->json([
                'message' => $role ? 'Hi Admin' : 'Hi Mitra',
                'user' => $user
            ]);
        }
        return response()->json(['message' => 'Unauthorized', 'role' => null], 401);
    }

    public function index()
    {
        if (Auth::check()) {
            return response()->json([
                'message' => 'User showed',
                'user' => Auth::user(),
            ], 200);
        }

        return response()->json(['message' => 'Not Found'], 404);
    }

    

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Email atau Password ngga valid',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::query()->where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $user->token = $user->createToken(Str::random(100))->plainTextToken;
            return response()->json([
                'message' => 'Login Success',
                'user' => $user
            ]);
        }

        return response()->json(['message' => 'Email atau Password salah'], 401);
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('admin');
        if ($user->check()) {
            $token = PersonalAccessToken::where('token', hash('sha256', explode('|', $request->bearerToken())[1]))->first();
            $user->user()->tokens()->where('id', $token->id)->delete();

            return response()->json([
                'message' => 'Berhasil logout!',
            ], 200);
        }
    }
}
