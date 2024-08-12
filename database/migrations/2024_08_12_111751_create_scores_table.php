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
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->integer('id_status');
            $table->integer('profil_tes_id');
            $table->integer('id_siswa');
            $table->integer('soal_bank_paket_id')->nullable();
            $table->string('nama')->nullable();
            $table->string('nisn')->nullable();
            $table->char('jk', 1)->nullable();
            $table->decimal('skor', 10, 0)->nullable();
            $table->integer('soal_benar')->nullable();
            $table->string('nama_pelajaran')->nullable();
            $table->integer('pelajaran_id')->nullable();
            $table->integer('materi_uji_id')->nullable();
            $table->integer('sesi')->nullable();
            $table->integer('id_pelaksanaan')->nullable();
            $table->string('nama_sekolah')->nullable();
            $table->integer('total_soal')->nullable();
            $table->integer('urutan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
