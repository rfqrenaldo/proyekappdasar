<?php

namespace App\Http\Controllers;

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
        $year = Year::with('project')->find($id);
        return response()->json([
            'message' => 'Berhasil mendapatkan data tahun',
            'data' => $year
        ], 200);
    }
}
