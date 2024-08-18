-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2024 at 10:09 PM
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
-- Database: `app4grad`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '2020-11-03 05:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `appID` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `middleName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `studNumber` char(9) NOT NULL,
  `program` varchar(100) NOT NULL,
  `section` varchar(100) NOT NULL,
  `birthDate` varchar(100) NOT NULL,
  `birthPlace` varchar(255) NOT NULL,
  `age` int(2) NOT NULL,
  `sex` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phoneNumber` char(11) NOT NULL,
  `status` int(1) NOT NULL,
  `regDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `id` int(11) NOT NULL,
  `appID` int(11) DEFAULT NULL,
  `appType` varchar(100) NOT NULL,
  `appDate` date NOT NULL,
  `isRead` int(1) NOT NULL,
  `RAstatus` int(1) NOT NULL,
  `CRstatus` int(1) NOT NULL DEFAULT 0,
  `DHstatus` int(1) NOT NULL DEFAULT 0,
  `CDstatus` int(1) NOT NULL DEFAULT 0,
  `RAremark` mediumtext DEFAULT NULL,
  `RAremarkDate` varchar(100) DEFAULT NULL,
  `DHremarkDate` varchar(100) DEFAULT NULL,
  `CDremarkDate` varchar(100) DEFAULT NULL,
  `CRremarkDate` varchar(100) DEFAULT NULL,
  `RAstaffID` int(11) NOT NULL,
  `studNum` int(9) NOT NULL,
  `email` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `middleName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `sex` varchar(100) NOT NULL,
  `age` int(2) NOT NULL,
  `birthDate` varchar(100) NOT NULL,
  `birthPlace` varchar(255) NOT NULL,
  `phoneNumber` char(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `shs` varchar(100) NOT NULL,
  `shsYear` varchar(100) NOT NULL,
  `shsAddress` varchar(255) NOT NULL,
  `osc` varchar(100) NOT NULL,
  `oscYear` varchar(100) NOT NULL,
  `oscAddress` varchar(255) NOT NULL,
  `admissionDate` varchar(100) NOT NULL,
  `1First` varchar(100) NOT NULL,
  `1Second` varchar(100) NOT NULL,
  `1Summer` varchar(100) NOT NULL,
  `2First` varchar(100) NOT NULL,
  `2Second` varchar(100) NOT NULL,
  `2Summer` varchar(100) NOT NULL,
  `3First` varchar(100) NOT NULL,
  `3Second` varchar(100) NOT NULL,
  `3Summer` varchar(100) NOT NULL,
  `4First` varchar(100) NOT NULL,
  `4Second` varchar(100) NOT NULL,
  `4Summer` varchar(100) NOT NULL,
  `5First` varchar(100) NOT NULL,
  `5Second` varchar(100) NOT NULL,
  `5Summer` varchar(100) NOT NULL,
  `6First` varchar(100) NOT NULL,
  `6Second` varchar(100) NOT NULL,
  `6Summer` varchar(100) NOT NULL,
  `sub1` varchar(100) NOT NULL,
  `7First` varchar(100) NOT NULL,
  `7Second` varchar(100) NOT NULL,
  `7Summer` varchar(100) NOT NULL,
  `8First` varchar(100) NOT NULL,
  `8Second` varchar(100) NOT NULL,
  `8Summer` varchar(100) NOT NULL,
  `unit1` int(1) NOT NULL,
  `sub2` varchar(100) NOT NULL,
  `unit2` int(1) NOT NULL,
  `sub3` varchar(100) NOT NULL,
  `unit3` int(1) NOT NULL,
  `sub4` varchar(100) NOT NULL,
  `unit4` int(1) NOT NULL,
  `sub5` varchar(100) NOT NULL,
  `unit5` int(1) NOT NULL,
  `sub6` varchar(100) NOT NULL,
  `unit6` int(1) NOT NULL,
  `sub7` varchar(100) NOT NULL,
  `unit7` int(1) NOT NULL,
  `sub8` varchar(100) NOT NULL,
  `unit8` int(1) NOT NULL,
  `totalUnits` int(2) NOT NULL,
  `lowestGrade` char(4) NOT NULL,
  `transfereeLowest` char(4) NOT NULL,
  `program` varchar(100) NOT NULL,
  `gradYear` varchar(100) NOT NULL,
  `signature` varchar(100) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `COC` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `DepartmentName` varchar(150) DEFAULT NULL,
  `DepartmentShortName` varchar(100) NOT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `DepartmentName`, `DepartmentShortName`, `CreationDate`) VALUES
(4, 'Department of Civil Engineering', 'DCEA', '2023-11-21 13:43:00'),
(7, 'Department of Computer and Electronics Engineering', 'DCEE', '2023-11-21 13:46:50'),
(8, 'Department of Industrial Engineering and Technology', 'DIET', '2023-11-21 13:49:22'),
(10, 'Department of Agriculture and Food Engineering', 'DAFE', '2023-11-21 13:50:16'),
(11, 'Department of Information Technology', 'DIT', '2023-11-21 13:51:01');

-- --------------------------------------------------------

--
-- Table structure for table `duration`
--

CREATE TABLE `duration` (
  `id` int(11) NOT NULL,
  `gradYear` int(4) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `deadline` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `duration`
--

INSERT INTO `duration` (`id`, `gradYear`, `startDate`, `endDate`, `deadline`) VALUES
(2, 2025, '2024-06-01', '2024-07-24', '2024-06-30');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `ProgramName` varchar(150) DEFAULT NULL,
  `ProgramShortName` varchar(100) NOT NULL,
  `deptID` int(11) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `ProgramName`, `ProgramShortName`, `deptID`, `CreationDate`) VALUES
(1, 'Bachelor of Science in Agricultural and Biosystems Engineering', 'BSABE', 10, '2023-11-26 15:16:59'),
(2, 'Bachelor of Science in Architecture', 'BSARCH', 4, '2023-11-26 15:20:29'),
(3, 'Bachelor of Science in Civil Engineering', 'BSCE', 4, '2023-11-26 15:21:01'),
(4, 'Bachelor of Science in Computer Engineering', 'BSCPE', 7, '2023-11-26 15:21:32'),
(5, 'Bachelor of Science in Computer Science', 'BSCS', 11, '2023-11-26 15:21:46'),
(6, 'Bachelor of Science in Electrical Engineering', 'BSEE', 7, '2023-11-26 15:23:22'),
(7, 'Bachelor of Science in Electronics Engineering', 'BSECE', 7, '2023-11-26 15:23:51'),
(8, 'Bachelor of Science in Industrial Engineering', 'BSIE', 8, '2023-11-26 15:24:11'),
(9, 'Bachelor of Science in Industrial Technology Major in Automotive Technology', 'BSIND-AT', 8, '2023-11-26 15:25:14'),
(10, 'Bachelor of Science in Industrial Technology Major in Electrical Technology', 'BSIND-ET', 8, '2023-11-26 15:25:56'),
(11, 'Bachelor of Science in Industrial Technology Major in Electronics Technology', 'BSINDT-ECT', 8, '2023-11-26 15:26:26'),
(12, 'Bachelor of Science in Information Technology', 'BSIT', 11, '2023-11-26 15:26:42'),
(13, 'Bachelor of Science in Office Administration', 'BSOA', 11, '2023-11-26 15:27:16');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `middleName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `program` varchar(100) NOT NULL,
  `sex` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phoneNumber` char(11) NOT NULL,
  `status` int(1) NOT NULL,
  `regDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(30) NOT NULL,
  `location` varchar(100) NOT NULL,
  `signature` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `firstName`, `lastName`, `middleName`, `email`, `password`, `program`, `sex`, `department`, `address`, `phoneNumber`, `status`, `regDate`, `role`, `location`, `signature`) VALUES
(28, 'Jake', 'Ersando', 'R', 'college.registrar@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', '', 'Male', '', 'Indang, Cavite', '09123456789', 1, '2024-05-19 04:07:22', 'College Registrar', 'NO-IMAGE-AVAILABLE.jpg', '66497afa9c86a_signature-40156.png'),
(29, 'Gladys', 'Perey', 'G', 'gladys.perey@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSIT', 'Female', 'DIT', 'Silang, Cavite', '09123456789', 1, '2024-05-19 04:11:28', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '66497bf008036_signature-40131.png'),
(30, 'Charlotte', 'Carandang', 'B', 'charlotte.carandang@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSIT', 'Female', 'DIT', 'Amadeo, Cavite', '09123456789', 1, '2024-05-19 04:15:05', 'Department Head', 'NO-IMAGE-AVAILABLE.jpg', '66497cc9b5991_signature-40144.png'),
(31, 'Dr. Willie', 'Buclatin', 'C', 'college.dean@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', '', 'Male', '', 'Tagayatay City, Cavite', '09123456789', 1, '2024-05-19 04:17:30', 'College Dean', 'NO-IMAGE-AVAILABLE.jpg', '66497d5ad0bb1_signature-40137.png'),
(32, 'Jake', 'Veron', 'R.', 'jake.veron@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSIT', 'Male', 'DIT', 'Tanza Cavite ', '09097846142', 1, '2024-06-05 07:24:31', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '666012af90088_ven.png'),
(33, 'john vincent', 'Bonza', 'J.', 'bonza@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSCS', 'Male', 'DIT', 'asASas', '09261234567', 1, '2024-06-05 09:33:28', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '666030e80fdef_CABALLERO_SIGN.png'),
(34, 'Joshua', 'Dantes', 'R', 'joshua.dantes@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSCS', 'Male', 'DIT', 'Tanza Cavite', '09978525735', 1, '2024-06-06 02:57:09', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '6661258502f6e_ven.png'),
(35, 'Ma. Fatima', 'Zuniga', 'B.', 'fatima.zuniga@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', '', 'Female', 'DIET', 'Indang Cavite', '09058068581', 1, '2024-06-06 06:19:05', 'Department Head', 'NO-IMAGE-AVAILABLE.jpg', '666154d96f29b_ven.png'),
(36, 'Michael', 'Costa', 'T.', 'michael.costa@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', '', 'Male', 'DCEE', 'Indang Cavite', '09058068581', 1, '2024-06-06 06:54:29', 'Department Head', 'NO-IMAGE-AVAILABLE.jpg', '66615d25efb08_ven.png'),
(37, 'Roslyn', 'Peña', 'P.', 'roslyn.peña@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', '', 'Female', 'DCEA', 'Indang Cavite', '09058068581', 1, '2024-06-06 07:14:53', 'Department Head', 'NO-IMAGE-AVAILABLE.jpg', '666161ede106d_ven.png'),
(38, 'Al Owen Roy', 'Ferrera', 'A.', 'owen.ferrera@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', '', 'Male', 'DAFE', 'Indang Cavite', '09058068581', 1, '2024-06-06 07:16:33', 'Department Head', 'NO-IMAGE-AVAILABLE.jpg', '66616251987f6_ven.png'),
(39, 'Novie', 'Obeal', 'T.', 'novie.obeal@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSIE', 'Female', 'DIET', 'Indang, Cavite', '09058068581', 1, '2024-06-07 04:01:50', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '6662862ea894d_ven.png'),
(40, 'Mary', 'Sandow', 'B.', 'mary.sandow@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSIE', 'Female', 'DIET', 'Indang Cavite', '09058068581', 1, '2024-06-07 04:51:29', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '666291d1ce33a_ven.png'),
(41, 'Roweldin', 'Mendoza', 'G.', 'roweldin.mendoza@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSIND-AT', 'Male', 'DIET', 'Indang Cavite', '09058068581', 1, '2024-06-07 04:53:29', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '66629249d2ff1_ven.png'),
(42, 'Ron', 'Dognidon', 'R.', 'ron.dognidon@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSIND-AT', 'Male', 'DIET', 'Indang Cavite', '09058068581', 1, '2024-06-07 04:54:53', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '6662929ddce0e_ven.png'),
(43, 'John', 'Balaba', 'R.', 'john.balaba@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSIND-ET', 'Male', 'DIET', 'Indang Cavite', '09058068581', 1, '2024-06-07 04:57:16', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '6662932c49736_ven.png'),
(44, 'Geraline', 'Fererra', 'H.', 'geraline.fererra@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSINDT-ECT', 'Female', 'DIET', 'Indang, Cavite', '09058068581', 1, '2024-06-07 05:01:04', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '6662941040b60_ven.png'),
(45, 'Andrea', 'Ofarel', 'R.', 'andrea.ofarel@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSINDT-ECT', 'Female', 'DIET', 'Indang Cavite', '09058068581', 1, '2024-06-07 05:07:29', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '666295918ee7d_ven.png'),
(46, 'Michael', 'Marcaida', 'J.', 'michael.marcaida@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSIND-ET', 'Male', 'DIET', 'Indang Cavite', '09058068581', 1, '2024-06-07 05:10:52', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '6662965c7d047_ven.png'),
(47, 'Angelo', 'Lagmay', 'K.', 'angelo.lagmay@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSCPE', 'Male', 'DCEE', 'Indang Cavite', '09058068581', 1, '2024-06-07 05:18:22', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '6662981e91715_ven.png'),
(48, 'Catriza', 'Escalante', 'D.', 'catriza.escalante@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSCPE', 'Female', 'DCEE', 'Indang Cavite', '09058068581', 1, '2024-06-07 05:19:37', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '66629869aa293_ven.png'),
(49, 'Christian', 'Amparo', 'T.', 'christian.amparo@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSEE', 'Male', 'DCEE', 'Indang Cavite', '09058068581', 1, '2024-06-07 05:21:16', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '666298cc7efc4_ven.png'),
(50, 'Hanz', 'Cabugos', 'J.', 'hanz.cabugos@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSEE', 'Male', 'DCEE', 'Indang Cavite', '09058068581', 1, '2024-06-07 05:22:30', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '66629916565d9_ven.png'),
(51, 'Janette', 'Aquino', 'A.', 'janette.aquino@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSECE', 'Female', 'DCEE', 'Indang Cavite', '09058068581', 1, '2024-06-07 05:24:31', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '6662998fd946b_ven.png'),
(52, 'Ervin', 'Javier', 'J.', 'ervin.javier@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSARCH', 'Male', 'DCEA', 'Indang Cavite', '09058068581', 1, '2024-06-07 05:25:42', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '666299d6929a4_ven.png'),
(53, 'Jonel', 'Mendoza', 'M.', 'jonel.mendoza@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSCE', 'Male', 'DCEA', 'Indang Cavite', '09058068581', 1, '2024-06-07 05:28:15', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '66629a6f65dd2_ven.png'),
(54, 'Joseph', 'Hocson', 'G.', 'joseph.hocson@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSCE', 'Male', 'DCEA', 'Indang Cavite', '09058068581', 1, '2024-06-07 05:29:11', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '66629aa73aefe_ven.png'),
(55, 'Kreistler', 'Reyes', 'K.', 'kreistler.reyes@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSARCH', 'Male', 'DCEA', 'Indang Cavite', '09058068581', 1, '2024-06-07 05:30:16', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '66629ae827ff1_ven.png'),
(56, 'Kobe', 'Catapang', 'R.', 'kobe.catapang@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSARCH', 'Male', 'DCEA', 'Indang Cavite', '09058068581', 1, '2024-06-07 05:31:11', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '66629b1fc0fa6_ven.png'),
(57, 'Patrick', 'Laudato', 'J.', 'patrick.james@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSABE', 'Male', 'DAFE', 'Indang Cavite', '09058068581', 1, '2024-06-07 05:32:37', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '66629b75bb167_ven.png'),
(58, 'Winsie', 'Rebaya', 'G.', 'winsie.rebaya@cvsu.edu.ph', 'dcb1dcca8955f7a8d409654782c4b363', 'BSABE', 'Female', 'DAFE', 'Indang Cavite', '09058068581', 1, '2024-06-07 05:33:32', 'Registration Adviser', 'NO-IMAGE-AVAILABLE.jpg', '66629bac408cf_ven.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`appID`);

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`appID`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `duration`
--
ALTER TABLE `duration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `appID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `duration`
--
ALTER TABLE `duration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
