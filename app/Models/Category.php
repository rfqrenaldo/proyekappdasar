<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\returnSelf;

class Category extends Model
{
    protected $guarded=[];
    use HasFactory;
    public function projectCategory(){
        return $this->hasMany(ProjectCategory::class)->get();
    }
}
