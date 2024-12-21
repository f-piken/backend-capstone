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
        Schema::create('tb_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nim'); // Nim seharusnya mengacu ke tb_mahasiswa
            $table->string('nama'); // Nama sebaiknya tipe string
            $table->integer('nominal'); // Nominal sebagai jumlah pembayaran
            $table->string('metode_pembayaran'); // Metode sebagai string
            $table->enum('status_pembayaran', ['LUNAS', 'BELUM_LUNAS']);
            $table->timestamps();
        
            // Foreign key constraint
            $table->foreign('nim')->references('nim')->on('tb_mahasiswa');
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
};
