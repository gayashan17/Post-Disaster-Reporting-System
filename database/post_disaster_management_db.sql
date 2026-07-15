-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2026 at 08:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `post_disaster_management_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `User_ID` int(11) NOT NULL,
  `Admin_Role` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`User_ID`, `Admin_Role`) VALUES
(6, 'Developer');

-- --------------------------------------------------------

--
-- Table structure for table `citizen`
--

CREATE TABLE `citizen` (
  `User_ID` int(11) NOT NULL,
  `Beneficiary_Name` varchar(100) NOT NULL,
  `Beneficiary_Bank` varchar(100) NOT NULL,
  `Beneficiary_Bank_Account_No` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `citizen`
--

INSERT INTO `citizen` (`User_ID`, `Beneficiary_Name`, `Beneficiary_Bank`, `Beneficiary_Bank_Account_No`) VALUES
(1, '', '', ''),
(11, '', '', ''),
(14, '', '', ''),
(19, '', '', ''),
(20, '', '', ''),
(21, '', '', ''),
(22, '', '', ''),
(26, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `compensation_report`
--

CREATE TABLE `compensation_report` (
  `Compensation_ID` int(11) NOT NULL,
  `Report_ID` int(11) NOT NULL,
  `Processed_By_Financial_Officer_User_ID` int(11) NOT NULL,
  `Approved_Amount` decimal(12,2) NOT NULL,
  `Payment_Status` enum('Pending','Approved','Paid','Failed','Cancelled') NOT NULL,
  `Payment_Rejection_Reason` varchar(255) DEFAULT NULL,
  `Payment_Date` date DEFAULT NULL,
  `Receipt_Number` varchar(100) DEFAULT NULL,
  `Receipt_File_Path` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `death_record`
--

CREATE TABLE `death_record` (
  `Report_ID` int(11) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` varchar(20) DEFAULT NULL,
  `Cause_Of_Death` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `death_record`
--

INSERT INTO `death_record` (`Report_ID`, `Full_Name`, `Age`, `Gender`, `Cause_Of_Death`) VALUES
(35, '', 0, 'default', '');

-- --------------------------------------------------------

--
-- Table structure for table `disaster_management_officer`
--

CREATE TABLE `disaster_management_officer` (
  `User_ID` int(11) NOT NULL,
  `Management_Officer_ID` varchar(20) DEFAULT NULL,
  `Department` varchar(100) DEFAULT NULL,
  `Region_Assigned` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disaster_management_officer`
--

INSERT INTO `disaster_management_officer` (`User_ID`, `Management_Officer_ID`, `Department`, `Region_Assigned`) VALUES
(3, 'DMO001', 'Disaster Management Centre', 'Central Province');

-- --------------------------------------------------------

--
-- Table structure for table `disaster_report`
--

CREATE TABLE `disaster_report` (
  `Report_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Disaster_Type_ID` int(11) NOT NULL,
  `Report_Type` varchar(50) NOT NULL,
  `Report_Status` enum('Submitted','Under Review','Verified','Rejected','Compensation Pending','Compensation Approved','Compensation Rejected','Payment Processing','Payment Completed','Closed') NOT NULL DEFAULT 'Submitted',
  `District` varchar(50) NOT NULL,
  `Street_Address` text NOT NULL,
  `Description` text DEFAULT NULL,
  `Report_Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disaster_report`
--

INSERT INTO `disaster_report` (`Report_ID`, `User_ID`, `Disaster_Type_ID`, `Report_Type`, `Report_Status`, `District`, `Street_Address`, `Description`, `Report_Date`) VALUES
(35, 26, 28, 'Death Record', 'Submitted', 'default', '', '', '2026-07-15 11:30:33'),
(36, 26, 23, 'Missing Person Record', 'Submitted', 'default', '', '', '2026-07-15 11:47:19'),
(37, 26, 28, 'Injured Person', 'Submitted', 'default', '', '', '2026-07-15 12:01:02');

-- --------------------------------------------------------

--
-- Table structure for table `disaster_type`
--

CREATE TABLE `disaster_type` (
  `Disaster_Type_ID` int(11) NOT NULL,
  `Disaster_Type_Name` varchar(100) NOT NULL,
  `Severity` enum('Low','Medium','High','Critical') NOT NULL,
  `Created_By_Admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disaster_type`
--

INSERT INTO `disaster_type` (`Disaster_Type_ID`, `Disaster_Type_Name`, `Severity`, `Created_By_Admin`) VALUES
(22, 'Flood', 'Medium', 6),
(23, 'Landslide', 'High', 6),
(24, 'Cyclone', 'High', 6),
(25, 'Earthquake', 'High', 6),
(26, 'Fire', 'Medium', 6),
(27, 'Tsunami', 'High', 6),
(28, 'Other', 'Low', 6);

-- --------------------------------------------------------

--
-- Table structure for table `district_secretary`
--

CREATE TABLE `district_secretary` (
  `User_ID` int(11) NOT NULL,
  `Secretary_Officer_ID` varchar(20) DEFAULT NULL,
  `Office_Name` varchar(100) DEFAULT NULL,
  `Office_Location` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `district_secretary`
--

INSERT INTO `district_secretary` (`User_ID`, `Secretary_Officer_ID`, `Office_Name`, `Office_Location`) VALUES
(4, 'DS001', 'Matara District Secretariat', 'Matara');

-- --------------------------------------------------------

--
-- Table structure for table `evidence_file_and_photos`
--

CREATE TABLE `evidence_file_and_photos` (
  `File_ID` int(11) NOT NULL,
  `Report_ID` int(11) NOT NULL,
  `File_Name` varchar(255) NOT NULL,
  `File_Type` varchar(20) NOT NULL,
  `File_Path` varchar(500) NOT NULL,
  `Uploaded_Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evidence_file_and_photos`
--

INSERT INTO `evidence_file_and_photos` (`File_ID`, `Report_ID`, `File_Name`, `File_Type`, `File_Path`, `Uploaded_Date`) VALUES
(11, 35, '26_6a572201f2238_DSE 22.1F Database Management Systems.pdf', 'application/pdf', '../uploads/evidence/ReportID_35/26_6a572201f2238_DSE 22.1F Database Management Systems.pdf', '2026-07-15 06:00:33'),
(12, 36, '26_6a5725ef3e28e_Gemini_Generated_Image_zh0ok1zh0ok1zh0o (1).png', 'image/png', '../uploads/evidence/ReportID_36/26_6a5725ef3e28e_Gemini_Generated_Image_zh0ok1zh0ok1zh0o (1).png', '2026-07-15 06:17:19'),
(13, 37, '26_6a57292656736_133508394_8b6a2438-9b01-4305-90c9-b2c97bf50b77.jpg', 'image/jpeg', '../uploads/evidence/ReportID_37/26_6a57292656736_133508394_8b6a2438-9b01-4305-90c9-b2c97bf50b77.jpg', '2026-07-15 06:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `financial_officer`
--

CREATE TABLE `financial_officer` (
  `User_ID` int(11) NOT NULL,
  `Financial_Officer_ID` varchar(20) DEFAULT NULL,
  `Department` varchar(100) DEFAULT NULL,
  `Bank_Details` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `financial_officer`
--

INSERT INTO `financial_officer` (`User_ID`, `Financial_Officer_ID`, `Department`, `Bank_Details`) VALUES
(5, 'FO001', 'Finance Division', 'Bank of Ceylon - A/C 123456789');

-- --------------------------------------------------------

--
-- Table structure for table `injured_person`
--

CREATE TABLE `injured_person` (
  `Report_ID` int(11) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` varchar(20) DEFAULT NULL,
  `Injured_Level` enum('Minor','Moderate','Severe','Critical') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `injured_person`
--

INSERT INTO `injured_person` (`Report_ID`, `Full_Name`, `Age`, `Gender`, `Injured_Level`) VALUES
(37, '', 0, 'default', 'Moderate');

-- --------------------------------------------------------

--
-- Table structure for table `local_authority_officer`
--

CREATE TABLE `local_authority_officer` (
  `User_ID` int(11) NOT NULL,
  `Local_Officer_ID` varchar(20) DEFAULT NULL,
  `Position` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `local_authority_officer`
--

INSERT INTO `local_authority_officer` (`User_ID`, `Local_Officer_ID`, `Position`) VALUES
(2, 'LAO001', 'Environmental Officer');

-- --------------------------------------------------------

--
-- Table structure for table `missing_person_record`
--

CREATE TABLE `missing_person_record` (
  `Report_ID` int(11) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` varchar(20) DEFAULT NULL,
  `Last_Seen_Location` varchar(255) DEFAULT NULL,
  `Last_Seen_Date` date DEFAULT NULL,
  `Last_Seen_Time` time DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `Relationship_to_Person` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `missing_person_record`
--

INSERT INTO `missing_person_record` (`Report_ID`, `Full_Name`, `Age`, `Gender`, `Last_Seen_Location`, `Last_Seen_Date`, `Last_Seen_Time`, `Status`, `Relationship_to_Person`) VALUES
(36, '', 0, 'default', '', '0000-00-00', '00:00:00', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_otp`
--

CREATE TABLE `password_reset_otp` (
  `otp_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `expiry_time` datetime NOT NULL,
  `is_used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_reset_otp`
--

INSERT INTO `password_reset_otp` (`otp_id`, `user_id`, `otp_code`, `expiry_time`, `is_used`, `created_at`) VALUES
(1, 6, '183587', '2026-07-07 00:07:08', 0, '2026-07-06 22:02:08'),
(2, 6, '394418', '2026-07-07 01:12:19', 1, '2026-07-06 23:07:19'),
(3, 6, '854311', '2026-07-07 01:15:51', 0, '2026-07-06 23:10:51'),
(4, 6, '664427', '2026-07-07 01:20:35', 0, '2026-07-06 23:15:35'),
(5, 6, '721480', '2026-07-07 01:30:23', 0, '2026-07-06 23:25:23'),
(6, 6, '494790', '2026-07-07 01:30:53', 0, '2026-07-06 23:25:53'),
(7, 6, '499034', '2026-07-07 01:41:47', 0, '2026-07-06 23:36:47'),
(8, 6, '210188', '2026-07-07 01:54:11', 1, '2026-07-06 23:49:11'),
(9, 6, '708123', '2026-07-07 02:18:38', 0, '2026-07-07 00:13:38'),
(10, 6, '832972', '2026-07-07 02:19:03', 0, '2026-07-07 00:14:03'),
(11, 6, '677207', '2026-07-08 03:49:15', 1, '2026-07-08 01:44:15');

-- --------------------------------------------------------

--
-- Table structure for table `property_damage`
--

CREATE TABLE `property_damage` (
  `Report_ID` int(11) NOT NULL,
  `Property_Type` varchar(100) NOT NULL,
  `Damage_Level` enum('Minor','Moderate','Major','Destroyed') NOT NULL,
  `Damage_Description` text DEFAULT NULL,
  `Estimated_Cost` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `Role_ID` int(11) NOT NULL,
  `Role_Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`Role_ID`, `Role_Name`) VALUES
(1, 'Admin'),
(2, 'Disaster Management Officer'),
(3, 'Citizen'),
(4, 'Local Authority Officer'),
(5, 'District Secretary'),
(6, 'Financial Officer');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `Gender` enum('Male','Female','Other') DEFAULT NULL,
  `NIC` varchar(20) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone_Number` varchar(20) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Role_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `Username`, `Password`, `Full_Name`, `Gender`, `NIC`, `Email`, `Phone_Number`, `Address`, `Role_ID`) VALUES
(1, 'citizen01', 'pass123', 'Kasun Perera', 'Male', '199812345678', 'kasun@gmail.com', '0711234567', 'Colombo', 3),
(2, 'lao01', 'pass123', 'Nimal Silva', 'Male', '198745678901', 'nimal@gmail.com', '0722345678', 'Gampaha', 4),
(3, 'dmo01', 'pass123', 'Amara Jayasinghe', 'Female', '198556789012', 'amara@gmail.com', '0773456789', 'Kandy', 2),
(4, 'ds01', 'pass123', 'Ruwan Fernando', 'Male', '197934567890', 'ruwan@gmail.com', '0764567890', 'Matara', 5),
(5, 'fo01', 'pass123', 'Chathuri Wickramasinghe', 'Female', '198923456789', 'chathuri@gmail.com', '0755678901', 'Kurunegala', 6),
(6, 'Admin', '$2y$10$Yv0vx6eDLgnjClgGtgnu/.aU9.KwM2zDPNrtv3TPeP8t9nxP4M0Ea', 'Malisha Madhusith', 'Male', '200304811656', 'malishashadowflame99@gmail.com', '0766511220', 'Galle', 1),
(9, 'MM@17', '$2y$10$vCXQHNooJBiH4qvxsOyMaemZIfsl7xxxv4paYtPrLIE/WPPiw7zfe', 'Malisha Madhusith', 'Male', '200304811656', 'malisha99@gmail.com', '0766511220', 'Malavigewatta,', 1),
(11, 'ABC', '$2y$10$FIITcBMLwPFDQeNkCIhSye8s6oyA39XImPvOrU9VbHW8BUNcMgNIW', 'abc', 'Male', '200304811655', 'malishashado@gmail.com', '0766511220', 'galle', 3),
(14, 'as', '$2y$10$YENTnCSD27sazAzT7SftUuANVsgEcpE7zTSYUdrO9cU/dl4AgOoqG', 'as', '', '', '', '', '', 3),
(19, 'Kasun@123', '$2y$10$L9.Ml8AbgFQUbhhUauwYxOOhysxbK2iz63akTE3X9XCPTeGYlFXde', 'Kasun Dananjaya', 'Male', '200304811656', 'AAAAA@gmail.com', '0766511220', 'Colombo', 3),
(20, 'Madu@123', '$2y$10$Afuvp17dwAB1EK3V/DDR0OhQEC1NdEk.aNLZbiEnL8SXNhDx6X1im', 'Madushi Kalansoooriya', 'Female', '200304811656', 'AAA@gmail.com', '0766511220', 'Colombo', 3),
(21, 'ASD123', '$2y$10$Cjk7CsqrShTnnsabPAB1g.cgMx0VawPWikzlKf8RxZr/rRGKLTsA2', 'Asanka Sampath Dananjaya', 'Male', '200304568596', 'AsankaSD@gmail.com', '0778899665', 'Kurunegala', 3),
(22, 'charin', '$2y$10$jwJxmkgI9BBLns5BXJMnd.uDSbforiJCCQ3QIfuUj0tCtcbFrYf4y', 'charindu gayashan', 'Male', '200512700610', 'charindu@gmail.com', '0762352086', 'galle', 3),
(26, 'charindu', '$2y$10$TxVu6.HZBGZNYJr9.N4wAOFGpSAVdgZZaznXeaUZJvs9F.5Vze6Eq', 'Charindu Gayashan', 'Male', '200512700610', 'charindugayashan00@gmail.com', '0762352086', 'galle', 3);

-- --------------------------------------------------------

--
-- Table structure for table `verification_report`
--

CREATE TABLE `verification_report` (
  `Verification_ID` int(11) NOT NULL,
  `Report_ID` int(11) NOT NULL,
  `Created_By_Officer_User_ID` int(11) NOT NULL,
  `Description` text DEFAULT NULL,
  `Report_Status` enum('Pending','Verified','Rejected') NOT NULL,
  `Estimated_Amount` decimal(12,2) DEFAULT NULL,
  `Verification_Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `citizen`
--
ALTER TABLE `citizen`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `compensation_report`
--
ALTER TABLE `compensation_report`
  ADD PRIMARY KEY (`Compensation_ID`),
  ADD UNIQUE KEY `Report_ID` (`Report_ID`),
  ADD UNIQUE KEY `Receipt_Number` (`Receipt_Number`),
  ADD KEY `Processed_By_Financial_Officer_User_ID` (`Processed_By_Financial_Officer_User_ID`);

--
-- Indexes for table `death_record`
--
ALTER TABLE `death_record`
  ADD PRIMARY KEY (`Report_ID`);

--
-- Indexes for table `disaster_management_officer`
--
ALTER TABLE `disaster_management_officer`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Management_Officer_ID` (`Management_Officer_ID`);

--
-- Indexes for table `disaster_report`
--
ALTER TABLE `disaster_report`
  ADD PRIMARY KEY (`Report_ID`),
  ADD KEY `fk_report_user` (`User_ID`),
  ADD KEY `fk_report_disaster_type` (`Disaster_Type_ID`);

--
-- Indexes for table `disaster_type`
--
ALTER TABLE `disaster_type`
  ADD PRIMARY KEY (`Disaster_Type_ID`),
  ADD KEY `Created_By_Admin` (`Created_By_Admin`);

--
-- Indexes for table `district_secretary`
--
ALTER TABLE `district_secretary`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Secretary_Officer_ID` (`Secretary_Officer_ID`);

--
-- Indexes for table `evidence_file_and_photos`
--
ALTER TABLE `evidence_file_and_photos`
  ADD PRIMARY KEY (`File_ID`),
  ADD KEY `Report_ID` (`Report_ID`);

--
-- Indexes for table `financial_officer`
--
ALTER TABLE `financial_officer`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Financial_Officer_ID` (`Financial_Officer_ID`);

--
-- Indexes for table `injured_person`
--
ALTER TABLE `injured_person`
  ADD PRIMARY KEY (`Report_ID`);

--
-- Indexes for table `local_authority_officer`
--
ALTER TABLE `local_authority_officer`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Local_Officer_ID` (`Local_Officer_ID`);

--
-- Indexes for table `missing_person_record`
--
ALTER TABLE `missing_person_record`
  ADD PRIMARY KEY (`Report_ID`);

--
-- Indexes for table `password_reset_otp`
--
ALTER TABLE `password_reset_otp`
  ADD PRIMARY KEY (`otp_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `property_damage`
--
ALTER TABLE `property_damage`
  ADD PRIMARY KEY (`Report_ID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Role_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `fk_users_roles` (`Role_ID`);

--
-- Indexes for table `verification_report`
--
ALTER TABLE `verification_report`
  ADD PRIMARY KEY (`Verification_ID`),
  ADD UNIQUE KEY `Report_ID` (`Report_ID`),
  ADD KEY `Created_By_Officer_User_ID` (`Created_By_Officer_User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `compensation_report`
--
ALTER TABLE `compensation_report`
  MODIFY `Compensation_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disaster_report`
--
ALTER TABLE `disaster_report`
  MODIFY `Report_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `disaster_type`
--
ALTER TABLE `disaster_type`
  MODIFY `Disaster_Type_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `evidence_file_and_photos`
--
ALTER TABLE `evidence_file_and_photos`
  MODIFY `File_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `password_reset_otp`
--
ALTER TABLE `password_reset_otp`
  MODIFY `otp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `verification_report`
--
ALTER TABLE `verification_report`
  MODIFY `Verification_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `citizen`
--
ALTER TABLE `citizen`
  ADD CONSTRAINT `citizen_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `compensation_report`
--
ALTER TABLE `compensation_report`
  ADD CONSTRAINT `compensation_report_ibfk_1` FOREIGN KEY (`Report_ID`) REFERENCES `disaster_report` (`Report_ID`),
  ADD CONSTRAINT `compensation_report_ibfk_2` FOREIGN KEY (`Processed_By_Financial_Officer_User_ID`) REFERENCES `financial_officer` (`User_ID`);

--
-- Constraints for table `death_record`
--
ALTER TABLE `death_record`
  ADD CONSTRAINT `death_record_ibfk_1` FOREIGN KEY (`Report_ID`) REFERENCES `disaster_report` (`Report_ID`);

--
-- Constraints for table `disaster_management_officer`
--
ALTER TABLE `disaster_management_officer`
  ADD CONSTRAINT `disaster_management_officer_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `disaster_report`
--
ALTER TABLE `disaster_report`
  ADD CONSTRAINT `fk_report_disaster_type` FOREIGN KEY (`Disaster_Type_ID`) REFERENCES `disaster_type` (`Disaster_Type_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_report_user` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `disaster_type`
--
ALTER TABLE `disaster_type`
  ADD CONSTRAINT `disaster_type_ibfk_1` FOREIGN KEY (`Created_By_Admin`) REFERENCES `admin` (`User_ID`);

--
-- Constraints for table `district_secretary`
--
ALTER TABLE `district_secretary`
  ADD CONSTRAINT `district_secretary_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `financial_officer`
--
ALTER TABLE `financial_officer`
  ADD CONSTRAINT `financial_officer_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `injured_person`
--
ALTER TABLE `injured_person`
  ADD CONSTRAINT `injured_person_ibfk_1` FOREIGN KEY (`Report_ID`) REFERENCES `disaster_report` (`Report_ID`);

--
-- Constraints for table `local_authority_officer`
--
ALTER TABLE `local_authority_officer`
  ADD CONSTRAINT `local_authority_officer_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `missing_person_record`
--
ALTER TABLE `missing_person_record`
  ADD CONSTRAINT `missing_person_record_ibfk_1` FOREIGN KEY (`Report_ID`) REFERENCES `disaster_report` (`Report_ID`);

--
-- Constraints for table `password_reset_otp`
--
ALTER TABLE `password_reset_otp`
  ADD CONSTRAINT `password_reset_otp_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `property_damage`
--
ALTER TABLE `property_damage`
  ADD CONSTRAINT `property_damage_ibfk_1` FOREIGN KEY (`Report_ID`) REFERENCES `disaster_report` (`Report_ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_roles` FOREIGN KEY (`Role_ID`) REFERENCES `roles` (`Role_ID`);

--
-- Constraints for table `verification_report`
--
ALTER TABLE `verification_report`
  ADD CONSTRAINT `verification_report_ibfk_1` FOREIGN KEY (`Report_ID`) REFERENCES `disaster_report` (`Report_ID`),
  ADD CONSTRAINT `verification_report_ibfk_2` FOREIGN KEY (`Created_By_Officer_User_ID`) REFERENCES `users` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
