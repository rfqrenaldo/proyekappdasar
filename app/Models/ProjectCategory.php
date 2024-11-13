<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    use HasFactory;
    protected $table= "category_project";
    protected $guarded = [];

    public function projects(){
        return $this->belongsToMany(Project::class);
    }
    public function category(){
        return$this->belongsToMany(Category::class);
    }

}
