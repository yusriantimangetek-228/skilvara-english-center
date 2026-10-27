-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2026 at 04:56 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skilvara_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `seats_left` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `name`, `status`, `seats_left`) VALUES
(1, 'Februari 2026', 'Tersisa 5 Kursi', 5),
(2, 'Maret 2026', 'Pendaftaran Dibuka', 20);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `category_id`, `question`, `answer`) VALUES
(1, 1, 'Apakah ada tes penempatan sebelum memulai kursus?', 'Ya, setiap calon siswa diwajibkan mengikuti tes penempatan (Placement Test) gratis untuk menentukan level yang paling sesuai dengan kemampuan saat ini. Tes tersedia secara online maupun offline di pusat kami.'),
(2, 1, 'Berapa lama durasi untuk setiap level program?', 'Durasi mengikuti jumlah sesi pada tiap program (24-30 sesi).'),
(3, 5, 'Apakah saya akan mendapatkan sertifikat setelah lulus?', 'Ya, peserta yang menyelesaikan program akan mendapatkan sertifikat.'),
(4, 1, 'Bagaimana jika saya tidak bisa hadir di salah satu sesi kelas?', 'Silakan hubungi admin untuk penjadwalan ulang sesi.'),
(5, 3, 'Metode pembayaran apa saja yang tersedia?', 'QRIS (Gopay, OVO, Dana, LinkAja) dan transfer bank manual (BCA, Mandiri).'),
(6, 4, 'Apakah Skilvara menyediakan kelas privat?', 'Silakan hubungi admin untuk informasi kelas privat.');

-- --------------------------------------------------------

--
-- Table structure for table `faq_categories`
--

CREATE TABLE `faq_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq_categories`
--

INSERT INTO `faq_categories` (`id`, `name`) VALUES
(1, 'Umum'),
(2, 'Pendaftaran'),
(3, 'Pembayaran'),
(4, 'Program & Fasilitas'),
(5, 'Sertifikat');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `method` enum('qris','transfer') NOT NULL,
  `proof_file` varchar(255) DEFAULT NULL,
  `status` enum('waiting','verified','rejected') DEFAULT 'waiting',
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `level_label` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `total_sessions` int(11) NOT NULL,
  `has_module` tinyint(1) DEFAULT 1,
  `tryout_count` int(11) DEFAULT 1,
  `short_desc` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `main_materials` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `slug`, `name`, `level_label`, `price`, `total_sessions`, `has_module`, `tryout_count`, `short_desc`, `description`, `main_materials`, `image`) VALUES
(1, 'kids', 'Kids Class', 'SD', 350000, 24, 1, 1, 'Belajar bahasa Inggris sejak dini melalui permainan menyenangkan untuk membangun kemampuan dasar dan rasa percaya diri anak.', 'Kids English Fun Class dirancang untuk anak-anak sekolah dasar yang ingin mulai belajar bahasa Inggris dengan cara yang menyenangkan.', 'Basic Vocabulary|Simple Sentences|Fun Games and Interactive Activities', NULL),
(2, 'teen', 'Teen Class', 'SMP-SMA', 450000, 30, 1, 1, 'Tingkatkan kemampuan bahasa Inggris untuk mendukung pembelajaran di sekolah, memperlancar percakapan, dan meningkatkan kepercayaan diri.', 'English for Teens dirancang untuk siswa SMP dan SMA yang ingin meningkatkan kemampuan bahasa Inggris untuk kebutuhan akademik dan komunikasi sehari-hari.', 'Grammar and Tenses|Speaking and Daily Conversations|Vocabulary and School Support', NULL),
(3, 'adult', 'Adult Class', 'Dewasa', 550000, 30, 1, 1, 'Tingkatkan kemampuan bahasa Inggris untuk kebutuhan sehari-hari, pekerjaan, dan komunikasi profesional.', 'English for Everyday & Professional Use dirancang untuk peserta dewasa yang ingin meningkatkan kemampuan bahasa Inggris untuk kebutuhan sehari-hari, pekerjaan, dan komunikasi profesional.', 'Everyday Conversations|English for the Workplace|Speaking Practice and Confidence Building', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `program_benefits`
--

CREATE TABLE `program_benefits` (
  `id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_benefits`
--

INSERT INTO `program_benefits` (`id`, `program_id`, `title`, `description`) VALUES
(1, 1, 'Basic Vocabulary', 'Mengenal kosakata bahasa Inggris sehari-hari.'),
(2, 1, 'Simple Sentences', 'Belajar membuat kalimat sederhana.'),
(3, 1, 'Fun Learning', 'Belajar melalui permainan dan aktivitas kreatif.'),
(4, 1, 'Confidence Building', 'Meningkatkan keberanian berbicara bahasa Inggris.'),
(5, 2, 'Grammar and Tenses', 'Memahami tata bahasa dan penggunaan tenses.'),
(6, 2, 'Speaking Practice', 'Melatih kelancaran berbicara dalam bahasa Inggris.'),
(7, 2, 'Daily Conversations', 'Berlatih percakapan dalam berbagai situasi.'),
(8, 2, 'School Support', 'Mendukung pemahaman bahasa Inggris di sekolah.'),
(9, 3, 'Everyday Conversations', 'Berkomunikasi dalam situasi sehari-hari.'),
(10, 3, 'Workplace English', 'Menggunakan bahasa Inggris dalam lingkungan kerja.'),
(11, 3, 'Speaking Practice', 'Melatih komunikasi lisan secara terarah.'),
(12, 3, 'Confidence Building', 'Membangun rasa percaya diri saat berbicara.');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `program_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `course_fee` int(11) NOT NULL,
  `registration_fee` int(11) NOT NULL DEFAULT 0,
  `discount` int(11) NOT NULL DEFAULT 0,
  `total_amount` int(11) NOT NULL,
  `status` enum('pending','paid','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `faq_categories`
--
ALTER TABLE `faq_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registration_id` (`registration_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `program_benefits`
--
ALTER TABLE `program_benefits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_id` (`program_id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_id` (`program_id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `faq_categories`
--
ALTER TABLE `faq_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `program_benefits`
--
ALTER TABLE `program_benefits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `faqs`
--
ALTER TABLE `faqs`
  ADD CONSTRAINT `faqs_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `faq_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `program_benefits`
--
ALTER TABLE `program_benefits`
  ADD CONSTRAINT `program_benefits_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`),
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
