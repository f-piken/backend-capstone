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
            $table->foreignId('mhs_id')->constrained('mahasiswa');
            $table->string('nama');
            $table->string('id_transaksi')->nullable();
            $table->integer('nominal');
            $table->string('metode_pembayaran');
            $table->enum('status_pembayaran', ['BELUM LUNAS','LUNAS','EXPIRED','UNKNOW']);
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
