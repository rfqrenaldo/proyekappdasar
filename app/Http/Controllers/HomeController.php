<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Method to display all projects with optional filtering by category and year
    public function filterProjects(Request $request)
    {
        $categories = $request->input('category', []);
        $years = $request->input('year', []);

        $query = Project::query();

        if (!empty($categories)) {
            $query->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('nama_kategori', $categories);
            });
        }

        if (!empty($years)) {
            $query->whereHas('year', function ($query) use ($years) {
                $query->whereIn('tahun', $years);
            });
        }

        $projects = $query->with(['categories', 'year', 'stakeholder', 'team', 'image'])->get();

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
