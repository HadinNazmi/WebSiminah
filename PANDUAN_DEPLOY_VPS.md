# Panduan Lengkap Deployment SIMINAH ke VPS Ubuntu 24.04

Dokumen ini adalah panduan langkah demi langkah untuk melakukan deploy aplikasi web backend **SIMINAH** ke VPS Ubuntu 24.04 LTS (1 Core vCPU, 2 GB RAM) menggunakan arsitektur Docker Production (PHP 8.2-FPM + Nginx + MySQL 8.0).

---

## 1. Arsitektur & Spesifikasi Sistem

| Komponen | Spesifikasi | Keterangan |
|---|---|---|
| **OS VPS** | Ubuntu 24.04 LTS | 1 Core CPU, 2 GB RAM |
| **Akses Web** | `http://<IP_VPS>` | Akses langsung via IP publik (Port 80) |
| **Web Server** | Nginx Alpine (`jelantah-nginx`) | Port 80 publik, proxy ke PHP-FPM |
| **Backend App** | PHP 8.2-FPM (`jelantah-app`) | Port 9000 internal, Laravel 10 |
| **Database** | MySQL 8.0 (`jelantah-db`) | Port 3306 **internal** (tidak dibuka ke publik) |
| **Inisialisasi DB**| `01-siminah-init.sql` | Otomatis di-import saat pertama kali container dibuat |
| **Data Persistence**| Docker Named Volumes | `jelantah_dbdata` & `jelantah_storage` |

---

## 2. Persiapan Awal di VPS (Wajib untuk RAM 2 GB)

Masuk ke VPS Anda via SSH dari terminal komputer lokal Anda:
```bash
ssh root@<IP_VPS_ANDA>
```

### 2.1. Konfigurasi SWAP Memory (Krusial)
Karena VPS memiliki RAM 2 GB, membuat Swap Memory sebesar 2 GB sangat penting untuk mencegah proses *killed by OOM (Out Of Memory)* saat proses build Docker atau trafik padat.

Jalankan perintah berikut:
```bash
# 1. Alokasikan file swap 2GB
sudo fallocate -l 2G /swapfile

# 2. Amankan permission
sudo chmod 600 /swapfile

# 3. Format dan aktifkan swap
sudo mkswap /swapfile
sudo swapon /swapfile

# 4. Buat permanen agar tetap aktif setelah reboot
echo '/swapfile none swap sw 0 0' | sudo tee -a /etc/fstab

# 5. Verifikasi swap aktif
free -h
```

---

### 2.2. Install Docker & Docker Compose di Ubuntu 24.04
Jalankan perintah instalasi resmi Docker berikut:

```bash
# Update repository
sudo apt-get update
sudo apt-get install -y ca-certificates curl gnupg git ufw

# Tambahkan GPG key resmi Docker
sudo install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
sudo chmod a+r /etc/apt/keyrings/docker.gpg

# Tambahkan repository Docker
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# Install Docker Engine dan Docker Compose Plugin
sudo apt-get update
sudo apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

# Verifikasi instalasi Docker
docker --version
docker compose version
```

---

### 2.3. Konfigurasi Firewall (UFW)
Buka hanya port SSH (22) dan HTTP (80). MySQL tetap tertutup dari internet demi keamanan:

```bash
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw enable
```

---

## 3. Deployment Aplikasi Web SIMINAH

### 3.1. Clone Repository ke VPS
```bash
cd /var/www || cd ~
git clone https://github.com/HadinNazmi/WebSiminah.git
cd WebSiminah
```

---

### 3.2. Siapkan File Konfigurasi `.env`
Salin template production yang sudah disiapkan:
```bash
cp .env.production.example .env
nano .env
```

Sesuaikan nilai-nilai berikut di dalam file `.env`:
```ini
APP_NAME=Siminah
APP_ENV=production
APP_KEY=                    # Dibiarkan kosong dulu, akan diisi di langkah 3.4
APP_DEBUG=false
APP_URL=http://<IP_VPS_ANDA> # Ganti dengan IP VPS Anda

DB_CONNECTION=mysql
DB_HOST=db                  # Wajib 'db' sesuai nama service docker-compose
DB_PORT=3306
DB_DATABASE=siminah
DB_USERNAME=siminah_user
DB_PASSWORD=GANTI_DENGAN_PASSWORD_DB_AMAN
DB_ROOT_PASSWORD=GANTI_DENGAN_PASSWORD_ROOT_AMAN
```
*(Tekan `CTRL + O`, `Enter` lalu `CTRL + X` untuk menyimpan di nano).*

---

### 3.3. Build dan Jalankan Container Docker
Jalankan seluruh service di background:
```bash
docker compose up -d --build
```

> **Catatan Inisialisasi Database:**
> Saat pertama kali container `jelantah-db` berjalan, MySQL 8 akan otomatis mendeteksi folder kosong dan **mengeksekusi `docker/mysql/init/01-siminah-init.sql`**. Seluruh tabel dan data lama (user, donatur, saldo, dll.) akan langsung terisi secara otomatis tanpa perlu import manual!

Tunggu sekitar 15-30 detik hingga MySQL selesai inisialisasi awal. Anda dapat memantau dengan:
```bash
docker compose ps
```
Pastikan ketiga container (`jelantah-app`, `jelantah-nginx`, `jelantah-db`) berstatus `Up` atau `Up (healthy)`.

---

### 3.4. Finalisasi Konfigurasi Laravel
Jalankan perintah ini satu per satu:

```bash
# 1. Generate APP_KEY unik untuk enkripsi
docker compose exec app php artisan key:generate --force

# 2. Cek apakah ada migrasi baru yang perlu dijalankan (jika ada)
docker compose exec app php artisan migrate --force

# 3. Buat symlink storage publik agar gambar dan bukti transaksi dapat diakses
docker compose exec app php artisan storage:link

# 4. Cache route, config, dan views untuk performa maksimal di VPS
docker compose exec app php artisan optimize
```

---

## 4. Uji Coba Aplikasi

Buka browser di laptop atau HP Anda, lalu kunjungi:
```text
http://<IP_VPS_ANDA>
```
Halaman login SIMINAH akan langsung muncul, dan Anda dapat login menggunakan akun admin yang ada pada database sebelumnya.

---

## 5. Perintah Operasional & Perawatan Rutin

| Kebutuhan | Perintah |
|---|---|
| **Cek status semua container** | `docker compose ps` |
| **Lihat logs real-time (debugging)** | `docker compose logs -f` |
| **Lihat logs service tertentu** | `docker compose logs -f app` atau `docker compose logs -f nginx` |
| **Restart semua container** | `docker compose restart` |
| **Matikan container** | `docker compose stop` |
| **Nyalakan kembali** | `docker compose start` |
| **Clear cache Laravel saat ada perubahan** | `docker compose exec app php artisan optimize:clear && docker compose exec app php artisan optimize` |

---

## 6. Prosedur Update Kode di VPS di Masa Depan

Jika ada pembaruan kode yang di-push ke GitHub:
```bash
cd WebSiminah
git pull origin master
docker compose up -d --build
docker compose exec app php artisan migrate --force
docker compose exec app php artisan optimize
```

---

## 7. Prosedur Backup Database Rutin

Untuk membuat backup data MySQL di VPS secara berkala:
```bash
docker compose exec db sh -c "mysqldump -u root -p\${MYSQL_ROOT_PASSWORD} siminah" > ~/backup_siminah_$(date +%Y%m%d).sql
```
File backup akan tersimpan aman di home directory server Anda.

---

## 8. Cara Masuk ke Terminal VPS (SSH)

Setiap kali Anda ingin mengelola server VPS, buka **PowerShell** di komputer Windows Anda dan jalankan:

```powershell
ssh root@202.10.41.115
```
*(Masukkan password VPS Anda jika diminta. Ganti IP jika IP VPS berubah.)*

Tanda bahwa sudah berhasil masuk, tampilan terminal akan berubah menjadi:
```text
root@vps:~#
```

Setelah masuk, pindah ke folder project:
```bash
cd ~/WebSiminah
```

### Perintah Harian yang Sering Dipakai di VPS

| Kebutuhan | Perintah |
|---|---|
| **Cek status container** | `docker compose ps` |
| **Lihat error log real-time** | `docker compose logs -f app` |
| **Lihat error PHP detail** | `docker compose exec app tail -n 50 storage/logs/laravel.log` |
| **Restart semua container** | `docker compose restart` |
| **Update kode dari GitHub** | `git pull origin master` |
| **Rebuild container setelah update** | `docker compose up -d --build app` |
| **Clear cache Laravel** | `docker compose exec app php artisan optimize:clear` |
| **Masuk CLI MySQL** | `docker compose exec db mysql -u root -p siminah` |
| **Keluar dari terminal VPS** | `exit` |

---

## 9. Cara Mengelola Database MySQL di VPS

### Opsi A: Lewat Terminal (CLI)
```bash
# Masuk ke MySQL
docker compose exec db mysql -u root -p siminah

# Di dalam mysql> prompt:
SHOW TABLES;
SELECT id, name, email, role FROM users;
SELECT count(*) FROM donatur;
EXIT;
```

### Opsi B: Pasang phpMyAdmin (GUI Browser)
Jika ingin membuka database via browser seperti di lokal (port 8080), tambahkan service ini ke `docker-compose.yml`:

```yaml
  phpmyadmin:
    image: phpmyadmin:latest
    container_name: jelantah-phpmyadmin
    restart: unless-stopped
    environment:
      PMA_HOST: db
      PMA_USER: root
      PMA_PASSWORD: ${DB_ROOT_PASSWORD}
    ports:
      - "8080:80"
    depends_on:
      - db
    networks:
      - jelantah-network
```

Lalu jalankan `docker compose up -d phpmyadmin` di VPS, dan buka `http://202.10.41.115:8080` di browser.

> [!WARNING]
> Pastikan firewall juga dibuka untuk port 8080 jika ingin menggunakan phpMyAdmin:
> `sudo ufw allow 8080/tcp`

---

## 10. Log Progress & Riwayat Commit Deployment

Semua perbaikan bug dan konfigurasi deployment telah dicatat secara kronologis di bawah ini.

| Tanggal | Commit | Keterangan |
|---|---|---|
| 16 Okt 2026 | `cbe9d1f` | **feat:** Setup Docker production (PHP 8.2-FPM + Nginx + MySQL 8), file `.dockerignore`, `.env.production.example`, `PANDUAN_DEPLOY_VPS.md`, dan Nginx config |
| 16 Okt 2026 | `0051337` | **fix:** Kompatibilitas MySQL 8.0 — query `MAX(COALESCE(updated_at, '-'))` diganti menjadi `MAX(updated_at)`. Perbaikan nama route duplikat `login` → `api.login` di `routes/api.php`. Pengaman `null` di fungsi `dateFormat()` dan `datetimeFormat()` di `helpers.php` |
| 16 Okt 2026 | `e5101f1` | **fix:** Menambahkan `@props` default di `progressBar.blade.php` agar variabel `$type` tidak *undefined* di PHP 8.2 |
| 16 Okt 2026 | `acd847b` | **fix:** Membuat file `inputDate.blade.php` dan mengubah pemanggilan komponen dari `<x-forms.inputDate>` ke `<x-forms.input-date>` agar kompatibel dengan filesystem Linux yang *case-sensitive* |

### Status Halaman Saat Ini

| Halaman | Admin Kelurahan | Admin CSR |
|---|---|---|
| Login | ✅ | ✅ |
| Dashboard | ✅ | ✅ |
| Kontainer | ✅ | ✅ (diperbaiki commit `e5101f1`) |
| Sumbangan | ✅ | ✅ (diperbaiki commit `acd847b`) |
| Donatur | ✅ | ✅ |
| Hadiah / Redeem | ✅ | ✅ |
| Profil | ✅ | ✅ |

