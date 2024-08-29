<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Storage;
use Str;
use Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Tipe gambar tidak didukung!',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::query()->where('id', Auth::user()->id)->first();;

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = "Profile_" . Str::random(32) . "." . $image->getClientOriginalExtension();

            Storage::disk('public')->put("images/profile/{$imageName}", file_get_contents($image));
            if ($user->image && Storage::disk('public')->exists(ltrim($user->image, '/'))) {
                Storage::disk("public")->delete(ltrim($user->image, '/'));
            }

            $user->image = "images/profile/{$imageName}";
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
