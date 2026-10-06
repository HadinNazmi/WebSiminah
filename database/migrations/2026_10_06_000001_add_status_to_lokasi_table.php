<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('lokasi', 'status')) {
            Schema::table('lokasi', function (Blueprint $table) {
                $table->string('status', 50)->default('active')->after('deskripsi');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('lokasi', 'status')) {
            Schema::table('lokasi', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
