<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $table = "anggotas";
    protected $guarded=[];
    use HasFactory;
    public function team_member(){
        return $this->hasMany(Team_member::class)->get();
    }

    public function projects()
    {
        return $this->hasManyThrough(Project::class, Team_member::class); // Menghubungkan Member ke Project lewat Team_member
    }
}
