<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class pembayaran extends Migration
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
            $table->foreignId('mhs_id')->constrained('mahasiswa')->onDelete('cascade');
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
        Schema::dropIfExists('pembayaran');
    }
};
