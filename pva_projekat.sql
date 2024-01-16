-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2024 at 12:32 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pva_projekat`
--

-- --------------------------------------------------------

--
-- Table structure for table `bans`
--

CREATE TABLE `bans` (
  `id_ban` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `date_start` date NOT NULL DEFAULT current_timestamp(),
  `date_end` date NOT NULL,
  `ban_reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id_comment` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_post` int(10) UNSIGNED NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id_comment`, `id_user`, `id_post`, `comment`) VALUES
(1, 2, 13, 'To je ta capri'),
(2, 2, 14, 'Prvi komentar'),
(3, 2, 13, 'Factos'),
(4, 2, 13, 'Nista osim cistih cinjenica.'),
(5, 2, 13, 'Comment222221111'),
(6, 2, 13, '#visernajivisi'),
(7, 2, 13, '#visernajivisi'),
(8, 2, 13, 'zavelame malagarava'),
(9, 2, 13, 'Kositi da zivotkvarismi'),
(10, 2, 13, 'Kositi da zivotkvarismi'),
(11, 2, 13, 'aaaaaaa'),
(12, 2, 13, 'aaaaaaa'),
(13, 2, 13, 'aaaaaaa'),
(14, 2, 13, 'A didu didu didule\n'),
(15, 2, 13, 'jeje'),
(16, 2, 13, 'jeje'),
(17, 2, 13, '???'),
(18, 2, 13, '???'),
(19, 2, 13, '???'),
(20, 2, 13, '1111'),
(21, 2, 13, '2222'),
(22, 2, 13, '33333'),
(23, 2, 12, 'Cao alex'),
(25, 2, 14, 'a didu didu diduleee'),
(27, 2, 14, 'meni\nje \nodvratno'),
(29, 2, 14, 'Danas sam bio kod Boska '),
(30, 2, 15, 'vauu'),
(31, 2, 12, 'Cao iz post.js'),
(32, 10, 4, 'cestitam '),
(33, 10, 15, 'Rispekt'),
(35, 2, 19, 'najjace'),
(36, 2, 18, 'ovo je maretov komentar'),
(37, 7, 24, 'lepa slika'),
(38, 2, 30, 'dobar logo'),
(39, 2, 31, 'tbtb'),
(41, 2, 24, 'cao'),
(42, 2, 37, 'xor  mi je bio neprijatelj');

-- --------------------------------------------------------

--
-- Table structure for table `following`
--

CREATE TABLE `following` (
  `id_follow` int(10) UNSIGNED NOT NULL,
  `id_followed_user` int(10) UNSIGNED NOT NULL,
  `id_follower` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `following`
--

INSERT INTO `following` (`id_follow`, `id_followed_user`, `id_follower`) VALUES
(42, 11, 2),
(46, 5, 10),
(48, 10, 13),
(60, 2, 10),
(62, 2, 7),
(64, 2, 13),
(65, 13, 2),
(66, 7, 2),
(68, 5, 2),
(69, 10, 2),
(70, 10, 16);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id_like` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_post` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id_like`, `id_user`, `id_post`) VALUES
(77, 10, 13),
(78, 10, 4),
(79, 10, 9),
(111, 2, 14),
(114, 2, 9),
(120, 2, 13),
(138, 2, 12),
(144, 2, 19),
(145, 2, 15),
(150, 2, 23),
(151, 10, 24),
(152, 10, 23),
(153, 2, 28),
(154, 2, 25),
(155, 7, 24),
(156, 7, 30),
(157, 2, 30),
(158, 2, 29),
(163, 10, 15),
(171, 16, 28),
(173, 2, 34),
(175, 2, 38),
(176, 10, 34),
(177, 20, 24),
(178, 20, 23),
(179, 20, 13);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id_post` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `post_description` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id_post`, `id_user`, `date`, `post_description`, `picture`) VALUES
(4, 2, '2024-01-05', 'Ovo je moj prvi post!', NULL),
(6, 2, '2024-01-05', 'aaaaaaaaaaaaaaaaa', NULL),
(7, 2, '2024-01-05', 'Yikes', NULL),
(9, 2, '2024-01-05', 'romaleromali', NULL),
(11, 2, '2024-01-05', 'Sewy', NULL),
(12, 10, '2024-01-05', 'Prvi post kod alex', NULL),
(13, 2, '2024-01-06', 'Viser>etf', NULL),
(14, 2, '2024-01-08', 'Provera123', NULL),
(15, 2, '2024-01-09', 'Danas sam bio kod Boska na konsultacijama.', NULL),
(18, 2, '2024-01-12', 'Danas pravim admina i nadam se zavrsavam projekat', NULL),
(19, 10, '2024-01-12', 'Projekat je spreman za predaju od 1/12/2024 u 7:50h ujutru,\n siuuuuu', NULL),
(23, 2, '2024-01-12', 'Na ovoj slici je Ato', 'uploads/posts/23.jpg'),
(24, 2, '2024-01-12', 'Ja i Ato', 'uploads/posts/24.jpg'),
(25, 10, '2024-01-12', 'Rufi', 'uploads/posts/25.JPG'),
(26, 10, '2024-01-12', 'Neki tekst za post', NULL),
(27, 10, '2024-01-12', 'Prva slika Rufi', 'uploads/posts/27.JPG'),
(28, 10, '2024-01-12', 'Univerzum wau', 'uploads/posts/28.jpg'),
(29, 7, '2024-01-13', 'Ovo je post od korisnika sa default profilnom slikom', NULL),
(30, 7, '2024-01-13', 'Logo', 'uploads/posts/30.png'),
(31, 13, '2024-01-13', 'Prvi logo', 'uploads/posts/31.png'),
(32, 2, '2024-01-13', 'Ovako je izgledao prvi dizajn aplikacije', 'uploads/posts/32.png'),
(34, 2, '2024-01-14', 'Cao iz dnevne sobe', NULL),
(36, 16, '2024-01-15', 'Hier ist meine ersten Post', NULL),
(37, 10, '2024-01-16', 'Nesto sto sam nasla iz prve godine', 'uploads/posts/37.png'),
(38, 10, '2024-01-16', 'Sutra jovan brani projekat', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `prof_description` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) NOT NULL DEFAULT 'uploads/profile_pictures/default.png',
  `user_type` varchar(15) NOT NULL DEFAULT 'user',
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `name`, `prof_description`, `profile_picture`, `user_type`, `gender`) VALUES
(2, 'jovannrt4421', '123', 'Joca', 'Volejbol%20plejer%0A%23visernajvisi', 'uploads/profile_pictures/2.jpg', 'user', 'male'),
(5, '1', '123', 'JocaCoca', NULL, 'uploads/profile_pictures/default.png', 'user', 'male'),
(7, 'joca2002', 'viser21', 'Jovan Abramovic', NULL, 'uploads/profile_pictures/default.png', 'user', 'male'),
(10, 'alex64', 'a1964', 'Aleksandra A.', 'Alex%20mi%20je%20mama%20', 'uploads/profile_pictures/10.jpg', 'user', 'female'),
(11, '123123123', '123123123', '123123', 'a%0Aa%0A%0Aa%0Aa', 'uploads/profile_pictures/default.png', 'user', 'male'),
(13, '123123', '123123', 'Rufi', '', 'uploads/profile_pictures/13.JPG', 'user', 'female'),
(14, 'admin123', 'admin123', 'Admin', 'Main%20Admin%20of%20the%20social%20network%20Toolan', 'uploads/profile_pictures/default.png', 'admin', 'male'),
(16, 'sjovannrt4421', '12344', 'Erik Kantona', 'golgolgolgol', 'uploads/profile_pictures/16.jpg', 'user', 'male'),
(18, 'ssjovannrt4421', '12345', 'asdasdasd', NULL, 'uploads/profile_pictures/default.png', 'user', 'male'),
(19, '121212213123', '123123', 'AAAA', NULL, 'uploads/profile_pictures/default.png', 'user', 'male'),
(20, 'cobe192', '123123', 'Kobi', NULL, 'uploads/profile_pictures/default.png', 'user', 'male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`id_ban`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `id_post` (`id_post`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `following`
--
ALTER TABLE `following`
  ADD PRIMARY KEY (`id_follow`),
  ADD KEY `id_followed_user` (`id_followed_user`),
  ADD KEY `id_follower` (`id_follower`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id_like`),
  ADD KEY `id_post` (`id_post`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bans`
--
ALTER TABLE `bans`
  MODIFY `id_ban` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `following`
--
ALTER TABLE `following`
  MODIFY `id_follow` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id_like` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id_post` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bans`
--
ALTER TABLE `bans`
  ADD CONSTRAINT `bans_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id_post`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `following`
--
ALTER TABLE `following`
  ADD CONSTRAINT `following_ibfk_1` FOREIGN KEY (`id_followed_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `following_ibfk_2` FOREIGN KEY (`id_follower`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id_post`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
