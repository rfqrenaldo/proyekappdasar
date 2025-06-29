<?php

namespace App\Http\Controllers;

use App\Models\Stakeholder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class StakeholderController extends Controller
{
    // Menampilkan semua stakeholder di navbar
    public function view_NavStakeholder() // Bisa diganti index
    {
        // Ambil semua stakeholder dengan relasi projects
        $stakeholders = Stakeholder::with(['projects'])->get();

        // Kembalikan data sebagai JSON
        return response()->json([
            'status' => 'success',
            'data' => $stakeholders,
        ]);
    }

    public function searchStakeholder($keyword)
    {
        $stakeholder = Stakeholder::with(['projects'])
            ->where('nama', 'like', '%' . $keyword . '%')
            ->get();

        if ($stakeholder->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nama Stakeholder tidak ditemukan'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $stakeholder
        ]);
    }


    public function storeStakeholder(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:Internal,Eksternal',
            'nomor_telepon' => 'required|digits_between:10,15',
            'email' => 'required|email',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = request()->user();
        if ($user->role != 'admin') {
            return abort(403);
        }

        try {
            // Upload foto jika ada
            $urlFoto = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('picture_of_stakeholder', 'public');
                $urlFoto = asset(Storage::url($fotoPath)); // Ubah path ke URL publik
            }

            // Simpan data stakeholder ke database
            $stakeholder = Stakeholder::create([
                'nama' => $request->nama,
                'kategori' => $request->kategori,
                'nomor_telepon' => $request->nomor_telepon,
                'email' => $request->email,
                'foto' => $urlFoto, // Simpan sebagai URL
            ]);

            return response()->json([
                'message' => 'Stakeholder berhasil ditambahkan!',
                'data' => $stakeholder,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan stakeholder',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function updateStakeholder(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:Internal,Eksternal',
            'nomor_telepon' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = request()->user();
        if ($user->role != 'admin') {
            return abort(403);
        }

        // Cari stakeholder berdasarkan ID
        $stakeholder = Stakeholder::find($id);
        if (!$stakeholder) {
            return response()->json(['message' => 'Stakeholder tidak ditemukan'], 404);
        }

        try {
            // Jika ada file foto yang diunggah, simpan dan perbarui
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($stakeholder->foto) {
                    // Ambil hanya path relatif dari URL
                    $oldPath = str_replace(asset('storage') . '/', '', $stakeholder->foto);
                    Storage::disk('public')->delete($oldPath);
                }

                // Simpan foto baru dan ubah ke URL publik
                $fotoPath = $request->file('foto')->store('picture_of_stakeholder', 'public');
                $stakeholder->foto = asset(Storage::url($fotoPath));
            }

            // Perbarui data stakeholder lainnya
            $stakeholder->nama = $request->nama;
            $stakeholder->kategori = $request->kategori;
            $stakeholder->nomor_telepon = $request->nomor_telepon;
            $stakeholder->email = $request->email;
            $stakeholder->save();

            return response()->json([
                'message' => 'Stakeholder berhasil diperbarui!',
                'data' => $stakeholder,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui stakeholder',
                'error' => $e->getMessage(),
            ], 500);
        }
    }




    public function deleteStakeholder($id)
    {
        $user = request()->user();
        if ($user->role != 'admin') {
            return abort(403);
        }
        // Cari stakeholder berdasarkan ID
        $stakeholder = Stakeholder::find($id);
        if (!$stakeholder) {
            return response()->json(['message' => 'Stakeholder tidak ditemukan!'], 404);
        }

        try {
            // Hapus foto jika ada
            if ($stakeholder->foto) {
                $oldPath = str_replace(asset('storage') . '/', '', $stakeholder->foto);
                Storage::disk('public')->delete($oldPath);
            }

            if ($stakeholder->projects->count() > 0) {
                throw new \Exception('This stakeholder is still assigned to projects.');
            }
            // Hapus stakeholder dari database
            $stakeholder->delete();



            return response()->json(['message' => 'Stakeholder berhasil dihapus!'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus stakeholder',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
