<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->date('tanggal_servis');
            $table->string('jenis_perbaikan');
            $table->text('deskripsi_kerusakan');
            $table->decimal('biaya', 12, 2)->default(0);
            $table->string('teknsi_vendor')->nullable();
            $table->enum('status_servis', ['Proses', 'Selesai'])->default('Proses');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};