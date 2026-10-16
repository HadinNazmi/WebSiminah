-- MariaDB dump 10.19  Distrib 10.11.19-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: siminah
-- ------------------------------------------------------
-- Server version	10.11.19-MariaDB-ubu2204

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adminkelurahan`
--

DROP TABLE IF EXISTS `adminkelurahan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `adminkelurahan` (
  `id_admin_kelurahan` char(36) NOT NULL DEFAULT (uuid()),
  `id_user` char(36) NOT NULL,
  `id_lokasi` char(36) NOT NULL,
  `nama_admin` varchar(255) DEFAULT NULL,
  `alamat_rumah` varchar(50) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_admin_kelurahan`),
  KEY `adminkelurahan_id_user_foreign` (`id_user`),
  KEY `adminkelurahan_id_lokasi_foreign` (`id_lokasi`),
  CONSTRAINT `adminkelurahan_id_lokasi_foreign` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`) ON DELETE CASCADE,
  CONSTRAINT `adminkelurahan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adminkelurahan`
--

LOCK TABLES `adminkelurahan` WRITE;
/*!40000 ALTER TABLE `adminkelurahan` DISABLE KEYS */;
INSERT INTO `adminkelurahan` VALUES
('1655692e-b094-4e1c-a8e6-ccd88c09ca12','79a4ce26-c135-11f1-bc56-ba2ebfceb693','912a11a8-fce1-4266-ae1f-1bfe765ea35f','adminkelurahan1','Alamat dummy','08123456789','2026-10-06 10:25:06','2026-10-06 19:13:34'),
('1d1eb90e-9c64-4f71-b09d-cec680d82e11','2f6fa8b1-40fc-497a-9531-acd8abc26071','a2eabef1-a8ae-400e-bd84-eb93d821ce15','bang jekii','jalan jalan','089827374636','2026-10-07 10:13:40','2026-10-15 07:40:03'),
('a2f8ea3f-1693-47f2-9d4b-e3143b886e32','a2f8ea3e-f6e2-4b6b-b05e-7e7c7d085389','a2f7d8b7-3343-4df4-a8e2-07348bc7f726','adminkelurahan6','jalan kelurahan 6','087945748575','2026-10-13 20:54:15','2026-10-13 20:54:15'),
('a2f9d09f-60bf-4d19-a2f7-12fd26be1b70','a2f9d09e-d0c8-4c61-a01b-35feeeeeea9b','9fb394a8-c215-11f1-b934-4eac6f0afc16','adminkel5','jalan kel5','081234567473','2026-10-14 07:38:26','2026-10-14 07:38:26'),
('a2fbd469-001b-4f80-a12c-fb782dbc7562','a2fbd468-e648-4e01-9ad9-8c9988cbadec','a2f7d8b7-3343-4df4-a8e2-07348bc7f726','halimah','jalan jalan','0897437483','2026-10-15 07:40:41','2026-10-15 07:40:41'),
('a2fbdadd-4b2e-44db-8e9f-472fad864f54','a2fbdadd-3048-4dc2-8047-9cc0a0ea1663','9fb394a8-c215-11f1-b934-4eac6f0afc16','rafif','jalan jalan ya','08797584993','2026-10-15 07:58:44','2026-10-15 07:58:44'),
('e958c161-c3e8-4918-8f71-48a4a2bc00c4','79ac567d-c135-11f1-bc56-ba2ebfceb693','912a11a8-fce1-4266-ae1f-1bfe765ea35f',NULL,'Alamat dummy','08123456789','2026-10-06 10:25:06','2026-10-06 10:25:06'),
('f59affc3-0f1e-44d4-9faa-83b03a687663','b9003319-d63b-4368-bd71-44a1f77dce01','a2eabef1-a8ae-400e-bd84-eb93d821ce15','bang jek jek','jalan jek','081298767890','2026-10-07 14:09:26','2026-10-07 14:09:26');
/*!40000 ALTER TABLE `adminkelurahan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `donatur`
--

DROP TABLE IF EXISTS `donatur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `donatur` (
  `id_donatur` char(36) NOT NULL DEFAULT (uuid()),
  `no_hp` varchar(50) NOT NULL,
  `nama_donatur` varchar(50) NOT NULL,
  `alamat_donatur` varchar(50) NOT NULL,
  `kelurahan` varchar(50) NOT NULL,
  `photo` varchar(50) NOT NULL,
  `poin` int(11) NOT NULL DEFAULT 0,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_donatur`),
  UNIQUE KEY `donatur_no_hp_unique` (`no_hp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `donatur`
--

LOCK TABLES `donatur` WRITE;
/*!40000 ALTER TABLE `donatur` DISABLE KEYS */;
INSERT INTO `donatur` VALUES
('17c16bf9-51ea-4749-8a02-a66ff49b3cc5','08111111111','Donatur Contoh','Alamat donatur dummy','Kelurahan Contoh','dummy.jpg',0,'$2y$10$cbf4SU0m9lRByhAzlCRiSumFt66mTbGsXfcLMfJAkk.tHDNIHJ0jO','2026-10-06 10:25:06','2026-10-06 11:39:49'),
('a2efceb7-51fc-4ce1-97da-2e6d385a6029','082283884373','hadin nazmii','dumai','dumai','dummy.jpg',53,'$2y$10$ABwaDhxbRaqNqc.x9VuNYeeTOS50oSg9YJj0E36YXT9rZUUvfDs6m','2026-10-09 08:14:50','2026-10-15 07:36:53'),
('a2efd7cb-cc33-4c42-b14e-5f72fc4217bf','081200000001','Tes Api','Jalan Tes','Teluk Binjai','dummy.jpg',0,'$2y$10$pnlrzwF6wtzS.NsHX1h/2eVY8YEhCg7u9dwvusVkBLZWTm84T9Cpa','2026-10-09 08:40:13','2026-10-09 08:40:13'),
('a2f5cf25-2223-45b0-8ffb-608794a1fa68','081200000009','Tes Submit','Jalan Tes','Teluk Binjai','dummy.jpg',0,'$2y$10$aR0bw2jlN9/d4roAfXGvduOF2eNhGsTJT5xnFcwqpQO17jD9fUHqu','2026-10-12 07:51:00','2026-10-12 07:51:00'),
('a2fbd1a2-e5d9-412e-a06d-4d03367b1ca8','083265986532','jaki','dumai','dumai','dummy.jpg',0,'$2y$10$BAn3UU2yYhT7WU4Ns0Ubv.MuvKv.O74Bx/1gxi6HdwSIHjqtg.rtC','2026-10-15 07:32:56','2026-10-15 07:32:56');
/*!40000 ALTER TABLE `donatur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kecamatan`
--

DROP TABLE IF EXISTS `kecamatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kecamatan` (
  `id_kecamatan` char(36) NOT NULL DEFAULT (uuid()),
  `nama_kecamatan` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kecamatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kecamatan`
--

LOCK TABLES `kecamatan` WRITE;
/*!40000 ALTER TABLE `kecamatan` DISABLE KEYS */;
INSERT INTO `kecamatan` VALUES
('401e4f59-ccec-4176-8789-cfec22dd0900','Kecamatan Contoh','2026-10-06 10:25:06','2026-10-06 10:25:06'),
('88415a74-c215-11f1-b934-4eac6f0afc16','kecamatan5','2026-10-07 13:08:36','2026-10-07 13:08:36'),
('a2eabef0-ec3a-4586-8001-f2375829647b','kecamatan 3','2026-10-06 19:51:35','2026-10-06 19:51:35'),
('a2f7d8b5-e6ec-4013-9cdc-20241b1e20db','kecamatan 6','2026-10-13 08:09:24','2026-10-13 08:09:24');
/*!40000 ALTER TABLE `kecamatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kontainer`
--

DROP TABLE IF EXISTS `kontainer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kontainer` (
  `id_kontainer` char(36) NOT NULL DEFAULT (uuid()),
  `id_lokasi` char(36) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kontainer`),
  KEY `kontainer_id_lokasi_foreign` (`id_lokasi`),
  CONSTRAINT `kontainer_id_lokasi_foreign` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kontainer`
--

LOCK TABLES `kontainer` WRITE;
/*!40000 ALTER TABLE `kontainer` DISABLE KEYS */;
INSERT INTO `kontainer` VALUES
('0a468b12-2b5e-4868-8db2-aa3baf7433ca','912a11a8-fce1-4266-ae1f-1bfe765ea35f',100,'Kontainer dummy','2026-10-06 10:25:06','2026-10-06 10:25:06'),
('a2eabef1-aa3e-4355-85b4-beed86e636a8','a2eabef1-a8ae-400e-bd84-eb93d821ce15',30,'-','2026-10-06 19:51:35','2026-10-06 19:51:35'),
('a2f7d8b7-34ab-46bc-b978-9f1e0bc227ed','a2f7d8b7-3343-4df4-a8e2-07348bc7f726',30,'-','2026-10-13 08:09:25','2026-10-13 08:09:25'),
('a2f8e8b1-5555-4b6b-8bcd-f8d5673f3498','9fb394a8-c215-11f1-b934-4eac6f0afc16',30,'-','2026-10-13 20:49:55','2026-10-13 20:49:55');
/*!40000 ALTER TABLE `kontainer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `log` (
  `id_log` char(36) NOT NULL DEFAULT (uuid()),
  `id_user` char(36) NOT NULL,
  `aksi` varchar(50) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_log`),
  KEY `log_id_user_foreign` (`id_user`),
  CONSTRAINT `log_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lokasi`
--

DROP TABLE IF EXISTS `lokasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `lokasi` (
  `id_lokasi` char(36) NOT NULL DEFAULT (uuid()),
  `id_kecamatan` char(36) NOT NULL,
  `is_kecamatan` tinyint(1) NOT NULL DEFAULT 0,
  `nama_kelurahan` varchar(50) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `deskripsi` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_lokasi`),
  KEY `lokasi_id_kecamatan_foreign` (`id_kecamatan`),
  CONSTRAINT `lokasi_id_kecamatan_foreign` FOREIGN KEY (`id_kecamatan`) REFERENCES `kecamatan` (`id_kecamatan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lokasi`
--

LOCK TABLES `lokasi` WRITE;
/*!40000 ALTER TABLE `lokasi` DISABLE KEYS */;
INSERT INTO `lokasi` VALUES
('912a11a8-fce1-4266-ae1f-1bfe765ea35f','401e4f59-ccec-4176-8789-cfec22dd0900',0,'Teluk Binjai','1.675869363869765','101.46266749714671','dummy.jpg','Ironman','active','2026-10-06 10:25:06','2026-10-06 11:04:18'),
('9fb394a8-c215-11f1-b934-4eac6f0afc16','88415a74-c215-11f1-b934-4eac6f0afc16',0,'kelurahan5','1.6759002595943002','101.4624431290313','bER6Pfxio1OTS4sBaeKzhm0koeCRUUUAURVqxVge.jpg','jalan kelurahan 5','active','2026-10-07 13:09:15','2026-10-07 13:09:15'),
('a2eabef1-a8ae-400e-bd84-eb93d821ce15','a2eabef0-ec3a-4586-8001-f2375829647b',1,'kelurahan 3','0.5259914140073789','101.42309862675553','wLxDc90Bm9ForDwwjj2R5MIqS30gqFGUihpU1ArT.jpg','jalan kelurahan 3','active','2026-10-06 19:51:35','2026-10-06 19:51:35'),
('a2f7d8b7-3343-4df4-a8e2-07348bc7f726','a2f7d8b5-e6ec-4013-9cdc-20241b1e20db',0,'kelurahan 6','1.675861378540887','101.46251069227793','xvWTO2JtkXkJpez3K1lj7KXuEYelxi2MfKBn0LZf.jpg','jalan kelurahan 6','active','2026-10-13 08:09:25','2026-10-13 08:09:25');
/*!40000 ALTER TABLE `lokasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_reset_tokens_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1),
(5,'2023_06_20_125529_create_table1',1),
(6,'2023_06_20_125846_create_adminkelurahan_table',1),
(7,'2023_06_20_125850_create_donatur_table',1),
(8,'2023_06_20_125855_create_kontainer_table',1),
(9,'2023_06_20_125858_create_pengelola_csr_table',1),
(10,'2023_06_20_125900_create_permintaan_table',1),
(11,'2023_06_20_125907_create_redeem_table',1),
(12,'2023_06_20_125911_create_reward_table',1),
(13,'2023_06_20_125915_create_sumbangan_table',1),
(14,'2023_06_20_130118_create_kecamatan_table',1),
(15,'2023_06_20_130118_create_lokasi_table',1),
(16,'2023_07_09_064139_adddummyuser',1),
(17,'2023_08_28_143238_create_log_table',1),
(18,'2023_08_28_144016_create_notifikasi_table',1),
(19,'2023_08_29_135346_create_relation',1),
(20,'2026_10_06_000001_add_status_to_lokasi_table',2),
(21,'2026_10_06_000002_add_poin_to_donatur_table',3),
(22,'2026_10_06_191105_add_nama_admin_to_adminkelurahan_table',4),
(23,'2026_10_07_141700_add_status_to_reward_table',5),
(24,'2026_10_09_080537_fix_tokenable_id_uuid_on_personal_access_tokens',6),
(25,'2026_10_09_080542_add_unique_no_hp_to_donatur_table',6),
(26,'2026_10_12_080114_add_keterangan_to_sumbangan_table',7),
(27,'2026_10_13_000001_ensure_default_kontainer_for_lokasi',8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifikasi`
--

DROP TABLE IF EXISTS `notifikasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifikasi` (
  `id_notifikasi` char(36) NOT NULL DEFAULT (uuid()),
  `id_donatur` char(36) NOT NULL,
  `id_sumbangan` char(36) NOT NULL,
  `status` varchar(50) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `isRead` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_notifikasi`),
  KEY `notifikasi_id_donatur_foreign` (`id_donatur`),
  KEY `notifikasi_id_sumbangan_foreign` (`id_sumbangan`),
  CONSTRAINT `notifikasi_id_donatur_foreign` FOREIGN KEY (`id_donatur`) REFERENCES `donatur` (`id_donatur`) ON DELETE CASCADE,
  CONSTRAINT `notifikasi_id_sumbangan_foreign` FOREIGN KEY (`id_sumbangan`) REFERENCES `sumbangan` (`id_sumbangan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifikasi`
--

LOCK TABLES `notifikasi` WRITE;
/*!40000 ALTER TABLE `notifikasi` DISABLE KEYS */;
INSERT INTO `notifikasi` VALUES
('79c110c3-c830-11f1-9945-a23de72b5427','a2efceb7-51fc-4ce1-97da-2e6d385a6029','693555e6-c765-11f1-aeaf-3a5175651dd4','sumbangan_verifikasi','sumbangan berhasil diverifikasi',0,'2026-10-15 07:36:35','2026-10-15 07:36:35'),
('79c1525c-c830-11f1-9945-a23de72b5427','a2efceb7-51fc-4ce1-97da-2e6d385a6029','693555e6-c765-11f1-aeaf-3a5175651dd4','reward_poin','Anda berhasil mendapat 13 poin',0,'2026-10-15 07:36:35','2026-10-15 07:36:35');
/*!40000 ALTER TABLE `notifikasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengelola_csr`
--

DROP TABLE IF EXISTS `pengelola_csr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengelola_csr` (
  `id_pengelola` char(36) NOT NULL DEFAULT (uuid()),
  `id_user` char(36) NOT NULL,
  `nama_pengelola` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengelola`),
  KEY `pengelola_csr_id_user_foreign` (`id_user`),
  CONSTRAINT `pengelola_csr_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengelola_csr`
--

LOCK TABLES `pengelola_csr` WRITE;
/*!40000 ALTER TABLE `pengelola_csr` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengelola_csr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permintaan`
--

DROP TABLE IF EXISTS `permintaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `permintaan` (
  `id_permintaan` char(36) NOT NULL DEFAULT (uuid()),
  `id_kontainer` char(36) NOT NULL,
  `id_lokasi` char(36) NOT NULL,
  `id_admin_kelurahan` char(36) NOT NULL,
  `tanggal_permintaan` date NOT NULL,
  `status_kontainer` varchar(50) NOT NULL,
  `status_permintaan` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_permintaan`),
  KEY `permintaan_id_kontainer_foreign` (`id_kontainer`),
  KEY `permintaan_id_lokasi_foreign` (`id_lokasi`),
  KEY `permintaan_id_admin_kelurahan_foreign` (`id_admin_kelurahan`),
  CONSTRAINT `permintaan_id_admin_kelurahan_foreign` FOREIGN KEY (`id_admin_kelurahan`) REFERENCES `adminkelurahan` (`id_admin_kelurahan`) ON DELETE CASCADE,
  CONSTRAINT `permintaan_id_kontainer_foreign` FOREIGN KEY (`id_kontainer`) REFERENCES `kontainer` (`id_kontainer`) ON DELETE CASCADE,
  CONSTRAINT `permintaan_id_lokasi_foreign` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permintaan`
--

LOCK TABLES `permintaan` WRITE;
/*!40000 ALTER TABLE `permintaan` DISABLE KEYS */;
INSERT INTO `permintaan` VALUES
('8926b2e8-c70f-11f1-8cc6-c20d73b42997','0a468b12-2b5e-4868-8db2-aa3baf7433ca','912a11a8-fce1-4266-ae1f-1bfe765ea35f','1655692e-b094-4e1c-a8e6-ccd88c09ca12','2026-10-13','penuh','diterima','2026-10-13 21:08:16','2026-10-13 21:08:57');
/*!40000 ALTER TABLE `permintaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES
(6,'App\\Models\\Donatur','a2efd7cb-cc33-4c42-b14e-5f72fc4217bf','authToken','3d04e3060302f40c2025098f58da92250827ef0a94caf63a2e447f67a5da3c2a','[\"*\"]','2026-10-09 08:41:04',NULL,'2026-10-09 08:40:13','2026-10-09 08:41:04'),
(7,'App\\Models\\Donatur','a2f5cf25-2223-45b0-8ffb-608794a1fa68','authToken','05d21bbeadc588c3161f94141203c594b7211ff24668abf96f2ea9e8d0a7e1da','[\"*\"]','2026-10-12 07:52:19',NULL,'2026-10-12 07:51:00','2026-10-12 07:52:19'),
(8,'App\\Models\\Donatur','a2f5cf25-2223-45b0-8ffb-608794a1fa68','authToken','2df4fc9198e210e2c0e6c46bb5ce005305fcc61532231e4a456aef2d010f40a0','[\"*\"]','2026-10-12 08:14:27',NULL,'2026-10-12 08:13:29','2026-10-12 08:14:27'),
(9,'App\\Models\\Donatur','17c16bf9-51ea-4749-8a02-a66ff49b3cc5','authToken','b9c2e9425fe140dcfcf4eb0d6013712333a467d0314640ae01a1fb1c1a1eec19','[\"*\"]',NULL,NULL,'2026-10-12 14:46:08','2026-10-12 14:46:08'),
(13,'App\\Models\\Donatur','a2f5cf25-2223-45b0-8ffb-608794a1fa68','authToken','d14ca49dc643d88377d387829a04b04a9c15931efe519883d9c6515263afaf8e','[\"*\"]','2026-10-14 20:30:15',NULL,'2026-10-14 20:30:15','2026-10-14 20:30:15'),
(14,'App\\Models\\Donatur','a2f5cf25-2223-45b0-8ffb-608794a1fa68','authToken','683d4a2c3c1e6dadcd199eae1cd446e5b847cf31ca185e9c5ff5c47d30a71583','[\"*\"]','2026-10-14 20:35:16',NULL,'2026-10-14 20:35:13','2026-10-14 20:35:16'),
(17,'App\\Models\\Donatur','a2efceb7-51fc-4ce1-97da-2e6d385a6029','authToken','1de0171849ab6a997d3be5ec60ba5a84ae361104b67ec1cc9d127d5ba17c8d80','[\"*\"]','2026-10-15 07:43:59',NULL,'2026-10-15 07:38:21','2026-10-15 07:43:59');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `redeem`
--

DROP TABLE IF EXISTS `redeem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `redeem` (
  `id_redeem` char(36) NOT NULL DEFAULT (uuid()),
  `id_donatur` char(36) NOT NULL,
  `id_reward` char(36) NOT NULL,
  `tanggal_redeem` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_redeem`),
  KEY `redeem_id_donatur_foreign` (`id_donatur`),
  KEY `redeem_id_reward_foreign` (`id_reward`),
  CONSTRAINT `redeem_id_donatur_foreign` FOREIGN KEY (`id_donatur`) REFERENCES `donatur` (`id_donatur`) ON DELETE CASCADE,
  CONSTRAINT `redeem_id_reward_foreign` FOREIGN KEY (`id_reward`) REFERENCES `reward` (`id_reward`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `redeem`
--

LOCK TABLES `redeem` WRITE;
/*!40000 ALTER TABLE `redeem` DISABLE KEYS */;
INSERT INTO `redeem` VALUES
('026f6823-cb39-4c6c-aa9d-9f4c37b8f01d','a2efceb7-51fc-4ce1-97da-2e6d385a6029','076c2450-0e0c-4ea2-8ad6-4337b2c140e7','2026-10-13','selesai','2026-10-13 08:13:06','2026-10-13 08:17:12'),
('3dca86a1-af7d-4c51-a508-d55095c6e8c7','a2efceb7-51fc-4ce1-97da-2e6d385a6029','633a2863-c76a-11f1-aeaf-3a5175651dd4','2026-10-14','selesai','2026-10-14 10:50:29','2026-10-14 10:51:16'),
('8f8e039d-b0eb-435e-8b68-23b7abec03ef','a2efceb7-51fc-4ce1-97da-2e6d385a6029','633a2863-c76a-11f1-aeaf-3a5175651dd4','2026-10-14','selesai','2026-10-14 07:59:00','2026-10-14 08:00:12'),
('fae4fd41-94e9-4b1a-8669-dd6fbb0fb0e5','a2efceb7-51fc-4ce1-97da-2e6d385a6029','633a2863-c76a-11f1-aeaf-3a5175651dd4','2026-10-15','selesai','2026-10-15 07:36:53','2026-10-15 07:37:17'),
('fe8e2e67-f396-492d-b73b-2ee4bfaa4dbd','a2efceb7-51fc-4ce1-97da-2e6d385a6029','076c2450-0e0c-4ea2-8ad6-4337b2c140e7','2026-10-14','selesai','2026-10-14 07:47:24','2026-10-14 08:00:06');
/*!40000 ALTER TABLE `redeem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reward`
--

DROP TABLE IF EXISTS `reward`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reward` (
  `id_reward` char(36) NOT NULL DEFAULT (uuid()),
  `nama_reward` varchar(50) NOT NULL,
  `stok` int(11) NOT NULL,
  `jumlah_poin` varchar(50) NOT NULL,
  `masa_berlaku` timestamp NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT '-',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_reward`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reward`
--

LOCK TABLES `reward` WRITE;
/*!40000 ALTER TABLE `reward` DISABLE KEYS */;
INSERT INTO `reward` VALUES
('076c2450-0e0c-4ea2-8ad6-4337b2c140e7','Voucher Jalan Jalan',15,'2','2026-10-07 23:59:59','9B1KXq1LHMh4T7bXcTEVcP6Tdp5zvDmfA2iZopkM.jpg','aktif','2026-10-07 14:31:23','2026-10-07 14:34:39'),
('633a2863-c76a-11f1-aeaf-3a5175651dd4','Voucher Belanja 100k',10,'2','2026-10-15 23:59:59','vUpuI1BQ6GMOtmUAssrGkcfpPKwK2PyRHnEwWDTX.jpg','-','2026-10-14 07:58:36','2026-10-15 07:36:53');
/*!40000 ALTER TABLE `reward` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sumbangan`
--

DROP TABLE IF EXISTS `sumbangan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sumbangan` (
  `id_sumbangan` char(36) NOT NULL DEFAULT (uuid()),
  `id_donatur` char(36) NOT NULL,
  `id_kontainer` char(36) NOT NULL,
  `tanggal` date NOT NULL,
  `berat` double NOT NULL,
  `photo` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `keterangan` varchar(255) NOT NULL DEFAULT '-',
  `poin_reward` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_sumbangan`),
  KEY `sumbangan_id_donatur_foreign` (`id_donatur`),
  KEY `sumbangan_id_kontainer_foreign` (`id_kontainer`),
  CONSTRAINT `sumbangan_id_donatur_foreign` FOREIGN KEY (`id_donatur`) REFERENCES `donatur` (`id_donatur`) ON DELETE CASCADE,
  CONSTRAINT `sumbangan_id_kontainer_foreign` FOREIGN KEY (`id_kontainer`) REFERENCES `kontainer` (`id_kontainer`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sumbangan`
--

LOCK TABLES `sumbangan` WRITE;
/*!40000 ALTER TABLE `sumbangan` DISABLE KEYS */;
INSERT INTO `sumbangan` VALUES
('0c22f206-0cdb-4479-bc0f-6af91848d6ff','17c16bf9-51ea-4749-8a02-a66ff49b3cc5','0a468b12-2b5e-4868-8db2-aa3baf7433ca','2026-10-06',3.3,'dummy.jpg','terverifikasi','-',0,'2026-10-06 10:29:14','2026-10-06 11:39:49'),
('1ac4fd41-c6a3-11f1-9a38-62f863203ab3','a2efceb7-51fc-4ce1-97da-2e6d385a6029','0a468b12-2b5e-4868-8db2-aa3baf7433ca','2026-10-13',6,'1791853925.jpg','terverifikasi','-',6,'2026-10-13 08:12:05','2026-10-13 08:12:33'),
('3b77d008-f7ea-48f6-83bd-4e26b83d3079','17c16bf9-51ea-4749-8a02-a66ff49b3cc5','0a468b12-2b5e-4868-8db2-aa3baf7433ca','2026-10-06',1.2,'dummy.jpg','terverifikasi','-',12,'2026-10-06 10:28:14','2026-10-06 10:28:14'),
('5dc330ba-c767-11f1-aeaf-3a5175651dd4','a2efceb7-51fc-4ce1-97da-2e6d385a6029','a2f8e8b1-5555-4b6b-8bcd-f8d5673f3498','2026-10-14',5,'1791938219.jpg','terverifikasi','-',5,'2026-10-14 07:36:59','2026-10-14 07:42:17'),
('693555e6-c765-11f1-aeaf-3a5175651dd4','a2efceb7-51fc-4ce1-97da-2e6d385a6029','0a468b12-2b5e-4868-8db2-aa3baf7433ca','2026-10-14',13,'1791937378.jpg','terverifikasi','-',13,'2026-10-14 07:22:59','2026-10-15 07:36:35'),
('6fbaf3f4-c70f-11f1-8cc6-c20d73b42997','a2efceb7-51fc-4ce1-97da-2e6d385a6029','0a468b12-2b5e-4868-8db2-aa3baf7433ca','2026-10-13',30,'1791900452.jpg','terverifikasi','-',30,'2026-10-13 21:07:33','2026-10-13 21:07:48'),
('abaaa3cf-c603-11f1-8b03-aa354e7ade61','a2efceb7-51fc-4ce1-97da-2e6d385a6029','a2eabef1-aa3e-4355-85b4-beed86e636a8','2026-10-12',5,'1791785448.jpg','0','-',5,'2026-10-12 13:10:49','2026-10-12 13:10:49'),
('aec9b8b4-c5db-11f1-9138-82ae60cf9633','a2efceb7-51fc-4ce1-97da-2e6d385a6029','0a468b12-2b5e-4868-8db2-aa3baf7433ca','2026-10-12',2,'1791768274.jpg','terverifikasi','-',2,'2026-10-12 08:24:34','2026-10-12 08:25:31'),
('cac17099-0788-465e-bd5e-49b39777e352','17c16bf9-51ea-4749-8a02-a66ff49b3cc5','0a468b12-2b5e-4868-8db2-aa3baf7433ca','2026-10-06',2.5,'dummy.jpg','terverifikasi','-',25,'2026-10-06 10:26:14','2026-10-06 10:26:14'),
('daee4220-c605-11f1-8b03-aa354e7ade61','a2efceb7-51fc-4ce1-97da-2e6d385a6029','0a468b12-2b5e-4868-8db2-aa3baf7433ca','2026-10-12',3,'1791786386.jpg','terverifikasi','-',3,'2026-10-12 13:26:26','2026-10-12 14:48:37'),
('dd2c9418-e322-439e-9599-f616322eb622','17c16bf9-51ea-4749-8a02-a66ff49b3cc5','0a468b12-2b5e-4868-8db2-aa3baf7433ca','2026-10-06',4,'dummy.jpg','terverifikasi','-',40,'2026-10-06 10:27:14','2026-10-06 10:27:14');
/*!40000 ALTER TABLE `sumbangan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `table1`
--

DROP TABLE IF EXISTS `table1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `table1` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `table1`
--

LOCK TABLES `table1` WRITE;
/*!40000 ALTER TABLE `table1` DISABLE KEYS */;
/*!40000 ALTER TABLE `table1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
('2f6fa8b1-40fc-497a-9531-acd8abc26071','bang jekii','bangjeki','bangjek@gmail.com',NULL,'admin_kelurahan','$2y$10$G5cDyTV..0yhd.6kn.zfgejldAtnqsdGR8voiizuFcN4.D3xm7M/m',NULL,'2026-10-07 10:13:40','2026-10-08 21:09:38'),
('79a4ce26-c135-11f1-bc56-ba2ebfceb693','adminkelurahan1','adminkelurahan','adminkelurahan@gmail.com',NULL,'admin_kelurahan','$2y$10$KiWLQsHW0fS0Gc8BpGnUFuspNM0vEigZVbIUGvoUk5/m12H29mLT2',NULL,'2026-10-06 10:24:44','2026-10-15 07:39:10'),
('79ac567d-c135-11f1-bc56-ba2ebfceb693','adminkelurahan2','adminkelurahan2','adminkelurahan2@gmail.com',NULL,'admin_kelurahan','$2y$10$NDhJVKLw6Qo2IcmJj7fr7.yPrKnhHrflWSneyueb5qWF8QWhkI5py',NULL,'2026-10-06 10:24:44','2026-10-06 10:24:44'),
('79b3e38f-c135-11f1-bc56-ba2ebfceb693','admincsr','admincsr','admincsr@gmail.com',NULL,'admin_csr','$2y$10$z2S4okjn89xfv8/9PbYnuOuSLrw9W6PCBkJ4RoOI5NsHXk0w.93CC',NULL,'2026-10-06 10:24:44','2026-10-06 10:24:44'),
('a2f8ea3e-f6e2-4b6b-b05e-7e7c7d085389','adminkelurahan6','adminkelurahan6','adminkelurahan6@gmail.com',NULL,'admin_kelurahan','$2y$10$TlOK5mF7ot7BD8zb5wOg9uLdGnZQwFTQagEH/N6eGyMZKf6oJD6Xe',NULL,'2026-10-13 20:54:15','2026-10-13 20:54:15'),
('a2f9d09e-d0c8-4c61-a01b-35feeeeeea9b','adminkel5','adminkel5','adminkel5@gmail.com',NULL,'admin_kelurahan','$2y$10$S.nTU2Fv0cv/IW1g/YOjLum0Rzc1LFCU9GqOZpijX0SIQRLaKW6RC',NULL,'2026-10-14 07:38:26','2026-10-14 07:38:26'),
('a2fbd468-e648-4e01-9ad9-8c9988cbadec','halimah','highfive','halimah@gmail.com',NULL,'admin_kelurahan','$2y$10$8aIavKeq5oAX84EFMCv2De7Osa7wcQF62ycImCX1.BePYciKQ9Eha',NULL,'2026-10-15 07:40:41','2026-10-15 07:40:41'),
('a2fbdadd-3048-4dc2-8047-9cc0a0ea1663','rafif','rafif','rafif@gmail.com',NULL,'admin_kelurahan','$2y$10$GsYkZ27Si0vHtiobYGij0eAU4bTvhTJmsiOm/OsaBHvNHcz3k3TL.',NULL,'2026-10-15 07:58:44','2026-10-15 07:58:44'),
('b9003319-d63b-4368-bd71-44a1f77dce01','bang jek jek','bangjekjek','bangjekjek@gmail.com',NULL,'admin_kelurahan','$2y$10$tXGokj1juaM6Au2Qd.zQJuZ.z7VBSMKFiLw1tSy53qK1Lt5EMw6UK',NULL,'2026-10-07 14:09:26','2026-10-07 14:09:26'),
('d403dffd-c13e-11f1-bc56-ba2ebfceb693','adminhadin','adminhadin','adminhadin@gmail.com',NULL,'admin_kelurahan','$2y$10$F/X6E24QSlgOsozYPwtua.zwxOJ9aCFcHHM91Ff6BSWB7WSWFH2.W',NULL,'2026-10-06 11:31:41','2026-10-06 11:31:41'),
('e411db63-c6a2-11f1-9a38-62f863203ab3','admin 6','admin6','admin6@gmail.com',NULL,'admin_kelurahan','$2y$10$2xq.PK8wXOW0dQty60b6wuG7fth4Pjix.kJMUljvF190x9uHUmGkW',NULL,'2026-10-13 08:10:33','2026-10-13 08:10:33'),
('f9976d0c-c1f4-11f1-a172-06b10001dd94','hadin nazmi','hadinnazmi','hadinnazmi21@gmail.com',NULL,'admin_kelurahan','$2y$10$MHaOP01kwO3fsbULHjv5x.5zyxXftPYiaz38FWACuC7VTcWHQiaSa',NULL,'2026-10-07 09:55:44','2026-10-07 09:55:44'),
('fbd35924-c166-11f1-bc56-ba2ebfceb693','adminkelurahan3','adminkelurahan3','adminkelurahan3',NULL,'admin_kelurahan','$2y$10$T5PYWXINP7Zzfr/GKwrXN.l6Aq/YIM31gLtQZN2z0vCizdCu2i1/y',NULL,'2026-10-06 19:14:19','2026-10-06 19:14:19');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-16  3:09:03


