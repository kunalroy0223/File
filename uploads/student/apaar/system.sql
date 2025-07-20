-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 20, 2025 at 08:41 AM
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
-- Table structure for table `batch_years`
--

CREATE TABLE `batch_years` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch_years`
--

INSERT INTO `batch_years` (`id`, `year`) VALUES
(1, 2018),
(2, 2019),
(3, 2020);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(1, 'BCA'),
(2, 'BMAGD'),
(3, 'BBA GB'),
(4, 'BB ATA');

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
(4, 2, NULL, NULL, 'abc descr', '2025-02-19 11:27:48', '../uploads/2nd_semester_Attendance_Report-output.pdf', 'Lab-001/ bookshelf/ A1'),
(23, 1, 2, 1, 'Sourasish roy Resume draft 1.pdf', '2025-07-19 20:19:12', 'uploads/affiliation/1/2/1/Sourasish roy Resume draft 1.pdf', 'gdg'),
(24, 1, 2, 1, 'Sourasish roy Resume draft 1.pdf', '2025-07-19 20:21:05', 'uploads/affiliation/1/2/1/Sourasish roy Resume draft 1.pdf', 'rk'),
(25, 1, 3, 1, 'Sourasish roy Resume draft 1.pdf', '2025-07-19 20:24:14', 'uploads/affiliation/1/3/1/Sourasish roy Resume draft 1.pdf', 'dfwe'),
(26, 2, 2, NULL, 'Sourasish roy Resume draft 1.pdf', '2025-07-20 03:25:08', 'uploads/affiliation/2/2/Sourasish roy Resume draft 1.pdf', 'gb'),
(27, 3, 2, NULL, 'Sourasish roy Resume draft 1.pdf', '2025-07-20 03:25:36', 'uploads/affiliation/3/2/Sourasish roy Resume draft 1.pdf', 'gnn'),
(28, 4, 2, NULL, 'Sourasish roy Resume draft 1.pdf', '2025-07-20 03:28:08', 'uploads/affiliation/4/2/Sourasish roy Resume draft 1.pdf', 'csc'),
(29, 4, 3, NULL, 'Sourasish roy Resume draft 1.pdf', '2025-07-20 03:28:45', 'uploads/affiliation/4/3/Sourasish roy Resume draft 1.pdf', 'wd'),
(30, 4, 1, NULL, 'Sourasish roy Resume draft 1.pdf', '2025-07-20 03:32:09', 'uploads/affiliation/4/1/Sourasish roy Resume draft 1.pdf', 'dd'),
(31, 2, 2, NULL, 'Sourasish roy Resume draft 1.pdf', '2025-07-20 03:35:37', 'uploads/affiliation/2/2/Sourasish roy Resume draft 1.pdf', 'edw'),
(32, 3, 2, NULL, 'Sourasish roy Resume draft 1.pdf', '2025-07-20 03:38:55', 'uploads/affiliation/3/2/Sourasish roy Resume draft 1.pdf', 'x'),
(33, 4, 4, NULL, 'Sourasish roy Resume draft 1.pdf', '2025-07-20 03:39:54', 'uploads/affiliation/4/4/Sourasish roy Resume draft 1.pdf', 'c'),
(34, 3, 1, NULL, 'Sourasish roy Resume draft 1.pdf', '2025-07-20 03:41:26', 'uploads/affiliation/3/1/Sourasish roy Resume draft 1.pdf', 'qs'),
(35, 2, 1, NULL, 'Sourasish roy Resume draft 1.pdf', '2025-07-20 03:41:54', 'uploads/affiliation/2/1/Sourasish roy Resume draft 1.pdf', 'fbv'),
(36, 3, 2, NULL, 'Sourasish roy Resume draft 1.pdf', '2025-07-20 06:28:50', 'uploads/affiliation/3/2/Sourasish roy Resume draft 1.pdf', 'da');

-- --------------------------------------------------------

--
-- Table structure for table `examination_files`
--

CREATE TABLE `examination_files` (
  `id` int(11) NOT NULL,
  `academic_year` varchar(9) NOT NULL,
  `semester_type` enum('Odd','Even') NOT NULL,
  `main_category` enum('Assessment Type','End Sem','Enrollment','Results') NOT NULL,
  `assessment_component` enum('CA1','CA2','CA3','CA4','PCA1','PCA2') DEFAULT NULL,
  `endsem_component` enum('Theory','Practical','Exam Form Fill Up') DEFAULT NULL,
  `theory_subcomponent` enum('Seating Allotment','Attendance','Routine') DEFAULT NULL,
  `enrollment_type` enum('Regular','Backlog') DEFAULT NULL,
  `results_type` enum('Regular','Backlog') DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examination_files`
--

INSERT INTO `examination_files` (`id`, `academic_year`, `semester_type`, `main_category`, `assessment_component`, `endsem_component`, `theory_subcomponent`, `enrollment_type`, `results_type`, `file_name`, `file_path`, `uploaded_at`) VALUES
(1, '2024-2025', 'Odd', 'End Sem', NULL, 'Theory', 'Seating Allotment', NULL, NULL, 'Sourasish roy Resume draft 1.pdf', 'uploads/examination/2024-2025/Odd/End Sem/Theory/Seating Allotment/Sourasish roy Resume draft 1.pdf', '2025-07-19 19:43:29'),
(2, '2024-2025', 'Odd', 'Assessment Type', 'CA1', NULL, NULL, NULL, NULL, 'Sourasish roy Resume draft 1.pdf', 'uploads/examination/2024-2025/Odd/Assessment Type/CA1/Sourasish roy Resume draft 1.pdf', '2025-07-19 19:58:04');

-- --------------------------------------------------------

--
-- Table structure for table `government_scholarship_subtypes`
--

CREATE TABLE `government_scholarship_subtypes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `government_scholarship_subtypes`
--

INSERT INTO `government_scholarship_subtypes` (`id`, `name`) VALUES
(1, 'SVMCN'),
(2, 'WBSC'),
(3, 'NSP'),
(4, 'WBMDFC'),
(5, 'E-KALYAN');

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_types`
--

CREATE TABLE `scholarship_types` (
  `id` int(11) NOT NULL,
  `type` enum('government','in_house') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholarship_types`
--

INSERT INTO `scholarship_types` (`id`, `type`) VALUES
(1, 'government'),
(2, 'in_house');

-- --------------------------------------------------------

--
-- Table structure for table `student_files`
--

CREATE TABLE `student_files` (
  `id` int(11) NOT NULL,
  `manage_type` enum('student_list','scholarship','apaar') NOT NULL,
  `batch_year_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `scholarship_type_id` int(11) DEFAULT NULL,
  `govt_scholarship_subtype_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `batch_years`
--
ALTER TABLE `batch_years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `year` (`year`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
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
-- Indexes for table `examination_files`
--
ALTER TABLE `examination_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `government_scholarship_subtypes`
--
ALTER TABLE `government_scholarship_subtypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scholarship_types`
--
ALTER TABLE `scholarship_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_files`
--
ALTER TABLE `student_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batch_year_id` (`batch_year_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `scholarship_type_id` (`scholarship_type_id`),
  ADD KEY `govt_scholarship_subtype_id` (`govt_scholarship_subtype_id`);

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
-- AUTO_INCREMENT for table `batch_years`
--
ALTER TABLE `batch_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `examination_files`
--
ALTER TABLE `examination_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `government_scholarship_subtypes`
--
ALTER TABLE `government_scholarship_subtypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `scholarship_types`
--
ALTER TABLE `scholarship_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_files`
--
ALTER TABLE `student_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `student_files`
--
ALTER TABLE `student_files`
  ADD CONSTRAINT `student_files_ibfk_1` FOREIGN KEY (`batch_year_id`) REFERENCES `batch_years` (`id`),
  ADD CONSTRAINT `student_files_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `student_files_ibfk_3` FOREIGN KEY (`scholarship_type_id`) REFERENCES `scholarship_types` (`id`),
  ADD CONSTRAINT `student_files_ibfk_4` FOREIGN KEY (`govt_scholarship_subtype_id`) REFERENCES `government_scholarship_subtypes` (`id`);

--
-- Constraints for table `university_options`
--
ALTER TABLE `university_options`
  ADD CONSTRAINT `university_options_ibfk_1` FOREIGN KEY (`affiliation_id`) REFERENCES `affiliation_data` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
