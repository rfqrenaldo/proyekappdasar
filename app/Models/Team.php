<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded =[];
    use HasFactory;

    public function project(){
        return $this->hasMany(Project::class)->get();
    }

    public function team_member(){
        return $this->hasMany(Team_member::class)->get();
    }

}
