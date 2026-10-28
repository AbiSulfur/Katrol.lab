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
        Schema::create('simulasi_katrols', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->default('Simulasi Nilai');
            $table->integer('kkm')->default(75);
            $table->integer('bobot_ph')->default(40);
            $table->integer('bobot_pts')->default(30);
            $table->integer('bobot_pas')->default(30);
            $table->string('metode')->default('none');
            $table->json('parameter')->nullable();
            $table->json('ringkasan_statistik')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simulasi_katrols');
    }
};
