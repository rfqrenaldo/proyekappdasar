<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = "anggotas";
    protected $guarded=[];
    use HasFactory;
    public function team_member(){
        return $this->hasMany(Anggota_team::class)->get();
    }
}
