-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2025 at 08:59 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrmis`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Table structure for table `appleave`
--

CREATE TABLE `appleave` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
--   `office` varchar(250) DEFAULT NULL, 
--   `firstname` varchar(250) DEFAULT NULL,
--   `lastname` varchar(250) DEFAULT NULL,
--   `middlename` varchar(250) DEFAULT NULL,
  `dateofFilling` date NOT NULL,
--   `position` varchar(250) DEFAULT NULL,
--   `salary` varchar(250) DEFAULT NULL,
  `typeofLeave` varchar(250) NOT NULL,
  `others` varchar(250) NOT NULL,
  `vacationleave` varchar(250) NOT NULL,
  `sickleave` varchar(250) NOT NULL,
  `specialleave` varchar(250) NOT NULL,
  `studyleave` varchar(250) DEFAULT NULL,
  `otherpurpose` varchar(250) DEFAULT NULL,
  `numberofWork` varchar(250) NOT NULL,
  `inclusiveDate_from` date NOT NULL,
  `inclusiveDate_to` date NOT NULL,
  `commutation` varchar(250) DEFAULT NULL,
  `certificationofLeave` date NOT NULL,
  `vacationTotal` varchar(250) NOT NULL,
  `vacationLess` varchar(250) NOT NULL,
  `vacationBalance` varchar(250) NOT NULL,
  `sickTotal` varchar(250) NOT NULL,
  `sickLess` varchar(250) NOT NULL,
  `sickBalance` varchar(250) NOT NULL,
  `recommendation` varchar(250) NOT NULL,
  `forDisapproval` varchar(250) NOT NULL,
  `approved` varchar(250) NOT NULL,
  `disapproved` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Table structure for table `civil_service_eligibility`
--

CREATE TABLE `civil_service_eligibility` (
  `id` int(11) NOT NULL,
  `employee_no` varchar(255) NOT NULL,
  `career` varchar(255) NOT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `date_exam` date DEFAULT NULL,
  `place_exam` varchar(255) DEFAULT NULL,
  `license_no` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Table structure for table `educational_background`
--

CREATE TABLE `educational_background` (
  `id` int(11) NOT NULL,
  `employee_no` varchar(255) DEFAULT NULL,
  `elementary` varchar(255) DEFAULT NULL,
  `elem_degree` varchar(255) DEFAULT NULL,
  `elem_period` varchar(255) DEFAULT NULL,
  `elem_level` varchar(255) DEFAULT NULL,
  `elem_year` varchar(255) DEFAULT NULL,
  `elem_acad` varchar(255) DEFAULT NULL,
  `secondary` varchar(255) DEFAULT NULL,
  `sec_degree` varchar(255) DEFAULT NULL,
  `sec_period` varchar(255) DEFAULT NULL,
  `sec_level` varchar(255) DEFAULT NULL,
  `sec_year` varchar(255) DEFAULT NULL,
  `sec_acad` varchar(255) DEFAULT NULL,
  `vocational` varchar(255) DEFAULT NULL,
  `voc_degree` varchar(255) DEFAULT NULL,
  `voc_period` varchar(255) DEFAULT NULL,
  `voc_level` varchar(255) DEFAULT NULL,
  `voc_year` varchar(255) DEFAULT NULL,
  `voc_acad` varchar(255) DEFAULT NULL,
  `college` varchar(255) DEFAULT NULL,
  `col_degree` varchar(255) DEFAULT NULL,
  `col_period` varchar(255) DEFAULT NULL,
  `col_level` varchar(255) DEFAULT NULL,
  `col_year` varchar(255) DEFAULT NULL,
  `col_acad` varchar(255) DEFAULT NULL,
  `graduate` varchar(255) DEFAULT NULL,
  `grad_degree` varchar(255) DEFAULT NULL,
  `grad_period` varchar(255) DEFAULT NULL,
  `grad_level` varchar(255) DEFAULT NULL,
  `grad_year` varchar(255) DEFAULT NULL,
  `grad_acad` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Table structure for table `emergency_contacts`
--

CREATE TABLE `emergency_contacts` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `person_name` varchar(255) NOT NULL,
  `relationship` varchar(255) NOT NULL,
  `tel_no` varchar(25) NOT NULL,
  `e_street` varchar(255) NOT NULL,
  `e_barangay` varchar(255) NOT NULL,
  `e_city` varchar(255) NOT NULL,
  `e_province` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_no` varchar(255) NOT NULL,
  `date_hired` date NOT NULL,
  `status` enum('Coterminous','Permanent','Elected','Temporary') NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `extension_name` varchar(50) DEFAULT NULL,
  `sex` enum('male','female') NOT NULL,
  `civil_status` enum('single','married','widowed','separated') NOT NULL,
  `birth_date` date NOT NULL,
  `birth_place` varchar(255) NOT NULL,
  `contact_number` varchar(25) NOT NULL,
  `height` decimal(5,2) NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `educational_attainment` enum('college_graduate','vocational','highschool_graduate','masteral_graduate','vocational_trade_course') NOT NULL,
  `course` varchar(255) DEFAULT NULL,
  `blood_type` enum('A+','A-','B+','B-','O+','O-','AB+','AB-') NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `spouse_name` varchar(255) DEFAULT NULL,
  `spouse_occupation` varchar(255) DEFAULT NULL,
  `employee_type` enum('permanent','jo') NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `salary_grade` varchar(50) NOT NULL,
  `step` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- Table structure for table `family_info`
--

CREATE TABLE `family_info` (
  `id` int(11) NOT NULL,
  `employee_no` varchar(255) DEFAULT NULL,
  `spouse_sname` varchar(255) DEFAULT NULL,
  `spouse_fname` varchar(255) DEFAULT NULL,
  `spouse_mname` varchar(255) DEFAULT NULL,
  `spouse_ext` varchar(50) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `bussAdd` varchar(255) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `father_sname` varchar(255) DEFAULT NULL,
  `father_fname` varchar(255) DEFAULT NULL,
  `father_mname` varchar(255) DEFAULT NULL,
  `mothers_sname` varchar(255) DEFAULT NULL,
  `mothers_fname` varchar(255) DEFAULT NULL,
  `mothers_mname` varchar(255) DEFAULT NULL,
  `child1_name` varchar(255) DEFAULT NULL,
  `child1_birth` date DEFAULT NULL,
  `child2_name` varchar(255) DEFAULT NULL,
  `child2_birth` date DEFAULT NULL,
  `child3_name` varchar(255) DEFAULT NULL,
  `child3_birth` date DEFAULT NULL,
  `child4_name` varchar(255) DEFAULT NULL,
  `child4_birth` date DEFAULT NULL,
  `child5_name` varchar(255) DEFAULT NULL,
  `child5_birth` date DEFAULT NULL,
  `child6_name` varchar(255) DEFAULT NULL,
  `child6_birth` date DEFAULT NULL,
  `child7_name` varchar(255) DEFAULT NULL,
  `child7_birth` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

--
-- Table structure for table `government_ids`
--

CREATE TABLE `government_ids` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `gsis_number` varchar(50) DEFAULT NULL,
  `sss_number` varchar(50) DEFAULT NULL,
  `tin_number` varchar(255) DEFAULT NULL,
  `philhealth_number` varchar(50) DEFAULT NULL,
  `pagibig_number` varchar(50) DEFAULT NULL,
  `eligibility` varchar(255) DEFAULT NULL,
  `prc_number` varchar(50) DEFAULT NULL,
  `prc_expiry_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-------------------------------------------------

--
-- Table structure for table `joborder`
--

CREATE TABLE `joborder` (
  `id` int(11) NOT NULL,
  `csc` varchar(250) NOT NULL,
  `sname` varchar(250) NOT NULL,
  `fname` varchar(250) NOT NULL,
  `mname` varchar(250) NOT NULL,
  `extension` varchar(250) NOT NULL,
  `datebirth` date NOT NULL,
  `placebirth` varchar(250) NOT NULL,
  `sex` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL,
  `height` varchar(250) NOT NULL,
  `weight` varchar(250) NOT NULL,
  `bloodtype` varchar(250) NOT NULL,
  `gsis` int(250) NOT NULL,
  `pagIbig` varchar(100) NOT NULL,
  `philhealth` int(100) NOT NULL,
  `sss` int(100) NOT NULL,
  `tin` int(100) NOT NULL,
  `agency` int(100) NOT NULL,
  `citizenship` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `house` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `subdivision` varchar(100) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `zipcode` int(100) NOT NULL,
  `permaHouse` varchar(100) NOT NULL,
  `permaStreet` varchar(100) NOT NULL,
  `permaSub` varchar(100) NOT NULL,
  `permaBarangay` varchar(100) NOT NULL,
  `permaCity` varchar(100) NOT NULL,
  `permaProvince` varchar(100) NOT NULL,
  `permaZip` int(100) NOT NULL,
  `telno` int(100) NOT NULL,
  `mobileno` int(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `spouseSur` varchar(100) NOT NULL,
  `spouseFname` varchar(100) NOT NULL,
  `spouseMname` varchar(100) NOT NULL,
  `spouseEx` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `businessName` varchar(100) NOT NULL,
  `businessAdd` varchar(100) NOT NULL,
  `telephone` int(100) NOT NULL,
  `fatherSur` varchar(100) NOT NULL,
  `fatherFname` varchar(100) NOT NULL,
  `fatherMname` varchar(100) NOT NULL,
  `fatherEx` varchar(100) NOT NULL,
  `motherSur` varchar(100) NOT NULL,
  `motherFname` varchar(100) NOT NULL,
  `motherMname` varchar(100) NOT NULL,
  `nameofchildren` varchar(200) NOT NULL,
  `dob` date NOT NULL,
  `elementary` varchar(100) NOT NULL,
  `elemDegree` varchar(100) NOT NULL,
  `elemPeriod` varchar(100) NOT NULL,
  `elemLevel` varchar(100) NOT NULL,
  `elemYear` varchar(100) NOT NULL,
  `elemAcad` varchar(100) NOT NULL,
  `secondary` varchar(100) NOT NULL,
  `secDegree` varchar(100) NOT NULL,
  `secPeriod` varchar(100) NOT NULL,
  `secLevel` varchar(100) NOT NULL,
  `secYear` varchar(100) NOT NULL,
  `secAcad` varchar(100) NOT NULL,
  `vocational` varchar(100) NOT NULL,
  `vocDegree` varchar(100) NOT NULL,
  `vocPeriod` varchar(100) NOT NULL,
  `vocLevel` varchar(100) NOT NULL,
  `vocYear` varchar(100) NOT NULL,
  `vocAcad` varchar(100) NOT NULL,
  `college` varchar(100) NOT NULL,
  `colDegree` varchar(100) NOT NULL,
  `colPeriod` varchar(100) NOT NULL,
  `colLevel` varchar(100) NOT NULL,
  `colYear` varchar(100) NOT NULL,
  `colAcad` varchar(100) NOT NULL,
  `graduate` varchar(100) NOT NULL,
  `gradDegree` varchar(100) NOT NULL,
  `gradPeriod` varchar(100) NOT NULL,
  `gradLevel` varchar(100) NOT NULL,
  `gradYear` varchar(100) NOT NULL,
  `gradAcad` varchar(100) NOT NULL,
  `career` varchar(100) NOT NULL,
  `ratings` varchar(100) NOT NULL,
  `dateofexam` varchar(100) NOT NULL,
  `placeofexam` varchar(100) NOT NULL,
  `licenseNum` varchar(100) NOT NULL,
  `incluFrom` date NOT NULL,
  `incluTo` date NOT NULL,
  `positionTitle` varchar(100) NOT NULL,
  `daoc` varchar(100) NOT NULL,
  `monthlySalary` int(100) NOT NULL,
  `sop` varchar(100) NOT NULL,
  `statusApp` varchar(100) NOT NULL,
  `govService` varchar(100) NOT NULL,
  `nameAdd` varchar(100) NOT NULL,
  `inclusive` varchar(100) NOT NULL,
  `numberofHour` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `titleofLearning` varchar(100) NOT NULL,
  `incluAttendance` varchar(100) NOT NULL,
  `numberHours` varchar(100) NOT NULL,
  `typeID` varchar(100) NOT NULL,
  `conducted` varchar(100) NOT NULL,
  `specialSkills` varchar(100) NOT NULL,
  `recognition` varchar(100) NOT NULL,
  `membership` varchar(100) NOT NULL,
  `third` varchar(100) NOT NULL,
  `fourth` varchar(100) NOT NULL,
  `guilty` varchar(100) NOT NULL,
  `criminal` varchar(100) NOT NULL,
  `convicted` varchar(100) NOT NULL,
  `seperated` varchar(100) NOT NULL,
  `candidate` varchar(100) NOT NULL,
  `resigned` varchar(100) NOT NULL,
  `acquired` varchar(100) NOT NULL,
  `indigenous` varchar(100) NOT NULL,
  `dissability` varchar(100) NOT NULL,
  `soloParent` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `telnum` int(100) NOT NULL,
  `govIssueID` varchar(100) NOT NULL,
  `licenseID` varchar(100) NOT NULL,
  `inssurance` varchar(100) NOT NULL,
  `employeePhoto` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `joelc`
--

CREATE TABLE `joelc` (
  `id` int(11) NOT NULL,
  `jo_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `date_started` date NOT NULL,
  `le_vac` decimal(10,2) NOT NULL,
  `le_sck` decimal(10,2) NOT NULL,
  `symbol` varchar(50) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `lt_wp_vac` decimal(10,2) DEFAULT NULL,
  `lt_wp_sck` decimal(10,2) DEFAULT NULL,
  `lt_np_vac` decimal(10,2) DEFAULT NULL,
  `lt_np_sck` decimal(10,2) DEFAULT NULL,
  `u_vac` decimal(10,2) DEFAULT NULL,
  `u_sck` decimal(10,2) DEFAULT NULL,
  `b_vac` decimal(10,2) NOT NULL,
  `b_sck` decimal(10,2) NOT NULL,
  `p_initial` varchar(100) DEFAULT NULL,
  `p_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

--
-- Table structure for table `learning_development`
--

CREATE TABLE `learning_development` (
  `id` int(11) NOT NULL,
  `employee_no` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `hours` int(11) NOT NULL,
  `citizenship_type` enum('Managerial','Supervisory','Technical','By Birth','Other') NOT NULL,
  `conducted_by` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `employee_no` varchar(255) NOT NULL,
  `notification_message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Table structure for table `other_info`
--

CREATE TABLE `other_info` (
  `id` int(11) NOT NULL,
  `employee_no` varchar(255) NOT NULL,
  `skills` text DEFAULT NULL,
  `non_academic` text DEFAULT NULL,
  `membership` text DEFAULT NULL,
  `if_third` varchar(255) DEFAULT NULL,
  `if_fourth` varchar(255) DEFAULT NULL,
  `if_guilty` varchar(255) DEFAULT NULL,
  `if_criminal` varchar(255) DEFAULT NULL,
  `if_convicted` varchar(255) DEFAULT NULL,
  `if_separated` varchar(255) DEFAULT NULL,
  `if_candidate` varchar(255) DEFAULT NULL,
  `if_resigned` varchar(255) DEFAULT NULL,
  `if_immigrant` varchar(255) DEFAULT NULL,
  `if_indigenous` varchar(255) DEFAULT NULL,
  `ref_nameq` varchar(255) DEFAULT NULL,
  `ref_add1` varchar(255) DEFAULT NULL,
  `ref_tel1` varchar(255) DEFAULT NULL,
  `ref_name2` varchar(255) DEFAULT NULL,
  `ref_add2` varchar(255) DEFAULT NULL,
  `ref_tel2` varchar(255) DEFAULT NULL,
  `ref_name3` varchar(255) DEFAULT NULL,
  `ref_add3s` varchar(255) DEFAULT NULL,
  `ref_tel3` varchar(255) DEFAULT NULL,
  `gov_id` varchar(255) DEFAULT NULL,
  `passport_id` varchar(255) DEFAULT NULL,
  `insure_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- Table structure for table `pelc`
--

CREATE TABLE `pelc` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `employee_no` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `le_vac` decimal(10,2) NOT NULL,
  `le_sck` decimal(10,2) NOT NULL,
  `from_to` varchar(255) NOT NULL,
  `lt_wp_vac` decimal(10,2) NOT NULL,
  `lt_wp_sck` decimal(10,2) NOT NULL,
  `lt_np_vac` decimal(10,2) DEFAULT NULL,
  `lt_np_sck` decimal(10,2) DEFAULT NULL,
  `u_vac` decimal(10,2) DEFAULT NULL,
  `u_sck` decimal(10,2) DEFAULT NULL,
  `b_vac` decimal(10,2) NOT NULL,
  `b_sck` decimal(10,2) NOT NULL,
  `p_initial` varchar(100) DEFAULT NULL,
  `p_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

--
-- Table structure for table `personal_info`
--

CREATE TABLE `personal_info` (
  `id` int(11) NOT NULL,
  `employee_no` varchar(50) NOT NULL,
  `csc` varchar(255) NOT NULL,
  `sname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) DEFAULT NULL,
  `extension` varchar(10) DEFAULT NULL,
  `datebirth` date DEFAULT NULL,
  `placebirth` varchar(255) DEFAULT NULL,
  `sex` enum('Male','Female') DEFAULT NULL,
  `status` enum('Single','Married','Widowed','Separated','Other') DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `bloodtype` varchar(10) DEFAULT NULL,
  `gsis_id` varchar(50) DEFAULT NULL,
  `pagibig_id` varchar(50) DEFAULT NULL,
  `philhealth_id` varchar(50) DEFAULT NULL,
  `sss_id` varchar(50) DEFAULT NULL,
  `tin_id` varchar(50) DEFAULT NULL,
  `citizenship` enum('Filipino','Dual Citizenship','By Birth','By Naturalization') DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `resAdd` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `subdivision` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `permaAdd` varchar(255) DEFAULT NULL,
  `permaStreet` varchar(255) DEFAULT NULL,
  `permaSub` varchar(255) DEFAULT NULL,
  `permaBarangay` varchar(255) DEFAULT NULL,
  `permaCity` varchar(255) DEFAULT NULL,
  `permaProvince` varchar(255) DEFAULT NULL,
  `permaZip` varchar(20) DEFAULT NULL,
  `telno` varchar(15) DEFAULT NULL,
  `mobileno` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Table structure for table `voluntary_work`
--

CREATE TABLE `voluntary_work` (
  `id` int(11) NOT NULL,
  `employee_no` varchar(50) NOT NULL,
  `org_name` varchar(255) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `hours` int(11) NOT NULL,
  `nature_of_work` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

--
-- Table structure for table `work_experience`
--

CREATE TABLE `work_experience` (
  `id` int(11) NOT NULL,
  `employee_no` varchar(255) NOT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `salary_grade` varchar(255) DEFAULT NULL,
  `status_appointment` varchar(255) DEFAULT NULL,
  `gov_service` enum('Yes','No') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `appleave`
--
ALTER TABLE `appleave`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `civil_service_eligibility`
--
ALTER TABLE `civil_service_eligibility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `educational_background`
--
ALTER TABLE `educational_background`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `family_info`
--
ALTER TABLE `family_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `government_ids`
--
ALTER TABLE `government_ids`
  ADD PRIMARY KEY (`id`),
  ADD KEY `government_ids_ibfk_1` (`employee_id`);

--
-- Indexes for table `joborder`
--
ALTER TABLE `joborder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `joelc`
--
ALTER TABLE `joelc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_joborder` (`jo_id`);

--
-- Indexes for table `learning_development`
--
ALTER TABLE `learning_development`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_info`
--
ALTER TABLE `other_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelc`
--
ALTER TABLE `pelc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employeeID` (`employee_id`);

--
-- Indexes for table `personal_info`
--
ALTER TABLE `personal_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voluntary_work`
--
ALTER TABLE `voluntary_work`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_experience`
--
ALTER TABLE `work_experience`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `appleave`
--
ALTER TABLE `appleave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `civil_service_eligibility`
--
ALTER TABLE `civil_service_eligibility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `educational_background`
--
ALTER TABLE `educational_background`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `family_info`
--
ALTER TABLE `family_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `government_ids`
--
ALTER TABLE `government_ids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `joborder`
--
ALTER TABLE `joborder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `joelc`
--
ALTER TABLE `joelc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `learning_development`
--
ALTER TABLE `learning_development`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `other_info`
--
ALTER TABLE `other_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pelc`
--
ALTER TABLE `pelc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `personal_info`
--
ALTER TABLE `personal_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `voluntary_work`
--
ALTER TABLE `voluntary_work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `work_experience`
--
ALTER TABLE `work_experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `appleave`
--
ALTER TABLE `appleave`
  ADD CONSTRAINT `employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD CONSTRAINT `emergency_contacts_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `government_ids`
--
ALTER TABLE `government_ids`
  ADD CONSTRAINT `government_ids_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `joelc`
--
ALTER TABLE `joelc`
  ADD CONSTRAINT `fk_joborder` FOREIGN KEY (`jo_id`) REFERENCES `joborder` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pelc`
--
ALTER TABLE `pelc`
  ADD CONSTRAINT `fk_employeeID` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
