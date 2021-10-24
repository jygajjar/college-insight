-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2021 at 05:32 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `collegeinsight`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `id` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `tid` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `aname` varchar(400) NOT NULL,
  `uploaddate` varchar(50) NOT NULL,
  `lastdate` varchar(50) NOT NULL,
  `amedia` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`id`, `cid`, `tid`, `title`, `aname`, `uploaddate`, `lastdate`, `amedia`) VALUES
(16, 1, 4, 'Tutorial 1', 'C Language new assignment number 1', 'April-17-2021 10:45:46', '2021-04-23', 'vlcsnap-2020-10-02-16h41m36s453.png'),
(17, 2, 4, 'Tutorial 1', 'Assignmetn added java number one 1\r\n', 'April-17-2021 10:46:27', '2021-04-29', 'Capture.JPG'),
(19, 2, 4, 'Tutorial 2', 'Java Assignment number 2. submit it before deadline', 'April-22-2021 12:18:16', '2021-04-29', 'git 1.JPG'),
(20, 2, 4, 'Tutorial 3', 'java assignment for late handed testing', 'April-23-2021 13:10:15', '2021-04-13', 'git 1.JPG'),
(21, 1, 4, 'Tutorial 2', 'this is tutorial 1 description', 'April-23-2021 14:52:13', '2021-04-28', 'images (2).jpeg'),
(25, 3, 4, 'Tutorial 1', 'python first assignment', 'April-24-2021 15:41:20', '2021-04-29', 'KETAN PPR1.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(10) NOT NULL,
  `cname` varchar(50) NOT NULL,
  `tid` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `cname`, `tid`, `datetime`) VALUES
(1, 'C Language', 4, 'April-17-2021 10:38:49'),
(2, 'JAVA', 4, 'April-17-2021 10:38:55'),
(3, 'Python', 4, 'April-17-2021 10:39:14'),
(4, 'Computer Network', 4, 'May-09-2021 14:44:42');

-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

CREATE TABLE `classroom` (
  `id` int(10) NOT NULL,
  `tid` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `sid` int(10) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classroom`
--

INSERT INTO `classroom` (`id`, `tid`, `cid`, `sid`, `status`) VALUES
(1, 4, 1, 1, 'unapproved'),
(2, 4, 2, 1, 'approved'),
(3, 4, 2, 6, 'approved'),
(4, 4, 1, 7, 'approved'),
(7, 4, 3, 1, 'approved'),
(8, 4, 4, 1, 'approved'),
(9, 4, 4, 12, 'unapproved');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `id` bigint(13) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `description` varchar(300) NOT NULL,
  `datetime` datetime(6) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`id`, `fullname`, `email`, `description`, `datetime`, `status`) VALUES
(1, 'Ketan Chavda', 'ketan@gmail.com', 'Nothing', '2021-04-17 11:55:00.000000', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `loginlog`
--

CREATE TABLE `loginlog` (
  `id` int(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `role` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loginlog`
--

INSERT INTO `loginlog` (`id`, `email`, `password`, `ip`, `role`, `status`, `datetime`) VALUES
(1, 'teacher1@gmail.com', 'teacher', '::1', 'Teacher', 'Failed', '2021-04-17 09:58:39'),
(2, 'teacher1@gmail.com', 'teacher@123', '::1', 'Teacher', 'Failed', '2021-04-17 09:58:52'),
(3, 'teacher1@gmail.com', 'Teacher@123', '::1', 'Teacher', 'Failed', '2021-04-17 09:59:05'),
(4, 'teacher1@gmail.com', 'Teacher@123', '::1', 'Teacher', 'Failed', '2021-04-17 09:59:41'),
(5, 'teacher1@gmail.com', 'ea62920343f2ea175f749d7da6ab37', '::1', 'Teacher', 'Success', '2021-04-17 10:00:13'),
(6, 'teacher1@gmail.com', 'Teacher@123', '::1', 'Teacher', 'Failed', '2021-04-17 10:02:32'),
(7, 'teacher1@gmail.com', 'ksjfcs', '::1', 'Teacher', 'Failed', '2021-04-17 10:02:48'),
(8, 'teacher1@gmail.com', 'Teacher@123', '::1', 'Teacher', 'Failed', '2021-04-17 10:03:27'),
(9, 'teacher1@gmail.com', 'Teacher@123', '::1', 'Teacher', 'Failed', '2021-04-17 10:09:02'),
(10, 'teacher1@gmail.com', 'ea62920343f2ea175f749d7da6ab37', '::1', 'Teacher', 'Failed', '2021-04-17 10:10:20'),
(11, 'teacher1@gmail.com', 'TEacher@123', '::1', 'Teacher', 'Failed', '2021-04-17 10:19:25'),
(12, 'std1@gmail.com', 'Student@123', '::1', 'Student', 'Failed', '2021-04-17 10:20:00'),
(13, 'std1@gmail.com', 'Student@123', '::1', 'Student', 'Failed', '2021-04-17 10:20:28'),
(14, 'teacher1@gmail.com', 'Teacher@123', '::1', 'Student', 'Failed', '2021-04-17 10:21:16'),
(15, 'teacher1@gmail.com', 'Teacher@123', '::1', 'Teacher', 'Success', '2021-04-17 10:22:25'),
(16, 'std1@gmail.com', 'Student@123', '::1', 'Student', 'Failed', '2021-04-17 10:22:47'),
(17, 'std1@gmail.com', 'safcdsac', '::1', 'Student', 'Failed', '2021-04-17 10:25:41'),
(18, 'std1@gmail.com', 'Student@123', '::1', 'Student', 'Success', '2021-04-17 10:25:49'),
(19, 'teacher1@gmail.com', 'Teacher@123', '::1', 'Teacher', 'Success', '2021-04-17 10:26:08'),
(20, 'teacher6@gmail.com', 'Teacher@123', '::1', 'Teacher', 'Failed', '2021-04-17 10:27:36'),
(21, 'teacher6@gmail.com', 'Teacher@123', '::1', 'Teacher', 'Failed', '2021-04-17 10:27:52'),
(22, 'teacher6@gmail.com', 'Teacher@123', '::1', 'Teacher', 'Success', '2021-04-17 10:29:20'),
(23, 'std6@gmail.com', 'Student@123', '::1', 'Student', 'Success', '2021-04-17 10:34:52'),
(24, 'teacher1@gmail.com', 'Teacher@123', '::1', 'Teacher', 'Success', '2021-04-17 10:38:38'),
(25, 'std1@gmail.com', 'Student1', '::1', 'Student', 'Failed', '2021-04-17 10:49:43'),
(26, 'std1@gmail.com', 'Student@123', '::1', 'Student', 'Success', '2021-04-17 10:49:51'),
(27, 'teacher1@gmail.com', 'Teacher@123', '::1', 'Teacher', 'Success', '2021-04-17 11:08:21'),
(28, 'std', '', '192.168.43.53', 'Student', 'Failed', '2021-04-17 11:37:56'),
(29, 'std1@gmail.com', 'Student@123', '192.168.43.53', 'Student', 'Success', '2021-04-17 11:38:24'),
(30, 'std1@gmail.com', 'Student@123', '::1', 'Student', 'Success', '2021-04-17 11:50:59'),
(31, 'std1@gmail.com', 'STudent123', '::1', 'Student', 'Failed', '2021-04-22 10:27:03'),
(32, 'std1@gmail.com', 'Student@123', '::1', 'Student', 'Success', '2021-04-22 10:28:18'),
(33, 'teacher1@gmail.com', 'Teacher@123', '::1', 'Student', 'Failed', '2021-04-22 10:30:16'),
(34, 'teacher1@gmail.com', 'Teacher@123', '::1', 'Student', 'Failed', '2021-04-22 10:30:29'),
(35, 'teacher1@gmail.com', 'Teacher123', '::1', 'Student', 'Failed', '2021-04-22 10:30:43'),
(36, 'std1@gmail.com', 'md5(root)', '::1', 'Student', 'Failed', '2021-04-22 10:33:09'),
(37, 'std1@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-04-22 10:35:20'),
(38, 'std1@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-04-22 10:36:51'),
(39, 'std1@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-04-22 10:37:30'),
(40, 'std1@gmail.com', '63a9f0ea7bb98050796b649e854818', '::1', 'Student', 'Failed', '2021-04-22 10:38:11'),
(41, 'std1@gmail.com', '63a9f0ea7bb98050796b649e854818', '::1', 'Student', 'Failed', '2021-04-22 10:39:11'),
(42, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Failed', '2021-04-22 10:40:22'),
(43, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Failed', '2021-04-22 10:40:56'),
(44, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Failed', '2021-04-22 10:41:03'),
(45, 'std1@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-04-22 10:41:20'),
(46, 'std1@gmail.com', 'safdc', '::1', 'Student', 'Failed', '2021-04-22 10:42:32'),
(47, '', '49f0bad299687c62334182178bfd75d8', '::1', 'Student', 'Success', '2021-04-22 10:42:56'),
(48, 'std1@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-04-22 10:44:21'),
(49, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-22 10:45:20'),
(50, 'std1@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-04-22 10:46:10'),
(51, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Failed', '2021-04-22 10:47:26'),
(52, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-22 10:48:10'),
(53, 'teacher1@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-04-22 10:49:31'),
(54, 'teacher1@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-04-22 10:49:42'),
(55, 'teacher1@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-04-22 10:50:18'),
(56, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-22 10:50:35'),
(57, 'teacher1@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-04-22 10:50:57'),
(58, 'teacher1@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-04-22 10:52:07'),
(59, 'teacher1@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-04-22 10:52:30'),
(60, 'teacher1@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-04-22 10:54:13'),
(61, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-22 11:32:01'),
(62, 'std2@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-22 12:02:47'),
(63, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-22 12:03:04'),
(64, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-22 12:14:06'),
(65, 'teacher1@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-04-22 12:14:24'),
(66, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-22 12:15:22'),
(67, 'teacher1@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-04-22 12:17:48'),
(68, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-22 12:19:13'),
(69, 'teacher1@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-04-22 13:23:27'),
(70, 'teacher1@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-04-23 11:49:40'),
(71, 'teacher1@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-04-23 11:50:15'),
(72, 'teacher1@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-04-23 14:28:18'),
(73, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '192.168.43.35', 'Student', 'Success', '2021-04-23 14:48:17'),
(74, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-23 15:04:11'),
(75, 'teacher1@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-04-23 23:00:18'),
(76, 'teacher1@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-04-23 23:02:39'),
(77, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-23 23:06:30'),
(78, 'teacher1@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-04-23 23:09:51'),
(79, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-23 23:18:20'),
(80, 'std1@gmail.com', 'root', '::1', 'Teacher', 'Failed', '2021-04-24 10:40:52'),
(81, 'teacher1@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-04-24 10:41:35'),
(82, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-24 13:23:43'),
(83, 'teacher1@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-04-24 13:50:49'),
(84, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-24 17:18:41'),
(85, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-25 09:42:10'),
(86, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-25 14:07:35'),
(87, 'teacher1@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-04-25 14:59:21'),
(88, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-25 19:25:14'),
(89, 'teacher1@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-04-25 19:28:10'),
(90, 'teacher1@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-04-25 19:28:21'),
(91, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-25 19:34:23'),
(92, 'std1@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-25 19:44:02'),
(93, 'Maria@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-04-26 19:14:55'),
(94, 'Maria@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-04-26 19:15:19'),
(95, 'Jill@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-04-26 19:18:33'),
(96, 'teacher1@gmail.com', 'root', '::1', 'Teacher', 'Failed', '2021-05-04 10:35:24'),
(97, 'Jill@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-05-04 10:36:17'),
(98, 'Maria@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-05-04 10:36:49'),
(99, 'Yoshi@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-05-04 10:45:51'),
(100, 'Ketan@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-05-09 13:27:42'),
(101, 'Ketan@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-05-09 13:58:38'),
(102, 'Yoshi@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-05-09 14:01:11'),
(103, 'John@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-05-09 14:42:07'),
(104, 'Ketan@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-05-09 14:43:06'),
(105, 'John@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-05-09 14:43:59'),
(106, 'Ketan@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-05-09 14:45:37'),
(107, 'teacher@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-05-09 14:48:59'),
(108, 'John@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-05-10 09:23:25'),
(109, 'ketanchavda171@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-05-10 09:35:50'),
(110, 'Ketan@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-05-10 09:46:32'),
(111, 'John@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-05-10 09:47:37'),
(112, 'John@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-05-10 09:47:45'),
(113, 'John@gmail.com', 'root', '::1', 'Student', 'Failed', '2021-05-10 09:50:35'),
(114, 'Ketan@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-05-10 09:50:42'),
(115, 'John@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-05-10 10:12:50'),
(116, 'teacher@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-05-10 10:15:57'),
(117, 'John@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-05-10 10:22:22'),
(118, 'teacher@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-05-10 10:22:41'),
(119, 'John@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-05-10 10:30:58'),
(120, 'teacher@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-05-10 10:31:55'),
(121, 'Ketan@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-05-10 10:33:33'),
(122, 'teacher@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-05-10 10:33:49'),
(123, 'teacher@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-05-10 10:51:30'),
(124, 'John@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-05-10 10:51:54'),
(125, 'Ketan@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-05-10 10:55:27'),
(126, 'ketanchavda171@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-05-10 11:13:02'),
(127, 'Ketan@gmail.com', '63a9f0ea7bb98050796b649e85481845', '::1', 'Student', 'Success', '2021-05-10 11:14:44'),
(128, 'John@gmail.com', 'root', '::1', 'Teacher', 'Success', '2021-05-10 11:16:34');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `textcontent` varchar(3000) NOT NULL,
  `datetime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `cid`, `textcontent`, `datetime`) VALUES
(23, 1, 'C language notification number one', 'April-17-2021 10:41:20'),
(24, 2, 'JAva notification number one.CollegeInsight is a free collaboration tool for teachers and students.Using College insight, students and teachers can reach out to one another and connect by sharing ideas, problems, and helpful tips.', 'April-17-2021 10:41:38');

-- --------------------------------------------------------

--
-- Table structure for table `std_work`
--

CREATE TABLE `std_work` (
  `id` int(10) NOT NULL,
  `aid` int(10) NOT NULL,
  `sid` int(10) NOT NULL,
  `attachment` varchar(30) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `lastdate` varchar(30) NOT NULL,
  `datetime` varchar(30) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `std_work`
--

INSERT INTO `std_work` (`id`, `aid`, `sid`, `attachment`, `description`, `lastdate`, `datetime`, `status`) VALUES
(9, 16, 1, 'git 1.JPG', 'c language submitted', '2021-04-23', 'April-22-2021 12:57:50', 'approved'),
(11, 17, 1, 'images (2).jpeg', 'xfcghjkb', '2021-04-29', 'April-23-2021 23:07:58', 'disapproved'),
(13, 19, 1, 'KETAN PPR1.pdf', '', '2021-04-29', 'April-25-2021 10:49:32', 'disapproved');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `bio` varchar(500) NOT NULL,
  `profilephoto` varchar(30) NOT NULL,
  `vkey` varchar(100) NOT NULL,
  `verified` int(10) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `email`, `password`, `firstname`, `lastname`, `bio`, `profilephoto`, `vkey`, `verified`, `datetime`) VALUES
(1, 'Ketan@gmail.com', '63a9f0ea7bb98050796b649e85481845', 'Ketan', 'Chavda', 'i am best student .\r\n', 'images (4).jpeg', '9346d9a4410213f816a20398277040df', 1, '2021-04-17 09:30:49'),
(6, 'Francisco@gmail.com', '63a9f0ea7bb98050796b649e85481845', 'Francisco ', 'Chang', '', 'avatar.png', 'e507d049b4f3275aa904df4d42fa0dca', 1, '2021-04-17 09:45:13'),
(7, 'Roland@gmail.com', '63a9f0ea7bb98050796b649e85481845', 'Roland', 'Mendel', '', 'avatar.png', '7db405588832a74d9c70b81b1afaec96', 1, '2021-04-17 09:45:36'),
(8, 'Helenstd4@gmail.com', '63a9f0ea7bb98050796b649e85481845', 'Helen ', 'Tannamuri', '', 'avatar.png', '7c942dd295d6c046421dda51cfd2a122', 1, '2021-04-17 09:46:04'),
(9, 'Yoshi@gmail.com', '63a9f0ea7bb98050796b649e85481845', 'Yoshi ', 'Bennett', '', 'avatar.png', '45f7430972339138e6a15785a90948c0', 1, '2021-04-17 09:46:21'),
(12, 'ketanchavda171@gmail.com', '63a9f0ea7bb98050796b649e85481845', 'Ketan', 'Chavda', '', 'avatar.png', 'ca69da00e9a6a6af01fe550c0d56d306', 1, '2021-05-10 11:12:06');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `bio` varchar(10000) NOT NULL,
  `profilephoto` varchar(30) NOT NULL,
  `status` varchar(50) NOT NULL,
  `vkey` varchar(100) NOT NULL,
  `verified` int(10) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `email`, `password`, `firstname`, `lastname`, `bio`, `profilephoto`, `status`, `vkey`, `verified`, `datetime`) VALUES
(4, 'John@gmail.com', '63a9f0ea7bb98050796b649e85481845', 'John', 'Doe', 'I am Teacher One. aaaaa', 'images (2).jpeg', '', '0ef4acea37e9444517349183b9b87238', 1, '2021-04-17 09:55:10'),
(5, 'Eve@gmail.com', '63a9f0ea7bb98050796b649e85481845', 'Eve', 'Jackson', '', 'avatar.png', '', 'ead09ec8507ad08799aac74259a810ae', 1, '2021-04-17 09:55:38'),
(6, 'Jill@gmail.com', '63a9f0ea7bb98050796b649e85481845', 'Jill', 'Smith', '', 'avatar.png', '', 'd8d4fee0bbde356138fce0d892c3afae', 1, '2021-04-17 09:55:59'),
(7, 'Bill@gmail.com', '63a9f0ea7bb98050796b649e85481845', 'Bill', 'Gates', '', 'avatar.png', '', '365ca28caa26722e9a528e341b02f7f2', 1, '2021-04-17 09:56:21'),
(9, 'teacher@gmail.com', '63a9f0ea7bb98050796b649e85481845', 'Teacher', 'Test', '', 'avatar.png', '', '5687ee4412e10a6ff39ddc0a2968c199', 1, '2021-04-17 10:28:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loginlog`
--
ALTER TABLE `loginlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `std_work`
--
ALTER TABLE `std_work`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `classroom`
--
ALTER TABLE `classroom`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` bigint(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loginlog`
--
ALTER TABLE `loginlog`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `std_work`
--
ALTER TABLE `std_work`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `cleaning` ON SCHEDULE EVERY 1 MINUTE STARTS '2020-10-18 14:42:22' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM student WHERE verified='0' AND datetime < (NOW() - INTERVAL 600 second)$$

CREATE DEFINER=`root`@`localhost` EVENT `cleaning_teacher` ON SCHEDULE EVERY 1 MINUTE STARTS '2020-10-18 15:38:41' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM teacher WHERE verified='0' AND datetime < (NOW() - INTERVAL 600 second)$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
