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
        Schema::create('kontainer', function (Blueprint $table) {
            $table->uuid('id_kontainer')->primary()->default(DB::raw('UUID()'));
            $table->uuid('id_lokasi');
            $table->integer('kapasitas');
            $table->string('keterangan', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontainer');
    }
};
