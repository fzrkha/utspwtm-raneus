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
        Schema::create('pelanggaran', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('id_plg', 10)->primary();
            $table->string('nis', 4);
            $table->text('isi_pel');
            $table->date('tgl_pel');
            $table->string('foto', 255);
            $table->enum('status', ['menunggu', 'ditanggapi']);
            $table->timestamps();

            // Foreign Key
            $table->foreign('nis')
                  ->references('nis')
                  ->on('murid')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggaran');
    }
};
