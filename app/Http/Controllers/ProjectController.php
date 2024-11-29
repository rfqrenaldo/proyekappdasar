<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Project;
use App\Models\Stakeholder;
use App\Models\Team;
use Illuminate\Http\Request;


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

}
