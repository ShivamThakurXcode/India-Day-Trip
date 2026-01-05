-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2026 at 03:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `india_day_trip`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `publication_date` date DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `category_id` int(11) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `view_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `author_email` varchar(100) DEFAULT NULL,
  `content` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('tour','blog') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `type`, `created_at`) VALUES
(1, 'Same Day Tours', 'Tours completed in one day', 'tour', '2025-12-28 08:46:45'),
(2, 'Taj Mahal Tours', 'Tours focusing on Taj Mahal', 'tour', '2025-12-28 08:46:45'),
(3, 'Golden Triangle Tours', 'Delhi, Agra, Jaipur tours', 'tour', '2025-12-28 08:46:45'),
(4, 'Travel Tips', 'Tips and guides for travelers', 'blog', '2025-12-28 08:46:45'),
(5, 'Destinations', 'Information about destinations', 'blog', '2025-12-28 08:46:45'),
(6, 'Short Tours', 'Short duration tours', 'tour', '2026-01-04 17:52:26'),
(7, 'Day Tours', 'Day tours', 'tour', '2026-01-04 17:52:26'),
(8, 'Extended Golden Triangle Tours', 'Extended Golden Triangle tours', 'tour', '2026-01-04 17:52:26'),
(9, 'Train Tours', 'Train based tours', 'tour', '2026-01-04 17:52:26'),
(10, 'Luxury Tours', 'Luxury tours', 'tour', '2026-01-04 17:52:26'),
(11, 'Wildlife Tours', 'Wildlife tours', 'tour', '2026-01-04 17:52:26'),
(12, 'Extended Tours', 'Extended tours', 'tour', '2026-01-04 17:52:26'),
(13, 'Day Trips', 'Day trips', 'tour', '2026-01-04 17:52:26'),
(14, 'Rajasthan Tours', 'Rajasthan tours', 'tour', '2026-01-04 17:52:26'),
(15, 'Food Tours', 'Food tasting tours', 'tour', '2026-01-04 17:52:26'),
(16, 'City Tours', 'City tours', 'tour', '2026-01-04 17:52:26'),
(17, 'Short Tours', 'Short duration tours', 'tour', '2026-01-04 18:03:38'),
(18, 'Day Tours', 'Day tours', 'tour', '2026-01-04 18:03:38'),
(19, 'Extended Golden Triangle Tours', 'Extended Golden Triangle tours', 'tour', '2026-01-04 18:03:38'),
(20, 'Train Tours', 'Train based tours', 'tour', '2026-01-04 18:03:38'),
(21, 'Luxury Tours', 'Luxury tours', 'tour', '2026-01-04 18:03:38'),
(22, 'Wildlife Tours', 'Wildlife tours', 'tour', '2026-01-04 18:03:38'),
(23, 'Extended Tours', 'Extended tours', 'tour', '2026-01-04 18:03:38'),
(24, 'Day Trips', 'Day trips', 'tour', '2026-01-04 18:03:38'),
(25, 'Rajasthan Tours', 'Rajasthan tours', 'tour', '2026-01-04 18:03:38'),
(26, 'Food Tours', 'Food tasting tours', 'tour', '2026-01-04 18:03:38'),
(27, 'City Tours', 'City tours', 'tour', '2026-01-04 18:03:38'),
(28, 'Short Tours', 'Short duration tours', 'tour', '2026-01-04 18:04:55'),
(29, 'Day Tours', 'Day tours', 'tour', '2026-01-04 18:04:55'),
(30, 'Extended Golden Triangle Tours', 'Extended Golden Triangle tours', 'tour', '2026-01-04 18:04:55'),
(31, 'Train Tours', 'Train based tours', 'tour', '2026-01-04 18:04:55'),
(32, 'Luxury Tours', 'Luxury tours', 'tour', '2026-01-04 18:04:55'),
(33, 'Wildlife Tours', 'Wildlife tours', 'tour', '2026-01-04 18:04:55'),
(34, 'Extended Tours', 'Extended tours', 'tour', '2026-01-04 18:04:55'),
(35, 'Day Trips', 'Day trips', 'tour', '2026-01-04 18:04:55'),
(36, 'Rajasthan Tours', 'Rajasthan tours', 'tour', '2026-01-04 18:04:55'),
(37, 'Food Tours', 'Food tasting tours', 'tour', '2026-01-04 18:04:55'),
(38, 'City Tours', 'City tours', 'tour', '2026-01-04 18:04:55'),
(39, 'Short Tours', 'Short duration tours', 'tour', '2026-01-04 18:05:09'),
(40, 'Day Tours', 'Day tours', 'tour', '2026-01-04 18:05:09'),
(41, 'Extended Golden Triangle Tours', 'Extended Golden Triangle tours', 'tour', '2026-01-04 18:05:09'),
(42, 'Train Tours', 'Train based tours', 'tour', '2026-01-04 18:05:09'),
(43, 'Luxury Tours', 'Luxury tours', 'tour', '2026-01-04 18:05:09'),
(44, 'Wildlife Tours', 'Wildlife tours', 'tour', '2026-01-04 18:05:09'),
(45, 'Extended Tours', 'Extended tours', 'tour', '2026-01-04 18:05:09'),
(46, 'Day Trips', 'Day trips', 'tour', '2026-01-04 18:05:09'),
(47, 'Rajasthan Tours', 'Rajasthan tours', 'tour', '2026-01-04 18:05:09'),
(48, 'Food Tours', 'Food tasting tours', 'tour', '2026-01-04 18:05:09'),
(49, 'City Tours', 'City tours', 'tour', '2026-01-04 18:05:09');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `alt_text` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `filename`, `title`, `tags`, `alt_text`, `created_at`) VALUES
(1, 'hg1.webp', 'Gallery Image 1', '[]', 'Gallery Image 1', '2025-12-28 08:46:45'),
(2, 'hg2.webp', 'Gallery Image 2', '[]', 'Gallery Image 2', '2025-12-28 08:46:45'),
(3, 'hg3.webp', 'Gallery Image 3', '[]', 'Gallery Image 3', '2025-12-28 08:46:45'),
(5, 'hg5.webp', 'Gallery Image 5', '[]', 'Gallery Image 5', '2025-12-28 08:46:45'),
(6, 'hg6.webp', 'Gallery Image 6', '[]', 'Gallery Image 68', '2025-12-28 08:46:45'),
(7, 'hg7.webp', 'Gallery Image 7', '[]', 'Gallery Image 7', '2025-12-28 08:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
(1, 'contact_address', 'Shop No. 2, Gupta Market, Tajganj, Agra', '2025-12-28 08:46:45', '2025-12-28 08:46:45'),
(2, 'contact_email', 'info@indiadaytrip.com', '2025-12-28 08:46:45', '2025-12-28 08:46:45'),
(3, 'contact_mobile', '+91 81260 52755', '2025-12-28 08:46:45', '2025-12-28 08:46:45'),
(4, 'social_facebook', 'https://www.facebook.com/indiadaytrip', '2025-12-28 08:46:45', '2025-12-28 08:46:45'),
(5, 'social_twitter', 'https://www.twitter.com/indiadaytrip', '2025-12-28 08:46:45', '2025-12-28 08:46:45'),
(6, 'social_instagram', 'https://www.instagram.com/indiadaytrip', '2025-12-28 08:46:45', '2025-12-28 08:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `highlights` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`highlights`)),
  `included` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`included`)),
  `excluded` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`excluded`)),
  `itinerary` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`itinerary`)),
  `pricing` decimal(10,2) DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `dates` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`dates`)),
  `availability` int(11) DEFAULT 0,
  `category_id` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT 5.00,
  `view_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`id`, `title`, `slug`, `description`, `highlights`, `included`, `excluded`, `itinerary`, `pricing`, `images`, `dates`, `availability`, `category_id`, `location`, `duration`, `rating`, `view_count`, `created_at`, `updated_at`) VALUES
(18, 'From Delhi 2 Days Agra and Jaipur Tour By Car', 'from-delhi-2-days-agra-and-jaipur-tour-by-car', 'This 2 days Agra and Jaipur tour from Delhi by car is ideal for travelers who want to experience India’s most iconic Mughal and Rajput heritage in a short time. Starting from Delhi, the journey takes you to Agra to explore the majestic Taj Mahal, Agra Fort, and local handicraft markets. On the second day, continue towards Jaipur, the Pink City of Rajasthan, known for its royal palaces, forts, and vibrant culture. This tour is designed for comfort with a private air-conditioned car, professional driver, and flexible sightseeing schedule. It suits couples, families, and first-time visitors seeking a balanced mix of history, architecture, and local experiences. The route offers smooth highways, safe travel, and well-paced sightseeing without rush. With expert planning and reliable services, this tour ensures a memorable North India travel experience while covering two UNESCO World Heritage destinations efficiently.', '[\"Visit the Taj Mahal at Agra\",\"Explore Agra Fort and city attractions\",\"Sightseeing in Jaipur including Amber Fort\",\"Private AC car with experienced driver\",\"Comfortable overnight stay in Jaipur\"]', '[\"Private air-conditioned car\",\"Hotel accommodation\",\"Professional driver\",\"All sightseeing as per itinerary\",\"Fuel, parking, and toll taxes\"]', '[\"Monument entrance fees\",\"Personal expenses\",\"Meals not mentioned\",\"Camera or video charges\",\"Travel insurance\"]', '[{\"title\":\"Day 1\",\"points\":[\"Delhi to Agra sightseeing and drive to Jaipur\"]},{\"title\":\"Day 2\",\"points\":[\"Jaipur sightseeing and return\\/drop\"]}]', 9999.00, '[\"tours-image\\/cropped_1767538320858_sunrise-taj-2.webp\",\"tours-image\\/cropped_1767538358273_agra-tour-1.webp\",\"tours-image\\/cropped_1767538419287_udaipur-tour.webp\",\"tours-image\\/cropped_1767538451873_varanashi-tour.webp\",\"tours-image\\/cropped_1767538716104_delhi-food-taste.webp\"]', NULL, 20, 1, 'Delhi – Agra – Jaipur', '2 Days', 5.00, 28, '2026-01-04 14:49:45', '2026-01-04 18:08:48'),
(40, 'Taj Mahal Sunrise Tour From Delhi', 'taj-mahal-sunrise-tour-from-delhi', 'The Taj Mahal Sunrise Tour from Delhi offers a magical opportunity to witness India’s most famous monument in the soft morning light. Departing early from Delhi, this tour ensures you reach Agra before sunrise to experience the Taj Mahal at its most serene and photogenic moment. The changing colors of the marble at dawn create an unforgettable visual experience. After the Taj Mahal visit, explore Agra Fort, a UNESCO World Heritage Site that reflects the grandeur of Mughal architecture. This tour is perfect for travelers with limited time who want a premium cultural experience in one day. With private transportation, a knowledgeable guide, and a well-planned schedule, the journey is smooth and comfortable. Ideal for couples, photographers, and history lovers, this sunrise tour provides a peaceful and crowd-free way to explore Agra’s iconic landmarks.', '[]', '[]', '[]', '[]', NULL, '[]', NULL, 0, NULL, '', '', 5.00, 0, '2026-01-04 18:06:08', '2026-01-04 18:08:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','editor') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$mi2N3AWZeFCP3HCJV65dMOjPeqQGphWRNjQItZ0wPz3lMOTkM4Ujm', 'admin@indiadaytrip.com', 'admin', '2025-12-28 08:46:45', '2025-12-28 08:46:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_category` (`category_id`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_blog_id` (`blog_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `idx_slug` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD CONSTRAINT `blog_comments_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `tours_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
