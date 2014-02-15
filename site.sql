/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : site

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-02-15 15:17:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for osw_settings
-- ----------------------------
DROP TABLE IF EXISTS `osw_settings`;
CREATE TABLE `osw_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osw_settings
-- ----------------------------
INSERT INTO `osw_settings` VALUES ('1', 'redirect_type', '1');
INSERT INTO `osw_settings` VALUES ('2', 'robust_db', 'opensim');
INSERT INTO `osw_settings` VALUES ('3', 'group_db', 'opensim');
INSERT INTO `osw_settings` VALUES ('4', 'profile_db', 'osmodules');
INSERT INTO `osw_settings` VALUES ('5', 'webassetURI', 'localhost/webasset');
INSERT INTO `osw_settings` VALUES ('6', 'GridName', 'Local Grid');
