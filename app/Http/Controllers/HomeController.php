<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Method to display all projects with optional filtering by category and year
    public function filterProjects(Request $request)
    {
        $category = $request->input('category');
        $year = $request->input('year');

        $query = Project::query();

        // Filter berdasarkan kategori jika kategori dipilih
        if ($category) {
            $query->whereHas('categories', function ($query) use ($category) {
                $query->where('nama_kategori', 'like', '%' . $category . '%');
            });
        }

        // Filter berdasarkan tahun jika tahun dipilih
        if ($year) {
            $query->whereHas('year', function ($query) use ($year) {
                $query->where('tahun', $year); // Filter berdasarkan tahun di tabel 'years'
            });
        }

        // Ambil proyek yang sudah difilter dengan relasi yang dibutuhkan
        $projects = $query->with(['categories', 'year', 'stakeholder', 'team'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $projects
        ]);
    }

    // Method to display all projects without filtering
    public function getAllProjects()
    {
        // Get all projects without any filter
        $projects = Project::with(['categories', 'year', 'stakeholder', 'team', 'image'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $projects
        ]);
    }
}
