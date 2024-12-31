<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class jadwal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('mahasiswa_id')->references('id')->on('mahasiswa')->onDelete('cascade');
            $table->string('hari', 50); // Hari
            $table->time('waktu_mulai'); // Waktu mulai
            $table->time('waktu_selesai'); // Waktu selesai
            $table->string('mata_kuliah', 100); // Mata kuliah
            $table->string('ruang', 50); // Ruang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal');
    }
}
