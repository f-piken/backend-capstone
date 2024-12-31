<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMahasiswaIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('mahasiswa_id')->nullable()->after('id'); // Menambahkan mahasiswa_id sebagai foreign key
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onDelete('set null'); // Relasi ke tabel tb_mahasiswa
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropColumn('mahasiswa_id');
        });
    }
}
