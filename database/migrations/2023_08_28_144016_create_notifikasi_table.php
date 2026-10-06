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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->uuid('id_notifikasi')->primary()->default(DB::raw('UUID()'));
            $table->uuid('id_donatur');
            $table->uuid('id_sumbangan');
            $table->string('status', 50);
            $table->string('keterangan', 50);
            $table->boolean('isRead', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
