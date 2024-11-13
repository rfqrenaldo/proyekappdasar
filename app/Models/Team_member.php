<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team_member extends Model
{
    use HasFactory;
        protected $table = "anggota_teams"; //anggota_teams adalah nama tabel di migration
        protected $guarded = [];

        public function team(){
            return $this->belongsTo(Team::class);
        }
        public function member(){
            return $this->belongsTo(Member::class);
        }

        public function project(){
            return $this->belongsTo(Project::class);
        }

}
