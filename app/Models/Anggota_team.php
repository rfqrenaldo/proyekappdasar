<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota_team extends Model
{
    protected $table = "anggota_teams"; //anggota_teams adalah nama tabel di migration
    protected $guarded = [];
    use HasFactory;

    public function team(){
        return $this->belongsTo(Team::class)->first();
    }
    public function member(){
        return $this->belongsTo(Anggota::class)->first();
    }


}
