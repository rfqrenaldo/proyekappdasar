<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Member;
use App\Models\Project;
use App\Models\Team;
use App\Models\Team_member;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    //nampilin semua mahasiswa
    //nampilin detail mahasiswa
    public function view_NavMember() //penamaan fungsi bisa diganti index
    {
        //jika navbar mahasiswa dipencet dapat melihat semua mahasiswa (mahasiswa adalah member dari team)dan jika mahasiswa dipencet dapat memunculkan project yang dimiliki mahasiswa tersebut
        // Get all projects without any filter
        $member = Member::with(['Team_member'])->get();
        return ResponseHelper::send('Sukses mendapatkan data semua anggota', $member);
    }



    public function searchMahasiswa($keyword)
    {

        $mhs = Member::with('team_member')->where('nama_lengkap', 'like', '%' . $keyword . '%')->get();
        if ($mhs->isEmpty()) {
            return ResponseHelper::send('Nama member atau mahasiswa tidak ditemukan', null, 404);
        }
        return ResponseHelper::send('Nama member atau mahasiswa tidak ditemukan', $mhs, 200);
    }


    public function DetailMahasiswa($id)
    {
        $member = Member::with(['projects', 'projects.image'])->find($id);
        return ResponseHelper::send('Sukses mendapatkan detail mahasiswa', $member, 200);
    }

    //untuk form add team
    public function storeTeamMember(Request $request)
    {

        // Validasi input
        $anggotas = [];
        $validator = Validator::make($request->all(), [
            'nama_tim' => 'required|string|max:255',
            'member_*' => 'required|exists:anggotas,id',
        ]);

        if ($validator->stopOnFirstFailure()) {
            return ResponseHelper::send(Arr::flatten($validator->messages()->toArray())[0], null, 400);
        }
        $user = request()->user();
        if ($user->role != 'admin') {
            return ResponseHelper::send('Unauthorized', null, 403);
        }

        $team = Team::create([
            'nama_tim' => $request->nama_tim,
        ]);

        $roles = ['pm', 'fe', 'be', 'ui_ux'];
        foreach ($roles as $role) {
            $anggota = Team_member::create([
                'role' => $role,
                'team_id' => $team->id,
                'member_id' => $request['member_' . $role],
            ]);
            $anggotas[] = $anggota;
        }

        return ResponseHelper::send('Anggota berhasil ditambahkan ke tim!', $anggotas, 201);
    }

    public function updateTeamMember(Request $request, $id)
    {
        // 1. Validasi Input
        $anggotas = []; // Inisialisasi array untuk anggota yang diperbarui
        $validator = Validator::make($request->all(), [
            'nama_tim' => 'sometimes|string|max:255|unique:teams,nama_tim,' . $id,
            'member_*' => 'sometimes|exists:anggotas,id', // 'sometimes' agar opsional untuk update
        ]);
        if ($validator->stopOnFirstFailure()) {
            return ResponseHelper::send(Arr::flatten($validator->messages()->toArray())[0], null, 400);
        }

        // 2. Periksa Hak Akses (Hanya Admin)
        $user = request()->user();
        if ($user->role != 'admin') {
            return ResponseHelper::send('Unauthorized', null, 403);
        }

        // 3. Temukan Tim yang Akan Diupdate
        $team = Team::find($id);
        if (!$team) {
            return ResponseHelper::send('Tim tidak ditemukan', null, 404);
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

        $data = [
            'team' => $team,
            'members' => $updatedTeamMembers // Kirim data anggota tim yang diperbarui
        ];
        return ResponseHelper::send('Tim dan anggotanya berhasil diperbarui!', $data, 200);
    }
    public function deleteTeamMember(int $id)
    {
        $user = request()->user();
        if ($user->role != 'admin') {
            return ResponseHelper::send('Unauthorized', null, 403);
        }

        try {
            DB::beginTransaction(); // Tetap baik untuk menjaga konsistensi jika ada operasi lain
            $team = Team::find($id);
            if (!$team) {
                DB::rollBack();
                return ResponseHelper::send('Tim tidak ditemukan.', null, 404);
            }

            $team->delete(); // Ini saja sudah cukup! Database akan menghapus anggota_teams.

            DB::commit();
            return ResponseHelper::send('Tim dan semua anggotanya berhasil dihapus!', null, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::send('Tim dan semua anggotanya gagal dihapus!', $e->getMessage(), 500);
        }
    }




    public function storeMahasiswa(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'NIM' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ], ['images.*' => 'Each image must not be larger than 4 MB.']);



        if ($validator->stopOnFirstFailure()) {
            return ResponseHelper::send(Arr::flatten($validator->messages()->toArray())[0], null, 400);
        }

        $user = request()->user();
        if ($user->role != 'admin') {
            return ResponseHelper::send('Unauthorized', null, 403);
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
            return ResponseHelper::send('Mahasiswa berhasil ditambahkan!', $member, 201);
        } catch (\Exception $e) {
            return ResponseHelper::send('Mahasiswa gagal ditambahkan!', $e->getMessage(), 400);
        }
    }




    public function updateMahasiswa(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'NIM' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ], ['images.*' => 'Each image must not be larger than 4 MB.']);

        if ($validator->stopOnFirstFailure()) {
            return ResponseHelper::send(Arr::flatten($validator->messages()->toArray())[0], null, 400);
        }

        $user = request()->user();
        if ($user->role != 'admin') {
            return ResponseHelper::send('Unauthorized', null, 403);
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
            return ResponseHelper::send('Mahasiswa berhasil diperbarui', $member, 200);
        } catch (\Exception $e) {
            return ResponseHelper::send('Mahasiswa gagal diperbarui', $e->getMessage(), 400);
        }
    }



    public function deleteMahasiswa($id)
    {
        $user = request()->user();
        if ($user->role != 'admin') {
            return ResponseHelper::send('Unauthorized', null, 403);
        }
        try {
            $member = Member::find($id);
            if (!$member) {
                return ResponseHelper::send('Mahasiswa tidak ditemukan', null, 404);
            }

            if ($member->projects->count() > 0) {
                return ResponseHelper::send('Mahasiswa masih punya project', null, 400);
            }

            // Hapus foto jika ada
            if ($member->foto) {
                Storage::disk('public')->delete($member->foto);
            }

            // Hapus mahasiswa dari database
            $member->delete();

            return ResponseHelper::send('Mahasiswa berhasil dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::send('Mahasiswa gagal dihapus', $e->getMessage(), 400);
        }
        // Cari mahasiswa berdasarkan ID
    }
}
