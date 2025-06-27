<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Project;
use App\Models\Team;
use App\Models\Team_member;
use DB;
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
        $user= request()->user();
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

    public function updateTeamMember(Request $request, $id)
    {
        // 1. Validasi Input
        $anggotas = []; // Inisialisasi array untuk anggota yang diperbarui
        $request->validate([
            'nama_tim' => 'sometimes|string|max:255|unique:teams,nama_tim,' . $id,
            'member_*' => 'sometimes|exists:anggotas,id', // 'sometimes' agar opsional untuk update
        ]);

        // 2. Periksa Hak Akses (Hanya Admin)
        $user = request()->user();
        if ($user->role != 'admin') {
            return abort(403, 'Unauthorized access.');
        }

        // 3. Temukan Tim yang Akan Diupdate
        $team = Team::find($id);
        if (!$team) {
            return response()->json([
                'message' => 'Tim tidak ditemukan.'
            ], 404);
        }

        // 4. Update Nama Tim (Jika Ada di Request)
        if ($request->has('nama_tim')) {
            $team->nama_tim = $request->nama_tim;
            $team->save();
        }

        // 5. Update Anggota Tim (Jika Ada di Request)
        // Gunakan array roles yang sama persis seperti di storeTeamMember Anda
        $roles = ['pm', 'fe', 'be', 'ui_ux'];

        foreach ($roles as $role) { // Iterasi berdasarkan role singkat (pm, fe, dll.)
            $requestKey = 'member_' . $role; // Contoh: 'member_pm'

            if ($request->has($requestKey)) {
                // Cari anggota tim berdasarkan team_id dan ROLE SINGKAT
                $teamMember = Team_member::where('team_id', $team->id)
                                         ->where('role', $role) // PENTING: Gunakan $role (nama singkat) di sini
                                         ->first();

                if ($teamMember) {
                    // Jika anggota tim ditemukan, update member_id-nya
                    $teamMember->member_id = $request->input($requestKey);
                    $teamMember->save();
                    $anggotas[] = $teamMember; // Tambahkan ke array yang diperbarui
                } else {
                    // Jika peran anggota tidak ditemukan (misalnya, tim lama tidak punya PM), buat entri baru
                    // Ini mungkin terjadi jika data sebelumnya tidak konsisten atau peran baru ditambahkan
                    $newMember = Team_member::create([
                        'team_id' => $team->id,
                        'member_id' => $request->input($requestKey),
                        'role' => $role, // PENTING: Simpan role singkat
                    ]);
                    $anggotas[] = $newMember;
                }
            }
        }

        // 6. Berikan Respons Sukses
        // Muat ulang anggota tim untuk memastikan data terbaru terkirim dalam respons
        $updatedTeamMembers = Team_member::where('team_id', $team->id)->get();

        return response()->json([
            'message' => 'Tim dan anggotanya berhasil diperbarui!',
            'team' => $team,
            'members' => $updatedTeamMembers // Kirim data anggota tim yang diperbarui
        ], 200);
    }
   public function deleteTeamMember(int $id)
{
    $user = request()->user();
    if ($user->role != 'admin') {
        return abort(403, 'Unauthorized access.');
    }

    try {
        DB::beginTransaction(); // Tetap baik untuk menjaga konsistensi jika ada operasi lain
        $team = Team::find($id);
        if (!$team) {
            DB::rollBack();
            return response()->json(['message' => 'Tim tidak ditemukan.'], 404);
        }

        $team->delete(); // Ini saja sudah cukup! Database akan menghapus anggota_teams.

        DB::commit();
        return response()->json(['message' => 'Tim dan semua anggotanya berhasil dihapus!'], 200);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'message' => 'Gagal menghapus tim: ' . $e->getMessage(),
            'error_code' => $e->getCode()
        ], 500);
    }
}




public function storeMahasiswa(Request $request)
{
    // Validasi input
    $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'NIM' => 'required|string|max:20',
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

        $user = request()->user();
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
    $user= request()->user();
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
