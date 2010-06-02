/*
MySQL Data Transfer
Source Host: 192.168.8.84
Source Database: msdr
Target Host: 192.168.8.84
Target Database: msdr
Date: 2010/6/2 11:57:56
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for daily_info
-- ----------------------------
CREATE TABLE `daily_info` (
  `id` int(11) NOT NULL auto_increment,
  `user` int(11) default NULL,
  `import_user` int(11) default NULL,
  `login_regd_user` int(11) default NULL,
  `male_user` int(11) default NULL,
  `female_user` int(11) default NULL,
  `login_user` int(11) default NULL,
  `real_user` int(11) default NULL,
  `video` int(11) default NULL,
  `image` int(11) default NULL,
  `blog` int(11) default NULL,
  `date` varchar(8) default NULL,
  PRIMARY KEY  (`id`),
  KEY `date` (`date`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for daily_rate
-- ----------------------------
CREATE TABLE `daily_rate` (
  `id` int(11) NOT NULL auto_increment,
  `age` text,
  `sex` text,
  `login` text,
  `info` text,
  `friend` text,
  `focus` text,
  `inbox` text,
  `outbox` text,
  `invite` text,
  `contact` text,
  `date` varchar(8) default NULL,
  PRIMARY KEY  (`id`),
  KEY `date` (`date`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for daily_trend
-- ----------------------------
CREATE TABLE `daily_trend` (
  `id` int(11) NOT NULL auto_increment,
  `register` int(11) default NULL,
  `video` int(11) default NULL,
  `image` int(11) default NULL,
  `blog` int(11) default NULL,
  `date` varchar(8) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `register` (`register`),
  KEY `date` (`date`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
