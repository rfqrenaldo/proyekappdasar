<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stakeholder extends Model
{
    use HasFactory;
    protected $table = 'stakeholders';
    protected $guarded = [];
    public function projects()
    {
        return $this->hasMany(Project::class, 'stakeholder_id');
    }
}
