/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 50625
Source Host           : localhost:3306
Source Database       : travelhub

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2015-11-06 02:38:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `boarding_vehicle`
-- ----------------------------
DROP TABLE IF EXISTS `boarding_vehicle`;
CREATE TABLE `boarding_vehicle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fare_id` mediumint(9) NOT NULL,
  `booked_seats` varchar(80) NOT NULL,
  `seat_status` enum('Not full','Full') NOT NULL DEFAULT 'Not full',
  `travel_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of boarding_vehicle
-- ----------------------------

-- ----------------------------
-- Table structure for `booking_details`
-- ----------------------------
DROP TABLE IF EXISTS `booking_details`;
CREATE TABLE `booking_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `status` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `booked_id` (`boarding_bus_id`) USING BTREE,
  KEY `travel_date` (`travel_date`) USING BTREE,
  KEY `ticket_no` (`ticket_no`) USING BTREE,
  KEY `route_id` (`route_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of booking_details
-- ----------------------------
INSERT INTO `booking_details` VALUES ('1', 'Not paid', 'offline', '', '1D3GHBOO', '1', '14', '2', 'Chibuzo', '8563543090', '08906854674', '', '8000.00', 'Jibowu', '00:00:00', '2015-03-28 17:47:42', '2015-03-29', '1');
INSERT INTO `booking_details` VALUES ('4', 'Not paid', 'offline', '', 'G1NCW2X6', '4', '26', '2', 'Judith', '08083643784', '08084675486', '', '8000.00', 'Jibowu', '00:00:00', '2015-03-28 18:00:57', '2015-03-29', '1');
INSERT INTO `booking_details` VALUES ('5', 'Not paid', 'offline', '', 'GOLZYZV4', '5', '1', '1', 'Kester', '0817484785', '08027847399', '', '5000.00', 'Jibowu', '00:00:00', '2015-03-28 18:03:18', '2015-03-29', '1');
INSERT INTO `booking_details` VALUES ('6', 'Not paid', 'offline', '', 'MN86GUU1', '3', '26', '11', 'Luis Ekpe', '08085748788', '08174858478', '', '4000.00', 'Jibowu', '00:00:00', '2015-03-28 18:04:05', '2015-03-29', '1');
INSERT INTO `booking_details` VALUES ('7', 'Not paid', 'offline', '', 'XMK4FKCC', '6', '52', '3', 'Chisom Eneh', '09075738474', '081374737464', '', '11000.00', 'Jibowu', '00:00:00', '2015-03-28 18:16:54', '2015-03-30', '1');
INSERT INTO `booking_details` VALUES ('8', 'Not paid', 'offline', '', 'L5BQM64E', '9', '14', '3', 'Emeka John', '08867598988', '08035725606', '', '9000.00', 'Jibowu', '00:00:00', '2015-04-01 18:05:09', '2015-04-02', '1');
INSERT INTO `booking_details` VALUES ('9', 'Not paid', 'offline', '', 'O1WZ2Y8D', '16', '14', '3', 'qqqqq', '0809999999', '080999999999', '', '10000.00', 'Jibowu', '00:00:00', '2015-04-10 11:32:13', '2015-04-18', '1');
INSERT INTO `booking_details` VALUES ('10', 'Not paid', 'offline', '', 'K1ARDPSF', '25', '14', '5', 'obinna', '08160000231', '08160000231', '', '9000.00', 'Jibowu', '00:00:00', '2015-07-10 10:08:38', '2015-07-10', '1');
INSERT INTO `booking_details` VALUES ('11', 'Not paid', 'offline', '', 'DZEQDTR1', '26', '14', '2', 'Ayomide', '08160000231', '08160000231', '', '10000.00', 'Jibowu', '00:00:00', '2015-07-10 15:27:47', '2015-07-11', '1');
INSERT INTO `booking_details` VALUES ('12', 'Not paid', 'offline', '', 'HHM5KHFZ', '27', '1', '5', 'tester1', '08029631485', '08029631485', '', '9000.00', 'Jibowu', '00:00:00', '2015-07-11 22:37:09', '2015-07-12', '1');
INSERT INTO `booking_details` VALUES ('13', 'Not paid', 'offline', '', 'Y1DJWDHF', '28', '1', '3', 'chris tester', '44455566', '08063351763', '', '10000.00', 'Jibowu', '00:00:00', '2015-07-11 22:47:13', '2015-07-12', '1');
INSERT INTO `booking_details` VALUES ('14', 'Not paid', 'offline', '', 'JIKHDWYG', '29', '14', '1', 'chike', '08063242486', '08066744644', '', '10000.00', 'Jibowu', '00:00:00', '2015-07-12 08:58:12', '0000-00-00', '1');

-- ----------------------------
-- Table structure for `bus_charter`
-- ----------------------------
DROP TABLE IF EXISTS `bus_charter`;
CREATE TABLE `bus_charter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `departure_location` varchar(20) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `travel_date` datetime NOT NULL,
  `bus_type_id` tinyint(4) NOT NULL,
  `num_of_vehicles` tinyint(4) NOT NULL,
  `date_chartered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(9) NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of bus_charter
-- ----------------------------
INSERT INTO `bus_charter` VALUES ('1', 'Chibuzo', '08035725606', 'Maryland', 'Enugu', '2015-04-04 00:00:00', '2', '1', '2015-03-21 04:55:03', 'Pending');
INSERT INTO `bus_charter` VALUES ('2', 'George', '0803583434', 'Iyana Paja', 'Orlu', '2015-03-30 00:00:00', '3', '2', '2015-03-22 13:23:57', 'Pending');

-- ----------------------------
-- Table structure for `departure_time`
-- ----------------------------
DROP TABLE IF EXISTS `departure_time`;
CREATE TABLE `departure_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` mediumint(9) NOT NULL,
  `travel_id` mediumint(9) NOT NULL,
  `travel_vehicle_type_id` int(11) NOT NULL,
  `departure_order` tinyint(4) NOT NULL,
  `departure_time` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `travel_id` (`travel_id`) USING BTREE,
  KEY `route_code` (`route_id`) USING BTREE,
  KEY `travel_vehicle_type_id` (`travel_vehicle_type_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of departure_time
-- ----------------------------

-- ----------------------------
-- Table structure for `fares`
-- ----------------------------
DROP TABLE IF EXISTS `fares`;
CREATE TABLE `fares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `travel_id` tinyint(4) NOT NULL,
  `vehicle_type_id` tinyint(4) NOT NULL,
  `fare` varchar(5) NOT NULL,
  `route_id` int(11) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `travel_id` (`travel_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of fares
-- ----------------------------

-- ----------------------------
-- Table structure for `online_booking`
-- ----------------------------
DROP TABLE IF EXISTS `online_booking`;
CREATE TABLE `online_booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_details_id` (`booking_details_id`) USING BTREE,
  UNIQUE KEY `ticket_no` (`ticket_no`) USING BTREE,
  KEY `payment_opt` (`payment_opt`,`payment_status`) USING BTREE,
  KEY `travel_date` (`travel_date`) USING BTREE,
  KEY `time_stamp` (`time_stamp`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of online_booking
-- ----------------------------
INSERT INTO `online_booking` VALUES ('1', 'Lagos to Abuja', 'offline', '', '', '', '00:00:00', '', '808', 'uzo.systems@gmail.com', 'RFWL6ZYN', '2013-11-30', '2013-11-29', '2013-11-29 14:05:24');
INSERT INTO `online_booking` VALUES ('2', 'Lagos to Onitsha', 'online', '', '', '', '00:00:00', '', '809', 'tina42006@yahoo.com', 'X1GTJFPN', '2013-12-19', '2013-11-29', '2013-11-29 15:30:18');
INSERT INTO `online_booking` VALUES ('3', 'Lagos to Onitsha', 'offline', '', '', '', '00:00:00', '', '810', 'tina42006@yahoo.com', '96HVVHVE', '2013-12-19', '2013-11-29', '2013-11-29 15:30:52');
INSERT INTO `online_booking` VALUES ('4', 'Lagos to Abuja', 'offline', '', '', '', '00:00:00', '', '811', 'tofunmi.og@gmail.com', 'EYOVAEYT', '2013-11-30', '2013-11-29', '2013-11-29 15:33:46');
INSERT INTO `online_booking` VALUES ('5', 'Lagos to Abuja', 'online', '', '', '', '00:00:00', '', '812', 'tofunmi.og@gmail.com', 'BGZINCSM', '2013-11-30', '2013-11-29', '2013-11-29 15:35:10');
INSERT INTO `online_booking` VALUES ('6', 'Lagos to Abuja', 'online', '', '', '', '00:00:00', '', '813', 'tofunmi.og@gmail.com', 'PMRKBFNH', '2013-12-02', '2013-11-29', '2013-11-29 15:36:19');

-- ----------------------------
-- Table structure for `parks`
-- ----------------------------
DROP TABLE IF EXISTS `parks`;
CREATE TABLE `parks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_id` tinyint(4) NOT NULL,
  `park` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `travel_id` (`state_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of parks
-- ----------------------------
INSERT INTO `parks` VALUES ('1', '25', 'Jibowu');
INSERT INTO `parks` VALUES ('2', '25', 'Maza maza');
INSERT INTO `parks` VALUES ('3', '25', 'Orile');
INSERT INTO `parks` VALUES ('4', '25', 'Oshodi-Charity');
INSERT INTO `parks` VALUES ('5', '25', 'Ojuelegba');
INSERT INTO `parks` VALUES ('6', '25', 'Ikotun');
INSERT INTO `parks` VALUES ('7', '25', 'Berger');
INSERT INTO `parks` VALUES ('8', '25', 'Cele');
INSERT INTO `parks` VALUES ('9', '25', 'Oshodi-Bolade');
INSERT INTO `parks` VALUES ('10', '1', 'Iba');
INSERT INTO `parks` VALUES ('11', '25', 'Iyana Ipaja');
INSERT INTO `parks` VALUES ('12', '1', 'Volks');
INSERT INTO `parks` VALUES ('13', '25', 'Yaba');
INSERT INTO `parks` VALUES ('14', '25', 'Ajah');
INSERT INTO `parks` VALUES ('15', '25', 'Festac Gate');
INSERT INTO `parks` VALUES ('16', '3', 'Holy ghost');
INSERT INTO `parks` VALUES ('17', '3', 'Nsukka');

-- ----------------------------
-- Table structure for `park_map`
-- ----------------------------
DROP TABLE IF EXISTS `park_map`;
CREATE TABLE `park_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `origin` varchar(30) NOT NULL,
  `destination` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `origin` (`origin`) USING BTREE,
  KEY `destination` (`destination`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of park_map
-- ----------------------------
INSERT INTO `park_map` VALUES ('1', '1', '16', '1');
INSERT INTO `park_map` VALUES ('2', '1', '17', '1');
INSERT INTO `park_map` VALUES ('3', '14', '17', '1');
INSERT INTO `park_map` VALUES ('4', '14', '16', '1');

-- ----------------------------
-- Table structure for `reports`
-- ----------------------------
DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) NOT NULL,
  `report_date` date NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of reports
-- ----------------------------
INSERT INTO `reports` VALUES ('2', '/home/autostar/public_html/reports/Daily-report-for-27-Jul-2015.xlsx', '2015-07-27', '2015-08-09 12:25:28');

-- ----------------------------
-- Table structure for `routes`
-- ----------------------------
DROP TABLE IF EXISTS `routes`;
CREATE TABLE `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `origin` varchar(30) NOT NULL,
  `destination` varchar(30) NOT NULL,
  `route` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `origin` (`origin`) USING BTREE,
  KEY `destination` (`destination`) USING BTREE,
  FULLTEXT KEY `route` (`route`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of routes
-- ----------------------------
INSERT INTO `routes` VALUES ('1', 'Enugu', 'Lagos', 'Enugu - Lagos', '1');
INSERT INTO `routes` VALUES ('26', 'Enugu', 'Abuja', 'Enugu - Abuja', '1');
INSERT INTO `routes` VALUES ('14', 'Lagos', 'Enugu', 'Lagos - Enugu', '1');
INSERT INTO `routes` VALUES ('29', 'Lagos', 'Abuja', 'Lagos - Abuja', '1');
INSERT INTO `routes` VALUES ('31', 'Lagos', 'PortHarcourt', 'Lagos - PortHarcourt', '1');
INSERT INTO `routes` VALUES ('32', 'Lagos', 'Delta', 'Lagos - Delta', '1');
INSERT INTO `routes` VALUES ('57', 'Abuja', 'Enugu', 'Abuja - Enugu', '1');
INSERT INTO `routes` VALUES ('56', 'Delta', 'Abuja', 'Delta - Abuja', '1');
INSERT INTO `routes` VALUES ('55', 'Abuja', 'Lagos', 'Abuja - Lagos', '1');
INSERT INTO `routes` VALUES ('54', 'Delta', 'Lagos', 'Delta - Lagos', '1');
INSERT INTO `routes` VALUES ('53', 'PortHarcourt', 'Abuja', 'PortHarcourt - Abuja', '1');
INSERT INTO `routes` VALUES ('52', 'PortHarcourt', 'Lagos', 'PortHarcourt - Lagos', '1');
INSERT INTO `routes` VALUES ('59', 'Abia', 'Jigawa', 'Abia - Jigawa', '0');

-- ----------------------------
-- Table structure for `states`
-- ----------------------------
DROP TABLE IF EXISTS `states`;
CREATE TABLE `states` (
  `id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of states
-- ----------------------------
INSERT INTO `states` VALUES ('1', 'Abuja');
INSERT INTO `states` VALUES ('2', 'Anambra');
INSERT INTO `states` VALUES ('3', 'Enugu');
INSERT INTO `states` VALUES ('4', 'Akwa Ibom');
INSERT INTO `states` VALUES ('5', 'Adamawa');
INSERT INTO `states` VALUES ('6', 'Abia');
INSERT INTO `states` VALUES ('7', 'Bauchi');
INSERT INTO `states` VALUES ('8', 'Bayelsa');
INSERT INTO `states` VALUES ('9', 'Benue');
INSERT INTO `states` VALUES ('10', 'Borno');
INSERT INTO `states` VALUES ('11', 'Cross River');
INSERT INTO `states` VALUES ('12', 'Delta');
INSERT INTO `states` VALUES ('13', 'Ebonyi');
INSERT INTO `states` VALUES ('14', 'Edo');
INSERT INTO `states` VALUES ('15', 'Ekiti');
INSERT INTO `states` VALUES ('16', 'Gombe');
INSERT INTO `states` VALUES ('17', 'Imo');
INSERT INTO `states` VALUES ('18', 'Jigawa');
INSERT INTO `states` VALUES ('19', 'Kaduna');
INSERT INTO `states` VALUES ('20', 'Kano');
INSERT INTO `states` VALUES ('21', 'Katsina');
INSERT INTO `states` VALUES ('22', 'Kebbi');
INSERT INTO `states` VALUES ('23', 'Kogi');
INSERT INTO `states` VALUES ('24', 'Kwara');
INSERT INTO `states` VALUES ('25', 'Lagos');
INSERT INTO `states` VALUES ('26', 'Nasarawa');
INSERT INTO `states` VALUES ('27', 'Niger');
INSERT INTO `states` VALUES ('28', 'Ogun');
INSERT INTO `states` VALUES ('29', 'Ondo');
INSERT INTO `states` VALUES ('30', 'Osun');
INSERT INTO `states` VALUES ('31', 'Oyo');
INSERT INTO `states` VALUES ('32', 'Plateau');
INSERT INTO `states` VALUES ('33', 'Rivers');
INSERT INTO `states` VALUES ('34', 'Sokoto');
INSERT INTO `states` VALUES ('35', 'Taraba');
INSERT INTO `states` VALUES ('36', 'Yobe');
INSERT INTO `states` VALUES ('37', 'Zamfara');

-- ----------------------------
-- Table structure for `states_towns`
-- ----------------------------
DROP TABLE IF EXISTS `states_towns`;
CREATE TABLE `states_towns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of states_towns
-- ----------------------------
INSERT INTO `states_towns` VALUES ('1', 'Lagos', '2010-12-03 09:45:43');
INSERT INTO `states_towns` VALUES ('2', 'Enugu', '2010-12-03 09:45:51');
INSERT INTO `states_towns` VALUES ('39', 'Benin', '2013-08-12 14:04:59');
INSERT INTO `states_towns` VALUES ('15', 'Abakaliki', '2013-06-01 21:29:22');
INSERT INTO `states_towns` VALUES ('16', 'Aba', '2012-08-18 13:08:14');
INSERT INTO `states_towns` VALUES ('17', 'Owerri', '2012-08-18 13:08:14');
INSERT INTO `states_towns` VALUES ('18', 'Onitsha', '2012-08-18 13:08:14');
INSERT INTO `states_towns` VALUES ('19', 'Abuja', '2012-08-18 13:08:14');
INSERT INTO `states_towns` VALUES ('20', 'Port Hacourt', '2013-06-02 05:28:11');
INSERT INTO `states_towns` VALUES ('21', 'Nsukka', '2012-08-18 13:08:14');
INSERT INTO `states_towns` VALUES ('42', 'Uyo', '2013-11-25 00:35:17');
INSERT INTO `states_towns` VALUES ('41', 'Kogi', '2013-11-25 00:34:48');
INSERT INTO `states_towns` VALUES ('4', 'Bayelsa', '2013-08-18 13:00:38');
INSERT INTO `states_towns` VALUES ('40', 'Calabar', '2013-11-25 00:34:48');
INSERT INTO `states_towns` VALUES ('26', 'Kaduna', '2012-10-21 22:52:42');
INSERT INTO `states_towns` VALUES ('37', 'Umuahia', '2013-08-06 21:51:12');
INSERT INTO `states_towns` VALUES ('31', 'Enugu-Ezike', '2013-06-01 21:30:08');
INSERT INTO `states_towns` VALUES ('33', 'Asaba', '2012-12-02 16:40:55');
INSERT INTO `states_towns` VALUES ('3', 'Warri', '2013-08-18 13:00:38');
INSERT INTO `states_towns` VALUES ('43', 'Jos', '2013-11-25 00:35:17');
INSERT INTO `states_towns` VALUES ('44', 'Ibadan', '2013-11-25 01:15:22');
INSERT INTO `states_towns` VALUES ('45', 'Abia', '2014-02-20 11:57:47');
INSERT INTO `states_towns` VALUES ('46', 'Akwa Ibom', '2014-02-20 11:57:47');
INSERT INTO `states_towns` VALUES ('47', 'Cross River', '2014-02-20 12:00:09');
INSERT INTO `states_towns` VALUES ('48', 'Ebony', '2014-02-20 12:00:09');
INSERT INTO `states_towns` VALUES ('49', 'Delta', '2014-02-20 12:00:09');
INSERT INTO `states_towns` VALUES ('50', 'Imo', '2014-02-20 12:00:09');
INSERT INTO `states_towns` VALUES ('51', 'Benue', '2014-02-20 12:00:09');
INSERT INTO `states_towns` VALUES ('52', 'Niger', '2014-02-20 12:00:37');
INSERT INTO `states_towns` VALUES ('53', 'Osun', '2014-02-20 12:00:37');
INSERT INTO `states_towns` VALUES ('54', 'Edo', '2014-02-20 12:01:06');
INSERT INTO `states_towns` VALUES ('55', 'Anambra', '2014-02-20 12:23:36');

-- ----------------------------
-- Table structure for `travels`
-- ----------------------------
DROP TABLE IF EXISTS `travels`;
CREATE TABLE `travels` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(50) NOT NULL,
  `offline_charge` varchar(6) NOT NULL,
  `online_charge` varchar(6) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_name` (`company_name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of travels
-- ----------------------------
INSERT INTO `travels` VALUES ('4', 'Ekene', '10', '10', '2015-10-30 05:33:01', '0');
INSERT INTO `travels` VALUES ('5', 'Ifesinachi', '5', '10', '2015-11-02 00:08:48', '0');

-- ----------------------------
-- Table structure for `travel_admins`
-- ----------------------------
DROP TABLE IF EXISTS `travel_admins`;
CREATE TABLE `travel_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `travel_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of travel_admins
-- ----------------------------
INSERT INTO `travel_admins` VALUES ('1', '4', '6');
INSERT INTO `travel_admins` VALUES ('2', '4', '7');
INSERT INTO `travel_admins` VALUES ('3', '4', '8');
INSERT INTO `travel_admins` VALUES ('6', '4', '12');
INSERT INTO `travel_admins` VALUES ('13', '4', '19');
INSERT INTO `travel_admins` VALUES ('17', '4', '24');
INSERT INTO `travel_admins` VALUES ('18', '4', '25');
INSERT INTO `travel_admins` VALUES ('19', '4', '26');

-- ----------------------------
-- Table structure for `travel_park`
-- ----------------------------
DROP TABLE IF EXISTS `travel_park`;
CREATE TABLE `travel_park` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `travel_id` int(11) NOT NULL,
  `park_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `travel_id` (`travel_id`,`park_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of travel_park
-- ----------------------------
INSERT INTO `travel_park` VALUES ('1', '4', '1', '24');
INSERT INTO `travel_park` VALUES ('2', '4', '14', '25');
INSERT INTO `travel_park` VALUES ('3', '4', '2', '26');

-- ----------------------------
-- Table structure for `travel_park_map`
-- ----------------------------
DROP TABLE IF EXISTS `travel_park_map`;
CREATE TABLE `travel_park_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `travel_id` smallint(6) NOT NULL,
  `park_map_id` smallint(6) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `travel_id` (`travel_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of travel_park_map
-- ----------------------------
INSERT INTO `travel_park_map` VALUES ('1', '4', '1', '0', '2015-11-06 01:24:16');
INSERT INTO `travel_park_map` VALUES ('2', '4', '2', '0', '2015-11-06 01:41:35');
INSERT INTO `travel_park_map` VALUES ('3', '4', '3', '0', '2015-11-06 01:43:40');
INSERT INTO `travel_park_map` VALUES ('4', '4', '4', '0', '2015-11-06 01:45:05');

-- ----------------------------
-- Table structure for `travel_routes`
-- ----------------------------
DROP TABLE IF EXISTS `travel_routes`;
CREATE TABLE `travel_routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `travel_id` smallint(6) NOT NULL,
  `route_id` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `travel_id` (`travel_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of travel_routes
-- ----------------------------

-- ----------------------------
-- Table structure for `travel_state`
-- ----------------------------
DROP TABLE IF EXISTS `travel_state`;
CREATE TABLE `travel_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `travel_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `travel_id` (`travel_id`,`state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of travel_state
-- ----------------------------
INSERT INTO `travel_state` VALUES ('4', '4', '16', '12');
INSERT INTO `travel_state` VALUES ('11', '4', '25', '19');

-- ----------------------------
-- Table structure for `travel_vehicle_types`
-- ----------------------------
DROP TABLE IF EXISTS `travel_vehicle_types`;
CREATE TABLE `travel_vehicle_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `travel_id` int(11) NOT NULL,
  `vehicle_name` varchar(20) NOT NULL,
  `vehicle_type_id` tinyint(4) NOT NULL,
  `amenities` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 for active, 0 for inactive',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `travel_id` (`travel_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of travel_vehicle_types
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(70) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` char(64) NOT NULL,
  `salt` char(32) NOT NULL,
  `user_type` varchar(15) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Chibuzo', 'chibuzo', '8185569fe5f5f34bd48bcdf3155f570297b96928d443ebec7d3c1626536fc318', 'vFF+q6x+1ceEWmVvhlCgELhzhPJqc0pC', 'admin', '2015-01-09 13:25:49', '0');
INSERT INTO `users` VALUES ('2', 'Njideka Onu', 'onu', '82cc406d16a8f3011f3921939fce857a86503f3a866df9e2a5758cc9701dc2c4', 'nJlZfWOzxdBRPCC5LxnBzv6FYK2QnogC', 'Operator', '2015-01-09 13:43:13', '1');
INSERT INTO `users` VALUES ('3', 'Okpeke Admin', 'okpo', 'dfa8617b02c9d168c793c64528521f8f6ac3120492541e5407f7acc2870c20cb', '2q2SKQMAAq3VdZqbK+NOKQu56RDCcWl/', 'user', '2015-09-15 15:43:23', '1');
INSERT INTO `users` VALUES ('4', 'amaka', 'amaka', '6ab0034f44a8f3fc92c2c9259133bfec8d581037cd36db30fc72bcb3d1bed9f6', 'X5AWxXtEqactoQH+DrjSuBfk4tZRyZZR', 'account', '2015-03-06 18:57:15', '0');
INSERT INTO `users` VALUES ('5', 'Administrator', 'admin', '34d9b4b876b7bda4e21a078ec6ddaa8f6379e4bde47009db722c82466988cdd1', 'izL6onBroshZLfM85Vrb1ZqEH+BuIRGi', 'user', '2015-03-27 13:00:46', '0');
INSERT INTO `users` VALUES ('6', 'Iroegbu Iroegbu', 'iroegbu', '648fbd2a1cc291edb8a1f7fee439d4fd63e6d470335ecce975ae0440cfb6f8a8', 'SLQbO/M3AgXsP80g4w/LQqEpG5fQ8O5w', 'travel_admin', '2015-10-31 17:18:50', '0');
INSERT INTO `users` VALUES ('7', 'Pelumi', 'pelu', '6ba0345fa0dfb195e0be52dfb0d2ead435c1f0a4d0b369e70c42daf13a9507e9', 'mEpDVw91QNhMkITN78Ge6RDQ7DR7ilQp', 'travel_admin', '2015-10-31 17:37:06', '0');
INSERT INTO `users` VALUES ('8', 'Chioma Amobi', 'chioma', 'a9b406e042798333f05e9856f8007eed7fe6ee62e390fc650121dbf6e8c3e5c7', 'lBBIrp9cvP4c/KcCqyh4mOP8V7WcUBez', 'travel_admin', '2015-10-31 17:43:13', '0');
INSERT INTO `users` VALUES ('12', 'Aproko AprokoName', 'aproko', '8af34d1d0c4f28cb65dc0b9d63a2b42c1a452339c0e763f42b83d313c07de022', 'BbUHCpEa0v3zdt/P/iFGjDvmpmRQjVsi', 'state_admin', '2015-11-02 22:45:50', '0');
INSERT INTO `users` VALUES ('24', 'Okolo Uzo', 'okoloc', 'f44c0263ddf60765eeeed2b26152d02562ace000f8727c1f177a8f8d21df0d14', '8tE5BGSybCMOezCmDVdGA78lcgtWq+0C', 'park_admin', '2015-11-03 01:15:11', '0');
INSERT INTO `users` VALUES ('19', 'Adesuwa Okpefa', 'okpefa', 'af36c1cff6d5eec594d9071f10022513539416e656cde383922c87dcad43e1a0', '5kCa9idNn9VKN/9TzNrdUoMxgI0LCquL', 'state_admin', '2015-11-02 22:45:47', '0');
INSERT INTO `users` VALUES ('25', 'Augustine Ogwo', 'ogwo', '9e685dad18b5d9da472d85a4b9611105ae8c580f1ba88177a9940f7a26268ff8', 'oYn9dLq7X0w3pckhFU3E2gr8Nj3Tu5ct', 'park_admin', '2015-11-03 01:17:19', '0');
INSERT INTO `users` VALUES ('26', 'Chike UserFullName', 'chike', '76db376ca24afc11fd3d8a336917fada8d0d58fcb87a892b7a6d7ec9cf13d24f', 'Tn+vJ9gSH/bRaocs2ISsVgfCb1huczj3', 'park_admin', '2015-11-05 16:06:04', '0');

-- ----------------------------
-- Table structure for `vehicle_types`
-- ----------------------------
DROP TABLE IF EXISTS `vehicle_types`;
CREATE TABLE `vehicle_types` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `num_of_seats` tinyint(2) NOT NULL,
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of vehicle_types
-- ----------------------------
INSERT INTO `vehicle_types` VALUES ('1', 'Regular Sienna', '5', '0');
INSERT INTO `vehicle_types` VALUES ('2', 'Car', '3', '0');
INSERT INTO `vehicle_types` VALUES ('3', 'Toyota Bus', '10', '0');
INSERT INTO `vehicle_types` VALUES ('4', 'Coaster Bus', '19', '0');
INSERT INTO `vehicle_types` VALUES ('5', 'A motor', '75', '0');
INSERT INTO `vehicle_types` VALUES ('6', 'gos', '7', '1');
INSERT INTO `vehicle_types` VALUES ('7', 'Executive Sienna', '5', '0');
INSERT INTO `vehicle_types` VALUES ('8', 'Hiace', '16', '0');
INSERT INTO `vehicle_types` VALUES ('9', 'Hummer', '6', '1');
