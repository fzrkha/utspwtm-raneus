<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tanggapan', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('id_tgp', 10)->primary();
            $table->string('id_plg', 10);
            $table->string('nip', 10);
            $table->text('isi_tgp');
            $table->date('tgl_tgp');
            $table->timestamps();

            // Foreign Keys
            $table->foreign('id_plg')
                  ->references('id_plg')
                  ->on('pelanggaran')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('nip')
                  ->references('nip')
                  ->on('pengguna')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        DB::statement('ALTER TABLE pengguna MODIFY id INT NOT NULL AUTO_INCREMENT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanggapan');
    }
};
