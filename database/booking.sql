-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 29, 2020 at 06:48 PM
-- Server version: 8.0.21
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `CreateOrUpdateEmployee`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateOrUpdateEmployee` (IN `e_name` TEXT, IN `e_email` TEXT, OUT `employee` TEXT)  NO SQL
BEGIN

INSERT INTO employees (employee_name, employee_mail) 
			VALUES (e_name, e_email)
			ON DUPLICATE KEY UPDATE
			employee_name=e_name, employee_mail=e_email;
            
            
SELECT * FROM employees where employee_mail = e_email;
            
END$$

DROP PROCEDURE IF EXISTS `CreateOrUpdateEvents`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateOrUpdateEvents` (IN `event_id` INT, IN `event_name` VARCHAR(255), IN `event_date` DATE, IN `version` VARCHAR(20))  NO SQL
BEGIN

INSERT INTO events (event_id, event_name, event_date, version) 
			VALUES (event_id, event_name, event_date, version)
			ON DUPLICATE KEY UPDATE
			event_name= event_name, event_date= event_date, version= version; 
END$$

DROP PROCEDURE IF EXISTS `CreateParticipations`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateParticipations` (IN `id` INT, IN `employee_id` INT, IN `event_id` INT, IN `fee` DOUBLE)  NO SQL
BEGIN

INSERT INTO participation (participation_id, employee_id, event_id, participation_fee)
VALUES (id, employee_id, event_id, fee)
ON DUPLICATE KEY UPDATE participation_fee = fee , participation_id = id ;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `employee_id` int NOT NULL AUTO_INCREMENT,
  `employee_name` text NOT NULL,
  `employee_mail` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`employee_id`),
  UNIQUE KEY `uniqe_email` (`employee_mail`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_name`, `employee_mail`) VALUES
(1, 'Reto Fanzen', 'reto.fanzen@no-reply.rexx-systems.com'),
(2, 'Leandro Bußmann', 'leandro.bussmann@no-reply.rexx-systems.com'),
(3, 'Hans Schäfer', 'hans.schaefer@no-reply.rexx-systems.com'),
(4, 'Mia Wyss', 'mia.wyss@no-reply.rexx-systems.com');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int NOT NULL,
  `event_name` text NOT NULL,
  `event_date` date NOT NULL,
  `version` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_date`, `version`) VALUES
(1, 'PHP 7 crash course', '2019-09-04', ''),
(2, 'International PHP Conference', '2019-10-21', '1.1.3'),
(3, 'code.talks', '2019-10-24', '1.1.3');

-- --------------------------------------------------------

--
-- Table structure for table `participation`
--

DROP TABLE IF EXISTS `participation`;
CREATE TABLE IF NOT EXISTS `participation` (
  `participation_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `event_id` int NOT NULL,
  `participation_fee` double NOT NULL,
  UNIQUE KEY `unique_particiation` (`event_id`,`employee_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `participation`
--

INSERT INTO `participation` (`participation_id`, `employee_id`, `event_id`, `participation_fee`) VALUES
(1, 1, 1, 0),
(2, 1, 2, 1485.99),
(3, 2, 2, 657.5),
(4, 3, 1, 0),
(5, 4, 1, 0),
(6, 4, 2, 657.5),
(7, 1, 3, 474.81),
(8, 3, 3, 534.31);

-- --------------------------------------------------------

--
-- Stand-in structure for view `participation_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `participation_view`;
CREATE TABLE IF NOT EXISTS `participation_view` (
`employee_name` text
,`employee_mail` varchar(250)
,`event_name` text
,`event_date` date
,`version` varchar(25)
,`participation_fee` double
);

-- --------------------------------------------------------

--
-- Structure for view `participation_view`
--
DROP TABLE IF EXISTS `participation_view`;

DROP VIEW IF EXISTS `participation_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `participation_view`  AS  select `em`.`employee_name` AS `employee_name`,`em`.`employee_mail` AS `employee_mail`,`ev`.`event_name` AS `event_name`,`ev`.`event_date` AS `event_date`,`ev`.`version` AS `version`,`p`.`participation_fee` AS `participation_fee` from ((`participation` `p` join `employees` `em` on((`em`.`employee_id` = `p`.`employee_id`))) join `events` `ev` on((`ev`.`event_id` = `p`.`event_id`))) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
