-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2017 at 03:06 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `boarding_vehicle`
--

INSERT INTO `boarding_vehicle` (`id`, `booked_vehicle_id`, `trip_id`, `park_map_id`, `vehicle_type_id`, `booked_seats`, `departure_order`, `fare`, `seat_status`, `travel_date`, `travel_id`) VALUES
(1, 0, 11, 7, 3, '2,4,3,1,5,6', 1, '4000.00', 'Not full', '2016-05-30', 6),
(2, 0, 11, 7, 3, '5', 1, '4000.00', 'Not full', '2016-06-13', 6),
(3, 0, 7, 7, 1, '', 1, '6000.00', 'Not full', '2016-06-13', 4),
(4, 0, 9, 7, 1, '5,2', 2, '5500.00', 'Not full', '2016-06-13', 4),
(5, 0, 10, 7, 5, '', 1, '4000.00', 'Not full', '2016-06-13', 6),
(6, 0, 11, 7, 3, '8,1,7,3', 1, '4000.00', 'Not full', '2016-06-14', 6),
(7, 0, 11, 7, 3, '10', 1, '4000.00', 'Not full', '2016-06-15', 6),
(8, 0, 7, 7, 1, '', 1, '6000.00', 'Not full', '2016-06-19', 4),
(9, 0, 9, 7, 1, '', 2, '5500.00', 'Not full', '2016-06-19', 4),
(10, 0, 7, 7, 1, '', 1, '6000.00', 'Not full', '2016-03-04', 4),
(11, 0, 9, 7, 1, '', 2, '5500.00', 'Not full', '2016-03-04', 4),
(12, 0, 8, 7, 3, '', 2, '6000.00', 'Not full', '2016-03-04', 4),
(13, 0, 10, 7, 5, '', 1, '4000.00', 'Not full', '2016-03-04', 6),
(14, 0, 15, 13, 8, '', 1, '5000.00', 'Not full', '2016-03-04', 6),
(15, 0, 16, 7, 13, '3,5,4,6,7,8,2,1,9,10,11,12,13,14', 1, '4000.00', 'Full', '2016-06-29', 6),
(16, 0, 16, 7, 13, '2,6,5', 1, '4000.00', 'Not full', '2016-06-29', 6),
(17, 0, 10, 7, 5, '3', 1, '4000.00', 'Not full', '2016-06-29', 6),
(18, 0, 10, 7, 5, '', 1, '4000.00', 'Not full', '2016-06-29', 6),
(19, 0, 10, 7, 5, '', 1, '4000.00', 'Not full', '2016-06-29', 6),
(20, 0, 10, 7, 5, '', 1, '4000.00', 'Not full', '2016-06-29', 6),
(21, 0, 10, 7, 5, '', 1, '7000.00', 'Not full', '2016-06-28', 6),
(22, 0, 16, 7, 13, '', 1, '4000.00', 'Not full', '2016-06-28', 6),
(23, 0, 15, 13, 8, '', 1, '5000.00', 'Not full', '2016-06-28', 6),
(24, 0, 11, 7, 3, '', 1, '4000.00', 'Not full', '2016-06-28', 6),
(25, 0, 15, 13, 8, '5,9,15', 1, '5000.00', 'Not full', '2016-07-08', 6),
(26, 0, 7, 7, 1, '', 1, '6000.00', 'Not full', '2016-07-07', 4),
(27, 0, 9, 7, 1, '', 2, '5500.00', 'Not full', '2016-07-07', 4),
(28, 0, 8, 7, 3, '', 2, '6000.00', 'Not full', '2016-07-07', 4),
(29, 0, 10, 7, 5, '', 1, '7000.00', 'Not full', '2016-07-07', 6),
(30, 0, 16, 7, 13, '', 1, '4000.00', 'Not full', '2016-07-07', 6),
(31, 0, 10, 7, 5, '', 1, '7000.00', 'Not full', '2016-07-10', 6),
(32, 0, 15, 13, 8, '', 1, '5000.00', 'Not full', '2016-07-10', 6),
(33, 0, 16, 7, 13, '', 1, '4000.00', 'Not full', '2016-07-10', 6),
(34, 0, 11, 7, 3, '', 1, '4000.00', 'Not full', '2016-07-10', 6),
(35, 0, 7, 7, 1, '', 1, '6000.00', 'Not full', '2016-07-10', 4),
(36, 0, 9, 7, 1, '', 2, '5500.00', 'Not full', '2016-07-10', 4),
(37, 0, 8, 7, 3, '', 2, '6000.00', 'Not full', '2016-07-10', 4),
(38, 0, 10, 7, 5, '', 1, '7000.00', 'Not full', '2016-07-11', 6),
(39, 0, 15, 13, 8, '', 1, '5000.00', 'Not full', '2016-07-11', 6),
(40, 0, 16, 7, 13, '', 1, '4000.00', 'Not full', '2016-07-11', 6),
(41, 0, 11, 7, 3, '', 1, '4000.00', 'Not full', '2016-07-11', 6),
(42, 0, 15, 13, 8, '', 1, '5000.00', 'Not full', '2016-07-12', 6),
(43, 0, 10, 7, 5, '', 1, '7000.00', 'Not full', '2016-07-12', 6),
(44, 0, 16, 7, 13, '', 1, '4000.00', 'Not full', '2016-07-12', 6),
(45, 0, 15, 13, 8, '', 1, '5000.00', 'Not full', '2016-07-13', 6),
(46, 0, 10, 7, 5, '27', 1, '7000.00', 'Not full', '2016-07-13', 6),
(47, 0, 16, 7, 13, '', 1, '4000.00', 'Not full', '2016-07-13', 6),
(48, 0, 15, 13, 8, '', 1, '5000.00', 'Not full', '2016-07-14', 6),
(49, 0, 10, 7, 5, '', 1, '7000.00', 'Not full', '2016-07-14', 6),
(50, 0, 18, 7, 8, '', 1, '4000.00', 'Not full', '2016-07-16', 5),
(51, 0, 10, 7, 5, '', 1, '7000.00', 'Not full', '2016-07-16', 6),
(52, 0, 15, 13, 8, '', 1, '5000.00', 'Not full', '2016-07-16', 6),
(53, 0, 18, 7, 8, '', 1, '4000.00', 'Not full', '2016-07-24', 5),
(54, 0, 10, 7, 5, '', 1, '7000.00', 'Not full', '2016-07-24', 6),
(55, 0, 16, 7, 13, '', 1, '4000.00', 'Not full', '2016-07-24', 6),
(56, 0, 15, 13, 8, '', 1, '5000.00', 'Not full', '2016-07-24', 6),
(57, 0, 18, 7, 8, '', 1, '4000.00', 'Not full', '2016-07-27', 5),
(58, 0, 17, 10, 5, '15', 1, '5500.00', 'Not full', '2016-08-24', 6),
(59, 0, 18, 7, 8, '5', 1, '4000.00', 'Not full', '2016-08-24', 5),
(60, 0, 18, 7, 8, '', 1, '4000.00', 'Not full', '2016-09-01', 5),
(61, 0, 10, 7, 5, '', 1, '7000.00', 'Not full', '2016-09-01', 6),
(62, 0, 18, 7, 8, '8', 1, '4000.00', 'Not full', '2016-09-09', 5),
(63, 0, 18, 7, 8, '1', 1, '4000.00', 'Not full', '2016-09-13', 5),
(64, 0, 21, 1, 1, '', 1, '6000.00', 'Not full', '2016-10-15', 4),
(65, 0, 20, 1, 8, '', 1, '4500.00', 'Not full', '2016-10-15', 5);

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
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`id`, `payment_status`, `channel`, `response`, `ticket_no`, `boarding_vehicle_id`, `seat_no`, `park_id`, `customer_id`, `date_booked`, `user_id`, `status`) VALUES
(1, 'Not paid', 'offline', '', 'RLRTEBOH', 1, 2, 0, 17, '2016-05-28 01:40:02', 0, '1'),
(2, 'Not paid', 'offline', '', 'VVYCVVNG', 1, 4, 0, 20, '2016-05-28 01:43:59', 0, '1'),
(3, 'Not paid', 'offline', '', 'SXT64JZL', 1, 3, 0, 17, '2016-05-28 01:47:52', 0, '1'),
(4, 'Not paid', 'offline', '', 'WDNMW4ZD', 1, 1, 0, 17, '2016-05-28 01:48:34', 0, '1'),
(5, 'Not paid', 'offline', '', 'MIHSFBHD', 1, 5, 0, 17, '2016-05-28 01:49:17', 0, '1'),
(6, 'Not paid', 'offline', '', 'SC1RRREG', 1, 6, 0, 17, '2016-05-28 01:52:17', 0, '1'),
(8, 'Not paid', 'bank', '', 'KLDEBEAU', 6, 0, 0, 23, '2016-06-12 12:53:45', 0, '1'),
(9, 'Not paid', 'bank', '', 'LIXF9LRC', 6, 8, 0, 23, '2016-06-12 13:13:45', 0, '1'),
(10, 'Not paid', 'bank', '', 'CJQIJXVI', 6, 8, 0, 23, '2016-06-12 13:16:55', 0, '1'),
(11, 'Not paid', 'bank', '', '2KLK2EFB', 6, 1, 0, 24, '2016-06-12 22:26:21', 0, '1'),
(12, 'Not paid', 'bank', '', '3WBICGYW', 6, 1, 0, 24, '2016-06-12 22:29:19', 0, '1'),
(13, 'Not paid', 'bank', '', 'GT25USYJ', 6, 7, 0, 17, '2016-06-13 09:46:36', 0, '1'),
(14, 'Not paid', 'bank', '', 'ITOMQXJP', 6, 7, 0, 17, '2016-06-13 09:54:01', 0, '1'),
(15, 'Not paid', 'bank', '', 'GUS1PF7G', 6, 7, 0, 17, '2016-06-13 10:18:13', 0, '1'),
(16, 'Not paid', 'bank', '', 'TXC7C0DZ', 6, 7, 0, 17, '2016-06-13 10:19:20', 0, '1'),
(17, 'Not paid', 'bank', '', 'SJSXYFR6', 6, 7, 0, 17, '2016-06-13 10:20:22', 0, '1'),
(18, 'Not paid', 'bank', '', 'F2EQYUXD', 6, 3, 0, 25, '2016-06-13 10:24:42', 0, '1'),
(19, 'Not paid', 'bank', '', 'GIURRCSM', 7, 10, 0, 17, '2016-06-13 10:29:12', 0, '1'),
(20, 'Not paid', 'offline', '', 'ZMCSO3HB', 15, 3, 0, 17, '2016-06-28 22:46:28', 0, '1'),
(21, 'Not paid', 'offline', '', 'GKQCWSOL', 15, 5, 0, 17, '2016-06-28 22:58:54', 0, '1'),
(22, 'Not paid', 'offline', '', 'GTXZPZRI', 15, 4, 0, 26, '2016-06-28 23:17:58', 0, '1'),
(23, 'Not paid', 'offline', '', 'XMIMXP7A', 15, 6, 0, 26, '2016-06-29 01:16:34', 0, '1'),
(24, 'Not paid', 'offline', '', 'B6PFXF4R', 15, 7, 0, 26, '2016-06-29 01:18:18', 0, '1'),
(25, 'Not paid', 'offline', '', '8K0FXU6I', 15, 8, 0, 17, '2016-06-29 01:18:49', 0, '1'),
(26, 'Not paid', 'offline', '', '1RDLKFWT', 15, 2, 0, 26, '2016-06-29 01:33:48', 0, '1'),
(27, 'Not paid', 'offline', '', '9F4PI9GA', 15, 1, 0, 17, '2016-06-29 01:36:17', 0, '1'),
(28, 'Not paid', 'offline', '', '6SVZKIU4', 15, 9, 0, 26, '2016-06-29 02:04:17', 0, '1'),
(29, 'Not paid', 'offline', '', 'LVBS8QYF', 15, 10, 0, 26, '2016-06-29 15:24:37', 0, '1'),
(30, 'Not paid', 'offline', '', 'SXYHLY3V', 15, 11, 0, 17, '2016-06-29 15:24:55', 0, '1'),
(31, 'Not paid', 'offline', '', 'EESDWLRE', 15, 12, 0, 26, '2016-06-29 15:31:43', 0, '1'),
(32, 'Not paid', 'offline', '', 'NPDKVCXY', 15, 13, 0, 17, '2016-06-29 15:31:56', 0, '1'),
(33, 'Not paid', 'offline', '', 'ASE25WNY', 15, 14, 0, 17, '2016-06-29 15:32:38', 0, '1'),
(34, 'Not paid', 'offline', '', 'XKEMNSZC', 16, 2, 0, 20, '2016-06-29 15:33:32', 0, '1'),
(35, 'Not paid', 'offline', '', 'SSWJYVJZ', 16, 6, 0, 26, '2016-06-29 17:30:01', 0, '1'),
(36, 'Not paid', 'offline', '', 'T0M8PAR3', 17, 3, 0, 17, '2016-06-29 18:09:16', 0, '1'),
(37, 'Not paid', 'offline', '', 'ZOB7LFXU', 16, 5, 0, 28, '2016-06-29 19:29:30', 0, '1'),
(38, 'Not paid', 'bank', '', 'DTR6LNGY', 25, 5, 0, 29, '2016-07-06 15:30:38', 0, '1'),
(39, 'Not paid', 'offline', '', 'OO15GQHO', 25, 9, 0, 17, '2016-07-06 15:31:28', 0, '1'),
(40, 'Not paid', 'bank', '', 'T1PPMM9S', 25, 15, 0, 30, '2016-07-06 15:36:17', 0, '1'),
(41, 'Not paid', 'bank', '', 'ETS1CYSW', 46, 27, 0, 17, '2016-07-13 08:17:54', 0, '1'),
(42, 'Not paid', 'bank', '', 'IWOXKMWZ', 58, 15, 0, 17, '2016-08-23 17:15:42', 0, '1'),
(43, 'Not paid', 'bank', '', 'E0YKCFXC', 59, 5, 0, 17, '2016-08-23 17:51:59', 0, '1'),
(44, 'Not paid', 'bank', '', 'YV0JYOEE', 59, 5, 0, 17, '2016-08-23 17:54:54', 0, '1'),
(45, 'Not paid', 'bank', '', 'DQQMTI4V', 59, 5, 0, 17, '2016-08-23 17:55:48', 0, '1'),
(46, 'Not paid', 'bank', '', 'TROQRF0B', 59, 5, 0, 17, '2016-08-23 17:57:22', 0, '1'),
(47, 'Not paid', 'bank', '', 'VPHXOHVT', 59, 5, 0, 17, '2016-08-23 17:57:55', 0, '1'),
(48, 'Not paid', 'bank', '', 'IBYX4H1D', 59, 5, 0, 17, '2016-08-23 18:00:26', 0, '1'),
(49, 'Not paid', 'bank', '', 'HCUOFFWI', 59, 5, 0, 17, '2016-08-23 18:01:49', 0, '1'),
(50, 'Not paid', 'bank', '', 'DMNDXW9X', 59, 5, 0, 17, '2016-08-23 18:06:10', 0, '1'),
(51, 'Not paid', 'bank', '', 'P5ITSVVS', 59, 5, 0, 17, '2016-08-23 18:07:16', 0, '1'),
(62, 'Not paid', 'bank', '', 'CMHEAEMR', 62, 8, 0, 31, '2016-09-08 22:19:38', 0, '1'),
(63, 'Not paid', 'bank', '', '3NJ6ABOR', 62, 8, 0, 31, '2016-09-08 23:08:22', 0, '1'),
(64, 'Not paid', 'bank', '', 'CRU0WJPW', 63, 1, 0, 32, '2016-09-12 18:59:31', 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `booking_issues`
--

CREATE TABLE IF NOT EXISTS `booking_issues` (
`id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL,
  `travel_date` date NOT NULL,
  `departure_order` tinyint(4) NOT NULL,
  `seat_no` tinyint(4) NOT NULL,
  `issue` varchar(150) NOT NULL,
  `resolved` tinyint(1) NOT NULL DEFAULT '0',
  `logged_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `booking_synch`
--

CREATE TABLE IF NOT EXISTS `booking_synch` (
`id` smallint(6) NOT NULL,
  `trip_id` int(11) NOT NULL,
  `travel_date` date NOT NULL,
  `seat_no` tinyint(2) NOT NULL,
  `departure_order` tinyint(2) NOT NULL,
  `cust_name` varchar(60) NOT NULL,
  `cust_phone` varchar(15) NOT NULL,
  `next_of_kin_phone` varchar(15) NOT NULL,
  `channel` varchar(50) NOT NULL,
  `category` varchar(100) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `logged_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

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
(20, 'Trother', '080555555667', '080555555667'),
(21, 'Chinonye Nneji', '0988989898', '0988989898'),
(22, 'Chibuzo', '080835787583', '080835787583'),
(23, 'Chinonye Nneji', '08083508505', '08083508505'),
(24, 'Ikpu', '08069486944', '08069486944'),
(25, 'Nigger', '07046795848', '07046795848'),
(26, 'Chiby', '08027930958', '08027930958'),
(27, 'Sione', '08135763222', '08135763222'),
(28, 'Chijioke boy', '08038568902', '08038568902'),
(29, 'Kester', '08048598945', '08048598945'),
(30, 'Ossai Oliver', '080235768478', '080235768478'),
(31, 'Chibuzo Okolo', '080897878798', '080897878798'),
(32, 'Chibuzo Okolo', '986796796079', '986796796079'),
(33, 'Chibuzo Okolo', '988768798989', '988768798989'),
(34, 'Chibuzo Okolo', '0908789897', '0908789897');

-- --------------------------------------------------------

--
-- Table structure for table `manifest_account`
--

CREATE TABLE IF NOT EXISTS `manifest_account` (
`id` int(11) NOT NULL,
  `boarding_vehicle_id` int(11) NOT NULL,
  `fuel` decimal(7,2) NOT NULL DEFAULT '0.00',
  `drivers_feeding` decimal(7,2) NOT NULL DEFAULT '0.00',
  `expenses` decimal(8,2) NOT NULL,
  `scouters_charge` decimal(6,2) NOT NULL DEFAULT '0.00',
  `load_charge` decimal(8,2) NOT NULL,
  `date_modifed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `nysc_fares`
--

CREATE TABLE IF NOT EXISTS `nysc_fares` (
`id` int(11) NOT NULL,
  `nysc_program_id` int(11) NOT NULL,
  `state_id` tinyint(4) NOT NULL,
  `fare` decimal(8,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nysc_fares`
--

INSERT INTO `nysc_fares` (`id`, `nysc_program_id`, `state_id`, `fare`) VALUES
(1, 1, 6, '4000.00'),
(2, 1, 1, '3999.00'),
(3, 1, 5, '6000.00'),
(4, 1, 4, '8000.00'),
(5, 1, 2, '0.00'),
(6, 1, 7, '0.00'),
(7, 1, 8, '0.00'),
(8, 1, 9, '0.00'),
(9, 1, 10, '0.00'),
(10, 1, 11, '0.00'),
(11, 1, 12, '0.00'),
(12, 1, 13, '0.00'),
(13, 1, 14, '0.00'),
(14, 1, 15, '0.00'),
(15, 1, 3, '0.00'),
(16, 1, 16, '0.00'),
(17, 1, 17, '0.00'),
(18, 1, 18, '0.00'),
(19, 1, 19, '0.00'),
(20, 1, 20, '0.00'),
(21, 1, 21, '0.00'),
(22, 1, 22, '0.00'),
(23, 1, 23, '0.00'),
(24, 1, 24, '0.00'),
(25, 1, 25, '0.00'),
(26, 1, 26, '0.00'),
(27, 1, 27, '0.00'),
(28, 1, 28, '0.00'),
(29, 1, 29, '0.00'),
(30, 1, 30, '0.00'),
(31, 1, 31, '0.00'),
(32, 1, 32, '0.00'),
(33, 1, 33, '0.00'),
(34, 1, 34, '0.00'),
(35, 1, 35, '0.00'),
(36, 1, 36, '0.00'),
(37, 1, 37, '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `nysc_programs`
--

CREATE TABLE IF NOT EXISTS `nysc_programs` (
`id` int(11) NOT NULL,
  `batch` char(1) NOT NULL,
  `stream` tinyint(1) NOT NULL,
  `camp_date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nysc_programs`
--

INSERT INTO `nysc_programs` (`id`, `batch`, `stream`, `camp_date`, `status`, `date_created`) VALUES
(1, 'B', 2, '2017-01-01', 1, '2017-01-18 13:54:50');

-- --------------------------------------------------------

--
-- Table structure for table `nysc_travelers`
--

CREATE TABLE IF NOT EXISTS `nysc_travelers` (
`id` int(11) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(60) NOT NULL,
  `origin` varchar(40) NOT NULL,
  `destination` varchar(40) NOT NULL,
  `travel_date` date NOT NULL,
  `passengers` tinyint(1) NOT NULL,
  `payment_opt` varchar(20) NOT NULL,
  `payment_status` varchar(10) NOT NULL DEFAULT 'Pending',
  `fare` decimal(9,2) NOT NULL,
  `ref_code` varchar(10) NOT NULL,
  `date_booked` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nysc_travelers`
--

INSERT INTO `nysc_travelers` (`id`, `fullname`, `phone`, `email`, `origin`, `destination`, `travel_date`, `passengers`, `payment_opt`, `payment_status`, `fare`, `ref_code`, `date_booked`) VALUES
(1, 'Chibuzo Okolo', '08035725606', 'chibuzo.henry@gmail.com', 'Enugu', 'Lagos', '2016-11-17', 1, '', 'Pending', '0.00', '', '2016-12-05 17:15:39'),
(2, 'Francis Ohatu', '08048584832', 'francis@gmail.com', 'Lagos', 'Delta', '0000-00-00', 1, '', 'Pending', '0.00', '', '2016-12-06 06:47:20'),
(3, 'Chibuzo Okolo', '8035725606', 'chibuzo.henry@gmail.com', 'Enugu', 'Imo', '0000-00-00', 2, '', 'Pending', '0.00', 'OQATID9A', '2016-12-06 10:57:05'),
(4, 'ityohrtio', '957-604-54', 'ptpyorpyr@yahoo.com', 'Lagos', 'Bayelsa', '2017-01-23', 1, '', 'Pending', '0.00', 'EOJ0PYBF', '2017-01-16 22:06:00'),
(5, 'Chibuzo Okolo', '8035725606', 'chibuzo.henry@gmail.com', 'Lagos', 'Edo', '2017-01-24', 1, '', 'Pending', '0.00', 'R7AM2S3N', '2017-01-16 22:55:29'),
(6, 'Chibuzo Okolo', '8035725606', 'chibuzo.henry@gmail.com', 'Lagos', 'Edo', '0000-00-00', 1, '', 'Pending', '0.00', 'UPU0LJ8V', '2017-01-17 13:24:14'),
(7, 'Chibuzo Okolo', '8035725606', '', 'Lagos', '', '0000-00-00', 1, '', 'Pending', '0.00', 'LZM4MOSH', '2017-01-17 13:34:15'),
(8, 'Damola Adewusi', '8184380439', 'augustine.ogwo@gmail.com', 'Lagos', 'Jigawa', '2017-01-24', 2, '', 'Pending', '0.00', 'OOOUOYFS', '2017-01-17 23:45:02'),
(9, 'Damola Adewusi', '8184380439', '', 'Lagos', 'Abuja', '2017-01-24', 1, '', 'Pending', '3999.00', 'XSW02LDI', '2017-01-19 06:08:32'),
(10, 'Chibuzo Okolo', '8035725606', 'chibuzo.henry@gmail.com', 'Lagos', 'Adamawa', '2017-01-25', 1, '', 'Pending', '6000.00', 'YNXE2RCQ', '2017-01-19 06:28:21'),
(11, 'Chibuzo Okolo', '8035725606', 'chibuzo.henry@gmail.com', 'Lagos', 'Abia', '2017-01-24', 1, '', 'Pending', '4000.00', '02WNBCWA', '2017-01-19 06:32:00'),
(12, 'Damola Adewusi', '8184380439', 'uzo.systems@gmail.com', 'Lagos', 'Ebonyi', '0000-00-00', 2, '', 'Pending', '0.00', 'TIK3MIRD', '2017-01-19 06:41:39'),
(13, 'Chibuzo Okolo', '8035725606', 'chibuzo.henry@gmail.com', 'Lagos', 'Abuja', '0000-00-00', 1, '', 'Pending', '3999.00', 'IXWJOQOF', '2017-01-19 06:45:26'),
(14, 'Chibuzo Okolo', '8035725606', 'chibuzo.henry@gmail.com', 'Lagos', 'Abia', '0000-00-00', 3, '', 'Pending', '4000.00', 'MXXUFNPS', '2017-01-19 07:39:07');

-- --------------------------------------------------------

--
-- Table structure for table `parks`
--

CREATE TABLE IF NOT EXISTS `parks` (
`id` int(11) NOT NULL,
  `state_id` tinyint(4) NOT NULL,
  `park` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

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
(27, 20, 'Kano II'),
(28, 1, 'Utako');

-- --------------------------------------------------------

--
-- Table structure for table `park_map`
--

CREATE TABLE IF NOT EXISTS `park_map` (
`id` int(11) NOT NULL,
  `origin` varchar(30) NOT NULL,
  `destination` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

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
(11, '17', '12', 1),
(12, '16', '11', 1),
(13, '16', '13', 1),
(14, '13', '16', 1),
(15, '13', '28', 1),
(16, '1', '10', 1),
(17, '17', '28', 1),
(18, '17', '21', 1),
(19, '17', '1', 1),
(20, '17', '10', 1),
(21, '21', '17', 1),
(22, '10', '1', 1),
(23, '10', '16', 1),
(24, '28', '13', 1);

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
  `api_charge` tinyint(1) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travels`
--

INSERT INTO `travels` (`id`, `company_name`, `abbr`, `offline_charge`, `online_charge`, `api_charge`, `date_created`, `deleted`) VALUES
(4, 'EkeneDiliChukwu Motors', 'Ekenedilichukwu', '8', '11', 4, '2015-10-30 04:33:01', 0),
(5, 'Ifesinachi Mass Transit', 'Ifesinachi', '5', '10', 0, '2015-11-01 23:08:48', 0),
(6, 'Peace Mass Transit', 'Peace', '2', '5', 0, '2016-05-20 19:35:53', 0),
(7, 'Cross Country Limited', 'Cross Country', '2', '10', 5, '2016-07-22 08:38:39', 0),
(8, 'Ekeson & Bros Limited', 'Ekeson', '2', '8', 7, '2016-09-17 11:38:53', 0),
(9, 'GUO Transport', 'GUO', '2', '8', 5, '2016-11-15 11:40:36', 0);

-- --------------------------------------------------------

--
-- Table structure for table `travel_admins`
--

CREATE TABLE IF NOT EXISTS `travel_admins` (
  `travel_id` int(11) NOT NULL,
`id` int(11) NOT NULL,
  `fullname` varchar(70) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` char(64) NOT NULL,
  `salt` char(32) NOT NULL,
  `user_type` varchar(15) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_admins`
--

INSERT INTO `travel_admins` (`travel_id`, `id`, `fullname`, `username`, `password`, `salt`, `user_type`, `date_created`, `deleted`) VALUES
(4, 6, 'Iroegbu Iroegbu', 'iroegbu', '648fbd2a1cc291edb8a1f7fee439d4fd63e6d470335ecce975ae0440cfb6f8a8', 'SLQbO/M3AgXsP80g4w/LQqEpG5fQ8O5w', 'travel_admin', '2015-10-31 16:18:50', '0'),
(4, 7, 'Pelumi', 'pelu', '6ba0345fa0dfb195e0be52dfb0d2ead435c1f0a4d0b369e70c42daf13a9507e9', 'mEpDVw91QNhMkITN78Ge6RDQ7DR7ilQp', 'travel_admin', '2015-10-31 16:37:06', '0'),
(4, 8, 'Chioma Amobi', 'chioma', 'a9b406e042798333f05e9856f8007eed7fe6ee62e390fc650121dbf6e8c3e5c7', 'lBBIrp9cvP4c/KcCqyh4mOP8V7WcUBez', 'travel_admin', '2015-10-31 16:43:13', '0'),
(4, 12, 'Complete Aproko', 'aproko2', '9ead1022a6caa72b77ab9d988718d90207b535c2dc53feb5205f97ea3aed0feb', 'Ju5453VemrTU96Ce/BQIWyfIk2/mWl7j', 'state_admin', '2016-02-10 03:01:00', '0'),
(4, 19, 'Adesuwa Okpefa', 'okpefa', 'af36c1cff6d5eec594d9071f10022513539416e656cde383922c87dcad43e1a0', '5kCa9idNn9VKN/9TzNrdUoMxgI0LCquL', 'state_admin', '2015-11-02 21:45:47', '0'),
(4, 24, 'Okolo Uzo', 'okoloc', 'f44c0263ddf60765eeeed2b26152d02562ace000f8727c1f177a8f8d21df0d14', '8tE5BGSybCMOezCmDVdGA78lcgtWq+0C', 'park_admin', '2015-11-03 00:15:11', '0'),
(4, 25, 'Augustine Ogwo', 'ogwo', '9e685dad18b5d9da472d85a4b9611105ae8c580f1ba88177a9940f7a26268ff8', 'oYn9dLq7X0w3pckhFU3E2gr8Nj3Tu5ct', 'park_admin', '2015-11-03 00:17:19', '0'),
(5, 27, 'okon', 'okon', 'f402c127d61caea3bf41c4c3b0186d9fc2e6c24e031484dfb8a7212446eb337f', 'bywti1DmsnnrLRZTFpPG1t3Wq+4T77dA', 'travel_admin', '2016-01-28 19:10:13', '0'),
(5, 28, 'Kano Admin', 'kano', '34ee91c74a47a7b683c659229706699d42fb97bc4b184515b17ca62881760004', 'R2jV1gxEX6f60z+FaF3SBpsN081ZPt1R', 'state_admin', '2016-01-28 19:24:22', '0'),
(4, 29, 'Okolo', 'oko', 'dcfbf7a9f5ae1567714e53b8791219566cf1dfe202aab8e7b4361bd9a8dcf3e5', '8OkgIqtVPOCbCFrmsWB4rfdBIaLsc3Yd', 'state_admin', '2016-02-11 04:20:25', '0'),
(6, 30, 'PMT Admin', 'pmt', '866f4a8a4340f8bd6704c410b433a000963137b0cec37c0d919c2f353cffa260', 'qkjzI5XJP3iFdvb8rAHHM3uc4vPudTk1', 'travel_admin', '2016-06-04 18:14:24', '0'),
(5, 31, 'Ifex Enugu', 'ifex_enugu', '21bcfb35abfc7a1f3638571f73cf8ef2d3fc35186df82450a45aaec786946930', '+K4UZ9exbfXyTATTaXkCyDhPg8KQF4gH', 'state_admin', '2016-07-14 04:02:33', '0'),
(5, 32, 'Ifex Holyghost', 'ifex_holyghost', '21b8e6f6dfc0bae81804a2e11ec32ac7b793e06a852f9ef89d36c1bc43baf42d', 'zDjA6lcQZoEcyKiM90NGfyZf5SomjjZJ', 'park_admin', '2016-07-14 04:09:14', '0'),
(7, 33, 'Cross Country Admin', 'ccl_admin', 'c688df82f2c5c47ae15db16033a1b813fa06d9cd69b36a5efa34aab5a3ac1625', 'aQbswDPDJoHRW1vEwO/HLc9B4mtCKM57', 'travel_admin', '2016-07-22 08:39:59', '0'),
(7, 34, 'Cross Country Lagos', 'ccl_lagos', '4f7d01234f0a58b723d896efcdff3ca12417ba7732a42a1c7865383a7392fc84', '1Q1FJOI25gfWLaP2jocr8koNgU8QysSY', 'state_admin', '2016-09-17 13:05:40', '0'),
(6, 35, 'Cross Country Jibowu', 'ccl_jibowu', 'b512a7fc57f0457b4c29711bfa6f82b3e07c5bdb652516a67370ea1e4df25b8f', 'BsJthnWMH+v2AXEpIacDgE68fQaTEs6S', 'park_admin', '2016-09-17 18:09:45', '0'),
(4, 36, 'Ekene Anambra', 'ekene_anam', 'e5ee80425657258f1cc167a830edcbfa802c8ccf3518c9788789dfca15dc6522', 'otmMpTW5uhCpqKrsOpvpDr+BifhgpJK0', 'state_admin', '2016-10-09 13:39:51', '0'),
(4, 38, 'Ekene Old Park', 'ekene_oldpark', '5195bf4113ffd48b7660cee219f43a3753ff0154227a49e6e71a6663c09ad428', '0QjgfbR/e2EyMPMy/XT+lz39gW1rkZCx', 'state_admin', '2016-10-09 13:43:11', '0'),
(4, 39, 'Ekene Old Park', 'ekeneoldpark', 'ecbfad0f18096bb2261f0531f3424ec5bfc73c609d73ae1d1115bbc40e0969f0', 'F+rrh6U3HOvcJgHor1VYJIcziEJYFWBc', 'park_admin', '2016-10-09 13:54:18', '0'),
(4, 42, 'ekene Amaokwe', 'amaokwe', '6e7642443562bcbad56b09f9212bfb9ea4ca01a15d63d2efccb605a4c4849d1c', 'P6mkWKIqAGe8yyaI4uOrvO3JEQnoWJer', 'park_admin', '2016-10-09 14:36:16', '0'),
(6, 43, 'Peace Abia', 'peace_abia', 'b582112171f44fe233afcf2a634b6a9ac65d0405209bae3341f0fbf7eda231d6', 'SHU/PR6PC6asAEW1R7eYWPQxVJm78DgI', 'state_admin', '2016-10-10 22:35:02', '0'),
(5, 44, 'Ifesinachi Lagos', 'ifex_lagos', 'd8ec24aa85ff9007081c08f52517fbd0788d030882dc77b94bd3e4fa1c8c37d4', 'za9tpLZGI0ElkTTMVhjDTMPzGEdChNBH', 'state_admin', '2016-10-11 07:51:10', '0'),
(5, 45, 'Ifesinachi Jibowu', 'ifex_jibowu', '86785c24a39d62834292c130ad32af3d13934a082009bf5bfbd929388e706eed', '1xXLuX39RNDR3g5FtquWHa1sPhNI1wnJ', 'park_admin', '2016-10-11 07:54:09', '0'),
(8, 46, 'Ekeson Abuja', 'ekeson_abuja', 'ae9a662786cd79b39608b6a9b814e6feb31e2427e53c5290a5f20f64fd101d1a', 'PyhQcaD2FEl4KRPVbK+Q4T//3oZjgBZ4', 'state_admin', '2016-10-17 22:09:38', '0'),
(8, 47, 'Ekeson Iba', 'ekeson_iba', '4dc68ca237c9ec0e92ad17344a568182765cab4d651cacff63cd185ab2298557', '8hZ+nJQtyrnz3lGsEVuwceCx7gDyR2a1', 'park_admin', '2016-10-17 23:19:27', '0'),
(8, 48, 'Ekeson Utako', 'ekeson_utako', '2ebee5cc6f205f56b588b14570b79ab7c535ee83dac1cad63464026fa045b03f', 'OGLr4ECze/e4e9EGK2DXPngyYmcKJyxL', 'park_admin', '2016-10-17 23:22:57', '0'),
(8, 49, 'Ekeson Lagos', 'ekeson_lagos', 'fd0246e934db05226be5820b738006c98b073cf3259ce74b7a8d0a8af146e814', 'FkYQz4C+vFVS1EJDjbrKru+t1veqG5KU', 'state_admin', '2016-10-17 23:37:04', '0'),
(8, 50, 'Ekeson Enugu', 'ekeson_enugu', '21014f530b9c07be13822a410042bb4a208b83ccaec267f96d847378773d3437', 'ncU3NBCBsGi/rH9zXE6eQb8SArq3y9ki', 'state_admin', '2016-10-17 23:38:37', '0'),
(8, 51, 'Ekeson Aba', 'ekeson_aba', '15d37f4f4196473fa12378480c16c0ac4ef3c0aa7c2dc912cbb374cc3cc11122', 'ik8rtICZAzwd0HatTIkA+yomsHV1npkT', 'state_admin', '2016-10-17 23:43:31', '0'),
(8, 52, 'Ekeson Rivers', 'ekeson_rivers', '17633a35d5f1dc7633ad190b6e8c78115fb8ceba0486fe6acdfcf3b6bd7b8c52', 'l02YKdazqhJodJIokuJHVWBV+b7OwkWC', 'state_admin', '2016-10-17 23:46:08', '0'),
(8, 53, 'ekeson Jibowu', 'ekeson_jibowu', 'f02b66ddcdb52d2676311c349956e661f7ed2a5074d2ace6d1a64ebe3cb3d2d8', 'lz4zwD3CZwC0hAtIrv54jU/99bzCKVg3', 'park_admin', '2016-10-17 23:50:35', '0');

-- --------------------------------------------------------

--
-- Table structure for table `travel_park`
--

CREATE TABLE IF NOT EXISTS `travel_park` (
`id` int(11) NOT NULL,
  `travel_id` int(11) NOT NULL,
  `park_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 for active, 2 for inactive',
  `online` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_park`
--

INSERT INTO `travel_park` (`id`, `travel_id`, `park_id`, `user_id`, `address`, `phone`, `status`, `online`) VALUES
(1, 4, 1, 24, '', '', 1, 1),
(2, 4, 14, 25, '', '', 1, 1),
(3, 4, 2, 26, '', '', 0, 0),
(4, 4, 16, 30, '', '', 1, 1),
(5, 4, 17, 31, '', '', 1, 0),
(6, 6, 16, 35, '', '', 1, 0),
(7, 5, 16, 32, '', '', 1, 0),
(8, 6, 13, 35, '', '', 1, 0),
(9, 6, 1, 35, '', '', 1, 0),
(10, 4, 21, 39, '', '', 1, 0),
(11, 4, 24, 42, 'Somewhere close', '08035725606,08035725606', 1, 1),
(12, 5, 1, 45, 'No Jibowu Street', '08035725606,08035725606', 1, 0),
(13, 8, 10, 47, 'Iba park', '08035725606,08035725606', 1, 0),
(14, 8, 28, 48, 'Utako', '08035725606,08035725606', 1, 0),
(15, 8, 1, 53, 'Jibowu under bridge', '08035725606,08035725606', 1, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

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
(12, 6, 10, 0, '2016-05-20 20:20:59'),
(13, 6, 12, 0, '2016-06-16 18:17:37'),
(14, 6, 13, 0, '2016-06-17 01:57:20'),
(15, 5, 7, 0, '2016-07-14 04:10:57'),
(16, 6, 15, 0, '2016-09-17 18:10:23'),
(17, 6, 16, 0, '2016-09-17 18:10:35'),
(18, 4, 17, 0, '2016-10-10 18:50:27'),
(19, 4, 18, 0, '2016-10-10 19:02:45'),
(20, 4, 19, 0, '2016-10-10 19:04:30'),
(21, 4, 20, 0, '2016-10-10 19:05:52'),
(22, 4, 21, 0, '2016-10-10 19:10:39'),
(23, 5, 1, 0, '2016-10-11 07:56:52'),
(24, 8, 1, 0, '2016-10-17 23:51:40'),
(25, 8, 22, 0, '2016-10-18 00:05:06'),
(26, 8, 23, 0, '2016-10-18 00:05:24'),
(27, 8, 24, 0, '2016-10-18 11:07:55');

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
-- Table structure for table `travel_settings`
--

CREATE TABLE IF NOT EXISTS `travel_settings` (
`id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `api` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `travel_state`
--

CREATE TABLE IF NOT EXISTS `travel_state` (
`id` int(11) NOT NULL,
  `travel_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `online` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_state`
--

INSERT INTO `travel_state` (`id`, `travel_id`, `state_id`, `user_id`, `status`, `online`) VALUES
(4, 4, 16, 12, 1, 1),
(11, 4, 25, 19, 1, 1),
(12, 5, 20, 28, 1, 0),
(13, 4, 3, 29, 1, 1),
(14, 6, 3, 33, 1, 0),
(15, 6, 25, 34, 1, 0),
(16, 5, 3, 31, 1, 0),
(17, 7, 25, 34, 1, 0),
(18, 4, 2, 36, 1, 0),
(20, 4, 21, 38, 1, 0),
(21, 6, 6, 43, 1, 0),
(22, 5, 25, 44, 1, 0),
(23, 8, 1, 46, 1, 0),
(24, 8, 25, 49, 1, 0),
(25, 8, 3, 50, 1, 0),
(26, 8, 6, 51, 1, 0),
(27, 8, 33, 52, 1, 0);

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
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_vehicle_types`
--

INSERT INTO `travel_vehicle_types` (`id`, `travel_id`, `vehicle_name`, `vehicle_type_id`, `status`, `date_modified`) VALUES
(1, 4, 'Coach', 4, 0, '2015-11-15 13:17:41'),
(3, 4, 'Executive', 1, 0, '2015-11-15 13:30:18'),
(4, 4, 'Luxury Bus', 5, 0, '2015-11-15 13:30:57'),
(5, 6, 'Hiace', 3, 0, '2016-05-20 20:24:26'),
(6, 6, 'Foton', 8, 0, '2016-05-20 20:24:44'),
(11, 6, 'Nissian Urvan', 13, 0, '2016-06-28 15:59:58'),
(13, 6, 'Luxury bus', 5, 0, '2016-06-30 14:20:26'),
(14, 5, 'Toyota Hiace', 8, 0, '2016-07-14 04:15:22'),
(15, 5, 'Nissian', 13, 0, '2016-07-14 04:15:38'),
(16, 5, 'Luxury bus', 5, 0, '2016-07-14 04:15:53'),
(17, 7, 'Coster', 4, 0, '2016-09-17 13:02:52'),
(18, 4, 'Hummer', 3, 0, '2016-10-17 21:52:39'),
(19, 4, 'Hiace', 14, 0, '2016-10-17 21:57:16'),
(20, 4, 'Injoo', 12, 0, '2016-10-17 22:08:02'),
(21, 8, 'Hiace', 15, 0, '2016-10-17 22:08:48');

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
  `fare` float(6,0) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `park_map_id`, `travel_id`, `state_id`, `departure`, `route_id`, `vehicle_type_id`, `amenities`, `departure_time`, `date_added`, `fare`) VALUES
(10, 7, 6, 3, 1, 1, 5, 'A/C', '07:00:00', '2016-05-20 20:43:46', 7000),
(15, 13, 6, 3, 1, 1, 8, 'A/C>TV', '07:00:00', '2016-06-17 16:42:53', 5000),
(16, 7, 6, 3, 1, 1, 13, 'A/C', '05:00:00', '2016-06-28 16:02:38', 4000),
(17, 10, 6, 3, 1, 26, 5, 'A/C>TV>Refreshment', '07:15:00', '2016-06-30 14:23:36', 5500),
(18, 7, 5, 3, 1, 1, 8, 'A/C', '07:00:00', '2016-07-14 04:16:42', 4000),
(19, 7, 5, 3, 2, 1, 13, 'A/C', '07:30:00', '2016-10-11 00:36:23', 5000),
(20, 1, 5, 25, 1, 14, 8, 'A/C>TV', '07:00:00', '2016-10-11 07:57:32', 4500),
(21, 1, 4, 25, 1, 14, 1, 'A/C', '01:30:00', '2016-10-14 00:43:48', 6000),
(22, 17, 4, 3, 1, 26, 1, 'A/C', '06:30:00', '2016-10-14 19:42:33', 4000),
(23, 19, 4, 3, 1, 1, 1, 'A/C', '06:30:00', '2016-10-14 20:29:45', 6000),
(24, 1, 8, 25, 1, 14, 15, 'A/C', '07:00:00', '2016-10-17 23:52:20', 4500),
(25, 22, 8, 1, 1, 55, 15, 'A/C', '06:00:00', '2016-10-18 00:05:50', 6000),
(26, 23, 8, 1, 1, 57, 15, 'A/C', '06:00:00', '2016-10-18 00:12:52', 4500),
(27, 23, 8, 1, 2, 57, 15, 'A/C', '07:00:00', '2016-10-18 00:13:22', 4500),
(28, 24, 8, 1, 1, 55, 15, 'A/C', '12:00:00', '2016-10-18 11:08:12', 5000);

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_types`
--

INSERT INTO `vehicle_types` (`id`, `name`, `num_of_seats`, `removed`) VALUES
(1, 'Regular Sienna', 5, 0),
(2, 'Car', 3, 1),
(3, 'Toyota Bus', 10, 0),
(4, 'Coaster Bus', 19, 0),
(5, 'Luxury Bus', 59, 0),
(6, 'gos', 7, 1),
(7, 'Executive Sienna', 5, 0),
(8, 'Old Hiace', 15, 0),
(9, 'Hummer', 6, 1),
(12, 'Another Motor', 18, 0),
(13, 'Nissian Urvan', 14, 0),
(14, 'Old Hiace', 14, 0),
(15, 'New Hiace', 14, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boarding_vehicle`
--
ALTER TABLE `boarding_vehicle`
 ADD PRIMARY KEY (`id`), ADD KEY `park_map_id` (`park_map_id`,`vehicle_type_id`), ADD KEY `travel_id` (`travel_id`), ADD KEY `booked_vehicle_id` (`booked_vehicle_id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
 ADD PRIMARY KEY (`id`), ADD KEY `ticket_no` (`ticket_no`) USING BTREE, ADD KEY `park_id` (`park_id`), ADD KEY `boarding_vehicle_id` (`boarding_vehicle_id`);

--
-- Indexes for table `booking_issues`
--
ALTER TABLE `booking_issues`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_synch`
--
ALTER TABLE `booking_synch`
 ADD PRIMARY KEY (`id`);

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
-- Indexes for table `manifest_account`
--
ALTER TABLE `manifest_account`
 ADD PRIMARY KEY (`id`), ADD KEY `booked_vehicle_id` (`boarding_vehicle_id`);

--
-- Indexes for table `manifest_serial_no`
--
ALTER TABLE `manifest_serial_no`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `seria_no` (`serial_no`), ADD KEY `booked_id` (`booked_vehicle_id`);

--
-- Indexes for table `nysc_fares`
--
ALTER TABLE `nysc_fares`
 ADD PRIMARY KEY (`id`), ADD KEY `nysc_program_id` (`nysc_program_id`);

--
-- Indexes for table `nysc_programs`
--
ALTER TABLE `nysc_programs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nysc_travelers`
--
ALTER TABLE `nysc_travelers`
 ADD PRIMARY KEY (`id`), ADD KEY `ref_code` (`ref_code`);

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
-- Indexes for table `travel_settings`
--
ALTER TABLE `travel_settings`
 ADD PRIMARY KEY (`id`);

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `booking_issues`
--
ALTER TABLE `booking_issues`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `booking_synch`
--
ALTER TABLE `booking_synch`
MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bus_charter`
--
ALTER TABLE `bus_charter`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `manifest_account`
--
ALTER TABLE `manifest_account`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `manifest_serial_no`
--
ALTER TABLE `manifest_serial_no`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `nysc_fares`
--
ALTER TABLE `nysc_fares`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `nysc_programs`
--
ALTER TABLE `nysc_programs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `nysc_travelers`
--
ALTER TABLE `nysc_travelers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `parks`
--
ALTER TABLE `parks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `park_map`
--
ALTER TABLE `park_map`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
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
MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `travel_admins`
--
ALTER TABLE `travel_admins`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `travel_park`
--
ALTER TABLE `travel_park`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `travel_park_map`
--
ALTER TABLE `travel_park_map`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `travel_routes`
--
ALTER TABLE `travel_routes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `travel_settings`
--
ALTER TABLE `travel_settings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `travel_state`
--
ALTER TABLE `travel_state`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `travel_vehicle_types`
--
ALTER TABLE `travel_vehicle_types`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
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
MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
