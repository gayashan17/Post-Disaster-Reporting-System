-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2026 at 06:43 PM
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
(11, '', '', ''),
(14, '', '', ''),
(19, '', '', ''),
(20, '', '', ''),
(21, '', '', ''),
(22, '', '', ''),
(26, '', '', ''),
(27, '', '', ''),
(28, '', '', ''),
(29, '', '', ''),
(30, '', '', ''),
(31, '', '', ''),
(32, 'asda', 'asdada', '845629959'),
(34, '', '', ''),
(36, '', '', ''),
(37, '', '', ''),
(38, '', '', ''),
(41, '', '', ''),
(42, '', '', ''),
(43, '', '', ''),
(44, '', '', ''),
(45, '', '', ''),
(46, 'sadf', 'asdf', ''),
(82, 'Kasun Maduranga', 'Bank of Ceylon', '1000000001'),
(83, 'Nimali Perera', 'People\'s Bank', '1000000002'),
(84, 'Tharindu Fernando', 'Commercial Bank', '1000000003'),
(85, 'Sachini Dilrukshi', 'Sampath Bank', '1000000004'),
(86, 'Chamod Lakshan', 'Hatton National Bank', '1000000005'),
(87, 'Hiruni Sewwandi', 'Nations Trust Bank', '1000000006'),
(88, 'Dinesh Kumara', 'Bank of Ceylon', '1000000007'),
(89, 'Piumi Hansika', 'People\'s Bank', '1000000008'),
(90, 'Ravindu Nimesh', 'Commercial Bank', '1000000009'),
(91, 'Thilini Madushika', 'Sampath Bank', '1000000010'),
(92, 'Sahan Pramod', 'Hatton National Bank', '1000000011'),
(93, 'Ishara Sandamini', 'Nations Trust Bank', '1000000012'),
(94, 'Nuwan Chathuranga', 'Bank of Ceylon', '1000000013'),
(95, 'Ayesha Fernando', 'People\'s Bank', '1000000014'),
(96, 'Dinuka Sathsara', 'Commercial Bank', '1000000015'),
(97, 'Shashika Nadeeshani', 'Sampath Bank', '1000000016'),
(98, 'Malith Ravishan', 'Hatton National Bank', '1000000017'),
(99, 'Kavindi Upeksha', 'Nations Trust Bank', '1000000018'),
(100, 'Hasitha Lakmal', 'Bank of Ceylon', '1000000019'),
(101, 'Madhavi Sachintha', 'People\'s Bank', '1000000020'),
(102, 'Praveen Madushan', 'Commercial Bank', '1000000021'),
(103, 'Nethmi Senanayake', 'Sampath Bank', '1000000022'),
(104, 'Chathura Bandara', 'Hatton National Bank', '1000000023'),
(105, 'Dinethmi Kavisha', 'Nations Trust Bank', '1000000024'),
(106, 'Lahiru Sandaruwan', 'Bank of Ceylon', '1000000025'),
(107, 'Oshadi Himasha', 'People\'s Bank', '1000000026'),
(108, 'Isuru Dhananjaya', 'Commercial Bank', '1000000027'),
(109, 'Shenali Tharuka', 'Sampath Bank', '1000000028'),
(110, 'Rukshan Prabath', 'Hatton National Bank', '1000000029'),
(111, 'Yashoda Nisansala', 'Nations Trust Bank', '1000000030'),
(112, 'Amila Perera', 'Bank of Ceylon', '1000000031'),
(113, 'Shenuka Wijesinghe', 'People\'s Bank', '1000000032'),
(114, 'Ravindu Jayasinghe', 'Commercial Bank', '1000000033'),
(115, 'Tharushi Fernando', 'Sampath Bank', '1000000034'),
(116, 'Kasun Dilshan', 'Hatton National Bank', '1000000035'),
(117, 'Nimesh Madushan', 'Nations Trust Bank', '1000000036'),
(118, 'Sanduni Hansika', 'Bank of Ceylon', '1000000037'),
(119, 'Tharindu Lakmal', 'People\'s Bank', '1000000038'),
(120, 'Kavisha Dilhani', 'Commercial Bank', '1000000039'),
(121, 'Sahan Chathuranga', 'Sampath Bank', '1000000040'),
(122, 'Dulanjana Prabath', 'Hatton National Bank', '1000000041'),
(123, 'Hiruni Sandamali', 'Nations Trust Bank', '1000000042'),
(124, 'Isuru Madushan', 'Bank of Ceylon', '1000000043'),
(125, 'Piumi Sewwandi', 'People\'s Bank', '1000000044'),
(126, 'Chamara Nimesh', 'Commercial Bank', '1000000045'),
(127, 'Dhanuka Bandara', 'Sampath Bank', '1000000046'),
(128, 'Sachini Madushika', 'Hatton National Bank', '1000000047'),
(129, 'Ravindu Chathuranga', 'Nations Trust Bank', '1000000048'),
(130, 'Nethmi Udeshika', 'Nations Trust Bank', '1000000049'),
(131, 'Malith Sandeepa', 'Bank of Ceylon', '1000000050');

-- --------------------------------------------------------

--
-- Table structure for table `compensation_report`
--

CREATE TABLE `compensation_report` (
  `Compensation_ID` int(11) NOT NULL,
  `Report_ID` int(11) NOT NULL,
  `Financial_Officer_User_ID` int(11) NOT NULL,
  `Estimate_Amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `Approved_Amount` decimal(12,2) DEFAULT NULL,
  `Paid_Amount` decimal(12,2) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Receipt_File_Path` varchar(255) DEFAULT NULL,
  `Payment_Status` enum('Claimed','Processing','Paid') NOT NULL DEFAULT 'Claimed',
  `Payment_Date` datetime DEFAULT NULL,
  `Created_Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compensation_report`
--

INSERT INTO `compensation_report` (`Compensation_ID`, `Report_ID`, `Financial_Officer_User_ID`, `Estimate_Amount`, `Approved_Amount`, `Paid_Amount`, `Description`, `Receipt_File_Path`, `Payment_Status`, `Payment_Date`, `Created_Date`) VALUES
(13, 47, 31, 200000.00, 150000.00, 150000.00, 'Full Payement', '../uploads/Receipt/13_47_1784987017_26_6a572201f2238_DSE_22.1F_Database_Management_Systems.pdf', 'Paid', '2026-07-25 19:13:37', '2026-07-25 19:13:03');

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
(35, '', 0, 'default', ''),
(42, '', 0, 'default', ''),
(43, '', 0, 'default', ''),
(50, '', 0, 'default', ''),
(53, '', 0, 'default', ''),
(54, '', 0, 'default', ''),
(55, '', 0, 'default', ''),
(56, '', 0, 'default', ''),
(57, '', 0, 'default', ''),
(58, '', 0, 'default', ''),
(65, '', 0, 'default', ''),
(66, '', 0, 'default', ''),
(71, '', 0, 'default', ''),
(72, '', 0, 'default', '');

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
(30, 'ASsDe', 'ADA', 'Galle');

-- --------------------------------------------------------

--
-- Table structure for table `disaster_report`
--

CREATE TABLE `disaster_report` (
  `Report_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Disaster_Type_ID` int(11) NOT NULL,
  `Report_Type` varchar(50) NOT NULL,
  `Report_Status` enum('Submitted','LAO Approved','LAO Pending','LAO Rejected','DMO Approved','DMO Pending','DMO Rejected','DS Approved','DS Pending','DS Rejected','FO Paid','FO Pending','FO Rejected') NOT NULL DEFAULT 'Submitted',
  `District` varchar(50) NOT NULL,
  `DS_ID` int(11) DEFAULT NULL,
  `Street_Address` text NOT NULL,
  `Description` text DEFAULT NULL,
  `Report_Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disaster_report`
--

INSERT INTO `disaster_report` (`Report_ID`, `User_ID`, `Disaster_Type_ID`, `Report_Type`, `Report_Status`, `District`, `DS_ID`, `Street_Address`, `Description`, `Report_Date`) VALUES
(35, 26, 28, 'Death Record', 'FO Pending', 'default', 1, '', '', '2026-07-15 11:30:33'),
(36, 26, 23, 'Missing Person Record', 'FO Paid', 'default', NULL, '', '', '2026-07-15 11:47:19'),
(37, 26, 28, 'Injured Person', 'FO Paid', 'default', NULL, '', '', '2026-07-15 12:01:02'),
(38, 26, 28, 'Property Damage', 'DMO Approved', 'galle', NULL, '', '', '2026-07-16 06:34:06'),
(39, 26, 28, 'Property Damage', 'FO Paid', 'default', NULL, '', '', '2026-07-16 09:33:56'),
(40, 32, 23, 'Property Damage', 'FO Pending', 'default', NULL, '', '', '2026-07-19 00:10:17'),
(41, 32, 28, 'Property Damage', 'FO Pending', 'default', NULL, '', '', '2026-07-19 00:15:02'),
(42, 32, 28, 'Death Record', 'FO Pending', 'default', NULL, '', '', '2026-07-19 02:46:47'),
(43, 32, 28, 'Death Record', 'FO Paid', 'default', NULL, '', '', '2026-07-19 02:48:38'),
(44, 32, 28, 'Injured Person', 'FO Paid', 'default', NULL, '', '', '2026-07-19 02:58:39'),
(45, 32, 28, 'Missing Person Record', 'Submitted', 'default', NULL, '', '', '2026-07-19 03:02:23'),
(46, 32, 23, 'Property Damage', 'LAO Approved', 'Galle', 3, 'asdfghj', 'uytfds', '2026-07-19 07:27:02'),
(47, 32, 28, 'Property Damage', 'FO Paid', 'Galle', 22, 'adfsgdsa', '', '2026-07-21 17:02:51'),
(48, 32, 28, 'Property Damage', 'Submitted', 'default', NULL, '', '', '2026-07-21 17:05:01'),
(49, 32, 28, 'Property Damage', 'FO Pending', 'Galle', 6, 'afasa', 'asdad', '2026-07-21 17:22:29'),
(50, 32, 28, 'Death Record', 'LAO Approved', 'default', NULL, '', '', '2026-07-21 19:59:50'),
(51, 32, 28, 'Injured Person', 'Submitted', 'default', NULL, '', '', '2026-07-21 20:00:06'),
(52, 32, 28, 'Missing Person Record', 'DMO Approved', 'Galle', 53, 'asdada', 'asdasd', '2026-07-21 20:00:32'),
(53, 32, 28, 'Death Record', 'DS Approved', 'default', NULL, '', '', '2026-07-22 16:22:52'),
(54, 32, 28, 'Death Record', 'DS Rejected', 'default', NULL, '', '', '2026-07-22 16:29:36'),
(55, 32, 28, 'Death Record', 'DS Rejected', 'Galle', NULL, '', '', '2026-07-22 16:39:46'),
(56, 32, 28, 'Death Record', 'DMO Rejected', 'Galle', NULL, '', '', '2026-07-22 16:40:05'),
(57, 32, 28, 'Death Record', 'DMO Rejected', 'Galle', NULL, '', '', '2026-07-22 16:40:43'),
(58, 32, 28, 'Death Record', 'DS Approved', 'Galle', NULL, '', '', '2026-07-22 19:09:30'),
(59, 26, 22, 'Property Damage', 'LAO Approved', 'Colombo', NULL, 'wedfxv', 'fdvb', '2026-07-24 01:27:20'),
(60, 26, 22, 'Property Damage', 'Submitted', 'Colombo', NULL, 'wedfxv', 'fdvb', '2026-07-24 01:37:58'),
(61, 26, 22, 'Property Damage', 'Submitted', 'Colombo', NULL, 'wedfxv', 'fdvb', '2026-07-24 01:39:31'),
(62, 32, 28, 'Property Damage', 'Submitted', 'Colombo', 1, '', '', '2026-07-25 17:51:35'),
(63, 32, 28, 'Property Damage', 'Submitted', 'Colombo', 1, '', '', '2026-07-26 21:06:03'),
(64, 32, 28, 'Property Damage', 'Submitted', 'Galle', 82, '', '', '2026-07-26 21:42:10'),
(65, 32, 28, 'Death Record', 'Submitted', 'Gampaha', 18, '', '', '2026-07-26 21:48:31'),
(66, 32, 28, 'Death Record', 'Submitted', 'Galle', 80, '', '', '2026-07-26 21:48:42'),
(67, 32, 28, 'Injured Person', 'Submitted', 'Galle', 84, '', '', '2026-07-26 21:49:12'),
(68, 32, 28, 'Property Damage', 'Submitted', 'Galle', 79, '', '', '2026-07-26 21:51:36'),
(69, 32, 28, 'Missing Person Record', 'Submitted', 'Galle', 85, '', '', '2026-07-26 22:04:32'),
(70, 32, 28, 'Missing Person Record', 'Submitted', 'Galle', 81, '', '', '2026-07-26 22:07:17'),
(71, 32, 28, 'Death Record', 'Submitted', 'Galle', 82, 'adadsd', '', '2026-07-26 22:09:20'),
(72, 32, 28, 'Death Record', 'Submitted', 'Galle', 93, '', '', '2026-07-26 22:09:44'),
(73, 32, 28, 'Injured Person', 'Submitted', 'Galle', 77, '', '', '2026-07-26 22:10:18'),
(74, 32, 28, 'Missing Person Record', 'Submitted', 'Galle', 90, '', '', '2026-07-26 22:10:36'),
(75, 32, 28, 'Property Damage', 'Submitted', 'Galle', 80, '', '', '2026-07-26 22:11:11');

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
(28, 'asasa', 'Galle', 'asdada'),
(48, 'ASsDe', 'SsASss', 'SASDAdaDd'),
(50, 'ASsDeAS', 'Matale', 'ASASASAS'),
(74, 'DS0001', 'Galle', '15 Main Street, Galle'),
(75, 'DS0002', 'Colombo', '15 Main Street, COlombo'),
(76, 'DS0003', 'Gampaha', '15 Main Street, Gampaha'),
(77, 'DS0004', 'Matara', '15 Main Street, Matara');

-- --------------------------------------------------------

--
-- Table structure for table `divisional_secretariat`
--

CREATE TABLE `divisional_secretariat` (
  `DS_ID` int(11) NOT NULL,
  `District` varchar(50) DEFAULT NULL,
  `DS_Name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `divisional_secretariat`
--

INSERT INTO `divisional_secretariat` (`DS_ID`, `District`, `DS_Name`) VALUES
(1, 'Colombo', 'Colombo'),
(2, 'Colombo', 'Dehiwala'),
(3, 'Colombo', 'Homagama'),
(4, 'Colombo', 'Kaduwela'),
(5, 'Colombo', 'Kesbewa'),
(6, 'Colombo', 'Kolonnawa'),
(7, 'Colombo', 'Maharagama'),
(8, 'Colombo', 'Moratuwa'),
(9, 'Colombo', 'Padukka'),
(10, 'Colombo', 'Ratmalana'),
(11, 'Colombo', 'Seethawaka'),
(12, 'Colombo', 'Sri Jayawardenapura'),
(13, 'Colombo', 'Thimbirigasyaya'),
(14, 'Gampaha', 'Attanagalla'),
(15, 'Gampaha', 'Biyagama'),
(16, 'Gampaha', 'Divulapitiya'),
(17, 'Gampaha', 'Dompe'),
(18, 'Gampaha', 'Gampaha'),
(19, 'Gampaha', 'Ja-Ela'),
(20, 'Gampaha', 'Katana'),
(21, 'Gampaha', 'Kelaniya'),
(22, 'Gampaha', 'Mahara'),
(23, 'Gampaha', 'Minuwangoda'),
(24, 'Gampaha', 'Mirigama'),
(25, 'Gampaha', 'Negombo'),
(26, 'Gampaha', 'Wattala'),
(27, 'Kalutara', 'Agalawatta'),
(28, 'Kalutara', 'Bandaragama'),
(29, 'Kalutara', 'Beruwala'),
(30, 'Kalutara', 'Bulathsinhala'),
(31, 'Kalutara', 'Dodangoda'),
(32, 'Kalutara', 'Horana'),
(33, 'Kalutara', 'Ingiriya'),
(34, 'Kalutara', 'Kalutara'),
(35, 'Kalutara', 'Madurawela'),
(36, 'Kalutara', 'Matugama'),
(37, 'Kalutara', 'Millaniya'),
(38, 'Kalutara', 'Palindanuwara'),
(39, 'Kalutara', 'Panadura'),
(40, 'Kalutara', 'Walallawita'),
(41, 'Kandy', 'Akurana'),
(42, 'Kandy', 'Doluwa'),
(43, 'Kandy', 'Gangawata Korale'),
(44, 'Kandy', 'Ganga Ihala Korale'),
(45, 'Kandy', 'Harispattuwa'),
(46, 'Kandy', 'Hatharaliyadda'),
(47, 'Kandy', 'Kundasale'),
(48, 'Kandy', 'Medadumbara'),
(49, 'Kandy', 'Minipe'),
(50, 'Kandy', 'Panvila'),
(51, 'Kandy', 'Pasbage Korale'),
(52, 'Kandy', 'Pathadumbara'),
(53, 'Kandy', 'Pathahewaheta'),
(54, 'Kandy', 'Poojapitiya'),
(55, 'Kandy', 'Thumpane'),
(56, 'Kandy', 'Udapalatha'),
(57, 'Kandy', 'Ududumbara'),
(58, 'Kandy', 'Yatinuwara'),
(59, 'Matale', 'Ambanganga Korale'),
(60, 'Matale', 'Dambulla'),
(61, 'Matale', 'Galewela'),
(62, 'Matale', 'Laggala-Pallegama'),
(63, 'Matale', 'Matale'),
(64, 'Matale', 'Naula'),
(65, 'Matale', 'Pallepola'),
(66, 'Matale', 'Rattota'),
(67, 'Matale', 'Ukuwela'),
(68, 'Matale', 'Wilgamuwa'),
(69, 'Matale', 'Yatawatta'),
(70, 'Nuwara Eliya', 'Ambagamuwa'),
(71, 'Nuwara Eliya', 'Hanguranketha'),
(72, 'Nuwara Eliya', 'Kothmale'),
(73, 'Nuwara Eliya', 'Nuwara Eliya'),
(74, 'Nuwara Eliya', 'Walapane'),
(75, 'Galle', 'Imaduwa'),
(76, 'Galle', 'Bope-Poddala'),
(77, 'Galle', 'Neluwa'),
(78, 'Galle', 'Nagoda'),
(79, 'Galle', 'Gonapinuwala'),
(80, 'Galle', 'Thawalama'),
(81, 'Galle', 'Welivitiya-Divithura'),
(82, 'Galle', 'Baddegama'),
(83, 'Galle', 'Balapitiya'),
(84, 'Galle', 'Galle Four Gravets'),
(85, 'Galle', 'Ambalangoda'),
(86, 'Galle', 'Akmeemana'),
(87, 'Galle', 'Bentota'),
(88, 'Galle', 'Elpitiya'),
(89, 'Galle', 'Niyagama'),
(90, 'Galle', 'Yakkalamulla'),
(91, 'Galle', 'Habaraduwa'),
(92, 'Galle', 'Hikkaduwa'),
(93, 'Galle', 'Karandeniya'),
(94, 'Matara', 'Akuressa'),
(95, 'Matara', 'Athuraliya'),
(96, 'Matara', 'Devinuwara'),
(97, 'Matara', 'Dickwella'),
(98, 'Matara', 'Hakmana'),
(99, 'Matara', 'Kamburupitiya'),
(100, 'Matara', 'Kirinda-Puhulwella'),
(101, 'Matara', 'Kotapola'),
(102, 'Matara', 'Malimbada'),
(103, 'Matara', 'Matara Four Gravets'),
(104, 'Matara', 'Mulatiyana'),
(105, 'Matara', 'Pasgoda'),
(106, 'Matara', 'Pitabeddara'),
(107, 'Matara', 'Thihagoda'),
(108, 'Matara', 'Weligama'),
(109, 'Matara', 'Welipitiya'),
(110, 'Hambantota', 'Ambalantota'),
(111, 'Hambantota', 'Angunakolapelessa'),
(112, 'Hambantota', 'Beliatta'),
(113, 'Hambantota', 'Hambantota'),
(114, 'Hambantota', 'Katuwana'),
(115, 'Hambantota', 'Lunugamvehera'),
(116, 'Hambantota', 'Okewela'),
(117, 'Hambantota', 'Sooriyawewa'),
(118, 'Hambantota', 'Tangalle'),
(119, 'Hambantota', 'Tissamaharama'),
(120, 'Hambantota', 'Walasmulla'),
(121, 'Hambantota', 'Weeraketiya'),
(122, 'Jaffna', 'Delft'),
(123, 'Jaffna', 'Island South (Velanai)'),
(124, 'Jaffna', 'Island North (Kayts)'),
(125, 'Jaffna', 'Jaffna'),
(126, 'Jaffna', 'Karainagar'),
(127, 'Jaffna', 'Nallur'),
(128, 'Jaffna', 'Thenmarachchi'),
(129, 'Jaffna', 'Vadamarachchi East'),
(130, 'Jaffna', 'Vadamarachchi North'),
(131, 'Jaffna', 'Vadamarachchi South-West'),
(132, 'Jaffna', 'Valikamam East'),
(133, 'Jaffna', 'Valikamam North'),
(134, 'Jaffna', 'Valikamam South'),
(135, 'Jaffna', 'Valikamam South-West'),
(136, 'Jaffna', 'Valikamam West'),
(137, 'Kilinochchi', 'Kandavalai'),
(138, 'Kilinochchi', 'Karachchi'),
(139, 'Kilinochchi', 'Pachchilaipalli'),
(140, 'Kilinochchi', 'Poonakary'),
(141, 'Mannar', 'Madhu'),
(142, 'Mannar', 'Manthai West'),
(143, 'Mannar', 'Mannar'),
(144, 'Mannar', 'Musali'),
(145, 'Mannar', 'Nanattan'),
(146, 'Mullaitivu', 'Manthai East'),
(147, 'Mullaitivu', 'Maritimepattu'),
(148, 'Mullaitivu', 'Oddusuddan'),
(149, 'Mullaitivu', 'Puthukudiyiruppu'),
(150, 'Mullaitivu', 'Thunukkai'),
(151, 'Vavuniya', 'Vavuniya'),
(152, 'Vavuniya', 'Vavuniya North'),
(153, 'Vavuniya', 'Vavuniya South'),
(154, 'Vavuniya', 'Vengalacheddikulam'),
(155, 'Trincomalee', 'Gomarankadawala'),
(156, 'Trincomalee', 'Kantale'),
(157, 'Trincomalee', 'Kinniya'),
(158, 'Trincomalee', 'Kuchchaveli'),
(159, 'Trincomalee', 'Morawewa'),
(160, 'Trincomalee', 'Muthur'),
(161, 'Trincomalee', 'Padavi Sri Pura'),
(162, 'Trincomalee', 'Seruvila'),
(163, 'Trincomalee', 'Thambalagamuwa'),
(164, 'Trincomalee', 'Trincomalee Town and Gravets'),
(165, 'Trincomalee', 'Verugal'),
(166, 'Batticaloa', 'Addalachchenai'),
(167, 'Batticaloa', 'Araipattai'),
(168, 'Batticaloa', 'Chenkalady'),
(169, 'Batticaloa', 'Eravur Pattu'),
(170, 'Batticaloa', 'Eravur Town'),
(171, 'Batticaloa', 'Kattankudy'),
(172, 'Batticaloa', 'Koralai Pattu'),
(173, 'Batticaloa', 'Koralai Pattu North'),
(174, 'Batticaloa', 'Koralai Pattu South'),
(175, 'Batticaloa', 'Manmunai North'),
(176, 'Batticaloa', 'Manmunai Pattu'),
(177, 'Batticaloa', 'Manmunai South and Eruvil Pattu'),
(178, 'Batticaloa', 'Porativu Pattu'),
(179, 'Batticaloa', 'Vaharai'),
(180, 'Ampara', 'Addalachchenai'),
(181, 'Ampara', 'Ampara'),
(182, 'Ampara', 'Damana'),
(183, 'Ampara', 'Dehiattakandiya'),
(184, 'Ampara', 'Eragama'),
(185, 'Ampara', 'Kalmunai'),
(186, 'Ampara', 'Kalmunai Muslim'),
(187, 'Ampara', 'Karaitivu'),
(188, 'Ampara', 'Lahugala'),
(189, 'Ampara', 'Maha Oya'),
(190, 'Ampara', 'Navithanveli'),
(191, 'Ampara', 'Ninthavur'),
(192, 'Ampara', 'Padiyathalawa'),
(193, 'Ampara', 'Pottuvil'),
(194, 'Ampara', 'Sainthamaruthu'),
(195, 'Ampara', 'Sammanthurai'),
(196, 'Ampara', 'Thirukkovil'),
(197, 'Ampara', 'Uhana'),
(198, 'Ampara', 'Namal Oya'),
(199, 'Ampara', 'Akkaraipattu'),
(200, 'Kurunegala', 'Alawwa'),
(201, 'Kurunegala', 'Ambanpola'),
(202, 'Kurunegala', 'Bamunakotuwa'),
(203, 'Kurunegala', 'Bingiriya'),
(204, 'Kurunegala', 'Ehetuwewa'),
(205, 'Kurunegala', 'Galgamuwa'),
(206, 'Kurunegala', 'Ganewatta'),
(207, 'Kurunegala', 'Giribawa'),
(208, 'Kurunegala', 'Ibbagamuwa'),
(209, 'Kurunegala', 'Kobeigane'),
(210, 'Kurunegala', 'Kotavehera'),
(211, 'Kurunegala', 'Kuliyapitiya East'),
(212, 'Kurunegala', 'Kuliyapitiya West'),
(213, 'Kurunegala', 'Kurunegala'),
(214, 'Kurunegala', 'Mahawa'),
(215, 'Kurunegala', 'Mallawapitiya'),
(216, 'Kurunegala', 'Maspotha'),
(217, 'Kurunegala', 'Mawathagama'),
(218, 'Kurunegala', 'Narammala'),
(219, 'Kurunegala', 'Nikaweratiya'),
(220, 'Kurunegala', 'Panduwasnuwara East'),
(221, 'Kurunegala', 'Panduwasnuwara West'),
(222, 'Kurunegala', 'Pannala'),
(223, 'Kurunegala', 'Polgahawela'),
(224, 'Kurunegala', 'Polpithigama'),
(225, 'Kurunegala', 'Rasnayakapura'),
(226, 'Kurunegala', 'Rideegama'),
(227, 'Kurunegala', 'Udubaddawa'),
(228, 'Kurunegala', 'Wariyapola'),
(229, 'Kurunegala', 'Weerambugedara'),
(230, 'Puttalam', 'Anamaduwa'),
(231, 'Puttalam', 'Arachchikattuwa'),
(232, 'Puttalam', 'Chilaw'),
(233, 'Puttalam', 'Dankotuwa'),
(234, 'Puttalam', 'Kalpitiya'),
(235, 'Puttalam', 'Karuwalagaswewa'),
(236, 'Puttalam', 'Madampe'),
(237, 'Puttalam', 'Mahakumbukkadawala'),
(238, 'Puttalam', 'Mundalama'),
(239, 'Puttalam', 'Nattandiya'),
(240, 'Puttalam', 'Nawagattegama'),
(241, 'Puttalam', 'Pallama'),
(242, 'Puttalam', 'Puttalam'),
(243, 'Puttalam', 'Vanathavilluwa'),
(244, 'Puttalam', 'Wennappuwa'),
(245, 'Puttalam', 'Mahawewa'),
(246, 'Anuradhapura', 'Galnewa'),
(247, 'Anuradhapura', 'Galenbindunuwewa'),
(248, 'Anuradhapura', 'Horowpothana'),
(249, 'Anuradhapura', 'Ipalogama'),
(250, 'Anuradhapura', 'Kahatagasdigiliya'),
(251, 'Anuradhapura', 'Kekirawa'),
(252, 'Anuradhapura', 'Mahavilachchiya'),
(253, 'Anuradhapura', 'Medawachchiya'),
(254, 'Anuradhapura', 'Mihintale'),
(255, 'Anuradhapura', 'Nachchadoowa'),
(256, 'Anuradhapura', 'Nachtaduwa'),
(257, 'Anuradhapura', 'Nochchiyagama'),
(258, 'Anuradhapura', 'Nuwaragam Palatha Central'),
(259, 'Anuradhapura', 'Nuwaragam Palatha East'),
(260, 'Anuradhapura', 'Padaviya'),
(261, 'Anuradhapura', 'Palagala'),
(262, 'Anuradhapura', 'Palugaswewa'),
(263, 'Anuradhapura', 'Rajanganaya'),
(264, 'Anuradhapura', 'Rambewa'),
(265, 'Anuradhapura', 'Thalawa'),
(266, 'Anuradhapura', 'Thambuttegama'),
(267, 'Anuradhapura', 'Vilachchiya'),
(268, 'Polonnaruwa', 'Dimbulagala'),
(269, 'Polonnaruwa', 'Elahera'),
(270, 'Polonnaruwa', 'Hingurakgoda'),
(271, 'Polonnaruwa', 'Lankapura'),
(272, 'Polonnaruwa', 'Medirigiriya'),
(273, 'Polonnaruwa', 'Thamankaduwa'),
(274, 'Polonnaruwa', 'Welikanda'),
(275, 'Badulla', 'Badulla'),
(276, 'Badulla', 'Bandarawela'),
(277, 'Badulla', 'Ella'),
(278, 'Badulla', 'Haldummulla'),
(279, 'Badulla', 'Hali-Ela'),
(280, 'Badulla', 'Kandaketiya'),
(281, 'Badulla', 'Lunugala'),
(282, 'Badulla', 'Mahiyanganaya'),
(283, 'Badulla', 'Meegahakivula'),
(284, 'Badulla', 'Passara'),
(285, 'Badulla', 'Rideemaliyadda'),
(286, 'Badulla', 'Soranatota'),
(287, 'Badulla', 'Uva Paranagama'),
(288, 'Badulla', 'Welimada'),
(289, 'Badulla', 'Haputale'),
(290, 'Monaragala', 'Badalkumbura'),
(291, 'Monaragala', 'Bibile'),
(292, 'Monaragala', 'Buttala'),
(293, 'Monaragala', 'Kataragama'),
(294, 'Monaragala', 'Madulla'),
(295, 'Monaragala', 'Medagama'),
(296, 'Monaragala', 'Monaragala'),
(297, 'Monaragala', 'Sevanagala'),
(298, 'Monaragala', 'Siyambalanduwa'),
(299, 'Monaragala', 'Thanamalwila'),
(300, 'Monaragala', 'Wellawaya'),
(301, 'Monaragala', 'Badalkumbura'),
(302, 'Monaragala', 'Bibile'),
(303, 'Monaragala', 'Buttala'),
(304, 'Monaragala', 'Kataragama'),
(305, 'Monaragala', 'Madulla'),
(306, 'Monaragala', 'Medagama'),
(307, 'Monaragala', 'Monaragala'),
(308, 'Monaragala', 'Sevanagala'),
(309, 'Monaragala', 'Siyambalanduwa'),
(310, 'Monaragala', 'Thanamalwila'),
(311, 'Monaragala', 'Wellawaya'),
(312, 'Ratnapura', 'Ayagama'),
(313, 'Ratnapura', 'Balangoda'),
(314, 'Ratnapura', 'Embilipitiya'),
(315, 'Ratnapura', 'Godakawela'),
(316, 'Ratnapura', 'Imbulpe'),
(317, 'Ratnapura', 'Kahawatta'),
(318, 'Ratnapura', 'Kalawana'),
(319, 'Ratnapura', 'Kolonna'),
(320, 'Ratnapura', 'Kuruvita'),
(321, 'Ratnapura', 'Nivithigala'),
(322, 'Ratnapura', 'Opanayaka'),
(323, 'Ratnapura', 'Pelmadulla'),
(324, 'Ratnapura', 'Ratnapura'),
(325, 'Ratnapura', 'Weligepola'),
(326, 'Ratnapura', 'Elapatha'),
(327, 'Ratnapura', 'Kiriella'),
(328, 'Ratnapura', 'Rathnapura Four Gravets'),
(329, 'Kegalle', 'Aranayaka'),
(330, 'Kegalle', 'Bulathkohupitiya'),
(331, 'Kegalle', 'Dehiowita'),
(332, 'Kegalle', 'Deraniyagala'),
(333, 'Kegalle', 'Galigamuwa'),
(334, 'Kegalle', 'Kegalle'),
(335, 'Kegalle', 'Mawanella'),
(336, 'Kegalle', 'Rambukkana'),
(337, 'Kegalle', 'Ruwanwella'),
(338, 'Kegalle', 'Warakapola'),
(339, 'Kegalle', 'Yatiyantota');

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
(13, 37, '26_6a57292656736_133508394_8b6a2438-9b01-4305-90c9-b2c97bf50b77.jpg', 'image/jpeg', '../uploads/evidence/ReportID_37/26_6a57292656736_133508394_8b6a2438-9b01-4305-90c9-b2c97bf50b77.jpg', '2026-07-15 06:31:02'),
(14, 38, '26_6a582e07626f4_9074a68f86e0f006a9ec7183530e66c0.jpg', 'image/jpeg', '../uploads/evidence/ReportID_38/26_6a582e07626f4_9074a68f86e0f006a9ec7183530e66c0.jpg', '2026-07-16 01:04:07'),
(15, 39, '26_6a58582cf3c8f_File Design.pdf', 'application/pdf', '../uploads/evidence/ReportID_39/26_6a58582cf3c8f_File Design.pdf', '2026-07-16 04:03:56'),
(16, 40, '32_6a5bc891274e0_AAA (1).pdf', 'application/pdf', '../uploads/evidence/ReportID_40/32_6a5bc891274e0_AAA (1).pdf', '2026-07-18 18:40:17'),
(17, 41, '32_6a5bc9aedd683_videoframe_4502.png', 'image/png', '../uploads/evidence/ReportID_41/32_6a5bc9aedd683_videoframe_4502.png', '2026-07-18 18:45:02'),
(18, 42, '32_6a5bed3f71230_videoframe_4502.png', 'image/png', '../uploads/evidence/ReportID_42/32_6a5bed3f71230_videoframe_4502.png', '2026-07-18 21:16:47'),
(19, 43, '32_6a5bedaed4861_9074a68f86e0f006a9ec7183530e66c0.jpg', 'image/jpeg', '../uploads/evidence/ReportID_43/32_6a5bedaed4861_9074a68f86e0f006a9ec7183530e66c0.jpg', '2026-07-18 21:18:38'),
(20, 44, '32_6a5bf00784771_videoframe_4502.png', 'image/png', '../uploads/evidence/ReportID_44/32_6a5bf00784771_videoframe_4502.png', '2026-07-18 21:28:39'),
(21, 45, '32_6a5bf0e7c98fc_videoframe_4502.png', 'image/png', '../uploads/evidence/ReportID_45/32_6a5bf0e7c98fc_videoframe_4502.png', '2026-07-18 21:32:23'),
(22, 46, '32_6a5c2eee7a0b3_1689416305401.jpg', 'image/jpeg', '../uploads/evidence/ReportID_46/32_6a5c2eee7a0b3_1689416305401.jpg', '2026-07-19 01:57:02'),
(23, 47, '32_6a5f58e30912f_1689416305401.jpg', 'image/jpeg', '../uploads/evidence/ReportID_47/32_6a5f58e30912f_1689416305401.jpg', '2026-07-21 11:32:51'),
(24, 48, '32_6a5f59650e4da_1689416305401.jpg', 'image/jpeg', '../uploads/evidence/ReportID_48/32_6a5f59650e4da_1689416305401.jpg', '2026-07-21 11:35:01'),
(25, 49, '26_6a572201f2238_DSE 22.1F Database Management Systems.pdf', 'image/jpeg', '../uploads/evidence/ReportID_49/26_6a572201f2238_DSE 22.1F Database Management Systems.pdf', '2026-07-21 11:52:29'),
(26, 49, '32_6a5f825e5a568_1689416305401.jpg', 'image/jpeg', '../uploads/evidence/ReportID_50/32_6a5f825e5a568_1689416305401.jpg', '2026-07-21 14:29:50'),
(27, 51, '32_6a5f826e84385_videoframe_4502.png', 'image/png', '../uploads/evidence/ReportID_51/32_6a5f826e84385_videoframe_4502.png', '2026-07-21 14:30:06'),
(28, 52, '32_6a5f82884f54f_1689416305401.jpg', 'image/jpeg', '../uploads/evidence/ReportID_52/32_6a5f82884f54f_1689416305401.jpg', '2026-07-21 14:30:32'),
(29, 53, '32_6a60a104327c8_1689416305401.jpg', 'image/jpeg', '../uploads/evidence/ReportID_53/32_6a60a104327c8_1689416305401.jpg', '2026-07-22 10:52:52'),
(30, 54, '32_6a60a29853457_videoframe_4502.png', 'image/png', '../uploads/evidence/ReportID_54/32_6a60a29853457_videoframe_4502.png', '2026-07-22 10:59:36'),
(31, 55, '32_6a60a4fa1b3a6_videoframe_4502.png', 'image/png', '../uploads/evidence/ReportID_55/32_6a60a4fa1b3a6_videoframe_4502.png', '2026-07-22 11:09:46'),
(32, 56, '32_6a60a50d2e916_videoframe_4502.png', 'image/png', '../uploads/evidence/ReportID_56/32_6a60a50d2e916_videoframe_4502.png', '2026-07-22 11:10:05'),
(33, 57, '32_6a60a533401af_videoframe_4502.png', 'image/png', '../uploads/evidence/ReportID_57/32_6a60a533401af_videoframe_4502.png', '2026-07-22 11:10:43'),
(34, 58, '32_6a60c8128fe56_1689416305401.jpg', 'image/jpeg', '../uploads/evidence/ReportID_58/32_6a60c8128fe56_1689416305401.jpg', '2026-07-22 13:39:30'),
(35, 59, '26_6a62722072021_62cff4-2c67f2.png', 'image/png', '../uploads/evidence/ReportID_59/26_6a62722072021_62cff4-2c67f2.png', '2026-07-23 19:57:20'),
(36, 60, '26_6a62749e842d1_62cff4-2c67f2.png', 'image/png', '../uploads/evidence/ReportID_60/26_6a62749e842d1_62cff4-2c67f2.png', '2026-07-23 20:07:58'),
(37, 61, '26_6a6274fb77829_62cff4-2c67f2.png', 'image/png', '../uploads/evidence/ReportID_61/26_6a6274fb77829_62cff4-2c67f2.png', '2026-07-23 20:09:31'),
(38, 62, '32_6a64aa4f5d8d9_26_6a572201f2238_DSE 22.1F Database Management Systems.pdf', 'application/pdf', '../uploads/evidence/ReportID_62/32_6a64aa4f5d8d9_26_6a572201f2238_DSE 22.1F Database Management Systems.pdf', '2026-07-25 12:21:35'),
(39, 63, '32_6a662963880cb_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', 'application/pdf', '../uploads/evidence/ReportID_63/32_6a662963880cb_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', '2026-07-26 15:36:03'),
(40, 64, '32_6a6631da566ca_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', 'application/pdf', '../uploads/evidence/ReportID_64/32_6a6631da566ca_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', '2026-07-26 16:12:10'),
(41, 65, '32_6a6633573cea8_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', 'application/pdf', '../uploads/evidence/ReportID_65/32_6a6633573cea8_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', '2026-07-26 16:18:31'),
(42, 66, '32_6a663362bab2a_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', 'application/pdf', '../uploads/evidence/ReportID_66/32_6a663362bab2a_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', '2026-07-26 16:18:42'),
(43, 67, '32_6a663380e7614_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', 'application/pdf', '../uploads/evidence/ReportID_67/32_6a663380e7614_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', '2026-07-26 16:19:12'),
(44, 68, '32_6a66341026011_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', 'application/pdf', '../uploads/evidence/ReportID_68/32_6a66341026011_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', '2026-07-26 16:21:36'),
(45, 69, '32_6a663718af881_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', 'application/pdf', '../uploads/evidence/ReportID_69/32_6a663718af881_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', '2026-07-26 16:34:32'),
(46, 70, '32_6a6637bd2c6a1_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', 'application/pdf', '../uploads/evidence/ReportID_70/32_6a6637bd2c6a1_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', '2026-07-26 16:37:17'),
(47, 71, '32_6a663838b99d0_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', 'application/pdf', '../uploads/evidence/ReportID_71/32_6a663838b99d0_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', '2026-07-26 16:39:20'),
(48, 72, '32_6a663850e883c_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', 'application/pdf', '../uploads/evidence/ReportID_72/32_6a663850e883c_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', '2026-07-26 16:39:44'),
(49, 73, '32_6a6638727b46e_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', 'application/pdf', '../uploads/evidence/ReportID_73/32_6a6638727b46e_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', '2026-07-26 16:40:18'),
(50, 74, '32_6a663884324b7_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', 'application/pdf', '../uploads/evidence/ReportID_74/32_6a663884324b7_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', '2026-07-26 16:40:36'),
(51, 75, '32_6a6638a731c3a_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', 'application/pdf', '../uploads/evidence/ReportID_75/32_6a6638a731c3a_Post_Disaster_Reporting_System_File_Design_Diagram.pdf', '2026-07-26 16:41:11');

-- --------------------------------------------------------

--
-- Table structure for table `financial_officer`
--

CREATE TABLE `financial_officer` (
  `User_ID` int(11) NOT NULL,
  `Financial_Officer_ID` varchar(20) DEFAULT NULL,
  `Department` varchar(100) DEFAULT NULL,
  `Bank_Name` varchar(255) DEFAULT NULL,
  `Bank_Account_No` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `financial_officer`
--

INSERT INTO `financial_officer` (`User_ID`, `Financial_Officer_ID`, `Department`, `Bank_Name`, `Bank_Account_No`) VALUES
(47, 'ASDAD', 'ADA', 'DAD', 'AD'),
(78, 'FO0001', 'Finance Division', 'Bank of Ceylon', '742100010001'),
(79, 'FO0002', 'Finance Division', 'People\'s Bank', '742100010002'),
(80, 'FO0003', 'Finance Division', 'Commercial Bank', '7421000104'),
(81, 'FO0004', 'Finance Division', 'SampathBank', '742106500104');

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
(37, '', 0, 'default', 'Moderate'),
(44, '', 0, 'default', ''),
(51, '', 0, 'default', ''),
(67, '', 0, 'default', ''),
(73, '', 0, 'default', '');

-- --------------------------------------------------------

--
-- Table structure for table `local_authority_officer`
--

CREATE TABLE `local_authority_officer` (
  `User_ID` int(11) NOT NULL,
  `Local_Officer_ID` varchar(20) DEFAULT NULL,
  `Position` varchar(100) DEFAULT NULL,
  `Assigned_divisional_secretariat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `local_authority_officer`
--

INSERT INTO `local_authority_officer` (`User_ID`, `Local_Officer_ID`, `Position`, `Assigned_divisional_secretariat`) VALUES
(26, '1', NULL, 1),
(51, 'LAO0001', 'Local Authority Officer', 86),
(52, 'LAO0002', 'Local Authority Officer', 85),
(53, 'LAO0003', 'Local Authority Officer', 82),
(54, 'LAO0004', 'Local Authority Officer', 83),
(55, 'LAO0005', 'Local Authority Officer', 87),
(56, 'LAO0006', 'Local Authority Officer', 76),
(59, 'LAO0007', 'Local Authority Officer', 88),
(60, 'LAO0008', 'Local Authority Officer', 84),
(61, 'LAO0009', 'Local Authority Officer', 79),
(62, 'LAO0010', 'Local Authority Officer', 91),
(63, 'LAO0011', 'Local Authority Officer', 92),
(64, 'LAO0012', 'Local Authority Officer', 75),
(65, 'LAO0013', 'Local Authority Officer', 93),
(66, 'LAO0014', 'Local Authority Officer', 78),
(67, 'LAO0015', 'Local Authority Officer', 77),
(68, 'LAO0016', 'Local Authority Officer', 89),
(69, 'LAO0017', 'Local Authority Officer', 80),
(70, 'LAO0018', 'Local Authority Officer', 81),
(71, 'LAO0019', 'Local Authority Officer', 90);

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
(36, '', 0, 'default', '', '0000-00-00', '00:00:00', NULL, ''),
(45, '', 0, 'default', '', '0000-00-00', '00:00:00', NULL, ''),
(52, 'asasda', 65, 'default', 'adasdada', '0000-00-00', '00:00:00', NULL, ''),
(69, '', 0, 'default', '', '0000-00-00', '00:00:00', NULL, ''),
(70, '', 0, 'default', '', '0000-00-00', '00:00:00', NULL, ''),
(74, '', 0, 'default', '', '0000-00-00', '00:00:00', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `Notification_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Report_ID` int(11) NOT NULL,
  `Notification_Title` varchar(150) NOT NULL,
  `Notification_Message` text NOT NULL,
  `Notification_Type` varchar(50) NOT NULL,
  `Is_Read` tinyint(1) NOT NULL DEFAULT 0,
  `Created_At` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`Notification_ID`, `User_ID`, `Report_ID`, `Notification_Title`, `Notification_Message`, `Notification_Type`, `Is_Read`, `Created_At`) VALUES
(1, 26, 61, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 1, '2026-07-24 01:39:31'),
(2, 26, 62, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 1, '2026-07-25 17:51:35'),
(3, 26, 63, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-26 21:06:03'),
(4, 53, 64, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-26 21:42:10'),
(5, 69, 66, 'New Death Report', 'A new Death Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-26 21:48:42'),
(6, 60, 67, 'New Injured Person Report', 'A new Injured Person Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-26 21:49:12'),
(7, 61, 68, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-26 21:51:36'),
(8, 52, 69, 'New Missing Person Report', 'A new Missing Person Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-26 22:04:32'),
(9, 70, 70, 'New Missing Person Report', 'A new Missing Person Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-26 22:07:17'),
(10, 53, 71, 'New Death Report', 'A new Death Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-26 22:09:20'),
(11, 65, 72, 'New Death Report', 'A new Death Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-26 22:09:44'),
(12, 67, 73, 'New Injured Person Report', 'A new Injured Person Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-26 22:10:18'),
(13, 71, 74, 'New Missing Person Report', 'A new Missing Person Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-26 22:10:36'),
(14, 69, 75, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-26 22:11:11');

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
(11, 6, '677207', '2026-07-08 03:49:15', 1, '2026-07-08 01:44:15'),
(12, 6, '198329', '2026-07-16 03:11:08', 1, '2026-07-16 01:06:08'),
(13, 6, '830909', '2026-07-16 06:13:52', 1, '2026-07-16 04:08:52'),
(14, 6, '908020', '2026-07-22 14:29:30', 1, '2026-07-22 12:24:30');

-- --------------------------------------------------------

--
-- Table structure for table `property_damage`
--

CREATE TABLE `property_damage` (
  `Report_ID` int(11) NOT NULL,
  `Property_Type` varchar(100) NOT NULL,
  `Damage_Level` enum('Minor','Moderate','Major','Destroyed') NOT NULL,
  `Damage_Description` text DEFAULT NULL,
  `Estimated_Cost` decimal(12,2) DEFAULT NULL,
  `Latitude` decimal(10,8) DEFAULT NULL,
  `Longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_damage`
--

INSERT INTO `property_damage` (`Report_ID`, `Property_Type`, `Damage_Level`, `Damage_Description`, `Estimated_Cost`, `Latitude`, `Longitude`) VALUES
(38, 'default', '', '', 0.00, NULL, NULL),
(39, 'default', '', '', 0.00, NULL, NULL),
(40, 'default', '', '', 0.00, NULL, NULL),
(41, 'default', '', '', 0.00, NULL, NULL),
(46, 'rHouse', 'Moderate', '', 231332.00, 6.04043514, 80.22849507),
(47, 'default', '', '', 0.00, 0.00000000, 0.00000000),
(48, 'default', '', '', 0.00, 0.00000000, 0.00000000),
(49, 'default', 'Minor', 'asasasa', 0.00, 0.00000000, 0.00000000),
(59, 'agrLand', 'Minor', 'fdgdfg', 13123.00, 6.18324300, 80.11229700),
(60, 'agrLand', 'Minor', 'fdgdfg', 13123.00, 6.18324300, 80.11229700),
(61, 'agrLand', 'Minor', 'fdgdfg', 13123.00, 6.18324300, 80.11229700),
(62, 'default', '', '', 0.00, 0.00000000, 0.00000000),
(63, 'default', '', '', 0.00, 0.00000000, 0.00000000),
(64, 'default', '', '', 0.00, 0.00000000, 0.00000000),
(68, 'default', '', '', 0.00, 0.00000000, 0.00000000),
(75, 'default', '', '', 0.00, 0.00000000, 0.00000000);

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
  `Role_ID` int(11) NOT NULL,
  `User_Status` enum('Active','Banned') NOT NULL DEFAULT 'Active',
  `Created_Date` datetime NOT NULL DEFAULT current_timestamp(),
  `Profile_Picture` varchar(255) NOT NULL DEFAULT 'Default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `Username`, `Password`, `Full_Name`, `Gender`, `NIC`, `Email`, `Phone_Number`, `Address`, `Role_ID`, `User_Status`, `Created_Date`, `Profile_Picture`) VALUES
(6, 'Admin', '$2y$10$wYr7YpeuBI7bFXltOqi2CuzNgYRJUDfcO4dH/5/17o08xlSJznxKy', 'Malisha Madhusith', 'Male', '200304811656', 'malishashadowflame99@gmail.com', '0766511220', 'Galleaa', 1, 'Active', '2026-07-22 12:12:34', '6_20260722_230543.jpg'),
(9, 'MM@17', '$2y$10$vCXQHNooJBiH4qvxsOyMaemZIfsl7xxxv4paYtPrLIE/WPPiw7zfe', 'Malisha Madhusith', 'Male', '200304811656', 'malisha99@gmail.com', '0766511220', 'Malavigewatta,', 1, 'Active', '2026-07-22 12:12:34', 'Default'),
(11, 'ABC', '$2y$10$FIITcBMLwPFDQeNkCIhSye8s6oyA39XImPvOrU9VbHW8BUNcMgNIW', 'abc', 'Male', '200304811655', 'malishashado@gmail.com', '0766511220', 'galle', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(14, 'as', '$2y$10$YENTnCSD27sazAzT7SftUuANVsgEcpE7zTSYUdrO9cU/dl4AgOoqG', 'as', '', '', '', '', '', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(19, 'Kasun@123', '$2y$10$L9.Ml8AbgFQUbhhUauwYxOOhysxbK2iz63akTE3X9XCPTeGYlFXde', 'Kasun Dananjaya', 'Male', '200304811656', 'AAAAA@gmail.com', '0766511220', 'Colombo', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(20, 'Madu@123', '$2y$10$Afuvp17dwAB1EK3V/DDR0OhQEC1NdEk.aNLZbiEnL8SXNhDx6X1im', 'Madushi Kalansoooriya', 'Female', '200304811656', 'AAA@gmail.com', '0766511220', 'Colombo', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(21, 'ASD123', '$2y$10$Cjk7CsqrShTnnsabPAB1g.cgMx0VawPWikzlKf8RxZr/rRGKLTsA2', 'Asanka Sampath Dananjaya', 'Male', '200304568596', 'AsankaSD@gmail.com', '0778899665', 'Kurunegala', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(22, 'charin', '$2y$10$jwJxmkgI9BBLns5BXJMnd.uDSbforiJCCQ3QIfuUj0tCtcbFrYf4y', 'charindu gayashan', 'Male', '200512700610', 'charindu@gmail.com', '0762352086', 'galle', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(26, 'charindu', '$2y$10$TxVu6.HZBGZNYJr9.N4wAOFGpSAVdgZZaznXeaUZJvs9F.5Vze6Eq', 'Charindu Gayashan', 'Male', '200512700610', 'charindugayashan00@gmail.com', '0762352086', 'galle', 3, 'Active', '2026-07-22 12:12:34', '26_20260725_230436.jpeg'),
(27, 'AAA', '$2y$10$zr22onqR0GJAgs.y2M5z5.5mk3nhPKqK0p9O7mC9qbXKBio4qDBsW', 'AAA', 'Male', '200304811654', 'asda@gmail.com', '0766511223', 'Galle', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(28, 'DS', '$2y$10$K7dz2nAvdSdMICRVgjRaHuR3mfn4cCIRaOkUEsqsYDeetwOItmZ0K', 'district secretary', 'Male', '200304568952', 'DS@gmail.com', '0755899663', 'Galle', 5, 'Active', '2026-07-22 12:12:34', '28_20260725_160125.png'),
(29, 'LOF', '$2y$10$cdD18ckAbSJDasQ7WTUF0eEwdkBj8U29XI2K9.uuwG4EYZKR6jBPO', 'Local Authority Officer', 'Male', '200546568956', 'LOF@gmail.com', '0456633221', 'Galle', 4, 'Active', '2026-07-22 12:12:34', 'Default'),
(30, 'DMO', '$2y$10$sYlC/BotKLirMNOTkiVLIOtc9wJz67I4FYFbibhhB1q7BAqyPg1hy', 'Disaster Managment Officer', 'Male', '200563254123', 'DMO@gmail.com', '0766588552', 'Galle', 2, 'Active', '2026-07-22 12:12:34', '30_20260725_223924.jpg'),
(31, 'FO', '$2y$10$OIWerh3Mt2DpNoJO.aYEQuGI2nwVDFywXcNVwmpDzz48w3PD/WwZS', 'Financial Officer', 'Male', '200345889966', 'FO@gmail.com', '0766544882', 'Colombo', 6, 'Active', '2026-07-22 12:12:34', '31_20260724_235359.png'),
(32, 'CT', '$2y$10$vXZ5gdY3pgKurzULxMmLH.m3Tanh13Ll1XnXfatDSb8Wn8obxLwnK', 'Citizen', 'Female', '200304589966', 'CT@gmail.com', '0755899667', 'Galle', 3, 'Active', '2026-07-22 12:12:34', '32_20260722_230342.png'),
(34, 'adcas', '$2y$10$4A2YTBjhGrz.s.LLY.PU2uIfNRu9ZlipvWtojggYjpGdNsRg6stAu', 'ascasc', 'Male', '200304556633', 'aoudhaisoasiai@gmail.com', '0758966332', 'ascasc', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(36, 'asdaad', '$2y$10$WjiVr5a9sARcFBghKR130ea7g3lLDyDAE7JUKzCbTrHPOacZVa28G', 'asdad', 'Male', '200356889977', 'aoudasoasiai@gmail.com', '0758966337', 'asasasa', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(37, 'asda', '$2y$10$yxttHGmScCxZIiB5f1US0OriqVaAe8AK6TAApSmBSfwV52DYGPd16', 'asdads', 'Male', '200304556633', 'asqwqqasda@gmail.com', '0777777777', 'acasc', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(38, 'asdada', '$2y$10$/w/u3M1o/VT0Ag050oYzbuyKAC18Wb9WLNtNAw7hFLi.SLhKavUpW', 'sdasdasd', 'Male', '200304556633', 'CT@gmail.coma', '0000000000', 'acasc', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(41, 'dw', '$2y$10$rH8XAnaBuzB9ApmV5PGUSO30zRNAZOWTVVEl8olYbwfRVYDelVR4m', 'Malisha Madhusith', 'Female', '200304811693', 'malishamadhusith72@gmail.coma', '0766511220', 'asasasa', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(42, 'dasd', '$2y$10$N2gRi1mjBpWOncB0.tGyYeVFldvBFNzyRmhNJ10iiRumjPzROoAsS', 'asdsa', 'Male', '200304811693', 'malisashamadhusith72@gmail.com', '0766511220', 'asasasa', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(43, 'j65', '$2y$10$Q5fiidYslGFDjL1c5ptFWuPSpUlgva2BDh0.xyvo25bkbWZqaSGAq', 'Malisha Madhusith', 'Male', '200304811693', 'maishamadhusith72@gmail.com', '0766511220', 'asasasa', 3, 'Banned', '2026-07-22 12:12:34', 'Default'),
(44, 'ugytd', '$2y$10$ALmPYyT2eoKwIKi.oyu1cO3xkxq3Pnr4ffXLmaMpeY6RiUG0zQNMC', 'asdsaasdasdasdaasdadsadadadaad', 'Male', '200304811693', 'malishusith72@gmail.com', '0766511220', 'asasasa', 3, 'Banned', '2026-07-22 12:12:34', 'Default'),
(45, 'asas', '$2y$10$sBdgJ9tYoMb7yIDyPFyz4uLAvxnmn3xTZ0JEPicTeb5BelLkbGLo6', 'Malisha Madhusith', 'Male', '200304811656', 'malishasamadhkjhusith72@gmail.com', '0777777777', 'asdasd', 5, 'Banned', '2026-07-22 12:12:34', 'Default'),
(46, 'asdasd', '$2y$10$HeVGRPS3aLmsiquf.A3crOwhV1Yq90IXxzAqSXaRA7s0kcmqFkUt6', 'Citizen', 'Male', '200304556633', 'Galle@gmail.com', '0777788996', 'Galle', 3, 'Active', '2026-07-22 17:39:25', 'Default'),
(47, 'FOASDAD', '$2y$10$iv5o1CA8Nv5kW.HeEgRYquG6vwvk0D1SDLrI.YVyITVhzDQLfUAFO', 'Malisha Madhusith', 'Female', '200304556666', 'malishamadhusith72@gmail.com', '0766511220', 'SADDSAD', 6, 'Active', '2026-07-25 02:40:35', 'Default.png'),
(48, 'AdminAass', '$2y$10$xBxZNlxj3oxv3fJeDuxno.zRuEcDT9VlciahjWhXRNxkDldGaqvCu', 'Malisha Madhusith', 'Female', '200304556666', 'malishaasamadhusith72@gmail.com', '0766511220', 'ASDADAD', 5, 'Active', '2026-07-25 03:42:37', 'Default.png'),
(49, 'AdminaSDFGHJK', '$2y$10$Q9IGfIYm5MUG/u9pVQw5ZurQCfFveqC3CIwwTOiBLvKeio991L/Ua', 'Malisha Madhusith', 'Female', '200304556666', 'malixzZXshamadhusith72@gmail.com', '0766511220', 'ASDADAD', 2, 'Active', '2026-07-25 03:50:07', 'Default.png'),
(50, 'AdminASASSASAS', '$2y$10$nzLPLD9wjcikOH/LAC3yUen8u7YeWJtghbIWYiE8VFC0NOmdYP/lG', 'Malisha Madhusith', 'Male', '200304556666', 'maliSFASAxzZXshamadhusith72@gmail.com', '0766511220', 'ASDADAD', 5, 'Active', '2026-07-25 14:23:16', 'Default.png'),
(51, 'lao_galle01', '$2y$10$0SUnuquIe053ojNya4yCt.kZqNi0ybpQwoSHG/JuOvNsWb6xZEQ2C', 'Nimal Perera', 'Male', '901234567V', 'nimal.perera01@gmail.com', '0712345001', '15 Main Street, Galle', 4, 'Active', '2026-07-26 19:29:29', 'Default.png'),
(52, 'lao_galle02', '$2y$10$w3skFkdDt.wG.tydhMORo.tzKYOJuzZXNj5MZyqpUTec9i2Q4N1i6', 'Kasun Silva', 'Male', '911234568V', 'kasun.silva02@gmail.com', '0712345002', '22 Temple Road, Galle', 4, 'Active', '2026-07-26 19:31:29', 'Default.png'),
(53, 'lao_galle03', '$2y$10$jWyqOR758GSPvsbZwuc5Y.XHZb8SNVuYV9DmaicVs2e0VxaCHVe7u', 'Dilani Fernando', 'Female', '925678901V', 'dilani.fernando01@gmail.com', '0712345003', '18 Station Road, Galle', 4, 'Active', '2026-07-26 19:34:15', 'Default.png'),
(54, 'lao_galle04', '$2y$10$RxDSbKxZlqkz.bfWhFt/Z.oKo0p4di9K6KtaHZ1u9rYfR93i9nQE6', 'Tharindu Jayasinghe', 'Male', '931234570V', 'tharindu.jaya02@gmail.com', '0712345004', '18 Station Road, Galle', 4, 'Active', '2026-07-26 19:42:07', 'Default.png'),
(55, 'lao_galle05', '$2y$10$5Ynr7N4JpaDHfANz2yU70OSOVCo0tFj0uSEusPfhmzX.sVRvj.x9a', 'Sanduni Wickramasinghe', 'Female', '946789012V', 'sanduni.w01@gmail.com', '0712345005', '11 Lake Road, Galle', 4, 'Active', '2026-07-26 19:43:43', 'Default.png'),
(56, 'lao_galle06', '$2y$10$wdqXo6.2HdtqJ9YsUaXJ4OIIh7QF55qgXRPe6TUFV80g15ZrVBoDq', 'Chamara Rajapaksha', 'Male', '951234571V', 'chamara.r02@gmail.com', '0712345006', '77 New Town, Galle', 4, 'Active', '2026-07-26 19:45:57', 'Default.png'),
(59, 'lao_galle07', '$2y$10$20cp032/qPp5xMvkyqBdeuiCUpFuS4OrJ9p0IKAi9t2fJKHRIWiaC', 'Iresha De Silva', 'Female', '967890123V', 'iresha.ds01@gmail.com', '0712345007', '29 River Road, Galle', 4, 'Active', '2026-07-26 19:53:43', 'Default.png'),
(60, 'lao_galle08', '$2y$10$tCG0EdbKdNEUKwR8ctYluu1a7wNhgWQ4E4PbukOHq58FhYycGd9ci', 'Pradeep Kumara', 'Male', '971234572V', 'pradeep.k02@gmail.com', '0712345008', '35 Market Street, Galle', 4, 'Active', '2026-07-26 19:55:26', 'Default.png'),
(61, 'lao_galle09', '$2y$10$.T80N.n6dEcfAnEBPEgeS.BynGq67QPALlELWbfB5B3LMLY98wmG6', 'Upeksha Senanayake', 'Female', '987654321V', 'upeksha.s01@gmail.com', '0712345009', '66 Hill Road, Galle', 4, 'Active', '2026-07-26 19:56:55', 'Default.png'),
(62, 'lao_galle10', '$2y$10$itIbzV5G2eN/94I0YVeraeud0a8t.8BS1.QEAbWwHhvHyJftzsN0C', 'Roshan Bandara', 'Male', '991234573V', 'roshan.b02@gmail.com', '0712345010', '90 Temple Junction, Galle', 4, 'Active', '2026-07-26 19:58:23', 'Default.png'),
(63, 'lao_galle11', '$2y$10$xmlXCOqE.JLcI1KaqYwQQOVcW4p/N1kZn66U3sbnO5rgiM8f32xs6', 'Asanka Wijesinghe', 'Male', '900112345V', 'asanka.w01@gmail.com', '0712345011', '12 Peradeniya Road, Galle', 4, 'Active', '2026-07-26 19:59:24', 'Default.png'),
(64, 'lao_galle12', '$2y$10$G43nyOxFRmzVNvlqAx9tLO1UuAGgj91qlxgB457Lr6yLbCLCIO.Gq', 'Sachini Perera', 'Female', '920112346V', 'sachini.p02@gmail.com', '0712345012', '45 Katugastota Road, Galle', 4, 'Active', '2026-07-26 20:00:21', 'Default.png'),
(65, 'lao_galle13', '$2y$10$nALunwW42tU8Fa6lputqEunp9XX8suXaVtpBsDyzzqRdb6Oj/G2DG', 'Ravindu Jayawardena', 'Male', '930112347V', 'ravindu.j01@gmail.com', '0712345013', '78 William Gopallawa Mawatha, Galle', 4, 'Active', '2026-07-26 20:01:31', 'Default.png'),
(66, 'lao_galle14', '$2y$10$U2QXYYqlEHP/K9eSNqwGQOLciehy.JhGFOCy7AoZxs4JVGYInfd5.', 'Nadeesha Fernando', 'Female', '940112348V', 'nadeesha.f02@gmail.com', '0712345014', '78 William Gopallawa Mawatha, Galle', 4, 'Active', '2026-07-26 20:02:12', 'Default.png'),
(67, 'lao_galle15', '$2y$10$UPMn.CSsjyVenFLrrClzY.HZwsB4w0sUPSsqrTwc7JkpQXgyS1MmW', 'Janaka Madushan', 'Male', '950112349V', 'janaka.m03@gmail.com', '0712345015', '78 William Gopallawa Mawatha, Galle', 4, 'Active', '2026-07-26 20:03:02', 'Default.png'),
(68, 'lao_galle16', '$2y$10$7vIdCHBY.FLVt5tSrKDwY.M7kYm6YEhNyNtUfxOFsIAuXvsMpKar2', 'Hiruni Ekanayake', 'Female', '960112350V', 'hiruni.e04@gmail.com', '0712345016', '31 Rajapihilla Mawatha, Galle', 4, 'Active', '2026-07-26 20:03:56', 'Default.png'),
(69, 'lao_galle17', '$2y$10$9JBjE4Rc9e5tbBo7s0o/nO6ha/3d5ByzJaAgqra/Tk.Y9iACURaiS', 'Thilina Gunawardana', 'Male', '970112351V', 'thilina.e04@gmail.com', '0712345017', '54 Dharmaraja Mawatha, Galle', 4, 'Active', '2026-07-26 20:06:23', 'Default.png'),
(70, 'lao_galle18', '$2y$10$u.S8h1OVj78u0RmpGFcbGep66PJ6MQpbU3r2wx2DencPvCGmRWYJS', 'Udeshika Karunaratne', 'Female', '980112352V', 'udeshika.k03@gmail.com', '0712345018', '17 Heerassagala Road, Galle', 4, 'Active', '2026-07-26 20:07:32', 'Default.png'),
(71, 'lao_galle19', '$2y$10$TBY9H6LUmikg1UHZ0XeatOgyrTEpKwnJRTmma2fiDiMyHnNUGzX1O', 'Chamath Bandara', 'Male', '990112353V', 'chamath.k03@gmail.com', '0712345019', '17 Ampitiya Road, Galle', 4, 'Active', '2026-07-26 20:08:48', 'Default.png'),
(73, 'dmo_galle01', '$2y$10$cu0Z4qxEiCzL4bcJ2AXJjeFeBgAkj6j2WnytVaqR25YKKAbVKJHde', 'Ruwan Jayawardena', 'Male', '801234501V', 'ruwan.dmo01@gmail.com', '0717700001', '15 Main Street, Galle', 2, 'Active', '2026-07-26 20:21:52', 'Default.png'),
(74, 'ds_galle01', '$2y$10$237vCQd7et337BUABxTCpuT/0vtNB9hcpXZ1Qsyn/igga4kBsEDZa', 'Mahinda Jayasinghe', 'Male', '721234501V', 'mahinda.ds01@gmail.com', '0718800001', '15 Main Street, Galle', 5, 'Active', '2026-07-26 20:25:10', 'Default.png'),
(75, 'ds_colombo01', '$2y$10$lUbJHTrjIBT8MDN.VEnV1uKSWzwi8k48EWx.dI4ztxR85YHdztcCC', 'Nadeeka Perera', 'Female', '741234502V', 'nadeeka.ds02@gmail.com', '0718800002', '6 Ampitiya Road, Colombo', 5, 'Active', '2026-07-26 20:26:47', 'Default.png'),
(76, 'ds_gampaha01', '$2y$10$d0nzxp3j1FbhURBiFbreB.FRrrzUHCofvBwV7PDI5manKS8GiIraW', 'Chathurika Silva', 'Female', '781234504V', 'chathurika.ds02@gmail.com', '0718800004', '6 Ampitiya Road, Gampaha', 5, 'Active', '2026-07-26 20:28:50', 'Default.png'),
(77, 'ds_matara01', '$2y$10$uGBvrbawUOGRbYmV7E1FFOVVa..g34cNgFYhAqm8zMca.bztqAwSG', 'Roshan Wijesinghe', 'Male', '781237504V', 'roshan.ds02@gmail.com', '0718800007', '6 Ampitiya Road, Matara', 5, 'Active', '2026-07-26 20:29:50', 'Default.png'),
(78, 'fo_0001', '$2y$10$gYrAIKf261.DvkDsrw0NLezDl8t8mS4PS4Snw3AcMznbDfFk9hNni', 'Nuwan Perera', 'Male', '801567801V', 'nuwan.fo01@gmail.com', '0719900001', '15 Peradeniya Road, Kandy', 6, 'Active', '2026-07-26 20:32:38', 'Default.png'),
(79, 'fo_0002', '$2y$10$IK2Xl.wdumlZFrv/A64OX.9PEzeP3deafSO7b.eT83lLdTmlMyT6a', 'Chamari Silva', 'Female', '811567801V', 'chamari.fo01@gmail.com', '0719900002', '24 Katugastota Road, Galle', 6, 'Active', '2026-07-26 20:34:05', 'Default.png'),
(80, 'fo_0003', '$2y$10$2T.75xC6f5xYv.Umdga10uvL5gXtrJAryKJpRbxXBdkDFW.b7kHWO', 'Roshan Fernando', 'Male', '841567803V', 'roshan.fo01@gmail.com', '0719900002', '24 Katugastota Road, Colombo', 6, 'Active', '2026-07-26 20:37:17', 'Default.png'),
(81, 'fo_0004', '$2y$10$xv8JCi/Tb9lvA1kvT/YB6.oC6Epv11yqyjsNBPQI8R3lfjgvl1E.u', 'Nadeesha Jayawardena', 'Female', '861567804V', 'nadeesha.fo01@gmail.com', '0719900007', '24 Katugastota Road, Gampaha', 6, 'Active', '2026-07-26 20:38:36', 'Default.png'),
(82, 'galle_user01', 'CT123456', 'Kasun Maduranga', 'Male', '200001234567', 'kasun.maduranga01@gmail.com', '0712345001', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(83, 'galle_user02', 'CT123456', 'Nimali Perera', 'Female', '200102345678', 'nimali.perera02@gmail.com', '0722345002', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(84, 'galle_user03', 'CT123456', 'Tharindu Fernando', 'Male', '199903456789', 'tharindu.fernando03@gmail.com', '0752345003', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(85, 'galle_user04', 'CT123456', 'Sachini Dilrukshi', 'Female', '200004567890', 'sachini.dilrukshi04@gmail.com', '0762345004', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(86, 'galle_user05', 'CT123456', 'Chamod Lakshan', 'Male', '199805678901', 'chamod.lakshan05@gmail.com', '0772345005', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(87, 'galle_user06', 'CT123456', 'Hiruni Sewwandi', 'Female', '200106789012', 'hiruni.sewwandi06@gmail.com', '0782345006', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(88, 'galle_user07', 'CT123456', 'Dinesh Kumara', 'Male', '199907890123', 'dinesh.kumara07@gmail.com', '0712345007', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(89, 'galle_user08', 'CT123456', 'Piumi Hansika', 'Female', '200008901234', 'piumi.hansika08@gmail.com', '0722345008', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(90, 'galle_user09', 'CT123456', 'Ravindu Nimesh', 'Male', '199909012345', 'ravindu.nimesh09@gmail.com', '0752345009', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(91, 'galle_user10', 'CT123456', 'Thilini Madushika', 'Female', '200110123456', 'thilini.madushika10@gmail.com', '0762345010', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(92, 'galle_user11', 'CT123456', 'Sahan Pramod', 'Male', '199811234567', 'sahan.pramod11@gmail.com', '0772345011', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(93, 'galle_user12', 'CT123456', 'Ishara Sandamini', 'Female', '200012345678', 'ishara.sandamini12@gmail.com', '0782345012', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(94, 'galle_user13', 'CT123456', 'Nuwan Chathuranga', 'Male', '199913456789', 'nuwan.chathuranga13@gmail.com', '0712345013', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(95, 'galle_user14', 'CT123456', 'Ayesha Fernando', 'Female', '200014567890', 'ayesha.fernando14@gmail.com', '0722345014', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(96, 'galle_user15', 'CT123456', 'Dinuka Sathsara', 'Male', '199815678901', 'dinuka.sathsara15@gmail.com', '0752345015', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(97, 'galle_user16', 'CT123456', 'Shashika Nadeeshani', 'Female', '200116789012', 'shashika.nadeeshani16@gmail.com', '0762345016', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(98, 'galle_user17', 'CT123456', 'Malith Ravishan', 'Male', '199917890123', 'malith.ravishan17@gmail.com', '0772345017', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(99, 'galle_user18', 'CT123456', 'Kavindi Upeksha', 'Female', '200018901234', 'kavindi.upeksha18@gmail.com', '0782345018', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(100, 'galle_user19', 'CT123456', 'Hasitha Lakmal', 'Male', '199919012345', 'hasitha.lakmal19@gmail.com', '0712345019', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(101, 'galle_user20', 'CT123456', 'Madhavi Sachintha', 'Female', '200120123456', 'madhavi.sachintha20@gmail.com', '0722345020', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(102, 'galle_user21', 'CT123456', 'Praveen Madushan', 'Male', '199821234567', 'praveen.madushan21@gmail.com', '0752345021', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(103, 'galle_user22', 'CT123456', 'Nethmi Senanayake', 'Female', '200022345678', 'nethmi.senanayake22@gmail.com', '0762345022', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(104, 'galle_user23', 'CT123456', 'Chathura Bandara', 'Male', '199923456789', 'chathura.bandara23@gmail.com', '0772345023', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(105, 'galle_user24', 'CT123456', 'Dinethmi Kavisha', 'Female', '200024567890', 'dinethmi.kavisha24@gmail.com', '0782345024', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(106, 'galle_user25', 'CT123456', 'Lahiru Sandaruwan', 'Male', '199825678901', 'lahiru.sandaruwan25@gmail.com', '0712345025', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(107, 'galle_user26', 'CT123456', 'Oshadi Himasha', 'Female', '200126789012', 'oshadi.himasha26@gmail.com', '0722345026', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(108, 'galle_user27', 'CT123456', 'Isuru Dhananjaya', 'Male', '199927890123', 'isuru.dhananjaya27@gmail.com', '0752345027', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(109, 'galle_user28', 'CT123456', 'Shenali Tharuka', 'Female', '200028901234', 'shenali.tharuka28@gmail.com', '0762345028', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(110, 'galle_user29', 'CT123456', 'Rukshan Prabath', 'Male', '199929012345', 'rukshan.prabath29@gmail.com', '0772345029', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(111, 'galle_user30', 'CT123456', 'Yashoda Nisansala', 'Female', '200130123456', 'yashoda.nisansala30@gmail.com', '0782345030', 'Galle', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(112, 'colombo_user01', 'CT123456', 'Amila Perera', 'Male', '199831234567', 'amila.perera31@gmail.com', '0712345031', 'Colombo', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(113, 'colombo_user02', 'CT123456', 'Shenuka Wijesinghe', 'Female', '200032345678', 'shenuka.wijesinghe32@gmail.com', '0722345032', 'Colombo', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(114, 'colombo_user03', 'CT123456', 'Ravindu Jayasinghe', 'Male', '199933456789', 'ravindu.jayasinghe33@gmail.com', '0752345033', 'Colombo', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(115, 'colombo_user04', 'CT123456', 'Tharushi Fernando', 'Female', '200034567890', 'tharushi.fernando34@gmail.com', '0762345034', 'Colombo', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(116, 'colombo_user05', 'CT123456', 'Kasun Dilshan', 'Male', '199835678901', 'kasun.dilshan35@gmail.com', '0772345035', 'Colombo', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(117, 'gampaha_user01', 'CT123456', 'Nimesh Madushan', 'Male', '200136789012', 'nimesh.madushan36@gmail.com', '0782345036', 'Gampaha', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(118, 'gampaha_user02', 'CT123456', 'Sanduni Hansika', 'Female', '199937890123', 'sanduni.hansika37@gmail.com', '0712345037', 'Gampaha', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(119, 'gampaha_user03', 'CT123456', 'Tharindu Lakmal', 'Male', '200038901234', 'tharindu.lakmal38@gmail.com', '0722345038', 'Gampaha', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(120, 'gampaha_user04', 'CT123456', 'Kavisha Dilhani', 'Female', '199939012345', 'kavisha.dilhani39@gmail.com', '0752345039', 'Gampaha', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(121, 'gampaha_user05', 'CT123456', 'Sahan Chathuranga', 'Male', '200140123456', 'sahan.chathuranga40@gmail.com', '0762345040', 'Gampaha', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(122, 'matara_user01', 'CT123456', 'Dulanjana Prabath', 'Male', '199841234567', 'dulanjana.prabath41@gmail.com', '0772345041', 'Matara', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(123, 'matara_user02', 'CT123456', 'Hiruni Sandamali', 'Female', '200042345678', 'hiruni.sandamali42@gmail.com', '0782345042', 'Matara', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(124, 'matara_user03', 'CT123456', 'Isuru Madushan', 'Male', '199943456789', 'isuru.madushan43@gmail.com', '0712345043', 'Matara', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(125, 'matara_user04', 'CT123456', 'Piumi Sewwandi', 'Female', '200044567890', 'piumi.sewwandi44@gmail.com', '0722345044', 'Matara', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(126, 'matara_user05', 'CT123456', 'Chamara Nimesh', 'Male', '199845678901', 'chamara.nimesh45@gmail.com', '0752345045', 'Matara', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(127, 'kandy_user01', 'CT123456', 'Dhanuka Bandara', 'Male', '200146789012', 'dhanuka.bandara46@gmail.com', '0762345046', 'Kandy', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(128, 'kandy_user02', 'CT123456', 'Sachini Madushika', 'Female', '199947890123', 'sachini.madushika47@gmail.com', '0772345047', 'Kandy', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(129, 'kandy_user03', 'CT123456', 'Ravindu Chathuranga', 'Male', '200048901234', 'ravindu.chathuranga48@gmail.com', '0782345048', 'Kandy', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(130, 'kandy_user04', 'CT123456', 'Nethmi Udeshika', 'Female', '199949012345', 'nethmi.udeshika49@gmail.com', '0712345049', 'Kandy', 3, 'Active', '2026-07-26 20:48:25', 'Default.png'),
(131, 'kandy_user05', 'CT123456', 'Malith Sandeepa', 'Male', '200150123456', 'malith.sandeepa50@gmail.com', '0722345050', 'Kandy', 3, 'Active', '2026-07-26 20:48:25', 'Default.png');

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
  `Verification_Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verification_report`
--

INSERT INTO `verification_report` (`Verification_ID`, `Report_ID`, `Created_By_Officer_User_ID`, `Description`, `Report_Status`, `Estimated_Amount`, `Verification_Date`) VALUES
(1, 38, 30, NULL, 'Verified', 200000.00, '2026-07-25 03:45:57'),
(3, 46, 30, NULL, 'Verified', 230000.00, '2026-07-25 03:47:45'),
(4, 47, 30, NULL, 'Verified', 200000.00, '2026-07-25 13:23:36'),
(5, 51, 30, NULL, 'Verified', 250000.00, '2026-07-25 13:23:36'),
(7, 46, 29, 'asasadad', 'Verified', 200330.00, '2026-07-25 17:22:54'),
(8, 49, 30, 'kjhgfds', 'Verified', 28000.00, '2026-07-25 17:25:28'),
(13, 49, 28, 'werghl', 'Verified', 15000.00, '2026-07-25 18:13:08'),
(14, 56, 29, 'dfghjkl;\'', 'Verified', NULL, '2026-07-25 18:43:38'),
(15, 47, 28, 'wertghjk,', 'Verified', 150000.00, '2026-07-25 18:44:52'),
(16, 55, 30, 'asdada', 'Verified', 20000.00, '2026-07-26 02:10:01'),
(17, 56, 30, 'adadas', 'Rejected', NULL, '2026-07-26 02:10:08'),
(18, 57, 30, 'sdfghjk', 'Rejected', NULL, '2026-07-26 02:12:53'),
(19, 58, 30, 'sxCx', 'Verified', 526626.00, '2026-07-26 02:31:31'),
(20, 52, 29, 'hjk', 'Rejected', 32623.00, '2026-07-26 02:41:43'),
(21, 52, 30, 'axasx', 'Rejected', 516554156.00, '2026-07-26 03:00:47'),
(22, 46, 30, 'fdsZx', 'Verified', 203030.00, '2026-07-26 03:23:51'),
(23, 58, 28, 'gj', 'Rejected', NULL, '2026-07-26 03:28:27'),
(24, 58, 28, 'sdaacacasca', 'Verified', 20000.00, '2026-07-26 17:49:48'),
(25, 52, 30, 'asdada', 'Verified', 2000.00, '2026-07-26 18:13:21');

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
  ADD UNIQUE KEY `uq_compensation_report` (`Report_ID`),
  ADD KEY `fk_compensation_financial_officer` (`Financial_Officer_User_ID`);

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
  ADD KEY `fk_report_disaster_type` (`Disaster_Type_ID`),
  ADD KEY `fk_report_ds` (`DS_ID`);

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
-- Indexes for table `divisional_secretariat`
--
ALTER TABLE `divisional_secretariat`
  ADD PRIMARY KEY (`DS_ID`);

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
  ADD UNIQUE KEY `Local_Officer_ID` (`Local_Officer_ID`),
  ADD KEY `fk_local_authority_officer_ds` (`Assigned_divisional_secretariat`);

--
-- Indexes for table `missing_person_record`
--
ALTER TABLE `missing_person_record`
  ADD PRIMARY KEY (`Report_ID`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`Notification_ID`),
  ADD KEY `fk_notification_user` (`User_ID`),
  ADD KEY `fk_notification_report` (`Report_ID`);

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
  ADD KEY `idx_report_id` (`Report_ID`),
  ADD KEY `idx_officer_id` (`Created_By_Officer_User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `compensation_report`
--
ALTER TABLE `compensation_report`
  MODIFY `Compensation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `disaster_report`
--
ALTER TABLE `disaster_report`
  MODIFY `Report_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `disaster_type`
--
ALTER TABLE `disaster_type`
  MODIFY `Disaster_Type_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `divisional_secretariat`
--
ALTER TABLE `divisional_secretariat`
  MODIFY `DS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=340;

--
-- AUTO_INCREMENT for table `evidence_file_and_photos`
--
ALTER TABLE `evidence_file_and_photos`
  MODIFY `File_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `Notification_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `password_reset_otp`
--
ALTER TABLE `password_reset_otp`
  MODIFY `otp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `verification_report`
--
ALTER TABLE `verification_report`
  MODIFY `Verification_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  ADD CONSTRAINT `fk_compensation_financial_officer` FOREIGN KEY (`Financial_Officer_User_ID`) REFERENCES `users` (`User_ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_compensation_report` FOREIGN KEY (`Report_ID`) REFERENCES `disaster_report` (`Report_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `fk_report_ds` FOREIGN KEY (`DS_ID`) REFERENCES `divisional_secretariat` (`DS_ID`),
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
-- Constraints for table `evidence_file_and_photos`
--
ALTER TABLE `evidence_file_and_photos`
  ADD CONSTRAINT `evidence_file_and_photos_ibfk_1` FOREIGN KEY (`Report_ID`) REFERENCES `disaster_report` (`Report_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `fk_local_authority_officer_ds` FOREIGN KEY (`Assigned_divisional_secretariat`) REFERENCES `divisional_secretariat` (`DS_ID`),
  ADD CONSTRAINT `local_authority_officer_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE;

--
-- Constraints for table `missing_person_record`
--
ALTER TABLE `missing_person_record`
  ADD CONSTRAINT `missing_person_record_ibfk_1` FOREIGN KEY (`Report_ID`) REFERENCES `disaster_report` (`Report_ID`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `fk_notification_report` FOREIGN KEY (`Report_ID`) REFERENCES `disaster_report` (`Report_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_notification_user` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `verification_report_ibfk_1` FOREIGN KEY (`Report_ID`) REFERENCES `disaster_report` (`Report_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `verification_report_ibfk_2` FOREIGN KEY (`Created_By_Officer_User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
