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
        Schema::create('sumbangan', function (Blueprint $table) {
            $table->uuid('id_sumbangan')->primary()->default(DB::raw('UUID()'));
            $table->uuid('id_donatur');
            $table->uuid('id_kontainer');
            $table->date('tanggal');
            $table->double('berat');
            $table->string('photo', 50);
            $table->string('status',50);
            $table->integer('poin_reward');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sumbangan');
    }
};
