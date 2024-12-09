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
        Schema::create('buat_chat', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('pengirim');
            $table->foreignId('id_admin')->nullable()->constrained('user')->onDelete('cascade'); // Foreign Key
            $table->enum('status', ['menunggu', 'berlangsung', 'berakhir']);
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
        Schema::dropIfExists('buat_chat');
    }
};
