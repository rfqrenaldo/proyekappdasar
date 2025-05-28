<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Project;
use App\Models\Team;
use App\Models\Team_member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    //nampilin semua mahasiswa
    //nampilin detail mahasiswa
    public function view_NavMember() //penamaan fungsi bisa diganti index
    {
        //jika navbar mahasiswa dipencet dapat melihat semua mahasiswa (mahasiswa adalah member dari team)dan jika mahasiswa dipencet dapat memunculkan project yang dimiliki mahasiswa tersebut
        // Get all projects without any filter
        $member = Member::with(['Team_member'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $member
        ]);
    }



     public function searchMahasiswa($keyword){

        $mhs = Member::with('team_member')->where('nama_lengkap', 'like', '%' . $keyword . '%')->get();
        if ($mhs->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nama member atau mahasiswa tidak ditemukan'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'data' => $mhs
        ]);

     }


    public function DetailMahasiswa($id)
    {

        $member = Member::with(['Project', 'Project.image'])->find($id);

        return response()->json([
            'status' => 'success',
            'data' => $member
        ]);
    }

    //untuk form add team
    public function storeTeamMember(Request $request){

        // Validasi input
        $anggotas=[];
        $request->validate([
            'nama_tim' => 'required|string|max:255',
            'member_*' => 'required|exists:anggotas,id',

        ]);
        $user= auth()->user();
        if ($user->role != 'admin') {
            return abort(403);
        }

        $team = Team::create([
            'nama_tim' => $request->nama_tim,
        ]);

        $roles = ['pm', 'fe','be','ui_ux'];
        foreach ($roles as $role){
            $anggota = Team_member::create([
                'role' => $role,
                'team_id' => $team->id,
                'member_id' => $request['member_'.$role],
            ]);
            $anggotas[] = $anggota;
        }

        // Simpan data ke tabel anggota_teams


        return response()->json([
            'message' => 'Anggota berhasil ditambahkan ke tim!',
            'data' => $anggotas
        ], 201);
    }



public function storeMahasiswa(Request $request)
{
    // Validasi input
    $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'NIM' => 'required|string|max:20',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = auth()->user();
    if ($user->role != 'admin') {
        return abort(403);
    }

    try {
        // Upload foto jika ada
        $urlFoto = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('picture_of_student', 'public');
            $urlFoto = asset(Storage::url($fotoPath)); // full URL ke file
        }

        // Simpan data anggota ke database dengan URL lengkap
        $member = Member::create([
            'nama_lengkap' => $request->nama_lengkap,
            'NIM' => $request->NIM,
            'foto' => $urlFoto, // langsung simpan URL lengkap ke kolom foto
        ]);

        return response()->json([
            'message' => 'Mahasiswa berhasil ditambahkan!',
            'data' => $member,
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat menambahkan mahasiswa',
            'error' => $e->getMessage(),
        ], 500);
    }
}




    public function updateMahasiswa(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'NIM' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();
        if ($user->role != 'admin') {
            return abort(403);
        }

        try {
            // Cari data mahasiswa berdasarkan ID
            $member = Member::findOrFail($id);

            // Upload foto baru jika ada
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($member->foto) {
                    $oldPath = str_replace(asset('storage') . '/', '', $member->foto);
                    Storage::disk('public')->delete($oldPath);
                }

                $fotoPath = $request->file('foto')->store('picture_of_student', 'public');
                $member->foto = asset(Storage::url($fotoPath));
            }

            // Update data lainnya
            $member->nama_lengkap = $request->nama_lengkap;
            $member->NIM = $request->NIM;
            $member->save();

            return response()->json([
                'message' => 'Mahasiswa berhasil diperbarui!',
                'data' => $member,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui mahasiswa',
                'error' => $e->getMessage(),
            ], 500);
        }
}



public function deleteMahasiswa($id)
{
    $user= auth()->user();
        if ($user->role != 'admin') {
            return abort(403);
        }
    // Cari mahasiswa berdasarkan ID
    $member = Member::find($id);
    if (!$member) {
        return response()->json(['message' => 'Mahasiswa tidak ditemukan!'], 404);
    }

    // Hapus foto jika ada
    if ($member->foto) {
        Storage::disk('public')->delete($member->foto);
    }

    // Hapus mahasiswa dari database
    $member->delete();

    return response()->json(['message' => 'Mahasiswa berhasil dihapus!'], 200);
}


}
