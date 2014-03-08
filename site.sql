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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osw_forum_topic
-- ----------------------------
INSERT INTO `osw_forum_topic` VALUES ('1', '1', 'Test topic', 'Test message', '1392913592', null);

-- ----------------------------
-- Table structure for osw_market_category
-- ----------------------------
DROP TABLE IF EXISTS `osw_market_category`;
CREATE TABLE `osw_market_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `childof` varchar(255) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osw_market_category
-- ----------------------------
INSERT INTO `osw_market_category` VALUES ('1', 'Animals', 'none');
INSERT INTO `osw_market_category` VALUES ('2', 'Animations', 'none');
INSERT INTO `osw_market_category` VALUES ('3', 'Apparel', 'none');
INSERT INTO `osw_market_category` VALUES ('4', 'Art', 'none');
INSERT INTO `osw_market_category` VALUES ('5', 'Audio & Video', 'none');
INSERT INTO `osw_market_category` VALUES ('6', 'Avi Accessories', 'none');
INSERT INTO `osw_market_category` VALUES ('7', 'Avi Appearance', 'none');
INSERT INTO `osw_market_category` VALUES ('8', 'Avi Components', 'none');
INSERT INTO `osw_market_category` VALUES ('9', 'Breedables', 'none');
INSERT INTO `osw_market_category` VALUES ('10', 'Building Components', 'none');
INSERT INTO `osw_market_category` VALUES ('11', 'Building Structures', 'none');
INSERT INTO `osw_market_category` VALUES ('12', 'Business', 'none');
INSERT INTO `osw_market_category` VALUES ('13', 'Celebrations', 'none');
INSERT INTO `osw_market_category` VALUES ('14', 'Gadgets', 'none');
INSERT INTO `osw_market_category` VALUES ('15', 'Home & Garden', 'none');
INSERT INTO `osw_market_category` VALUES ('16', 'Misc', 'none');
INSERT INTO `osw_market_category` VALUES ('17', 'Scripts', 'none');
INSERT INTO `osw_market_category` VALUES ('18', 'Services', 'none');
INSERT INTO `osw_market_category` VALUES ('19', 'Vehicles', 'none');
INSERT INTO `osw_market_category` VALUES ('20', 'Weapons', 'none');
INSERT INTO `osw_market_category` VALUES ('21', 'Explosives', 'Weapons');
INSERT INTO `osw_market_category` VALUES ('22', 'Handguns', 'Weapons');
INSERT INTO `osw_market_category` VALUES ('23', 'Melee', 'Weapons');
INSERT INTO `osw_market_category` VALUES ('24', 'Non-Scripted', 'Weapons');
INSERT INTO `osw_market_category` VALUES ('25', 'Other', 'Weapons');
INSERT INTO `osw_market_category` VALUES ('26', 'Ranged', 'Weapons');
INSERT INTO `osw_market_category` VALUES ('27', 'Shields', 'Weapons');

-- ----------------------------
-- Table structure for osw_market_drop_box
-- ----------------------------
DROP TABLE IF EXISTS `osw_market_drop_box`;
CREATE TABLE `osw_market_drop_box` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(255) NOT NULL,
  `ownerkey` varchar(255) DEFAULT NULL,
  `primkey` varchar(255) NOT NULL,
  `sim` varchar(255) NOT NULL,
  `pos` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osw_market_drop_box
-- ----------------------------

-- ----------------------------
-- Table structure for osw_market_drop_box_items
-- ----------------------------
DROP TABLE IF EXISTS `osw_market_drop_box_items`;
CREATE TABLE `osw_market_drop_box_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(255) NOT NULL,
  `ownerkey` varchar(255) DEFAULT NULL,
  `boxid` varchar(255) NOT NULL,
  `primkey` varchar(255) NOT NULL,
  `itemname` varchar(255) NOT NULL,
  `itemtype` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osw_market_drop_box_items
-- ----------------------------

-- ----------------------------
-- Table structure for osw_market_products
-- ----------------------------
DROP TABLE IF EXISTS `osw_market_products`;
CREATE TABLE `osw_market_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` varchar(255) DEFAULT NULL,
  `cat` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `info` longtext,
  `features` longtext,
  `img` varchar(255) DEFAULT NULL,
  `other_imgs` varchar(255) DEFAULT NULL,
  `seller` varchar(255) DEFAULT NULL,
  `sales` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `permissions` char(8) DEFAULT NULL,
  `version` char(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osw_market_products
-- ----------------------------
INSERT INTO `osw_market_products` VALUES ('1', '1', 'Weapons', 'Your mom', 'This gun is a test of my powerful smite', 'Fart-o-matic, Stink Launcher, Poop exploder', '', 'shit, fuck', 'Christina Vortex', '69', '666', 'C, M', '1');

-- ----------------------------
-- Table structure for osw_sessions
-- ----------------------------
DROP TABLE IF EXISTS `osw_sessions`;
CREATE TABLE `osw_sessions` (
  `id` varchar(11) NOT NULL,
  `code` varchar(25) NOT NULL,
  `time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

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
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osw_settings
-- ----------------------------
INSERT INTO `osw_settings` VALUES ('1', 'robust_db', 'vtgrid');
INSERT INTO `osw_settings` VALUES ('2', 'group_db', 'vtgrid');
INSERT INTO `osw_settings` VALUES ('3', 'profile_db', 'vtgrid');
INSERT INTO `osw_settings` VALUES ('4', 'webassetURI', 'localhost/webasset');
INSERT INTO `osw_settings` VALUES ('5', 'GridName', 'Local Grid');
INSERT INTO `osw_settings` VALUES ('6', 'SiteAddress', 'http://localhost');
INSERT INTO `osw_settings` VALUES ('7', 'loginURI', '127.0.0.1:9000');
INSERT INTO `osw_settings` VALUES ('8', 'GridNick', 'LG');
INSERT INTO `osw_settings` VALUES ('9', 'GridEmail', '@prims.localhost');
INSERT INTO `osw_settings` VALUES ('10', 'GridMoney', 'OS$');
INSERT INTO `osw_settings` VALUES ('11', 'cookie_prefix', 'osw');
INSERT INTO `osw_settings` VALUES ('12', 'cookie_length', '1209600');
INSERT INTO `osw_settings` VALUES ('13', 'cookie_path', '/');
INSERT INTO `osw_settings` VALUES ('14', 'cookie_domain', 'localhost');
INSERT INTO `osw_settings` VALUES ('15', 'logout_redirect', 'index.php');
INSERT INTO `osw_settings` VALUES ('16', 'activation_type', '1');
INSERT INTO `osw_settings` VALUES ('17', 'security_image', 'no');
INSERT INTO `osw_settings` VALUES ('18', 'redirect_type', '1');
INSERT INTO `osw_settings` VALUES ('19', 'max_password', '15');
INSERT INTO `osw_settings` VALUES ('20', 'min_password', '6');
INSERT INTO `osw_settings` VALUES ('21', 'Style', 'Default');
INSERT INTO `osw_settings` VALUES ('22', 'Banner', null);
INSERT INTO `osw_settings` VALUES ('23', 'Logo', null);
INSERT INTO `osw_settings` VALUES ('24', 'search_db', 'vtgrid');
INSERT INTO `osw_settings` VALUES ('25', 'Twitter', 'Chrisx84');
INSERT INTO `osw_settings` VALUES ('26', 'Facebook', null);
INSERT INTO `osw_settings` VALUES ('27', 'min_sales_2b_featured', '10000');

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
  `online` char(3) DEFAULT 'no',
  `last_login` varchar(255) DEFAULT NULL,
  `last_session` varchar(255) DEFAULT NULL,
  `last_action` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osw_users
-- ----------------------------
INSERT INTO `osw_users` VALUES ('1', '6551271e-fee0-4054-829f-de71252cae93', 'Admin', '4ac0575c39a0ce5d3c6550471a2fbc4c', '', null, null, 'no', 'yes', null, 'yes', '', '', '');
INSERT INTO `osw_users` VALUES ('2', '6551271e-fee0-4054-829f-de71252cae93', 'Chrisx84', '11206322662490d8ed6fa7110d34966c', 'xPkwMFhE5n', null, null, 'no', 'yes', null, 'yes', '1394308187', '1394308195', '1394308195');