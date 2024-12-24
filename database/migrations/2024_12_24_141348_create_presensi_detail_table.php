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
        Schema::create('presensi_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presensi_id')->constrained('presensi');
            $table->foreignId('mhs_id');
            $table->enum('status', ['present', 'absen','permission']);
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
        Schema::dropIfExists('presensi_detail');
    }
};
