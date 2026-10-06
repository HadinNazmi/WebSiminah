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
        Schema::create('lokasi', function (Blueprint $table) {
            $table->uuid('id_lokasi')->primary()->default(DB::raw('UUID()'));
            $table->uuid('id_kecamatan');
            $table->boolean('is_kecamatan')->default(0);
            $table->string('nama_kelurahan', 50);
            $table->string('latitude', 50);
            $table->string('longitude', 50);
            $table->string('gambar');
            $table->string('deskripsi', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi');
    }
};
