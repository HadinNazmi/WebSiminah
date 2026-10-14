<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Lokasi;
use App\Models\Kontainer;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (method_exists(Lokasi::class, 'kontainer')) {
            $lokasiTanpaKontainer = Lokasi::doesntHave('kontainer')->get();
        } else {
            $lokasiTanpaKontainer = Lokasi::all()->filter(function ($lokasi) {
                return !Kontainer::where('id_lokasi', $lokasi->id_lokasi)->exists();
            });
        }

        foreach ($lokasiTanpaKontainer as $lokasi) {
            Kontainer::create([
                'id_lokasi' => $lokasi->id_lokasi,
                'kapasitas' => 30,
                'keterangan' => '-',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // dibiarkan kosong
    }
};
