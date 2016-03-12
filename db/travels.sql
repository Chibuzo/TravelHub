/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 50625
Source Host           : localhost:3306
Source Database       : travelhub

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2016-03-12 17:12:31
*/

SET FOREIGN_KEY_CHECKS=0;

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
  `account_number` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_name` (`company_name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of travels
-- ----------------------------
INSERT INTO `travels` VALUES ('4', 'Ekene', '8', '11', '2015-10-30 05:33:01', '0', '');
INSERT INTO `travels` VALUES ('5', 'Ifesinachi', '5', '10', '2015-11-02 00:08:48', '0', '3265652312');
INSERT INTO `travels` VALUES ('6', 'Test Travel', '5', '4', '2016-03-12 16:56:17', '0', '0123450000');
