<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lokasi', function (Blueprint $table) {
            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('kecamatan')->onDelete('cascade');
        });

        Schema::table('adminkelurahan', function (Blueprint $table) {
            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasi')->onDelete('cascade');
        });

        Schema::table('log', function (Blueprint $table) {
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('kontainer', function (Blueprint $table) {
            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasi')->onDelete('cascade');
        });

        Schema::table('permintaan', function (Blueprint $table) {
            $table->foreign('id_kontainer')->references('id_kontainer')->on('kontainer')->onDelete('cascade');
            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasi')->onDelete('cascade');
            $table->foreign('id_admin_kelurahan')->references('id_admin_kelurahan')->on('adminkelurahan')->onDelete('cascade');
        });

        Schema::table('redeem', function (Blueprint $table) {
            $table->foreign('id_donatur')->references('id_donatur')->on('donatur')->onDelete('cascade');
            $table->foreign('id_reward')->references('id_reward')->on('reward')->onDelete('cascade');
        });

        Schema::table('sumbangan', function (Blueprint $table) {
            $table->foreign('id_donatur')->references('id_donatur')->on('donatur')->onDelete('cascade');
            $table->foreign('id_kontainer')->references('id_kontainer')->on('kontainer')->onDelete('cascade');
        });

        Schema::table('notifikasi', function (Blueprint $table) {
            $table->foreign('id_donatur')->references('id_donatur')->on('donatur')->onDelete('cascade');
            $table->foreign('id_sumbangan')->references('id_sumbangan')->on('sumbangan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->dropForeign(['id_donatur']);
            $table->dropForeign(['id_sumbangan']);
        });

        Schema::table('sumbangan', function (Blueprint $table) {
            $table->dropForeign(['id_donatur']);
            $table->dropForeign(['id_kontainer']);
        });

        Schema::table('redeem', function (Blueprint $table) {
            $table->dropForeign(['id_donatur']);
            $table->dropForeign(['id_reward']);
        });

        Schema::table('permintaan', function (Blueprint $table) {
            $table->dropForeign(['id_kontainer']);
            $table->dropForeign(['id_lokasi']);
            $table->dropForeign(['id_admin_kelurahan']);
        });

        Schema::table('kontainer', function (Blueprint $table) {
            $table->dropForeign(['id_lokasi']);
        });

        Schema::table('log', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
        });

        Schema::table('adminkelurahan', function (Blueprint $table) {
            $table->dropForeign(['id_lokasi']);
        });

        Schema::table('lokasi', function (Blueprint $table) {
            $table->dropForeign(['id_kecamatan']);
        });
    }
};
