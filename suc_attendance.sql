-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2019 at 09:04 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `suc_attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `att_id` int(11) NOT NULL,
  `student` int(11) NOT NULL COMMENT 'student usr_id, FK tbl_user',
  `punch_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_verify` tinyint(1) NOT NULL DEFAULT '0',
  `punch_method` int(11) NOT NULL DEFAULT '1' COMMENT '1: scan qr, 2',
  `act_id` int(11) NOT NULL COMMENT 'FK tbl_attendance_activity'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`att_id`, `student`, `punch_time`, `is_verify`, `punch_method`, `act_id`) VALUES
(1, 3, '2019-12-02 14:06:20', 0, 1, 1),
(2, 3, '2019-12-03 04:21:18', 0, 1, 2),
(3, 4, '2019-12-03 04:22:15', 0, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance_activity`
--

CREATE TABLE `tbl_attendance_activity` (
  `act_id` int(11) NOT NULL,
  `time_id` int(11) NOT NULL COMMENT 'which subject time, FK tbl_time',
  `created_by` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ref_text` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_attendance_activity`
--

INSERT INTO `tbl_attendance_activity` (`act_id`, `time_id`, `created_by`, `created_date`, `ref_text`) VALUES
(1, 3, 2, '2019-12-02 09:22:54', 'ehuonf'),
(2, 4, 2, '2019-12-03 04:08:10', '68yxw0'),
(4, 3, 2, '2019-12-01 16:00:00', '000000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class_cancel`
--

CREATE TABLE `tbl_class_cancel` (
  `ccl_id` int(11) NOT NULL,
  `time_id` int(11) NOT NULL,
  `reason` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cancel_date` date NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_class_cancel`
--

INSERT INTO `tbl_class_cancel` (`ccl_id`, `time_id`, `reason`, `cancel_date`, `created_date`, `status_id`) VALUES
(2, 3, NULL, '2019-12-09', '2019-12-03 11:53:15', 1),
(4, 6, NULL, '2019-12-04', '2019-12-04 06:55:37', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_enrollment`
--

CREATE TABLE `tbl_enrollment` (
  `enr_id` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `enroll_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_enrollment`
--

INSERT INTO `tbl_enrollment` (`enr_id`, `student`, `sub_id`, `enroll_date`) VALUES
(1, 3, 1, '2019-09-01 16:00:00'),
(2, 3, 2, '2019-09-01 16:00:00'),
(3, 4, 1, '2019-09-01 16:00:00'),
(4, 4, 2, '2019-09-01 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_semester`
--

CREATE TABLE `tbl_semester` (
  `sem_id` int(11) NOT NULL,
  `sem_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sem_year` int(4) NOT NULL,
  `sem_number` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_semester`
--

INSERT INTO `tbl_semester` (`sem_id`, `sem_name`, `sem_year`, `sem_number`, `start_date`, `end_date`) VALUES
(1, '2019C', 2019, 3, '2019-08-26', '2020-01-05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject`
--

CREATE TABLE `tbl_subject` (
  `sub_id` int(11) NOT NULL,
  `sub_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sub_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lecturer` int(11) NOT NULL,
  `sem_id` int(11) NOT NULL COMMENT 'what semester, refer to tbl_semester'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_subject`
--

INSERT INTO `tbl_subject` (`sub_id`, `sub_name`, `sub_code`, `lecturer`, `sem_id`) VALUES
(1, 'Web Development', 'BTPR2113', 2, 1),
(2, 'Information Security and Assurance', 'BTIS2073', 2, 1),
(3, 'Internet Application', 'ABCD1234', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject_time`
--

CREATE TABLE `tbl_subject_time` (
  `time_id` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `week_day` int(1) NOT NULL COMMENT 'what day have thee class (0-6))',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_subject_time`
--

INSERT INTO `tbl_subject_time` (`time_id`, `sub_id`, `week_day`, `start_time`, `end_time`) VALUES
(1, 1, 1, '13:00:00', '15:00:00'),
(2, 1, 2, '11:00:00', '12:00:00'),
(3, 2, 1, '15:00:00', '23:00:00'),
(4, 2, 2, '12:00:00', '19:00:00'),
(5, 2, 3, '08:00:00', '13:00:00'),
(6, 3, 3, '13:00:00', '23:00:00'),
(7, 3, 4, '09:00:00', '12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `usr_id` int(11) NOT NULL COMMENT 'running number',
  `usr_name` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'login id',
  `usr_password` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `usr_type` int(2) NOT NULL DEFAULT '1' COMMENT '1 : student; 2 : lecturer; 3 : admin',
  `created_by` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status_id` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`usr_id`, `usr_name`, `usr_password`, `full_name`, `phone`, `email`, `usr_type`, `created_by`, `created_date`, `updated_by`, `updated_date`, `status_id`) VALUES
(1, 'admin', '$2y$10$ZhVxWynPKaau.afoqtG9CO5btIrFb19rcAd9lAFX6phbobb.7NbQe', 'Administrator', '', '', 3, 1, '2019-12-02 04:29:06', 1, '2019-12-02 04:29:06', 1),
(2, 'lc001', '$2y$10$ZhVxWynPKaau.afoqtG9CO5btIrFb19rcAd9lAFX6phbobb.7NbQe', 'Lecturer 1', '0198251721', 'lecturer1@mail.com', 2, 1, '2019-12-02 04:30:48', 1, '2019-12-02 04:30:48', 1),
(3, 'B180237C', '$2y$10$ZhVxWynPKaau.afoqtG9CO5btIrFb19rcAd9lAFX6phbobb.7NbQe', 'Yee Jian Xiong', '0000000000', 'jxyee981101@gmail.com', 1, 1, '2019-12-02 05:49:57', 1, '2019-12-02 05:49:57', 1),
(4, 'B180001C', '$2y$10$ZhVxWynPKaau.afoqtG9CO5btIrFb19rcAd9lAFX6phbobb.7NbQe', 'Student 1', '0000000000', 'student1@mail.com', 1, 1, '2019-12-02 14:30:59', 1, '2019-12-02 14:31:10', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`att_id`);

--
-- Indexes for table `tbl_attendance_activity`
--
ALTER TABLE `tbl_attendance_activity`
  ADD PRIMARY KEY (`act_id`);

--
-- Indexes for table `tbl_class_cancel`
--
ALTER TABLE `tbl_class_cancel`
  ADD PRIMARY KEY (`ccl_id`);

--
-- Indexes for table `tbl_enrollment`
--
ALTER TABLE `tbl_enrollment`
  ADD PRIMARY KEY (`enr_id`);

--
-- Indexes for table `tbl_semester`
--
ALTER TABLE `tbl_semester`
  ADD PRIMARY KEY (`sem_id`);

--
-- Indexes for table `tbl_subject`
--
ALTER TABLE `tbl_subject`
  ADD PRIMARY KEY (`sub_id`);

--
-- Indexes for table `tbl_subject_time`
--
ALTER TABLE `tbl_subject_time`
  ADD PRIMARY KEY (`time_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `att_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_attendance_activity`
--
ALTER TABLE `tbl_attendance_activity`
  MODIFY `act_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_class_cancel`
--
ALTER TABLE `tbl_class_cancel`
  MODIFY `ccl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_enrollment`
--
ALTER TABLE `tbl_enrollment`
  MODIFY `enr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_semester`
--
ALTER TABLE `tbl_semester`
  MODIFY `sem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_subject`
--
ALTER TABLE `tbl_subject`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_subject_time`
--
ALTER TABLE `tbl_subject_time`
  MODIFY `time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'running number', AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
