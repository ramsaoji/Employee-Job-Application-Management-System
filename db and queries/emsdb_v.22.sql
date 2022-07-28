-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2022 at 04:54 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emsdb`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `all_report` (IN `from_date` DATE, IN `to_date` DATE)  BEGIN

SELECT 
e.emp_id AS Employee_Id,
e.fname AS Fname,
e.lname AS Lname,
e.email AS Email,
e.phone AS Phone,
e.emp_category_id AS Category_Id,
c.category_name AS Category_Name,
e.profile AS Profile,
e.expertise AS Expertise,
e.joining_date AS Joining_Date,
e.exp_year AS Experience_Year,
e.current_salary AS Current_Salary,
e.expected_salary AS Expected_Salary,
e.created_by AS Created_By,
e.created_date AS Created_Date,
e.file_name AS File_Path

FROM employee_details e INNER JOIN categories c 
ON e.emp_category_id = c.category_id
WHERE date_format(created_date, "%Y-%m-%d") BETWEEN from_date and to_date ORDER BY e.fname,e.lname;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `all_report_category` (IN `from_date` DATE, IN `to_date` DATE, IN `category_name` VARCHAR(50))  BEGIN

SELECT 
e.emp_id AS Employee_Id,
e.fname AS Fname,
e.lname AS Lname,
e.email AS Email,
e.phone AS Phone,
e.emp_category_id AS Category_Id,
c.category_name AS Category_Name,
e.profile AS Profile,
e.expertise AS Expertise,
e.joining_date AS Joining_Date,
e.exp_year AS Experience_Year,
e.current_salary AS Current_Salary,
e.expected_salary AS Expected_Salary,
e.created_by AS Created_By,
e.created_date AS Created_Date,
e.file_name AS File_Path

FROM employee_details e INNER JOIN categories c 
ON e.emp_category_id = c.category_id
WHERE date_format(created_date, "%Y-%m-%d") BETWEEN from_date and to_date AND c.category_name = category_name ORDER BY e.fname,e.lname;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(4) NOT NULL,
  `category_name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'QA Engineer'),
(2, 'Cloud'),
(3, 'Front End Dev'),
(4, 'Back End Dev');

-- --------------------------------------------------------

--
-- Table structure for table `employee_details`
--

CREATE TABLE `employee_details` (
  `emp_id` int(4) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` bigint(10) NOT NULL,
  `emp_category_id` int(4) NOT NULL,
  `profile` varchar(50) NOT NULL,
  `expertise` varchar(1000) NOT NULL,
  `joining_date` date NOT NULL,
  `exp_year` int(3) NOT NULL,
  `current_salary` int(10) NOT NULL,
  `expected_salary` int(10) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp(6) NULL DEFAULT current_timestamp(6),
  `updated_by` varchar(50) NOT NULL,
  `updated_date` timestamp(6) NULL DEFAULT NULL,
  `file_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `login_id` int(4) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `login_name` varchar(50) NOT NULL,
  `login_pass` varchar(50) NOT NULL,
  `role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `user_name`, `login_name`, `login_pass`, `role`) VALUES
(1, 'Super Admin', 'superadmin', '0f9b10b6098ccbe175077e3ca879bbb9', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `fk_category_id` (`emp_category_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`emp_category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
