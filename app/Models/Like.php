<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $guarded =[];
    use HasFactory;
    public function project(){
        return $this->belongsTo(Project::class)->first();
    }
}
