-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2026 at 12:42 AM
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
(145, 'Chamara Rajapaksha', 'Bank of Ceylon', '5269659626'),
(146, 'Hiruni Sandamali', 'Bank of Ceylon', '6579279397'),
(147, 'Piumi Sewwandi', 'Commercial Bank', '546446464646'),
(148, 'Sahan Chathuranga', 'Commercial Bank', '45642854355'),
(149, 'Kamal Chathuranga', 'Commercial Bank', '452453452135');

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
(1, 77, 78, 250000.00, 250000.00, 250000.00, 'Payment Successfully', '../uploads/Receipt/1_77_1785101165_Screenshot_2026-06-01_130517.png', 'Paid', '2026-06-27 02:56:05', '2026-06-27 02:53:00'),
(2, 85, 78, 10000.00, 10000.00, 10000.00, 'Payment Successfully', '../uploads/Receipt/2_85_1785101184_Screenshot_2026-05-31_150304.png', 'Paid', '2026-04-27 02:56:24', '2026-04-27 02:53:05'),
(3, 86, 78, 30000.00, 30000.00, 30000.00, 'Payment Successfully', '../uploads/Receipt/3_86_1785101207_Screenshot_2026-05-31_150304.png', 'Paid', '2026-05-27 02:56:47', '2026-05-27 02:53:14'),
(4, 88, 78, 50000.00, 50000.00, 50000.00, 'Payment Successfully', '../uploads/Receipt/4_88_1785101223_Screenshot_2026-06-01_124628.png', 'Paid', '2026-07-27 02:57:03', '2026-07-27 02:53:19'),
(5, 100, 78, 2500000.00, 2500000.00, NULL, NULL, NULL, 'Processing', NULL, '2026-07-27 04:01:23'),
(6, 93, 78, 2000000.00, 2000000.00, NULL, NULL, NULL, 'Processing', NULL, '2026-07-27 04:01:26');

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
(84, 'Kamal Gunarathne', 43, 'male', 'Drawn'),
(89, 'Ruwan Herath', 46, 'male', 'Desase'),
(97, 'Ruwan Herath', 46, 'male', 'Desase');

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
(135, 'DMO001', 'Disaster Management Centre', 'Galle'),
(136, 'DMO002', 'Disaster Management Centre', 'Colombo'),
(137, 'DMO003', 'Disaster Management Centre', 'Matara'),
(138, 'DMO004', 'Disaster Management Centre', 'Gampaha');

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
(77, 145, 22, 'Property Damage', 'FO Paid', 'Galle', 85, 'Old polwatta Road, ambalangoda, Galle', '', '2026-07-27 01:29:18'),
(84, 145, 22, 'Death Record', 'DMO Rejected', 'Galle', 85, 'Ambalngsada 7/h , Ambalangoda, Galle', 'Death', '2026-07-27 01:37:14'),
(85, 145, 22, 'Injured Person', 'FO Paid', 'Galle', 85, '71 Temple road, Galle', 'The person sustained injuries while escaping from the disaster-affected area.', '2026-07-27 01:42:52'),
(86, 145, 23, 'Missing Person Record', 'FO Paid', 'Galle', 85, '55 temple Road, Galle', 'The individual has been missing since the disaster occurred and has not returned home.', '2026-07-27 01:44:39'),
(87, 146, 22, 'Property Damage', 'DS Rejected', 'Galle', 85, 'Temple Road 22/4 , Ambalangoda.', 'Strong winds damaged the roof and part of the boundary wall.', '2026-07-27 01:47:44'),
(88, 145, 28, 'Property Damage', 'FO Paid', 'Galle', 85, 'temple road, 23/4 ,galle', 'The property was affected by flooding, causing damage to household items and flooring.', '2026-07-27 02:29:52'),
(89, 146, 22, 'Death Record', 'LAO Rejected', 'Galle', 85, 'The individual was reported deceased as a result of the disaster incident.', 'The individual was reported deceased as a result of the disaster incident.', '2026-07-27 03:07:33'),
(90, 146, 26, 'Injured Person', 'LAO Rejected', 'Galle', 85, '24/6 Temple Road , Ambalnvaththa.', 'The individual sustained injuries due to debris falling from a damaged building.', '2026-07-27 03:09:05'),
(91, 146, 22, 'Missing Person Record', 'DS Approved', 'Galle', 85, 'Kongaha Road, galle', 'The person was last seen in the affected area before the disaster and remains unaccounted for.', '2026-07-27 03:12:07'),
(92, 146, 28, 'Property Damage', 'DS Rejected', 'Galle', 85, 'julgaaha Road, Amnana , Galle', 'A fallen tree damaged the roof and front section of the house.', '2026-07-27 03:13:49'),
(93, 149, 24, 'Property Damage', 'FO Pending', 'Galle', 85, 'Temple road, Galle', 'A fallen tree damaged the roof and front section of the house.', '2026-07-27 03:20:37'),
(94, 149, 22, 'Property Damage', 'DS Approved', 'Galle', 85, '42/1 kongaha Road, galle', 'A fallen tree damaged the roof and front section of the house.', '2026-07-27 03:21:33'),
(95, 149, 22, 'Missing Person Record', 'DS Approved', 'Galle', 85, 'Temple Road', 'A fallen tree damaged the roof and front section of the house.', '2026-07-27 03:22:54'),
(96, 149, 24, 'Injured Person', 'DMO Approved', 'Galle', 85, 'Kongaha', 'A fallen tree damaged the roof and front section of the house.', '2026-07-27 03:23:33'),
(97, 149, 23, 'Death Record', 'DMO Approved', 'Galle', 85, 'junction road, galle', 'A fallen tree damaged the roof and front section of the house.', '2026-07-27 03:24:24'),
(98, 149, 25, 'Property Damage', 'DMO Rejected', 'Galle', 85, 'Gedara para, Galle', 'A fallen tree damaged the roof and front section of the house.', '2026-07-27 03:25:43'),
(99, 147, 24, 'Property Damage', 'DMO Rejected', 'Galle', 85, 'Ambalangoda', 'A fallen tree damaged the roof and front section of the house.', '2026-07-27 03:27:02'),
(100, 147, 24, 'Property Damage', 'FO Pending', 'Galle', 85, 'Ambalangoada', 'A fallen tree damaged the roof and front section of the house.', '2026-07-27 03:27:49'),
(101, 147, 23, 'Property Damage', 'LAO Approved', 'Galle', 85, '34/7 temple Road', 'The property was affected by flooding, causing damage to household items and flooring.', '2026-07-27 04:07:59'),
(102, 147, 22, 'Property Damage', 'LAO Approved', 'Galle', 85, 'Galle', 'he property was affected by flooding, causing damage to household items and flooring.', '2026-07-27 04:08:46');

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
(1, 77, '145_6a666716301c2_videoframe_4502.png', 'image/png', '../uploads/evidence/ReportID_77/145_6a666716301c2_videoframe_4502.png', '2026-07-26 19:59:18'),
(2, 84, '145_6a6668f22acc5_1689416305401.jpg', 'image/jpeg', '../uploads/evidence/ReportID_84/145_6a6668f22acc5_1689416305401.jpg', '2026-07-26 20:07:14'),
(3, 85, '145_6a666a441644d_videoframe_4502.png', 'image/png', '../uploads/evidence/ReportID_85/145_6a666a441644d_videoframe_4502.png', '2026-07-26 20:12:52'),
(4, 86, '145_6a666aafa346e_videoframe_4502.png', 'image/png', '../uploads/evidence/ReportID_86/145_6a666aafa346e_videoframe_4502.png', '2026-07-26 20:14:39'),
(5, 87, '146_6a666b68b8800_Screenshot 2026-06-01 124132.png', 'image/png', '../uploads/evidence/ReportID_87/146_6a666b68b8800_Screenshot 2026-06-01 124132.png', '2026-07-26 20:17:44'),
(6, 88, '145_6a667548e975d_Screenshot 2026-05-31 150304.png', 'image/png', '../uploads/evidence/ReportID_88/145_6a667548e975d_Screenshot 2026-05-31 150304.png', '2026-07-26 20:59:52'),
(7, 89, '146_6a667e1d4dfde_Screenshot 2026-04-19 183416.png', 'image/png', '../uploads/evidence/ReportID_89/146_6a667e1d4dfde_Screenshot 2026-04-19 183416.png', '2026-07-26 21:37:33'),
(8, 90, '146_6a667e794f076_Screenshot 2026-06-01 130517.png', 'image/png', '../uploads/evidence/ReportID_90/146_6a667e794f076_Screenshot 2026-06-01 130517.png', '2026-07-26 21:39:05'),
(9, 91, '146_6a667f2f14e06_Screenshot 2026-04-30 222435.png', 'image/png', '../uploads/evidence/ReportID_91/146_6a667f2f14e06_Screenshot 2026-04-30 222435.png', '2026-07-26 21:42:07'),
(10, 92, '146_6a667f958170b_Screenshot 2026-06-01 124132.png', 'image/png', '../uploads/evidence/ReportID_92/146_6a667f958170b_Screenshot 2026-06-01 124132.png', '2026-07-26 21:43:49'),
(11, 93, '149_6a66812dee133_Screenshot 2026-05-31 150304.png', 'image/png', '../uploads/evidence/ReportID_93/149_6a66812dee133_Screenshot 2026-05-31 150304.png', '2026-07-26 21:50:37'),
(12, 94, '149_6a668165ba3f8_Screenshot 2026-05-31 150304.png', 'image/png', '../uploads/evidence/ReportID_94/149_6a668165ba3f8_Screenshot 2026-05-31 150304.png', '2026-07-26 21:51:33'),
(13, 95, '149_6a6681b6e9ec5_Screenshot 2026-05-31 150304.png', 'image/png', '../uploads/evidence/ReportID_95/149_6a6681b6e9ec5_Screenshot 2026-05-31 150304.png', '2026-07-26 21:52:54'),
(14, 96, '149_6a6681dda002d_Screenshot 2026-04-19 191103.png', 'image/png', '../uploads/evidence/ReportID_96/149_6a6681dda002d_Screenshot 2026-04-19 191103.png', '2026-07-26 21:53:33'),
(15, 97, '149_6a668210ee319_Screenshot 2026-06-01 130517.png', 'image/png', '../uploads/evidence/ReportID_97/149_6a668210ee319_Screenshot 2026-06-01 130517.png', '2026-07-26 21:54:24'),
(16, 98, '149_6a66825fea177_Screenshot 2026-04-15 172328.png', 'image/png', '../uploads/evidence/ReportID_98/149_6a66825fea177_Screenshot 2026-04-15 172328.png', '2026-07-26 21:55:43'),
(17, 99, '147_6a6682ae25dc3_Screenshot 2026-05-31 150304.png', 'image/png', '../uploads/evidence/ReportID_99/147_6a6682ae25dc3_Screenshot 2026-05-31 150304.png', '2026-07-26 21:57:02'),
(18, 100, '147_6a6682dd585f0_Screenshot 2026-04-30 222435.png', 'image/png', '../uploads/evidence/ReportID_100/147_6a6682dd585f0_Screenshot 2026-04-30 222435.png', '2026-07-26 21:57:49'),
(19, 101, '147_6a668c47634c7_Screenshot 2026-06-01 124315.png', 'image/png', '../uploads/evidence/ReportID_101/147_6a668c47634c7_Screenshot 2026-06-01 124315.png', '2026-07-26 22:37:59'),
(20, 102, '147_6a668c76d1ef4_Screenshot 2026-06-01 124600.png', 'image/png', '../uploads/evidence/ReportID_102/147_6a668c76d1ef4_Screenshot 2026-06-01 124600.png', '2026-07-26 22:38:46');

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
(85, 'Sarada Gunawardena', 21, 'female', 'Moderate'),
(90, 'Kalpani chnadrasekara', 23, 'female', 'Severe'),
(96, 'Kalpani chnadrasekara', 23, 'male', 'Severe');

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
(139, 'LAO0001', 'Local Authority Officer', 86),
(140, 'LAO0002', 'Local Authority Officer', 85),
(141, 'LAO0003', 'Local Authority Officer', 82),
(142, 'LAO0004', 'Local Authority Officer', 83),
(143, 'LAO0005', 'Local Authority Officer', 87),
(144, 'LAO0006', 'Local Authority Officer', 76);

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
(86, 'Kasun perera', 36, 'male', 'Galle Bus station', '2026-07-14', '06:47:00', NULL, 'Brother'),
(91, 'Shamila Liyanarachchi', 45, 'female', 'Kongaha Junction', '2026-07-25', '08:15:00', NULL, 'Mother'),
(95, 'Kusuma Sandeepani', 55, 'female', 'Kongaha Junction', '2026-07-14', '07:24:00', NULL, 'Mother');

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
(1, 140, 77, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 01:29:18'),
(2, 140, 84, 'New Death Report', 'A new Death Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 01:37:14'),
(3, 140, 85, 'New Injured Person Report', 'A new Injured Person Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 01:42:52'),
(4, 140, 86, 'New Missing Person Report', 'A new Missing Person Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 01:44:39'),
(5, 140, 87, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 01:47:44'),
(6, 145, 77, 'Report Rejection', 'Your Report Has Been Rejected By a Local Authority Officer', 'LAO Rejection', 0, '2026-07-27 01:50:01'),
(7, 145, 84, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 01:50:17'),
(8, 145, 85, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 01:50:22'),
(9, 145, 86, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 01:50:27'),
(10, 146, 87, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 01:50:31'),
(11, 145, 77, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 02:13:51'),
(12, 145, 84, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 02:13:56'),
(13, 145, 77, 'Report Rejection', 'Your Report Has Been Rejected By Disaster Management Officer', 'DMO Rejection', 0, '2026-07-27 02:22:46'),
(14, 145, 84, 'Report Rejection', 'Your Report Has Been Rejected By Disaster Management Officer', 'DMO Rejection', 0, '2026-07-27 02:23:49'),
(15, 140, 88, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 02:29:52'),
(16, 145, 85, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 02:30:59'),
(17, 145, 86, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 02:31:03'),
(18, 146, 87, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 02:31:07'),
(19, 145, 88, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 02:31:11'),
(20, 145, 85, 'Report Approval', 'Your Report Has Been Approved By Disaster Management Officer', 'DMO Approval', 0, '2026-07-27 02:41:26'),
(21, 145, 86, 'Report Approval', 'Your Report Has Been Approved By Disaster Management Officer', 'DMO Approval', 0, '2026-07-27 02:41:37'),
(22, 146, 87, 'Report Approval', 'Your Report Has Been Approved By Disaster Management Officer', 'DMO Approval', 0, '2026-07-27 02:41:56'),
(23, 145, 88, 'Report Approval', 'Your Report Has Been Approved By Disaster Management Officer', 'DMO Approval', 0, '2026-07-27 02:42:06'),
(24, 145, 77, 'Report Approval', 'Your Report Has Been Approved By District Secretary', 'DS Approval', 0, '2026-07-27 02:48:29'),
(25, 146, 87, 'Report Rejection', 'Your Report Has Been Rejected By District Secretary', 'DS Rejected', 0, '2026-07-27 02:48:51'),
(26, 145, 85, 'Report Approval', 'Your Report Has Been Approved By District Secretary', 'DS Approval', 0, '2026-07-27 02:49:08'),
(27, 145, 86, 'Report Approval', 'Your Report Has Been Approved By District Secretary', 'DS Approval', 0, '2026-07-27 02:49:16'),
(28, 145, 88, 'Report Rejection', 'Your Report Has Been Rejected By District Secretary', 'DS Rejected', 0, '2026-07-27 02:49:39'),
(29, 145, 77, 'Compensation Processing', 'Your Compensation Claim Is Now Being Processed By Financial Officer', 'FO Processing', 0, '2026-07-27 02:53:00'),
(30, 145, 85, 'Compensation Processing', 'Your Compensation Claim Is Now Being Processed By Financial Officer', 'FO Processing', 0, '2026-07-27 02:53:05'),
(31, 145, 86, 'Compensation Processing', 'Your Compensation Claim Is Now Being Processed By Financial Officer', 'FO Processing', 0, '2026-07-27 02:53:14'),
(32, 145, 88, 'Compensation Processing', 'Your Compensation Claim Is Now Being Processed By Financial Officer', 'FO Processing', 0, '2026-07-27 02:53:19'),
(33, 140, 89, 'New Death Report', 'A new Death Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 03:07:33'),
(34, 140, 90, 'New Injured Person Report', 'A new Injured Person Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 03:09:05'),
(35, 140, 91, 'New Missing Person Report', 'A new Missing Person Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 03:12:07'),
(36, 140, 92, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 03:13:49'),
(37, 146, 89, 'Report Rejection', 'Your Report Has Been Rejected By a Local Authority Officer', 'LAO Rejection', 0, '2026-07-27 03:15:45'),
(38, 146, 90, 'Report Rejection', 'Your Report Has Been Rejected By a Local Authority Officer', 'LAO Rejection', 0, '2026-07-27 03:16:04'),
(39, 146, 91, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 03:16:27'),
(40, 146, 92, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 03:16:35'),
(41, 140, 93, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 03:20:37'),
(42, 140, 94, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 03:21:33'),
(43, 140, 95, 'New Missing Person Report', 'A new Missing Person Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 03:22:54'),
(44, 140, 96, 'New Injured Person Report', 'A new Injured Person Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 03:23:33'),
(45, 140, 97, 'New Death Report', 'A new Death Report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 03:24:24'),
(46, 140, 98, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 03:25:43'),
(47, 140, 99, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 03:27:02'),
(48, 140, 100, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 03:27:49'),
(49, 149, 93, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 03:28:19'),
(50, 149, 94, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 03:28:24'),
(51, 149, 95, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 03:34:46'),
(52, 149, 96, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 03:34:50'),
(53, 149, 97, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 03:34:54'),
(54, 149, 98, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 03:34:58'),
(55, 147, 99, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 03:35:04'),
(56, 147, 100, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 03:35:08'),
(57, 147, 100, 'Report Approval', 'Your Report Has Been Approved By Disaster Management Officer', 'DMO Approval', 0, '2026-07-27 03:36:43'),
(58, 146, 91, 'Report Approval', 'Your Report Has Been Approved By Disaster Management Officer', 'DMO Approval', 0, '2026-07-27 03:36:54'),
(59, 146, 92, 'Report Approval', 'Your Report Has Been Approved By Disaster Management Officer', 'DMO Approval', 0, '2026-07-27 03:37:08'),
(60, 149, 93, 'Report Approval', 'Your Report Has Been Approved By Disaster Management Officer', 'DMO Approval', 0, '2026-07-27 03:37:33'),
(61, 149, 94, 'Report Approval', 'Your Report Has Been Approved By Disaster Management Officer', 'DMO Approval', 0, '2026-07-27 03:37:46'),
(62, 149, 95, 'Report Approval', 'Your Report Has Been Approved By Disaster Management Officer', 'DMO Approval', 0, '2026-07-27 03:38:06'),
(63, 149, 96, 'Report Approval', 'Your Report Has Been Approved By Disaster Management Officer', 'DMO Approval', 0, '2026-07-27 03:38:15'),
(64, 149, 97, 'Report Approval', 'Your Report Has Been Approved By Disaster Management Officer', 'DMO Approval', 0, '2026-07-27 03:38:23'),
(65, 149, 98, 'Report Rejection', 'Your Report Has Been Rejected By Disaster Management Officer', 'DMO Rejection', 0, '2026-07-27 03:40:48'),
(66, 147, 99, 'Report Rejection', 'Your Report Has Been Rejected By Disaster Management Officer', 'DMO Rejection', 0, '2026-07-27 03:40:55'),
(67, 146, 92, 'Report Rejection', 'Your Report Has Been Rejected By District Secretary', 'DS Rejected', 0, '2026-07-27 03:50:09'),
(68, 146, 91, 'Report Approval', 'Your Report Has Been Approved By District Secretary', 'DS Approval', 0, '2026-07-27 03:51:12'),
(69, 149, 93, 'Report Approval', 'Your Report Has Been Approved By District Secretary', 'DS Approval', 0, '2026-07-27 03:51:32'),
(70, 149, 94, 'Report Approval', 'Your Report Has Been Approved By District Secretary', 'DS Approval', 0, '2026-07-27 03:53:15'),
(71, 149, 95, 'Report Approval', 'Your Report Has Been Approved By District Secretary', 'DS Approval', 0, '2026-07-27 03:53:24'),
(72, 147, 100, 'Report Approval', 'Your Report Has Been Approved By District Secretary', 'DS Approval', 0, '2026-07-27 03:57:03'),
(73, 147, 100, 'Compensation Processing', 'Your Compensation Claim Is Now Being Processed By Financial Officer', 'FO Processing', 0, '2026-07-27 04:01:23'),
(74, 149, 93, 'Compensation Processing', 'Your Compensation Claim Is Now Being Processed By Financial Officer', 'FO Processing', 0, '2026-07-27 04:01:26'),
(75, 140, 101, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 04:07:59'),
(76, 140, 102, 'New Property Damage Disaster Report', 'A new disaster report has been submitted for your Divisional Secretariat and requires review.', 'Report Submitted', 0, '2026-07-27 04:08:46'),
(77, 147, 101, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 04:09:25'),
(78, 147, 102, 'Report Approval', 'Your Report Has Been Approved By a Local Authority Officer', 'LAO Approval', 0, '2026-07-27 04:09:30');

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
(77, 'rHouse', 'Moderate', 'Minor damage to the roof with several tiles displa...', 300000.00, 6.23886170, 80.05739658),
(87, 'comBuilding', 'Major', 'Strong winds damaged the roof and part of the boundary wall.', 300000.00, 6.10363939, 80.22786185),
(88, 'rHouse', 'Minor', 'The property was affected by flooding, causing damage to household items and flooring.', 50000.00, 6.10363939, 80.22786185),
(92, 'apt', '', 'A fallen tree damaged the roof and front section of the house.', 1200000.00, 6.10363939, 80.22786185),
(93, 'vehicle', 'Moderate', 'A fallen tree damaged the Car.', 2000000.00, 6.10364000, 80.22784300),
(94, 'apt', 'Major', 'A fallen tree damaged the roof and front section of the house.', 450000.00, 6.10363939, 80.22786185),
(98, 'shop', 'Major', 'A fallen tree damaged the roof and front section of the house.', 1700000.00, 6.10363939, 80.22786185),
(99, 'rHouse', 'Minor', 'A fallen tree damaged the roof and front section of the house.', 50000.00, 6.10363939, 80.22786185),
(100, 'agrLand', '', 'A fallen tree damaged the roof and front section of the house.', 2500000.00, 6.10363939, 80.22786185),
(101, 'apt', 'Moderate', 'he property was affected by flooding, causing damage to household items and flooring.', 1300000.00, 6.10363939, 80.22786185),
(102, 'apt', 'Minor', 'he property was affected by flooding, causing damage to household items and flooring.', 100000.00, 6.10363939, 80.22786185);

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
(74, 'ds_galle01', '$2y$10$237vCQd7et337BUABxTCpuT/0vtNB9hcpXZ1Qsyn/igga4kBsEDZa', 'Mahinda Jayasinghe', 'Male', '721234501V', 'mahinda.ds01@gmail.com', '0718800001', '15 Main Street, Galle', 5, 'Active', '2026-07-26 20:25:10', '74_20260727_001939.jpg'),
(75, 'ds_colombo01', '$2y$10$lUbJHTrjIBT8MDN.VEnV1uKSWzwi8k48EWx.dI4ztxR85YHdztcCC', 'Nadeeka Perera', 'Female', '741234502V', 'nadeeka.ds02@gmail.com', '0718800002', '6 Ampitiya Road, Colombo', 5, 'Active', '2026-07-26 20:26:47', 'Default.png'),
(76, 'ds_gampaha01', '$2y$10$d0nzxp3j1FbhURBiFbreB.FRrrzUHCofvBwV7PDI5manKS8GiIraW', 'Chathurika Silva', 'Female', '781234504V', 'chathurika.ds02@gmail.com', '0718800004', '6 Ampitiya Road, Gampaha', 5, 'Active', '2026-07-26 20:28:50', 'Default.png'),
(77, 'ds_matara01', '$2y$10$uGBvrbawUOGRbYmV7E1FFOVVa..g34cNgFYhAqm8zMca.bztqAwSG', 'Roshan Wijesinghe', 'Male', '781237504V', 'roshan.ds02@gmail.com', '0718800007', '6 Ampitiya Road, Matara', 5, 'Active', '2026-07-26 20:29:50', 'Default.png'),
(78, 'fo_0001', '$2y$10$gYrAIKf261.DvkDsrw0NLezDl8t8mS4PS4Snw3AcMznbDfFk9hNni', 'Nuwan Perera', 'Male', '801567801V', 'nuwan.fo01@gmail.com', '0719900001', '15 Peradeniya Road, Kandy', 6, 'Active', '2026-07-26 20:32:38', '78_20260727_003316.jpeg'),
(79, 'fo_0002', '$2y$10$IK2Xl.wdumlZFrv/A64OX.9PEzeP3deafSO7b.eT83lLdTmlMyT6a', 'Chamari Silva', 'Female', '811567801V', 'chamari.fo01@gmail.com', '0719900002', '24 Katugastota Road, Galle', 6, 'Active', '2026-07-26 20:34:05', 'Default.png'),
(80, 'fo_0003', '$2y$10$2T.75xC6f5xYv.Umdga10uvL5gXtrJAryKJpRbxXBdkDFW.b7kHWO', 'Roshan Fernando', 'Male', '841567803V', 'roshan.fo01@gmail.com', '0719900002', '24 Katugastota Road, Colombo', 6, 'Active', '2026-07-26 20:37:17', 'Default.png'),
(81, 'fo_0004', '$2y$10$xv8JCi/Tb9lvA1kvT/YB6.oC6Epv11yqyjsNBPQI8R3lfjgvl1E.u', 'Nadeesha Jayawardena', 'Female', '861567804V', 'nadeesha.fo01@gmail.com', '0719900007', '24 Katugastota Road, Gampaha', 6, 'Active', '2026-07-26 20:38:36', 'Default.png'),
(135, 'dmo_galle01', '$2y$10$FKBH8hRD5g.5X6PI.Zr0m.wMFxoNF3Pm96tUN3scGd4bKxWVy.Ynu', 'Ruwan Jayawardena', 'Male', '801234501V', 'ruwan.dmo01@gmail.com', '0717700001', '25 Peradeniya Road, Kandy', 2, 'Active', '2026-07-27 00:13:37', '135_20260726_230619.jpeg'),
(136, 'dmo_colombo01', '$2y$10$mvCAucPxBDrQiD/abkss4.jlyOvBKpBFY8fcJB16X/lUdBbDI3xZq', 'Nayana Perera', 'Female', '821234502V', 'nayana.dmo02@gmail.com', '0717700002', '42 Katugastota Road, Kandy', 2, 'Active', '2026-07-27 00:29:39', 'Default.png'),
(137, 'dmo_matara01', '$2y$10$YQKSxPcVu4MnfPxbrmnPxu0EjftZ/OkIziYGBuvkY8W/MuaIvmNVS', 'Chaminda Silva', 'Male', '821234572V', 'chaminda.dmo02@gmail.com', '0717700007', '42 Katugastota Road, Kandy', 2, 'Active', '2026-07-27 00:30:57', 'Default.png'),
(138, 'dmo_gampaha01', '$2y$10$J1JEuZiP9trrO8CggtVE5.IuLnFQLt1GkjXy6F5jEWDuYkXwW7JiW', 'Dilrukshi Fernando', 'Female', '821234506V', 'dilrukshi.dmo02@gmail.com', '0717700004', '25 Peradeniya Road, Kandy', 2, 'Active', '2026-07-27 00:32:45', 'Default.png'),
(139, 'lao_galle01', '$2y$10$523Xfj62739xkfRtyIBERuEu8FoFrSpdPYdSwUBUyPcDVFVAO0Yny', 'Nimal Perera', 'Male', '901234567V', 'nimal.perera01@gmail.com', '0712345001', '15 Main Street, Galle', 4, 'Active', '2026-07-27 00:58:27', 'Default.png'),
(140, 'lao_galle02', '$2y$10$l2QwJ5FC4H5qZc/Hl05mFOvBZGm2ecVGEN7OlY/S4SSG8fuhS12IS', 'Kasun Silva', 'Male', '902234567V', 'kasun.perera01@gmail.com', '0712345002', '16 Main Street, Galle', 4, 'Active', '2026-07-27 00:59:33', '140_20260726_221921.jpeg'),
(141, 'lao_galle03', '$2y$10$mYE8ltAodwsxHXp8XafTeeVxSewa7tyt8vOq/9x1Ye7rY.L4espoy', 'Dilani Fernando', 'Female', '902234568V', 'dilani.lao01@gmail.com', '0712345003', '16 Main Street, Galle', 4, 'Active', '2026-07-27 01:00:35', 'Default.png'),
(142, 'lao_galle04', '$2y$10$JMrxB9fMowKXqOMhfCaj/eU2KY2wH0kNyTh2oBZujz8s9vtxTNuzu', 'Tharindu Fernando', 'Male', '902234569V', 'tharindu.lao01@gmail.com', '0712345004', '17 Main Street, Galle', 4, 'Active', '2026-07-27 01:01:45', 'Default.png'),
(143, 'lao_galle05', '$2y$10$TF8H.xjfIadRf7Xb3X5kJ.rq.69dhwo1jNPrG9gRLk8SudYlXLSua', 'Sanduni Wickramasinghe', 'Female', '902734569V', 'sanduni.lao01@gmail.com', '0712345005', '17 Main Street, Galle', 4, 'Active', '2026-07-27 01:03:26', 'Default.png'),
(144, 'lao_galle06', '$2y$10$lndzZmnQ/hCgxiaDhC3HfuXSn5XLnP4k7RpeoKzEw/Fa4xU1ll5Vm', 'Chamara Wickramasinghe', 'Male', '902734560V', 'chamara.lao01@gmail.com', '0712345006', '47 Main Street, Galle', 4, 'Active', '2026-07-27 01:04:30', 'Default.png'),
(145, 'Citizen01', '$2y$10$BxVBPHAFuBAZx9TGdks57eGoiYYOR7muhemZrGm/lS0yv/xPibtsy', 'Chamara Rajapaksha', 'Male', '951234571V', 'chamara.r02@gmail.com', '0712345006', '77 New Town, Galle', 3, 'Active', '2026-07-27 01:07:12', '145_20260726_221517.jpg'),
(146, 'Citizen02', '$2y$10$wX5vnkq4yi51mc7HXprsduHwMaeYf1bRH8ZscBUiFlM6a9el3ZQF.', 'Hiruni Sandamali', 'Female', '951234577V', 'hiruni.r02@gmail.com', '0712345009', '77 New Town, Galle', 3, 'Active', '2026-07-27 01:10:04', '146_20260726_221557.png'),
(147, 'Piumi', '$2y$10$RQq2FuWE3EP3MDl/QSF.RO8xOkGXEsVufN/eeUJqDrf7naV5bqsVO', 'Piumi Sewwandi', 'Female', '951234577V', 'piumi.r02@gmail.com', '0712345099', '7 New Town, Galle', 3, 'Active', '2026-07-27 01:11:53', 'Default.png'),
(148, 'Sahan Chathuranga', '$2y$10$/RzuKK2fCY877sigFVcFd.OVe57ow1Ufv8AtApdE4I9W4ioCtFFeW', 'Sahan Chathuranga', 'Male', '951234577V', 'sahan.r02@gmail.com', '0712345091', '7 New Town, Galle', 3, 'Active', '2026-07-27 01:13:00', 'Default.png'),
(149, 'Kamal', '$2y$10$2P9Npognpv3WQExYp2jyq.BiuRRiq5Amjlusf51GiFPJUS8jlmpxa', 'Kamal Chathuranga', 'Male', '951234578V', 'kamalC.r02@gmail.com', '0712345097', '7 pansala road, Galle', 3, 'Active', '2026-07-27 01:14:33', 'Default.png');

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
(1, 77, 135, 'Not enough Evidance', 'Rejected', NULL, '2026-07-27 02:22:46'),
(2, 77, 135, 'File upload after inform', 'Verified', 250000.00, '2026-07-27 02:23:24'),
(3, 84, 135, 'Not enough Evidance', 'Rejected', NULL, '2026-07-27 02:23:49'),
(4, 85, 135, 'Evidance Verified.', 'Verified', 10000.00, '2026-07-27 02:41:26'),
(5, 86, 135, 'Evidance Verified.', 'Verified', 30000.00, '2026-07-27 02:41:37'),
(6, 87, 135, 'Evidance Verified.', 'Verified', 250000.00, '2026-07-27 02:41:56'),
(7, 88, 135, 'Evidance Verified.', 'Verified', 50000.00, '2026-07-27 02:42:06'),
(8, 77, 74, 'Evidance Verified and procced.', 'Verified', 250000.00, '2026-07-27 02:48:29'),
(9, 87, 74, 'Not enough Evidance.', 'Rejected', NULL, '2026-07-27 02:48:51'),
(10, 85, 74, 'Evidance Verified and procced.', 'Verified', 10000.00, '2026-04-27 02:49:08'),
(11, 86, 74, 'Evidance Verified and procced.', 'Verified', 30000.00, '2026-05-27 02:49:15'),
(12, 88, 74, 'not enough evidance', 'Rejected', NULL, '2026-07-27 02:49:39'),
(13, 88, 74, 'Evidance Verified and procced.', 'Verified', 50000.00, '2026-07-27 02:50:33'),
(14, 100, 135, 'Evidance Verified', 'Verified', 2500000.00, '2026-07-27 03:36:43'),
(15, 91, 135, 'Evidance Verified', 'Verified', 30000.00, '2026-06-27 03:36:54'),
(16, 92, 135, 'Evidance Verified', 'Verified', 1200000.00, '2026-07-27 03:37:08'),
(17, 93, 135, 'Evidance Verified', 'Verified', 2000000.00, '2026-04-27 03:37:33'),
(18, 94, 135, 'Evidance Verified', 'Verified', 450000.00, '2026-05-27 03:37:46'),
(19, 95, 135, 'Evidance Verified', 'Verified', 30000.00, '2026-07-27 03:38:06'),
(20, 96, 135, 'Evidance Verified', 'Verified', 10000.00, '2026-05-27 03:38:15'),
(21, 97, 135, 'Evidance Verified', 'Verified', 80000.00, '2026-06-27 03:38:23'),
(22, 98, 135, 'Not Enough Evidance', 'Rejected', NULL, '2026-07-27 03:40:48'),
(23, 99, 135, 'Not Enough Evidance', 'Rejected', NULL, '2026-07-27 03:40:55'),
(24, 92, 74, 'Not Enough Evidance', 'Rejected', NULL, '2026-07-27 03:50:09'),
(25, 91, 74, 'Verified Report Details', 'Verified', 30000.00, '2026-06-27 03:51:12'),
(26, 93, 74, 'Verified Report Details', 'Verified', 2000000.00, '2026-07-27 03:51:32'),
(27, 94, 74, 'Verified Report Details', 'Verified', 450000.00, '2026-07-27 03:53:15'),
(28, 95, 74, 'Verified Report Details', 'Verified', 30000.00, '2026-07-27 03:53:24'),
(29, 100, 74, 'Verified Report Details', 'Verified', 2500000.00, '2026-07-27 03:57:03');

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
  MODIFY `Compensation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `disaster_report`
--
ALTER TABLE `disaster_report`
  MODIFY `Report_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

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
  MODIFY `File_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `Notification_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `password_reset_otp`
--
ALTER TABLE `password_reset_otp`
  MODIFY `otp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `verification_report`
--
ALTER TABLE `verification_report`
  MODIFY `Verification_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
