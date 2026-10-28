<?php

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
        Schema::create('profil_gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->nullable();
            $table->string('nip', 50)->nullable();
            $table->string('sekolah', 150)->nullable();
            $table->string('mapel', 100)->nullable();
            $table->string('kelas', 50)->nullable();
            $table->string('tahun_ajaran', 20)->nullable();
            $table->string('semester', 20)->nullable();
            $table->integer('default_kkm')->default(75);
            $table->integer('default_bobot_ph')->default(40);
            $table->integer('default_bobot_pts')->default(30);
            $table->integer('default_bobot_pas')->default(30);
            $table->string('default_metode', 50)->default('none');
            $table->boolean('default_jangan_turunkan')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_gurus');
    }
};
