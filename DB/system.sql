-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 21, 2025 at 10:47 AM
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
-- Database: `system`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_years`
--

CREATE TABLE `academic_years` (
  `id` int(11) NOT NULL,
  `affiliation_id` int(11) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_years`
--

INSERT INTO `academic_years` (`id`, `affiliation_id`, `year`) VALUES
(1, 1, '2022-2023'),
(2, 1, '2023-2024'),
(3, 2, '2021-2022'),
(4, 3, '2020-2021');

-- --------------------------------------------------------

--
-- Table structure for table `affiliation_data`
--

CREATE TABLE `affiliation_data` (
  `id` int(11) NOT NULL,
  `affiliation_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `affiliation_data`
--

INSERT INTO `affiliation_data` (`id`, `affiliation_name`) VALUES
(1, 'University'),
(2, 'AICTE Approved'),
(3, 'UGC Approved'),
(4, 'Private Institution');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `affiliation_id` int(11) DEFAULT NULL,
  `academic_year_id` int(11) DEFAULT NULL,
  `university_option_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `file_path` varchar(255) NOT NULL,
  `office_location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `affiliation_id`, `academic_year_id`, `university_option_id`, `file_name`, `last_modified`, `file_path`, `office_location`) VALUES
(1, 1, 1, 1, 'Affiliation_Doc1.pdf', '2025-02-19 07:22:14', 'uploads/Affiliation_Doc1.pdf', 'Office A1'),
(2, 1, 1, 2, 'Exam_Report.xlsx', '2025-02-19 07:22:14', 'uploads/Exam_Report.xlsx', 'Office B2'),
(3, 2, 3, NULL, 'College_Policy.pdf', '2025-02-19 07:57:08', 'uploads/College_Policy.pdf', 'Office C3'),
(4, 2, NULL, NULL, 'abc descr', '2025-02-19 11:27:48', '../uploads/2nd_semester_Attendance_Report-output.pdf', 'Lab-001/ bookshelf/ A1');

-- --------------------------------------------------------

--
-- Table structure for table `university_options`
--

CREATE TABLE `university_options` (
  `id` int(11) NOT NULL,
  `option_name` varchar(100) NOT NULL,
  `affiliation_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `university_options`
--

INSERT INTO `university_options` (`id`, `option_name`, `affiliation_id`) VALUES
(1, 'CWMS', 1),
(2, 'CET', 1),
(3, 'Registration', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`, `updated_at`) VALUES
(4, 'admin', '$2y$10$ZcDo4wOXi1mQQh2SO5neSO0kAx/C15Yr/CxsGU9eUQNsps5oEDVCq', 'admin@pass.com', '2025-02-18 10:56:47', '2025-02-18 10:56:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliation_id` (`affiliation_id`);

--
-- Indexes for table `affiliation_data`
--
ALTER TABLE `affiliation_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliation_id` (`affiliation_id`),
  ADD KEY `academic_year_id` (`academic_year_id`),
  ADD KEY `university_option_id` (`university_option_id`);

--
-- Indexes for table `university_options`
--
ALTER TABLE `university_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliation_id` (`affiliation_id`);

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
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `affiliation_data`
--
ALTER TABLE `affiliation_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `university_options`
--
ALTER TABLE `university_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD CONSTRAINT `academic_years_ibfk_1` FOREIGN KEY (`affiliation_id`) REFERENCES `affiliation_data` (`id`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`affiliation_id`) REFERENCES `affiliation_data` (`id`),
  ADD CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`),
  ADD CONSTRAINT `documents_ibfk_3` FOREIGN KEY (`university_option_id`) REFERENCES `university_options` (`id`);

--
-- Constraints for table `university_options`
--
ALTER TABLE `university_options`
  ADD CONSTRAINT `university_options_ibfk_1` FOREIGN KEY (`affiliation_id`) REFERENCES `affiliation_data` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
