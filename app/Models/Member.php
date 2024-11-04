<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded=[];
    use HasFactory;
    public function team(){
        return $this->belongsToMany(Team::class)->first();
    }
}
