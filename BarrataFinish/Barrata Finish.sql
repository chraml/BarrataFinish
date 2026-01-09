-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2025 at 12:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barratagt`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_company`
--

CREATE TABLE `about_company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `vision` text DEFAULT NULL,
  `mission` text DEFAULT NULL,
  `about_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_company`
--

INSERT INTO `about_company` (`id`, `company_name`, `tagline`, `description`, `vision`, `mission`, `about_image`, `created_at`, `updated_at`) VALUES
(1, 'PT Barrata Global Technology', 'Mitra Terpercaya dalam Industri Pemetaan Indonesia', 'PT Barrata Global Technology telah menjadi bagian penting dalam perkembangan industri pemetaan di Indonesia. Kami mendistribusikan software photogrammetry terkemuka, hardware pemetaan modern, dan data citra satelit berkualitas tinggi untuk mendukung kebutuhan pemetaan profesional di berbagai sektor.', 'Menjadi distributor terdepan dalam menyediakan solusi pemetaan dan teknologi geospasial di Indonesia.', 'Memberikan produk dan layanan berkualitas terbaik dengan dukungan tim ahli berpengalaman, serta terus beradaptasi dengan perkembangan teknologi untuk memenuhi ekspektasi klien.', '', '2025-10-19 21:15:19', '2025-11-21 02:38:32');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'admin@barrata.com', 'admin123', '2025-10-19 21:15:19'),
(2, 'admin@gmail.com', 'admin123', '2025-11-06 04:09:21'),
(3, 'test@admin.com', 'test123', '2025-11-21 00:35:46');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `logo`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'TNI Angkatan Udara', '1765236912_001.png', 0, '2025-11-09 02:10:10', '2025-12-08 23:35:12'),
(2, 'Badan Informasi Geospasial', '1765237286_002.png', 0, '2025-11-09 02:10:10', '2025-12-08 23:41:26'),
(3, 'BIN (Badan Intelijen Negara Republik Indonesia)', '1765237298_002a.png', 0, '2025-11-09 02:10:10', '2025-12-08 23:41:38'),
(4, 'ITB', '1765237309_003.png', 0, '2025-11-09 02:10:10', '2025-12-08 23:41:49'),
(5, 'Surveyor Indonesia', '1765237322_004.png', 0, '2025-11-09 02:10:10', '2025-12-08 23:42:02'),
(6, 'Penas', '1765237332_005.png', 0, '2025-11-09 02:10:10', '2025-12-08 23:42:12'),
(7, 'Sucofindo', '1765237345_006.png', 0, '2025-11-09 02:10:10', '2025-12-08 23:42:25'),
(8, 'Pemerintah Kota Banjarbaru', '1765237356_007.png', 0, '2025-11-09 02:10:10', '2025-12-08 23:42:36'),
(9, 'Pemda Kota', '1765237368_008.png', 0, '2025-11-09 02:10:10', '2025-12-08 23:42:48'),
(10, 'ITERA', '1765237378_009.png', 0, '2025-11-09 02:10:10', '2025-12-08 23:42:58'),
(11, 'Institut Teknologi Sepuluh November', '1765237387_010.png', 0, '2025-11-09 02:10:10', '2025-12-08 23:43:07'),
(12, 'Kementerian Lingkungan Hidup dan Kehutanan', '1765237399_011.png', 0, '2025-11-09 02:10:10', '2025-12-08 23:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
  `id` int(11) NOT NULL,
  `address` text DEFAULT NULL,
  `operating_hours` text DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `whatsapp` varchar(50) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `linkedin` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `maps_embed_url` text DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `location_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`id`, `address`, `operating_hours`, `phone`, `email`, `whatsapp`, `website`, `instagram`, `linkedin`, `facebook`, `twitter`, `maps_embed_url`, `latitude`, `longitude`, `location_description`, `created_at`, `updated_at`) VALUES
(1, 'Jl. Arcamanik Endah No.85A, Cisaranten Kulon, Kec. Arcamanik, Kota Bandung, Jawa Barat 40293', 'Senin-Jumat: 08:00 - 17:00 WIB\r\nSabtu: 08:00 - 12:00 WIB\r\nMinggu: Tutup', '(022) 20521270', 'info@barrataglobal.tech', '+62 812 3456 7890', 'https://barrataglobal.tech', '@barrataglobal', 'barrata-technologies', 'https://web.facebook.com/barrataglobaltechnology/', '@Barrata_Global', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.766250706146!2d107.67217807499654!3d-6.918524593081061!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68dd75c0000001%3A0x3eabb88b5648a569!2sPT.%20Barrata%20Global%20Technology!5e0!3m2!1sid!2sid!4v1762442035539!5m2!1sid!2sid', '', '', 'Kantor kami berlokasi strategis di kawasan Arcamanik, Bandung.', '2025-10-19 21:15:19', '2025-11-06 08:37:10');

-- --------------------------------------------------------

--
-- Table structure for table `contact_requests`
--

CREATE TABLE `contact_requests` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `whatsapp_number` varchar(50) NOT NULL,
  `request_type` varchar(100) NOT NULL,
  `priority` enum('High','Medium','Low') DEFAULT 'Medium',
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('baru','Pending','In Progress','Resolved') DEFAULT 'baru',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_requests`
--

INSERT INTO `contact_requests` (`id`, `name`, `email`, `whatsapp_number`, `request_type`, `priority`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(4, 'jaya', 'jaya@gmail.com', '+6281463819262', 'Survey', 'Medium', 'Survey', 'persyaratan survey', 'In Progress', '2025-12-08 15:15:00', '2025-12-08 15:16:00'),
(5, 'alya', 'alyakamilia13@gmail.com', '+6281463819262', 'Pelatihan Fotogrametri - Remote Sensing', 'Medium', 'Pelatihan', 'Detail Pelatihan', 'Pending', '2025-12-08 15:15:46', '2025-12-08 15:15:46');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` varchar(500) NOT NULL,
  `answer` text NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Apa itu PT Barrata Global Technology?', 'PT Barrata Global Technology adalah perusahaan distributor software photogrammetry, hardware pemetaan, dan data citra satelit yang telah berkontribusi besar dalam perubahan positif industri pemetaan Indonesia. Kami melayani berbagai klien mulai dari institusi pendidikan, swasta, hingga pemerintahan.', 1, 1, '2025-11-21 01:57:41', '2025-11-21 01:57:41'),
(2, 'Software Photogrammetry apa saja yang didistribusikan?', 'Kami mendistribusikan software photogrammetry terkemuka seperti Summit Evolution dan Correlator 3D. Summit Evolution menyediakan tools untuk menangkap informasi 3D dari data stereo dengan interface CAD dan GIS. Correlator 3D dari Simactive adalah software pertama yang menggunakan GPU-Powered AT dan DSM engines di industri.', 1, 2, '2025-11-21 01:57:41', '2025-11-21 01:57:41'),
(3, 'Apa itu Summit Evolution?', 'Summit Evolution adalah software yang menyediakan seperangkat tools untuk menemukan dan menangkap informasi 3D dari data stereo. Software ini mencakup interface CAD dan GIS, 3D stereo vector superimposition, automated feature editing, contour generation, dan banyak tools lainnya. Fitur dapat digitalisasi langsung ke AutoCAD, MicroStation, ArcGIS, atau Global Mapper melalui interface Capture.', 1, 3, '2025-11-21 01:57:41', '2025-11-21 01:57:41'),
(4, 'Apa keunggulan Correlator 3D?', 'Correlator 3D dari Simactive merupakan software photogrammetry yang terus berinovasi sejak 2003. Keunggulan utamanya adalah sebagai software pertama di industri yang menggunakan GPU-Powered AT (Aerial Triangulation) dan DSM (Digital Surface Model) engines, yang memberikan performa pemrosesan data yang sangat cepat dan akurat.', 1, 4, '2025-11-21 01:57:41', '2025-11-21 01:57:41'),
(5, 'Data satelit imagery apa saja yang tersedia?', 'Kami menyediakan berbagai data satelit imagery berkualitas tinggi seperti AW3D (peta 3D global dengan resolusi 5 meter), ALOS 2 PALSAR-2 (Synthetic Aperture Radar), dan KOMPSAT (Korean Multipurpose Satellite) untuk keperluan multipurpose dan SAR.', 1, 5, '2025-11-21 01:57:41', '2025-11-21 01:57:41'),
(6, 'Apa itu AW3D?', 'AW3D adalah peta 3D pertama dan paling presisi di dunia yang mencakup seluruh permukaan daratan global dengan resolusi 5 meter. Data ini sangat berguna untuk berbagai aplikasi pemetaan dan analisis topografi.', 1, 6, '2025-11-21 01:57:41', '2025-11-21 01:57:41'),
(7, 'Apa itu ALOS 2 PALSAR-2?', 'PALSAR-2 yang terpasang di satelit ALOS-2 adalah Synthetic Aperture Radar (SAR) yang memancarkan gelombang mikro dan menerima pantulannya dari permukaan bumi untuk memperoleh informasi. Teknologi ini dapat bekerja dalam segala kondisi cuaca dan siang/malam.', 1, 7, '2025-11-21 01:57:41', '2025-11-21 01:57:41'),
(8, 'Apa itu KOMPSAT Imagery?', 'KOMPSAT (Korean Multipurpose Satellite) adalah satelit multipurpose yang dikembangkan oleh Korea Aerospace Research Institute (KARI). Kami sebagai SI Imaging Services bertanggung jawab atas distribusi komersial citra KOMPSAT di seluruh dunia sejak 2014, termasuk untuk keperluan multipurpose dan SAR.', 1, 8, '2025-11-21 01:57:41', '2025-11-21 01:57:41'),
(9, 'Siapa saja klien dan partner PT Barrata?', 'Kami memiliki banyak klien dan partner dari berbagai sektor mulai dari institusi pendidikan (universitas, sekolah tinggi), perusahaan swasta (konsultan pemetaan, pertambangan, perkebunan), hingga lembaga pemerintah (Kementerian, BPN, BPPT, dan instansi terkait pemetaan).', 1, 9, '2025-11-21 01:57:41', '2025-11-21 01:57:41'),
(10, 'Apakah PT Barrata menyediakan pelatihan penggunaan software?', 'Ya, kami menyediakan pelatihan dan dukungan teknis untuk penggunaan software photogrammetry yang kami distribusikan. Kami memiliki tenaga ahli berkualitas di industri pemetaan yang siap membantu klien memaksimalkan penggunaan produk kami.', 1, 10, '2025-11-21 01:57:41', '2025-11-21 01:57:41'),
(11, 'Bagaimana PT Barrata menjaga kualitas layanan?', 'Kami berkomitmen melayani klien dengan kualitas terbaik dan hasil pengiriman produk yang tepat waktu. Kami terus beradaptasi dengan teknologi baru dan didukung oleh sumber daya manusia berkualitas serta peralatan lengkap yang siap digunakan untuk memenuhi ekspektasi klien.', 1, 11, '2025-11-21 01:57:41', '2025-11-21 01:57:41'),
(12, 'Apakah tersedia dukungan teknis setelah pembelian?', 'Ya, kami menyediakan dukungan teknis berkelanjutan untuk semua produk yang kami distribusikan. Tim ahli kami siap menjawab semua pertanyaan dan membantu menyelesaikan kendala teknis yang mungkin Anda hadapi dalam penggunaan software atau data satelit.', 1, 12, '2025-11-21 01:57:41', '2025-11-21 01:57:41'),
(13, 'Bagaimana cara memesan produk atau layanan?', 'Anda dapat menghubungi kami melalui halaman kontak di website ini, mengirim email, atau menghubungi nomor telepon/WhatsApp yang tertera. Tim kami akan segera merespon dan memberikan informasi detail mengenai produk, harga, dan proses pemesanan.', 1, 13, '2025-11-21 01:57:41', '2025-11-21 01:57:41'),
(14, 'Apakah ada demo atau trial untuk software?', 'Ya, untuk beberapa software yang kami distribusikan tersedia demo atau trial version. Silakan hubungi tim kami untuk informasi lebih lanjut mengenai ketersediaan demo dan persyaratannya.', 1, 14, '2025-11-21 01:57:41', '2025-11-21 01:57:41'),
(15, 'Berapa lama proses pengiriman data satelit setelah order?', 'Waktu pengiriman data satelit bervariasi tergantung jenis data dan ketersediaan. Data arsip biasanya dapat dikirim dalam 1-3 hari kerja, sementara data tasking baru memerlukan waktu sesuai dengan jadwal satelit dan kondisi cuaca. Tim kami akan memberikan estimasi waktu yang jelas saat pemesanan.', 1, 15, '2025-11-21 01:57:41', '2025-11-21 01:57:41');

-- --------------------------------------------------------

--
-- Table structure for table `home_content`
--

CREATE TABLE `home_content` (
  `id` int(11) NOT NULL,
  `main_title` varchar(255) NOT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `button_text` varchar(100) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `background_image` varchar(255) DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `home_content`
--

INSERT INTO `home_content` (`id`, `main_title`, `sub_title`, `description`, `button_text`, `button_link`, `background_image`, `hero_image`, `created_at`, `updated_at`) VALUES
(1, 'PT Barrata Global Technology', '', 'Distributor Software Photogrammetry, Hardware, dan Citra Satelit\r\n\r\nKami telah berkontribusi besar dalam membawa perubahan positif di industri pemetaan Indonesia. Melayani berbagai klien dan mitra mulai dari institusi pendidikan, swasta, hingga pemerintahan.', 'Hubungi Kami', 'kontak.php', '', '', '2025-10-19 21:15:19', '2025-11-21 02:34:34');

-- --------------------------------------------------------

--
-- Table structure for table `portfolios`
--

CREATE TABLE `portfolios` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  `project_url` varchar(255) DEFAULT NULL,
  `technologies` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portfolios`
--

INSERT INTO `portfolios` (`id`, `title`, `description`, `category`, `status`, `image`, `client`, `completion_date`, `project_url`, `technologies`, `created_at`, `updated_at`) VALUES
(1, 'Website Company Profile PT Maju Jaya', 'Pengembangan website company profile modern dan responsif dengan fitur multi-language, gallery interaktif, dan sistem manajemen konten yang mudah digunakan. Website ini dirancang untuk meningkatkan brand awareness dan mempermudah komunikasi dengan klien.', 'Lainnya', 'completed', '1761467022_ITfirm - IT Solutions and Services Company.jpeg', NULL, '2025-10-26', 'https://www.majujaya.co.id', 'PHP, Laravel, MySQL, Bootstrap, jQuery', '2025-10-26 01:23:42', '2025-11-22 03:15:04'),
(4, 'DAT/EM Photogrammetric Suite Version 7.4 Now Available', 'The time has come! The DAT/EM Photogrammetric Suite version 7.4 is now available. This exciting release includes a beta version of DAT/EM Point Cloud VR, updated project import compatibility for Summit Evolution', 'DATAEM Systems International', NULL, '1763606045_002.jpg', NULL, NULL, 'https://www.datem.com/datem-photogrammetric-suite-version-7-4-now-available/', NULL, '2025-11-21 02:49:55', '2025-11-22 03:14:53'),
(5, 'Version 7.5 Preview', 'Version 7.5 of the DAT/EM Software Suite is almost available. We are excited to share a preview of a few things to look forward to in the next release.', 'DATAEM Systems International', NULL, '1763607908_001.jpg', NULL, NULL, 'https://www.datem.com/version-7-5-preview/', NULL, '2025-11-21 02:51:12', '2025-11-22 02:03:17'),
(7, 'SimActive Used for Mapping Construction Projects', 'SimActive announces the use of its Correlator3D product in the mapping of large construction projects by US firm Bullseye Construction. The software allows for the creation of accurate map products including DSMs, point clouds and orthomosaics.', 'SimActive', NULL, '1763608083_001 (1).jpg', NULL, NULL, 'https://www.simactive.com/news-stories/simactive-used-for-mapping-construction-projects', NULL, '2025-11-21 02:51:21', '2025-11-22 03:14:26'),
(8, 'SimActive Used for Mapping in New Zealand', 'SimActive Inc. announces the use of its Correlator3D product used by GMAPSNZ in New Zealand. The software allows for the creation of accurate map products in challenging terrain and environment.', 'SimActive', NULL, '1763608122_002 (1).jpg', NULL, NULL, 'https://www.simactive.com/news-stories/simactive-used-for-mapping-in-new-zealand', NULL, '2025-11-21 02:51:30', '2025-11-22 03:14:11'),
(9, 'Cloud Computing Continues to Boost Photogrammetry Services', 'Two decades ago, SimActive introduced a gamechanger in photogrammetry processing when it transformed methods from the video and gaming industry for use in the geoinformatics sector.', 'SimActive', NULL, '1763608169_003 (1).jpg', NULL, NULL, 'https://www.simactive.com/news-stories/cloud-computing-continues-to-boost-photogrammetry-services', NULL, '2025-11-21 02:51:38', '2025-11-22 03:14:00'),
(10, 'Advantages of Combining AW3D DEM and Ortho Imagery', 'At AW3D, while we are well-known for our 3D data offerings, did you know we also provide high-quality AW3D Ortho imagery? This month, we want to highlight the advantages of using Digital Elevation Models and ortho imagery together.', 'ALOS-4,AW3D', NULL, '1763608571_001.gif', NULL, NULL, 'https://www.aw3d.jp/en/products/', NULL, '2025-11-21 02:51:48', '2025-11-22 03:13:48'),
(11, 'Archaeological Research of Buried Mausoleums in Conflict Areas', 'Remote sensing plays a crucial role in modern archaeological research. Slope and Aspect, calculated from AW3D Enhanced DTM, empower archaeologists to observe subtle elevation differences that are difficult to discern on-site.', 'AW3D', NULL, '1763608630_002.png', NULL, NULL, 'https://www.aw3d.jp/en/casestudy/archaeological-research-of-buried-mausoleums-in-conflict-areas-al-bass-site-tyre-lebanon/', NULL, '2025-11-21 02:51:55', '2025-11-22 02:02:28'),
(12, 'Agricultural Development Initiatives in Egypt', 'Latest case study from the World Food Programme Egypt, a collaboration with the Egyptian government to enhance agricultural productivity in 60 villages in Upper Egypt focusing on agricultural land consolidation and irrigation.', 'AW3D', NULL, '1763608668_003.png', NULL, NULL, 'https://www.aw3d.jp/en/casestudy/agricultural-land-consolidation-and-irrigation-along-the-nile-river-in-egypt/', NULL, '2025-11-21 02:52:03', '2025-11-22 02:01:55'),
(14, 'Sample', 'Sample', 'Lainnya', NULL, '1763831040_logo.png', NULL, NULL, NULL, NULL, '2025-11-22 10:04:00', '2025-11-22 10:04:00');

-- --------------------------------------------------------

--
-- Table structure for table `satellite_imagery`
--

CREATE TABLE `satellite_imagery` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `satellite_imagery`
--

INSERT INTO `satellite_imagery` (`id`, `name`, `description`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'AW3D', 'AW3D is the world\'s first and most precise 3D maps covering all global land areas with a meter resolution.', '1762691966_Aw3D.jpg', '2025-11-09 02:10:10', '2025-11-09 05:43:13'),
(2, 'ALOS-4', 'The PALSAR-2 aboard the ALOS-4 is a synthetic Aperture Radar (SAR), which emits microwave and receives the reflection from the ground to acquire information.', '1762692233_restec.png', '2025-11-09 02:10:10', '2025-11-09 05:43:53'),
(3, 'KOMPSAT IMAGERY', 'Korean Multi-purpose Satellite was developed by Korea Aerospace Research Institute (KARI) and is one of the key satellites for commercial distribution of KOMPSAT.', '1762693058_siis.png', '2025-11-09 02:10:10', '2025-11-09 05:57:38');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('software','satellite') NOT NULL,
  `badge` varchar(100) DEFAULT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `type`, `badge`, `description`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'DATAEM Systems International', 'software', 'SUMMIT EVOLUTION', 'Summit Evolution provides a set of powerful tools for discovering and capturing 3D information from stereo data. The software includes DAT and DEA interfaces, 3D stereo vector superimposition, automated feature adding, contour generation and more. Through the CatBase™ interface for encoded Summit products, image features frames Summit Evolution project are displayed directly into Automated Stereo Compilation™ Stereo map feature can be created on the Summit Evolution project, for immediate feature verification.', '1763726911_DATEM.jpg', 1, '2025-11-09 02:10:10', '2025-11-21 05:08:31'),
(2, 'SimActive', 'software', 'CORRELATOR 3D', 'SimActive is a leading developer of photogrammetry software producing best-in-class Canada. SimActive have been continuously innovating in the Correlator 3D product and Correlator giving the full software are all-in-one™ and DAT images in the industry.', '1763726925_simactive_logo.png', 1, '2025-11-09 02:10:10', '2025-11-21 05:08:45'),
(4, 'AW3D', 'satellite', '', 'AW3D is the world\'s first and most precise 3D maps covering all global land areas with a meter resolution.', '1763726934_Aw3D.jpg', 1, '2025-11-09 02:10:10', '2025-11-21 05:08:54'),
(5, 'ALOS-4', 'satellite', '', 'The PALSAR-2 aboard the ALOS-4 is a synthetic Aperture Radar (SAR), which emits microwave and receives the reflection from the ground to acquire information.', '1763726942_restec.png', 1, '2025-11-09 02:10:10', '2025-11-21 05:09:02'),
(6, 'KOMPSAT IMAGERY', 'satellite', '', 'Korean Multi-purpose Satellite was developed by Korea Aerospace Research Institute (KARI) and is one of the key satellites for commercial distribution of KOMPSAT.', '1763726953_siis.png', 1, '2025-11-09 02:10:10', '2025-11-21 05:09:13');

-- --------------------------------------------------------

--
-- Table structure for table `software`
--

CREATE TABLE `software` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `badge` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `software`
--

INSERT INTO `software` (`id`, `name`, `badge`, `description`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'DATAEM Systems International', 'SUMMIT EVOLUTION', 'Summit Evolution provides a set of powerful tools for discovering and capturing 3D information from stereo data. The software includes DAT and DEA interfaces, 3D stereo vector superimposition, automated feature adding, contour generation and more. Through the CatBase™ interface for encoded Summit products, image features frames Summit Evolution project are displayed directly into Automated Stereo Compilation™ Stereo map feature can be created on the Summit Evolution project, for immediate feature verification.', '1762688573_DATEM.jpg', '2025-11-09 02:10:10', '2025-11-09 04:42:53'),
(2, 'SimActive', 'CORRELATOR 3D', 'SimActive is a leading developer of photogrammetry software producing best-in-class Canada. SimActive have been continuously innovating in the Correlator 3D product and Correlator giving the full software are all-in-one™ and DAT images in the industry.', '1762688584_simactive_logo.png', '2025-11-09 02:10:10', '2025-11-09 04:43:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_company`
--
ALTER TABLE `about_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_requests`
--
ALTER TABLE `contact_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_content`
--
ALTER TABLE `home_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satellite_imagery`
--
ALTER TABLE `satellite_imagery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `software`
--
ALTER TABLE `software`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_company`
--
ALTER TABLE `about_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_requests`
--
ALTER TABLE `contact_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `home_content`
--
ALTER TABLE `home_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `satellite_imagery`
--
ALTER TABLE `satellite_imagery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `software`
--
ALTER TABLE `software`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
