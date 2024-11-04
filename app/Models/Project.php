<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function stakeholder(){
        return $this->belongsTo(Stakeholder::class)->first();
    }

    public function team(){
        return $this->belongsTo(Team::class)->first();
    }

    public function image(){
        return $this->hasMany(Image::class)->get();
    }
    public function comment(){
        return $this->hasMany(Comment::class)->get();
    }
    public function like(){
        return $this->hasMany(Like::class)->get();
    }
    public function year(){
        return $this->hasMany(Year::class)->get();
    }
    public function categories(){
        return $this->belongsToMany(Category::class)->get();
    }


}
