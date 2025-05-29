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

            // Foreign key untuk team_id dengan onDelete('cascade')
            $table->foreignIdFor(Team::class)
                  ->constrained() // Secara default akan membuat kolom team_id dan foreign key
                  ->onDelete('cascade'); // <<<--- INI YANG PERLU DITAMBAHKAN

            // Foreign key untuk member_id (asumsi mengacu ke tabel 'anggotas')
            // Umumnya, Anda tidak ingin menghapus anggota jika timnya dihapus,
            // jadi onDelete('cascade') di sini tidak diperlukan/disarankan
            // kecuali Anda ingin menghapus anggota dari tabel 'anggotas'
            // jika assosiasinya ke tim dihapus (yang jarang diinginkan).
            // Defaultnya adalah 'restrict' atau 'set null'.
            $table->foreignIdFor(Member::class)
                  ->constrained('anggotas'); // Menggunakan nama tabel 'anggotas' secara eksplisit jika nama model tidak cocok
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_teams'); // Pastikan dropIfExists di down()
    }
};
