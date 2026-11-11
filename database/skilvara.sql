-- =====================================================================
--  Skilvara English Center - Initial Database Schema
--  Cara import : phpMyAdmin / HeidiSQL (Laragon) -> Import file ini
--  Aman dijalankan berulang kali (DROP TABLE IF EXISTS di awal).
--  CATATAN: sesuaikan nama tabel/kolom dengan ERD Tugas 4 bila berbeda.
-- =====================================================================

CREATE DATABASE IF NOT EXISTS `skilvara_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `skilvara_db`;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `payments`;
DROP TABLE IF EXISTS `registrations`;
DROP TABLE IF EXISTS `batches`;
DROP TABLE IF EXISTS `program_benefits`;
DROP TABLE IF EXISTS `programs`;
DROP TABLE IF EXISTS `faqs`;
DROP TABLE IF EXISTS `faq_categories`;
DROP TABLE IF EXISTS `site_stats`;
DROP TABLE IF EXISTS `site_settings`;

SET FOREIGN_KEY_CHECKS = 1;

-- ---------------------------------------------------------------------
-- 1. programs : Kids Class, Teen Class, Adult Class
-- ---------------------------------------------------------------------
CREATE TABLE `programs` (
  `id`                INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug`              VARCHAR(50)  NOT NULL,
  `name`              VARCHAR(100) NOT NULL,
  `short_name`        VARCHAR(50)  NOT NULL,
  `image`             VARCHAR(120) NOT NULL,
  `price`             DECIMAL(12,0) NOT NULL DEFAULT 0,
  `total_sessions`    SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  `has_module`        TINYINT(1)   NOT NULL DEFAULT 1,
  `tryout_count`      TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `short_description` VARCHAR(300) NOT NULL,
  `description`       TEXT         NOT NULL,
  `sort_order`        TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `is_active`         TINYINT(1)   NOT NULL DEFAULT 1,
  `created_at`        TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_programs_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 2. program_benefits : "Manfaat Belajar" + "Materi Utama" tiap program
--    highlight_text diisi bila item tampil di daftar "Materi Utama".
-- ---------------------------------------------------------------------
CREATE TABLE `program_benefits` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `program_id`     INT UNSIGNED NOT NULL,
  `title`          VARCHAR(100) NOT NULL,
  `description`    VARCHAR(255) NOT NULL,
  `highlight_text` VARCHAR(120) DEFAULT NULL,
  `sort_order`     TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_benefits_program` (`program_id`),
  CONSTRAINT `fk_benefits_program` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 3. batches : gelombang pendaftaran
-- ---------------------------------------------------------------------
CREATE TABLE `batches` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(50)  NOT NULL,
  `start_date` DATE         NOT NULL,
  `note`       VARCHAR(80)  NOT NULL DEFAULT '',
  `is_open`    TINYINT(1)   NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 4. registrations : data pendaftar (dari Form Pendaftaran)
-- ---------------------------------------------------------------------
CREATE TABLE `registrations` (
  `id`               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reg_code`         VARCHAR(30)  NOT NULL,
  `full_name`        VARCHAR(120) NOT NULL,
  `email`            VARCHAR(120) NOT NULL,
  `whatsapp`         VARCHAR(20)  NOT NULL,
  `address`          TEXT         NOT NULL,
  `program_id`       INT UNSIGNED NOT NULL,
  `batch_id`         INT UNSIGNED NOT NULL,
  `course_fee`       DECIMAL(12,0) NOT NULL DEFAULT 0,
  `registration_fee` DECIMAL(12,0) NOT NULL DEFAULT 0,
  `discount`         DECIMAL(12,0) NOT NULL DEFAULT 0,
  `total_amount`     DECIMAL(12,0) NOT NULL DEFAULT 0,
  `status`           ENUM('menunggu_pembayaran','menunggu_verifikasi','aktif','dibatalkan') NOT NULL DEFAULT 'menunggu_pembayaran',
  `created_at`       TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_registrations_code` (`reg_code`),
  KEY `idx_reg_program` (`program_id`),
  KEY `idx_reg_batch` (`batch_id`),
  CONSTRAINT `fk_reg_program` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_reg_batch`   FOREIGN KEY (`batch_id`)   REFERENCES `batches` (`id`)  ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 5. payments : catatan pembayaran per pendaftaran
-- ---------------------------------------------------------------------
CREATE TABLE `payments` (
  `id`              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `registration_id` INT UNSIGNED NOT NULL,
  `method`          ENUM('qris','transfer_bank') NOT NULL DEFAULT 'qris',
  `amount`          DECIMAL(12,0) NOT NULL DEFAULT 0,
  `status`          ENUM('menunggu_verifikasi','berhasil','ditolak') NOT NULL DEFAULT 'menunggu_verifikasi',
  `paid_at`         TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_pay_reg` (`registration_id`),
  CONSTRAINT `fk_pay_reg` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 6. faq_categories & faqs
-- ---------------------------------------------------------------------
CREATE TABLE `faq_categories` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(60) NOT NULL,
  `slug`       VARCHAR(60) NOT NULL,
  `sort_order` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_faqcat_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `faqs` (
  `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` INT UNSIGNED NOT NULL,
  `question`    VARCHAR(255) NOT NULL,
  `answer`      TEXT         NOT NULL,
  `sort_order`  TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `is_active`   TINYINT(1)   NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_faq_cat` (`category_id`),
  CONSTRAINT `fk_faq_cat` FOREIGN KEY (`category_id`) REFERENCES `faq_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- 7. site_settings & site_stats : kontak, biaya, dan angka statistik
-- ---------------------------------------------------------------------
CREATE TABLE `site_settings` (
  `setting_key`   VARCHAR(60)  NOT NULL,
  `setting_value` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `site_stats` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `page`       VARCHAR(20)  NOT NULL,
  `stat_value` VARCHAR(20)  NOT NULL,
  `stat_label` VARCHAR(60)  NOT NULL,
  `sort_order` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_stats_page` (`page`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
--  DATA AWAL (SEED) - diambil dari wireframe high fidelity
-- =====================================================================

INSERT INTO `programs`
  (`id`,`slug`,`name`,`short_name`,`image`,`price`,`total_sessions`,`has_module`,`tryout_count`,`short_description`,`description`,`sort_order`) VALUES
(1,'kids-class','Kids Class (SD)','Kids Class','kids-class.jpg',350000,24,1,1,
 'Belajar bahasa Inggris sejak dini melalui permainan menyenangkan untuk membangun kemampuan dasar dan rasa percaya diri anak.',
 'Kids English Fun Class dirancang untuk anak-anak sekolah dasar yang ingin mulai belajar bahasa Inggris dengan cara yang menyenangkan. Pembelajaran berfokus pada pengenalan kosakata, penyusunan kalimat sederhana, serta latihan berbicara melalui permainan dan aktivitas interaktif.',1),
(2,'teen-class','Teen Class (SMP-SMA)','Teen Class','teen-class.jpg',450000,30,1,1,
 'Tingkatkan kemampuan bahasa Inggris untuk mendukung pembelajaran di sekolah, memperlancar percakapan, dan meningkatkan kepercayaan diri.',
 'English for Teens dirancang untuk siswa SMP dan SMA yang ingin meningkatkan kemampuan bahasa Inggris untuk kebutuhan akademik dan komunikasi sehari-hari. Program ini menggabungkan pembelajaran grammar, pengembangan kosakata, latihan percakapan, dan dukungan materi sekolah.',2),
(3,'adult-class','Adult Class','Adult Class','adult-class.jpg',550000,30,1,1,
 'Tingkatkan kemampuan bahasa Inggris untuk kebutuhan sehari-hari, pekerjaan, dan komunikasi profesional dengan latihan berbicara yang terarah.',
 'English for Everyday & Professional Use dirancang untuk peserta dewasa yang ingin meningkatkan kemampuan bahasa Inggris untuk kebutuhan sehari-hari, pekerjaan, dan komunikasi profesional. Peserta akan berlatih percakapan, memperluas kosakata, serta membangun kepercayaan diri melalui praktik berbicara.',3);

INSERT INTO `program_benefits` (`program_id`,`title`,`description`,`highlight_text`,`sort_order`) VALUES
(1,'Basic Vocabulary','Mengenal kosakata bahasa Inggris sehari-hari.','Basic Vocabulary',1),
(1,'Simple Sentences','Belajar membuat kalimat sederhana.','Simple Sentences',2),
(1,'Fun Learning','Belajar melalui permainan dan aktivitas kreatif.','Fun Games and Interactive Activities',3),
(1,'Confidence Building','Meningkatkan keberanian berbicara bahasa Inggris.',NULL,4),

(2,'Grammar and Tenses','Memahami tata bahasa dan penggunaan tenses.','Grammar and Tenses',1),
(2,'Speaking Practice','Melatih kelancaran berbicara dalam bahasa Inggris.','Speaking and Daily Conversations',2),
(2,'Daily Conversations','Berlatih percakapan dalam berbagai situasi.',NULL,3),
(2,'School Support','Mendukung pemahaman bahasa Inggris di sekolah.','Vocabulary and School Support',4),

(3,'Everyday Conversations','Berkomunikasi dalam situasi sehari-hari.','Everyday Conversations',1),
(3,'Workplace English','Menggunakan bahasa Inggris dalam lingkungan kerja.','English for the Workplace',2),
(3,'Speaking Practice','Melatih komunikasi lisan secara terarah.','Speaking Practice and Confidence Building',3),
(3,'Confidence Building','Membangun rasa percaya diri saat berbicara.',NULL,4);

INSERT INTO `batches` (`id`,`name`,`start_date`,`note`,`is_open`) VALUES
(1,'Desember 2026','2026-12-07','Tersisa 5 Kursi',1),
(2,'Januari 2027','2027-01-11','Pendaftaran Dibuka',1);

INSERT INTO `faq_categories` (`id`,`name`,`slug`,`sort_order`) VALUES
(1,'Umum','umum',1),
(2,'Pendaftaran','pendaftaran',2),
(3,'Pembayaran','pembayaran',3),
(4,'Program & Fasilitas','program-fasilitas',4),
(5,'Sertifikat','sertifikat',5);

-- Jawaban selain pertanyaan pertama adalah teks contoh: sesuaikan dengan kebijakan Skilvara yang sebenarnya.
INSERT INTO `faqs` (`category_id`,`question`,`answer`,`sort_order`) VALUES
(1,'Apakah ada tes penempatan sebelum memulai kursus?','Ya, setiap calon siswa diwajibkan mengikuti tes penempatan (Placement Test) gratis untuk menentukan level yang paling sesuai dengan kemampuan saat ini. Tes ini tersedia secara online maupun offline di pusat kami.',1),
(1,'Berapa lama durasi untuk setiap level program?','Kids Class terdiri dari 24 sesi, sedangkan Teen Class dan Adult Class terdiri dari 30 sesi per program. Hubungi admin untuk informasi jadwal pertemuan per minggu.',2),
(2,'Bagaimana cara mendaftar di Skilvara?','Klik tombol "Daftar Sekarang", isi formulir data diri, pilih program dan batch, periksa kembali data pada halaman konfirmasi, lalu lanjutkan ke pembayaran.',1),
(3,'Metode pembayaran apa saja yang tersedia?','Pembayaran dapat dilakukan melalui QRIS (Gopay, OVO, Dana, LinkAja) atau transfer bank manual (BCA, Mandiri). Setelah membayar, kirimkan bukti pembayaran ke WhatsApp Admin.',1),
(4,'Bagaimana jika saya tidak bisa hadir di salah satu sesi kelas?','Silakan informasikan kepada admin atau pengajar sebelum kelas dimulai agar dapat dibantu mengenai kemungkinan penjadwalan ulang sesuai kebijakan Skilvara.',1),
(4,'Apakah Skilvara menyediakan kelas privat?','Silakan hubungi tim kami melalui WhatsApp atau halaman Contact untuk menanyakan ketersediaan kelas privat dan biayanya.',2),
(5,'Apakah saya akan mendapatkan sertifikat setelah lulus?','Informasi mengenai sertifikat penyelesaian program dapat ditanyakan langsung kepada admin Skilvara English Center.',1);

INSERT INTO `site_settings` (`setting_key`,`setting_value`) VALUES
('address','Ruko Cluster Permata, Jl. Kelapa, Lagaligo, Kec. Wara, Kota Palopo'),
('phone','+62 822-7297-9021'),
('whatsapp','6282272979021'),
('email','@skilvaraenglishcenter.com'),
('maps_url','https://www.google.com/maps/search/?api=1&query=Skilvara+English+Center+Palopo'),
('tiktok_url','#'),
('instagram_url','#'),
('facebook_url','#'),
('bank_name','Bank BRI'),
('bank_account_no','040301045884508'),
('bank_account_name','MUH. RINALDY'),
('registration_fee','150000'),
('promo_discount','0');

INSERT INTO `site_stats` (`page`,`stat_value`,`stat_label`,`sort_order`) VALUES
('home','3+','Tahun Pengalaman',1),
('home','100+','Alumni Berhasil',2),
('home','2+','Instruktur Profesional',3),
('home','10+','Partner Institusi',4),
('profil','200+','Siswa Terdaftar',1),
('profil','98%','Kepuasan Alumni',2);
