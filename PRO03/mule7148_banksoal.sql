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

-- Dumping database structure for mule7148_banksoal
CREATE DATABASE IF NOT EXISTS `mule7148_banksoal` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `mule7148_banksoal`;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.


-- Dumping structure for table mule7148_banksoal.tbl_formatsoal
CREATE TABLE IF NOT EXISTS `tbl_formatsoal` (
  `id_formatsoal` int(11) NOT NULL AUTO_INCREMENT,
  `id_prodi` int(11) NOT NULL,
  `kopsurat_formatsoal` varchar(50) NOT NULL,
  `petunjukujian_formatsoal` text NOT NULL,
  `created_formatsoal` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_formatsoal` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_formatsoal`),
  KEY `FK_id_prodi_formatsoal` (`id_prodi`),
  CONSTRAINT `FK_id_prodi_formatsoal` FOREIGN KEY (`id_prodi`) REFERENCES `tbl_prodi` (`id_prodi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.


-- Dumping structure for table mule7148_banksoal.tbl_kelasmahasiswa
CREATE TABLE IF NOT EXISTS `tbl_kelasmahasiswa` (
  `id_kelasmahasiswa` int(11) NOT NULL AUTO_INCREMENT,
  `id_prodi` int(11) NOT NULL DEFAULT 0,
  `id_periode` int(11) NOT NULL DEFAULT 0,
  `semester_kelasmahasiswa` int(11) NOT NULL DEFAULT 0,
  `nomor_kelasmahasiswa` int(11) NOT NULL DEFAULT 0,
  `created_kelasmahasiswa` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_kelasmahasiswa` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_kelasmahasiswa`),
  KEY `FK_id_prodi_kelasmahasiswa` (`id_prodi`),
  KEY `FK_id_periode_kelasmahasiswa` (`id_periode`),
  CONSTRAINT `FK_id_periode_kelasmahasiswa` FOREIGN KEY (`id_periode`) REFERENCES `tbl_periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_id_prodi_kelasmahasiswa` FOREIGN KEY (`id_prodi`) REFERENCES `tbl_prodi` (`id_prodi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.


-- Dumping structure for table mule7148_banksoal.tbl_periode
CREATE TABLE IF NOT EXISTS `tbl_periode` (
  `id_periode` int(11) NOT NULL AUTO_INCREMENT,
  `nama_periode` varchar(50) NOT NULL,
  `semester_periode` varchar(50) NOT NULL,
  `created_periode` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_periode` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_periode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.


-- Dumping structure for table mule7148_banksoal.tbl_prodi
CREATE TABLE IF NOT EXISTS `tbl_prodi` (
  `id_fakultas` int(11) NOT NULL,
  `id_prodi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_prodi` varchar(50) NOT NULL,
  `id_user_kepala_prodi` int(11) NOT NULL,
  `id_user_admin_prodi` int(11) NOT NULL,
  `created_prodi` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_prodi` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_prodi`),
  KEY `FK_id_fakultas_prodi` (`id_fakultas`),
  KEY `FK_id_user_kepala_prodi` (`id_user_kepala_prodi`),
  KEY `FK_id_user_admin_prodi` (`id_user_admin_prodi`),
  CONSTRAINT `FK_id_fakultas_prodi` FOREIGN KEY (`id_fakultas`) REFERENCES `tbl_fakultas` (`id_fakultas`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_id_user_admin_prodi` FOREIGN KEY (`id_user_admin_prodi`) REFERENCES `tbl_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_id_user_kepala_prodi` FOREIGN KEY (`id_user_kepala_prodi`) REFERENCES `tbl_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.


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
  `file_soal` varchar(50) NOT NULL,
  `created_soal` datetime NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.


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
  `created_user` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_user` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
