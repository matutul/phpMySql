-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2020 at 04:18 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `course`
--
CREATE DATABASE IF NOT EXISTS `course` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `course`;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `lid` varchar(50) NOT NULL,
  `lec_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`lid`, `lec_name`) VALUES
('10001', 'Md Mahtab Hossain'),
('10002', 'Abdullah Alim'),
('10003', 'Md Kaikobad Rahman'),
('10004', 'Shaswata Kumar Mondol');

-- --------------------------------------------------------

--
-- Table structure for table `slot`
--

CREATE TABLE `slot` (
  `sl_no` int(10) NOT NULL,
  `slot_id` varchar(50) NOT NULL,
  `slot` varchar(300) NOT NULL,
  `snum` int(1) NOT NULL DEFAULT 0,
  `lid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slot`
--

INSERT INTO `slot` (`sl_no`, `slot_id`, `slot`, `snum`, `lid`) VALUES
(1, '100', 'Sunday 10.00AM to 12.00AM', 6, '10001'),
(4, '101', 'Sunday 3.00PM to 5.00PM', 3, '10002'),
(5, '102', 'Wednesday 10.00AM to 12.00AM', 2, '10003'),
(6, '103', 'Wednesday 3.00PM to 5.00PM', 1, '10004');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `sl` int(10) NOT NULL,
  `sid` varchar(50) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `slot_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`sl`, `sid`, `fname`, `lname`, `email`, `slot_id`) VALUES
(16, '123123', 'Umme Habiba', 'Rahman', 'habiba@edu.bd', '100'),
(23, '163-15-8523', 'Md Mominul', 'Islam', 'asad@ecu.bd', '100'),
(27, '171-15-9000', 'Ahmed', 'Shehjad', 'ahmed@edu.bd', '103'),
(14, '171-15-9427', 'Md Ashrafujjaman', 'Tutul', 'tutul@edu.bd', '101'),
(25, '171-15-9443', 'Farjana', 'Mou', 'mou@edu.bd', '101'),
(28, '171-15-9444', 'Hasnain', 'Arif', 'arif@edu.bd', '102'),
(26, '171-15-9455', 'Fazlay', 'Rabbi', 'rabbi@edu.bd', '102'),
(15, '171-15-9465', '&lt;&lt;Mehedi Hasan&lt;?php echo ?&gt;', '&lt;?php&quot;Select * from slot&quot;?&gt;Choyen', 'choyon@edu.bd', '101'),
(24, '171-15-9554', 'Roni', 'Mushaddek', 'roni@edu.bd', '100'),
(17, '234234', 'Ahmed', 'Amin', 'amin@edu.bd', '101'),
(29, '654654', 'Abu', 'Taleb', 'taleb@gmail.com', '100'),
(19, '657', 'Abdullah', 'Momin', 'abd@edu.bd', '101');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`lid`);

--
-- Indexes for table `slot`
--
ALTER TABLE `slot`
  ADD PRIMARY KEY (`slot_id`),
  ADD KEY `sl_no` (`sl_no`),
  ADD KEY `lid` (`lid`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `sid` (`sid`),
  ADD KEY `sl` (`sl`),
  ADD KEY `slot_id` (`slot_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `slot`
--
ALTER TABLE `slot`
  MODIFY `sl_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `sl` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `slot`
--
ALTER TABLE `slot`
  ADD CONSTRAINT `slot_ibfk_1` FOREIGN KEY (`lid`) REFERENCES `lecturer` (`lid`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`slot_id`) REFERENCES `slot` (`slot_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
