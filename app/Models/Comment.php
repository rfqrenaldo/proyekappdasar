<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table ='comments';
    protected $guarded =[];
    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function User(){
        return $this->belongsToMany(User::class);
    }
}
