<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($token)
    {
        $user = Mitra::where('verification_token', $token)->first();

        if (!$user) {
            // return response()->json(['message' => "Invalid verification link"]);
            return redirect('/verify_redirect')->with('error', 'Link verifikasi tidak valid atau sudah Kadaluarsa!');
        }

        $user->is_active = true;
        $user->verification_token = null; // Hapus token setelah verifikasi
        $user->save();

        // return response()->json(['message' => "Email verified successfully"]);
        return redirect('/verify_redirect')->with('success', 'Akun anda berhasil diaktivasi');
    }

    public function redirect()
    {
        return view('email.redirect');
    }
}
