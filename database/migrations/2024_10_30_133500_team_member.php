<?php

use App\Models\Member;
use App\Models\Team;
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
        Schema::create('anggota_teams', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['pm', 'fe', 'be', 'ui_ux']);
            $table->foreignIdFor(Team::class)
            ->constrained();
            $table->foreignIdFor(Member::class)->constrained('anggotas');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
