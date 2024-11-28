<?php

namespace App\Http\Controllers;

use App\Models\Stakeholder;
use Illuminate\Http\Request;

class StakeholderController extends Controller
{
    // Menampilkan semua stakeholder di navbar
    public function view_NavStakeholder() //bisa diganti index
    {
        // Ambil semua stakeholder
        $stakeholders = Stakeholder::with(['projects'])->get();

        // Kembalikan data sebagai JSON
        return response()->json([
            'status' => 'success',
            'data' => $stakeholders,
        ]);
    }

    // public function searchStakeholder(Request $request)
    // {
    //     $stakeholderName = $request->input('stakeholder_name');
    //     $projectName = $request->input('project_name');

    //     $query = Stakeholder::query();

    //     if ($stakeholderName) {
    //         $query->where('name', 'like', '%' . $stakeholderName . '%');
    //     }

    //     if ($projectName) {
    //         $query->whereHas('projects', function ($q) use ($projectName) {
    //             $q->where('name', 'like', '%' . $projectName . '%');
    //         });
    //     }

    //     $stakeholders = $query->with('projects')->get();

    //     // Kembalikan data sebagai JSON
    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $stakeholders,
    //     ]);
    // }


    public function searchStakeholder($keyword){
        $stakeholder = Stakeholder::with(['projects'])->where('nama', 'like', '%' . $keyword . '%')->get();

        if ($stakeholder->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nama Stakeholder tidak ditemukan'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'data' => $stakeholder
        ]);
    }
}
