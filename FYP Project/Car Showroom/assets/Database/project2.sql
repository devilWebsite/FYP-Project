-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2024 at 01:22 PM
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
-- Database: `project2`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminlogin`
--

CREATE TABLE `adminlogin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminlogin`
--

INSERT INTO `adminlogin` (`username`, `password`) VALUES
('admin', '123');

-- --------------------------------------------------------

--
-- Table structure for table `brandlist`
--

CREATE TABLE `brandlist` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `imagePath` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `dateUpdated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brandlist`
--

INSERT INTO `brandlist` (`id`, `name`, `imagePath`, `status`, `dateUpdated`) VALUES
(1, 'Toyota', 'brand-1.png', 'Active', '2024-04-29 03:59:55'),
(4, 'Suzuki', 'brand-7.png', 'Active', '2024-04-29 04:01:21'),
(5, 'Honda', 'brand-8.png', 'Active', '2024-04-29 04:01:34'),
(6, 'BMW', 'download.jpeg', 'Active', '2024-04-29 04:03:22'),
(7, 'Hyundai', 'download (1).jpeg', 'Active', '2024-04-29 04:06:03'),
(8, 'Nissan', 'download (2).jpeg', 'Active', '2024-04-29 04:06:15'),
(9, 'Perodua', 'Perodua.png', 'Active', '2024-04-29 04:06:34'),
(10, 'Proton', 'Proton.jpeg', 'Active', '2024-04-29 04:06:42');

-- --------------------------------------------------------

--
-- Table structure for table `carlist`
--

CREATE TABLE `carlist` (
  `id` varchar(8) NOT NULL,
  `carType` varchar(255) NOT NULL,
  `brandType` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `year` year(4) NOT NULL,
  `mileage` int(11) NOT NULL,
  `fuel` varchar(50) NOT NULL,
  `engine` varchar(50) NOT NULL,
  `transmission` enum('Manual','Automatic') NOT NULL,
  `productImg` text NOT NULL,
  `OtherImg` text NOT NULL,
  `status` enum('Sold','Available','Unavailable') NOT NULL,
  `dateUpdated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `newCar` enum('New','Non-New') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carlist`
--

INSERT INTO `carlist` (`id`, `carType`, `brandType`, `price`, `year`, `mileage`, `fuel`, `engine`, `transmission`, `productImg`, `OtherImg`, `status`, `dateUpdated`, `newCar`) VALUES
('664b02f8', 'Honda City', 'Honda', 82900.00, '2018', 102463, 'Petrol', 'VTEC', 'Automatic', 'uploads/Honda City.png', 'uploads/Pic 1.jpeg', 'Available', '2024-05-20 07:59:52', 'New'),
('66431794', 'axia', 'Perodua', 12500.00, '2023', 100250, 'Petrol', '1.598 turbo', 'Automatic', 'uploads/Pic 3.jpg', 'uploads/Pic 3.jpg', 'Unavailable', '2024-06-24 07:41:11', 'New'),
('6643186d', 'Ativa', 'Proton', 12000.00, '2024', 100250, 'Petrol', '1.598 turbo', 'Automatic', 'uploads/brand-3.png', 'uploads/Pic 3.jpg', 'Sold', '2024-06-24 07:41:32', 'Non-New'),
('66442c93', 'Navara', 'Nissan', 4500000.00, '2023', 100250, 'Gasoline', '1.598 turbo', 'Manual', 'uploads/download (2).jpeg', 'uploads/Pic 3.jpg', 'Available', '2024-05-15 03:31:31', 'New'),
('6646fbd0', 'Proton Saga', 'Proton', 1520000.00, '2024', 100265, 'Petrol', '1.598 xyhsd', 'Automatic', 'uploads/Pic 3.jpg', 'uploads/brand-2.png', 'Available', '2024-05-17 06:40:16', 'New'),
('6646fc08', 'Proton Wira', 'Proton', 250000.00, '2001', 116962, 'Petrol', 'kvn jdz', 'Manual', 'uploads/Pic 1.jpeg', 'uploads/backgroundImg.jpeg', 'Available', '2024-05-17 06:41:12', 'New'),
('6646fc7e', 'S70', 'Proton', 500000.00, '2024', 100000, 'Petrol', '1.598 xyhsd', 'Automatic', 'uploads/S70.jpeg', 'uploads/locationIcon.png', 'Available', '2024-05-17 06:43:10', 'New'),
('664b11e2', 'Axia', 'Perodua', 12000.00, '2021', 104528, 'Petrol', 'VTEC 1.5', 'Manual', 'uploads/Pic 3.jpg', 'uploads/S70.jpeg', 'Available', '2024-05-20 09:03:30', 'New'),
('66792882', 'X1', 'BMW', 1001500.00, '2024', 17109, 'Petrol', 'G 1.8', 'Manual', 'uploads/X4.png', 'uploads/x4 - 1.png,uploads/x4 - 2.png,uploads/x4 - 3.png,uploads/x4 - 4.png,uploads/x4 - 5.png', 'Available', '2024-06-24 08:04:53', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `carserviceapp`
--

CREATE TABLE `carserviceapp` (
  `serviceId` int(10) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `carPlateNo` varchar(20) NOT NULL,
  `carBrand` varchar(20) NOT NULL,
  `carModel` varchar(20) NOT NULL,
  `carYear` int(11) NOT NULL,
  `services` varchar(255) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `serviceCenter` enum('Rawang','Puncak Alam') NOT NULL,
  `appointmentDate` date NOT NULL,
  `appointmentTime` varchar(20) NOT NULL,
  `status` enum('Pending','Resolved') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carserviceapp`
--

INSERT INTO `carserviceapp` (`serviceId`, `email`, `name`, `phoneNumber`, `carPlateNo`, `carBrand`, `carModel`, `carYear`, `services`, `remark`, `serviceCenter`, `appointmentDate`, `appointmentTime`, `status`) VALUES
(3524793, 'reenanair0713@gmail.com', 'reena nair', '0136584269', 'VAR1235', 'Honda', 'Civic', 2022, 'generalService', '0', 'Puncak Alam', '2024-06-01', '17:30', 'Resolved'),
(3524792, 'ravinmaha1703@gmail.com', 'Ravindraaa', '0189864035', 'MDU4003', 'Proton', 'S70', 2024, 'generalService', '0', 'Rawang', '2024-06-08', '12:50', 'Resolved'),
(3524794, 'mahaletchumy1708@gmail.com', 'Maha', '0136584269', 'RMM1708', 'Honda', 'Civic', 2022, 'others', 'gmbn3ghriu ktrjghfv', 'Rawang', '2024-07-27', '09.30', 'Pending'),
(3524795, 'thanesh0508@gmail.com', 'Thanesh', '0175181430', 'RLT1569', 'Honda', 'City', 2018, 'Array', '', 'Puncak Alam', '2024-04-24', '17:05', 'Pending'),
(3524808, 'chewlan8@gmail.com', 'Chew Lan', '0152634581', 'HDU3004', 'Perodua', 'Axia', 2022, 'generalService', 'RFNIJE NDIFJIDS 1558 ', 'Rawang', '2024-06-06', '10.00', 'Pending'),
(3524797, 'theva0401@gmail.com', 'Theva', '0142503612', 'BKJ1234', 'Proton', 'Ativa', 2025, 'a:1:{i:0;s:12:\"brake-system\";}', '0', 'Rawang', '2024-04-29', '13:10', 'Resolved'),
(3524798, 'tina01@gmail.com', 'Tina', '0125478932', 'BPR4003', 'Proton', 'Wira', 2010, 'a:1:{i:0;s:14:\"generalService\";}', 'general service 98', '', '2024-05-25', '14:30', 'Pending'),
(3524799, 'devi08@gmail.com', 'Devi', '0152489604', 'BLK4561', 'Proton', 'Axia', 2025, 'a:1:{i:0;s:6:\"others\";}', 'Others', '', '2024-04-09', '14:33', 'Pending'),
(3524800, 'sdleij@gmail.com', 'devi raj', '0136584269', 'RMM1708', 'Proton', 'Waja', 2010, 'Array', 'fegvredbvrd', 'Rawang', '2024-05-10', '16:00', 'Pending'),
(3524801, 'fnerhfuwy@gmail.com', 'fnvre', '0102547891', 'DJB4255', 'Proton', 'Bezza', 2022, 'airconPollenFil', '0', 'Rawang', '2024-05-10', '18:11', 'Resolved'),
(3524802, 'kapi45@gmail.com', 'Kapineshwari', '0154213012', 'KUP4582', 'Perodua', 'Kancil', 2015, 'generalService', 'general service + full check on car', '', '2024-06-01', '17:16', 'Pending'),
(3524803, 'gvekfjl@gmail.com', 'jnhg', '0125410210', 'DKV2832', 'bgnbke', 'bvknrj', 2015, 'brake-system', 'ttrjgbnkr', 'Rawang', '2024-05-01', '16:21', 'Pending'),
(3524809, 'mahaletchumy1708@gmail.com', 'Mahaletchumy', '0165479250', 'RMM1708', 'Honda', 'Civic', 2022, 'generalService', 'jfhfifwd', 'Rawang', '2024-05-29', '09.00', 'Pending'),
(3524805, 'dvncd@gmail.com', 'vdsnjbh hg', '0102365104', 'RLT1259', 'vnbef', 'vm fnekve', 2022, 'periodic-maintenance', 'vmef', '', '2024-05-10', '16:22', 'Pending'),
(3524806, 'dcjn@gmail.com', 'djcnhudficc', '0120254781', 'mck4417', 'clkmdjvn', 'vlmnj', 2024, 'inspection', 'vnfhjueikl', 'Puncak Alam', '2024-05-01', '00:30', 'Pending'),
(3524807, 'vmcds@gmail.com', 'vkmsfvnhb', '0120254784', 'vdc4514', 'vmlfk', 'vlfgmn', 2023, 'battery', 'fv bngjrkodfpl;vc', 'Rawang', '2024-04-20', '00:32', 'Pending'),
(3524810, 'mahaletchumy1708@gmail.com', 'Maha', '0103651504', 'MPU0583', 'Nissan', 'Almera', 2023, 'inspection, suspension, others', 'm kgbnfid', 'Rawang', '2024-07-17', '13:00 - 14:00', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `inquiry`
--

CREATE TABLE `inquiry` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Pending','Resolved','Progress') NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiry`
--

INSERT INTO `inquiry` (`id`, `name`, `email`, `subject`, `message`, `status`, `dateCreated`) VALUES
(4011250, 'Maha', 'mahaletchumy1708@gmail.com', 'Car Loan', 'gref', 'Progress', '2024-06-24 07:35:40'),
(4011251, 'Maha', 'mahaletchumy1708@gmail.com', 'fvesrafvwas', 'scvwecfw', 'Pending', '2024-06-24 07:35:14'),
(4011252, 'Maha', 'corolla02@gmail.com', 'Car Loan ', 'vv', 'Pending', '2024-06-24 09:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phoneNumber` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `name`, `phoneNumber`, `email`, `username`, `password`, `date_created`) VALUES
(1, 'Maha', '0103651504', 'mahaletchumy1708@gmail.com', 'Maha1708', '$2y$10$lz4vAn6cdQY21fnUhpMoOuUlvm6mubVYRiNJCvK6EsKHaDeKEvU/K', '2024-06-24 07:24:59');

-- --------------------------------------------------------

--
-- Table structure for table `testdriveapp`
--

CREATE TABLE `testdriveapp` (
  `testDriveId` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `appointmentDate` date NOT NULL,
  `appointmentTime` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testdriveapp`
--

INSERT INTO `testdriveapp` (`testDriveId`, `name`, `phoneNumber`, `appointmentDate`, `appointmentTime`) VALUES
(5524797, 'Aiman', '0102589631', '2024-04-16', '17:30'),
(5524791, 'Ravin ', '0189864035', '2024-05-09', '13:00-03:00 '),
(5524792, 'Thana', '0165479250', '2024-05-01', '15:00-17:00 '),
(5524798, 'fjvidfv', '0131596470', '2024-05-15', '11:00-13:00'),
(5524794, 'edcds', '0125463250', '2024-04-30', '17:12'),
(5524795, 'cjkwedbfuw', '0131596470', '2024-04-30', '15:00-17:00 '),
(5524796, 'Hi tan', '0131596470', '2024-05-09', '15:00-17:00 '),
(5524799, 'Chew Lan', '0152634581', '2024-05-09', '15:00-17:00 '),
(5524800, 'Maha', '0103651504', '2024-07-06', '11:00-13:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminlogin`
--
ALTER TABLE `adminlogin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `brandlist`
--
ALTER TABLE `brandlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carlist`
--
ALTER TABLE `carlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carserviceapp`
--
ALTER TABLE `carserviceapp`
  ADD PRIMARY KEY (`serviceId`);

--
-- Indexes for table `inquiry`
--
ALTER TABLE `inquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `testdriveapp`
--
ALTER TABLE `testdriveapp`
  ADD PRIMARY KEY (`testDriveId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brandlist`
--
ALTER TABLE `brandlist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `carserviceapp`
--
ALTER TABLE `carserviceapp`
  MODIFY `serviceId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3524811;

--
-- AUTO_INCREMENT for table `inquiry`
--
ALTER TABLE `inquiry`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4011253;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testdriveapp`
--
ALTER TABLE `testdriveapp`
  MODIFY `testDriveId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5524801;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
