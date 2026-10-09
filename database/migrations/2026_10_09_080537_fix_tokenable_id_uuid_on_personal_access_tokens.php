<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Token lama untuk Donatur tidak valid (ID UUID tidak muat di kolom angka)
        DB::table('personal_access_tokens')
            ->where('tokenable_type', 'App\\Models\\Donatur')
            ->delete();

        DB::statement('ALTER TABLE personal_access_tokens MODIFY tokenable_id CHAR(36) NOT NULL');
    }

    public function down(): void
    {
        DB::table('personal_access_tokens')->delete();
        DB::statement('ALTER TABLE personal_access_tokens MODIFY tokenable_id BIGINT UNSIGNED NOT NULL');
    }
};