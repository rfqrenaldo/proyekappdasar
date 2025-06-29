<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Member;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Stakeholder;
use App\Models\Team;
use App\Models\Team_member;
use App\Models\Year;
use Database\Seeders\TeamMembersSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Log;
use Storage;

class ProjectController extends Controller
{
    public function searchProjects($keyword)
    {
        // Query pencarian yang mempertimbangkan beberapa kolom dan relasi
        $projects = Project::with(['image'])->where('nama_proyek', 'like', '%' . $keyword . '%')->get();

        if ($projects->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Proyek tidak ditemukan'
            ]);
        }

        // Mengembalikan respons JSON
        return response()->json([
            'status' => 'success',
            'data' => $projects
        ]);
    }

    public function DetailProject(int $id)
    {
        try {
            // Eager loading semua relasi berdasarkan definisi di model Anda
            $project = Project::with([
                'image',           // Project->image() adalah hasMany ke Image
                'likes',           // Project->likes() adalah hasMany ke Like
                'comments.user',   // Project->comments() adalah hasMany ke Comment, lalu Comment->user()
                'categories',      // Project->categories() adalah belongsToMany ke Category
                'year',            // Project->year() adalah hasMany ke Year
                'stakeholder',     // Project->stakeholder() adalah belongsTo ke Stakeholder
                'team',            // Project->team() adalah belongsTo ke Team
                'team.team_member',    // <--- INI PERBAIKAN: dari 'team.members' menjadi 'team.team_member'
                'team.team_member.member' // Relasi Team_member->member (asumsi Member model untuk tabel anggotas)
            ])->findOrFail($id);

            // Perhatian:
            // - $project->image akan menjadi Collection of Image models (karena hasMany)
            // - $project->year akan menjadi Collection of Year models (karena hasMany)
            // - $project->categories akan menjadi Collection of Category models (karena belongsToMany)
            // - $project->team->team_member akan menjadi Collection of Team_member models (karena hasMany)

            return response()->json([
                'status' => 'success',
                'data' => $project,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Tangani jika proyek tidak ditemukan
            return response()->json([
                'status' => 'error',
                'message' => 'Proyek tidak ditemukan.',
            ], 404);
        } catch (\Exception $e) {
            // Tangani error umum lainnya
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail proyek: ' . $e->getMessage(),
                'error_code' => $e->getCode(),
            ], 500);
        }
    }
    public function DetailStakeholder($id)
    {
        //jika stakeholder dipencet dapat melihat detail stakeholdernya
        // Ambil detail stakeholder berdasarkan ID tanpa eager loading di model
        $stakeholder = Stakeholder::with('projects', 'projects.image')->findOrFail($id);

        // Ambil proyek terkait dengan stakeholder
        $projects = $stakeholder->projects()->get();

        return response()->json([
            'status' => 'success',
            'data' => $stakeholder,
        ]);
    }

    public function DetailTeam($id)
    {
        // jika team dipencet maka akan muncul nama nama membernya//
        // Ambil detail tim berdasarkan ID tanpa eager loading di model
        $team = Team::with(['team_member', 'team_member.member', 'project', 'project.image'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $team,
        ]);
    }

    public function DetailMember($id)
    {
        // jika member dipencet maka akan muncul detail membernya
        $member = Member::with('projects', 'projects.image')->findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $member,
        ]);
    }

    public function storeProject(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_proyek' => 'required|string|max:255',
            'stakeholder_id' => 'required|exists:stakeholders,id',
            'team_id' => 'required|exists:teams,id',
            'year' => 'required|integer',
            'deskripsi' => 'required|string',
            'category_project' => 'required|exists:categories,id',
            'link_proyek' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ], ['images.*' => 'Each image must not be larger than 4 MB.']);

        if ($validator->fails()) {
            return response()->json([
                'message' => "Check your input",
                'error' => $validator->messages(),
            ], 400);
        }

        $user = request()->user();
        if ($user->role != 'admin') {
            return abort(403);
        }

        try {
            // Simpan proyek baru
            $project = Project::create([
                'nama_proyek' => $request->nama_proyek,
                'deskripsi' => $request->deskripsi,
                'stakeholder_id' => $request->stakeholder_id,
                'team_id' => $request->team_id,
                'link_proyek' => $request->link_proyek,
            ]);

            // Simpan relasi ke kategori
            ProjectCategory::create([
                'project_id' => $project->id,
                'category_id' => $request->category_project,
            ]);

            // Simpan tahun proyek
            Year::create([
                'project_id' => $project->id,
                'tahun' => $request->year,
            ]);

            // Simpan gambar jika ada
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('picture_of_project', 'public');
                    $url = asset(Storage::url($path)); // Ubah path ke URL lengkap
                    Image::create([
                        'project_id' => $project->id,
                        'link_gambar' => $url,
                    ]);
                }
            }

            return response()->json([
                'message' => 'Project berhasil ditambahkan',
                'project' => $project->load(['image', 'categories']),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan project',
                'error' => $e->getMessage(),
            ], 500);
        }
    }





    public function updateProject(Request $request, $id)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'stakeholder_id' => 'required|exists:stakeholders,id',
            'team_id' => 'required|exists:teams,id',
            'year' => 'required|integer',
            'deskripsi' => 'required|string',
            'category_project' => 'required|exists:categories,id',
            'link_proyek' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = request()->user();
        if ($user->role != 'admin') {
            return abort(403);
        }

        $project = Project::findOrFail($id);

        $project->update([
            'nama_proyek' => $request->nama_proyek,
            'deskripsi' => $request->deskripsi,
            'stakeholder_id' => $request->stakeholder_id,
            'team_id' => $request->team_id,
            'link_proyek' => $request->link_proyek,
        ]);

        if ($request->hasFile('images')) {
            // Hapus gambar lama dari storage dan database
            foreach ($project->image as $img) {
                if (Storage::disk('public')->exists(str_replace('storage/', '', parse_url($img->link_gambar, PHP_URL_PATH)))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', parse_url($img->link_gambar, PHP_URL_PATH)));
                }
                $img->delete();
            }

            // Simpan gambar baru dan generate URL publik
            foreach ($request->file('images') as $image) {
                $path = $image->store('picture_of_project', 'public');
                $url = asset(Storage::url($path)); // URL publik
                Image::create([
                    'project_id' => $project->id,
                    'link_gambar' => $url,
                ]);
            }
        }

        // Perbarui kategori
        ProjectCategory::updateOrCreate(
            ['project_id' => $project->id],
            ['category_id' => $request->category_project]
        );

        // Perbarui tahun
        Year::updateOrCreate(
            ['project_id' => $project->id],
            ['tahun' => $request->year]
        );

        return response()->json([
            'message' => 'Project berhasil diperbarui',
            'project' => $project->load('image', 'categories')
        ], 200);
    }


    public function deleteProject($project_id)
    {
        $user = request()->user();
        if ($user->role != 'admin') {
            return abort(403);
        }

        $project = Project::findOrFail($project_id);

        // Hapus semua gambar terkait
        foreach ($project->image as $img) {
            $path = str_replace('storage/', '', parse_url($img->link_gambar, PHP_URL_PATH));
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $img->delete();
        }

        // Hapus relasi kategori & tahun (opsional, tergantung cascade)
        ProjectCategory::where('project_id', $project_id)->delete();
        Year::where('project_id', $project_id)->delete();

        // Hapus proyek
        $project->delete();

        return response()->json([
            'message' => 'Project berhasil dihapus'
        ], 200);
    }




    public function storeTeam(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_tim' => 'required|string|max:255|unique:teams,nama_tim',
            'pm' => 'required|exists:anggotas,id',
            'fe' => 'required|exists:anggotas,id',
            'be' => 'required|exists:anggotas,id',
            'ui_ux' => 'required|exists:anggotas,id',
        ]);
        $user = request()->user();
        if ($user->role != 'admin') {
            return abort(403);
        }

        try {
            // Mulai transaksi database untuk mencegah kesalahan data
            DB::beginTransaction();

            // Simpan tim baru ke tabel 'teams'
            $team = Team::create([
                'nama_tim' => $request->nama_tim,
            ]);

            // Data peran anggota tim
            $roles = [
                'Project Manager' => $request->pm,
                'Front End' => $request->fe,
                'Back End' => $request->be,
                'UI/UX' => $request->ui_ux,
            ];

            // Simpan data anggota tim ke tabel 'anggota_teams'
            foreach ($roles as $role => $member_id) {
                Team_member::create([
                    'team_id' => $team->id,
                    'member_id' => $member_id,
                    'role' => $role,
                ]);
            }

            // Commit transaksi jika semua proses sukses
            DB::commit();

            return redirect()->back()->with('success', 'Tim berhasil dibuat!');
        } catch (\Exception $e) {
            // Rollback jika terjadi kesalahan
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat tim: ' . $e->getMessage());
        }
    }

    public function commentProject(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        // Temukan proyek berdasarkan ID
        $project = Project::findOrFail($id);

        // Simpan komentar ke dalam tabel `comments`
        $comment = $project->comments()->create([
            'isi_komen' => $request->comment,
            'user_id' => request()->user()->id, // Menggunakan ID pengguna yang sedang login
        ]);

        return response()->json([
            'message' => 'Komentar berhasil ditambahkan',
            'comment' => $comment
        ], 201);
    }

    public function deleteComment($comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        $user = request()->user();
        if ($user->role != 'admin' && $comment->user_id != $user->id) {
            return response()->json([
                'message' => 'Hanya admin yang dapat menghapus komentar'
            ], 403);
        }
        // Temukan komentar berdasarkan ID

        // Hapus komentar
        $comment->delete();

        return response()->json([
            'message' => 'Komentar berhasil dihapus'
        ], 200);
    }
    public function getComments($id)
    {
        // Temukan proyek berdasarkan ID
        $project = Project::findOrFail($id);

        // Ambil semua komentar untuk proyek ini
        $comments = $project->comments()->with('user')->get();

        return response()->json([
            'comments' => $comments,
        ]);
    }
    public function searchTeam($keyword)
    {
        // Query pencarian yang mempertimbangkan nama tim
        $teams = Team::with(['team_member.member'])->where('nama_tim', 'like', '%' . $keyword . '%')->get();

        if ($teams->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tim tidak ditemukan'
            ]);
        }

        // Mengembalikan respons JSON
        return response()->json([
            'status' => 'success',
            'data' => $teams
        ]);
    }

    public function likeProject($id)
    {
        // Temukan proyek berdasarkan ID
        $project = Project::findOrFail($id);

        // Cek apakah pengguna sudah menyukai proyek ini
        $like = $project->likes()->where('user_id', request()->user()->id)->first();

        if ($like) {
            // Jika sudah, hapus like
            $like->delete();
            return response()->json([
                'message' => 'Like dihapus',
                'status' => 'unliked'
            ]);
        } else {
            // Jika belum, tambahkan like
            $project->likes()->create([
                'user_id' => request()->user()->id,
            ]);
            return response()->json([
                'message' => 'Proyek disukai',
                'status' => 'liked'
            ]);
        }
    }
    public function getLikeStatus($id)
    {
        // Temukan proyek berdasarkan ID
        $project = Project::findOrFail($id);

        // Cek apakah pengguna sudah menyukai proyek ini
        $like = $project->likes()->where('user_id', request()->user()->id)->first();


        return response()->json([
            'liked' => $like ? true : false,
        ]);
    }
    public function getLikes($id)
    {
        // Temukan proyek berdasarkan ID
        $project = Project::findOrFail($id);

        // Ambil jumlah like untuk proyek ini
        $likesCount = $project->likes()->count();

        return response()->json([
            'likes_count' => $likesCount,
        ]);
    }
}
