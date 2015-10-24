-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2015 at 11:48 PM
-- Server version: 5.6.25
-- PHP Version: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travelhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `boarding_vehicle`
--

CREATE TABLE IF NOT EXISTS `boarding_vehicle` (
  `id` int(11) NOT NULL,
  `fare_id` mediumint(9) NOT NULL,
  `booked_seats` varchar(80) NOT NULL,
  `seat_status` enum('Not full','Full') NOT NULL DEFAULT 'Not full',
  `travel_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE IF NOT EXISTS `booking_details` (
  `id` int(11) NOT NULL,
  `payment_status` varchar(15) NOT NULL DEFAULT 'Not paid',
  `payment_opt` varchar(15) NOT NULL,
  `response` varchar(100) NOT NULL,
  `ticket_no` char(8) NOT NULL,
  `boarding_bus_id` int(11) NOT NULL,
  `route_id` mediumint(9) NOT NULL,
  `seat_no` tinyint(2) NOT NULL,
  `c_name` varchar(25) NOT NULL,
  `next_of_kin_phone` varchar(11) NOT NULL,
  `phone_no` char(13) NOT NULL,
  `email` varchar(40) NOT NULL,
  `fare` decimal(10,2) NOT NULL,
  `terminal` varchar(30) NOT NULL,
  `departure_time` time NOT NULL,
  `date_booked` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `travel_date` date NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`id`, `payment_status`, `payment_opt`, `response`, `ticket_no`, `boarding_bus_id`, `route_id`, `seat_no`, `c_name`, `next_of_kin_phone`, `phone_no`, `email`, `fare`, `terminal`, `departure_time`, `date_booked`, `travel_date`, `status`) VALUES
(1, 'Not paid', 'offline', '', '1D3GHBOO', 1, 14, 2, 'Chibuzo', '8563543090', '08906854674', '', '8000.00', 'Jibowu', '00:00:00', '2015-03-28 16:47:42', '2015-03-29', '1'),
(4, 'Not paid', 'offline', '', 'G1NCW2X6', 4, 26, 2, 'Judith', '08083643784', '08084675486', '', '8000.00', 'Jibowu', '00:00:00', '2015-03-28 17:00:57', '2015-03-29', '1'),
(5, 'Not paid', 'offline', '', 'GOLZYZV4', 5, 1, 1, 'Kester', '0817484785', '08027847399', '', '5000.00', 'Jibowu', '00:00:00', '2015-03-28 17:03:18', '2015-03-29', '1'),
(6, 'Not paid', 'offline', '', 'MN86GUU1', 3, 26, 11, 'Luis Ekpe', '08085748788', '08174858478', '', '4000.00', 'Jibowu', '00:00:00', '2015-03-28 17:04:05', '2015-03-29', '1'),
(7, 'Not paid', 'offline', '', 'XMK4FKCC', 6, 52, 3, 'Chisom Eneh', '09075738474', '081374737464', '', '11000.00', 'Jibowu', '00:00:00', '2015-03-28 17:16:54', '2015-03-30', '1'),
(8, 'Not paid', 'offline', '', 'L5BQM64E', 9, 14, 3, 'Emeka John', '08867598988', '08035725606', '', '9000.00', 'Jibowu', '00:00:00', '2015-04-01 17:05:09', '2015-04-02', '1'),
(9, 'Not paid', 'offline', '', 'O1WZ2Y8D', 16, 14, 3, 'qqqqq', '0809999999', '080999999999', '', '10000.00', 'Jibowu', '00:00:00', '2015-04-10 10:32:13', '2015-04-18', '1'),
(10, 'Not paid', 'offline', '', 'K1ARDPSF', 25, 14, 5, 'obinna', '08160000231', '08160000231', '', '9000.00', 'Jibowu', '00:00:00', '2015-07-10 09:08:38', '2015-07-10', '1'),
(11, 'Not paid', 'offline', '', 'DZEQDTR1', 26, 14, 2, 'Ayomide', '08160000231', '08160000231', '', '10000.00', 'Jibowu', '00:00:00', '2015-07-10 14:27:47', '2015-07-11', '1'),
(12, 'Not paid', 'offline', '', 'HHM5KHFZ', 27, 1, 5, 'tester1', '08029631485', '08029631485', '', '9000.00', 'Jibowu', '00:00:00', '2015-07-11 21:37:09', '2015-07-12', '1'),
(13, 'Not paid', 'offline', '', 'Y1DJWDHF', 28, 1, 3, 'chris tester', '44455566', '08063351763', '', '10000.00', 'Jibowu', '00:00:00', '2015-07-11 21:47:13', '2015-07-12', '1'),
(14, 'Not paid', 'offline', '', 'JIKHDWYG', 29, 14, 1, 'chike', '08063242486', '08066744644', '', '10000.00', 'Jibowu', '00:00:00', '2015-07-12 07:58:12', '0000-00-00', '1');

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
  `route_id` int(11) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `terminal_name` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parks`
--

INSERT INTO `parks` (`id`, `state_id`, `terminal_name`) VALUES
(1, 1, 'Jibowu'),
(2, 1, 'Maza maza'),
(3, 1, 'Orile'),
(4, 1, 'Oshodi-Charity'),
(5, 1, 'Ojuelegba'),
(6, 1, 'Ikotun'),
(7, 1, 'Berger'),
(8, 1, 'Cele'),
(9, 1, 'Oshodi-Bolade'),
(10, 1, 'Iba'),
(11, 1, 'Iyana Ipaja'),
(12, 1, 'Volks'),
(13, 1, 'Yaba'),
(14, 1, 'Ajah'),
(15, 1, 'Festac Gate'),
(16, 2, 'Holy ghost'),
(17, 2, 'Nsukka');

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
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `origin`, `destination`, `route`, `status`) VALUES
(1, 'Enugu', 'Lagos', 'Enugu - Lagos', 1),
(26, 'Enugu', 'Abuja', 'Enugu - Abuja', 1),
(14, 'Lagos', 'Enugu', 'Lagos - Enugu', 1),
(29, 'Lagos', 'Abuja', 'Lagos - Abuja', 1),
(31, 'Lagos', 'PortHarcourt', 'Lagos - PortHarcourt', 1),
(32, 'Lagos', 'Delta', 'Lagos - Delta', 1),
(57, 'Abuja', 'Enugu', 'Abuja - Enugu', 1),
(56, 'Delta', 'Abuja', 'Delta - Abuja', 1),
(55, 'Abuja', 'Lagos', 'Abuja - Lagos', 1),
(54, 'Delta', 'Lagos', 'Delta - Lagos', 1),
(53, 'PortHarcourt', 'Abuja', 'PortHarcourt - Abuja', 1),
(52, 'PortHarcourt', 'Lagos', 'PortHarcourt - Lagos', 1);

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
-- Table structure for table `travel_vehicle_types`
--

CREATE TABLE IF NOT EXISTS `travel_vehicle_types` (
  `id` int(11) NOT NULL,
  `travel_id` int(11) NOT NULL,
  `vehicle_name` varchar(20) NOT NULL,
  `vehicle_type_id` tinyint(4) NOT NULL,
  `amenities` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 for active, 0 for inactive',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `salt`, `user_type`, `date_created`, `deleted`) VALUES
(1, 'Chibuzo', 'chibuzo', '8185569fe5f5f34bd48bcdf3155f570297b96928d443ebec7d3c1626536fc318', 'vFF+q6x+1ceEWmVvhlCgELhzhPJqc0pC', 'admin', '2015-01-09 12:25:49', '0'),
(2, 'Njideka Onu', 'onu', '82cc406d16a8f3011f3921939fce857a86503f3a866df9e2a5758cc9701dc2c4', 'nJlZfWOzxdBRPCC5LxnBzv6FYK2QnogC', 'Operator', '2015-01-09 12:43:13', '1'),
(3, 'Okpeke Admin', 'okpo', 'dfa8617b02c9d168c793c64528521f8f6ac3120492541e5407f7acc2870c20cb', '2q2SKQMAAq3VdZqbK+NOKQu56RDCcWl/', 'user', '2015-09-15 14:43:23', '1'),
(4, 'amaka', 'amaka', '6ab0034f44a8f3fc92c2c9259133bfec8d581037cd36db30fc72bcb3d1bed9f6', 'X5AWxXtEqactoQH+DrjSuBfk4tZRyZZR', 'account', '2015-03-06 17:57:15', '0'),
(5, 'Administrator', 'admin', '34d9b4b876b7bda4e21a078ec6ddaa8f6379e4bde47009db722c82466988cdd1', 'izL6onBroshZLfM85Vrb1ZqEH+BuIRGi', 'user', '2015-03-27 12:00:46', '0');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_types`
--

CREATE TABLE IF NOT EXISTS `vehicle_types` (
  `id` smallint(6) NOT NULL,
  `name` varchar(50) NOT NULL,
  `num_of_seats` tinyint(2) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_types`
--

INSERT INTO `vehicle_types` (`id`, `name`, `num_of_seats`) VALUES
(1, 'Regular Sienna', 5),
(2, 'Car', 3),
(3, 'Toyota Bus', 10),
(4, 'Coaster Bus', 19),
(5, 'A motor', 70),
(6, 'gos', 7),
(7, 'Executive Sienna', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boarding_vehicle`
--
ALTER TABLE `boarding_vehicle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booked_id` (`boarding_bus_id`),
  ADD KEY `travel_date` (`travel_date`),
  ADD KEY `ticket_no` (`ticket_no`),
  ADD KEY `route_id` (`route_id`);

--
-- Indexes for table `bus_charter`
--
ALTER TABLE `bus_charter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departure_time`
--
ALTER TABLE `departure_time`
  ADD PRIMARY KEY (`id`),
  ADD KEY `travel_id` (`travel_id`),
  ADD KEY `route_code` (`route_id`),
  ADD KEY `travel_vehicle_type_id` (`travel_vehicle_type_id`);

--
-- Indexes for table `fares`
--
ALTER TABLE `fares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `travel_id` (`travel_id`);

--
-- Indexes for table `online_booking`
--
ALTER TABLE `online_booking`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_details_id` (`booking_details_id`),
  ADD UNIQUE KEY `ticket_no` (`ticket_no`),
  ADD KEY `payment_opt` (`payment_opt`,`payment_status`),
  ADD KEY `travel_date` (`travel_date`),
  ADD KEY `time_stamp` (`time_stamp`);

--
-- Indexes for table `parks`
--
ALTER TABLE `parks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `travel_id` (`state_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `filename` (`filename`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `origin` (`origin`),
  ADD KEY `destination` (`destination`),
  ADD FULLTEXT KEY `route` (`route`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states_towns`
--
ALTER TABLE `states_towns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `travel_routes`
--
ALTER TABLE `travel_routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `travel_id` (`travel_id`);

--
-- Indexes for table `travel_vehicle_types`
--
ALTER TABLE `travel_vehicle_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `travel_id` (`travel_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `bus_charter`
--
ALTER TABLE `bus_charter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `departure_time`
--
ALTER TABLE `departure_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fares`
--
ALTER TABLE `fares`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=58;
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
-- AUTO_INCREMENT for table `travel_routes`
--
ALTER TABLE `travel_routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `travel_vehicle_types`
--
ALTER TABLE `travel_vehicle_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
