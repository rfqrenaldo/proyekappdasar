<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function stakeholder(){
        return $this->belongsTo(Stakeholder::class);
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function image(){
        return $this->hasMany(Image::class, 'project_id');
    }
    public function comments(){
        return $this->hasMany(Comment::class, 'project_id');
    }
    public function likes(){
        return $this->hasMany(Like::class, 'project_id');
    }
    public function year(){
        return $this->hasMany(Year::class, 'project_id');
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }

}
