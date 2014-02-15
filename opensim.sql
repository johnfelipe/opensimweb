/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50614
Source Host           : localhost:3306
Source Database       : opensim

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2014-02-04 13:56:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for assets
-- ----------------------------
DROP TABLE IF EXISTS `assets`;
CREATE TABLE `assets` (
  `name` varchar(64) NOT NULL,
  `description` varchar(64) NOT NULL,
  `assetType` tinyint(4) NOT NULL,
  `local` tinyint(1) NOT NULL,
  `temporary` tinyint(1) NOT NULL,
  `data` longblob NOT NULL,
  `id` char(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `create_time` int(11) DEFAULT '0',
  `access_time` int(11) DEFAULT '0',
  `asset_flags` int(11) NOT NULL DEFAULT '0',
  `CreatorID` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Rev. 1';

-- ----------------------------
-- Table structure for auth
-- ----------------------------
DROP TABLE IF EXISTS `auth`;
CREATE TABLE `auth` (
  `UUID` char(36) NOT NULL,
  `passwordHash` char(32) NOT NULL DEFAULT '',
  `passwordSalt` char(32) NOT NULL DEFAULT '',
  `webLoginKey` varchar(255) NOT NULL DEFAULT '',
  `accountType` varchar(32) NOT NULL DEFAULT 'UserAccount',
  PRIMARY KEY (`UUID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for avatars
-- ----------------------------
DROP TABLE IF EXISTS `avatars`;
CREATE TABLE `avatars` (
  `PrincipalID` char(36) NOT NULL,
  `Name` varchar(32) NOT NULL,
  `Value` text,
  PRIMARY KEY (`PrincipalID`,`Name`),
  KEY `PrincipalID` (`PrincipalID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estateban
-- ----------------------------
DROP TABLE IF EXISTS `estateban`;
CREATE TABLE `estateban` (
  `EstateID` int(10) unsigned NOT NULL,
  `bannedUUID` varchar(36) NOT NULL,
  `bannedIp` varchar(16) NOT NULL,
  `bannedIpHostMask` varchar(16) NOT NULL,
  `bannedNameMask` varchar(64) DEFAULT NULL,
  KEY `estateban_EstateID` (`EstateID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estate_groups
-- ----------------------------
DROP TABLE IF EXISTS `estate_groups`;
CREATE TABLE `estate_groups` (
  `EstateID` int(10) unsigned NOT NULL,
  `uuid` char(36) NOT NULL,
  KEY `EstateID` (`EstateID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estate_managers
-- ----------------------------
DROP TABLE IF EXISTS `estate_managers`;
CREATE TABLE `estate_managers` (
  `EstateID` int(10) unsigned NOT NULL,
  `uuid` char(36) NOT NULL,
  KEY `EstateID` (`EstateID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estate_map
-- ----------------------------
DROP TABLE IF EXISTS `estate_map`;
CREATE TABLE `estate_map` (
  `RegionID` char(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `EstateID` int(11) NOT NULL,
  PRIMARY KEY (`RegionID`),
  KEY `EstateID` (`EstateID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estate_settings
-- ----------------------------
DROP TABLE IF EXISTS `estate_settings`;
CREATE TABLE `estate_settings` (
  `EstateID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EstateName` varchar(64) DEFAULT NULL,
  `AbuseEmailToEstateOwner` tinyint(4) NOT NULL,
  `DenyAnonymous` tinyint(4) NOT NULL,
  `ResetHomeOnTeleport` tinyint(4) NOT NULL,
  `FixedSun` tinyint(4) NOT NULL,
  `DenyTransacted` tinyint(4) NOT NULL,
  `BlockDwell` tinyint(4) NOT NULL,
  `DenyIdentified` tinyint(4) NOT NULL,
  `AllowVoice` tinyint(4) NOT NULL,
  `UseGlobalTime` tinyint(4) NOT NULL,
  `PricePerMeter` int(11) NOT NULL,
  `TaxFree` tinyint(4) NOT NULL,
  `AllowDirectTeleport` tinyint(4) NOT NULL,
  `RedirectGridX` int(11) NOT NULL,
  `RedirectGridY` int(11) NOT NULL,
  `ParentEstateID` int(10) unsigned NOT NULL,
  `SunPosition` double NOT NULL,
  `EstateSkipScripts` tinyint(4) NOT NULL,
  `BillableFactor` float NOT NULL,
  `PublicAccess` tinyint(4) NOT NULL,
  `AbuseEmail` varchar(255) NOT NULL,
  `EstateOwner` varchar(36) NOT NULL,
  `DenyMinors` tinyint(4) NOT NULL,
  `AllowLandmark` tinyint(4) NOT NULL DEFAULT '1',
  `AllowParcelChanges` tinyint(4) NOT NULL DEFAULT '1',
  `AllowSetHome` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`EstateID`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estate_users
-- ----------------------------
DROP TABLE IF EXISTS `estate_users`;
CREATE TABLE `estate_users` (
  `EstateID` int(10) unsigned NOT NULL,
  `uuid` char(36) NOT NULL,
  KEY `EstateID` (`EstateID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for friends
-- ----------------------------
DROP TABLE IF EXISTS `friends`;
CREATE TABLE `friends` (
  `PrincipalID` varchar(255) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `Friend` varchar(255) NOT NULL,
  `Flags` varchar(16) NOT NULL DEFAULT '0',
  `Offered` varchar(32) NOT NULL DEFAULT '0',
  PRIMARY KEY (`PrincipalID`(36),`Friend`(36)),
  KEY `PrincipalID` (`PrincipalID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for griduser
-- ----------------------------
DROP TABLE IF EXISTS `griduser`;
CREATE TABLE `griduser` (
  `UserID` varchar(255) NOT NULL,
  `HomeRegionID` char(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `HomePosition` char(64) NOT NULL DEFAULT '<0,0,0>',
  `HomeLookAt` char(64) NOT NULL DEFAULT '<0,0,0>',
  `LastRegionID` char(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `LastPosition` char(64) NOT NULL DEFAULT '<0,0,0>',
  `LastLookAt` char(64) NOT NULL DEFAULT '<0,0,0>',
  `Online` char(5) NOT NULL DEFAULT 'false',
  `Login` char(16) NOT NULL DEFAULT '0',
  `Logout` char(16) NOT NULL DEFAULT '0',
  `TOS` char(128) DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for im_offline
-- ----------------------------
DROP TABLE IF EXISTS `im_offline`;
CREATE TABLE `im_offline` (
  `ID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `PrincipalID` char(36) NOT NULL DEFAULT '',
  `Message` text NOT NULL,
  `TMStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `PrincipalID` (`PrincipalID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for inventoryfolders
-- ----------------------------
DROP TABLE IF EXISTS `inventoryfolders`;
CREATE TABLE `inventoryfolders` (
  `folderName` varchar(64) DEFAULT NULL,
  `type` smallint(6) NOT NULL DEFAULT '0',
  `version` int(11) NOT NULL DEFAULT '0',
  `folderID` char(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `agentID` char(36) DEFAULT NULL,
  `parentFolderID` char(36) DEFAULT NULL,
  PRIMARY KEY (`folderID`),
  KEY `inventoryfolders_agentid` (`agentID`),
  KEY `inventoryfolders_parentFolderid` (`parentFolderID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for inventoryitems
-- ----------------------------
DROP TABLE IF EXISTS `inventoryitems`;
CREATE TABLE `inventoryitems` (
  `assetID` varchar(36) DEFAULT NULL,
  `assetType` int(11) DEFAULT NULL,
  `inventoryName` varchar(64) DEFAULT NULL,
  `inventoryDescription` varchar(128) DEFAULT NULL,
  `inventoryNextPermissions` int(10) unsigned DEFAULT NULL,
  `inventoryCurrentPermissions` int(10) unsigned DEFAULT NULL,
  `invType` int(11) DEFAULT NULL,
  `creatorID` varchar(255) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `inventoryBasePermissions` int(10) unsigned NOT NULL DEFAULT '0',
  `inventoryEveryOnePermissions` int(10) unsigned NOT NULL DEFAULT '0',
  `salePrice` int(11) NOT NULL DEFAULT '0',
  `saleType` tinyint(4) NOT NULL DEFAULT '0',
  `creationDate` int(11) NOT NULL DEFAULT '0',
  `groupID` varchar(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `groupOwned` tinyint(4) NOT NULL DEFAULT '0',
  `flags` int(11) unsigned NOT NULL DEFAULT '0',
  `inventoryID` char(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `avatarID` char(36) DEFAULT NULL,
  `parentFolderID` char(36) DEFAULT NULL,
  `inventoryGroupPermissions` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`inventoryID`),
  KEY `inventoryitems_avatarid` (`avatarID`),
  KEY `inventoryitems_parentFolderid` (`parentFolderID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for land
-- ----------------------------
DROP TABLE IF EXISTS `land`;
CREATE TABLE `land` (
  `UUID` varchar(255) NOT NULL,
  `RegionUUID` varchar(255) DEFAULT NULL,
  `LocalLandID` int(11) DEFAULT NULL,
  `Bitmap` longblob,
  `Name` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `OwnerUUID` varchar(255) DEFAULT NULL,
  `IsGroupOwned` int(11) DEFAULT NULL,
  `Area` int(11) DEFAULT NULL,
  `AuctionID` int(11) DEFAULT NULL,
  `Category` int(11) DEFAULT NULL,
  `ClaimDate` int(11) DEFAULT NULL,
  `ClaimPrice` int(11) DEFAULT NULL,
  `GroupUUID` varchar(255) DEFAULT NULL,
  `SalePrice` int(11) DEFAULT NULL,
  `LandStatus` int(11) DEFAULT NULL,
  `LandFlags` int(11) DEFAULT NULL,
  `LandingType` int(11) DEFAULT NULL,
  `MediaAutoScale` int(11) DEFAULT NULL,
  `MediaTextureUUID` varchar(255) DEFAULT NULL,
  `MediaURL` varchar(255) DEFAULT NULL,
  `MusicURL` varchar(255) DEFAULT NULL,
  `PassHours` float DEFAULT NULL,
  `PassPrice` int(11) DEFAULT NULL,
  `SnapshotUUID` varchar(255) DEFAULT NULL,
  `UserLocationX` float DEFAULT NULL,
  `UserLocationY` float DEFAULT NULL,
  `UserLocationZ` float DEFAULT NULL,
  `UserLookAtX` float DEFAULT NULL,
  `UserLookAtY` float DEFAULT NULL,
  `UserLookAtZ` float DEFAULT NULL,
  `AuthbuyerID` varchar(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `OtherCleanTime` int(11) NOT NULL DEFAULT '0',
  `Dwell` int(11) NOT NULL DEFAULT '0',
  `MediaType` varchar(32) NOT NULL DEFAULT 'none/none',
  `MediaDescription` varchar(255) NOT NULL DEFAULT '',
  `MediaSize` varchar(16) NOT NULL DEFAULT '0,0',
  `MediaLoop` tinyint(1) NOT NULL DEFAULT '0',
  `ObscureMusic` tinyint(1) NOT NULL DEFAULT '0',
  `ObscureMedia` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UUID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for landaccesslist
-- ----------------------------
DROP TABLE IF EXISTS `landaccesslist`;
CREATE TABLE `landaccesslist` (
  `LandUUID` varchar(255) DEFAULT NULL,
  `AccessUUID` varchar(255) DEFAULT NULL,
  `Flags` int(11) DEFAULT NULL,
  `Expires` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `name` varchar(100) DEFAULT NULL,
  `version` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for os_groups_groups
-- ----------------------------
DROP TABLE IF EXISTS `os_groups_groups`;
CREATE TABLE `os_groups_groups` (
  `GroupID` char(36) NOT NULL DEFAULT '',
  `Location` varchar(255) NOT NULL DEFAULT '',
  `Name` varchar(255) NOT NULL DEFAULT '',
  `Charter` text NOT NULL,
  `InsigniaID` char(36) NOT NULL DEFAULT '',
  `FounderID` char(36) NOT NULL DEFAULT '',
  `MembershipFee` int(11) NOT NULL DEFAULT '0',
  `OpenEnrollment` varchar(255) NOT NULL DEFAULT '',
  `ShowInList` int(4) NOT NULL DEFAULT '0',
  `AllowPublish` int(4) NOT NULL DEFAULT '0',
  `MaturePublish` int(4) NOT NULL DEFAULT '0',
  `OwnerRoleID` char(36) NOT NULL DEFAULT '',
  PRIMARY KEY (`GroupID`),
  UNIQUE KEY `Name` (`Name`),
  FULLTEXT KEY `Name_2` (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for os_groups_invites
-- ----------------------------
DROP TABLE IF EXISTS `os_groups_invites`;
CREATE TABLE `os_groups_invites` (
  `InviteID` char(36) NOT NULL DEFAULT '',
  `GroupID` char(36) NOT NULL DEFAULT '',
  `RoleID` char(36) NOT NULL DEFAULT '',
  `PrincipalID` varchar(255) NOT NULL DEFAULT '',
  `TMStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`InviteID`),
  UNIQUE KEY `PrincipalGroup` (`GroupID`,`PrincipalID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for os_groups_membership
-- ----------------------------
DROP TABLE IF EXISTS `os_groups_membership`;
CREATE TABLE `os_groups_membership` (
  `GroupID` char(36) NOT NULL DEFAULT '',
  `PrincipalID` varchar(255) NOT NULL DEFAULT '',
  `SelectedRoleID` char(36) NOT NULL DEFAULT '',
  `Contribution` int(11) NOT NULL DEFAULT '0',
  `ListInProfile` int(4) NOT NULL DEFAULT '1',
  `AcceptNotices` int(4) NOT NULL DEFAULT '1',
  `AccessToken` char(36) NOT NULL DEFAULT '',
  PRIMARY KEY (`GroupID`,`PrincipalID`),
  KEY `PrincipalID` (`PrincipalID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for os_groups_notices
-- ----------------------------
DROP TABLE IF EXISTS `os_groups_notices`;
CREATE TABLE `os_groups_notices` (
  `GroupID` char(36) NOT NULL DEFAULT '',
  `NoticeID` char(36) NOT NULL DEFAULT '',
  `TMStamp` int(10) unsigned NOT NULL DEFAULT '0',
  `FromName` varchar(255) NOT NULL DEFAULT '',
  `Subject` varchar(255) NOT NULL DEFAULT '',
  `Message` text NOT NULL,
  `HasAttachment` int(4) NOT NULL DEFAULT '0',
  `AttachmentType` int(4) NOT NULL DEFAULT '0',
  `AttachmentName` varchar(128) NOT NULL DEFAULT '',
  `AttachmentItemID` char(36) NOT NULL DEFAULT '',
  `AttachmentOwnerID` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`NoticeID`),
  KEY `GroupID` (`GroupID`),
  KEY `TMStamp` (`TMStamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for os_groups_principals
-- ----------------------------
DROP TABLE IF EXISTS `os_groups_principals`;
CREATE TABLE `os_groups_principals` (
  `PrincipalID` varchar(255) NOT NULL DEFAULT '',
  `ActiveGroupID` char(36) NOT NULL DEFAULT '',
  PRIMARY KEY (`PrincipalID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for os_groups_rolemembership
-- ----------------------------
DROP TABLE IF EXISTS `os_groups_rolemembership`;
CREATE TABLE `os_groups_rolemembership` (
  `GroupID` char(36) NOT NULL DEFAULT '',
  `RoleID` char(36) NOT NULL DEFAULT '',
  `PrincipalID` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`GroupID`,`RoleID`,`PrincipalID`),
  KEY `PrincipalID` (`PrincipalID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for os_groups_roles
-- ----------------------------
DROP TABLE IF EXISTS `os_groups_roles`;
CREATE TABLE `os_groups_roles` (
  `GroupID` char(36) NOT NULL DEFAULT '',
  `RoleID` char(36) NOT NULL DEFAULT '',
  `Name` varchar(255) NOT NULL DEFAULT '',
  `Description` varchar(255) NOT NULL DEFAULT '',
  `Title` varchar(255) NOT NULL DEFAULT '',
  `Powers` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`GroupID`,`RoleID`),
  KEY `GroupID` (`GroupID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for presence
-- ----------------------------
DROP TABLE IF EXISTS `presence`;
CREATE TABLE `presence` (
  `UserID` varchar(255) NOT NULL,
  `RegionID` char(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `SessionID` char(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `SecureSessionID` char(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `LastSeen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `SessionID` (`SessionID`),
  KEY `UserID` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for primitems
-- ----------------------------
DROP TABLE IF EXISTS `primitems`;
CREATE TABLE `primitems` (
  `invType` int(11) DEFAULT NULL,
  `assetType` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `creationDate` bigint(20) DEFAULT NULL,
  `nextPermissions` int(11) DEFAULT NULL,
  `currentPermissions` int(11) DEFAULT NULL,
  `basePermissions` int(11) DEFAULT NULL,
  `everyonePermissions` int(11) DEFAULT NULL,
  `groupPermissions` int(11) DEFAULT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  `itemID` char(36) NOT NULL DEFAULT '',
  `primID` char(36) DEFAULT NULL,
  `assetID` char(36) DEFAULT NULL,
  `parentFolderID` char(36) DEFAULT NULL,
  `CreatorID` varchar(255) NOT NULL DEFAULT '',
  `ownerID` char(36) DEFAULT NULL,
  `groupID` char(36) DEFAULT NULL,
  `lastOwnerID` char(36) DEFAULT NULL,
  PRIMARY KEY (`itemID`),
  KEY `primitems_primid` (`primID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for prims
-- ----------------------------
DROP TABLE IF EXISTS `prims`;
CREATE TABLE `prims` (
  `CreationDate` int(11) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Text` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `SitName` varchar(255) DEFAULT NULL,
  `TouchName` varchar(255) DEFAULT NULL,
  `ObjectFlags` int(11) DEFAULT NULL,
  `OwnerMask` int(11) DEFAULT NULL,
  `NextOwnerMask` int(11) DEFAULT NULL,
  `GroupMask` int(11) DEFAULT NULL,
  `EveryoneMask` int(11) DEFAULT NULL,
  `BaseMask` int(11) DEFAULT NULL,
  `PositionX` double DEFAULT NULL,
  `PositionY` double DEFAULT NULL,
  `PositionZ` double DEFAULT NULL,
  `GroupPositionX` double DEFAULT NULL,
  `GroupPositionY` double DEFAULT NULL,
  `GroupPositionZ` double DEFAULT NULL,
  `VelocityX` double DEFAULT NULL,
  `VelocityY` double DEFAULT NULL,
  `VelocityZ` double DEFAULT NULL,
  `AngularVelocityX` double DEFAULT NULL,
  `AngularVelocityY` double DEFAULT NULL,
  `AngularVelocityZ` double DEFAULT NULL,
  `AccelerationX` double DEFAULT NULL,
  `AccelerationY` double DEFAULT NULL,
  `AccelerationZ` double DEFAULT NULL,
  `RotationX` double DEFAULT NULL,
  `RotationY` double DEFAULT NULL,
  `RotationZ` double DEFAULT NULL,
  `RotationW` double DEFAULT NULL,
  `SitTargetOffsetX` double DEFAULT NULL,
  `SitTargetOffsetY` double DEFAULT NULL,
  `SitTargetOffsetZ` double DEFAULT NULL,
  `SitTargetOrientW` double DEFAULT NULL,
  `SitTargetOrientX` double DEFAULT NULL,
  `SitTargetOrientY` double DEFAULT NULL,
  `SitTargetOrientZ` double DEFAULT NULL,
  `UUID` char(36) NOT NULL DEFAULT '',
  `RegionUUID` char(36) DEFAULT NULL,
  `CreatorID` varchar(255) NOT NULL DEFAULT '',
  `OwnerID` char(36) DEFAULT NULL,
  `GroupID` char(36) DEFAULT NULL,
  `LastOwnerID` char(36) DEFAULT NULL,
  `SceneGroupID` char(36) DEFAULT NULL,
  `PayPrice` int(11) NOT NULL DEFAULT '0',
  `PayButton1` int(11) NOT NULL DEFAULT '0',
  `PayButton2` int(11) NOT NULL DEFAULT '0',
  `PayButton3` int(11) NOT NULL DEFAULT '0',
  `PayButton4` int(11) NOT NULL DEFAULT '0',
  `LoopedSound` char(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `LoopedSoundGain` double NOT NULL DEFAULT '0',
  `TextureAnimation` blob,
  `OmegaX` double NOT NULL DEFAULT '0',
  `OmegaY` double NOT NULL DEFAULT '0',
  `OmegaZ` double NOT NULL DEFAULT '0',
  `CameraEyeOffsetX` double NOT NULL DEFAULT '0',
  `CameraEyeOffsetY` double NOT NULL DEFAULT '0',
  `CameraEyeOffsetZ` double NOT NULL DEFAULT '0',
  `CameraAtOffsetX` double NOT NULL DEFAULT '0',
  `CameraAtOffsetY` double NOT NULL DEFAULT '0',
  `CameraAtOffsetZ` double NOT NULL DEFAULT '0',
  `ForceMouselook` tinyint(4) NOT NULL DEFAULT '0',
  `ScriptAccessPin` int(11) NOT NULL DEFAULT '0',
  `AllowedDrop` tinyint(4) NOT NULL DEFAULT '0',
  `DieAtEdge` tinyint(4) NOT NULL DEFAULT '0',
  `SalePrice` int(11) NOT NULL DEFAULT '10',
  `SaleType` tinyint(4) NOT NULL DEFAULT '0',
  `ColorR` int(11) NOT NULL DEFAULT '0',
  `ColorG` int(11) NOT NULL DEFAULT '0',
  `ColorB` int(11) NOT NULL DEFAULT '0',
  `ColorA` int(11) NOT NULL DEFAULT '0',
  `ParticleSystem` blob,
  `ClickAction` tinyint(4) NOT NULL DEFAULT '0',
  `Material` tinyint(4) NOT NULL DEFAULT '3',
  `CollisionSound` char(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `CollisionSoundVolume` double NOT NULL DEFAULT '0',
  `LinkNumber` int(11) NOT NULL DEFAULT '0',
  `PassTouches` tinyint(4) NOT NULL DEFAULT '0',
  `MediaURL` varchar(255) DEFAULT NULL,
  `DynAttrs` text,
  `PhysicsShapeType` tinyint(4) NOT NULL DEFAULT '0',
  `Density` double NOT NULL DEFAULT '1000',
  `GravityModifier` double NOT NULL DEFAULT '1',
  `Friction` double NOT NULL DEFAULT '0.6',
  `Restitution` double NOT NULL DEFAULT '0.5',
  `KeyframeMotion` blob,
  PRIMARY KEY (`UUID`),
  KEY `prims_regionuuid` (`RegionUUID`),
  KEY `prims_scenegroupid` (`SceneGroupID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for primshapes
-- ----------------------------
DROP TABLE IF EXISTS `primshapes`;
CREATE TABLE `primshapes` (
  `Shape` int(11) DEFAULT NULL,
  `ScaleX` double NOT NULL DEFAULT '0',
  `ScaleY` double NOT NULL DEFAULT '0',
  `ScaleZ` double NOT NULL DEFAULT '0',
  `PCode` int(11) DEFAULT NULL,
  `PathBegin` int(11) DEFAULT NULL,
  `PathEnd` int(11) DEFAULT NULL,
  `PathScaleX` int(11) DEFAULT NULL,
  `PathScaleY` int(11) DEFAULT NULL,
  `PathShearX` int(11) DEFAULT NULL,
  `PathShearY` int(11) DEFAULT NULL,
  `PathSkew` int(11) DEFAULT NULL,
  `PathCurve` int(11) DEFAULT NULL,
  `PathRadiusOffset` int(11) DEFAULT NULL,
  `PathRevolutions` int(11) DEFAULT NULL,
  `PathTaperX` int(11) DEFAULT NULL,
  `PathTaperY` int(11) DEFAULT NULL,
  `PathTwist` int(11) DEFAULT NULL,
  `PathTwistBegin` int(11) DEFAULT NULL,
  `ProfileBegin` int(11) DEFAULT NULL,
  `ProfileEnd` int(11) DEFAULT NULL,
  `ProfileCurve` int(11) DEFAULT NULL,
  `ProfileHollow` int(11) DEFAULT NULL,
  `State` int(11) DEFAULT NULL,
  `Texture` longblob,
  `ExtraParams` longblob,
  `UUID` char(36) NOT NULL DEFAULT '',
  `Media` text,
  PRIMARY KEY (`UUID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for regionban
-- ----------------------------
DROP TABLE IF EXISTS `regionban`;
CREATE TABLE `regionban` (
  `regionUUID` varchar(36) NOT NULL,
  `bannedUUID` varchar(36) NOT NULL,
  `bannedIp` varchar(16) NOT NULL,
  `bannedIpHostMask` varchar(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Rev. 1';

-- ----------------------------
-- Table structure for regionenvironment
-- ----------------------------
DROP TABLE IF EXISTS `regionenvironment`;
CREATE TABLE `regionenvironment` (
  `region_id` varchar(36) NOT NULL,
  `llsd_settings` text NOT NULL,
  PRIMARY KEY (`region_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for regionextra
-- ----------------------------
DROP TABLE IF EXISTS `regionextra`;
CREATE TABLE `regionextra` (
  `RegionID` char(36) NOT NULL,
  `Name` varchar(32) NOT NULL,
  `value` text,
  PRIMARY KEY (`RegionID`,`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for regions
-- ----------------------------
DROP TABLE IF EXISTS `regions`;
CREATE TABLE `regions` (
  `uuid` varchar(36) NOT NULL,
  `regionHandle` bigint(20) unsigned NOT NULL,
  `regionName` varchar(128) DEFAULT NULL,
  `regionRecvKey` varchar(128) DEFAULT NULL,
  `regionSendKey` varchar(128) DEFAULT NULL,
  `regionSecret` varchar(128) DEFAULT NULL,
  `regionDataURI` varchar(255) DEFAULT NULL,
  `serverIP` varchar(64) DEFAULT NULL,
  `serverPort` int(10) unsigned DEFAULT NULL,
  `serverURI` varchar(255) DEFAULT NULL,
  `locX` int(10) unsigned DEFAULT NULL,
  `locY` int(10) unsigned DEFAULT NULL,
  `locZ` int(10) unsigned DEFAULT NULL,
  `eastOverrideHandle` bigint(20) unsigned DEFAULT NULL,
  `westOverrideHandle` bigint(20) unsigned DEFAULT NULL,
  `southOverrideHandle` bigint(20) unsigned DEFAULT NULL,
  `northOverrideHandle` bigint(20) unsigned DEFAULT NULL,
  `regionAssetURI` varchar(255) DEFAULT NULL,
  `regionAssetRecvKey` varchar(128) DEFAULT NULL,
  `regionAssetSendKey` varchar(128) DEFAULT NULL,
  `regionUserURI` varchar(255) DEFAULT NULL,
  `regionUserRecvKey` varchar(128) DEFAULT NULL,
  `regionUserSendKey` varchar(128) DEFAULT NULL,
  `regionMapTexture` varchar(36) DEFAULT NULL,
  `serverHttpPort` int(10) DEFAULT NULL,
  `serverRemotingPort` int(10) DEFAULT NULL,
  `owner_uuid` varchar(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `originUUID` varchar(36) DEFAULT NULL,
  `access` int(10) unsigned DEFAULT '1',
  `ScopeID` char(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `sizeX` int(11) NOT NULL DEFAULT '0',
  `sizeY` int(11) NOT NULL DEFAULT '0',
  `flags` int(11) NOT NULL DEFAULT '0',
  `last_seen` int(11) NOT NULL DEFAULT '0',
  `PrincipalID` char(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `Token` varchar(255) NOT NULL,
  `parcelMapTexture` varchar(36) DEFAULT NULL,
  PRIMARY KEY (`uuid`),
  KEY `regionName` (`regionName`),
  KEY `regionHandle` (`regionHandle`),
  KEY `overrideHandles` (`eastOverrideHandle`,`westOverrideHandle`,`southOverrideHandle`,`northOverrideHandle`),
  KEY `ScopeID` (`ScopeID`),
  KEY `flags` (`flags`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='Rev. 3';

-- ----------------------------
-- Table structure for regionsettings
-- ----------------------------
DROP TABLE IF EXISTS `regionsettings`;
CREATE TABLE `regionsettings` (
  `regionUUID` char(36) NOT NULL,
  `block_terraform` int(11) NOT NULL,
  `block_fly` int(11) NOT NULL,
  `allow_damage` int(11) NOT NULL,
  `restrict_pushing` int(11) NOT NULL,
  `allow_land_resell` int(11) NOT NULL,
  `allow_land_join_divide` int(11) NOT NULL,
  `block_show_in_search` int(11) NOT NULL,
  `agent_limit` int(11) NOT NULL,
  `object_bonus` double NOT NULL,
  `maturity` int(11) NOT NULL,
  `disable_scripts` int(11) NOT NULL,
  `disable_collisions` int(11) NOT NULL,
  `disable_physics` int(11) NOT NULL,
  `terrain_texture_1` char(36) NOT NULL,
  `terrain_texture_2` char(36) NOT NULL,
  `terrain_texture_3` char(36) NOT NULL,
  `terrain_texture_4` char(36) NOT NULL,
  `elevation_1_nw` double NOT NULL,
  `elevation_2_nw` double NOT NULL,
  `elevation_1_ne` double NOT NULL,
  `elevation_2_ne` double NOT NULL,
  `elevation_1_se` double NOT NULL,
  `elevation_2_se` double NOT NULL,
  `elevation_1_sw` double NOT NULL,
  `elevation_2_sw` double NOT NULL,
  `water_height` double NOT NULL,
  `terrain_raise_limit` double NOT NULL,
  `terrain_lower_limit` double NOT NULL,
  `use_estate_sun` int(11) NOT NULL,
  `fixed_sun` int(11) NOT NULL,
  `sun_position` double NOT NULL,
  `covenant` char(36) DEFAULT NULL,
  `Sandbox` tinyint(4) NOT NULL,
  `sunvectorx` double NOT NULL DEFAULT '0',
  `sunvectory` double NOT NULL DEFAULT '0',
  `sunvectorz` double NOT NULL DEFAULT '0',
  `loaded_creation_id` varchar(64) DEFAULT NULL,
  `loaded_creation_datetime` int(10) unsigned NOT NULL DEFAULT '0',
  `map_tile_ID` char(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `TelehubObject` varchar(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `parcel_tile_ID` char(36) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `covenant_datetime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`regionUUID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for regionwindlight
-- ----------------------------
DROP TABLE IF EXISTS `regionwindlight`;
CREATE TABLE `regionwindlight` (
  `region_id` varchar(36) NOT NULL DEFAULT '000000-0000-0000-0000-000000000000',
  `water_color_r` float(9,6) unsigned NOT NULL DEFAULT '4.000000',
  `water_color_g` float(9,6) unsigned NOT NULL DEFAULT '38.000000',
  `water_color_b` float(9,6) unsigned NOT NULL DEFAULT '64.000000',
  `water_fog_density_exponent` float(3,1) unsigned NOT NULL DEFAULT '4.0',
  `underwater_fog_modifier` float(3,2) unsigned NOT NULL DEFAULT '0.25',
  `reflection_wavelet_scale_1` float(3,1) unsigned NOT NULL DEFAULT '2.0',
  `reflection_wavelet_scale_2` float(3,1) unsigned NOT NULL DEFAULT '2.0',
  `reflection_wavelet_scale_3` float(3,1) unsigned NOT NULL DEFAULT '2.0',
  `fresnel_scale` float(3,2) unsigned NOT NULL DEFAULT '0.40',
  `fresnel_offset` float(3,2) unsigned NOT NULL DEFAULT '0.50',
  `refract_scale_above` float(3,2) unsigned NOT NULL DEFAULT '0.03',
  `refract_scale_below` float(3,2) unsigned NOT NULL DEFAULT '0.20',
  `blur_multiplier` float(4,3) unsigned NOT NULL DEFAULT '0.040',
  `big_wave_direction_x` float(3,2) NOT NULL DEFAULT '1.05',
  `big_wave_direction_y` float(3,2) NOT NULL DEFAULT '-0.42',
  `little_wave_direction_x` float(3,2) NOT NULL DEFAULT '1.11',
  `little_wave_direction_y` float(3,2) NOT NULL DEFAULT '-1.16',
  `normal_map_texture` varchar(36) NOT NULL DEFAULT '822ded49-9a6c-f61c-cb89-6df54f42cdf4',
  `horizon_r` float(3,2) unsigned NOT NULL DEFAULT '0.25',
  `horizon_g` float(3,2) unsigned NOT NULL DEFAULT '0.25',
  `horizon_b` float(3,2) unsigned NOT NULL DEFAULT '0.32',
  `horizon_i` float(3,2) unsigned NOT NULL DEFAULT '0.32',
  `haze_horizon` float(3,2) unsigned NOT NULL DEFAULT '0.19',
  `blue_density_r` float(3,2) unsigned NOT NULL DEFAULT '0.12',
  `blue_density_g` float(3,2) unsigned NOT NULL DEFAULT '0.22',
  `blue_density_b` float(3,2) unsigned NOT NULL DEFAULT '0.38',
  `blue_density_i` float(3,2) unsigned NOT NULL DEFAULT '0.38',
  `haze_density` float(3,2) unsigned NOT NULL DEFAULT '0.70',
  `density_multiplier` float(3,2) unsigned NOT NULL DEFAULT '0.18',
  `distance_multiplier` float(4,1) unsigned NOT NULL DEFAULT '0.8',
  `max_altitude` int(4) unsigned NOT NULL DEFAULT '1605',
  `sun_moon_color_r` float(3,2) unsigned NOT NULL DEFAULT '0.24',
  `sun_moon_color_g` float(3,2) unsigned NOT NULL DEFAULT '0.26',
  `sun_moon_color_b` float(3,2) unsigned NOT NULL DEFAULT '0.30',
  `sun_moon_color_i` float(3,2) unsigned NOT NULL DEFAULT '0.30',
  `sun_moon_position` float(4,3) unsigned NOT NULL DEFAULT '0.317',
  `ambient_r` float(3,2) unsigned NOT NULL DEFAULT '0.35',
  `ambient_g` float(3,2) unsigned NOT NULL DEFAULT '0.35',
  `ambient_b` float(3,2) unsigned NOT NULL DEFAULT '0.35',
  `ambient_i` float(3,2) unsigned NOT NULL DEFAULT '0.35',
  `east_angle` float(3,2) unsigned NOT NULL DEFAULT '0.00',
  `sun_glow_focus` float(3,2) unsigned NOT NULL DEFAULT '0.10',
  `sun_glow_size` float(3,2) unsigned NOT NULL DEFAULT '1.75',
  `scene_gamma` float(4,2) unsigned NOT NULL DEFAULT '1.00',
  `star_brightness` float(3,2) unsigned NOT NULL DEFAULT '0.00',
  `cloud_color_r` float(3,2) unsigned NOT NULL DEFAULT '0.41',
  `cloud_color_g` float(3,2) unsigned NOT NULL DEFAULT '0.41',
  `cloud_color_b` float(3,2) unsigned NOT NULL DEFAULT '0.41',
  `cloud_color_i` float(3,2) unsigned NOT NULL DEFAULT '0.41',
  `cloud_x` float(3,2) unsigned NOT NULL DEFAULT '1.00',
  `cloud_y` float(3,2) unsigned NOT NULL DEFAULT '0.53',
  `cloud_density` float(3,2) unsigned NOT NULL DEFAULT '1.00',
  `cloud_coverage` float(3,2) unsigned NOT NULL DEFAULT '0.27',
  `cloud_scale` float(3,2) unsigned NOT NULL DEFAULT '0.42',
  `cloud_detail_x` float(3,2) unsigned NOT NULL DEFAULT '1.00',
  `cloud_detail_y` float(3,2) unsigned NOT NULL DEFAULT '0.53',
  `cloud_detail_density` float(3,2) unsigned NOT NULL DEFAULT '0.12',
  `cloud_scroll_x` float(4,2) NOT NULL DEFAULT '0.20',
  `cloud_scroll_x_lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cloud_scroll_y` float(4,2) NOT NULL DEFAULT '0.01',
  `cloud_scroll_y_lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `draw_classic_clouds` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`region_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for spawn_points
-- ----------------------------
DROP TABLE IF EXISTS `spawn_points`;
CREATE TABLE `spawn_points` (
  `RegionID` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Yaw` float NOT NULL,
  `Pitch` float NOT NULL,
  `Distance` float NOT NULL,
  KEY `RegionID` (`RegionID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for terrain
-- ----------------------------
DROP TABLE IF EXISTS `terrain`;
CREATE TABLE `terrain` (
  `RegionUUID` varchar(255) DEFAULT NULL,
  `Revision` int(11) DEFAULT NULL,
  `Heightfield` longblob
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tokens
-- ----------------------------
DROP TABLE IF EXISTS `tokens`;
CREATE TABLE `tokens` (
  `UUID` char(36) NOT NULL,
  `token` varchar(255) NOT NULL,
  `validity` datetime NOT NULL,
  UNIQUE KEY `uuid_token` (`UUID`,`token`),
  KEY `UUID` (`UUID`),
  KEY `token` (`token`),
  KEY `validity` (`validity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for useraccounts
-- ----------------------------
DROP TABLE IF EXISTS `useraccounts`;
CREATE TABLE `useraccounts` (
  `PrincipalID` char(36) NOT NULL,
  `ScopeID` char(36) NOT NULL,
  `FirstName` varchar(64) NOT NULL,
  `LastName` varchar(64) NOT NULL,
  `Email` varchar(64) DEFAULT NULL,
  `ServiceURLs` text,
  `Created` int(11) DEFAULT NULL,
  `UserLevel` int(11) NOT NULL DEFAULT '0',
  `UserFlags` int(11) NOT NULL DEFAULT '0',
  `UserTitle` varchar(64) NOT NULL DEFAULT '',
  UNIQUE KEY `PrincipalID` (`PrincipalID`),
  KEY `Email` (`Email`),
  KEY `FirstName` (`FirstName`),
  KEY `LastName` (`LastName`),
  KEY `Name` (`FirstName`,`LastName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
