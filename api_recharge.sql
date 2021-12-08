-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2021 at 03:46 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api_recharge`
--

-- --------------------------------------------------------

--
-- Table structure for table `gsm`
--

CREATE TABLE `gsm` (
  `id` int(10) UNSIGNED NOT NULL,
  `systype` varchar(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `phone` int(11) NOT NULL,
  `operator` varchar(16) NOT NULL,
  `port` varchar(6) NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL,
  `ussdsend` varchar(60) NOT NULL,
  `ussdbalance` varchar(60) NOT NULL,
  `isactive` int(11) NOT NULL DEFAULT 1 COMMENT '1=active\r\n0=disabled',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gsm`
--

INSERT INTO `gsm` (`id`, `systype`, `name`, `phone`, `operator`, `port`, `userid`, `ussdsend`, `ussdbalance`, `isactive`, `created_date`) VALUES
(1, 'recharge', 'Nias', 15215482, 'Aritel', 'com97', 1, '85421', '953251', 1, '2021-12-02 02:03:23'),
(2, 'recharge', 'good bye', 1966885733, 'Aritel', 'com9', 1, '854125', '965215', 1, '2021-12-02 02:03:44'),
(4, 'recharge', 'comad', 1966885732, 'Aritel', 'com8', 1, '98562', '7850', 1, '2021-12-02 02:04:25'),
(5, 'recharge', 'new entry', 14521521, 'Banglalink', 'com7', 1, '*111*@phone*@amount*1251*2£', '*1115£', 1, '2021-12-02 02:16:02'),
(6, 'banking', 'arrivals', 1714358448, 'Aritel', 'com6', 1, '45215\"', 'dsfasd', 1, '2021-12-02 02:17:27'),
(7, 'banking', 'testing', 181254152, 'Banglalink', 'com90', 1, 'fasf', 'asdf', 1, '2021-12-02 02:21:04');

-- --------------------------------------------------------

--
-- Table structure for table `received`
--

CREATE TABLE `received` (
  `id` int(10) UNSIGNED NOT NULL,
  `gsmid` int(10) UNSIGNED NOT NULL,
  `message` varchar(120) NOT NULL,
  `receivedtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `created_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `received`
--

INSERT INTO `received` (`id`, `gsmid`, `message`, `receivedtime`, `created_time`) VALUES
(1, 1, 'hello world', '2021-12-02 15:41:01', '2021-12-02 15:41:16');

-- --------------------------------------------------------

--
-- Table structure for table `sent`
--

CREATE TABLE `sent` (
  `id` int(10) UNSIGNED NOT NULL,
  `gsmid` int(10) UNSIGNED NOT NULL,
  `phone` varchar(26) NOT NULL,
  `amount` double NOT NULL,
  `note` varchar(30) DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `sendingtime` datetime NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sent`
--

INSERT INTO `sent` (`id`, `gsmid`, `phone`, `amount`, `note`, `userid`, `sendingtime`, `created_time`) VALUES
(1, 2, '1996668857', 60, NULL, 1, '2021-12-02 12:29:52', '2021-12-02 12:29:52'),
(2, 1, '1823874659', 60, NULL, 1, '2021-12-02 12:45:45', '2021-12-02 12:45:45'),
(3, 4, '1535215421', 99, NULL, 1, '2021-12-02 12:46:05', '2021-12-02 12:46:05'),
(4, 5, '1415215210', 40, NULL, 1, '2021-12-02 12:46:47', '2021-12-02 12:46:47'),
(5, 1, '1714358448', 50, NULL, 1, '2021-12-02 13:02:11', '2021-12-02 13:02:11'),
(6, 1, '1966885733', 50, NULL, 1, '2021-12-02 13:02:37', '2021-12-02 13:02:37'),
(7, 1, '18000000', 88, NULL, 1, '2021-12-02 13:04:30', '2021-12-02 13:04:30'),
(8, 1, '1966885733', 60, NULL, 1, '2021-12-02 13:07:54', '2021-12-02 13:07:54'),
(9, 1, '1111111111', 1010, NULL, 1, '2021-12-02 13:37:54', '2021-12-02 13:37:54'),
(10, 1, '900000', 49, NULL, 1, '2021-12-02 13:38:56', '2021-12-02 13:38:56'),
(11, 2, '182654800', 12, NULL, 1, '2021-12-02 14:17:23', '2021-12-02 14:17:23'),
(12, 6, '1966885733', 5000, NULL, 1, '2021-12-02 14:27:33', '2021-12-02 14:27:33'),
(13, 7, '1823874659', 9000, NULL, 1, '2021-12-02 14:28:20', '2021-12-02 14:28:20'),
(14, 6, '714358448', 20000, NULL, 1, '2021-12-02 14:30:17', '2021-12-02 14:30:17'),
(15, 7, '1714358448', 9200, NULL, 1, '2021-12-02 14:30:48', '2021-12-02 14:30:48'),
(16, 1, '1966885733', 20, NULL, 1, '2021-12-02 15:54:37', '2021-12-02 15:54:38');

-- --------------------------------------------------------

--
-- Table structure for table `sent_log`
--

CREATE TABLE `sent_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `gsm_id` int(10) UNSIGNED NOT NULL,
  `sent_id` int(10) UNSIGNED DEFAULT NULL,
  `message` varchar(67) NOT NULL,
  `received_time` datetime NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `photo` varchar(20) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `photo`, `username`, `password`, `created_date`) VALUES
(1, 'Farjan', NULL, NULL, NULL, 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2021-12-01 14:13:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gsm`
--
ALTER TABLE `gsm`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `port` (`port`);

--
-- Indexes for table `received`
--
ALTER TABLE `received`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sent`
--
ALTER TABLE `sent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sent_log`
--
ALTER TABLE `sent_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gsm`
--
ALTER TABLE `gsm`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `received`
--
ALTER TABLE `received`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sent`
--
ALTER TABLE `sent`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sent_log`
--
ALTER TABLE `sent_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
