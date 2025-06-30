<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Stakeholder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Throwable;

class StakeholderController extends Controller
{
    // Menampilkan semua stakeholder di navbar
    public function view_NavStakeholder() // Bisa diganti index
    {
        // Ambil semua stakeholder dengan relasi projects
        $stakeholders = Stakeholder::with(['projects'])->get();
        return ResponseHelper::send('Berhasil mendapatkan semua data stakeholder', $stakeholders);
    }

    public function searchStakeholder($keyword)
    {
        $stakeholder = Stakeholder::with(['projects'])
            ->where('nama', 'like', '%' . $keyword . '%')
            ->get();

        if ($stakeholder->isEmpty()) {
            return ResponseHelper::send('Stakeholder tidak ditemukan', null, 404);
        }
        return ResponseHelper::send('Stakeholder berhasil ditemukan', $stakeholder, 200);
    }


    public function storeStakeholder(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:Internal,Eksternal',
            'nomor_telepon' => 'required|digits_between:10,15',
            'email' => 'required|email',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ], ['foto' => 'Each image must not be larger than 4 MB.']);

        if ($validator->fails()) {
            return ResponseHelper::send('Check your input', $validator->messages(), 400);
        }

        $user = request()->user();
        if ($user->role != 'admin') {
            return ResponseHelper::send('Unauthorized', null, 403);
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
            return ResponseHelper::send('Stakeholder berhasil ditambahkan', $stakeholder, 201);
        } catch (\Exception $e) {
            return ResponseHelper::send('Stakeholder gagal ditambahkan', $e->getMessage(), 400);
        }
    }



    public function updateStakeholder(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:Internal,Eksternal',
            'nomor_telepon' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ], ['foto' => 'Each image must not be larger than 4 MB.']);

        if ($validator->fails()) {
            return ResponseHelper::send('Check your input', $validator->messages(), 400);
        }

        $user = request()->user();
        if ($user->role != 'admin') {
            return ResponseHelper::send('Unauthorized', null, 403);
        }

        // Cari stakeholder berdasarkan ID
        $stakeholder = Stakeholder::find($id);
        if (!$stakeholder) {
            return ResponseHelper::send('Stakeholder tidak ditemukan', null, 404);
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

            return ResponseHelper::send('Stakeholder berhasil diperbarui', $stakeholder, 200);
        } catch (\Exception $e) {
            return ResponseHelper::send('Stakeholder gagal diperbarui', $e->getMessage(), 400);
        }
    }




    public function deleteStakeholder($id)
    {
        $user = request()->user();
        if ($user->role != 'admin') {
            return ResponseHelper::send('Unauthorized', null, 403);
        }
        // Cari stakeholder berdasarkan ID
        $stakeholder = Stakeholder::find($id);
        if (!$stakeholder) {
            return ResponseHelper::send('Stakeholder tidak ditemukan', null, 404);
        }

        try {
            // Hapus foto jika ada
            if ($stakeholder->foto) {
                $oldPath = str_replace(asset('storage') . '/', '', $stakeholder->foto);
                Storage::disk('public')->delete($oldPath);
            }

            if ($stakeholder->projects->count() > 0) {
                throw new \Exception('Stakeholder masih memiliki project');
            }
            // Hapus stakeholder dari database
            $stakeholder->delete();
            return ResponseHelper::send('Stakeholder berhasil dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::send('Stakeholder gagal dihapus', $e->getMessage(), 400);
        }
    }
}
