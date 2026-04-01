-- SQL to add new columns to existing database
-- Run this after importing the main SQL file if the database already exists

-- Add new columns to tours table
ALTER TABLE `tours` ADD COLUMN IF NOT EXISTS `internal_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL;
ALTER TABLE `tours` ADD COLUMN IF NOT EXISTS `included_points` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL;
ALTER TABLE `tours` ADD COLUMN IF NOT EXISTS `excluded_points` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL;
ALTER TABLE `tours` ADD COLUMN IF NOT EXISTS `faq` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL;
ALTER TABLE `tours` ADD COLUMN IF NOT EXISTS `show_price` tinyint(1) DEFAULT 1;
ALTER TABLE `tours` ADD COLUMN IF NOT EXISTS `schemas` longtext DEFAULT NULL;

-- Add new column to blogs table
ALTER TABLE `blogs` ADD COLUMN IF NOT EXISTS `schemas` longtext DEFAULT NULL;