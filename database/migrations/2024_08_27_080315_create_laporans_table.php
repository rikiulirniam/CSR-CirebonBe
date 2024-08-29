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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->integer('dana_realisasi');
            $table->date('tgl_realisasi');
            $table->enum('status', ['ditolak', 'diterima', 'revisi', 'draf'])->default('draf');
            $table->text("tanggapan")->nullable();
            $table->json('images')->nullable();
            $table->foreignId('kecamatan_id');
            $table->foreignId('proyek_id');
            $table->foreignId('mitra_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
