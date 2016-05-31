-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2016 at 11:51 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `travelhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `boarding_vehicle`
--

CREATE TABLE IF NOT EXISTS `boarding_vehicle` (
`id` int(11) NOT NULL,
  `booked_vehicle_id` int(11) NOT NULL DEFAULT '0',
  `trip_id` mediumint(9) NOT NULL,
  `park_map_id` int(11) NOT NULL,
  `vehicle_type_id` smallint(6) NOT NULL,
  `booked_seats` varchar(80) NOT NULL,
  `departure_order` tinyint(2) NOT NULL,
  `fare` decimal(7,2) NOT NULL,
  `seat_status` enum('Not full','Full') NOT NULL DEFAULT 'Not full',
  `travel_date` date NOT NULL,
  `travel_id` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `boarding_vehicle`
--

INSERT INTO `boarding_vehicle` (`id`, `booked_vehicle_id`, `trip_id`, `park_map_id`, `vehicle_type_id`, `booked_seats`, `departure_order`, `fare`, `seat_status`, `travel_date`, `travel_id`) VALUES
(1, 0, 11, 7, 3, '2,4,3,1,5,6', 1, '4000.00', 'Not full', '2016-05-30', 6);

-- --------------------------------------------------------

--
-- Table structure for table `booked_vehicles`
--

CREATE TABLE IF NOT EXISTS `booked_vehicles` (
`id` int(11) NOT NULL,
  `vehicle_no` varchar(15) NOT NULL,
  `vehicle_type_id` mediumint(1) NOT NULL,
  `departure_order` tinyint(2) NOT NULL,
  `park_map_id` mediumint(9) NOT NULL,
  `route_id` mediumint(9) NOT NULL,
  `travel_date` date NOT NULL,
  `travel_id` mediumint(9) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booked_vehicles`
--

INSERT INTO `booked_vehicles` (`id`, `vehicle_no`, `vehicle_type_id`, `departure_order`, `park_map_id`, `route_id`, `travel_date`, `travel_id`) VALUES
(1, 'SRT 958', 1, 1, 7, 0, '2016-02-23', 4),
(2, 'Xl 435 GL', 1, 2, 7, 0, '2016-02-23', 4),
(4, 'TY 741', 3, 1, 7, 0, '2016-02-26', 4);

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE IF NOT EXISTS `booking_details` (
`id` int(11) NOT NULL,
  `payment_status` varchar(15) NOT NULL DEFAULT 'Not paid',
  `channel` varchar(15) NOT NULL,
  `response` varchar(100) NOT NULL,
  `ticket_no` char(8) NOT NULL,
  `boarding_vehicle_id` int(11) NOT NULL,
  `seat_no` tinyint(2) NOT NULL,
  `park_id` smallint(6) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date_booked` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`id`, `payment_status`, `channel`, `response`, `ticket_no`, `boarding_vehicle_id`, `seat_no`, `park_id`, `customer_id`, `date_booked`, `user_id`, `status`) VALUES
(1, 'Not paid', 'offline', '', 'RLRTEBOH', 1, 2, 0, 17, '2016-05-28 01:40:02', 0, '1'),
(2, 'Not paid', 'offline', '', 'VVYCVVNG', 1, 4, 0, 20, '2016-05-28 01:43:59', 0, '1'),
(3, 'Not paid', 'offline', '', 'SXT64JZL', 1, 3, 0, 17, '2016-05-28 01:47:52', 0, '1'),
(4, 'Not paid', 'offline', '', 'WDNMW4ZD', 1, 1, 0, 17, '2016-05-28 01:48:34', 0, '1'),
(5, 'Not paid', 'offline', '', 'MIHSFBHD', 1, 5, 0, 17, '2016-05-28 01:49:17', 0, '1'),
(6, 'Not paid', 'offline', '', 'SC1RRREG', 1, 6, 0, 17, '2016-05-28 01:52:17', 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `bus_charter`
--

CREATE TABLE IF NOT EXISTS `bus_charter` (
`id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `departure_location` varchar(20) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `travel_date` datetime NOT NULL,
  `bus_type_id` tinyint(4) NOT NULL,
  `num_of_vehicles` tinyint(4) NOT NULL,
  `date_chartered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(9) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bus_charter`
--

INSERT INTO `bus_charter` (`id`, `name`, `phone`, `departure_location`, `destination`, `travel_date`, `bus_type_id`, `num_of_vehicles`, `date_chartered`, `status`) VALUES
(1, 'Chibuzo', '08035725606', 'Maryland', 'Enugu', '2015-04-04 00:00:00', 2, 1, '2015-03-21 03:55:03', 'Pending'),
(2, 'George', '0803583434', 'Iyana Paja', 'Orlu', '2015-03-30 00:00:00', 3, 2, '2015-03-22 12:23:57', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
`id` int(11) NOT NULL,
  `c_name` varchar(40) NOT NULL,
  `phone_no` varchar(12) NOT NULL,
  `next_of_kin_phone` varchar(12) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `c_name`, `phone_no`, `next_of_kin_phone`) VALUES
(1, 'Kingsley ekeh', '080648594887', '89485948594'),
(2, 'Chioma', '080378348309', '405039530943'),
(3, 'Eneh', '787989811111', '0358395389'),
(4, 'Obinna', '000', '9845'),
(5, 'Chibuzo', '03593350', '905358308111'),
(6, 'Elvis', '89385046805', '080865473675'),
(7, 'Amaka', '85395839', '968596853333'),
(8, 'Eneh', '7879898', '0358395389'),
(9, 'Obinna', '93859339', '984574759'),
(10, 'Chibuzo', '0359335000', '905358308111'),
(11, 'Kelvin', '989787867', '080897878'),
(12, 'Amaka', '85395839', '96859685'),
(13, 'Frank', '787878', '746847'),
(14, 'elvina', '04830', '305390358'),
(15, 'Ken', '8539438', '93539589'),
(16, 'Kester', '0485048540', '038535808'),
(17, 'Jide', '08035725606', '08035725606'),
(18, 'Okolo', '09689484', '085359308'),
(19, 'uzo', '845808977', '8798987987'),
(20, 'Trother', '080555555667', '080555555667');

-- --------------------------------------------------------

--
-- Table structure for table `departure_time`
--

CREATE TABLE IF NOT EXISTS `departure_time` (
`id` int(11) NOT NULL,
  `route_id` mediumint(9) NOT NULL,
  `travel_id` mediumint(9) NOT NULL,
  `travel_vehicle_type_id` int(11) NOT NULL,
  `departure_order` tinyint(4) NOT NULL,
  `departure_time` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fares`
--

CREATE TABLE IF NOT EXISTS `fares` (
`id` int(11) NOT NULL,
  `travel_id` tinyint(4) NOT NULL,
  `vehicle_type_id` tinyint(4) NOT NULL,
  `fare` varchar(5) NOT NULL,
  `park_map_id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fares`
--

INSERT INTO `fares` (`id`, `travel_id`, `vehicle_type_id`, `fare`, `park_map_id`, `route_id`, `last_modified`, `date_added`) VALUES
(16, 4, 1, '3500', 1, 14, '2015-11-20 15:47:52', '2015-11-20 15:47:52'),
(17, 4, 3, '4000', 1, 14, '2015-11-20 15:47:52', '2015-11-20 15:47:52'),
(18, 4, 4, '3000', 1, 14, '2015-11-20 15:47:52', '2015-11-20 15:47:52'),
(19, 4, 1, '5200', 3, 14, '2015-11-20 15:48:21', '2015-11-20 15:48:21'),
(20, 4, 3, '9000', 3, 14, '2015-11-20 15:48:21', '2015-11-20 15:48:21'),
(21, 4, 4, '3400', 3, 14, '2015-11-20 15:48:21', '2015-11-20 15:48:21'),
(22, 4, 1, '', 5, 29, '2015-11-20 15:59:03', '2015-11-20 15:59:03'),
(23, 4, 3, '10700', 5, 29, '2015-11-20 15:59:03', '2015-11-20 15:59:03'),
(24, 4, 4, '', 5, 29, '2015-11-20 15:59:03', '2015-11-20 15:59:03');

-- --------------------------------------------------------

--
-- Table structure for table `manifest_audit`
--

CREATE TABLE IF NOT EXISTS `manifest_audit` (
`id` int(11) NOT NULL,
  `boarding_vehicle_id` int(11) NOT NULL,
  `load_cost` int(11) NOT NULL DEFAULT '0',
  `drivers_expenses` int(11) NOT NULL DEFAULT '0',
  `travel_id` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manifest_audit`
--

INSERT INTO `manifest_audit` (`id`, `boarding_vehicle_id`, `load_cost`, `drivers_expenses`, `travel_id`) VALUES
(2, 19, 0, 5500, 0),
(3, 20, 2000, 5000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `manifest_serial_no`
--

CREATE TABLE IF NOT EXISTS `manifest_serial_no` (
`id` int(11) NOT NULL,
  `booked_vehicle_id` int(11) NOT NULL,
  `serial_no` char(6) NOT NULL,
  `travel_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `online_booking`
--

CREATE TABLE IF NOT EXISTS `online_booking` (
`id` int(11) NOT NULL,
  `route` varchar(30) NOT NULL,
  `payment_opt` varchar(16) NOT NULL,
  `payment_status` varchar(20) NOT NULL,
  `response` varchar(225) NOT NULL,
  `amount` varchar(6) NOT NULL,
  `grace_duration` time NOT NULL COMMENT 'Duration of time for which the booking remains valid',
  `delivery_addr` tinytext NOT NULL,
  `booking_details_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `ticket_no` char(8) NOT NULL,
  `travel_date` date NOT NULL,
  `date_booked` date NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `online_booking`
--

INSERT INTO `online_booking` (`id`, `route`, `payment_opt`, `payment_status`, `response`, `amount`, `grace_duration`, `delivery_addr`, `booking_details_id`, `email`, `ticket_no`, `travel_date`, `date_booked`, `time_stamp`) VALUES
(1, 'Lagos to Abuja', 'offline', '', '', '', '00:00:00', '', 808, 'uzo.systems@gmail.com', 'RFWL6ZYN', '2013-11-30', '2013-11-29', '2013-11-29 13:05:24'),
(2, 'Lagos to Onitsha', 'online', '', '', '', '00:00:00', '', 809, 'tina42006@yahoo.com', 'X1GTJFPN', '2013-12-19', '2013-11-29', '2013-11-29 14:30:18'),
(3, 'Lagos to Onitsha', 'offline', '', '', '', '00:00:00', '', 810, 'tina42006@yahoo.com', '96HVVHVE', '2013-12-19', '2013-11-29', '2013-11-29 14:30:52'),
(4, 'Lagos to Abuja', 'offline', '', '', '', '00:00:00', '', 811, 'tofunmi.og@gmail.com', 'EYOVAEYT', '2013-11-30', '2013-11-29', '2013-11-29 14:33:46'),
(5, 'Lagos to Abuja', 'online', '', '', '', '00:00:00', '', 812, 'tofunmi.og@gmail.com', 'BGZINCSM', '2013-11-30', '2013-11-29', '2013-11-29 14:35:10'),
(6, 'Lagos to Abuja', 'online', '', '', '', '00:00:00', '', 813, 'tofunmi.og@gmail.com', 'PMRKBFNH', '2013-12-02', '2013-11-29', '2013-11-29 14:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `parks`
--

CREATE TABLE IF NOT EXISTS `parks` (
`id` int(11) NOT NULL,
  `state_id` tinyint(4) NOT NULL,
  `park` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parks`
--

INSERT INTO `parks` (`id`, `state_id`, `park`) VALUES
(1, 25, 'Jibowu'),
(2, 25, 'Maza maza'),
(3, 25, 'Orile'),
(4, 25, 'Oshodi-Charity'),
(5, 25, 'Ojuelegba'),
(6, 25, 'Ikotun'),
(7, 25, 'Berger'),
(8, 25, 'Cele'),
(9, 25, 'Oshodi-Bolade'),
(10, 1, 'Iba'),
(11, 25, 'Iyana Ipaja'),
(12, 1, 'Volks'),
(13, 25, 'Yaba'),
(14, 25, 'Ajah'),
(15, 25, 'Festac Gate'),
(16, 3, 'Holy ghost'),
(17, 3, 'Nsukka'),
(18, 25, 'Maryland'),
(19, 25, 'Ikeja'),
(21, 3, 'Old Park'),
(24, 3, 'Amokwe'),
(25, 1, 'Berger'),
(26, 13, 'Afikpo'),
(27, 20, 'Kano II');

-- --------------------------------------------------------

--
-- Table structure for table `park_map`
--

CREATE TABLE IF NOT EXISTS `park_map` (
`id` int(11) NOT NULL,
  `origin` varchar(30) NOT NULL,
  `destination` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `park_map`
--

INSERT INTO `park_map` (`id`, `origin`, `destination`, `status`) VALUES
(1, '1', '16', 1),
(2, '1', '17', 1),
(3, '14', '17', 1),
(4, '14', '16', 1),
(5, '14', '12', 1),
(6, '2', '16', 1),
(7, '16', '1', 1),
(8, '16', '2', 1),
(9, '16', '12', 1),
(10, '16', '25', 1),
(11, '17', '12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
`id` int(11) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `report_date` date NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `filename`, `report_date`, `date_added`) VALUES
(2, '/home/autostar/public_html/reports/Daily-report-for-27-Jul-2015.xlsx', '2015-07-27', '2015-08-09 11:25:28');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE IF NOT EXISTS `routes` (
`id` int(11) NOT NULL,
  `origin` varchar(30) NOT NULL,
  `destination` varchar(30) NOT NULL,
  `route` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `origin`, `destination`, `route`, `status`) VALUES
(1, '3', '25', 'Enugu - Lagos', 1),
(26, '3', '1', 'Enugu - Abuja', 1),
(14, '25', '3', 'Lagos - Enugu', 1),
(29, '25', '1', 'Lagos - Abuja', 1),
(31, '25', '33', 'Lagos - Rivers', 1),
(32, '25', '12', 'Lagos - Delta', 0),
(57, '1', '3', 'Abuja - Enugu', 1),
(56, '12', '1', 'Delta - Abuja', 1),
(55, '1', '25', 'Abuja - Lagos', 1),
(54, '12', '25', 'Delta - Lagos', 1),
(53, '33', '1', 'Rivers - Abuja', 0),
(52, '33', '25', 'Rivers - Lagos', 1),
(59, '6', '18', 'Abia - Jigawa', 0),
(63, '1', '26', 'Abuja - Nasarawa', 0),
(62, '16', '37', 'Gombe - Zamfara', 1);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
`id` tinyint(2) NOT NULL,
  `state_name` varchar(15) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `state_name`) VALUES
(1, 'Abuja'),
(2, 'Anambra'),
(3, 'Enugu'),
(4, 'Akwa Ibom'),
(5, 'Adamawa'),
(6, 'Abia'),
(7, 'Bauchi'),
(8, 'Bayelsa'),
(9, 'Benue'),
(10, 'Borno'),
(11, 'Cross River'),
(12, 'Delta'),
(13, 'Ebonyi'),
(14, 'Edo'),
(15, 'Ekiti'),
(16, 'Gombe'),
(17, 'Imo'),
(18, 'Jigawa'),
(19, 'Kaduna'),
(20, 'Kano'),
(21, 'Katsina'),
(22, 'Kebbi'),
(23, 'Kogi'),
(24, 'Kwara'),
(25, 'Lagos'),
(26, 'Nasarawa'),
(27, 'Niger'),
(28, 'Ogun'),
(29, 'Ondo'),
(30, 'Osun'),
(31, 'Oyo'),
(32, 'Plateau'),
(33, 'Rivers'),
(34, 'Sokoto'),
(35, 'Taraba'),
(36, 'Yobe'),
(37, 'Zamfara');

-- --------------------------------------------------------

--
-- Table structure for table `states_towns`
--

CREATE TABLE IF NOT EXISTS `states_towns` (
`id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states_towns`
--

INSERT INTO `states_towns` (`id`, `name`, `time_added`) VALUES
(1, 'Lagos', '2010-12-03 08:45:43'),
(2, 'Enugu', '2010-12-03 08:45:51'),
(39, 'Benin', '2013-08-12 13:04:59'),
(15, 'Abakaliki', '2013-06-01 20:29:22'),
(16, 'Aba', '2012-08-18 12:08:14'),
(17, 'Owerri', '2012-08-18 12:08:14'),
(18, 'Onitsha', '2012-08-18 12:08:14'),
(19, 'Abuja', '2012-08-18 12:08:14'),
(20, 'Port Hacourt', '2013-06-02 04:28:11'),
(21, 'Nsukka', '2012-08-18 12:08:14'),
(42, 'Uyo', '2013-11-24 23:35:17'),
(41, 'Kogi', '2013-11-24 23:34:48'),
(4, 'Bayelsa', '2013-08-18 12:00:38'),
(40, 'Calabar', '2013-11-24 23:34:48'),
(26, 'Kaduna', '2012-10-21 21:52:42'),
(37, 'Umuahia', '2013-08-06 20:51:12'),
(31, 'Enugu-Ezike', '2013-06-01 20:30:08'),
(33, 'Asaba', '2012-12-02 15:40:55'),
(3, 'Warri', '2013-08-18 12:00:38'),
(43, 'Jos', '2013-11-24 23:35:17'),
(44, 'Ibadan', '2013-11-25 00:15:22'),
(45, 'Abia', '2014-02-20 10:57:47'),
(46, 'Akwa Ibom', '2014-02-20 10:57:47'),
(47, 'Cross River', '2014-02-20 11:00:09'),
(48, 'Ebony', '2014-02-20 11:00:09'),
(49, 'Delta', '2014-02-20 11:00:09'),
(50, 'Imo', '2014-02-20 11:00:09'),
(51, 'Benue', '2014-02-20 11:00:09'),
(52, 'Niger', '2014-02-20 11:00:37'),
(53, 'Osun', '2014-02-20 11:00:37'),
(54, 'Edo', '2014-02-20 11:01:06'),
(55, 'Anambra', '2014-02-20 11:23:36');

-- --------------------------------------------------------

--
-- Table structure for table `travels`
--

CREATE TABLE IF NOT EXISTS `travels` (
`id` tinyint(3) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `abbr` varchar(20) NOT NULL,
  `offline_charge` varchar(6) NOT NULL,
  `online_charge` varchar(6) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travels`
--

INSERT INTO `travels` (`id`, `company_name`, `abbr`, `offline_charge`, `online_charge`, `date_created`, `deleted`) VALUES
(4, 'Ekene', '', '8', '11', '2015-10-30 04:33:01', 0),
(5, 'Ifesinachi Mass Transit', 'Ifesinachi', '5', '10', '2015-11-01 23:08:48', 0),
(6, 'Peace Mass Transit', 'Peace', '2', '5', '2016-05-20 19:35:53', 0);

-- --------------------------------------------------------

--
-- Table structure for table `travel_admins`
--

CREATE TABLE IF NOT EXISTS `travel_admins` (
`id` int(11) NOT NULL,
  `travel_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_admins`
--

INSERT INTO `travel_admins` (`id`, `travel_id`, `user_id`) VALUES
(1, 4, 6),
(2, 4, 7),
(3, 4, 8),
(6, 4, 12),
(13, 4, 19),
(17, 4, 24),
(18, 4, 25),
(19, 4, 26),
(20, 5, 27),
(21, 5, 28),
(22, 4, 29),
(23, 4, 30),
(24, 4, 31),
(25, 6, 32),
(26, 6, 33),
(27, 6, 34),
(28, 6, 35);

-- --------------------------------------------------------

--
-- Table structure for table `travel_park`
--

CREATE TABLE IF NOT EXISTS `travel_park` (
`id` int(11) NOT NULL,
  `travel_id` int(11) NOT NULL,
  `park_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_park`
--

INSERT INTO `travel_park` (`id`, `travel_id`, `park_id`, `user_id`) VALUES
(1, 4, 1, 24),
(2, 4, 14, 25),
(3, 4, 2, 26),
(4, 4, 16, 30),
(5, 4, 17, 31),
(6, 6, 16, 35);

-- --------------------------------------------------------

--
-- Table structure for table `travel_park_map`
--

CREATE TABLE IF NOT EXISTS `travel_park_map` (
`id` int(11) NOT NULL,
  `travel_id` smallint(6) NOT NULL,
  `park_map_id` smallint(6) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_park_map`
--

INSERT INTO `travel_park_map` (`id`, `travel_id`, `park_map_id`, `status`, `date_added`) VALUES
(1, 4, 1, 0, '2015-11-06 00:24:16'),
(2, 4, 2, 0, '2015-11-06 00:41:35'),
(3, 4, 3, 0, '2015-11-06 00:43:40'),
(4, 4, 4, 0, '2015-11-06 00:45:05'),
(5, 4, 5, 0, '2015-11-20 14:51:32'),
(6, 4, 6, 0, '2016-01-28 22:33:58'),
(7, 4, 7, 0, '2016-02-21 11:59:35'),
(10, 4, 10, 0, '2016-02-22 20:33:46'),
(11, 6, 7, 0, '2016-05-20 20:20:35'),
(12, 6, 10, 0, '2016-05-20 20:20:59');

-- --------------------------------------------------------

--
-- Table structure for table `travel_routes`
--

CREATE TABLE IF NOT EXISTS `travel_routes` (
`id` int(11) NOT NULL,
  `travel_id` smallint(6) NOT NULL,
  `route_id` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `travel_state`
--

CREATE TABLE IF NOT EXISTS `travel_state` (
`id` int(11) NOT NULL,
  `travel_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_state`
--

INSERT INTO `travel_state` (`id`, `travel_id`, `state_id`, `user_id`) VALUES
(4, 4, 16, 12),
(11, 4, 25, 19),
(12, 5, 20, 28),
(13, 4, 3, 29),
(14, 6, 3, 33),
(15, 6, 25, 34);

-- --------------------------------------------------------

--
-- Table structure for table `travel_vehicle_types`
--

CREATE TABLE IF NOT EXISTS `travel_vehicle_types` (
`id` int(11) NOT NULL,
  `travel_id` int(11) NOT NULL,
  `vehicle_name` varchar(20) NOT NULL,
  `vehicle_type_id` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 for active, 1 for inactive',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_vehicle_types`
--

INSERT INTO `travel_vehicle_types` (`id`, `travel_id`, `vehicle_name`, `vehicle_type_id`, `status`, `date_modified`, `date_added`) VALUES
(1, 4, 'Coach', 4, 0, '2015-11-15 13:17:41', '2015-11-15 13:13:14'),
(3, 4, 'Executive', 1, 0, '2015-11-15 13:30:18', '2015-11-15 13:30:18'),
(4, 4, 'Luxury Bus', 5, 0, '2015-11-15 13:30:57', '2015-11-15 13:30:57'),
(5, 6, 'Hiace', 3, 0, '2016-05-20 20:24:26', '2016-05-20 20:24:26'),
(6, 6, 'Foton', 8, 0, '2016-05-20 20:24:44', '2016-05-20 20:24:44');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE IF NOT EXISTS `trips` (
`id` int(11) NOT NULL,
  `park_map_id` int(11) NOT NULL,
  `travel_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `departure` tinyint(2) NOT NULL,
  `route_id` int(11) NOT NULL,
  `vehicle_type_id` int(11) NOT NULL,
  `amenities` varchar(255) NOT NULL,
  `departure_time` time NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `fare` float(6,0) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `park_map_id`, `travel_id`, `state_id`, `departure`, `route_id`, `vehicle_type_id`, `amenities`, `departure_time`, `date_added`, `date_updated`, `fare`) VALUES
(1, 1, 4, 25, 3, 14, 1, 'A/C>TV>Refreshment', '06:30:00', '2016-01-09 20:09:31', '2016-02-09 03:21:57', 4000),
(2, 2, 4, 25, 1, 14, 1, 'Food>TV>Refreshment', '06:30:00', '2016-01-09 22:46:50', '2016-02-09 03:21:50', 5000),
(3, 4, 4, 25, 1, 14, 3, 'A/C>Food>Restrooms', '06:30:00', '2016-01-10 00:21:32', '2016-02-09 03:21:43', 3000),
(4, 3, 4, 25, 1, 14, 1, 'A/C>Restrooms', '06:30:00', '2016-01-10 00:28:43', '2016-02-05 23:51:48', 2500),
(5, 5, 4, 25, 3, 29, 1, 'A/C>Food>Refreshment', '06:30:00', '2016-02-05 21:43:09', '2016-02-05 21:56:04', 5000),
(6, 3, 4, 25, 2, 14, 1, 'A/C', '01:00:00', '2016-02-21 00:45:46', '2016-02-21 01:43:34', 2500),
(7, 7, 4, 3, 1, 1, 1, 'A/C>Refreshment', '12:45:00', '2016-02-21 12:00:29', '2016-02-21 12:06:16', 6000),
(8, 7, 4, 3, 2, 1, 3, 'A/C', '02:00:00', '2016-02-23 01:00:39', '0000-00-00 00:00:00', 6000),
(9, 7, 4, 3, 2, 1, 1, 'A/C', '02:00:00', '2016-02-23 01:01:04', '2016-02-23 01:01:30', 5500),
(10, 7, 6, 3, 1, 1, 5, 'A/C', '07:00:00', '2016-05-20 20:43:46', '0000-00-00 00:00:00', 4000),
(11, 7, 6, 3, 1, 1, 3, 'A/C', '07:15:00', '2016-05-20 21:18:34', '0000-00-00 00:00:00', 4000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` tinyint(4) NOT NULL,
  `fullname` varchar(70) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` char(64) NOT NULL,
  `salt` char(32) NOT NULL,
  `user_type` varchar(15) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` char(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `salt`, `user_type`, `date_created`, `deleted`) VALUES
(1, 'Chibuzo', 'chibuzo', '8185569fe5f5f34bd48bcdf3155f570297b96928d443ebec7d3c1626536fc318', 'vFF+q6x+1ceEWmVvhlCgELhzhPJqc0pC', 'admin', '2015-01-09 12:25:49', '0'),
(2, 'Njideka Onu', 'onu', '82cc406d16a8f3011f3921939fce857a86503f3a866df9e2a5758cc9701dc2c4', 'nJlZfWOzxdBRPCC5LxnBzv6FYK2QnogC', 'Operator', '2015-01-09 12:43:13', '1'),
(3, 'Okpeke Admin', 'okpo', 'dfa8617b02c9d168c793c64528521f8f6ac3120492541e5407f7acc2870c20cb', '2q2SKQMAAq3VdZqbK+NOKQu56RDCcWl/', 'user', '2015-09-15 14:43:23', '1'),
(4, 'amaka', 'amaka', '6ab0034f44a8f3fc92c2c9259133bfec8d581037cd36db30fc72bcb3d1bed9f6', 'X5AWxXtEqactoQH+DrjSuBfk4tZRyZZR', 'account', '2015-03-06 17:57:15', '0'),
(5, 'Administrator', 'admin', '34d9b4b876b7bda4e21a078ec6ddaa8f6379e4bde47009db722c82466988cdd1', 'izL6onBroshZLfM85Vrb1ZqEH+BuIRGi', 'user', '2015-03-27 12:00:46', '0'),
(6, 'Iroegbu Iroegbu', 'iroegbu', '648fbd2a1cc291edb8a1f7fee439d4fd63e6d470335ecce975ae0440cfb6f8a8', 'SLQbO/M3AgXsP80g4w/LQqEpG5fQ8O5w', 'travel_admin', '2015-10-31 16:18:50', '0'),
(7, 'Pelumi', 'pelu', '6ba0345fa0dfb195e0be52dfb0d2ead435c1f0a4d0b369e70c42daf13a9507e9', 'mEpDVw91QNhMkITN78Ge6RDQ7DR7ilQp', 'travel_admin', '2015-10-31 16:37:06', '0'),
(8, 'Chioma Amobi', 'chioma', 'a9b406e042798333f05e9856f8007eed7fe6ee62e390fc650121dbf6e8c3e5c7', 'lBBIrp9cvP4c/KcCqyh4mOP8V7WcUBez', 'travel_admin', '2015-10-31 16:43:13', '0'),
(12, 'Full Aproko', 'aproko', '8af34d1d0c4f28cb65dc0b9d63a2b42c1a452339c0e763f42b83d313c07de022', 'BbUHCpEa0v3zdt/P/iFGjDvmpmRQjVsi', 'state_admin', '2015-11-22 09:28:28', '0'),
(24, 'Okolo Uzo', 'okoloc', 'f44c0263ddf60765eeeed2b26152d02562ace000f8727c1f177a8f8d21df0d14', '8tE5BGSybCMOezCmDVdGA78lcgtWq+0C', 'park_admin', '2015-11-03 00:15:11', '0'),
(19, 'Adesuwa Okpefa', 'okpefa', 'af36c1cff6d5eec594d9071f10022513539416e656cde383922c87dcad43e1a0', '5kCa9idNn9VKN/9TzNrdUoMxgI0LCquL', 'state_admin', '2015-11-02 21:45:47', '0'),
(25, 'Augustine Ogwo', 'ogwo', '9e685dad18b5d9da472d85a4b9611105ae8c580f1ba88177a9940f7a26268ff8', 'oYn9dLq7X0w3pckhFU3E2gr8Nj3Tu5ct', 'park_admin', '2015-11-03 00:17:19', '0'),
(26, 'Chike Mgbemena', 'chike', '76db376ca24afc11fd3d8a336917fada8d0d58fcb87a892b7a6d7ec9cf13d24f', 'Tn+vJ9gSH/bRaocs2ISsVgfCb1huczj3', 'user', '2015-11-18 23:13:12', '0'),
(27, 'okon', 'okon', 'f402c127d61caea3bf41c4c3b0186d9fc2e6c24e031484dfb8a7212446eb337f', 'bywti1DmsnnrLRZTFpPG1t3Wq+4T77dA', 'travel_admin', '2016-01-28 19:10:13', '0'),
(28, 'Kano Admin', 'kano', '34ee91c74a47a7b683c659229706699d42fb97bc4b184515b17ca62881760004', 'R2jV1gxEX6f60z+FaF3SBpsN081ZPt1R', 'state_admin', '2016-01-28 19:24:22', '0'),
(29, 'Chibuzo Okolo', 'buzo', '7db807d9c3361a22e8e353ccf39906d467724bd76548499b8135b933d88226b3', 'FbFTf7p9IFg36kP6Qpyt0cXH56kx2zlt', 'state_admin', '2016-02-21 11:44:09', '0'),
(30, 'Chris Ossai', 'chris', '37d95369d4ba4ee3dfff6b9cbb4266da958efa8604cc174c73863ede1965b853', 'zHeQ1Y0zwpyHoxdO7LE7MyDmF4OIC6xE', 'park_admin', '2016-02-21 11:59:15', '0'),
(31, 'Oliver Ossai', 'bekee', '562bc813edcbce4aae12f936c31f9bf251ef3600be9ea17c63f3791a9a693400', '2RSToOqvxuEsd+net8y1FrhdFM7qTZvX', 'park_admin', '2016-02-22 20:34:25', '0'),
(32, 'chibike', 'chibike', '7273daa4fd761ccc996c0f7b811fdbee28600892431c484481a39461ad16e30f', 'JlZRMO4vHj0KaMPA2Zf9OoMMwa+gJPA2', 'travel_admin', '2016-05-20 20:09:13', '0'),
(33, 'Chibuzo Okolo', 'peace_enugu', 'd748618ddee1ea60072e491ef8eb9c50b0b65597e4cb077d54ddfdae72d9ed80', 'f1r7dAdyy2RG7T+C9W8zD5svhWfGXBHP', 'state_admin', '2016-05-20 20:17:24', '0'),
(34, 'Ossai Emeka', 'ossai', 'cbf635fee76cde847f9d91fbd2216c3644507b226f513f1fa841ffc13fdcbeb7', 'hFtsio6QERahU/S4UHM8HG9i9CG9jQab', 'state_admin', '2016-05-20 20:18:41', '0'),
(35, 'Peace Holyghost', 'peace_holyghost', '73415eaa99847c4ed4afef60ea6b670e1cff4ee0a1cb075e8cb7443700cb08dc', 'VB3c+uxRNKNOLXw0kRoxweIVpHyuMwVN', 'park_admin', '2016-05-20 20:20:03', '0');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_info`
--

CREATE TABLE IF NOT EXISTS `vehicle_info` (
`id` int(11) NOT NULL,
  `vehicle_no` varchar(15) NOT NULL,
  `driver_name` varchar(40) NOT NULL,
  `drivers_phone` char(11) NOT NULL,
  `vehicle_type_id` mediumint(9) NOT NULL,
  `travel_id` mediumint(9) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = active, 0 = inactive'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_info`
--

INSERT INTO `vehicle_info` (`id`, `vehicle_no`, `driver_name`, `drivers_phone`, `vehicle_type_id`, `travel_id`, `status`) VALUES
(1, 'SRT 958', 'Tachiii', '08083683743', 1, 4, 1),
(2, 'Xl 435 GL', 'Elvis', '08086843489', 1, 4, 1),
(3, 'ABC 463', 'Kelvin Ama', '08475847843', 1, 4, 1),
(4, 'TY 741', 'Lenard', '08057845632', 3, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_types`
--

CREATE TABLE IF NOT EXISTS `vehicle_types` (
`id` smallint(6) NOT NULL,
  `name` varchar(50) NOT NULL,
  `num_of_seats` tinyint(2) NOT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_types`
--

INSERT INTO `vehicle_types` (`id`, `name`, `num_of_seats`, `removed`) VALUES
(1, 'Regular Sienna', 5, 0),
(2, 'Car', 3, 1),
(3, 'Toyota Bus', 10, 0),
(4, 'Coaster Bus', 19, 0),
(5, 'Luxury Bus', 75, 0),
(6, 'gos', 7, 1),
(7, 'Executive Sienna', 5, 0),
(8, 'Hiace', 16, 0),
(9, 'Hummer', 6, 1),
(12, 'Another Motor', 18, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boarding_vehicle`
--
ALTER TABLE `boarding_vehicle`
 ADD PRIMARY KEY (`id`), ADD KEY `park_map_id` (`park_map_id`,`vehicle_type_id`), ADD KEY `travel_id` (`travel_id`), ADD KEY `booked_vehicle_id` (`booked_vehicle_id`);

--
-- Indexes for table `booked_vehicles`
--
ALTER TABLE `booked_vehicles`
 ADD PRIMARY KEY (`id`), ADD KEY `bus_info_id` (`vehicle_no`), ADD KEY `park_map_id` (`park_map_id`), ADD KEY `travel_id` (`travel_id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
 ADD PRIMARY KEY (`id`), ADD KEY `ticket_no` (`ticket_no`) USING BTREE, ADD KEY `park_id` (`park_id`), ADD KEY `boarding_vehicle_id` (`boarding_vehicle_id`);

--
-- Indexes for table `bus_charter`
--
ALTER TABLE `bus_charter`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
 ADD PRIMARY KEY (`id`), ADD KEY `next_of_kin_phone` (`next_of_kin_phone`);

--
-- Indexes for table `departure_time`
--
ALTER TABLE `departure_time`
 ADD PRIMARY KEY (`id`), ADD KEY `travel_id` (`travel_id`) USING BTREE, ADD KEY `route_code` (`route_id`) USING BTREE, ADD KEY `travel_vehicle_type_id` (`travel_vehicle_type_id`) USING BTREE;

--
-- Indexes for table `fares`
--
ALTER TABLE `fares`
 ADD PRIMARY KEY (`id`), ADD KEY `travel_id` (`travel_id`) USING BTREE;

--
-- Indexes for table `manifest_audit`
--
ALTER TABLE `manifest_audit`
 ADD PRIMARY KEY (`id`), ADD KEY `travel_id` (`travel_id`), ADD KEY `booked_vehicle_id` (`boarding_vehicle_id`);

--
-- Indexes for table `manifest_serial_no`
--
ALTER TABLE `manifest_serial_no`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `seria_no` (`serial_no`), ADD KEY `booked_id` (`booked_vehicle_id`);

--
-- Indexes for table `online_booking`
--
ALTER TABLE `online_booking`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `booking_details_id` (`booking_details_id`) USING BTREE, ADD UNIQUE KEY `ticket_no` (`ticket_no`) USING BTREE, ADD KEY `payment_opt` (`payment_opt`,`payment_status`) USING BTREE, ADD KEY `travel_date` (`travel_date`) USING BTREE, ADD KEY `time_stamp` (`time_stamp`) USING BTREE;

--
-- Indexes for table `parks`
--
ALTER TABLE `parks`
 ADD PRIMARY KEY (`id`), ADD KEY `travel_id` (`state_id`) USING BTREE;

--
-- Indexes for table `park_map`
--
ALTER TABLE `park_map`
 ADD PRIMARY KEY (`id`), ADD KEY `origin` (`origin`) USING BTREE, ADD KEY `destination` (`destination`) USING BTREE;

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `filename` (`filename`) USING BTREE;

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
 ADD PRIMARY KEY (`id`), ADD KEY `origin` (`origin`) USING BTREE, ADD KEY `destination` (`destination`) USING BTREE, ADD FULLTEXT KEY `route` (`route`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states_towns`
--
ALTER TABLE `states_towns`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`) USING BTREE;

--
-- Indexes for table `travels`
--
ALTER TABLE `travels`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `company_name` (`company_name`) USING BTREE;

--
-- Indexes for table `travel_admins`
--
ALTER TABLE `travel_admins`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `travel_park`
--
ALTER TABLE `travel_park`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `travel_id` (`travel_id`,`park_id`);

--
-- Indexes for table `travel_park_map`
--
ALTER TABLE `travel_park_map`
 ADD PRIMARY KEY (`id`), ADD KEY `travel_id` (`travel_id`) USING BTREE;

--
-- Indexes for table `travel_routes`
--
ALTER TABLE `travel_routes`
 ADD PRIMARY KEY (`id`), ADD KEY `travel_id` (`travel_id`) USING BTREE;

--
-- Indexes for table `travel_state`
--
ALTER TABLE `travel_state`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `travel_id` (`travel_id`,`state_id`);

--
-- Indexes for table `travel_vehicle_types`
--
ALTER TABLE `travel_vehicle_types`
 ADD PRIMARY KEY (`id`), ADD KEY `travel_id` (`travel_id`) USING BTREE;

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_info`
--
ALTER TABLE `vehicle_info`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `bus_no` (`vehicle_no`), ADD KEY `travel_id` (`travel_id`);

--
-- Indexes for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boarding_vehicle`
--
ALTER TABLE `boarding_vehicle`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `booked_vehicles`
--
ALTER TABLE `booked_vehicles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `bus_charter`
--
ALTER TABLE `bus_charter`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `departure_time`
--
ALTER TABLE `departure_time`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fares`
--
ALTER TABLE `fares`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `manifest_audit`
--
ALTER TABLE `manifest_audit`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `manifest_serial_no`
--
ALTER TABLE `manifest_serial_no`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `online_booking`
--
ALTER TABLE `online_booking`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `parks`
--
ALTER TABLE `parks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `park_map`
--
ALTER TABLE `park_map`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `states_towns`
--
ALTER TABLE `states_towns`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `travels`
--
ALTER TABLE `travels`
MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `travel_admins`
--
ALTER TABLE `travel_admins`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `travel_park`
--
ALTER TABLE `travel_park`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `travel_park_map`
--
ALTER TABLE `travel_park_map`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `travel_routes`
--
ALTER TABLE `travel_routes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `travel_state`
--
ALTER TABLE `travel_state`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `travel_vehicle_types`
--
ALTER TABLE `travel_vehicle_types`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `vehicle_info`
--
ALTER TABLE `vehicle_info`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
