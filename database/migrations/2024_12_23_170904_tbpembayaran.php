<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class tbpembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('tb_mahasiswa')->onDelete('cascade');
            $table->string('nim');
            $table->string('nama');
            $table->decimal('nominal', 10, 2); // Menggunakan decimal untuk nominal
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
        Schema::dropIfExists('tb_pembayaran');
    }
}
