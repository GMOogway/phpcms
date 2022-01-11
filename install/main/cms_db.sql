SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `cms_admin`
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin`;
CREATE TABLE `cms_admin` (
  `userid` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL COMMENT '用户名',
  `password` varchar(50) DEFAULT NULL COMMENT '加密密码',
  `login_attr` varchar(100) NOT NULL DEFAULT '' COMMENT '登录附加验证字符',
  `roleid` varchar(255) NOT NULL COMMENT '权限id',
  `encrypt` varchar(50) NOT NULL COMMENT '随机加密码',
  `lastloginip` varchar(200) DEFAULT NULL COMMENT '最后登录Ip',
  `lastlogintime` int(10) unsigned DEFAULT '0' COMMENT '最后登录时间',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱地址',
  `islock` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '账号锁定标识',
  `realname` varchar(50) NOT NULL DEFAULT '' COMMENT '姓名',
  `lang` VARCHAR(6) NOT NULL COMMENT '语言',
  PRIMARY KEY (`userid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_admin_login`
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin_login`;
CREATE TABLE `cms_admin_login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned DEFAULT NULL COMMENT '会员uid',
  `is_login` int(10) unsigned DEFAULT NULL COMMENT '是否首次登录',
  `is_repwd` int(10) unsigned DEFAULT NULL COMMENT '是否重置密码',
  `updatetime` int(10) unsigned NOT NULL COMMENT '修改密码时间',
  `logintime` int(10) unsigned NOT NULL COMMENT '最近登录时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `logintime` (`logintime`),
  KEY `updatetime` (`updatetime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_admin_panel`
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin_panel`;
CREATE TABLE `cms_admin_panel` (
  `menuid` mediumint(8) unsigned NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '管理员userid',
  `name` char(32) DEFAULT NULL COMMENT '名称',
  `icon` varchar(255) NULL DEFAULT NULL COMMENT '图标标示',
  `url` char(255) DEFAULT NULL COMMENT '外链地址',
  `datetime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  UNIQUE KEY `userid` (`menuid`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_admin_role`
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin_role`;
CREATE TABLE `cms_admin_role` (
  `roleid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `rolename` varchar(50) NOT NULL COMMENT '角色名称',
  `description` text NOT NULL COMMENT '角色描述',
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`roleid`),
  KEY `listorder` (`listorder`),
  KEY `disabled` (`disabled`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_admin_role_priv`
-- ----------------------------
DROP TABLE IF EXISTS `cms_admin_role_priv`;
CREATE TABLE `cms_admin_role_priv` (
  `roleid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `m` char(20) NOT NULL,
  `c` char(20) NOT NULL,
  `a` char(20) NOT NULL,
  `data` char(30) NOT NULL DEFAULT '',
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  KEY `roleid` (`roleid`,`m`,`c`,`a`,`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `cms_attachment`;
CREATE TABLE `cms_attachment` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module` char(15) NOT NULL,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `filename` varchar(255) NOT NULL,
  `filepath` char(200) NOT NULL,
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `fileext` char(10) NOT NULL,
  `isimage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isthumb` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `downloads` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uploadtime` int(10) unsigned NOT NULL DEFAULT '0',
  `uploadip` char(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `authcode` char(32) NOT NULL,
  `filemd5` varchar(50) NOT NULL COMMENT '文件md5值',
  `remote` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '远程附件id',
  `attachinfo` text NOT NULL COMMENT '附件信息',
  `related` varchar(50) NOT NULL COMMENT '相关表标识',
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`),
  KEY `authcode` (`authcode`),
  KEY `relatedtid` (`related`),
  KEY `fileext` (`fileext`),
  KEY `filemd5` (`filemd5`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_attachment_index`
-- ----------------------------
DROP TABLE IF EXISTS `cms_attachment_index`;
CREATE TABLE `cms_attachment_index` (
  `keyid` char(30) NOT NULL,
  `aid` char(10) NOT NULL,
  KEY `keyid` (`keyid`),
  KEY `aid` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
-- ----------------------------
-- Table structure for `cms_attachment_remote`
-- ----------------------------
DROP TABLE IF EXISTS `cms_attachment_remote`;
CREATE TABLE `cms_attachment_remote` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(2) NOT NULL COMMENT '类型',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `url` varchar(255) NOT NULL COMMENT '访问地址',
  `value` text NOT NULL COMMENT '参数值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
-- ----------------------------
-- Table structure for `cms_badword`
-- ----------------------------
DROP TABLE IF EXISTS `cms_badword`;
CREATE TABLE `cms_badword` (
  `badid` smallint(5) unsigned NOT NULL auto_increment,
  `badword` char(20) NOT NULL,
  `level` tinyint(5) NOT NULL default '1',
  `replaceword` char(20) NOT NULL default '0',
  `lastusetime` int(10) unsigned NOT NULL default '0',
  `listorder` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`badid`),
  UNIQUE KEY `badword` (`badword`),
  KEY `usetimes` (`replaceword`,`listorder`),
  KEY `hits` (`listorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci ;

-- ----------------------------
-- Table structure for `cms_block`
-- ----------------------------
DROP TABLE IF EXISTS `cms_block`;
CREATE TABLE `cms_block` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned DEFAULT '0',
  `name` char(50) DEFAULT NULL,
  `pos` char(30) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0',
  `data` text,
  `template` text,
  PRIMARY KEY (`id`),
  KEY `pos` (`pos`),
  KEY `type` (`type`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_block_history`
-- ----------------------------
DROP TABLE IF EXISTS `cms_block_history`;
CREATE TABLE `cms_block_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `blockid` int(10) unsigned DEFAULT '0',
  `data` text,
  `creat_at` int(10) unsigned DEFAULT '0',
  `userid` mediumint(8) unsigned DEFAULT '0',
  `username` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_block_priv`
-- ----------------------------
DROP TABLE IF EXISTS `cms_block_priv`;
CREATE TABLE `cms_block_priv` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `roleid` tinyint(3) unsigned DEFAULT '0',
  `siteid` smallint(5) unsigned DEFAULT '0',
  `blockid` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `blockid` (`blockid`),
  KEY `roleid` (`roleid`,`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_cache`
-- ----------------------------
DROP TABLE IF EXISTS `cms_cache`;
CREATE TABLE `cms_cache` (
  `filename` char(50) NOT NULL,
  `path` char(50) NOT NULL,
  `data` mediumtext NOT NULL,
  PRIMARY KEY  (`filename`,`path`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_category`
-- ----------------------------
DROP TABLE IF EXISTS `cms_category`;
CREATE TABLE `cms_category` (
  `catid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `module` varchar(15) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `modelid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `parentid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `arrparentid` varchar(255) NOT NULL,
  `child` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `arrchildid` mediumtext NOT NULL,
  `catname` varchar(30) NOT NULL,
  `style` varchar(5) NOT NULL,
  `image` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL,
  `parentdir` varchar(100) NOT NULL,
  `catdir` varchar(30) NOT NULL,
  `url` varchar(100) NOT NULL,
  `items` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `setting` mediumtext NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ismenu` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `sethtml` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `letter` varchar(30) NOT NULL,
  `usable_type` varchar(255) NOT NULL,
  PRIMARY KEY (`catid`),
  KEY `module` (`module`,`parentid`,`listorder`,`catid`),
  KEY `siteid` (`siteid`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci ;

-- ----------------------------
-- Table structure for `cms_category_priv`
-- ----------------------------
DROP TABLE IF EXISTS `cms_category_priv`;
CREATE TABLE `cms_category_priv` (
 `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `roleid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `action` char(30) NOT NULL,
  KEY `catid` (`catid`,`roleid`,`is_admin`,`action`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_collection_content`
-- ----------------------------
DROP TABLE IF EXISTS `cms_collection_content`;
CREATE TABLE `cms_collection_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nodeid` int(10) unsigned NOT NULL DEFAULT '0',
  `siteid` mediumint(5) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `url` char(255) NOT NULL,
  `title` char(100) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nodeid` (`nodeid`,`siteid`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_collection_history`
-- ----------------------------
DROP TABLE IF EXISTS `cms_collection_history`;
CREATE TABLE `cms_collection_history` (
  `md5` char(32) NOT NULL,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`md5`,`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_collection_node`
-- ----------------------------
DROP TABLE IF EXISTS `cms_collection_node`;
CREATE TABLE `cms_collection_node` (
  `nodeid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `lastdate` int(10) unsigned NOT NULL DEFAULT '0',
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sourcecharset` varchar(8) NOT NULL,
  `sourcetype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `urlpage` text NOT NULL,
  `pagesize_start` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `pagesize_end` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `page_base` char(255) NOT NULL,
  `par_num` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `url_contain` char(100) NOT NULL,
  `url_except` char(100) NOT NULL,
  `url_start` char(100) NOT NULL DEFAULT '',
  `url_end` char(100) NOT NULL DEFAULT '',
  `title_rule` char(100) NOT NULL,
  `title_html_rule` text NOT NULL,
  `author_rule` char(100) NOT NULL,
  `author_html_rule` text NOT NULL,
  `comeform_rule` char(100) NOT NULL,
  `comeform_html_rule` text NOT NULL,
  `time_rule` char(100) NOT NULL,
  `time_html_rule` text NOT NULL,
  `content_rule` char(100) NOT NULL,
  `content_html_rule` text NOT NULL,
  `content_page_start` char(100) NOT NULL,
  `content_page_end` char(100) NOT NULL,
  `content_page_rule` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content_page` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content_nextpage` char(100) NOT NULL,
  `down_attachment` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `watermark` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `coll_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `customize_config` text NOT NULL,
  PRIMARY KEY (`nodeid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_collection_program`
-- ----------------------------
DROP TABLE IF EXISTS `cms_collection_program`;
CREATE TABLE `cms_collection_program` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `nodeid` int(10) unsigned NOT NULL DEFAULT '0',
  `modelid` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `config` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`),
  KEY `nodeid` (`nodeid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cms_content_check`;
CREATE TABLE `cms_content_check` (
  `checkid` char(15) NOT NULL,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `title` char(80) NOT NULL,
  `username` char(50) NOT NULL,
  `inputtime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  KEY `username` (`username`),
  KEY `checkid` (`checkid`),
  KEY `status` (`status`,`inputtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_datacall`
-- ----------------------------
DROP TABLE IF EXISTS `cms_datacall`;
CREATE TABLE `cms_datacall` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` char(40) DEFAULT NULL,
  `dis_type` tinyint(1) unsigned DEFAULT '0',
  `type` tinyint(1) DEFAULT '0',
  `module` char(20) DEFAULT NULL,
  `action` char(20) DEFAULT NULL,
  `data` text,
  `template` text,
  `cache` mediumint(8) DEFAULT NULL,
  `num` smallint(6) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_dbsource`
-- ----------------------------
DROP TABLE IF EXISTS `cms_dbsource`;
CREATE TABLE `cms_dbsource` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `host` varchar(20) NOT NULL,
  `port` int(5) NOT NULL DEFAULT '3306',
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `dbname` varchar(50) NOT NULL,
  `dbtablepre` varchar(30) NOT NULL ,
  `charset` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_downservers`
-- ----------------------------
DROP TABLE IF EXISTS `cms_downservers`;
CREATE TABLE `cms_downservers` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `sitename` varchar(100) DEFAULT NULL,
  `siteurl` varchar(255) DEFAULT NULL,
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_favorite`
-- ----------------------------
DROP TABLE IF EXISTS `cms_favorite`;
CREATE TABLE `cms_favorite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `title` char(100) NOT NULL,
  `url` char(100) NOT NULL,
  `adddate` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_hits`
-- ----------------------------
DROP TABLE IF EXISTS `cms_hits`;
CREATE TABLE `cms_hits` (
  `hitsid` char(30) NOT NULL,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `yesterdayviews` int(10) unsigned NOT NULL DEFAULT '0',
  `dayviews` int(10) unsigned NOT NULL DEFAULT '0',
  `weekviews` int(10) unsigned NOT NULL DEFAULT '0',
  `monthviews` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`hitsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_ipbanned`
-- ----------------------------
DROP TABLE IF EXISTS `cms_ipbanned`;
CREATE TABLE `cms_ipbanned` (
  `ipbannedid` smallint(5) NOT NULL auto_increment,
  `ip` char(200) NOT NULL,
  `expires` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ipbannedid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_keylink`
-- ----------------------------
DROP TABLE IF EXISTS `cms_keylink`;
CREATE TABLE `cms_keylink` (
  `keylinkid` smallint(5) unsigned NOT NULL auto_increment,
  `word` char(40) NOT NULL,
  `url` char(100) NOT NULL,
  PRIMARY KEY  (`keylinkid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;


-- ----------------------------
-- Table structure for `cms_keyword`
-- ----------------------------
DROP TABLE IF EXISTS `cms_keyword`;
CREATE TABLE IF NOT EXISTS `cms_keyword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `keyword` char(100) NOT NULL,
  `pinyin` char(100) NOT NULL,
  `videonum` int(11) NOT NULL DEFAULT '0',
  `searchnums` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `keyword` (`keyword`,`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;


-- ----------------------------
-- Table structure for `cms_keyword_data`
-- ----------------------------
DROP TABLE IF EXISTS `cms_keyword_data`;
CREATE TABLE IF NOT EXISTS `cms_keyword_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tagid` int(10) unsigned NOT NULL DEFAULT '0',
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `contentid` char(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tagid` (`tagid`,`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_linkage`
-- ----------------------------
DROP TABLE IF EXISTS `cms_linkage`;
CREATE TABLE `cms_linkage` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '菜单名称',
  `type` tinyint(1) unsigned NOT NULL,
  `code` char(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `module` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='联动菜单表';

-- ----------------------------
-- Table structure for `cms_linkage_data_1`
-- ----------------------------
DROP TABLE IF EXISTS `cms_linkage_data_1`;
CREATE TABLE `cms_linkage_data_1` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `site` mediumint(5) unsigned NOT NULL COMMENT '站点id',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '上级id',
  `pids` varchar(255) DEFAULT NULL COMMENT '所有上级id',
  `name` varchar(30) NOT NULL COMMENT '栏目名称',
  `cname` varchar(30) NOT NULL COMMENT '别名',
  `child` tinyint(1) unsigned DEFAULT NULL DEFAULT '0' COMMENT '是否有下级',
  `hidden` tinyint(1) unsigned DEFAULT NULL DEFAULT '0' COMMENT '前端隐藏',
  `childids` text DEFAULT NULL COMMENT '下级所有id',
  `displayorder` mediumint(8) DEFAULT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `cname` (`cname`),
  KEY `hidden` (`hidden`),
  KEY `list` (`site`,`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='联动菜单数据表';

-- ----------------------------
-- Table structure for `cms_log`
-- ----------------------------
DROP TABLE IF EXISTS `cms_log`;
CREATE TABLE `cms_log` (
  `logid` int(10) unsigned NOT NULL auto_increment,
  `field` varchar(15) NOT NULL,
  `value` int(10) unsigned NOT NULL default '0',
  `module` varchar(15) NOT NULL,
  `file` varchar(20) NOT NULL,
  `action` varchar(20) NOT NULL,
  `querystring` varchar(255) NOT NULL,
  `data` mediumtext NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(50) NOT NULL,
  `ip` varchar(200) NOT NULL,
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`logid`),
  KEY `module` (`module`,`file`,`action`),
  KEY `username` (`username`,`action`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_member`
-- ----------------------------
DROP TABLE IF EXISTS `cms_member`;
CREATE TABLE `cms_member` (
  `userid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(50) NOT NULL DEFAULT '' COMMENT '加密密码',
  `login_attr` varchar(100) NOT NULL DEFAULT '' COMMENT '登录附加验证字符',
  `encrypt` varchar(50) NOT NULL COMMENT '随机加密码',
  `nickname` char(50) NOT NULL  COMMENT '昵称',
  `avatar` char(255) NOT NULL COMMENT '头像',
  `regdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `lastdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登陆时间',
  `regip` char(200) NOT NULL DEFAULT '' COMMENT '注册Ip',
  `lastip` char(200) NOT NULL DEFAULT '' COMMENT '最后登录Ip',
  `loginnum` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `email` char(50) NOT NULL DEFAULT '' COMMENT '邮箱地址',
  `groupid` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '会员组id',
  `areaid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '地区id',
  `amount` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '金钱RMB',
  `point` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `modelid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型id',
  `message` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `islock` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '账号锁定标识',
  `vip` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是VIP',
  `overduedate` int(10) unsigned NOT NULL DEFAULT '0',
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '站点id',
  `connectid` char(40) NOT NULL DEFAULT '',
  `from` char(10) NOT NULL DEFAULT '',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`),
  KEY `email` (`email`(50))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;



-- ----------------------------
-- Table structure for `cms_member_detail`
-- ----------------------------
DROP TABLE IF EXISTS `cms_member_detail`;
CREATE TABLE `cms_member_detail` (
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `birthday` date DEFAULT NULL,
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_member_group`
-- ----------------------------
DROP TABLE IF EXISTS `cms_member_group`;
CREATE TABLE `cms_member_group` (
  `groupid` tinyint(3) unsigned NOT NULL auto_increment,
  `name` char(15) NOT NULL,
  `issystem` tinyint(1) unsigned NOT NULL default '0',
  `starnum` tinyint(2) unsigned NOT NULL,
  `point` smallint(6) unsigned NOT NULL,
  `allowmessage` smallint(5) unsigned NOT NULL default '0',
  `allowvisit` tinyint(1) unsigned NOT NULL default '0',
  `allowpost` tinyint(1) unsigned NOT NULL default '0',
  `allowpostverify` tinyint(1) unsigned NOT NULL,
  `allowsearch` tinyint(1) unsigned NOT NULL default '0',
  `allowupgrade` tinyint(1) unsigned NOT NULL default '1',
  `allowsendmessage` tinyint(1) unsigned NOT NULL,
  `allowpostnum` smallint(5) unsigned NOT NULL default '0',
  `allowattachment` tinyint(1) NOT NULL,
  `price_y` decimal(8,2) unsigned NOT NULL default '0.00',
  `price_m` decimal(8,2) unsigned NOT NULL default '0.00',
  `price_d` decimal(8,2) unsigned NOT NULL default '0.00',
  `icon` char(30) NOT NULL,
  `usernamecolor` char(7) NOT NULL,
  `description` char(100) NOT NULL,
  `sort` tinyint(3) unsigned NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`groupid`),
  KEY `disabled` (`disabled`),
  KEY `listorder` (`sort`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_member_login`
-- ----------------------------
DROP TABLE IF EXISTS `cms_member_login`;
CREATE TABLE `cms_member_login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned DEFAULT NULL COMMENT '会员uid',
  `is_login` int(10) unsigned DEFAULT NULL COMMENT '是否首次登录',
  `is_repwd` int(10) unsigned DEFAULT NULL COMMENT '是否重置密码',
  `updatetime` int(10) unsigned NOT NULL COMMENT '修改密码时间',
  `logintime` int(10) unsigned NOT NULL COMMENT '最近登录时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `logintime` (`logintime`),
  KEY `updatetime` (`updatetime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;


-- ----------------------------
-- Table structure for `cms_member_verify`
-- ----------------------------
DROP TABLE IF EXISTS `cms_member_verify`;
CREATE TABLE `cms_member_verify` (
  `userid` mediumint(8) unsigned NOT NULL auto_increment,
  `username` char(50) NOT NULL,
  `password` char(50) NOT NULL,
  `encrypt` varchar(50) NOT NULL,
  `nickname` char(50) NOT NULL,
  `regdate` int(10) unsigned NOT NULL,
  `regip` char(200) NOT NULL,
  `email` char(50) NOT NULL,
  `modelid` tinyint(3) unsigned NOT NULL default '0',
  `point` smallint(5) unsigned NOT NULL default '0',
  `amount` decimal(8,2) unsigned NOT NULL default '0.00',
  `modelinfo` char(255) NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `siteid` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `message` char(100) default NULL,
  `mobile` char(11) NOT NULL DEFAULT '',
  PRIMARY KEY  (`userid`),
  UNIQUE KEY `username` (`username`),
  KEY `email` (`email`(50))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_member_menu`
-- ----------------------------
DROP TABLE IF EXISTS `cms_member_menu`;
CREATE TABLE `cms_member_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(40) NOT NULL DEFAULT '',
  `parentid` smallint(6) NOT NULL DEFAULT '0',
  `m` char(20) NOT NULL DEFAULT '',
  `c` char(20) NOT NULL DEFAULT '',
  `a` char(20) NOT NULL DEFAULT '',
  `data` char(100) NOT NULL DEFAULT '',
  `listorder` smallint(6) unsigned NOT NULL DEFAULT '0',
  `display` enum('1','0') NOT NULL DEFAULT '1',
  `isurl` enum('1','0') NOT NULL DEFAULT '0',
  `url` char(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `listorder` (`listorder`),
  KEY `parentid` (`parentid`),
  KEY `module` (`m`,`c`,`a`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_member_vip`
-- ----------------------------
DROP TABLE IF EXISTS `cms_member_vip`;
CREATE TABLE `cms_member_vip` (
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_menu`
-- ----------------------------
DROP TABLE IF EXISTS `cms_menu`;
CREATE TABLE `cms_menu` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` char(40) NOT NULL default '',
  `parentid` smallint(6) NOT NULL default '0',
  `m` char(20) NOT NULL default '',
  `c` char(20) NOT NULL default '',
  `a` char(20) NOT NULL default '',
  `data` char(100) NOT NULL default '',
  `icon` varchar(255) NULL DEFAULT NULL COMMENT '图标标示',
  `listorder` smallint(6) unsigned NOT NULL default '0',
  `display` enum('1','0') NOT NULL default '1',
  `project1` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `project2` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `project3` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `project4` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `project5` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY  (`id`),
  KEY `listorder` (`listorder`),
  KEY `parentid` (`parentid`),
  KEY `module` (`m`,`c`,`a`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

--
-- 表的结构 `cms_model`
--

DROP TABLE IF EXISTS `cms_model`;
CREATE TABLE IF NOT EXISTS `cms_model` (
  `modelid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `name` char(30) NOT NULL,
  `description` char(100) NOT NULL,
  `tablename` char(20) NOT NULL,
  `setting` text NOT NULL ,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' ,
  `items` smallint(5) unsigned NOT NULL DEFAULT '0' ,
  `enablesearch` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `default_style` char(30) NOT NULL,
  `category_template` char(30) NOT NULL,
  `list_template` char(30) NOT NULL,
  `show_template` char(30) NOT NULL,
  `js_template` varchar(30) NOT NULL ,
  `admin_list_template` char(30) NOT NULL,
  `member_add_template` varchar(30) NOT NULL ,
  `member_list_template` varchar(30) NOT NULL ,
  `sort` tinyint(3) NOT NULL,
  `type` tinyint(1) NOT NULL,
  PRIMARY KEY (`modelid`),
  KEY `type` (`type`,`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cms_model_field`;
CREATE TABLE IF NOT EXISTS `cms_model_field` (
  `fieldid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `modelid` smallint(5) NOT NULL DEFAULT '0',
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `field` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `tips` text NOT NULL,
  `css` varchar(30) NOT NULL,
  `minlength` int(10) unsigned NOT NULL DEFAULT '0',
  `maxlength` int(10) unsigned NOT NULL DEFAULT '0',
  `pattern` varchar(255) NOT NULL,
  `errortips` varchar(255) NOT NULL,
  `formtype` varchar(20) NOT NULL,
  `setting` mediumtext NOT NULL,
  `formattribute` varchar(255) NOT NULL,
  `unsetgroupids` varchar(255) NOT NULL,
  `unsetroleids` varchar(255) NOT NULL,
  `iscore` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `issystem` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isunique` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isbase` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `issearch` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isadd` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isfulltext` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isposition` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `listorder` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isomnipotent` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fieldid`),
  KEY `modelid` (`modelid`,`disabled`),
  KEY `field` (`field`,`modelid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_module`
-- ----------------------------
DROP TABLE IF EXISTS `cms_module`;
CREATE TABLE `cms_module` (
  `module` varchar(15) NOT NULL,
  `name` varchar(20) NOT NULL,
  `url` varchar(50) NOT NULL,
  `iscore` tinyint(1) unsigned NOT NULL default '0',
  `version` varchar(50) NOT NULL default '',
  `description` varchar(255) NOT NULL,
  `setting` mediumtext NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  `installdate` date NOT NULL default '0000-00-00',
  `updatedate` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`module`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;



-- ----------------------------
-- Table structure for `cms_page`
-- ----------------------------
DROP TABLE IF EXISTS `cms_page`;
CREATE TABLE `cms_page` (
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `title` varchar(160) NOT NULL,
  `style` varchar(24) NOT NULL,
  `keywords` varchar(40) NOT NULL,
  `content` text NOT NULL,
  `template` varchar(30) NOT NULL,
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_pay_account`
-- ----------------------------
DROP TABLE IF EXISTS `cms_pay_account`;
CREATE TABLE `cms_pay_account` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `trade_sn` char(50) NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` char(50) NOT NULL,
  `contactname` char(50) NOT NULL,
  `email` char(50) NOT NULL,
  `telephone` char(20) NOT NULL,
  `discount` float(8,2) NOT NULL DEFAULT '0.00',
  `money` char(8) NOT NULL,
  `quantity` int(8) unsigned NOT NULL DEFAULT '1',
  `addtime` int(10) NOT NULL DEFAULT '0',
  `paytime` int(10) NOT NULL DEFAULT '0',
  `usernote` char(255) NOT NULL,
  `pay_id` tinyint(3) NOT NULL,
  `pay_type` enum('offline','recharge','selfincome','online') NOT NULL DEFAULT 'recharge',
  `payment` char(90) NOT NULL,
  `type` tinyint(3) NOT NULL DEFAULT '1',
  `ip` char(200) NOT NULL DEFAULT '0.0.0.0',
  `status` enum('succ','failed','error','progress','timeout','cancel','waitting','unpay') NOT NULL DEFAULT 'unpay',
  `adminnote` char(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `userid` (`userid`),
  KEY `trade_sn` (`trade_sn`,`money`,`status`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_pay_payment`
-- ----------------------------
DROP TABLE IF EXISTS `cms_pay_payment`;
CREATE TABLE `cms_pay_payment` (
  `pay_id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(120) NOT NULL,
  `pay_name` varchar(120) NOT NULL,
  `pay_code` varchar(20) NOT NULL,
  `pay_desc` text NOT NULL,
  `pay_method` tinyint(1) default NULL,
  `pay_fee` varchar(10) NOT NULL,
  `config` text NOT NULL,
  `is_cod` tinyint(1) unsigned NOT NULL default '0',
  `is_online` tinyint(1) unsigned NOT NULL default '0',
  `pay_order` tinyint(3) unsigned NOT NULL default '0',
  `enabled` tinyint(1) unsigned NOT NULL default '0',
  `author` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `version` varchar(20) NOT NULL,
  PRIMARY KEY  (`pay_id`),
  KEY `pay_code` (`pay_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_pay_spend`
-- ----------------------------
DROP TABLE IF EXISTS `cms_pay_spend`;
CREATE TABLE `cms_pay_spend` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `creat_at` int(10) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  `username` varchar(50) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL default '0',
  `logo` varchar(20) NOT NULL,
  `value` int(5) NOT NULL,
  `op_userid` int(10) unsigned NOT NULL default '0',
  `op_username` char(20) NOT NULL,
  `msg` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `type` (`type`),
  KEY `creat_at` (`creat_at`),
  KEY `logo` (`logo`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_position`
-- ----------------------------
DROP TABLE IF EXISTS `cms_position`;
CREATE TABLE `cms_position` (
  `posid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `modelid` smallint(5) unsigned DEFAULT '0',
  `catid` smallint(5) unsigned DEFAULT '0',
  `name` char(30) NOT NULL DEFAULT '',
  `maxnum` smallint(5) NOT NULL DEFAULT '20',
  `extention` char(100) DEFAULT NULL,
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`posid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;


INSERT INTO `cms_position` (`posid`, `modelid`, `catid`, `name`, `maxnum`, `listorder`, `siteid`) VALUES(1, 0, 0, '首页头条推荐', 20, 0, 1);
INSERT INTO `cms_position` (`posid`, `modelid`, `catid`, `name`, `maxnum`, `listorder`, `siteid`) VALUES(2, 0, 0, '首页焦点图推荐', 20, 0, 1);
INSERT INTO `cms_position` (`posid`, `modelid`, `catid`, `name`, `maxnum`, `listorder`, `siteid`) VALUES(3, 0, 0, '栏目页焦点图', 20, 0, 1);
INSERT INTO `cms_position` (`posid`, `modelid`, `catid`, `name`, `maxnum`, `listorder`, `siteid`) VALUES(4, 0, 0, '推荐下载', 20, 0, 1);
INSERT INTO `cms_position` (`posid`, `modelid`, `catid`, `name`, `maxnum`, `listorder`, `siteid`) VALUES(5, 0, 0, '图片首页焦点图', 20, 0, 1);
INSERT INTO `cms_position` (`posid`, `modelid`, `catid`, `name`, `maxnum`, `listorder`, `siteid`) VALUES(6, 0, 0, '网站顶部推荐', 20, 0, 1);
INSERT INTO `cms_position` (`posid`, `modelid`, `catid`, `name`, `maxnum`, `listorder`, `siteid`) VALUES(7, 0, 0, '栏目首页推荐', 20, 0, 1);
INSERT INTO `cms_position` (`posid`, `modelid`, `catid`, `name`, `maxnum`, `listorder`, `siteid`) VALUES(8, 0, 0, '首页图片推荐', 20, 0, 1);
INSERT INTO `cms_position` (`posid`, `modelid`, `catid`, `name`, `maxnum`, `listorder`, `siteid`) VALUES(9, 0, 0, '视频首页焦点图', 20, 0, 1);
INSERT INTO `cms_position` (`posid`, `modelid`, `catid`, `name`, `maxnum`, `listorder`, `siteid`) VALUES(10, 0, 0, '视频首页头条推荐', 20, 0, 1);
INSERT INTO `cms_position` (`posid`, `modelid`, `catid`, `name`, `maxnum`, `listorder`, `siteid`) VALUES(11, 0, 0, '视频首页每日热点', 20, 0, 1);
INSERT INTO `cms_position` (`posid`, `modelid`, `catid`, `name`, `maxnum`, `listorder`, `siteid`) VALUES(12, 0, 0, '视频栏目精彩推荐', 20, 0, 1);


-- ----------------------------
-- Table structure for `cms_position_data`
-- ----------------------------
DROP TABLE IF EXISTS `cms_position_data`;
CREATE TABLE `cms_position_data` (
  `id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `posid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `module` char(20) DEFAULT NULL,
  `modelid` smallint(6) unsigned DEFAULT '0',
  `thumb` tinyint(1) NOT NULL DEFAULT '0',
  `data` mediumtext,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `listorder` mediumint(8) DEFAULT '0',
  `expiration` int(10) NOT NULL,
  `extention` char(30) DEFAULT NULL,
  `synedit` tinyint(1) DEFAULT '0',
  KEY `posid` (`posid`),
  KEY `listorder` (`listorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;


-- ----------------------------
-- Table structure for `cms_queue`
-- ----------------------------
DROP TABLE IF EXISTS `cms_queue`;
CREATE TABLE `cms_queue` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` char(5) DEFAULT NULL,
  `siteid` smallint(5) unsigned DEFAULT '0',
  `path` varchar(100) DEFAULT NULL,
  `status1` tinyint(1) DEFAULT '0',
  `status2` tinyint(1) DEFAULT '0',
  `status3` tinyint(1) DEFAULT '0',
  `status4` tinyint(1) DEFAULT '0',
  `times` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`),
  KEY `times` (`times`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_release_point`
-- ----------------------------
DROP TABLE IF EXISTS `cms_release_point`;
CREATE TABLE `cms_release_point` (
  `id` mediumint(8) NOT NULL auto_increment,
  `name` varchar(30) default NULL,
  `host` varchar(100) default NULL,
  `username` varchar(50) default NULL,
  `password` varchar(50) default NULL,
  `port` varchar(10) default '21',
  `pasv` tinyint(1) default '0',
  `ssl` tinyint(1) default '0',
  `path` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_search`
-- ----------------------------
DROP TABLE IF EXISTS `cms_search`;
CREATE TABLE `cms_search` (
  `searchid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `adddate` int(10) unsigned NOT NULL,
  `data` text NOT NULL,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`searchid`),
  KEY `typeid` (`typeid`,`id`),
  KEY `siteid` (`siteid`),
  FULLTEXT KEY `data` (`data`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_search_keyword`
-- ----------------------------
DROP TABLE IF EXISTS `cms_search_keyword`;
CREATE TABLE `cms_search_keyword` (
  `keyword` char(20) NOT NULL,
  `pinyin` char(20) NOT NULL,
  `searchnums` int(10) unsigned NOT NULL,
  `data` char(20) NOT NULL,
  UNIQUE KEY `keyword` (`keyword`),
  UNIQUE KEY `pinyin` (`pinyin`),
  FULLTEXT KEY `data` (`data`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_session`
-- ----------------------------
DROP TABLE IF EXISTS `cms_session`;
CREATE TABLE `cms_session` (
  `sessionid` char(32) NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `ip` char(200) NOT NULL,
  `lastvisit` int(10) unsigned NOT NULL default '0',
  `roleid` tinyint(3) unsigned default '0',
  `groupid` tinyint(3) unsigned NOT NULL default '0',
  `m` char(20) NOT NULL,
  `c` char(20) NOT NULL,
  `a` char(20) NOT NULL,
  `data` char(255) NOT NULL,
  PRIMARY KEY  (`sessionid`),
  KEY `lastvisit` (`lastvisit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_site`
-- ----------------------------
DROP TABLE IF EXISTS `cms_site`;
CREATE TABLE `cms_site` (
  `siteid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) DEFAULT '',
  `dirname` char(255) DEFAULT '',
  `domain` char(255) DEFAULT '',
  `ishtml` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `mobileauto` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `mobilehtml` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `not_pad` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `mobile_domain` char(255) DEFAULT '',
  `site_title` char(255) DEFAULT '',
  `keywords` char(255) DEFAULT '',
  `description` char(255) DEFAULT '',
  `release_point` text,
  `default_style` char(50) DEFAULT NULL,
  `template` text,
  `setting` mediumtext,
  `style` varchar(5) NOT NULL,
  PRIMARY KEY (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_special`
-- ----------------------------
DROP TABLE IF EXISTS `cms_special`;
CREATE TABLE IF NOT EXISTS `cms_special` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `aid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` char(60) NOT NULL,
  `typeids` char(100) NOT NULL,
  `thumb` char(100) NOT NULL,
  `banner` char(100) NOT NULL,
  `description` char(255) NOT NULL,
  `url` char(100) NOT NULL,
  `ishtml` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ispage` tinyint(1) unsigned NOT NULL,
  `filename` char(40) NOT NULL,
  `pics` char(100) NOT NULL,
  `voteid` char(60) NOT NULL,
  `style` char(20) NOT NULL,
  `index_template` char(40) NOT NULL,
  `list_template` char(40) NOT NULL,
  `show_template` char(60) NOT NULL,
  `css` text NOT NULL,
  `username` char(50) NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(5) unsigned NOT NULL,
  `elite` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isvideo` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `disabled` (`disabled`,`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci ;

-- ----------------------------
-- Table structure for `cms_special_c_data`
-- ----------------------------
DROP TABLE IF EXISTS `cms_special_c_data`;
CREATE TABLE IF NOT EXISTS `cms_special_c_data` (
  `id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `author` varchar(40) NOT NULL,
  `content` text NOT NULL,
  `paginationtype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `maxcharperpage` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `style` char(20) NOT NULL,
  `show_template` varchar(30) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_special_content`
-- ----------------------------
DROP TABLE IF EXISTS `cms_special_content`;
CREATE TABLE IF NOT EXISTS `cms_special_content` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `specialid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `title` char(80) NOT NULL,
  `style` char(24) NOT NULL,
  `typeid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `thumb` char(100) NOT NULL,
  `keywords` char(40) NOT NULL,
  `description` char(255) NOT NULL,
  `url` char(100) NOT NULL,
  `curl` char(15) NOT NULL,
  `listorder` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` char(50) NOT NULL,
  `inputtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `searchid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isdata` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `videoid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `specialid` (`specialid`,`typeid`,`isdata`),
  KEY `typeid` (`typeid`,`isdata`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci ;

-- ----------------------------
-- Table structure for `cms_sphinx_counter`
-- ----------------------------
DROP TABLE IF EXISTS `cms_sphinx_counter`;
CREATE TABLE `cms_sphinx_counter` (
  `counter_id` int(11) unsigned NOT NULL,
  `max_doc_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`counter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_template_bak`
-- ----------------------------
DROP TABLE IF EXISTS `cms_template_bak`;
CREATE TABLE `cms_template_bak` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `creat_at` int(10) unsigned DEFAULT '0',
  `fileid` char(50) DEFAULT NULL,
  `userid` mediumint(8) DEFAULT NULL,
  `username` char(50) DEFAULT NULL,
  `template` text,
  PRIMARY KEY (`id`),
  KEY `fileid` (`fileid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;



-- ----------------------------
-- Table structure for `cms_times`
-- ----------------------------
DROP TABLE IF EXISTS `cms_times`;
CREATE TABLE `cms_times` (
  `username` char(50) NOT NULL,
  `ip` char(200) NOT NULL,
  `logintime` int(10) unsigned NOT NULL default '0',
  `isadmin` tinyint(1) NOT NULL default '0',
  `times` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`username`,`isadmin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_type`
-- ----------------------------
DROP TABLE IF EXISTS `cms_type`;
CREATE TABLE `cms_type` (
  `typeid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `module` char(15) NOT NULL,
  `modelid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `name` char(30) NOT NULL,
  `parentid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `typedir` char(20) NOT NULL,
  `url` char(100) NOT NULL,
  `template` char(30) NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`typeid`),
  KEY `module` (`module`,`parentid`,`siteid`,`listorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_urlrule`
-- ----------------------------
DROP TABLE IF EXISTS `cms_urlrule`;
CREATE TABLE `cms_urlrule` (
  `urlruleid` smallint(5) unsigned NOT NULL auto_increment,
  `module` varchar(15) NOT NULL,
  `file` varchar(20) NOT NULL,
  `ishtml` tinyint(1) unsigned NOT NULL default '0',
  `urlrule` varchar(255) NOT NULL,
  `example` varchar(255) NOT NULL,
  PRIMARY KEY  (`urlruleid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cms_workflow`
-- ----------------------------
DROP TABLE IF EXISTS `cms_workflow`;
CREATE TABLE `cms_workflow` (
  `workflowid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `steps` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `workname` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `setting` text NOT NULL,
  `flag` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`workflowid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO `cms_workflow` (`workflowid`, `siteid`, `steps`, `workname`, `description`, `setting`) VALUES(1, 1, 1, '一级审核', '审核一次', '');
INSERT INTO `cms_workflow` (`workflowid`, `siteid`, `steps`, `workname`, `description`, `setting`) VALUES(2, 1, 2, '二级审核', '审核两次', '');
INSERT INTO `cms_workflow` (`workflowid`, `siteid`, `steps`, `workname`, `description`, `setting`) VALUES(3, 1, 3, '三级审核', '审核三次', '');
INSERT INTO `cms_workflow` (`workflowid`, `siteid`, `steps`, `workname`, `description`, `setting`) VALUES(4, 1, 4, '四级审核', '四级审核', '');

DROP TABLE IF EXISTS `cms_copyfrom`;
CREATE TABLE IF NOT EXISTS `cms_copyfrom` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sitename` varchar(30) NOT NULL,
  `siteurl` varchar(100) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cms_download`;
CREATE TABLE IF NOT EXISTS `cms_download` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `typeid` smallint(5) unsigned NOT NULL,
  `title` char(80) NOT NULL DEFAULT '',
  `style` char(24) NOT NULL DEFAULT '',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `keywords` char(40) NOT NULL DEFAULT '',
  `description` char(255) NOT NULL DEFAULT '',
  `posids` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `url` char(100) NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `sysadd` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `username` char(50) NOT NULL,
  `inputtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `systems` varchar(100) NOT NULL DEFAULT 'Win2000/WinXP/Win2003',
  `copytype` varchar(15) NOT NULL DEFAULT '',
  `language` varchar(10) NOT NULL DEFAULT '',
  `classtype` varchar(20) NOT NULL DEFAULT '',
  `version` varchar(20) NOT NULL DEFAULT '',
  `filesize` varchar(10) NOT NULL DEFAULT 'Unkown',
  `stars` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `status` (`status`,`listorder`,`id`),
  KEY `listorder` (`catid`,`status`,`listorder`,`id`),
  KEY `catid` (`catid`,`status`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

--
-- 转存表中的数据 `cms_download`
--


-- --------------------------------------------------------

--
-- 表的结构 `cms_download_data`
--

DROP TABLE IF EXISTS `cms_download_data`;
CREATE TABLE IF NOT EXISTS `cms_download_data` (
  `id` mediumint(8) unsigned DEFAULT '0',
  `content` text NOT NULL,
  `readpoint` smallint(5) unsigned NOT NULL DEFAULT '0',
  `groupids_view` varchar(100) NOT NULL,
  `paginationtype` tinyint(1) NOT NULL,
  `maxcharperpage` mediumint(6) NOT NULL,
  `template` varchar(30) NOT NULL,
  `paytype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `relation` varchar(255) NOT NULL DEFAULT '',
  `allow_comment` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `downfiles` mediumtext NOT NULL,
  `downfile` varchar(255) NOT NULL DEFAULT '',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

--
-- 转存表中的数据 `cms_download_data`
--


-- --------------------------------------------------------

--
-- 表的结构 `cms_news`
--

DROP TABLE IF EXISTS `cms_news`;
CREATE TABLE IF NOT EXISTS `cms_news` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `typeid` smallint(5) unsigned NOT NULL,
  `title` varchar(80) NOT NULL DEFAULT '',
  `style` char(24) NOT NULL DEFAULT '',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `keywords` char(40) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `posids` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `url` char(100) NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `sysadd` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `username` char(50) NOT NULL,
  `inputtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `status` (`status`,`listorder`,`id`),
  KEY `listorder` (`catid`,`status`,`listorder`,`id`),
  KEY `catid` (`catid`,`status`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

--
-- 转存表中的数据 `cms_news`
--


-- --------------------------------------------------------

--
-- 表的结构 `cms_news_data`
--

DROP TABLE IF EXISTS `cms_news_data`;
CREATE TABLE IF NOT EXISTS `cms_news_data` (
  `id` mediumint(8) unsigned DEFAULT '0',
  `content` mediumtext NOT NULL,
  `readpoint` smallint(5) unsigned NOT NULL DEFAULT '0',
  `groupids_view` varchar(100) NOT NULL,
  `paginationtype` tinyint(1) NOT NULL,
  `maxcharperpage` mediumint(6) NOT NULL,
  `template` varchar(30) NOT NULL,
  `paytype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `relation` varchar(255) NOT NULL DEFAULT '',
  `voteid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `allow_comment` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `copyfrom` varchar(100) NOT NULL DEFAULT '',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

--
-- 转存表中的数据 `cms_news_data`
--


-- --------------------------------------------------------

--
-- 表的结构 `cms_picture`
--

DROP TABLE IF EXISTS `cms_picture`;
CREATE TABLE IF NOT EXISTS `cms_picture` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `typeid` smallint(5) unsigned NOT NULL,
  `title` char(80) NOT NULL DEFAULT '',
  `style` char(24) NOT NULL DEFAULT '',
  `thumb` char(100) NOT NULL DEFAULT '',
  `keywords` char(40) NOT NULL DEFAULT '',
  `description` char(255) NOT NULL DEFAULT '',
  `posids` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `url` char(100) NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `sysadd` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `username` char(50) NOT NULL,
  `inputtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `status` (`status`,`listorder`,`id`),
  KEY `listorder` (`catid`,`status`,`listorder`,`id`),
  KEY `catid` (`catid`,`status`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

--
-- 转存表中的数据 `cms_picture`
--


-- --------------------------------------------------------

--
-- 表的结构 `cms_picture_data`
--

DROP TABLE IF EXISTS `cms_picture_data`;
CREATE TABLE IF NOT EXISTS `cms_picture_data` (
  `id` mediumint(8) unsigned DEFAULT '0',
  `content` text NOT NULL,
  `readpoint` smallint(5) unsigned NOT NULL DEFAULT '0',
  `groupids_view` varchar(100) NOT NULL,
  `paginationtype` tinyint(1) NOT NULL,
  `maxcharperpage` mediumint(6) NOT NULL,
  `template` varchar(30) NOT NULL,
  `paytype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `relation` varchar(255) NOT NULL DEFAULT '',
  `pictureurls` mediumtext NOT NULL,
  `copyfrom` varchar(255) NOT NULL DEFAULT '',
  `allow_comment` tinyint(1) unsigned NOT NULL DEFAULT '1',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- --------------------------------------------------------


--
-- 表的结构 `cms_extend_setting`
--

DROP TABLE IF EXISTS `cms_extend_setting`;
CREATE TABLE IF NOT EXISTS `cms_extend_setting` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `key` char(30) NOT NULL,
  `data` mediumtext,
  PRIMARY KEY (`id`),
  KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;


-- ----------------------------
-- Records of cms_linkage
-- ----------------------------
INSERT INTO `cms_linkage` (`id`, `name`, `type`, `code`) VALUES(1, '中国地区', 0, 'address');


-- ----------------------------
-- Records of cms_linkage_data_1
-- ----------------------------
INSERT INTO `cms_linkage_data_1` (`id`, `site`, `pid`, `pids`, `name`, `cname`, `child`, `hidden`, `childids`, `displayorder`) VALUES(1, 1, 0, '0', '北京', 'beijing', 0, 0, '1', 0);
INSERT INTO `cms_linkage_data_1` (`id`, `site`, `pid`, `pids`, `name`, `cname`, `child`, `hidden`, `childids`, `displayorder`) VALUES(2, 1, 0, '0', '天津', 'tianjin', 0, 0, '2', 0);

-- ----------------------------
-- Records of cms_menu
-- ----------------------------
--
-- 转存表中的数据 `cms_menu`
--

INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(1, 'panel', 0, 'admin', 'index', 'public_main', '', 'fa fa-home', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(2, 'admininfo', 1, 'admin', 'admin_manage', 'init', '', 'fa fa-user', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(3, 'editinfo', 2, 'admin', 'admin_manage', 'public_edit_info', '', 'fa fa-user', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(4, 'editpwd', 2, 'admin', 'admin_manage', 'public_edit_pwd', '', 'fa fa-unlock-alt', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(5, 'create_html_quick', 1, 'content', 'create_html_opt', 'index', '', 'fa fa-file-code-o', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(6, 'create_index', 5, 'content', 'create_html', 'public_index', '', 'fa fa-html5', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(7, 'sys_setting', 0, 'admin', 'setting', 'init', '', 'fa fa-cogs', 1, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(8, 'correlative_setting', 7, 'admin', 'admin', 'admin', '', 'fa fa-cogs', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(9, 'settingsave', 8, 'admin', 'setting', 'save', '', 'fa fa-save', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(10, 'site_management', 8, 'admin', 'site', 'init', '', 'fa fa-cog', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(11, 'add_site', 10, 'admin', 'site', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(12, 'site_edit', 10, 'admin', 'site', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(13, 'site_del', 10, 'admin', 'site', 'del', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(14, 'site_field_manage', 10, 'content', 'sitemodel_field', 'init', '&modelid=0', 'fa fa-puzzle-piece', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(15, 'release_point_management', 8, 'admin', 'release_point', 'init', '', 'fa fa-cogs', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(16, 'release_point_add', 15, 'admin', 'release_point', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(17, 'release_point_del', 15, 'admin', 'release_point', 'del', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(18, 'release_point_edit', 15, 'admin', 'release_point', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(19, 'attachment', 8, 'attachment', 'attachment', 'init', '', 'fa fa-folder', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(20, 'remote', 19, 'attachment', 'attachment', 'remote', '', 'fa fa-cloud', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(21, 'remote_add', 20, 'attachment', 'attachment', 'remote_add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(22, 'remote_edit', 20, 'attachment', 'attachment', 'remote_edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(23, 'remote_delete', 20, 'attachment', 'attachment', 'remote_delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(24, 'basic_config', 8, 'admin', 'setting', 'init', '', 'fa fa-cog', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(25, 'safe_config', 8, 'admin', 'setting', 'init', '&tab=2', 'fa fa-shield', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(26, 'email_config', 8, 'admin', 'setting', 'init', '&tab=3', 'fa fa-envelope', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(27, 'connect_config', 8, 'admin', 'setting', 'init', '&tab=4', 'fa fa-html5', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(28, 'setting_keyword_enable', 8, 'admin', 'setting', 'init', '&tab=5', 'fa fa-tags', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(29, 'admin_setting', 7, 'admin', '', '', '', 'fa fa-cog', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(30, 'role_manage', 29, 'admin', 'role', 'init', '', 'fa fa-users', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(31, 'role_add', 30, 'admin', 'role', 'add', '', 'fa fa-plus', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(32, 'priv_setting', 30, 'admin', 'role', 'priv_setting', '', 'fa fa-cog', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(33, 'role_priv', 30, 'admin', 'role', 'role_priv', '', 'fa fa-users', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(34, 'role_edit', 30, 'admin', 'role', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(35, 'member_manage', 30, 'admin', 'role', 'member_manage', '', 'fa fa-user', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(36, 'role_delete', 30, 'admin', 'role', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(37, 'admin_manage', 29, 'admin', 'admin_manage', 'init', '', 'fa fa-shield', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(38, 'admin_add', 37, 'admin', 'admin_manage', 'add', '', 'fa fa-plus', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(39, 'admin_edit', 37, 'admin', 'admin_manage', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(40, 'admin_delete', 37, 'admin', 'admin_manage', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(41, 'module', 0, 'admin', 'module', 'init', '', 'fa fa-puzzle-piece', 2, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(42, 'module_list', 41, 'admin', 'module', '', '', 'fa fa-list', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(43, 'pay', 42, 'pay', 'payment', 'pay_list', 's=3', 'fa fa-rmb', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(44, 'payments', 43, 'pay', 'payment', 'init', '', 'fa fa-rmb', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(45, 'payment_add', 44, 'pay', 'payment', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(46, 'payment_delete', 44, 'pay', 'payment', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(47, 'payment_edit', 44, 'pay', 'payment', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(48, 'paylist', 43, 'pay', 'payment', 'pay_list', '', 'fa fa-calendar', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(49, 'pay_delete', 48, 'pay', 'payment', 'pay_del', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(50, 'pay_cancel', 48, 'pay', 'payment', 'pay_cancel', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(51, 'discount', 48, 'pay', 'payment', 'discount', '', 'fa fa-rmb', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(52, 'modify_deposit', 43, 'pay', 'payment', 'modify_deposit', 's=1', 'fa fa-calendar-plus-o', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(53, 'spend_record', 43, 'pay', 'spend', 'init', '', 'fa fa-calendar-check-o', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(54, 'pay_stat', 43, 'pay', 'payment', 'pay_stat', '', 'fa fa-table', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(55, 'dbsource', 42, 'dbsource', 'data', 'init', '', 'fa fa-database', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(56, 'external_data_sources', 55, 'dbsource', 'dbsource_admin', 'init', '', 'fa fa-database', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(57, 'dbsource_add', 55, 'dbsource', 'dbsource_admin', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(58, 'dbsource_edit', 55, 'dbsource', 'dbsource_admin', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(59, 'dbsource_del', 55, 'dbsource', 'dbsource_admin', 'del', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(60, 'dbsource_data_add', 55, 'dbsource', 'data', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(61, 'dbsource_data_edit', 55, 'dbsource', 'data', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(62, 'dbsource_data_del', 55, 'dbsource', 'data', 'del', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(63, 'fulltext_search', 42, 'search', 'search_type', 'init', '', 'fa fa-search', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(64, 'manage_type', 63, 'search', 'search_type', 'init', '', 'fa fa-reorder', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(65, 'search_setting', 63, 'search', 'search_admin', 'setting', '', 'fa fa-cog', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(66, 'createindex', 63, 'search', 'search_admin', 'createindex', '', 'fa fa-refresh', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(67, 'add_search_type', 63, 'search', 'search_type', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(68, 'module_manage', 41, 'admin', 'module', '', '', 'fa fa-puzzle-piece', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(69, 'module_manage', 68, 'admin', 'module', 'init', '', 'fa fa-folder', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(70, 'content', 0, 'content', 'content', 'init', '', 'fa fa-th-large', 3, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(71, 'content_publish', 70, 'content', 'content', 'init', '', 'fa fa-th-large', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(72, 'content_manage', 71, 'content', 'content', 'init', '', 'fa fa-th-large', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(73, 'add_content', 72, 'content', 'content', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(74, 'check_content', 72, 'content', 'content', 'pass', '', 'fa fa-check-square-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(75, 'edit_content', 72, 'content', 'content', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(76, 'push_to_special', 72, 'content', 'push', 'init', '', 'fa fa-window-restore', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(77, 'move_content', 72, 'content', 'content', 'remove', '', 'fa fa-arrows', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(78, 'copy_to_special', 72, 'content', 'copy', 'init', '', 'fa fa-copy', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(79, 'add_othors', 72, 'content', 'content', 'add_othors', '', 'fa fa-cloud', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(80, 'delete_content', 72, 'content', 'content', 'delete', '', 'fa fa-trash-o', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(81, 'batch_show', 72, 'content', 'create_html', 'batch_show', '', 'fa fa-file-code-o', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(82, 'listorder', 72, 'content', 'content', 'listorder', '', 'fa fa-sort-amount-asc', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(83, 'recycle', 72, 'content', 'content', 'recycle_init', '', 'fa fa-trash-o', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(84, 'restore', 72, 'content', 'content', 'recycle', '', 'fa fa-reply', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(85, 'update', 72, 'content', 'content', 'update', '', 'fa fa-refresh', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(86, 'content_all', 72, 'content', 'content', 'initall', '', 'fa fa-th-large', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(87, 'attachment_manage', 71, 'attachment', 'manage', 'init', '', 'fa fa-folder', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(88, 'attachment_address_update', 87, 'attachment', 'address', 'update', '', 'fa fa-archive', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(89, 'attachment_manager_db', 87, 'attachment', 'manage', 'init', '', 'fa fa-database', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(90, 'attachment_manager_dir', 87, 'attachment', 'manage', 'dir', '', 'fa fa-folder', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(91, 'attachment_address_replace', 87, 'attachment', 'address', 'init', '', 'fa fa-search', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(92, 'special', 71, 'special', 'special', 'init', '', 'fa fa-th-list', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(93, 'add_special', 92, 'special', 'special', 'add', '', 'fa fa-plus', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(94, 'edit_special', 92, 'special', 'special', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(95, 'special_list', 92, 'special', 'special', 'init', '', 'fa fa-list', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(96, 'special_elite', 92, 'special', 'special', 'elite', '', 'fa fa-flag', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(97, 'delete_special', 92, 'special', 'special', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(98, 'special_listorder', 92, 'special', 'special', 'listorder', '', 'fa fa-sort-amount-asc', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(99, 'special_content_list', 92, 'special', 'content', 'init', '', 'fa fa-list', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(100, 'special_content_add', 99, 'special', 'content', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(101, 'special_content_list', 99, 'special', 'content', 'init', '', 'fa fa-list', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(102, 'special_content_edit', 99, 'special', 'content', 'edit', '', 'fa fa-globe', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(103, 'special_content_delete', 99, 'special', 'content', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(104, 'special_content_listorder', 99, 'special', 'content', 'listorder', '', 'fa fa-sort-amount-asc', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(105, 'special_content_import', 99, 'special', 'special', 'import', '', 'fa fa-upload', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(106, 'creat_html', 92, 'special', 'special', 'html', '', 'fa fa-file-code-o', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(107, 'create_special_list', 92, 'special', 'special', 'create_special_list', '', 'fa fa-home', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(108, 'block', 71, 'block', 'block_admin', 'init', '', 'fa fa-table', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(109, 'block_add', 108, 'block', 'block_admin', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(110, 'block_edit', 108, 'block', 'block_admin', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(111, 'block_del', 108, 'block', 'block_admin', 'del', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(112, 'block_update', 108, 'block', 'block_admin', 'block_update', '', 'fa fa-refresh', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(113, 'block_restore', 108, 'block', 'block_admin', 'history_restore', '', 'fa fa-reply', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(114, 'history_del', 108, 'block', 'block_admin', 'history_del', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(115, 'collection_node', 71, 'collection', 'node', 'manage', '', 'fa fa-th-large', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(116, 'node_add', 115, 'collection', 'node', 'add', '', 'fa fa-plus', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(117, 'collection_node_edit', 115, 'collection', 'node', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(118, 'collection_node_delete', 115, 'collection', 'node', 'del', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(119, 'collection_node_publish', 115, 'collection', 'node', 'publist', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(120, 'collection_node_import', 115, 'collection', 'node', 'node_import', '', 'fa fa-upload', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(121, 'collection_node_export', 115, 'collection', 'node', 'export', '', 'fa fa-upload', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(122, 'collection_node_collection_content', 115, 'collection', 'node', 'col_content', '', 'fa fa-list-alt', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(123, 'col_url_list', 115, 'collection', 'node', 'col_url_list', '', 'fa fa-link', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(124, 'copy_node', 115, 'collection', 'node', 'copy', '', 'fa fa-copy', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(125, 'content_del', 115, 'collection', 'node', 'content_del', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(126, 'collection_content_import', 115, 'collection', 'node', 'import', '', 'fa fa-list', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(127, 'import_program_add', 115, 'collection', 'node', 'import_program_add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(128, 'import_program_del', 115, 'collection', 'node', 'import_program_del', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(129, 'import_content', 115, 'collection', 'node', 'import_content', '', 'fa fa-upload', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(130, 'release_manage', 70, 'release', 'html', 'init', '', 'fa fa-file-code-o', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(131, 'create_list_html', 130, 'content', 'create_html', 'category', '', 'fa fa-th-large', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(132, 'create_index', 130, 'content', 'create_html', 'public_index', '', 'fa fa-home', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(133, 'a_clean_data', 130, 'content', 'content', 'clear_data', '', 'fa fa-trash-o', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(134, 'create_all', 130, 'content', 'create_all_html', 'all_update', '', 'fa fa-file-code-o', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(135, 'update_urls', 130, 'content', 'create_html', 'update_urls', '', 'fa fa-wrench', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(136, 'create_content_html', 130, 'content', 'create_html', 'show', '', 'fa fa-sticky-note', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(137, 'sync_release_point', 130, 'release', 'index', 'init', '', 'fa fa-globe', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(138, 'failure_list', 137, 'release', 'index', 'failed', '', 'fa fa-indent', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(139, 'queue_del', 137, 'release', 'index', 'del', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(140, 'content_settings', 70, 'content', 'content_settings', 'init', '', 'fa fa-cogs', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(141, 'category_manage', 140, 'admin', 'category', 'init', 'module=admin', 'fa fa-reorder', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(142, 'add_category', 141, 'admin', 'category', 'add', 's=0', 'fa fa-plus', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(143, 'edit_category', 141, 'admin', 'category', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(144, 'add_page', 141, 'admin', 'category', 'add', 's=1', 'fa fa-plus', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(145, 'add_cat_link', 141, 'admin', 'category', 'add', 's=2', 'fa fa-plus-square-o', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(146, 'category_cache', 141, 'admin', 'category', 'public_cache', 'module=admin', 'fa fa-globe', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(147, 'count_items', 141, 'admin', 'category', 'count_items', '', 'fa fa-refresh', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(148, 'category_batch_edit', 141, 'admin', 'category', 'batch_edit', '', 'fa fa-edit', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(149, 'category_field_manage', 141, 'content', 'sitemodel_field', 'init', '&modelid=-1', 'fa fa-code', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(150, 'page_field_manage', 141, 'content', 'sitemodel_field', 'init', '&modelid=-2', 'fa fa-list', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(151, 'model_manage', 140, 'content', 'sitemodel', 'init', '', 'fa fa-th-large', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(152, 'add_model', 151, 'content', 'sitemodel', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(153, 'sitemodel_import', 151, 'content', 'sitemodel', 'import', '', 'fa fa-upload', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(154, 'fields_manage', 151, 'content', 'sitemodel_field', 'init', '', 'fa fa-code', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(155, 'edit_model_content', 151, 'content', 'sitemodel', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(156, 'disabled_model', 151, 'content', 'sitemodel', 'disabled', '', 'fa fa-ban', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(157, 'delete_model', 151, 'content', 'sitemodel', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(158, 'export_model', 151, 'content', 'sitemodel', 'export', '', 'fa fa-upload', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(159, 'type_manage', 140, 'content', 'type_manage', 'init', '', 'fa fa-th-list', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(160, 'add_type', 159, 'content', 'type_manage', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(161, 'delete', 159, 'content', 'type_manage', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(162, 'edit', 159, 'content', 'type_manage', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(163, 'posid_manage', 140, 'admin', 'position', 'init', '', 'fa fa-flag', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(164, 'posid_add', 163, 'admin', 'position', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(165, 'position_edit', 163, 'admin', 'position', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(166, 'members', 0, 'member', 'member', 'init', '', 'fa fa-user', 4, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(167, 'manage_member', 166, 'member', 'member', 'manage', '', 'fa fa-user', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(168, 'member_manage', 167, 'member', 'member', 'manage', '', 'fa fa-user', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(169, 'member_lock', 168, 'member', 'member', 'lock', '', 'fa fa-lock', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(170, 'member_unlock', 168, 'member', 'member', 'unlock', '', 'fa fa-unlock-alt', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(171, 'member_move', 168, 'member', 'member', 'move', '', 'fa fa-arrows', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(172, 'member_delete', 168, 'member', 'member', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(173, 'member_search', 168, 'member', 'member', 'search', '', 'fa fa-search', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(174, 'member_edit', 168, 'member', 'member', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(175, 'view_memberlinfo', 168, 'member', 'member', 'memberinfo', '', 'fa fa-eye', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(176, 'member_add', 168, 'member', 'member', 'add', '', 'fa fa-user-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(177, 'member_verify', 167, 'member', 'member_verify', 'manage', 's=0', 'fa fa-check-square-o', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(178, 'verify_pass', 177, 'member', 'member_verify', 'manage', 's=1', 'fa fa-th-list', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(179, 'verify_ignore', 177, 'member', 'member_verify', 'manage', 's=2', 'fa fa-list-alt', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(180, 'verify_delete', 177, 'member', 'member_verify', 'manage', 's=3', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(181, 'verify_deny', 177, 'member', 'member_verify', 'manage', 's=4', 'fa fa-list', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(182, 'never_pass', 177, 'member', 'member_verify', 'manage', 's=5', 'fa fa-ban', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(183, 'operation_pass', 177, 'member', 'member_verify', 'pass', '', 'fa fa-check', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(184, 'operation_delete', 177, 'member', 'member_verify', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(185, 'operation_ignore', 177, 'member', 'member_verify', 'ignore', '', 'fa fa-code', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(186, 'operation_reject', 177, 'member', 'member_verify', 'reject', '', 'fa fa-ban', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(187, 'view_modelinfo', 177, 'member', 'member_verify', 'modelinfo', '', 'fa fa-eye', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(188, 'member_setting', 167, 'member', 'member_setting', 'manage', '', 'fa fa-search', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(189, 'manage_member_group', 166, 'member', 'member_group', 'manage', '', 'fa fa-users', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(190, 'member_group_manage', 189, 'member', 'member_group', 'manage', '', 'fa fa-users', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(191, 'member_group_add', 190, 'member', 'member_group', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(192, 'member_group_edit', 190, 'member', 'member_group', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(193, 'member_group_delete', 190, 'member', 'member_group', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(194, 'listorder', 189, 'member', 'member_group', 'sort', '', 'fa fa-sort-amount-asc', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(195, 'manage_member_model', 166, 'member', 'member_model', 'manage', '', 'fa fa-th-large', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(196, 'member_model_manage', 195, 'member', 'member_model', 'manage', '', 'fa fa-th-large', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(197, 'member_model_delete', 196, 'member', 'member_model', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(198, 'member_model_edit', 196, 'member', 'member_model', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(199, 'member_modelfield_add', 196, 'member', 'member_modelfield', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(200, 'member_modelfield_edit', 196, 'member', 'member_modelfield', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(201, 'member_modelfield_delete', 196, 'member', 'member_modelfield', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(202, 'member_modelfield_manage', 196, 'member', 'member_modelfield', 'manage', '', 'fa fa-code', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(203, 'member_model_add', 196, 'member', 'member_model', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(204, 'member_model_export', 195, 'member', 'member_model', 'export', '', 'fa fa-upload', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(205, 'member_model_sort', 195, 'member', 'member_model', 'sort', '', 'fa fa-sort-amount-asc', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(206, 'member_model_move', 195, 'member', 'member_model', 'move', '', 'fa fa-arrows', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(207, 'member_model_import', 195, 'member', 'member_model', 'import', '', 'fa fa-upload', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(208, 'userinterface', 0, 'template', 'style', 'init', '', 'fa fa-html5', 5, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(209, 'template_manager', 208, '', '', '', '', 'fa fa-home', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(210, 'template_style', 209, 'template', 'style', 'init', '', 'fa fa-css3', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(211, 'import_style', 210, 'template', 'style', 'import', '', 'fa fa-upload', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(212, 'template_file', 210, 'template', 'file', 'init', '', 'fa fa-file', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(213, 'template_export', 210, 'template', 'style', 'export', '', 'fa fa-upload', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(214, 'template_onoff', 210, 'template', 'style', 'disable', '', 'fa fa-cogs', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(215, 'template_updatename', 210, 'template', 'style', 'updatename', '', 'fa fa-file-code-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(216, 'template_file_list', 210, 'template', 'file', 'init', '', 'fa fa-desktop', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(217, 'template_file_edit', 210, 'template', 'file', 'edit_file', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(218, 'file_add_file', 210, 'template', 'file', 'add_file', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(219, 'template_editor', 210, 'template', 'file', 'edit_file', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(220, 'template_visualization', 210, 'template', 'file', 'visualization', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(221, 'pc_tag_edit', 210, 'template', 'file', 'edit_pc_tag', '', 'fa fa-calendar-check-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(222, 'history_version', 210, 'template', 'template_bak', 'init', '', 'fa fa-history', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(223, 'restore_version', 210, 'template', 'template_bak', 'restore', '', 'fa fa-reply', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(224, 'del_history_version', 210, 'template', 'template_bak', 'del', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(225, 'extend', 0, 'admin', 'urlrule', 'init', '', 'fa fa-puzzle-piece', 6, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(226, 'extend_all', 225, 'admin', 'extend_all', 'init', '', 'fa fa-puzzle-piece', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(227, 'urlrule_manage', 226, 'admin', 'urlrule', 'init', '', 'fa fa-link', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(228, 'add_urlrule', 227, 'admin', 'urlrule', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(229, 'edit_urlrule', 227, 'admin', 'urlrule', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(230, 'delete_urlrule', 227, 'admin', 'urlrule', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(231, 'ipbanned', 226, 'admin', 'ipbanned', 'init', '', 'fa fa-ban', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(232, 'add_ipbanned', 231, 'admin', 'ipbanned', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(233, 'delete_ip', 231, 'admin', 'ipbanned', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(234, 'downsites', 226, 'admin', 'downservers', 'init', '', 'fa fa-download', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(235, 'log', 226, 'admin', 'log', 'init', '', 'fa fa-calendar', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(236, 'delete_log', 235, 'admin', 'log', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(237, 'cache_all', 226, 'admin', 'cache_all', 'init', '', 'fa fa-refresh', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(238, 'scan', 226, 'scan', 'index', 'init', '', 'fa fa-bug', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(239, 'scan_report', 238, 'scan', 'index', 'scan_report', '', 'fa fa-file-text', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(240, 'md5_creat', 238, 'scan', 'index', 'md5_creat', '', 'fa fa-file', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(241, 'copyfrom_manage', 226, 'admin', 'copyfrom', 'init', '', 'fa fa-globe', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(242, 'member_menu_manage', 226, 'member', 'member_menu', 'manage', '', 'fa fa-list-alt', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(243, 'member_menu_add', 242, 'member', 'member_menu', 'add', '', 'fa fa-plus', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(244, 'member_menu_edit', 242, 'member', 'member_menu', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(245, 'member_menu_delete', 242, 'member', 'member_menu', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(246, 'public_error', 226, 'admin', 'index', 'public_error', '', 'fa fa-shield', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(247, 'check_bom', 226, 'admin', 'check_bom', 'init', '', 'fa fa-code', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(248, 'check', 226, 'admin', 'check', 'init', '', 'fa fa-wrench', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(249, 'public_error_log', 226, 'admin', 'index', 'public_error_log', '', 'fa fa-shield', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(250, 'public_email_log', 226, 'admin', 'index', 'public_email_log', '', 'fa fa-envelope-open', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(251, 'database_toos', 226, 'admin', 'database', 'export', '', 'fa fa-database', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(252, 'database_export', 251, 'admin', 'database', 'export', '', 'fa fa-upload', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(253, 'database_import', 251, 'admin', 'database', 'import', '', 'fa fa-upload', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(254, 'menu_manage', 226, 'admin', 'menu', 'init', '', 'fa fa-list-alt', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(255, 'menu_add', 254, 'admin', 'menu', 'add', '', 'fa fa-plus', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(256, 'edit_menu', 254, 'admin', 'menu', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(257, 'delete_menu', 254, 'admin', 'menu', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(258, 'badword_manage', 226, 'admin', 'badword', 'init', '', 'fa fa-tag', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(259, 'badword_export', 258, 'admin', 'badword', 'export', '', 'fa fa-upload', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(260, 'badword_import', 258, 'admin', 'badword', 'import', '', 'fa fa-upload', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(261, 'badword_add', 258, 'admin', 'badword', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(262, 'badword_edit', 258, 'admin', 'badword', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(263, 'badword_delete', 258, 'admin', 'badword', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(264, 'googlesitemap', 226, 'admin', 'googlesitemap', 'set', '', 'fa fa-sitemap', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(265, 'keylink', 226, 'admin', 'keylink', 'init', '', 'fa fa-chain', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(266, 'add_keylink', 265, 'admin', 'keylink', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(267, 'delete_keylink', 265, 'admin', 'keylink', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(268, 'edit_keylink', 265, 'admin', 'keylink', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(269, 'linkage', 226, 'admin', 'linkage', 'init', '', 'fa fa-columns', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(270, 'linkageadd', 269, 'admin', 'linkage', 'add', '', 'fa fa-plus', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(271, 'workflow', 226, 'content', 'workflow', 'init', '', 'fa fa-sort-numeric-asc', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(272, 'add_workflow', 271, 'content', 'workflow', 'add', '', 'fa fa-plus', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(273, 'edit_workflow', 271, 'content', 'workflow', 'edit', '', 'fa fa-edit', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(274, 'delete_workflow', 271, 'content', 'workflow', 'delete', '', 'fa fa-trash-o', 0, '0', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(275, 'cloud_service', 225, 'admin', 'cloud', 'init', '', 'fa fa-cloud', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(276, 'my_website', 275, 'admin', 'cloud', 'init', '', 'fa fa-cog', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(277, 'version_update', 275, 'admin', 'cloud', 'upgrade', '', 'fa fa-refresh', 0, '1', 1, 1, 1, 1, 1);
INSERT INTO `cms_menu` (`id`, `name`, `parentid`, `m`, `c`, `a`, `data`, `icon`, `listorder`, `display`, `project1`, `project2`, `project3`, `project4`, `project5`) VALUES(278, 'file_compare', 275, 'admin', 'cloud', 'compare', '', 'fa fa-code', 0, '1', 1, 1, 1, 1, 1);

-- ----------------------------
-- Records of cms_module
-- ----------------------------
INSERT INTO `cms_module` VALUES ('admin', 'admin', '', '1', '1.0', '', '{"admin_email":"zhaoxunzhiyin@163.com","category_ajax":"0","errorlog_size":"20","sysadmincode":"0","sysadmincodemodel":"0","captcha_charset":"","sysadmincodevoicemodel":"0","sysadmincodelen":"4","maxloginfailedtimes":"8","sysadminlogintimes":"10","minrefreshtime":"2","pwd_use":{"0":"admin","1":"member"},"pwd_is_edit":"1","pwd_day_edit":"10","pwd_is_login_edit":"1","login_use":{"0":"admin","1":"member"},"login_is_option":"1","login_exit_time":"30","login_city":"0","login_llq":"0","safe_use":{"0":"admin","1":"member"},"safe_wdl":"30","mail_type":"1","mail_server":"smtp.qq.com","mail_port":"25","mail_from":"zhaoxunzhiyin@qq.com","mail_auth":"1","mail_user":"zhaoxunzhiyin@qq.com","mail_password":""}', '0', '0', CURDATE(), CURDATE());

INSERT INTO `cms_module` VALUES ('member', '会员', '', '1', '1.0', '', '{"maxloginfailedtimes":"8","syslogintimes":"10","logintime":"0","allowregister":"1","choosemodel":"1","mobile_checktype":"0","user_sendsms_title":"","rmb_point_rate":"10","defualtpoint":"0","defualtamount":"0","regprotocol":"\\t\\t 欢迎您注册成为本站用户\\r\\n请仔细阅读下面的协议，只有接受协议才能继续进行注册。 \\r\\n1．服务条款的确认和接纳\\r\\n　　本站用户服务的所有权和运作权归本站拥有。本站所提供的服务将按照有关章程、服务条款和操作规则严格执行。用户通过注册程序点击“我同意” 按钮，即表示用户与本站达成协议并接受所有的服务条款。\\r\\n2． 本站服务简介\\r\\n　　本站通过国际互联网为用户提供新闻及文章浏览、图片浏览、软件下载、网上留言和BBS论坛等服务。\\r\\n　　用户必须： \\r\\n　　1)购置设备，包括个人电脑一台、调制解调器一个及配备上网装置。 \\r\\n　　2)个人上网和支付与此服务有关的电话费用、网络费用。\\r\\n　　用户同意： \\r\\n　　1)提供及时、详尽及准确的个人资料。 \\r\\n　　2)不断更新注册资料，符合及时、详尽、准确的要求。所有原始键入的资料将引用为注册资料。 \\r\\n　　3)用户同意遵守《中华人民共和国保守国家秘密法》、《中华人民共和国计算机信息系统安全保护条例》、《计算机软件保护条例》等有关计算机及互联网规定的法律和法规、实施办法。在任何情况下，本站合理地认为用户的行为可能违反上述法律、法规，本站可以在任何时候，不经事先通知终止向该用户提供服务。用户应了解国际互联网的无国界性，应特别注意遵守当地所有有关的法律和法规。\\r\\n3． 服务条款的修改\\r\\n　　本站会不定时地修改服务条款，服务条款一旦发生变动，将会在相关页面上提示修改内容。如果您同意改动，则再一次点击“我同意”按钮。 如果您不接受，则及时取消您的用户使用服务资格。\\r\\n4． 服务修订\\r\\n　　本站保留随时修改或中断服务而不需知照用户的权利。本站行使修改或中断服务的权利，不需对用户或第三方负责。\\r\\n5． 用户隐私制度\\r\\n　　尊重用户个人隐私是本站的 基本政策。本站不会公开、编辑或透露用户的注册信息，除非有法律许可要求，或本站在诚信的基础上认为透露这些信息在以下三种情况是必要的： \\r\\n　　1)遵守有关法律规定，遵从合法服务程序。 \\r\\n　　2)保持维护本站的商标所有权。 \\r\\n　　3)在紧急情况下竭力维护用户个人和社会大众的隐私安全。 \\r\\n　　4)符合其他相关的要求。 \\r\\n6．用户的帐号，密码和安全性\\r\\n　　一旦注册成功成为本站用户，您将得到一个密码和帐号。如果您不保管好自己的帐号和密码安全，将对因此产生的后果负全部责任。另外，每个用户都要对其帐户中的所有活动和事件负全责。您可随时根据指示改变您的密码，也可以结束旧的帐户重开一个新帐户。用户同意若发现任何非法使用用户帐号或安全漏洞的情况，立即通知本站。\\r\\n7． 免责条款\\r\\n　　用户明确同意网站服务的使用由用户个人承担风险。 　　 \\r\\n　　本站不作任何类型的担保，不担保服务一定能满足用户的要求，也不担保服务不会受中断，对服务的及时性，安全性，出错发生都不作担保。用户理解并接受：任何通过本站服务取得的信息资料的可靠性取决于用户自己，用户自己承担所有风险和责任。 \\r\\n8．有限责任\\r\\n　　本站对任何直接、间接、偶然、特殊及继起的损害不负责任。\\r\\n9． 不提供零售和商业性服务 \\r\\n　　用户使用网站服务的权利是个人的。用户只能是一个单独的个体而不能是一个公司或实体商业性组织。用户承诺不经本站同意，不能利用网站服务进行销售或其他商业用途。\\r\\n10．用户责任 \\r\\n　　用户单独承担传输内容的责任。用户必须遵循： \\r\\n　　1)从中国境内向外传输技术性资料时必须符合中国有关法规。 \\r\\n　　2)使用网站服务不作非法用途。 \\r\\n　　3)不干扰或混乱网络服务。 \\r\\n　　4)不在论坛BBS或留言簿发表任何与政治相关的信息。 \\r\\n　　5)遵守所有使用网站服务的网络协议、规定、程序和惯例。\\r\\n　　6)不得利用本站危害国家安全、泄露国家秘密，不得侵犯国家社会集体的和公民的合法权益。\\r\\n　　7)不得利用本站制作、复制和传播下列信息： \\r\\n　　　1、煽动抗拒、破坏宪法和法律、行政法规实施的；\\r\\n　　　2、煽动颠覆国家政权，推翻社会主义制度的；\\r\\n　　　3、煽动分裂国家、破坏国家统一的；\\r\\n　　　4、煽动民族仇恨、民族歧视，破坏民族团结的；\\r\\n　　　5、捏造或者歪曲事实，散布谣言，扰乱社会秩序的；\\r\\n　　　6、宣扬封建迷信、淫秽、色情、赌博、暴力、凶杀、恐怖、教唆犯罪的；\\r\\n　　　7、公然侮辱他人或者捏造事实诽谤他人的，或者进行其他恶意攻击的；\\r\\n　　　8、损害国家机关信誉的；\\r\\n　　　9、其他违反宪法和法律行政法规的；\\r\\n　　　10、进行商业广告行为的。\\r\\n　　用户不能传输任何教唆他人构成犯罪行为的资料；不能传输长国内不利条件和涉及国家安全的资料；不能传输任何不符合当地法规、国家法律和国际法 律的资料。未经许可而非法进入其它电脑系统是禁止的。若用户的行为不符合以上的条款，本站将取消用户服务帐号。\\r\\n11．网站内容的所有权\\r\\n　　本站定义的内容包括：文字、软件、声音、相片、录象、图表；在广告中全部内容；电子邮件的全部内容；本站为用户提供的商业信息。所有这些内容受版权、商标、标签和其它财产所有权法律的保护。所以，用户只能在本站和广告商授权下才能使用这些内容，而不能擅自复制、篡改这些内容、或创造与内容有关的派生产品。\\r\\n12．附加信息服务\\r\\n　　用户在享用本站提供的免费服务的同时，同意接受本站提供的各类附加信息服务。\\r\\n13．解释权\\r\\n　　本注册协议的解释权归本站所有。如果其中有任何条款与国家的有关法律相抵触，则以国家法律的明文规定为准。 ","registerverifymessage":" 欢迎您注册成为本站用户，您的账号需要邮箱认证，点击下面链接进行认证：{click}\\r\\n或者将网址复制到浏览器：{url}","forgetpassword":" 本站密码找回，请在一小时内点击下面链接进行操作：{click}\\r\\n或者将网址复制到浏览器：{url}","notallow":"","config":{"userlen":"0","userlenmax":"50","pwdlen":"0","pwdmax":"50","pwdpreg":"","preg":"\\/^[a-zA-Z0-9_\\\\x7f-\\\\xff][a-zA-Z0-9_\\\\x7f-\\\\xff]+$\\/\"},"enablemailcheck":"0","enablcodecheck":"1","registerverify":"0","showapppoint":"0","showregprotocol":"0","list_field":{"username":{"use":"1","name":"账号","width":"110","func":"author"},"nickname":{"use":"1","name":"昵称","width":"120","func":""},"amount":{"use":"1","name":"余额","width":"120","func":"money"},"point":{"use":"1","name":"积分","width":"120","func":"score"},"regip":{"use":"1","name":"注册IP","width":"140","func":"ip"},"regdate":{"use":"1","name":"注册时间","width":"170","func":"datetime"},"userid":{"name":"用户ID","width":"","func":""},"groupid":{"name":"用户组","width":"","center":"1","func":"group"},"email":{"name":"邮箱","width":"","func":""},"mobile":{"name":"手机","width":"","func":""}}}', '0', '0', CURDATE(), CURDATE());

INSERT INTO `cms_module` VALUES ('pay', '支付', '', '1', '1.0', '', '', '0', '0', CURDATE(), CURDATE());

INSERT INTO `cms_module` VALUES ('digg', '顶一下', '', '1', '1.0', '', '', '0', '0', CURDATE(), CURDATE());
INSERT INTO `cms_module` VALUES ('special', '专题', '', '1', '1.0', '', '', '0', '0', CURDATE(), CURDATE());
INSERT INTO `cms_module` VALUES ('content', '内容模块', '', '1', '1.0', '', '', '0', '0', CURDATE(), CURDATE());
INSERT INTO `cms_module` VALUES ('mobile', '手机模块', '', '1', '1.0', '', '', '0', '0', CURDATE(), CURDATE());
INSERT INTO `cms_module` VALUES ('search', '全站搜索', '', '1', '1.0', '', '{"fulltextenble":"1","relationenble":"1","suggestenable":"1","sphinxenable":"0","sphinxhost":"10.228.134.102","sphinxport":"9312","1":{"fulltextenble":"0","relationenble":"0","suggestenable":"0","sphinxenable":"0","sphinxhost":"","sphinxport":""}}', '0', '0', CURDATE(), CURDATE());

INSERT INTO `cms_module` VALUES ('scan', '木马扫描', 'scan', '1', '1.0', '', '', '0', '0', CURDATE(), CURDATE());
INSERT INTO `cms_module` VALUES ('attachment', '附件', 'attachment', '1', '1.0', '', '', '0', '0', CURDATE(), CURDATE());
INSERT INTO `cms_module` VALUES ('block', '碎片', '', '1', '1.0', '', '', '0', '0', CURDATE(), CURDATE());
INSERT INTO `cms_module` VALUES ('collection', '采集模块', 'collection', '1', '1.0', '', '', '0', '0', CURDATE(), CURDATE());
INSERT INTO `cms_module` VALUES ('dbsource', '数据源', '', '1', '1.0', '', '', '0', '0', CURDATE(), CURDATE());
INSERT INTO `cms_module` VALUES ('template', '模板风格', '', '1', '1.0', '', '', '0', '0', CURDATE(), CURDATE());
INSERT INTO `cms_module` VALUES ('release', '发布点', '', '1', '1.0', '', '', '0', '0', CURDATE(), CURDATE());

-- ----------------------------
-- Records of cms_type
-- ----------------------------
INSERT INTO `cms_type` (`siteid`, `typeid`, `module`, `modelid`, `name`, `parentid`, `typedir`, `url`, `template`, `listorder`, `description`) VALUES('1', '52', 'search', '0', '专题', '0', 'special', '', '', '4', '专题');
INSERT INTO `cms_type` (`siteid`, `typeid`, `module`, `modelid`, `name`, `parentid`, `typedir`, `url`, `template`, `listorder`, `description`) VALUES('1', '1', 'search', '1', '新闻', '0', '', '', '', '1', '新闻模型搜索');
INSERT INTO `cms_type` (`siteid`, `typeid`, `module`, `modelid`, `name`, `parentid`, `typedir`, `url`, `template`, `listorder`, `description`) VALUES('1', '2', 'search', '2', '下载', '0', '', '', '', '3', '下载模型搜索');
INSERT INTO `cms_type` (`siteid`, `typeid`, `module`, `modelid`, `name`, `parentid`, `typedir`, `url`, `template`, `listorder`, `description`) VALUES('1', '3', 'search', '3', '图片', '0', '', '', '', '2', '图片模型搜索');



-- ----------------------------
-- Records of cms_urlrule
-- ----------------------------
INSERT INTO `cms_urlrule` VALUES ('1', 'content', 'category', '1', '{$categorydir}{$catdir}/index.html|{$categorydir}{$catdir}/{$page}.html', 'news/china/1000.html');
INSERT INTO `cms_urlrule` VALUES ('6', 'content', 'category', '0', 'index.php?m=content&c=index&a=lists&catid={$catid}|index.php?m=content&c=index&a=lists&catid={$catid}&page={$page}', 'index.php?m=content&c=index&a=lists&catid=1&page=1');
INSERT INTO `cms_urlrule` VALUES ('11', 'content', 'show', '1', '{$year}/{$catdir}_{$month}{$day}/{$id}.html|{$year}/{$catdir}_{$month}{$day}/{$id}_{$page}.html', '2010/catdir_0720/1_2.html');
INSERT INTO `cms_urlrule` VALUES ('12', 'content', 'show', '1', '{$categorydir}{$catdir}/{$year}/{$month}{$day}/{$id}.html|{$categorydir}{$catdir}/{$year}/{$month}{$day}/{$id}_{$page}.html', 'it/product/2010/0720/1_2.html');
INSERT INTO `cms_urlrule` VALUES ('16', 'content', 'show', '0', 'index.php?m=content&c=index&a=show&catid={$catid}&id={$id}|index.php?m=content&c=index&a=show&catid={$catid}&id={$id}&page={$page}', 'index.php?m=content&c=index&a=show&catid=1&id=1');
INSERT INTO `cms_urlrule` VALUES ('17', 'content', 'show', '0', 'show-{$catid}-{$id}-{$page}.html', 'show-1-2-1.html');
INSERT INTO `cms_urlrule` VALUES ('18', 'content', 'show', '0', 'content-{$catid}-{$id}-{$page}.html', 'content-1-2-1.html');
INSERT INTO `cms_urlrule` VALUES ('30', 'content', 'category', '0', 'list-{$catid}-{$page}.html', 'list-1-1.html');


-- ----------------------------
-- Records of cms_model
-- ----------------------------
INSERT INTO `cms_model` (`modelid`, `siteid`, `name`, `description`, `tablename`, `setting`, `enablesearch`, `disabled`, `default_style`, `category_template`, `list_template`, `show_template`, `sort`, `type`) VALUES(1, 1, '文章模型', '', 'news', '{"updatetime_select":"0","order":"updatetime DESC","search_time":"updatetime","list_field":{"title":{"use":"1","name":"主题","width":"","func":"title"},"username":{"use":"1","name":"用户名","width":"100","func":""},"updatetime":{"use":"1","name":"更新时间","width":"180","func":"datetime"},"listorder":{"use":"1","name":"排序","width":"100","center":"1","func":"save_text_value"}},"category_template":"category","list_template":"list","show_template":"show","admin_list_template":"","member_add_template":""}', 1, 0, 'default', 'category', 'list', 'show', 0, 0);
INSERT INTO `cms_model` (`modelid`, `siteid`, `name`, `description`, `tablename`, `setting`, `enablesearch`, `disabled`, `default_style`, `category_template`, `list_template`, `show_template`, `sort`, `type`) VALUES(2, 1, '下载模型', '', 'download', '{"updatetime_select":"0","order":"updatetime DESC","search_time":"updatetime","list_field":{"title":{"use":"1","name":"主题","width":"","func":"title"},"username":{"use":"1","name":"用户名","width":"100","func":""},"updatetime":{"use":"1","name":"更新时间","width":"180","func":"datetime"},"listorder":{"use":"1","name":"排序","width":"100","center":"1","func":"save_text_value"}},"category_template":"category_download","list_template":"list_download","show_template":"show_download","admin_list_template":"","member_add_template":""}', 1, 0, 'default', 'category_download', 'list_download', 'show_download', 0, 0);
INSERT INTO `cms_model` (`modelid`, `siteid`, `name`, `description`, `tablename`, `setting`, `enablesearch`, `disabled`, `default_style`, `category_template`, `list_template`, `show_template`, `sort`, `type`) VALUES(3, 1, '图片模型', '', 'picture', '{"updatetime_select":"0","order":"updatetime DESC","search_time":"updatetime","list_field":{"title":{"use":"1","name":"主题","width":"","func":"title"},"username":{"use":"1","name":"用户名","width":"100","func":""},"updatetime":{"use":"1","name":"更新时间","width":"180","func":"datetime"},"listorder":{"use":"1","name":"排序","width":"100","center":"1","func":"save_text_value"}},"category_template":"category_picture","list_template":"list_picture","show_template":"show_picture","admin_list_template":"","member_add_template":""}', 1, 0, 'default', 'category_picture', 'list_picture', 'show_picture', 0, 0);
INSERT INTO `cms_model` (`modelid`, `siteid`, `name`, `description`, `tablename`, `enablesearch`, `disabled`, `default_style`, `category_template`, `list_template`, `show_template`, `sort`, `type`) VALUES(10, 1, '普通会员', '普通会员', 'member_detail', 1, 0, '', '', '', '', 0, 2);

-- ----------------------------
-- Records of cms_model_field
-- ----------------------------

INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(1, 1, 1, 'catid', '栏目', '', '', 1, 6, '/^[0-9]{1,6}$/', '请选择栏目', 'catid', '', '', '', '', 0, 1, 0, 1, 1, 1, 0, 0, 1, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(2, 1, 1, 'typeid', '类别', '', '', 0, 0, '', '', 'typeid', '{\"minnumber\":\"\",\"defaultvalue\":\"\"}', '', '', '', 0, 1, 0, 1, 1, 1, 0, 0, 2, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(3, 1, 1, 'title', '标题', '', 'inputtitle', 1, 80, '', '请输入标题', 'title', '', '', '', '', 0, 1, 0, 1, 1, 1, 1, 1, 4, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(4, 1, 1, 'thumb', '缩略图', '', '', 0, 100, '', '', 'image', '{\"size\":\"50\",\"defaultvalue\":\"\",\"show_type\":\"1\",\"upload_allowext\":\"jpg|jpeg|gif|png|bmp\",\"watermark\":\"1\",\"isselectimage\":\"1\",\"images_width\":\"\",\"images_height\":\"\"}', '', '', '', 0, 1, 0, 0, 0, 1, 0, 1, 14, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(5, 1, 1, 'keywords', '关键词', '多关键词之间用“,”隔开', '', 0, 40, '', '', 'keyword', '', 'data-role=\'tagsinput\'', '', '', 0, 1, 0, 1, 1, 1, 1, 0, 7, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(6, 1, 1, 'description', '摘要', '', '', 0, 255, '', '', 'textarea', '{\"width\":\"\",\"height\":\"\",\"defaultvalue\":\"\",\"enablehtml\":\"0\"}', '', '', '', 0, 1, 0, 1, 0, 1, 1, 1, 10, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(7, 1, 1, 'content', '内容', '', '', 1, 999999, '', '内容不能为空', 'editor', '{\"width\":\"\",\"height\":\"\",\"toolbar\":\"full\",\"toolvalue\":\"\'Bold\', \'Italic\', \'Underline\'\",\"defaultvalue\":\"\",\"enablekeylink\":\"1\",\"replacenum\":\"2\",\"link_mode\":\"0\",\"show_bottom_boot\":\"1\",\"tool_select_1\":\"1\",\"tool_select_2\":\"1\",\"tool_select_3\":\"1\",\"tool_select_4\":\"1\",\"color\":\"\",\"theme\":\"default\",\"autofloat\":\"0\",\"div2p\":\"1\",\"autoheight\":\"0\",\"enter\":\"0\",\"simpleupload\":\"0\",\"watermark\":\"1\",\"attachment\":\"0\",\"image_reduce\":\"\",\"allowupload\":\"0\",\"upload_number\":\"\",\"upload_maxsize\":\"\",\"enablesaveimage\":\"0\",\"local_img\":\"1\",\"local_watermark\":\"1\",\"local_attachment\":\"0\",\"local_image_reduce\":\"\",\"disabled_page\":\"0\"}', '', '', '', 0, 0, 0, 1, 0, 1, 1, 0, 13, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(8, 1, 1, 'voteid', '添加投票', '', '', 0, 0, '', '', 'omnipotent', '{\"formtext\":\"<input type=\'text\' name=\'info[voteid]\' id=\'voteid\' value=\'{FIELD_VALUE}\' size=\'3\'> \\r\\n<input type=\'button\' value=\\\"选择已有投票\\\" onclick=\\\"omnipotent(\'selectid\',\'?m=vote&c=vote&a=public_get_votelist&from_api=1\',\'选择已有投票\')\\\" class=\\\"button\\\">\\r\\n<input type=\'button\' value=\\\"新增投票\\\" onclick=\\\"omnipotent(\'addvote\',\'?m=vote&c=vote&a=add&from_api=1\',\'添加投票\',0)\\\" class=\\\"button\\\">\",\"fieldtype\":\"mediumint\",\"minnumber\":\"1\"}', '', '', '', 0, 0, 0, 1, 0, 0, 1, 0, 21, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(9, 1, 1, 'pages', '分页方式', '', '', 0, 0, '', '', 'pages', '', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 0, 16, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(10, 1, 1, 'inputtime', '发布时间', '', '', 0, 0, '', '', 'datetime', '{\"width\":\"\",\"fieldtype\":\"int\",\"format\":\"1\",\"format2\":\"0\",\"is_left\":\"0\",\"defaultvalue\":\"\",\"color\":\"\"}', '', '', '', 0, 1, 0, 0, 0, 0, 0, 1, 17, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(11, 1, 1, 'updatetime', '更新时间', '', '', 0, 0, '', '', 'datetime', '{\"width\":\"\",\"fieldtype\":\"int\",\"format\":\"1\",\"format2\":\"0\",\"is_left\":\"0\",\"defaultvalue\":\"\",\"color\":\"\"}', '', '', '', 0, 1, 0, 0, 0, 0, 0, 0, 18, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(12, 1, 1, 'posids', '推荐位', '', '', 0, 0, '', '', 'posid', '{\"cols\":\"4\",\"width\":\"145\"}', '', '', '', 0, 1, 0, 1, 0, 0, 0, 0, 19, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(13, 1, 1, 'islink', '转向链接', '', '', 0, 0, '', '', 'islink', '', '', '', '', 0, 1, 0, 0, 0, 1, 0, 0, 30, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(14, 1, 1, 'url', 'URL', '', '', 0, 100, '', '', 'text', '', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 50, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(15, 1, 1, 'listorder', '排序', '', '', 0, 6, '', '', 'number', '', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 51, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(16, 1, 1, 'status', '状态', '', '', 0, 2, '', '', 'box', '', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 55, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(17, 1, 1, 'template', '内容页模板', '', '', 0, 30, '', '', 'template', '{\"size\":\"\",\"defaultvalue\":\"\"}', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 53, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(18, 1, 1, 'groupids_view', '阅读权限', '', '', 0, 0, '', '', 'groupid', '{\"groupids\":\"\"}', '', '', '', 0, 0, 0, 1, 0, 0, 0, 0, 20, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(19, 1, 1, 'readpoint', '阅读收费', '', '', 0, 5, '', '', 'readpoint', '{\"minnumber\":\"1\",\"maxnumber\":\"99999\",\"decimaldigits\":\"0\",\"defaultvalue\":\"\"}', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 55, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(20, 1, 1, 'relation', '相关文章', '', '', 0, 0, '', '', 'omnipotent', '{\"formtext\":\"<input type=\'hidden\' name=\'info[relation]\' id=\'relation\' value=\'{FIELD_VALUE}\' style=\'50\' >\\r\\n<ul class=\\\"list-dot\\\" id=\\\"relation_text\\\"><\\/ul>\\r\\n<div>\\r\\n<input type=\'button\' value=\\\"添加相关\\\" onclick=\\\"omnipotent(\'selectid\',\'?m=content&c=content&a=public_relationlist&modelid={MODELID}\',\'添加相关文章\',1)\\\" class=\\\"button\\\" style=\\\"width:66px;\\\">\\r\\n<span class=\\\"edit_content\\\">\\r\\n<input type=\'button\' value=\\\"显示已有\\\" onclick=\\\"show_relation({MODELID},{ID})\\\" class=\\\"button\\\" style=\\\"width:66px;\\\">\\r\\n<\\/span>\\r\\n<\\/div>\",\"fieldtype\":\"varchar\",\"minnumber\":\"1\"}', '', '2,6,4,5,1,17,18,7', '', 0, 0, 0, 0, 0, 0, 1, 0, 15, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(21, 1, 1, 'allow_comment', '允许评论', '', '', 0, 0, '', '', 'box', '{\"options\":\"允许评论|1\\r\\n不允许评论|0\",\"boxtype\":\"radio\",\"fieldtype\":\"tinyint\",\"minnumber\":\"1\",\"width\":\"100\",\"size\":\"1\",\"defaultvalue\":\"1\",\"outputtype\":\"1\",\"filtertype\":\"0\"}', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 54, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(22, 1, 1, 'copyfrom', '来源', '', '', 0, 100, '', '', 'copyfrom', '{\"defaultvalue\":\"\"}', '', '', '', 0, 0, 0, 1, 0, 1, 0, 0, 8, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(23, 1, 1, 'username', '用户名', '', '', 0, 20, '', '', 'text', '', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 98, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(24, 2, 1, 'catid', '栏目', '', '', 1, 6, '/^[0-9]{1,6}$/', '请选择栏目', 'catid', '{\"defaultvalue\":\"\"}', '', '-99', '-99', 0, 1, 0, 1, 1, 1, 0, 0, 1, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(25, 2, 1, 'typeid', '类别', '', '', 0, 0, '', '', 'typeid', '{\"minnumber\":\"\",\"defaultvalue\":\"\"}', '', '', '', 0, 1, 0, 1, 1, 1, 0, 0, 2, 1, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(26, 2, 1, 'title', '标题', '', 'inputtitle', 1, 80, '', '请输入标题', 'title', '', '', '', '', 0, 1, 0, 1, 1, 1, 1, 1, 4, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(27, 2, 1, 'keywords', '关键词', '多关键词之间用“,”隔开', '', 0, 40, '', '', 'keyword', '{\"size\":\"100\",\"defaultvalue\":\"\"}', 'data-role=\'tagsinput\'', '-99', '-99', 0, 1, 0, 1, 1, 1, 1, 0, 7, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(28, 2, 1, 'description', '摘要', '', '', 0, 255, '', '', 'textarea', '{\"width\":\"\",\"height\":\"\",\"defaultvalue\":\"\",\"enablehtml\":\"0\"}', '', '', '', 0, 1, 0, 1, 0, 1, 1, 1, 10, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(29, 2, 1, 'content', '内容', '', '', 1, 999999, '', '内容不能为空', 'editor', '{\"toolbar\":\"full\",\"toolvalue\":\"\'Bold\', \'Italic\', \'Underline\'\",\"defaultvalue\":\"\",\"enablekeylink\":\"1\",\"replacenum\":\"2\",\"link_mode\":\"0\",\"color\":\"\",\"theme\":\"default\",\"autofloat\":\"0\",\"div2p\":\"1\",\"autoheight\":\"0\",\"enter\":\"0\",\"simpleupload\":\"0\",\"watermark\":\"1\",\"attachment\":\"0\",\"image_reduce\":\"\",\"enablesaveimage\":\"1\",\"height\":\"\",\"local_img\":\"1\",\"local_watermark\":\"1\",\"local_attachment\":\"0\",\"local_image_reduce\":\"\",\"disabled_page\":\"0\"}', '', '', '', 0, 0, 0, 1, 0, 1, 1, 0, 13, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(30, 2, 1, 'thumb', '缩略图', '', '', 0, 100, '', '', 'image', '{\"size\":\"50\",\"defaultvalue\":\"\",\"show_type\":\"1\",\"upload_allowext\":\"jpg|jpeg|gif|png|bmp\",\"watermark\":\"1\",\"isselectimage\":\"1\",\"images_width\":\"\",\"images_height\":\"\"}', '', '', '', 0, 1, 0, 0, 0, 1, 0, 1, 14, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(31, 2, 1, 'relation', '相关文章', '', '', 0, 0, '', '', 'omnipotent', '{\"formtext\":\"<input type=\'hidden\' name=\'info[relation]\' id=\'relation\' value=\'{FIELD_VALUE}\' style=\'50\' >\\r\\n<ul class=\\\"list-dot\\\" id=\\\"relation_text\\\"><\\/ul>\\r\\n<div>\\r\\n<input type=\'button\' value=\\\"添加相关\\\" onclick=\\\"omnipotent(\'selectid\',\'?m=content&c=content&a=public_relationlist&modelid={MODELID}\',\'添加相关文章\',1)\\\" class=\\\"button\\\" style=\\\"width:66px;\\\">\\r\\n<span class=\\\"edit_content\\\">\\r\\n<input type=\'button\' value=\\\"显示已有\\\" onclick=\\\"show_relation({MODELID},{ID})\\\" class=\\\"button\\\" style=\\\"width:66px;\\\">\\r\\n<\\/span>\\r\\n<\\/div>\",\"fieldtype\":\"varchar\",\"minnumber\":\"1\"}', '', '2,6,4,5,1,17,18,7', '', 0, 0, 0, 0, 0, 0, 1, 0, 15, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(32, 2, 1, 'pages', '分页方式', '', '', 0, 0, '', '', 'pages', '', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 0, 16, 1, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(33, 2, 1, 'inputtime', '发布时间', '', '', 0, 0, '', '', 'datetime', '{\"width\":\"\",\"fieldtype\":\"int\",\"format\":\"1\",\"format2\":\"0\",\"is_left\":\"0\",\"defaultvalue\":\"\",\"color\":\"\"}', '', '', '', 0, 1, 0, 0, 0, 0, 0, 1, 17, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(34, 2, 1, 'updatetime', '更新时间', '', '', 0, 0, '', '', 'datetime', '{\"width\":\"\",\"fieldtype\":\"int\",\"format\":\"1\",\"format2\":\"0\",\"is_left\":\"0\",\"defaultvalue\":\"\",\"color\":\"\"}', '', '', '', 0, 1, 0, 0, 0, 0, 0, 0, 18, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(35, 2, 1, 'posids', '推荐位', '', '', 0, 0, '', '', 'posid', '{\"cols\":\"4\",\"width\":\"145\"}', '', '', '', 0, 1, 0, 1, 0, 0, 0, 0, 21, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(36, 2, 1, 'groupids_view', '阅读权限', '', '', 0, 0, '', '', 'groupid', '{\"groupids\":\"\"}', '', '', '', 0, 0, 0, 1, 0, 0, 0, 0, 22, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(37, 2, 1, 'islink', '转向链接', '', '', 0, 0, '', '', 'islink', '', '', '', '', 0, 1, 0, 0, 0, 1, 0, 0, 30, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(38, 2, 1, 'url', 'URL', '', '', 0, 100, '', '', 'text', '', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 50, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(39, 2, 1, 'listorder', '排序', '', '', 0, 6, '', '', 'number', '', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 51, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(40, 2, 1, 'template', '内容页模板', '', '', 0, 30, '', '', 'template', '{\"size\":\"\",\"defaultvalue\":\"\"}', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 53, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(41, 2, 1, 'allow_comment', '允许评论', '', '', 0, 0, '', '', 'box', '{\"options\":\"允许评论|1\\r\\n不允许评论|0\",\"boxtype\":\"radio\",\"fieldtype\":\"tinyint\",\"minnumber\":\"1\",\"width\":\"100\",\"size\":\"1\",\"defaultvalue\":\"1\",\"outputtype\":\"1\",\"filtertype\":\"0\"}', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 54, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(42, 2, 1, 'status', '状态', '', '', 0, 2, '', '', 'box', '', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 55, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(43, 2, 1, 'readpoint', '阅读收费', '', '', 0, 5, '', '', 'readpoint', '{\"minnumber\":\"1\",\"maxnumber\":\"99999\",\"decimaldigits\":\"0\",\"defaultvalue\":\"\"}', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 55, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(44, 2, 1, 'username', '用户名', '', '', 0, 20, '', '', 'text', '', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 98, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(45, 2, 1, 'downfiles', '本地下载', '', '', 0, 0, '', '', 'downfiles', '{\"upload_allowext\":\"rar|zip\",\"isselectimage\":\"0\",\"upload_number\":\"10\",\"downloadlink\":\"1\",\"downloadtype\":\"1\"}', '', '', '', 0, 0, 0, 1, 0, 1, 0, 0, 8, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(46, 2, 1, 'downfile', '镜像下载', '', '', 0, 0, '', '', 'downfile', '{\"downloadlink\":\"1\",\"downloadtype\":\"1\",\"upload_allowext\":\"rar|zip\",\"isselectimage\":\"0\",\"upload_number\":\"1\"}', '', '', '', 0, 0, 0, 1, 0, 1, 0, 0, 9, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(47, 2, 1, 'systems', '软件平台', '<select name=\'selectSystem\' onchange=\"ChangeInput(this,document.myform.systems,\'/\')\">\r\n	<option value=\'WinXP\'>WinXP</option>\r\n	<option value=\'Vista\'>Windows 7</option>\r\n	<option value=\'Win2000\'>Win2000</option>\r\n	<option value=\'Win2003\'>Win2003</option>\r\n	<option value=\'Unix\'>Unix</option>\r\n	<option value=\'Linux\'>Linux</option>\r\n	<option value=\'MacOS\'>MacOS</option>\r\n</select>', '', 0, 100, '', '', 'text', '{\"size\":\"50\",\"defaultvalue\":\"Win2000\\/WinXP\\/Win2003\",\"ispassword\":\"0\"}', '', '', '', 0, 1, 0, 1, 0, 1, 1, 0, 14, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(48, 2, 1, 'copytype', '软件授权形式', '', '', 0, 15, '', '', 'box', '{\"options\":\"免费版|免费版\\r\\n共享版|共享版\\r\\n试用版|试用版\\r\\n演示版|演示版\\r\\n注册版|注册版\\r\\n破解版|破解版\\r\\n零售版|零售版\\r\\nOEM版|OEM版\",\"boxtype\":\"select\",\"fieldtype\":\"varchar\",\"minnumber\":\"1\",\"cols\":\"5\",\"width\":\"80\",\"size\":\"1\",\"default_select_value\":\"免费版\"}', '', '', '', 0, 1, 0, 1, 0, 1, 0, 0, 12, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(49, 2, 1, 'language', '软件语言', '', '', 0, 16, '', '', 'box', '{\"options\":\"英文|英文\\r\\n简体中文|简体中文\\r\\n繁体中文|繁体中文\\r\\n简繁中文|简繁中文\\r\\n多国语言|多国语言\\r\\n其他语言|其他语言\",\"boxtype\":\"select\",\"fieldtype\":\"varchar\",\"minnumber\":\"1\",\"cols\":\"5\",\"width\":\"80\",\"size\":\"1\",\"default_select_value\":\"简体中文\"}', '', '', '', 0, 1, 0, 1, 0, 1, 0, 0, 13, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(50, 2, 1, 'classtype', '软件类型', '', '', 0, 20, '', '', 'box', '{\"options\":\"国产软件|国产软件\\r\\n国外软件|国外软件\\r\\n汉化补丁|汉化补丁\\r\\n程序源码|程序源码\\r\\n其他|其他\",\"boxtype\":\"radio\",\"fieldtype\":\"varchar\",\"minnumber\":\"1\",\"cols\":\"5\",\"width\":\"80\",\"size\":\"1\",\"default_select_value\":\"国产软件\"}', '', '', '', 0, 1, 0, 1, 0, 1, 0, 0, 19, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(51, 2, 1, 'version', '版本号', '', '', 0, 20, '', '', 'text', '{\"size\":\"10\",\"defaultvalue\":\"\",\"ispassword\":\"0\"}', '', '', '', 0, 1, 0, 0, 0, 1, 1, 0, 13, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(52, 2, 1, 'filesize', '文件大小', '', '', 0, 10, '', '', 'text', '{\"size\":\"10\",\"defaultvalue\":\"未知\",\"ispassword\":\"0\"}', '', '', '', 0, 1, 0, 0, 0, 1, 1, 0, 14, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(53, 2, 1, 'stars', '评分等级', '', '', 0, 20, '', '', 'box', '{\"options\":\"★☆☆☆☆|★☆☆☆☆\\r\\n★★☆☆☆|★★☆☆☆\\r\\n★★★☆☆|★★★☆☆\\r\\n★★★★☆|★★★★☆\\r\\n★★★★★|★★★★★\",\"boxtype\":\"radio\",\"fieldtype\":\"varchar\",\"minnumber\":\"1\",\"cols\":\"5\",\"width\":\"88\",\"size\":\"1\",\"default_select_value\":\"★★★☆☆\"}', '', '', '', 0, 1, 0, 1, 0, 1, 0, 0, 20, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(54, 3, 1, 'allow_comment', '允许评论', '', '', 0, 0, '', '', 'box', '{\"options\":\"允许评论|1\\r\\n不允许评论|0\",\"boxtype\":\"radio\",\"fieldtype\":\"tinyint\",\"minnumber\":\"1\",\"width\":\"100\",\"size\":\"1\",\"defaultvalue\":\"1\",\"outputtype\":\"1\",\"filtertype\":\"0\"}', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 54, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(55, 3, 1, 'template', '内容页模板', '', '', 0, 30, '', '', 'template', '{\"size\":\"\",\"defaultvalue\":\"\"}', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 53, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(56, 3, 1, 'url', 'URL', '', '', 0, 100, '', '', 'text', '', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 50, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(57, 3, 1, 'listorder', '排序', '', '', 0, 6, '', '', 'number', '', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 51, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(58, 3, 1, 'posids', '推荐位', '', '', 0, 0, '', '', 'posid', '{\"cols\":\"4\",\"width\":\"145\"}', '', '', '', 0, 1, 0, 1, 0, 0, 0, 0, 19, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(59, 3, 1, 'groupids_view', '阅读权限', '', '', 0, 0, '', '', 'groupid', '{\"groupids\":\"\"}', '', '', '', 0, 0, 0, 1, 0, 0, 0, 0, 20, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(60, 3, 1, 'inputtime', '发布时间', '', '', 0, 0, '', '', 'datetime', '{\"width\":\"\",\"fieldtype\":\"int\",\"format\":\"1\",\"format2\":\"0\",\"is_left\":\"0\",\"defaultvalue\":\"\",\"color\":\"\"}', '', '', '', 0, 1, 0, 0, 0, 0, 0, 1, 17, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(61, 3, 1, 'updatetime', '更新时间', '', '', 0, 0, '', '', 'datetime', '{\"width\":\"\",\"fieldtype\":\"int\",\"format\":\"1\",\"format2\":\"0\",\"is_left\":\"0\",\"defaultvalue\":\"\",\"color\":\"\"}', '', '', '', 0, 1, 0, 0, 0, 0, 0, 0, 18, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(62, 3, 1, 'pages', '分页方式', '', '', 0, 0, '', '', 'pages', '', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 0, 16, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(63, 3, 1, 'relation', '相关组图', '', '', 0, 0, '', '', 'omnipotent', '{\"formtext\":\"<input type=\'hidden\' name=\'info[relation]\' id=\'relation\' value=\'{FIELD_VALUE}\' style=\'50\' >\\r\\n<ul class=\\\"list-dot\\\" id=\\\"relation_text\\\"><\\/ul>\\r\\n<div>\\r\\n<input type=\'button\' value=\\\"添加相关\\\" onclick=\\\"omnipotent(\'selectid\',\'?m=content&c=content&a=public_relationlist&modelid={MODELID}\',\'添加相关文章\',1)\\\" class=\\\"button\\\" style=\\\"width:66px;\\\">\\r\\n<span class=\\\"edit_content\\\">\\r\\n<input type=\'button\' value=\\\"显示已有\\\" onclick=\\\"show_relation({MODELID},{ID})\\\" class=\\\"button\\\" style=\\\"width:66px;\\\">\\r\\n<\\/span>\\r\\n<\\/div>\",\"fieldtype\":\"varchar\",\"minnumber\":\"1\"}', '', '2,6,4,5,1,17,18,7', '', 0, 0, 0, 0, 0, 0, 1, 0, 15, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(64, 3, 1, 'thumb', '缩略图', '', '', 0, 100, '', '', 'image', '{\"size\":\"50\",\"defaultvalue\":\"\",\"show_type\":\"1\",\"upload_allowext\":\"jpg|jpeg|gif|png|bmp\",\"watermark\":\"1\",\"isselectimage\":\"1\",\"images_width\":\"\",\"images_height\":\"\"}', '', '', '', 0, 1, 0, 0, 0, 1, 0, 1, 14, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(65, 3, 1, 'content', '内容', '', '', 0, 999999, '', '', 'editor', '{\"toolbar\":\"full\",\"toolvalue\":\"\'Bold\', \'Italic\', \'Underline\'\",\"defaultvalue\":\"\",\"enablekeylink\":\"1\",\"replacenum\":\"2\",\"link_mode\":\"0\",\"color\":\"\",\"theme\":\"default\",\"autofloat\":\"0\",\"div2p\":\"1\",\"autoheight\":\"0\",\"enter\":\"0\",\"simpleupload\":\"0\",\"watermark\":\"1\",\"attachment\":\"0\",\"image_reduce\":\"\",\"enablesaveimage\":\"1\",\"height\":\"\",\"local_img\":\"1\",\"local_watermark\":\"1\",\"local_attachment\":\"0\",\"local_image_reduce\":\"\",\"disabled_page\":\"0\"}', '', '', '', 0, 0, 0, 1, 0, 1, 1, 0, 13, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(66, 3, 1, 'description', '摘要', '', '', 0, 255, '', '', 'textarea', '{\"width\":\"\",\"height\":\"\",\"defaultvalue\":\"\",\"enablehtml\":\"0\"}', '', '', '', 0, 1, 0, 1, 0, 1, 1, 1, 10, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(67, 3, 1, 'title', '标题', '', 'inputtitle', 1, 80, '', '请输入标题', 'title', '', '', '', '', 0, 1, 0, 1, 1, 1, 1, 1, 4, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(68, 3, 1, 'keywords', '关键词', '多关键词之间用“,”隔开', '', 0, 40, '', '', 'keyword', '{\"size\":\"100\",\"defaultvalue\":\"\"}', 'data-role=\'tagsinput\'', '-99', '-99', 0, 1, 0, 1, 1, 1, 1, 0, 7, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(69, 3, 1, 'typeid', '类别', '', '', 0, 0, '', '', 'typeid', '{\"minnumber\":\"\",\"defaultvalue\":\"\"}', '', '', '', 0, 1, 0, 1, 1, 1, 0, 0, 2, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(70, 3, 1, 'catid', '栏目', '', '', 1, 6, '/^[0-9]{1,6}$/', '请选择栏目', 'catid', '{\"defaultvalue\":\"\"}', '', '-99', '-99', 0, 1, 0, 1, 1, 1, 0, 0, 1, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(71, 3, 1, 'status', '状态', '', '', 0, 2, '', '', 'box', '', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 55, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(72, 3, 1, 'readpoint', '阅读收费', '', '', 0, 5, '', '', 'readpoint', '{\"minnumber\":\"1\",\"maxnumber\":\"99999\",\"decimaldigits\":\"0\",\"defaultvalue\":\"\"}', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 55, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(73, 3, 1, 'username', '用户名', '', '', 0, 20, '', '', 'text', '', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 98, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(74, 3, 1, 'pictureurls', '组图', '', '', 0, 0, '', '', 'images', '{\"upload_allowext\":\"gif|jpg|jpeg|png|bmp\",\"isselectimage\":\"1\",\"upload_number\":\"50\"}', '', '', '', 0, 0, 0, 1, 0, 1, 0, 0, 15, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(75, 3, 1, 'copyfrom', '来源', '', '', 0, 0, '', '', 'copyfrom', '{\"defaultvalue\":\"\"}', '', '', '', 0, 0, 0, 1, 0, 1, 0, 0, 8, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(76, 3, 1, 'islink', '转向链接', '', '', 0, 0, '', '', 'islink', '', '', '', '', 0, 1, 0, 0, 0, 1, 0, 0, 30, 0, 0);
INSERT INTO `cms_model_field` (`fieldid`, `modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES(77, 10, 1, 'birthday', '生日', '', '', 0, 0, '', '生日格式错误', 'datetime', '{\"width\":\"\",\"fieldtype\":\"int\",\"format\":\"0\",\"format2\":\"0\",\"is_left\":\"0\",\"defaultvalue\":\"\",\"color\":\"\"}', '', '', '', 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0);

--
-- 会员字段
--

INSERT INTO `cms_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`) VALUES ('10', '1', 'birthday', '生日', '', '', '0', '0', '', '生日格式错误', 'datetime', 'array (\n  \'fieldtype\' => \'date\',\n  \'format\' => \'Y-m-d\',\n  \'defaulttype\' => \'0\',\n)', '', '', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0');

INSERT INTO `cms_admin_role` VALUES ('1', '超级管理员', '超级管理员', '0', '0');
INSERT INTO `cms_admin_role` VALUES ('2', '站点管理员', '站点管理员', '0', '0');
INSERT INTO `cms_admin_role` VALUES ('3', '运营总监', '运营总监', '1', '0');
INSERT INTO `cms_admin_role` VALUES ('4', '总编', '总编', '5', '0');
INSERT INTO `cms_admin_role` VALUES ('5', '编辑', '编辑', '1', '0');
INSERT INTO `cms_admin_role` VALUES ('7', '发布人员', '发布人员', '0', '0');

INSERT INTO `cms_site` VALUES ('1', 'CMS演示站', '', 'http://www.kaixin100.cn/', '1', '0', '0', '0', 'http://www.kaixin100.cn/mobile/', 'CMS演示站', 'CMS演示站', 'CMS演示站', '', 'default', 'default', '{\"upload_maxsize\":\"2\",\"upload_allowext\":\"jpg|jpeg|gif|bmp|png|doc|docx|xls|xlsx|ppt|pptx|pdf|txt|rar|zip|swf\",\"filename\":\"{yyyy}\/{mm}{dd}\/{time}{rand:6}\",\"imageMaxSize\":\"2\",\"imageAllowFiles\":\"png|jpg|jpeg|gif|bmp\",\"catcherMaxSize\":\"2\",\"catcherAllowFiles\":\"png|jpg|jpeg|gif|bmp\",\"videoMaxSize\":\"100\",\"videoAllowFiles\":\"flv|swf|mkv|avi|rm|rmvb|mpeg|mpg|ogg|ogv|mov|wmv|mp4|webm|mp3|wav|mid\",\"fileMaxSize\":\"50\",\"fileAllowFiles\":\"png|jpg|jpeg|gif|bmp|flv|swf|mkv|avi|rm|rmvb|mpeg|mpg|ogg|ogv|mov|wmv|mp4|webm|mp3|wav|mid|rar|zip|tar|gz|7z|bz2|cab|iso|doc|docx|xls|xlsx|ppt|pptx|pdf|txt|md|xml\",\"imageManagerListSize\":\"20\",\"imageManagerAllowFiles\":\"png|jpg|jpeg|gif|bmp\",\"fileManagerListSize\":\"20\",\"fileManagerAllowFiles\":\"png|jpg|jpeg|gif|bmp|flv|swf|mkv|avi|rm|rmvb|mpeg|mpg|ogg|ogv|mov|wmv|mp4|webm|mp3|wav|mid|rar|zip|tar|gz|7z|bz2|cab|iso|doc|docx|xls|xlsx|ppt|pptx|pdf|txt|md|xml\",\"videoManagerListSize\":\"20\",\"videoManagerAllowFiles\":\"flv|swf|mkv|avi|rm|rmvb|mpeg|mpg|ogg|ogv|mov|wmv|mp4|webm|mp3|wav|mid\",\"watermark_enable\":\"1\",\"type\":\"0\",\"wm_font_path\":\"1.ttf\",\"wm_text\":\"cms\",\"wm_font_size\":\"\",\"wm_font_color\":\"\",\"wm_overlay_path\":\"logo.png\",\"wm_opacity\":\"100\",\"quality\":\"80\",\"wm_padding\":\"\",\"wm_hor_offset\":\"\",\"wm_vrt_offset\":\"\",\"width\":\"\",\"height\":\"\",\"locate\":\"right-bottom\",\"ueditor\":\"0\",\"thumb\":\"0\"}', '');

INSERT INTO `cms_member_group` VALUES ('8', '游客', '1', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0.00', '0.00', '0.00', '', '', '', '0', '0');
INSERT INTO `cms_member_group` VALUES ('2', '新手上路', '1', '1', '50', '100', '1', '1', '0', '0', '0', '1', '0', '0', '50.00', '10.00', '1.00', '', '', '', '2', '0');
INSERT INTO `cms_member_group` VALUES ('6', '注册会员', '1', '2', '100', '150', '0', '1', '0', '0', '1', '1', '0', '0', '300.00', '30.00', '1.00', '', '', '', '6', '0');
INSERT INTO `cms_member_group` VALUES ('4', '中级会员', '1', '3', '150', '500', '1', '1', '0', '1', '1', '1', '0', '0', '500.00', '60.00', '1.00', '', '', '', '4', '0');
INSERT INTO `cms_member_group` VALUES ('5', '高级会员', '1', '5', '300', '999', '1', '1', '0', '1', '1', '1', '0', '0', '360.00', '90.00', '5.00', '', '', '', '5', '0');
INSERT INTO `cms_member_group` VALUES ('1', '禁止访问', '1', '0', '0', '0', '1', '1', '0', '1', '0', '0', '0', '0', '0.00', '0.00', '0.00', '', '', '0', '0', '0');
INSERT INTO `cms_member_group` VALUES ('7', '邮件认证', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', 'images/group/vip.jpg', '#000000', '', '7', '0');

INSERT INTO `cms_member_menu` VALUES ('', 'member_init', '0', 'member', 'index', 'init', 't=0', '0', '1', '', '');
INSERT INTO `cms_member_menu` VALUES ('', 'account_manage', '0', 'member', 'index', 'account_manage', 't=1', '0', '1', '', '');
INSERT INTO `cms_member_menu` VALUES ('', 'favorite', '0', 'member', 'index', 'favorite', 't=2', '0', '1', '', '');

INSERT INTO `cms_category` (`catid`, `siteid`, `module`, `type`, `modelid`, `parentid`, `arrparentid`, `child`, `arrchildid`, `catname`, `style`, `image`, `description`, `parentdir`, `catdir`, `url`, `items`, `hits`, `setting`, `listorder`, `ismenu`, `sethtml`, `letter`, `usable_type`) VALUES(1, 1, 'content', 1, 0, 0, '0', 1, '1,2,3,4,5', '网站介绍', '', '', '', '', 'about', 'http://www.kaixin100.cn/index.php?m=content&c=index&a=lists&catid=1', 0, 0, '{\"disabled\":\"0\",\"iscatpos\":\"1\",\"isleft\":\"1\",\"ishtml\":\"0\",\"template_list\":\"default\",\"page_template\":\"page\",\"meta_title\":\"网站介绍\",\"meta_keywords\":\"网站介绍\",\"meta_description\":\"网站介绍\",\"pagesize\":0,\"category_ruleid\":\"6\",\"show_ruleid\":\"\",\"repeatchargedays\":1}', 1, 0, 0, 'wangzhanjieshao', '');
INSERT INTO `cms_category` (`catid`, `siteid`, `module`, `type`, `modelid`, `parentid`, `arrparentid`, `child`, `arrchildid`, `catname`, `style`, `image`, `description`, `parentdir`, `catdir`, `url`, `items`, `hits`, `setting`, `listorder`, `ismenu`, `sethtml`, `letter`, `usable_type`) VALUES(2, 1, 'content', 1, 0, 1, '0,1', 0, '2', '关于我们', '', '', '', 'about/', 'aboutus', 'http://www.kaixin100.cn/index.php?m=content&c=index&a=lists&catid=2', 0, 0, '{\"disabled\":\"0\",\"iscatpos\":\"1\",\"isleft\":\"1\",\"ishtml\":\"0\",\"template_list\":\"default\",\"page_template\":\"page\",\"meta_title\":\"关于我们\",\"meta_keywords\":\"关于我们\",\"meta_description\":\"关于我们\",\"pagesize\":0,\"category_ruleid\":\"6\",\"show_ruleid\":\"\",\"repeatchargedays\":1}', 1, 1, 0, 'guanyuwomen', '');
INSERT INTO `cms_category` (`catid`, `siteid`, `module`, `type`, `modelid`, `parentid`, `arrparentid`, `child`, `arrchildid`, `catname`, `style`, `image`, `description`, `parentdir`, `catdir`, `url`, `items`, `hits`, `setting`, `listorder`, `ismenu`, `sethtml`, `letter`, `usable_type`) VALUES(3, 1, 'content', 1, 0, 1, '0,1', 0, '3', '联系方式', '', '', '', 'about/', 'contactus', 'http://www.kaixin100.cn/index.php?m=content&c=index&a=lists&catid=3', 0, 0, '{\"disabled\":\"0\",\"iscatpos\":\"1\",\"isleft\":\"1\",\"ishtml\":\"0\",\"template_list\":\"default\",\"page_template\":\"page\",\"meta_title\":\"联系方式\",\"meta_keywords\":\"联系方式\",\"meta_description\":\"联系方式\",\"pagesize\":0,\"category_ruleid\":\"6\",\"show_ruleid\":\"\",\"repeatchargedays\":1}', 2, 1, 0, 'lianxifangshi', '');
INSERT INTO `cms_category` (`catid`, `siteid`, `module`, `type`, `modelid`, `parentid`, `arrparentid`, `child`, `arrchildid`, `catname`, `style`, `image`, `description`, `parentdir`, `catdir`, `url`, `items`, `hits`, `setting`, `listorder`, `ismenu`, `sethtml`, `letter`, `usable_type`) VALUES(4, 1, 'content', 1, 0, 1, '0,1', 0, '4', '版权声明', '', '', '', 'about/', 'copyright', 'http://www.kaixin100.cn/index.php?m=content&c=index&a=lists&catid=4', 0, 0, '{\"disabled\":\"0\",\"iscatpos\":\"1\",\"isleft\":\"1\",\"ishtml\":\"0\",\"template_list\":\"default\",\"page_template\":\"page\",\"meta_title\":\"版权声明\",\"meta_keywords\":\"版权声明\",\"meta_description\":\"版权声明\",\"pagesize\":0,\"category_ruleid\":\"6\",\"show_ruleid\":\"\",\"repeatchargedays\":1}', 3, 1, 0, 'banquanshengming', '');
INSERT INTO `cms_category` (`catid`, `siteid`, `module`, `type`, `modelid`, `parentid`, `arrparentid`, `child`, `arrchildid`, `catname`, `style`, `image`, `description`, `parentdir`, `catdir`, `url`, `items`, `hits`, `setting`, `listorder`, `ismenu`, `sethtml`, `letter`, `usable_type`) VALUES(5, 1, 'content', 1, 0, 1, '0,1', 0, '5', '招聘信息', '', '', '', 'about/', 'hr', 'http://www.kaixin100.cn/index.php?m=content&c=index&a=lists&catid=5', 0, 0, '{\"disabled\":\"0\",\"iscatpos\":\"1\",\"isleft\":\"1\",\"ishtml\":\"0\",\"template_list\":\"default\",\"page_template\":\"page\",\"meta_title\":\"招聘信息\",\"meta_keywords\":\"招聘信息\",\"meta_description\":\"招聘信息\",\"pagesize\":0,\"category_ruleid\":\"6\",\"show_ruleid\":\"\",\"repeatchargedays\":1}', 4, 1, 0, 'zhaopinxinxi', '');