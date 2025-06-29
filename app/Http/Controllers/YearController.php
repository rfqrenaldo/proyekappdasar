<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function getYear()
    {
        $years = Year::with('project')->get();
        return response()->json([
            'message' => 'Berhasil mendapatkan data tahun',
            'data' => $years
        ], 200);
    }
    public function getYearDetail(Request $request, String $id)
    {
        $year = Year::where('tahun', $id);
        $project = Project::whereIn('id', $year->pluck('project_id'))->get();
        $year = $year->first();
        unset($year->project_id);
        unset($year->id);
        $year->project = $project;
        return response()->json([
            'message' => 'Berhasil mendapatkan data tahun',
            'data' => $year
        ], 200);
    }
}
