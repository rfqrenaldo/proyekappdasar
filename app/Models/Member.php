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
}
