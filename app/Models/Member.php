<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;
    protected $table = "anggotas";
    protected $guarded = [];
    use HasFactory;

    public function team_member()
    {
        return $this->hasMany(Team_member::class);
    }

    public function projects()
    {
        return $this->hasManyThrough(
            Project::class,
            Team_member::class,
            'member_id',   // Foreign key on team_member table
            'team_id',     // Foreign key on projects table
            'id',          // Local key on members table
            'team_id'      // Local key on team_member table
        );
    }
}
