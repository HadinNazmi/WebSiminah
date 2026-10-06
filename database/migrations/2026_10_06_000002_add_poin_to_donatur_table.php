<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('donatur', 'poin')) {
            Schema::table('donatur', function (Blueprint $table) {
                $table->integer('poin')->default(0)->after('photo');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('donatur', 'poin')) {
            Schema::table('donatur', function (Blueprint $table) {
                $table->dropColumn('poin');
            });
        }
    }
};
