-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2025 at 07:12 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proj_libraryy`
--

-- --------------------------------------------------------

--
-- Table structure for table `addbooks`
--

CREATE TABLE `addbooks` (
  `id` int(11) NOT NULL,
  `BookName` varchar(255) NOT NULL,
  `CatId` int(11) NOT NULL,
  `AuthorId` int(11) NOT NULL,
  `ISBNNumber` varchar(25) NOT NULL,
  `BookPrice` decimal(10,2) NOT NULL,
  `bookImage` varchar(250) NOT NULL,
  `isIssued` int(1) NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `pdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `addbooks`
--

INSERT INTO `addbooks` (`id`, `BookName`, `CatId`, `AuthorId`, `ISBNNumber`, `BookPrice`, `bookImage`, `isIssued`, `RegDate`, `pdate`) VALUES
(1, 'PHP', 2, 6, '123', '500.00', 'image/PHP.jpeg', 1, '2025-03-10 10:00:43', '2019-07-10'),
(2, 'PYTHON', 2, 5, '456', '500.00', 'image/PYTHON.jpeg', 1, '2025-03-10 10:01:56', '2012-06-05'),
(3, 'THE LONG AGO', 1, 4, '789', '456.00', 'image/THE LONG AGO.jpg', 1, '2025-03-10 10:02:36', '2016-10-11'),
(4, 'ASP', 2, 7, '1234', '258.00', 'image/ASP.NET.jpeg', 0, '2025-03-10 10:03:29', '2012-01-30'),
(5, 'TO LIVE', 4, 4, '4567', '369.00', 'image/TO LIVE.jpg', 0, '2025-03-10 10:04:43', '2013-01-09'),
(6, 'THE BOY', 1, 8, '7897', '512.00', 'image/THE BOY.jpg', 0, '2025-03-10 10:06:02', '2007-02-20'),
(7, 'IMAGINE ME', 1, 4, '4564', '500.00', 'image/IMAGINE ME.jpg', 0, '2025-03-10 10:19:00', '2025-03-18');

-- --------------------------------------------------------

--
-- Table structure for table `adminlog`
--

CREATE TABLE `adminlog` (
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `adminlog`
--

INSERT INTO `adminlog` (`email`, `password`) VALUES
('kishan@gmail.com', 'KISHAN');

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `aid` int(10) NOT NULL,
  `author_name` varchar(50) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`aid`, `author_name`, `reg_date`) VALUES
(1, 'Leo Tolstoy', '2025-03-10 15:27:27'),
(2, 'Jane Austen', '2025-03-10 15:27:39'),
(3, 'Carl Sagan', '2025-03-10 15:27:54'),
(4, 'Kent Beck', '2025-03-10 15:28:06'),
(5, 'Guido', '2025-03-10 15:28:32'),
(6, 'Rasmus Lerdorf', '2025-03-10 15:28:48'),
(7, 'Scott Mitchell', '2025-03-10 15:29:09'),
(8, 'Dennis Ritchie', '2025-03-10 15:29:20');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cid` int(10) NOT NULL,
  `catename` varchar(50) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cid`, `catename`, `reg_date`) VALUES
(1, 'Graphic Novels', '2025-03-10 15:23:46'),
(2, 'Programming', '2025-03-10 15:24:25'),
(3, 'Arts', '2025-03-10 15:24:36'),
(4, 'Spiritual', '2025-03-10 15:24:48'),
(5, 'Childrens Books', '2025-03-10 15:25:12'),
(6, 'Health And Fitness', '2025-03-10 15:25:41'),
(7, 'Science', '2025-03-10 15:25:54'),
(8, 'Law', '2025-03-10 15:26:04'),
(9, 'Education', '2025-03-10 15:26:15');

-- --------------------------------------------------------

--
-- Table structure for table `issuedbook`
--

CREATE TABLE `issuedbook` (
  `id` int(11) NOT NULL,
  `BookId` int(11) NOT NULL,
  `roll_no` varchar(150) NOT NULL,
  `IssuesDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `ReturnDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `RetrunStatus` int(1) NOT NULL DEFAULT 0,
  `fine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `issuedbook`
--

INSERT INTO `issuedbook` (`id`, `BookId`, `roll_no`, `IssuesDate`, `ReturnDate`, `RetrunStatus`, `fine`) VALUES
(1, 1, '46', '2025-03-10 10:09:00', NULL, 0, 0),
(2, 2, '46', '2025-03-10 10:09:43', NULL, 0, 0),
(3, 3, '5', '2025-03-10 10:10:39', '2025-03-10 10:11:10', 1, 0),
(4, 3, '5', '2025-03-10 10:11:40', '2025-03-10 10:14:32', 1, 10),
(5, 3, '69', '2025-03-10 10:14:43', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `roll_no` int(10) NOT NULL,
  `f_name` varchar(50) NOT NULL,
  `email_id` varchar(30) NOT NULL,
  `m_no` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `field` varchar(50) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp(),
  `img` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`roll_no`, `f_name`, `email_id`, `m_no`, `password`, `gender`, `field`, `reg_date`, `img`) VALUES
(5, 'AMIT PARMAR', 'amit@gmail.com', '1234567898', 'AMIT123', 'Male', 'BCA', '2025-01-20 14:10:03', 'img/AMIT.jpg'),
(14, 'avinash', 'avi@gmail.com', '9316361979', 'AVINASH', 'Male', 'BCA', '2025-01-18 11:58:39', 'img/avinash.jpg'),
(27, 'DEV', 'dev@gmail.com', '7777889944', 'DEV123', 'Male', 'BCA', '2025-01-18 11:47:49', 'img/DEV.jpg'),
(46, 'HET', 'het@gmail.com', '4564561231', 'HET123', 'Male', 'BCA', '2025-01-18 11:59:45', 'img/het.jpg'),
(69, 'KISHAN', 'kishan@gmail.com', '4545454545', 'KISHAN', 'Male', 'BCA', '2025-01-18 10:43:01', 'img/KISHAN.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addbooks`
--
ALTER TABLE `addbooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `issuedbook`
--
ALTER TABLE `issuedbook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`roll_no`),
  ADD UNIQUE KEY `email_id` (`email_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addbooks`
--
ALTER TABLE `addbooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `aid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `issuedbook`
--
ALTER TABLE `issuedbook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
