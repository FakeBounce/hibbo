-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 18, 2017 at 04:28 PM
-- Server version: 10.1.9-MariaDB-log
-- PHP Version: 7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hibbo`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `life` bigint(20) NOT NULL,
  `mana` bigint(20) NOT NULL,
  `armor` bigint(20) NOT NULL,
  `damage` bigint(20) NOT NULL,
  `range` bigint(20) NOT NULL,
  `mv` bigint(20) NOT NULL,
  `flat_dd` bigint(20) NOT NULL,
  `percent_dd` bigint(20) NOT NULL,
  `dr` bigint(20) NOT NULL,
  `action` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`, `life`, `mana`, `armor`, `damage`, `range`, `mv`, `flat_dd`, `percent_dd`, `dr`, `action`, `created_at`, `updated_at`) VALUES
(1, 'Warrior', 15000, 1000, 0, 100, 1, 2, 50, 0, 0, 10, '2017-02-18 14:41:32', '2017-02-18 14:41:32');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(10) UNSIGNED NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `url`, `name`, `type`, `created_at`, `updated_at`) VALUES
(1, 'redpotion.png', 'Potion de vitalité', 'consummable', '2017-02-18 14:41:32', '2017-02-18 14:41:32'),
(2, 'bluepotion.png', 'Potion d\'énergie', 'consummable', '2017-02-18 14:41:32', '2017-02-18 14:41:32');

-- --------------------------------------------------------

--
-- Table structure for table `maps`
--

CREATE TABLE `maps` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tile_set` longtext COLLATE utf8_unicode_ci NOT NULL,
  `monster_set` longtext COLLATE utf8_unicode_ci NOT NULL,
  `item_set` longtext COLLATE utf8_unicode_ci NOT NULL,
  `monster_range` longtext COLLATE utf8_unicode_ci NOT NULL,
  `width` bigint(20) NOT NULL,
  `height` bigint(20) NOT NULL,
  `floor` bigint(20) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `maps`
--

INSERT INTO `maps` (`id`, `name`, `tile_set`, `monster_set`, `item_set`, `monster_range`, `width`, `height`, `floor`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Initiation', '1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 2 2 2 2 2 2 2 1 1 1 1 1 1 1 1 1 1 1 2 2 2 2 2 2 2 1 1 1 1 1 1 1 1 1 1 1 2 2 2 2 2 2 2 1 1 1 1 1 1 1 1 1 1 1 2 2 2 2 2 2 2 1 1 1 1 1 1 1 1 1 1 1 2 2 2 2 2 2 2 3 2 2 1 1 2 1 1 2 2 2 2 2 2 2 2 2 2 3 2 2 2 2 2 1 1 1 1 1 2 2 2 2 2 2 2 3 2 2 1 1 2 1 1 1 1 1 2 2 2 2 2 2 2 1 1 1 1 1 1 1 1 1 1 1 2 2 2 2 2 2 2 1 1 1 1 1 1 1 1 1 1 1 2 2 2 2 2 2 2 1 1 1 1 1 1 1 1 1 1 1 2 2 2 2 2 2 2 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1', '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 3 3 3 3 3 0 0 0 0 0 0 0 0 0 0 0 0 0 0 2 2 2 2 2 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 2 1 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 1 0 0 3 0 0 0 2 0 3 0 0 5 0 0 -1 0 0 1 0 2 1 0 0 0 2 0 3 0 0 4 0 0 0 0 0 1 0 0 0 0 0 0 2 0 3 0 0 5 0 0 0 0 0 0 2 1 3 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 3 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 3 0 0 0 0 0 0 0 0 0 0 0 0 3 0 0 0 0 0 3 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0', '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 1 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 2 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 2 0 0 0 0 0 1 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0', '1 2 3 4 5', 18, 13, 0, 'Découverte', '2017-02-18 14:41:32', '2017-02-18 14:41:32');

-- --------------------------------------------------------

--
-- Table structure for table `map_tiles`
--

CREATE TABLE `map_tiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `break` tinyint(1) NOT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `map_tiles`
--

INSERT INTO `map_tiles` (`id`, `url`, `type`, `break`, `action`, `created_at`, `updated_at`) VALUES
(1, 'forest.png', 'wall', 0, 'none', '2017-02-18 14:41:32', '2017-02-18 14:41:32'),
(2, 'grass.png', 'ground', 0, 'none', '2017-02-18 14:41:32', '2017-02-18 14:41:32'),
(3, 'grass_left_door.png', 'door', 1, 'kill_all', '2017-02-18 14:41:32', '2017-02-18 14:41:32');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_09_10_135949_create_monsters_table', 1),
('2016_09_10_135955_create_classes_table', 1),
('2016_09_10_140010_create_skills_table', 1),
('2016_09_11_134302_create_maps_table', 1),
('2016_09_11_134308_create_map_tiles_table', 1),
('2016_09_21_211959_create_items_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `monsters`
--

CREATE TABLE `monsters` (
  `id` int(10) UNSIGNED NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `life` bigint(20) NOT NULL,
  `armor` bigint(20) NOT NULL,
  `damage` bigint(20) NOT NULL,
  `range` bigint(20) NOT NULL,
  `mv` bigint(20) NOT NULL,
  `xp` bigint(20) NOT NULL,
  `gold` bigint(20) NOT NULL,
  `flat_dd` bigint(20) NOT NULL,
  `percent_dd` bigint(20) NOT NULL,
  `dr` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `monsters`
--

INSERT INTO `monsters` (`id`, `url`, `name`, `life`, `armor`, `damage`, `range`, `mv`, `xp`, `gold`, `flat_dd`, `percent_dd`, `dr`, `created_at`, `updated_at`) VALUES
(1, 'Man.png', 'Man', 200, 0, 150, 1, 1, 1, 1, 0, 0, 0, '2017-02-18 14:41:32', '2017-02-18 14:41:32'),
(2, 'Warrior.png', 'Warrior', 300, 100, 250, 1, 1, 1, 1, 0, 0, 0, '2017-02-18 14:41:32', '2017-02-18 14:41:32'),
(3, 'Ectoplasm.png', 'Ectoplasm', 500, 0, 550, 1, 1, 1, 1, 0, 0, 0, '2017-02-18 14:41:32', '2017-02-18 14:41:32'),
(4, 'Basic_Boss.png', 'Boss', 10000, 0, 1000, 2, 0, 1, 1, 0, 0, 0, '2017-02-18 14:41:32', '2017-02-18 14:41:32'),
(5, 'Healing_Orb.png', 'Totem de soin', 100, 0, 0, 1, 0, 1, 1, 0, 0, 0, '2017-02-18 14:41:32', '2017-02-18 14:41:32');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(10) UNSIGNED NOT NULL,
  `damage` bigint(20) NOT NULL,
  `time_damage` bigint(20) NOT NULL,
  `buff_damage` bigint(20) NOT NULL,
  `debuff_damage` bigint(20) NOT NULL,
  `type_damage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `xp` bigint(20) NOT NULL,
  `flat_dd` bigint(20) NOT NULL,
  `flat_du` bigint(20) NOT NULL,
  `percent_dd` bigint(20) NOT NULL,
  `percent_du` bigint(20) NOT NULL,
  `dr` bigint(20) NOT NULL,
  `buff_life` bigint(20) NOT NULL,
  `debuff_life` bigint(20) NOT NULL,
  `heal` bigint(20) NOT NULL,
  `time_heal` bigint(20) NOT NULL,
  `forced_mv` bigint(20) NOT NULL,
  `buff_mv` bigint(20) NOT NULL,
  `debuff_mv` bigint(20) NOT NULL,
  `duration` bigint(20) NOT NULL,
  `mana` bigint(20) NOT NULL,
  `cost_mana` bigint(20) NOT NULL,
  `cost_life` bigint(20) NOT NULL,
  `minimal_range` bigint(20) NOT NULL,
  `linear_range` bigint(20) NOT NULL,
  `diagonal_range` bigint(20) NOT NULL,
  `linear_aoe` bigint(20) NOT NULL,
  `diagonal_aoe` bigint(20) NOT NULL,
  `up_aoe` bigint(20) NOT NULL,
  `right_aoe` bigint(20) NOT NULL,
  `down_aoe` bigint(20) NOT NULL,
  `left_aoe` bigint(20) NOT NULL,
  `cast` bigint(20) NOT NULL,
  `action` bigint(20) NOT NULL,
  `reset_cast` bigint(20) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maps`
--
ALTER TABLE `maps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `map_tiles`
--
ALTER TABLE `map_tiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monsters`
--
ALTER TABLE `monsters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `maps`
--
ALTER TABLE `maps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `map_tiles`
--
ALTER TABLE `map_tiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `monsters`
--
ALTER TABLE `monsters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
