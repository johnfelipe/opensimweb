CREATE TABLE IF NOT EXISTS `profile_classifieds` 
(
 
`classifieduuid` char(36) NOT NULL,
  `creatoruuid` char(36) NOT NULL,
 
`creationdate` int(20) NOT NULL,
  `expirationdate` int(20) NOT NULL,
 
`category` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
 
`description` text NOT NULL,
  `parceluuid` char(36) NOT NULL,
 
`parentestate` int(11) NOT NULL,
  `snapshotuuid` char(36) NOT NULL,
 
`simname` varchar(255) NOT NULL,
  `posglobal` varchar(255) NOT NULL,
 
`parcelname` varchar(255) NOT NULL,
  `classifiedflags` int(8) NOT NULL,
 
`priceforlisting` int(5) NOT NULL,
  PRIMARY KEY (`classifieduuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 
 
 
CREATE TABLE IF NOT EXISTS `profile_notes` (
 
`useruuid` varchar(36) NOT NULL,
 
`targetuuid` varchar(36) NOT NULL,
 
`notes` text NOT NULL,
  UNIQUE KEY `useruuid` (`useruuid`,`targetuuid`)
)
 ENGINE=MyISAM DEFAULT CHARSET=utf8;
 
 
 
CREATE TABLE IF NOT EXISTS `profile_picks` (
 
`pickuuid` varchar(36) NOT NULL,
  `creatoruuid` varchar(36) NOT NULL,
 
`toppick` enum('true','false') NOT NULL,
  `parceluuid` varchar(36) NOT NULL,
 
`name` varchar(255) NOT NULL,
 
`description` text NOT NULL,
 
`snapshotuuid` varchar(36) NOT NULL,
 
`user` varchar(255) NOT NULL,
 
`originalname` varchar(255) NOT NULL,
 
`simname` varchar(255) NOT NULL,
 
`posglobal` varchar(255) NOT NULL,
 
`sortorder` int(2) NOT NULL,
 
`enabled` enum('true','false') NOT NULL,
  PRIMARY KEY (`pickuuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 
 
 
CREATE TABLE IF NOT EXISTS `profile` (
 
`useruuid` varchar(36) NOT NULL,
 
`profilePartner` varchar(36) NOT NULL,
 
`profileAllowPublish` BINARY(1) NOT NULL,
 
`profileMaturePublish` BINARY(1) NOT NULL,
 
`profileURL` varchar(255) NOT NULL,
 
`profileWantToMask` int(3) NOT NULL,
 
`profileWantToText` text NOT NULL,
 
`profileSkillsMask` int(3) NOT NULL,
 
`profileSkillsText` text NOT NULL,
 
`profileLanguages` text NOT NULL,
 
`profileImage` varchar(36) NOT NULL,
 
`profileAboutText` text NOT NULL,
 
`profileFirstImage` varchar(36) NOT NULL,
 
`profileFirstText` text NOT NULL,
  PRIMARY KEY (`useruuid`)
) 
ENGINE=MyISAM DEFAULT CHARSET=utf8;
 
 
CREATE TABLE IF NOT EXISTS `profile_settings` (
 
`useruuid` varchar(36) NOT NULL,
 
`imviaemail` enum('true','false') NOT NULL,
 
`visible` enum('true','false') NOT NULL,
 
`email` varchar(254) NOT NULL,
  PRIMARY KEY (`useruuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;