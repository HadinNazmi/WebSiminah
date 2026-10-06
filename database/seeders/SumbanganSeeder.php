<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SumbanganSeeder extends Seeder
{
    public function run(): void
    {
        $donatur   = DB::table('donatur')->first();
        $kontainer = DB::table('kontainer')->first();

        if (!$donatur || !$kontainer) {
            $this->command->error('Donatur/kontainer belum ada. Jalankan DummySeeder dulu.');
            return;
        }

        // updated_at dibuat setelah kontainer dibuat, supaya lolos filter dashboard
        $data = [
            ['berat' => 2.5, 'status' => 'terverifikasi', 'poin' => 25, 'menit' => 1],
            ['berat' => 4.0, 'status' => 'terverifikasi', 'poin' => 40, 'menit' => 2],
            ['berat' => 1.2, 'status' => 'terverifikasi', 'poin' => 12, 'menit' => 3],
            ['berat' => 3.3, 'status' => 'diproses',      'poin' => 0,  'menit' => 4],
        ];

        foreach ($data as $row) {
            $waktu = now()->addMinutes($row['menit']);

            DB::table('sumbangan')->insert([
                'id_sumbangan' => (string) Str::uuid(),
                'id_donatur'   => $donatur->id_donatur,
                'id_kontainer' => $kontainer->id_kontainer,
                'tanggal'      => now()->toDateString(),
                'berat'        => $row['berat'],
                'photo'        => 'dummy.jpg',
                'status'       => $row['status'],
                'poin_reward'  => $row['poin'],
                'created_at'   => $waktu,
                'updated_at'   => $waktu,
            ]);
        }
    }
}
