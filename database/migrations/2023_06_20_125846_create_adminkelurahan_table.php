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
        Schema::create('adminkelurahan', function (Blueprint $table) {
            $table->uuid('id_admin_kelurahan')->primary()->default(DB::raw('UUID()'));
            $table->uuid('id_user');
            $table->uuid('id_lokasi');
            $table->foreign('id_user')->references('id')->on('users'); 
            $table->string('alamat_rumah', 50);
            $table->string('no_hp', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adminkelurahan');
    }
};
