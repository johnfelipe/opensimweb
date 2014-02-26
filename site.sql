/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : site

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-02-26 11:14:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for osw_forum_board
-- ----------------------------
DROP TABLE IF EXISTS `osw_forum_board`;
CREATE TABLE `osw_forum_board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` varchar(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `sort` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osw_forum_board
-- ----------------------------
INSERT INTO `osw_forum_board` VALUES ('1', '1', 'Test', 'test board', '0');

-- ----------------------------
-- Table structure for osw_forum_cat
-- ----------------------------
DROP TABLE IF EXISTS `osw_forum_cat`;
CREATE TABLE `osw_forum_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `sort` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osw_forum_cat
-- ----------------------------
INSERT INTO `osw_forum_cat` VALUES ('1', 'Test cat', '0');

-- ----------------------------
-- Table structure for osw_forum_replies
-- ----------------------------
DROP TABLE IF EXISTS `osw_forum_replies`;
CREATE TABLE `osw_forum_replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `board_id` varchar(11) NOT NULL,
  `topic_id` varchar(11) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `message` longtext,
  `time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osw_forum_replies
-- ----------------------------

-- ----------------------------
-- Table structure for osw_forum_topic
-- ----------------------------
DROP TABLE IF EXISTS `osw_forum_topic`;
CREATE TABLE `osw_forum_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `board_id` varchar(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` longtext,
  `time` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osw_forum_topic
-- ----------------------------
INSERT INTO `osw_forum_topic` VALUES ('1', '1', 'Test topic', 'Test message', '1392913592', null);

-- ----------------------------
-- Table structure for osw_sessions
-- ----------------------------
DROP TABLE IF EXISTS `osw_sessions`;
CREATE TABLE `osw_sessions` (
  `id` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osw_sessions
-- ----------------------------

-- ----------------------------
-- Table structure for osw_settings
-- ----------------------------
DROP TABLE IF EXISTS `osw_settings`;
CREATE TABLE `osw_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osw_settings
-- ----------------------------
INSERT INTO `osw_settings` VALUES ('1', 'redirect_type', '1');
INSERT INTO `osw_settings` VALUES ('2', 'robust_db', 'opensim');
INSERT INTO `osw_settings` VALUES ('3', 'group_db', 'opensim');
INSERT INTO `osw_settings` VALUES ('4', 'profile_db', 'osmodules');
INSERT INTO `osw_settings` VALUES ('5', 'webassetURI', 'localhost/webasset');
INSERT INTO `osw_settings` VALUES ('6', 'GridName', 'Local Grid');
INSERT INTO `osw_settings` VALUES ('7', 'SiteAddress', 'http://localhost:81');
INSERT INTO `osw_settings` VALUES ('8', 'cookie_prefix', 'osw');
INSERT INTO `osw_settings` VALUES ('9', 'cookie_length', '10');
INSERT INTO `osw_settings` VALUES ('10', 'cookie_path', '/');
INSERT INTO `osw_settings` VALUES ('11', 'Style', 'Default');
INSERT INTO `osw_settings` VALUES ('12', 'Banner', null);
INSERT INTO `osw_settings` VALUES ('13', 'Logo', null);
INSERT INTO `osw_settings` VALUES ('14', 'search_db', 'osmodules');

-- ----------------------------
-- Table structure for osw_users
-- ----------------------------
DROP TABLE IF EXISTS `osw_users`;
CREATE TABLE `osw_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PrincipalID` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `display` varchar(255) DEFAULT NULL,
  `blocked` char(3) DEFAULT NULL,
  `active` char(3) DEFAULT NULL,
  `style` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`PrincipalID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osw_users
-- ----------------------------
