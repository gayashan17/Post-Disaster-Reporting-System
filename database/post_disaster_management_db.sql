-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2026 at 11:24 PM
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
(32, '', '', ''),
(34, '', '', ''),
(36, '', '', ''),
(37, '', '', ''),
(38, '', '', ''),
(41, '', '', ''),
(42, '', '', ''),
(43, '', '', ''),
(44, '', '', ''),
(45, '', '', ''),
(46, '', '', '');

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
(35, '', 0, 'default', ''),
(42, '', 0, 'default', ''),
(43, '', 0, 'default', ''),
(50, '', 0, 'default', ''),
(53, '', 0, 'default', ''),
(54, '', 0, 'default', ''),
(55, '', 0, 'default', ''),
(56, '', 0, 'default', ''),
(57, '', 0, 'default', ''),
(58, '', 0, 'default', '');

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
  `DS_ID` int(11) DEFAULT NULL,
  `Street_Address` text NOT NULL,
  `Description` text DEFAULT NULL,
  `Report_Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disaster_report`
--

INSERT INTO `disaster_report` (`Report_ID`, `User_ID`, `Disaster_Type_ID`, `Report_Type`, `Report_Status`, `District`, `DS_ID`, `Street_Address`, `Description`, `Report_Date`) VALUES
(35, 26, 28, 'Death Record', 'Submitted', 'default', 1, '', '', '2026-07-15 11:30:33'),
(36, 26, 23, 'Missing Person Record', 'Submitted', 'default', NULL, '', '', '2026-07-15 11:47:19'),
(37, 26, 28, 'Injured Person', 'Submitted', 'default', NULL, '', '', '2026-07-15 12:01:02'),
(38, 26, 28, 'Property Damage', 'Submitted', 'default', NULL, '', '', '2026-07-16 06:34:06'),
(39, 26, 28, 'Property Damage', 'Submitted', 'default', NULL, '', '', '2026-07-16 09:33:56'),
(40, 32, 23, 'Property Damage', 'Submitted', 'default', NULL, '', '', '2026-07-19 00:10:17'),
(41, 32, 28, 'Property Damage', 'Submitted', 'default', NULL, '', '', '2026-07-19 00:15:02'),
(42, 32, 28, 'Death Record', 'Submitted', 'default', NULL, '', '', '2026-07-19 02:46:47'),
(43, 32, 28, 'Death Record', 'Submitted', 'default', NULL, '', '', '2026-07-19 02:48:38'),
(44, 32, 28, 'Injured Person', 'Submitted', 'default', NULL, '', '', '2026-07-19 02:58:39'),
(45, 32, 28, 'Missing Person Record', 'Submitted', 'default', NULL, '', '', '2026-07-19 03:02:23'),
(46, 32, 23, 'Property Damage', 'Submitted', 'Galle', NULL, 'asdfghj', 'uytfds', '2026-07-19 07:27:02'),
(47, 32, 28, 'Property Damage', 'Submitted', 'default', NULL, '', '', '2026-07-21 17:02:51'),
(48, 32, 28, 'Property Damage', 'Submitted', 'default', NULL, '', '', '2026-07-21 17:05:01'),
(49, 32, 28, 'Property Damage', 'Submitted', 'default', NULL, '', '', '2026-07-21 17:22:29'),
(50, 32, 28, 'Death Record', 'Submitted', 'default', NULL, '', '', '2026-07-21 19:59:50'),
(51, 32, 28, 'Injured Person', 'Submitted', 'default', NULL, '', '', '2026-07-21 20:00:06'),
(52, 32, 28, 'Missing Person Record', 'Submitted', 'default', NULL, '', '', '2026-07-21 20:00:32'),
(53, 32, 28, 'Death Record', 'Submitted', 'default', NULL, '', '', '2026-07-22 16:22:52'),
(54, 32, 28, 'Death Record', 'Submitted', 'default', NULL, '', '', '2026-07-22 16:29:36'),
(55, 32, 28, 'Death Record', 'Submitted', 'default', NULL, '', '', '2026-07-22 16:39:46'),
(56, 32, 28, 'Death Record', 'Submitted', 'default', NULL, '', '', '2026-07-22 16:40:05'),
(57, 32, 28, 'Death Record', 'Submitted', 'default', NULL, '', '', '2026-07-22 16:40:43'),
(58, 32, 28, 'Death Record', 'Submitted', 'default', NULL, '', '', '2026-07-22 19:09:30'),
(59, 26, 22, 'Property Damage', 'Submitted', 'Colombo', NULL, 'wedfxv', 'fdvb', '2026-07-24 01:27:20'),
(60, 26, 22, 'Property Damage', 'Submitted', 'Colombo', NULL, 'wedfxv', 'fdvb', '2026-07-24 01:37:58'),
(61, 26, 22, 'Property Damage', 'Submitted', 'Colombo', NULL, 'wedfxv', 'fdvb', '2026-07-24 01:39:31');

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
(25, 49, '32_6a5f5d7da5ba8_9074a68f86e0f006a9ec7183530e66c0.jpg', 'image/jpeg', '../uploads/evidence/ReportID_49/32_6a5f5d7da5ba8_9074a68f86e0f006a9ec7183530e66c0.jpg', '2026-07-21 11:52:29'),
(26, 50, '32_6a5f825e5a568_1689416305401.jpg', 'image/jpeg', '../uploads/evidence/ReportID_50/32_6a5f825e5a568_1689416305401.jpg', '2026-07-21 14:29:50'),
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
(37, 61, '26_6a6274fb77829_62cff4-2c67f2.png', 'image/png', '../uploads/evidence/ReportID_61/26_6a6274fb77829_62cff4-2c67f2.png', '2026-07-23 20:09:31');

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
(51, '', 0, 'default', '');

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
(26, '1', NULL, 1);

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
(52, '', 0, 'default', '', '0000-00-00', '00:00:00', NULL, '');

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
(1, 26, 61, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-24 01:39:31');

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
(49, 'default', '', '', 0.00, 0.00000000, 0.00000000),
(59, 'agrLand', 'Minor', 'fdgdfg', 13123.00, 6.18324300, 80.11229700),
(60, 'agrLand', 'Minor', 'fdgdfg', 13123.00, 6.18324300, 80.11229700),
(61, 'agrLand', 'Minor', 'fdgdfg', 13123.00, 6.18324300, 80.11229700);

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
(26, 'charindu', '$2y$10$TxVu6.HZBGZNYJr9.N4wAOFGpSAVdgZZaznXeaUZJvs9F.5Vze6Eq', 'Charindu Gayashan', 'Male', '200512700610', 'charindugayashan00@gmail.com', '0762352086', 'galle', 4, 'Active', '2026-07-22 12:12:34', '26_20260723_161722.png'),
(27, 'AAA', '$2y$10$zr22onqR0GJAgs.y2M5z5.5mk3nhPKqK0p9O7mC9qbXKBio4qDBsW', 'AAA', 'Male', '200304811654', 'asda@gmail.com', '0766511223', 'Galle', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(28, 'DS', '$2y$10$K7dz2nAvdSdMICRVgjRaHuR3mfn4cCIRaOkUEsqsYDeetwOItmZ0K', 'district secretary', 'Male', '200304568952', 'DS@gmail.com', '0755899663', 'Galle', 5, 'Active', '2026-07-22 12:12:34', 'Default'),
(29, 'LOF', '$2y$10$cdD18ckAbSJDasQ7WTUF0eEwdkBj8U29XI2K9.uuwG4EYZKR6jBPO', 'Local Authority Officer', 'Male', '200546568956', 'LOF@gmail.com', '0456633221', 'Galle', 4, 'Active', '2026-07-22 12:12:34', 'Default'),
(30, 'DMO', '$2y$10$sYlC/BotKLirMNOTkiVLIOtc9wJz67I4FYFbibhhB1q7BAqyPg1hy', 'Disaster Managment Officer', 'Male', '200563254123', 'DMO@gmail.com', '0766588552', 'Galle', 2, 'Active', '2026-07-22 12:12:34', 'Default'),
(31, 'FO', '$2y$10$OIWerh3Mt2DpNoJO.aYEQuGI2nwVDFywXcNVwmpDzz48w3PD/WwZS', 'Financial Officer', 'Male', '200345889966', 'FO@gmail.com', '0766544882', 'Galle', 6, 'Active', '2026-07-22 12:12:34', 'Default'),
(32, 'CT', '$2y$10$vXZ5gdY3pgKurzULxMmLH.m3Tanh13Ll1XnXfatDSb8Wn8obxLwnK', 'Citizen', 'Female', '200304589966', 'CT@gmail.com', '0755899667', 'Colombo', 3, 'Active', '2026-07-22 12:12:34', '32_20260722_230342.png'),
(34, 'adcas', '$2y$10$4A2YTBjhGrz.s.LLY.PU2uIfNRu9ZlipvWtojggYjpGdNsRg6stAu', 'ascasc', 'Male', '200304556633', 'aoudhaisoasiai@gmail.com', '0758966332', 'ascasc', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(36, 'asdaad', '$2y$10$WjiVr5a9sARcFBghKR130ea7g3lLDyDAE7JUKzCbTrHPOacZVa28G', 'asdad', 'Male', '200356889977', 'aoudasoasiai@gmail.com', '0758966337', 'asasasa', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(37, 'asda', '$2y$10$yxttHGmScCxZIiB5f1US0OriqVaAe8AK6TAApSmBSfwV52DYGPd16', 'asdads', 'Male', '200304556633', 'asqwqqasda@gmail.com', '0777777777', 'acasc', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(38, 'asdada', '$2y$10$/w/u3M1o/VT0Ag050oYzbuyKAC18Wb9WLNtNAw7hFLi.SLhKavUpW', 'sdasdasd', 'Male', '200304556633', 'CT@gmail.coma', '0000000000', 'acasc', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(41, 'dw', '$2y$10$rH8XAnaBuzB9ApmV5PGUSO30zRNAZOWTVVEl8olYbwfRVYDelVR4m', 'Malisha Madhusith', 'Female', '200304811693', 'malishamadhusith72@gmail.coma', '0766511220', 'asasasa', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(42, 'dasd', '$2y$10$N2gRi1mjBpWOncB0.tGyYeVFldvBFNzyRmhNJ10iiRumjPzROoAsS', 'asdsa', 'Male', '200304811693', 'malisashamadhusith72@gmail.com', '0766511220', 'asasasa', 3, 'Active', '2026-07-22 12:12:34', 'Default'),
(43, 'j65', '$2y$10$Q5fiidYslGFDjL1c5ptFWuPSpUlgva2BDh0.xyvo25bkbWZqaSGAq', 'Malisha Madhusith', 'Male', '200304811693', 'maishamadhusith72@gmail.com', '0766511220', 'asasasa', 3, 'Banned', '2026-07-22 12:12:34', 'Default'),
(44, 'ugytd', '$2y$10$ALmPYyT2eoKwIKi.oyu1cO3xkxq3Pnr4ffXLmaMpeY6RiUG0zQNMC', 'asdsaasdasdasdaasdadsadadadaad', 'Male', '200304811693', 'malishusith72@gmail.com', '0766511220', 'asasasa', 3, 'Banned', '2026-07-22 12:12:34', 'Default'),
(45, 'asas', '$2y$10$sBdgJ9tYoMb7yIDyPFyz4uLAvxnmn3xTZ0JEPicTeb5BelLkbGLo6', 'Malisha Madhusith', 'Male', '200304811656', 'malishasamadhkjhusith72@gmail.com', '0777777777', 'asdasd', 5, 'Banned', '2026-07-22 12:12:34', 'Default'),
(46, 'asdasd', '$2y$10$HeVGRPS3aLmsiquf.A3crOwhV1Yq90IXxzAqSXaRA7s0kcmqFkUt6', 'Citizen', 'Male', '200304556633', 'Galle@gmail.com', '0777788996', 'Galle', 3, 'Active', '2026-07-22 17:39:25', 'Default');

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
  MODIFY `Report_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

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
  MODIFY `File_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `Notification_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `password_reset_otp`
--
ALTER TABLE `password_reset_otp`
  MODIFY `otp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

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
  ADD CONSTRAINT `verification_report_ibfk_1` FOREIGN KEY (`Report_ID`) REFERENCES `disaster_report` (`Report_ID`),
  ADD CONSTRAINT `verification_report_ibfk_2` FOREIGN KEY (`Created_By_Officer_User_ID`) REFERENCES `users` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
