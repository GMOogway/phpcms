DROP TABLE IF EXISTS `cms_fclient`;
CREATE TABLE `cms_fclient` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` smallint(5) unsigned DEFAULT '0',
  `username` varchar(200) NOT NULL DEFAULT '',
  `name` varchar(200) NOT NULL DEFAULT '',
  `domain` varchar(220) NOT NULL DEFAULT '',
  `sn` varchar(220) NOT NULL DEFAULT '',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `inputtime` int(10) unsigned NOT NULL DEFAULT '0',
  `setting` mediumtext NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `endtime` (`endtime`),
  KEY `inputtime` (`inputtime`)
) TYPE=MyISAM;
INSERT INTO `cms_member_menu` VALUES ('', 'website', '0', 'fclient', 'member', 'init', 't=3', '0', '1', '', '');