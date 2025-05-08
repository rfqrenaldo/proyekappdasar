<?php

use App\Models\Comment;
use App\Models\Image;
use App\Models\Like;
use App\Models\Project_category;
use App\Models\Stakeholder;
use App\Models\Team;
use App\Models\Year;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->string('nama_proyek');
        $table->foreignIdFor(Stakeholder::class)->constrained()->onDelete('cascade');
        $table->foreignIdFor(Team::class)->constrained()->onDelete('cascade');
        $table->text('deskripsi')->nullable();
        $table->text('link_proyek')->nullable();
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
