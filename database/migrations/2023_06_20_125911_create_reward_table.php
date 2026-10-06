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
        Schema::create('reward', function (Blueprint $table) {
            $table->uuid('id_reward')->primary()->default(DB::raw('UUID()'));
            $table->string('nama_reward', 50);
            $table->integer('stok');
            $table->string('jumlah_poin', 50);
            $table->timestamp('masa_berlaku');
            $table->string('gambar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reward');
    }
};
