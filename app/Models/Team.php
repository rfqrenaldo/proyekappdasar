<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';
    protected $guarded =[];
    use HasFactory;

    public function project(){
        return $this->hasMany(Project::class, 'team_id');
    }

    public function team_member(){
        return $this->hasMany(Team_member::class, 'team_id');
    }

}
