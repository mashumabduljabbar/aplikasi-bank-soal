-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.8-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table mule7148_banksoal.tbl_fakultas
CREATE TABLE IF NOT EXISTS `tbl_fakultas` (
  `id_fakultas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_fakultas` varchar(50) NOT NULL,
  `alamat_fakultas` text NOT NULL,
  `notelp_fakultas` varchar(15) NOT NULL,
  `email_fakultas` varchar(50) NOT NULL,
  `created_fakultas` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_fakultas` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_fakultas`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table mule7148_banksoal.tbl_fakultas: ~2 rows (approximately)
/*!40000 ALTER TABLE `tbl_fakultas` DISABLE KEYS */;
INSERT INTO `tbl_fakultas` (`id_fakultas`, `nama_fakultas`, `alamat_fakultas`, `notelp_fakultas`, `email_fakultas`, `created_fakultas`, `updated_fakultas`) VALUES
	(1, 'Fakultas Komputer', 'Rumbai', '123', 'fk@unilak.ac.id', '2019-12-15 22:17:37', NULL),
	(2, 'Fakultas Ekonomi', 'Rumbai', '124', 'fe@unilak.ac.id', '2019-12-15 22:17:37', NULL);
/*!40000 ALTER TABLE `tbl_fakultas` ENABLE KEYS */;


-- Dumping structure for table mule7148_banksoal.tbl_formatsoal
CREATE TABLE IF NOT EXISTS `tbl_formatsoal` (
  `id_formatsoal` int(11) NOT NULL AUTO_INCREMENT,
  `id_prodi` int(11) NOT NULL,
  `kopsurat_formatsoal` varchar(50) NOT NULL,
  `petunjukujian_formatsoal` text NOT NULL,
  `created_formatsoal` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_formatsoal` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_formatsoal`),
  UNIQUE KEY `id_prodi` (`id_prodi`),
  CONSTRAINT `FK_id_prodi_formatsoal` FOREIGN KEY (`id_prodi`) REFERENCES `tbl_prodi` (`id_prodi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table mule7148_banksoal.tbl_formatsoal: ~1 rows (approximately)
/*!40000 ALTER TABLE `tbl_formatsoal` DISABLE KEYS */;
INSERT INTO `tbl_formatsoal` (`id_formatsoal`, `id_prodi`, `kopsurat_formatsoal`, `petunjukujian_formatsoal`, `created_formatsoal`, `updated_formatsoal`) VALUES
	(1, 1, '1576681624eced4d7fad92b2f2fa97f82c27e8a723.jpg', '<ol>\r\n<li>Jawablah soal sesuai dengan instruksi dalam soal tersebut.</li>\r\n<li>Tidak dibenarkan menggunakan HP, Laptop dan alat elektronik lainnya.</li>\r\n<li>Masukkan soal ke dalam lembar jawaban saat dikumpulkan.</li>\r\n</ol>', '2019-12-17 05:14:36', '2019-12-18 22:07:04');
/*!40000 ALTER TABLE `tbl_formatsoal` ENABLE KEYS */;


-- Dumping structure for table mule7148_banksoal.tbl_kelasmahasiswa
CREATE TABLE IF NOT EXISTS `tbl_kelasmahasiswa` (
  `id_kelasmahasiswa` int(11) NOT NULL AUTO_INCREMENT,
  `id_prodi` int(11) NOT NULL DEFAULT 0,
  `periode_kelasmahasiswa` varchar(50) NOT NULL,
  `gg_kelasmahasiswa` varchar(50) NOT NULL DEFAULT '0',
  `semester_kelasmahasiswa` int(1) NOT NULL DEFAULT 0,
  `nomor_kelasmahasiswa` int(11) NOT NULL DEFAULT 0,
  `created_kelasmahasiswa` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_kelasmahasiswa` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_kelasmahasiswa`),
  KEY `FK_id_prodi_kelasmahasiswa` (`id_prodi`),
  CONSTRAINT `FK_id_prodi_kelasmahasiswa` FOREIGN KEY (`id_prodi`) REFERENCES `tbl_prodi` (`id_prodi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table mule7148_banksoal.tbl_kelasmahasiswa: ~4 rows (approximately)
/*!40000 ALTER TABLE `tbl_kelasmahasiswa` DISABLE KEYS */;
INSERT INTO `tbl_kelasmahasiswa` (`id_kelasmahasiswa`, `id_prodi`, `periode_kelasmahasiswa`, `gg_kelasmahasiswa`, `semester_kelasmahasiswa`, `nomor_kelasmahasiswa`, `created_kelasmahasiswa`, `updated_kelasmahasiswa`) VALUES
	(1, 2, '2019/2020', 'Ganjil', 1, 1, '2019-12-16 10:00:49', '2019-12-20 01:30:25'),
	(3, 2, '2019/2020', 'Genap', 2, 2, '2019-12-16 10:00:49', '2019-12-20 01:30:38'),
	(4, 2, '2020/2021', 'Ganjil', 3, 2, '2019-12-16 22:08:15', '2019-12-20 02:36:45'),
	(5, 1, '2021/2022', 'Genap', 4, 76, '2019-12-20 02:17:52', '2019-12-20 03:03:50');
/*!40000 ALTER TABLE `tbl_kelasmahasiswa` ENABLE KEYS */;


-- Dumping structure for table mule7148_banksoal.tbl_matakuliah
CREATE TABLE IF NOT EXISTS `tbl_matakuliah` (
  `id_matakuliah` int(11) NOT NULL AUTO_INCREMENT,
  `id_prodi` int(11) NOT NULL DEFAULT 0,
  `kode_matakuliah` varchar(50) NOT NULL,
  `nama_matakuliah` varchar(50) NOT NULL,
  `totalsks_matakuliah` int(11) NOT NULL,
  `created_matakuliah` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_matakuliah` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_matakuliah`),
  UNIQUE KEY `kode_matakuliah` (`kode_matakuliah`),
  KEY `FK_id_periode_matakuliah` (`id_prodi`),
  CONSTRAINT `FK_id_periode_matakuliah` FOREIGN KEY (`id_prodi`) REFERENCES `tbl_prodi` (`id_prodi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table mule7148_banksoal.tbl_matakuliah: ~1 rows (approximately)
/*!40000 ALTER TABLE `tbl_matakuliah` DISABLE KEYS */;
INSERT INTO `tbl_matakuliah` (`id_matakuliah`, `id_prodi`, `kode_matakuliah`, `nama_matakuliah`, `totalsks_matakuliah`, `created_matakuliah`, `updated_matakuliah`) VALUES
	(1, 2, 'DE', 'Dededed', 2, '2019-12-16 22:32:40', '2019-12-20 02:15:46'),
	(2, 1, 'B', 'TKJ', 2, '2019-12-16 22:32:40', '2019-12-20 08:30:22');
/*!40000 ALTER TABLE `tbl_matakuliah` ENABLE KEYS */;


-- Dumping structure for table mule7148_banksoal.tbl_prodi
CREATE TABLE IF NOT EXISTS `tbl_prodi` (
  `id_fakultas` int(11) NOT NULL,
  `id_prodi` int(11) NOT NULL AUTO_INCREMENT,
  `kode_prodi` varchar(50) NOT NULL,
  `nama_prodi` varchar(50) NOT NULL,
  `id_user_kepala_prodi` int(11) NOT NULL,
  `id_user_admin_prodi` int(11) NOT NULL,
  `created_prodi` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_prodi` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_prodi`),
  UNIQUE KEY `kode_prodi` (`kode_prodi`),
  KEY `FK_id_fakultas_prodi` (`id_fakultas`),
  KEY `FK_id_user_kepala_prodi` (`id_user_kepala_prodi`),
  KEY `FK_id_user_admin_prodi` (`id_user_admin_prodi`),
  CONSTRAINT `FK_id_fakultas_prodi` FOREIGN KEY (`id_fakultas`) REFERENCES `tbl_fakultas` (`id_fakultas`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_id_user_admin_prodi` FOREIGN KEY (`id_user_admin_prodi`) REFERENCES `tbl_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_id_user_kepala_prodi` FOREIGN KEY (`id_user_kepala_prodi`) REFERENCES `tbl_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table mule7148_banksoal.tbl_prodi: ~4 rows (approximately)
/*!40000 ALTER TABLE `tbl_prodi` DISABLE KEYS */;
INSERT INTO `tbl_prodi` (`id_fakultas`, `id_prodi`, `kode_prodi`, `nama_prodi`, `id_user_kepala_prodi`, `id_user_admin_prodi`, `created_prodi`, `updated_prodi`) VALUES
	(1, 1, 'TI', 'Teknik Informatika', 1, 3, '2019-12-15 23:04:03', '2019-12-19 23:42:52'),
	(1, 2, 'SIS', 'Sistem Informasi', 3, 2, '2019-12-15 23:04:03', '2019-12-19 23:58:39'),
	(2, 3, 'AK', 'Akutansi', 1, 3, '2019-12-15 23:04:03', '2019-12-19 23:42:53');
/*!40000 ALTER TABLE `tbl_prodi` ENABLE KEYS */;


-- Dumping structure for table mule7148_banksoal.tbl_soal
CREATE TABLE IF NOT EXISTS `tbl_soal` (
  `id_soal` int(11) NOT NULL AUTO_INCREMENT,
  `id_matakuliah` int(11) NOT NULL,
  `id_formatsoal` int(11) NOT NULL,
  `id_kelasmahasiswa` int(11) NOT NULL,
  `id_user_dosen_soal` int(11) NOT NULL,
  `tanggal_soal` date NOT NULL,
  `totalwaktu_soal` int(11) NOT NULL,
  `sifatujian_soal` int(1) NOT NULL DEFAULT 0,
  `tipe_soal` varchar(50) NOT NULL,
  `isi_soal` text NOT NULL,
  `created_soal` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_soal` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_soal`),
  KEY `FK_id_formatsoal_soal` (`id_formatsoal`),
  KEY `FK_id_matakuliah_soal` (`id_matakuliah`),
  KEY `FK_id_kelasmahasiswa_soal` (`id_kelasmahasiswa`),
  KEY `FK_id_user_dosen_soal` (`id_user_dosen_soal`),
  CONSTRAINT `FK_id_formatsoal_soal` FOREIGN KEY (`id_formatsoal`) REFERENCES `tbl_formatsoal` (`id_formatsoal`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_id_kelasmahasiswa_soal` FOREIGN KEY (`id_kelasmahasiswa`) REFERENCES `tbl_kelasmahasiswa` (`id_kelasmahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_id_matakuliah_soal` FOREIGN KEY (`id_matakuliah`) REFERENCES `tbl_matakuliah` (`id_matakuliah`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_id_user_dosen_soal` FOREIGN KEY (`id_user_dosen_soal`) REFERENCES `tbl_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table mule7148_banksoal.tbl_soal: ~3 rows (approximately)
/*!40000 ALTER TABLE `tbl_soal` DISABLE KEYS */;
INSERT INTO `tbl_soal` (`id_soal`, `id_matakuliah`, `id_formatsoal`, `id_kelasmahasiswa`, `id_user_dosen_soal`, `tanggal_soal`, `totalwaktu_soal`, `sifatujian_soal`, `tipe_soal`, `isi_soal`, `created_soal`, `updated_soal`) VALUES
	(1, 1, 1, 1, 3, '2019-12-18', 90, 0, 'A', 'okokokok', '2019-12-18 05:42:42', NULL),
	(2, 1, 1, 3, 1, '2019-12-18', 903, 1, 'E', '<p>Test</p>\r\n<p>&nbsp;</p>', '2019-12-18 05:45:15', '2019-12-20 03:04:04'),
	(3, 2, 1, 4, 1, '2019-12-18', 120, 1, 'B', '<p>Isi Soal</p>', '2019-12-18 22:02:48', '2019-12-20 08:48:53'),
	(4, 2, 1, 5, 2, '2019-12-20', 90, 1, 'C', '<p>Isi Soal</p>', '2019-12-20 08:50:58', NULL);
/*!40000 ALTER TABLE `tbl_soal` ENABLE KEYS */;


-- Dumping structure for table mule7148_banksoal.tbl_user
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nidn_user` varchar(50) DEFAULT NULL,
  `level_user` varchar(50) DEFAULT NULL,
  `nama_user` varchar(50) DEFAULT NULL,
  `notelp_user` varchar(15) DEFAULT NULL,
  `email_user` varchar(50) DEFAULT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `user_password` varchar(50) DEFAULT NULL,
  `foto_user` varchar(50) DEFAULT NULL,
  `id_prodi` int(11) DEFAULT 0,
  `created_user` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_user` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `nidn_user` (`nidn_user`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `id_prodi` (`id_prodi`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table mule7148_banksoal.tbl_user: ~3 rows (approximately)
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` (`id_user`, `nidn_user`, `level_user`, `nama_user`, `notelp_user`, `email_user`, `user_name`, `user_password`, `foto_user`, `id_prodi`, `created_user`, `updated_user`) VALUES
	(1, '123', 'superadmin', 'Jabbars', '08', 'm@m.co', '123', '17c4520f6cfd1ab53d8745e84681eb49', '1576437533eb211eb4d8eb0fb2fa7a7eede2151211.png', 2, '2019-12-15 21:10:12', '2019-12-20 00:55:40'),
	(2, '124', 'nonadmin', 'Jeng', '080346775879', 'm@m.co', '124', '9b4a061e33aceff57eee1429404cf716', '1576804734f7a4301a81e15842362b6836b29e17b7.png', 1, '2019-12-15 21:10:12', '2019-12-20 08:23:12'),
	(3, '125', 'adminprodi', 'Teguh', '1234', 'teg@uni.ac.id', '125', '21232f297a57a5a743894a0e4a801fc3', '157643776941b586905e6233e72b076191f8bf9512.png', 1, '2019-12-16 01:27:29', '2019-12-20 00:55:53');
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
