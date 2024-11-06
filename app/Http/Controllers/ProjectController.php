<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;


class ProjectController extends Controller
{
    public function filterProjects(Request $request)
    {
        $category = $request->input('category');
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



}
