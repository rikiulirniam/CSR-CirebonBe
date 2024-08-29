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
        Schema::create('proyeks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tanggal_awal');                                                          
            $table->date('tanggal_akhir');
            $table->text('deskripsi')->nullable();
            $table->string('image');
            $table->boolean("status")->default(true);
            $table->foreignId('kecamatan_id');
            $table->foreignId('sektor_id');
            $table->foreignId('program_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyeks');
    }
};
