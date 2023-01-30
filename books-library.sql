-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Jan 30, 2023 at 06:17 PM
-- Server version: 8.0.32
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `books-library`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `books_number` smallint NOT NULL DEFAULT '0',
  `is_updated` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `first_name`, `last_name`, `books_number`, `is_updated`) VALUES
(1, '1-author', '1-author', 1, 1),
(2, '2-author', '2-author', 2, 1),
(3, '3-author', '3-author', 1, 1),
(4, '4-author', '4-author', 3, 1),
(5, '5-author', '5-author', 1, 1),
(6, '6-author', '6-author', 0, 1),
(7, '7-author', '7-author', 3, 1),
(8, '8-author', '8-author', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `published` date NOT NULL,
  `book_cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `name`, `description`, `published`, `book_cover`) VALUES
(1, '1-book', 'description', '2023-01-01', NULL),
(2, '2-book', 'description', '2022-01-01', NULL),
(3, '3-book', 'description', '2023-01-01', NULL),
(4, '4-book', 'description', '2024-01-01', NULL),
(5, '5-book', 'description', '2021-01-01', NULL),
(6, '6-book', 'description', '2020-01-01', NULL),
(7, '7-book', 'description', '2019-01-01', NULL),
(8, '8-book', 'description', '2011-01-01', NULL),
(9, '9-book', 'description', '2012-01-01', NULL),
(11, 'new book2', NULL, '1988-01-01', '1630483340368_0-63d7f218d974f.jpeg'),
(12, 'new book3', NULL, '2010-01-01', 'restructuring-63d7f95f095c4.png'),
(13, 'new book4', NULL, '1999-01-01', 'screenshot14-63d7eb284b46c.png'),
(14, 'new book5', NULL, '1977-01-01', '1640358535619-63d7f0c0392dd.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `book_author`
--

CREATE TABLE `book_author` (
  `book_id` int NOT NULL,
  `author_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_author`
--

INSERT INTO `book_author` (`book_id`, `author_id`) VALUES
(1, 1),
(1, 3),
(2, 4),
(2, 7),
(3, 4),
(3, 5),
(4, 2),
(5, 4),
(5, 7),
(6, 2),
(6, 8),
(7, 7);

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230125154108', '2023-01-29 23:53:04', 289),
('DoctrineMigrations\\Version20230125154109', '2023-01-29 23:53:04', 1),
('DoctrineMigrations\\Version20230127094711', '2023-01-29 23:53:04', 39),
('DoctrineMigrations\\Version20230127094712', '2023-01-29 23:53:04', 1),
('DoctrineMigrations\\Version20230129010853', '2023-01-29 23:53:04', 20);

-- --------------------------------------------------------

--
-- Table structure for table `sonata_user__user`
--

CREATE TABLE `sonata_user__user` (
  `id` int NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sonata_user__user`
--

INSERT INTO `sonata_user__user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `created_at`, `updated_at`) VALUES
(2, 'admin', 'admin', 'admin@gmail.com', 'admin@gmail.com', 1, NULL, '$argon2id$v=19$m=65536,t=4,p=1$w1HjKHqFsWCBbTG5pJ8UPQ$iy2dh54kB9tHxGPyYbnTF0mbdk63HFLoUlcCkQCHw1o', '2023-01-30 17:36:29', NULL, NULL, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', '2023-01-27 11:51:21', '2023-01-30 17:36:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_author`
--
ALTER TABLE `book_author`
  ADD PRIMARY KEY (`book_id`,`author_id`),
  ADD KEY `IDX_9478D34516A2B381` (`book_id`),
  ADD KEY `IDX_9478D345F675F31B` (`author_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `sonata_user__user`
--
ALTER TABLE `sonata_user__user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_4F797D592FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_4F797D5A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_4F797D5C05FB297` (`confirmation_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sonata_user__user`
--
ALTER TABLE `sonata_user__user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_author`
--
ALTER TABLE `book_author`
  ADD CONSTRAINT `FK_9478D34516A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_9478D345F675F31B` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
