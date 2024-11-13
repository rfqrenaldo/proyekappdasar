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
    public function view_NavMember()
    {
        //jika navbar mahasiswa dipencet dapat melihat semua mahasiswa (mahasiswa adalah member dari team)dan jika mahasiswa dipencet dapat memunculkan project yang dimiliki mahasiswa tersebut
        // Get all projects without any filter
        $member = Member::with(['Team_member'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $member
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
