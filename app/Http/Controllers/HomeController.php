<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //nampilin semua project
    //filtering project
    public function filterProjects(Request $request)
    {
        $category = $request->input('category'); //ini ditambah 1 soalnya dapat memiliki 2 kategori pad12
        $year = $request->input('year');

        $query = Project::query();

        if ($category) {
            $query->where('category', 'like', '%' . $category . '%');
        }

        if ($year) {
            $query->where('year', $year);
        }

        $projects = $query->get();

        // Kembalikan sebagai respons JSON
        // return response()->json($projects);
        return response()->json([
            'status' => 'success',
            'data' => $projects
        ]);
    }
}
