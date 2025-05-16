<?php

namespace App\Http\Controllers;

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

    public function view_project($id)
    {
        //controller ini dapat menampilkan projectnya(gambar), kemudian didalamnya ada: jumlah like, isi comment,deskripsi,nama proyek, Category, Tahun, nama stakeholder, nama tim, dan nama member timnya
        // stakeholder bisa dipencet terdirect ke Detailstakeholder dan didalam nya
        // team bisa dipencet terdirect ke Detailteam dan didalam nya ada nama nama membernya
        // nama membernya bisa dipencet lalu mengarahkan ke DetailMember

        // Ambil proyek berdasarkan ID tanpa eager loading di model
        $project = Project::with(['image', 'like', 'comment', 'year', 'stakeholder', 'team', 'team.team_member', 'team.team_member.member', 'categories'])->findOrFail($id);

        // Kembalikan sebagai JSON
        return response()->json([
            'status' => 'success',
            'data' => $project,
        ]);
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
        // jika member dipencet dapat melihat detail membernya memiliki proyek apa saja

        // Ambil detail anggota berdasarkan ID
        $member = Member::findOrFail($id);

        // Ambil proyek yang dimiliki oleh anggota
        $projects = $member->projects;  // Mengambil proyek melalui relasi hasManyThrough

        return response()->json([
            'status' => 'success',
            'data' => [
                'member' => [
                    'id' => $member->id,
                    'nama_lengkap' => $member->nama_lengkap,
                    'NIM' => $member->NIM,
                    'foto' => $member->foto,
                ],
                'projects' => $projects->map(function ($project) {
                    return [
                        'id' => $project->id,
                        'name' => $project->name,
                        'description' => $project->description,
                    ];
                }),
            ],
        ]);
    }

    public function storeProject(Request $request)
    {

    $request->validate([
        'nama_proyek' => 'required|string|max:255',
        'stakeholder_id' => 'required|exists:stakeholders,id',
        'team_id' => 'required|exists:teams,id',
        'year' => 'required|integer',
        'deskripsi' => 'required|string',
        'category_project' => 'required|exists:categories,id', // Validasi sesuai ENUM di tabel `categories`
        'link_proyek' => 'nullable|url',
        // Validasi array gambar dan tiap gambar di dalamnya
        'images' => 'nullable|array',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // maksimal 2MB per gambar
    ]);
    $user= auth()->user();
        if ($user->role != 'admin') {
            return abort(403);
        }

    // Simpan proyek baru ke dalam tabel `projects`
    $project = Project::create([
        'nama_proyek' => $request->nama_proyek,
        'deskripsi' => $request->deskripsi,
        'stakeholder_id' => $request->stakeholder_id,
        'team_id' => $request->team_id,
        'link_proyek' => $request->link_proyek,
    ]);

    // Cari ID kategori berdasarkan nama_kategori yang dipilih (PAD1 atau PAD2)
    $category = Category::where('id', $request->category_project)->first();

    // Simpan kategori ke dalam tabel `category_project`
    if ($category) {
        ProjectCategory::create([
            'project_id' => $project->id,
            'category_id' => $category->id,
        ]);
    }

    // Simpan tahun proyek ke dalam tabel `years` (jika tabel ini ada)
    Year::create([
        'project_id' => $project->id,
        'tahun' => $request->year,
    ]);

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('projek_foto', 'public');
            Image::create([
                'project_id' => $project->id,
                'link_gambar' => $path,
            ]);
        }
    }

    return response()->json([
        'message' => 'Project berhasil ditambahkan',
        'project' => $project->load('image', 'categories')
    ], 201);

    }

    public function updateProject(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'stakeholder_id' => 'required|exists:stakeholders,id',
            'team_id' => 'required|exists:teams,id',
            'year' => 'required|integer',
            'deskripsi' => 'required|string',
            'category_project' => 'required|exists:categories,id', // Validasi sesuai ENUM di tabel `categories`
            'link_proyek' => 'nullable|url',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // maksimal 2MB per gambar
        ]);
         $user= auth()->user();
        if ($user->role != 'admin') {
            return abort(403);
        }

        // Temukan proyek berdasarkan ID
        $project = Project::findOrFail($id);

        // Perbarui data proyek
        $project->update([
            'nama_proyek' => $request->nama_proyek,
            'deskripsi' => $request->deskripsi,
            'stakeholder_id' => $request->stakeholder_id,
            'team_id' => $request->team_id,
            'link_proyek' => $request->link_proyek,
        ]);

        if ($request->hasFile('images')) {
            $gambar= $project->image;
            // Hapus gambar lama jika ada
            foreach ($gambar as $img) {
                if (file_exists(public_path('storage/' . $img->link_gambar))) {
                    unlink(public_path('storage/' . $img->link_gambar));
                }
                $img->delete();
            }
            foreach ($request->file('images') as $image) {
                $path = $image->store('projek_foto', 'public');
                Image::create([
                    'project_id' => $project->id,
                    'link_gambar' => $path,
                ]);
            }
        }
        // Cari ID kategori berdasarkan nama_kategori yang dipilih (PAD1 atau PAD2)
        $category = Category::where('id', $request->category_project)->first();

        // Simpan kategori ke dalam tabel `category_project`
        if ($category) {
            ProjectCategory::updateOrCreate(
                ['project_id' => $project->id],
                ['category_id' => $category->id]
            );
        }

        // Perbarui tahun proyek ke dalam tabel `years` (jika tabel ini ada)
        Year::updateOrCreate(
            ['project_id' => $project->id],
            ['tahun' => $request->year]
        );

        return response()->json([
            'message' => 'Project berhasil diperbarui',
            'project' => $project
        ], 200);
    }

    public function deleteProject($project_id)
    {
        // Temukan proyek berdasarkan ID
        $project = Project::findOrFail($project_id);
        $user= auth()->user();
        if ($user->role != 'admin') {
            return abort(403);
        }

        // Hapus gambar terkait proyek
        foreach ($project->image as $img) {
            if (file_exists(public_path('storage/' . $img->link_gambar))) {
                unlink(public_path('storage/' . $img->link_gambar));
            }
            $img->delete();
        }

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
        $user= auth()->user();
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
        $comment= $project->comments()->create([
            'isi_komen' => $request->comment,
            'user_id' => auth()->id(), // Menggunakan ID pengguna yang sedang login
        ]);

        return response()->json([
            'message' => 'Komentar berhasil ditambahkan',
            'comment' => $comment
        ], 201);
    }
    public function deleteComment($comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        $user= auth()->user();
        if ($user->role != 'admin'&&$comment->user_id != $user->id) {
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

    public function likeProject($id)
    {
        // Temukan proyek berdasarkan ID
        $project = Project::findOrFail($id);

        // Cek apakah pengguna sudah menyukai proyek ini
        $like = $project->likes()->where('user_id', auth()->id())->first();

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
                'user_id' => auth()->id(),
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
        $like = $project->likes()->where('user_id', auth()->id())->first();

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
