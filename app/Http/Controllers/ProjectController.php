<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Project;
use App\Models\Stakeholder;
use App\Models\Team;
use Illuminate\Http\Request;


class ProjectController extends Controller
{


    public function searchProjects(Request $request)
    {
        // Validasi input keyword agar berupa string dan opsional
        $validatedData = $request->validate([
            'keyword' => 'string|nullable|max:255'
        ]);

        $keyword = $validatedData['keyword'];

        // Query pencarian yang mempertimbangkan beberapa kolom dan relasi
        $projects = Project::where('name', 'like', '%' . $keyword . '%')
            ->orWhereHas('stakeholder', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%'); // Mencari di nama stakeholder
            })
            ->orWhereHas('team', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%'); // Mencari di nama tim
            })
            ->orWhereHas('year', function ($query) use ($keyword) {
                $query->where('year', 'like', '%' . $keyword . '%'); // Mencari di tahun
            })
            ->orWhereHas('categories', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%'); // Mencari di kategori
            })
            ->get();

        // Mengembalikan respons JSON
        return response()->json([
            'status' => 'success',
            'data' => $projects
        ]);
    }

    public function view_project(){
        //controller ini dapat menampilkan projectnya(gambar), kemudian didalamnya ada: jumlah like, isi comment,deskripsi,nama proyek, Category, Tahun, nama stakeholder, nama tim, dan nama member timnya
        // stakeholder bisa dipencet terdirect ke Detailstakeholder dan didalam nya
        // team bisa dipencet terdirect ke Detailteam dan didalam nya ada nama nama membernya
        // nama membernya bisa dipencet lalu mengarahkan ke DetailMember
    }



    public function DetailStakeholder(){
        //jika stakeholder dipencet dapat melihat detail stakeholdernya
        // di stakeholder dapat melihat list project yang dimiliki stakeholder tersebut dan bila dipencet langsung terdirect ke projectnya
    }

    public function DetailTeam(){
        // jika team dipencet maka akan muncul nama nama membernya
    }

    public function DetailMember(){
        // jika member dipencet dapat melihat detail membernya memiliki proyek apa saja
    }


    public function view_project2($id)
    {
        // Ambil proyek berdasarkan ID tanpa eager loading di model
        $project = Project::findOrFail($id);

        // Ambil relasi secara manual tanpa menggunakan eager loading
        $data = [
            'project' => $project,
            'images' => $project->image(),
            'like_count' => $project->like()->count(),
            'comments' => $project->comment(),
            'description' => $project->description,
            'name' => $project->name,
            'categories' => $project->categories(),
            'year' => $project->year(),
            'stakeholder' => [
                'id' => optional($project->stakeholder())->id,
                'name' => optional($project->stakeholder())->name,
            ],
            'team' => [
                'id' => optional($project->team())->id,
                'name' => optional($project->team())->name,
                'members' => $project->team() ? $project->team()->members : [],
            ],
        ];

        // Kembalikan sebagai JSON
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function DetailStakeholder2($id)
    {
        // Ambil detail stakeholder berdasarkan ID tanpa eager loading di model
        $stakeholder = Stakeholder::findOrFail($id);

        // Ambil proyek terkait dengan stakeholder
        $projects = $stakeholder->projects()->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'stakeholder' => $stakeholder,
                'projects' => $projects->map(function ($project) {
                    return [
                        'id' => $project->id,
                        'name' => $project->name,
                    ];
                }),
            ],
        ]);
    }

    public function DetailTeam2($id)
    {
        // Ambil detail tim berdasarkan ID tanpa eager loading di model
        $team = Team::findOrFail($id);

        // Ambil anggota terkait dengan tim
        $members = $team->members()->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'team' => $team,
                'members' => $members,
            ],
        ]);
    }

    public function DetailMember2($id)
    {
        // Ambil detail anggota berdasarkan ID tanpa eager loading di model
        $member = Member::findOrFail($id);

        // Ambil proyek terkait dengan anggota
        $projects = $member->projects()->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'member' => $member,
                'projects' => $projects->map(function ($project) {
                    return [
                        'id' => $project->id,
                        'name' => $project->name,
                    ];
                }),
            ],
        ]);
    }

    //HAPUSSSSS ANGKA 2



}






