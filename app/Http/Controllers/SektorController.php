<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Sektor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;
use Validator;

class SektorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pStart = $request->query('pStart');
        $pEnd = $request->query('pEnd');

        $query = Sektor::query()->withCount('programs');

        if ($pStart !== null) {
            if ($pEnd !== null) {
                // Jika ada pStart dan pEnd, ambil item dari pStart hingga pEnd
                $query->skip($pStart - 1)->take($pEnd - $pStart + 1);
            } else {
                // Jika hanya ada pStart, ambil item dari pStart hingga akhir dengan limit yang besar
                $query->skip($pStart - 1)->take(PHP_INT_MAX);
            }
        }

        $sektors = $query->get();

        return response()->json([
            'sektors' => $sektors,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10420',
            'status' => "nullable|boolean",
            'programs' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => "Jenis gambar tidak didukung",
                'errors' => $validator->errors()
            ], 422);
        }

        $imageName = join('', explode(' ', $request->name)) . Str::random(16) . "." . $request->image->getClientOriginalExtension();


        $sektor = Sektor::create([
            'name' => $request->name,
            'image' => $imageName,
            'description' => $request->description
        ]);

        for ($i = 0; $i < count($request->programs); $i++) {
            Program::create([
                'sektor_id' => $sektor->id,
                'nama' => $request->programs[$i]["nama"],
                'deskripsi' => $request->programs[$i]["deskripsi"],
            ]);
        }

        Storage::disk('public/images/sektor')->put($imageName, file_get_contents($request->image));

        // Return Json Response
        return response()->json([
            'message' => "Product successfully created."
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sektor = Sektor::query()
            ->where('id', $id)
            ->with(['programs.proyeks']) // Include the projects associated with each program
            ->first();
    
        return response()->json([
            'sektor' => $sektor
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => "nullable|boolean",
            'programs' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => "Jenis gambar tidak didukung",
                'errors' => $validator->errors()
            ], 422);
        }

        // Cari sektor yang ingin diupdate
        $sektor = Sektor::findOrFail($id);

        // Cek apakah ada gambar baru
        if ($request->hasFile('image')) {
            // Nama gambar baru
            $imageName = join('', explode(' ', $request->name ?? $sektor->name)) . Str::random(16) . "." . $request->image->getClientOriginalExtension();

            // Hapus gambar lama dari storage sebelum menyimpan gambar baru
            if ($sektor->image && Storage::disk('public')->exists('images/sektor/' . $sektor->image)) {
                Storage::disk('public')->delete('images/sektor/' . $sektor->image);
            }

            // Simpan gambar baru ke storage
            Storage::disk('public')->put('images/sektor/' . $imageName, file_get_contents($request->image));

            // Update gambar di database
            $sektor->image = $imageName;
        }

        // Update sektor
        $sektor->update([
            'name' => $request->name ?? $sektor->name,
            'image' => $sektor->image,
            'description' => $request->description ?? $sektor->description,
        ]);

        // Jika program di-submit, hapus program-program lama dan tambahkan program-program baru
        if ($request->has('programs')) {
            $sektor->programs()->delete();

            foreach ($request->programs as $program) {
                Program::create([
                    'sektor_id' => $sektor->id,
                    'nama' => $program["nama"],
                    'deskripsi' => $program["deskripsi"],
                ]);
            }
        }

        // Return Json Response
        return response()->json([
            'message' => "Sektor berhasil diperbarui!"
        ], 200);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}
}
