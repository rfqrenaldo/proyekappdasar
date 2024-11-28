<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Project;
use App\Models\Team_member;
use Illuminate\Http\Request;

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

     // Search mahasiswa by name, team name, or project name
     public function searchMahasiswa(Request $request)
     {
         $keyword = $request->input('keyword');

         // Search members based on the keyword
         $members = Member::where('name', 'like', '%' . $keyword . '%')
             ->orWhereHas('team_member', function ($query) use ($keyword) {
                 $query->where('name', 'like', '%' . $keyword . '%');
             })
             ->orWhereHas('projects', function ($query) use ($keyword) {
                 $query->where('name', 'like', '%' . $keyword . '%');
             })
             ->with(['team_member', 'projects'])
             ->get();

         return response()->json([
             'status' => 'success',
             'data' => $members,
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
}
