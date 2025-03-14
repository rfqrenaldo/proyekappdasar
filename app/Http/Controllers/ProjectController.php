<?php

namespace App\Http\Controllers;

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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'stakeholder_id' => 'required|exists:stakeholders,id',
            'team_id' => 'required|exists:teams,id',
            'year' => 'required|integer',
            'category_ids' => 'array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'stakeholder_id' => $request->stakeholder_id,
            'team_id' => $request->team_id,
        ]);

        // Menambahkan kategori ke proyek melalui tabel category_project
        if ($request->has('category_ids')) {
            foreach ($request->category_ids as $category_id) {
                ProjectCategory::create([
                    'project_id' => $project->id,
                    'category_id' => $category_id,
                ]);
            }
        }

        // Menambahkan tahun ke proyek
        Year::create([
            'project_id' => $project->id,
            'year' => $request->year,
        ]);

        return response()->json([
            'message' => 'Project berhasil ditambahkan',
            'project' => $project
        ], 201);
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
}
