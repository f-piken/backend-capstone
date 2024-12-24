<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD:database/migrations/2024_12_09_092445_create_pembayaran_table.php
            $table->foreignId('mhs_id')->constrained('mahasiswa');
=======
            $table->foreignId('nim')->constrained('tb_mahasiswa');
>>>>>>> 875d971 (email-pembayaran):database/migrations/2024_12_09_092445_create_tb_pembayaran.php
            $table->string('nama');
            $table->integer('nominal');
            $table->string('metode_pembayaran');
            $table->enum('status_pembayaran', ['LUNAS', 'BELUM_LUNAS']);
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
        Schema::dropIfExists('pembayaran');
    }
};
