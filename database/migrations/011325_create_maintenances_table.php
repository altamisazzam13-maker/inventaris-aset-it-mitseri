<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aset')->unique(); // Contoh: AST-IT-001
            $table->string('nama_aset'); // Contoh: Laptop ThinkPad X1
            $table->string('kategori'); // Laptop, PC, Monitor, Printer, Network
            $table->string('nomor_seri')->nullable();
            $table->enum('kondisi', ['Bagus', 'Rusak Ringan', 'Rusak Berat'])->default('Bagus');
            $table->enum('status', ['Tersedia', 'Digunakan', 'Perbaikan', 'Afkir'])->default('Tersedia');
            $table->string('lokasi')->nullable();
            $table->date('tanggal_pengadaan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};