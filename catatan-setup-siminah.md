# Siminah: Catatan Setup dan Handoff

Dokumen ini merangkum semua yang sudah dikerjakan agar pekerjaan bisa dilanjutkan (termasuk oleh agent seperti Claude Code). Bagian 6 berisi daftar pekerjaan yang belum selesai.

## 1. Konteks

Project Laravel lama (sekitar 2 tahun tidak aktif) yang akan di-upgrade dan diaktifkan lagi. Tidak ada akses ke database lama, jadi database dimulai dari kosong. Dijalankan lokal di Windows memakai Docker, nantinya dipindah ke VPS.

| Item | Nilai |
|---|---|
| Repo asal (milik tim lama, jangan diubah) | https://github.com/DimasNughadi/siminah.git |
| Repo baru milik pengguna | https://github.com/HadinNazmi/WebSiminah.git |
| Branch | `master` (riwayat dimulai dari nol, 1 commit awal) |
| Framework | Laravel 10.x, PHP minimal 8.1 |
| Database | MariaDB 10.11 (di container Docker) |
| Paket utama | barryvdh/laravel-dompdf, bensampo/laravel-enum, laravel/sanctum, yajra/laravel-datatables-oracle |
| Folder lokal | `D:\Semester 7\Magang\SiminahWeb\siminah` |
| Shell | PowerShell (Windows) |
| Alamat lokal | http://localhost:8000 |

## 2. Setup Docker (selesai)

File yang ditambahkan di root project:

- `Dockerfile`: `php:8.1-cli` + ekstensi `pdo_mysql mbstring zip gd bcmath exif` + Composer.
- `docker-compose.yml`: service `app` (port 8000, `php artisan serve`) dan `db` (MariaDB, port host 3307).

Service `db`:

```yaml
db:
  image: mariadb:10.11
  environment:
    MARIADB_DATABASE: siminah
    MARIADB_ROOT_PASSWORD: root
  ports:
    - "3307:3306"
  volumes:
    - dbdata:/var/lib/mysql
```

Pengaturan `.env` (jangan di-commit):

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=siminah
DB_USERNAME=root
DB_PASSWORD=root
```

Prasyarat Windows yang sudah dilalui: fitur `VirtualMachinePlatform` diaktifkan lewat PowerShell Administrator, lalu restart.

## 3. Perbaikan yang sudah dilakukan

### 3.1 Migration

| Masalah | Penyebab | Tindakan |
|---|---|---|
| `default UUID()` gagal di MySQL 8 | Project dibuat untuk MariaDB | Ganti image ke `mariadb:10.11` |
| Tabel `notifikasi` dobel | Dua migration (Juni versi bigint, Agustus versi UUID) | Hapus `2023_06_20_165733_create_notifikasi_table.php` |
| Tabel `kecamatan` dobel | Dua file identik | Hapus `2023_08_29_133247_create_kecamatan_table.php` |
| Tabel `log` dobel | Versi September memakai bigint, tidak cocok dengan `users.id` (UUID) | Hapus `2023_09_04_133341_create_log_table.php` |
| Foreign key dobel (`log_id_user_foreign`) | Blok relasi tertulis berulang di `create_relation.php`, `down()` salah | `2023_08_29_135346_create_relation.php` ditulis ulang tanpa duplikat, `down()` memakai `dropForeign` |

Hasil: `php artisan migrate:fresh` berhasil semua. Akun bawaan dibuat oleh migration `2023_07_09_064139_adddummyuser`.

### 3.2 Bug UUID pada model (penyebab login `admincsr` masuk sebagai `adminkelurahan`)

Semua tabel memakai ID UUID, tetapi model tidak mendeklarasikan `keyType` string. Laravel membaca ID sebagai angka dan memotongnya (ketiga user terbaca sebagai `79`), sehingga setiap login dikenali sebagai user yang sama.

Perbaikan: tambahkan ke model

```php
public $incrementing = false;
protected $keyType = 'string';
```

- `User.php`: sudah diperbaiki dan **terverifikasi** (ID terbaca UUID penuh, login `admincsr` benar).
- `Sumbangan.php`: ditambah `$primaryKey = 'id_sumbangan'` beserta dua baris di atas (sebelumnya tidak punya `$primaryKey`).
- 11 model lain (`Adminkelurahan, Donatur, Kecamatan, Kontainer, Log, Lokasi, Notifikasi, PengelolaCsr, Permintaan, Redeem, Reward`): perbaikan diberikan lewat skrip PowerShell. Pengguna melaporkan semua halaman CSR berjalan setelahnya, tetapi **hitungan akhir 13 file ber-`keyType` belum dikonfirmasi**. Cek ulang dengan:
  `Select-String -Path app/Models/*.php -Pattern "keyType" | Select-Object Filename`

### 3.3 Data dummy

Karena database kosong, dashboard error `Illegal operator and value combination` (`$currentContainer` null). Diatasi dengan seeder:

- `database/seeders/DummySeeder.php`: kecamatan, lokasi, kontainer, adminkelurahan (terhubung ke 2 akun admin kelurahan), donatur.
- `database/seeders/SumbanganSeeder.php`: 4 sumbangan (3 terverifikasi, 1 diproses).

### 3.4 Akun bawaan

| Peran | Username | Password |
|---|---|---|
| admin_kelurahan | `adminkelurahan` | `adminkelurahan` |
| admin_kelurahan | `adminkelurahan2` | `adminkelurahan` |
| admin_csr | `admincsr` | `admincsr` |

Password ini lemah dan tertulis di repo. Wajib diganti sebelum produksi.

## 4. Git dan GitHub (selesai)

- Remote `origin` sudah diarahkan ke `HadinNazmi/WebSiminah`. Repo asli tidak tersentuh.
- Push awal sempat ditolak GitHub secret scanning (GH013) karena **token Mapbox** di `public/assets/js/maps.js` baris 59 (dan di riwayat lama, termasuk `resources/views/test-component.blade.php`).
- Solusi: token diganti placeholder `ISI_TOKEN_MAPBOX_KAMU`, riwayat dibuang dengan `git checkout --orphan`, lalu `git push -u origin master --force`. Push berhasil.
- Konsekuensi: riwayat commit tim lama tidak ikut ke repo baru (masih ada di repo asli).
- `.env` diabaikan Git. `.env.example` ikut di-commit sebagai template.
- Mulai sekarang cukup `git push` biasa, tanpa `--force`.

## 5. Pelajaran penting (jebakan yang sudah terjadi)

1. **Migration project tidak lengkap.** Pembuat asli menambah kolom langsung di database lama tanpa migration. Kolom yang sudah terdeteksi hilang: `lokasi.status` dan `donatur.poin`. Kemungkinan ada lagi.
2. **Error tersembunyi.** Hampir semua controller memakai `catch (Exception $e) { return redirect()->back()->with(...); }`. Gejalanya: klik menu lalu terlempar ke dashboard tanpa pesan. Cara melacak: tambahkan `report($e);` di `catch` supaya error masuk `storage/logs/laravel.log`, atau jalankan query yang sama lewat skrip kecil.
3. **Cookie/session lama.** Setelah `migrate:fresh` (ID user berubah), browser biasa menghasilkan 419 atau redirect berulang. Pakai Incognito baru dan tutup semua jendela Incognito setelah mengubah model auth.
4. **Escaping PowerShell.** Perintah `tinker --execute="..."` yang berisi `$` dan kutip rawan gagal. Lebih aman menulis skrip PHP sementara (`cek.php`) lalu `docker compose exec app php cek.php`, dan hapus setelah selesai.
5. **Jangan commit token.** Secret scanning menolak push yang memuat token Mapbox (`pk.` maupun `sk.`).

## 6. Pekerjaan yang belum selesai

Urut prioritas:

1. **Migration `lokasi.status`**. `LokasiController@index` memfilter `where('status', '!=', 'deleted')` padahal kolomnya tidak ada (terbukti: `Unknown column 'status'`). Gejala: menu Lokasi (akun CSR) terlempar ke dashboard. Migration yang diusulkan: `2026_10_06_000001_add_status_to_lokasi_table.php` (`string('status', 50)->default('active')->after('deskripsi')`). **Belum terkonfirmasi sudah dibuat dan dijalankan.**
2. **Migration `donatur.poin`**. `DonaturController@index` memilih `donatur.poin`, kolom tidak ada di tabel (daftar kolom terkonfirmasi: `id_donatur, no_hp, nama_donatur, alamat_donatur, kelurahan, photo, password, created_at, updated_at`). Gejala: halaman Donatur (akun adminkelurahan) terlempar ke dashboard. Migration yang diusulkan: `2026_10_06_000002_add_poin_to_donatur_table.php` (`integer('poin')->default(0)->after('photo')`). **Belum terkonfirmasi.** Setelah itu, sisa query `DonaturController@index` (terpotong di baris 60) mungkin masih memuat kolom lain yang hilang.
3. **Cari kolom hilang lainnya secara sistematis.**
   - Bandingkan `$fillable` setiap model dengan kolom tabel (skrip `cek2.php`, belum dijalankan).
   - `Sumbangan::$fillable` memuat `keterangan` padahal tabel `sumbangan` tidak punya kolom itu. `SumbanganController` menyebut `keterangan` di baris 182, 186, 203, 209 (belum dibaca).
   - Cari semua pemakaian `'deleted'` (soft delete buatan) di `app/Http/Controllers` dan cocokkan dengan kolom `status`/`keterangan` yang benar-benar ada.
   - Tambahkan `report($e)` ke semua `catch` controller untuk melacak sisa error.
4. **Uji semua halaman** untuk `admincsr` dan `adminkelurahan`: dashboard, Sumbangan, Kontainer, Donatur, Hadiah (reward), Redeem, Permintaan, Lokasi, Admin Kelurahan (khusus CSR), Profile.
5. **Data dummy tambahan**: tabel `pengelola_csr`, `reward`, `redeem`, `permintaan` masih kosong dan mungkin dibutuhkan beberapa halaman.
6. **Relasi model**: `User::adminKelurahan()` memakai `hasOne(AdminKelurahan::class)` tanpa kunci, padahal kolomnya `id_user` (seharusnya `hasOne(AdminKelurahan::class, 'id_user', 'id')`). Perbaiki bila muncul `Unknown column 'user_id'`. Perhatikan juga nama class `AdminKelurahan` vs file `Adminkelurahan.php` (case-sensitive di Linux).
7. **Token Mapbox**: ganti `ISI_TOKEN_MAPBOX_KAMU` di `public/assets/js/maps.js` baris 59 dengan public token milik sendiri (awalan `pk.`). Sebaiknya simpan di `.env` (`MAPBOX_TOKEN`) dan kirim ke tampilan lewat Blade, jangan di-commit. Token lama milik tim sebelumnya sempat terekspos di riwayat repo mereka, sebaiknya mereka diberi tahu agar mencabutnya.
8. **`.env.example`**: sesuaikan bagian database dengan Docker (`DB_HOST=db`, `DB_DATABASE=siminah`, dst.) dan tambah `MAPBOX_TOKEN=`.
9. **Upgrade versi**: Laravel 10 → 11 → 12 secara bertahap, naikkan PHP di Dockerfile (8.2 atau lebih tinggi), uji di setiap langkah, ikuti laravel.com/docs/upgrade. Commit sebelum mulai agar ada titik kembali.
10. **Persiapan produksi (VPS)**: ganti `php artisan serve` dengan Nginx + PHP-FPM, `APP_ENV=production`, `APP_DEBUG=false`, SSL (Let's Encrypt), ganti semua password bawaan (migration `adddummyuser`), pertimbangkan repo Private.

## 7. Perintah harian

```powershell
docker compose up -d                      # nyalakan
docker compose down                       # matikan (data aman)
docker compose down -v                    # matikan + hapus database
docker compose ps
docker compose logs app --tail 30
docker compose exec app php artisan migrate            # migration baru saja
docker compose exec app php artisan migrate:fresh      # reset total (hapus data)
docker compose exec app php artisan db:seed --class=DummySeeder
docker compose exec app php artisan db:seed --class=SumbanganSeeder
```

Setelah `migrate:fresh`, jalankan lagi kedua seeder dan buka Incognito baru. Urutan seeder: `DummySeeder` dulu, baru `SumbanganSeeder`.

## 8. Struktur akses (dari kode)

- Middleware `CekHakAkses` (alias `role`) mengalihkan ke `dashboard` kalau role tidak ada di daftar.
- `routes/web.php` baris 24: grup untuk `admin_csr` dan `admin_kelurahan`.
- `routes/web.php` baris 79: grup khusus `admin_csr` (kelola admin kelurahan, aksi hadiah, hapus donatur, filter sumbangan).
- Helper `isAdminCsr()` / `isAdminKelurahan()` di `app/Helpers/helpers.php`, dipakai di `resources/views/.../sidebar.blade.php` (baris 55 dan 115).
- Setelah login: `admin_csr` ke `/dashboard`, `admin_kelurahan` ke `/donatur` (lihat `LoginController@index`).
