<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DummySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $idKecamatan = (string) Str::uuid();
        $idLokasi    = (string) Str::uuid();
        $idKontainer = (string) Str::uuid();

        DB::table('kecamatan')->insert([
            'id_kecamatan'   => $idKecamatan,
            'nama_kecamatan' => 'Kecamatan Contoh',
            'created_at'     => $now,
            'updated_at'     => $now,
        ]);

        DB::table('lokasi')->insert([
            'id_lokasi'      => $idLokasi,
            'id_kecamatan'   => $idKecamatan,
            'is_kecamatan'   => 0,
            'nama_kelurahan' => 'Kelurahan Contoh',
            'latitude'       => '1.6667',
            'longitude'      => '101.4500',
            'gambar'         => 'dummy.jpg',
            'deskripsi'      => 'Lokasi dummy untuk uji coba',
            'created_at'     => $now,
            'updated_at'     => $now,
        ]);

        DB::table('kontainer')->insert([
            'id_kontainer' => $idKontainer,
            'id_lokasi'    => $idLokasi,
            'kapasitas'    => 100,
            'keterangan'   => 'Kontainer dummy',
            'created_at'   => $now,
            'updated_at'   => $now,
        ]);

        // Hubungkan kedua akun admin kelurahan ke lokasi dummy
        $users = DB::table('users')->where('role', 'admin_kelurahan')->get();
        foreach ($users as $user) {
            DB::table('adminkelurahan')->insert([
                'id_admin_kelurahan' => (string) Str::uuid(),
                'id_user'            => $user->id,
                'id_lokasi'          => $idLokasi,
                'alamat_rumah'       => 'Alamat dummy',
                'no_hp'              => '08123456789',
                'created_at'         => $now,
                'updated_at'         => $now,
            ]);
        }

        DB::table('donatur')->insert([
            'id_donatur'     => (string) Str::uuid(),
            'no_hp'          => '08111111111',
            'nama_donatur'   => 'Donatur Contoh',
            'alamat_donatur' => 'Alamat donatur dummy',
            'kelurahan'      => 'Kelurahan Contoh',
            'photo'          => 'dummy.jpg',
            'password'       => bcrypt('donatur123'),
            'created_at'     => $now,
            'updated_at'     => $now,
        ]);
    }
}
