-- -----------------------------
-- Think MySQL Data Transfer 
-- 
-- Host     : 127.0.0.1
-- Port     : 3306
-- Database : sccms
-- 
-- Part : #1
-- Date : 2016-09-23 17:44:05
-- -----------------------------

SET FOREIGN_KEY_CHECKS = 0;


-- -----------------------------
-- Table structure for `sc_action`
-- -----------------------------
DROP TABLE IF EXISTS `sc_action`;
CREATE TABLE `sc_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '行为唯一标识',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '行为说明',
  `remark` char(140) NOT NULL DEFAULT '' COMMENT '行为描述',
  `rule` text NOT NULL COMMENT '行为规则',
  `log` text NOT NULL COMMENT '日志规则',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统行为表';

-- -----------------------------
-- Records of `sc_action`
-- -----------------------------
INSERT INTO `sc_action` VALUES ('1', 'user_login', '用户登录', '', '', '[user|get_nickname]在[time|time_format]登录了后台', '1', '1', '1473661715');
INSERT INTO `sc_action` VALUES ('3', 'user_logout', '用户退出', '', '', '[user|get_nickname]在[time|time_format]退出了后台', '1', '1', '1473661418');

-- -----------------------------
-- Table structure for `sc_action_log`
-- -----------------------------
DROP TABLE IF EXISTS `sc_action_log`;
CREATE TABLE `sc_action_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(30) NOT NULL DEFAULT '0' COMMENT '行为id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行用户id',
  `action_ip` bigint(20) NOT NULL COMMENT '执行行为者ip',
  `model` varchar(50) NOT NULL DEFAULT '' COMMENT '触发行为的表',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '日志备注',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行行为的时间',
  PRIMARY KEY (`id`),
  KEY `action_ip_ix` (`action_ip`),
  KEY `action_id_ix` (`name`),
  KEY `user_id_ix` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='行为日志表';

-- -----------------------------
-- Records of `sc_action_log`
-- -----------------------------
INSERT INTO `sc_action_log` VALUES ('88', '用户登录', '0', '2130706433', 'Manager', '验证码错误！', '1474617254');
INSERT INTO `sc_action_log` VALUES ('118', '用户登录', '0', '2130706433', 'Manager', '用户名或密码错误', '1474617803');
INSERT INTO `sc_action_log` VALUES ('119', '用户登录', '5', '2130706433', 'Manager', '登录成功', '1474617824');
INSERT INTO `sc_action_log` VALUES ('120', '用户注销', '5', '2130706433', 'Manager', '注销成功', '1474617852');
INSERT INTO `sc_action_log` VALUES ('121', '用户登录', '5', '2130706433', 'Manager', '登录成功', '1474620027');
INSERT INTO `sc_action_log` VALUES ('122', '用户注销', '5', '2130706433', 'Manager', '注销成功', '1474621086');
INSERT INTO `sc_action_log` VALUES ('123', '用户登录', '5', '2130706433', 'Manager', '登录成功', '1474621094');

-- -----------------------------
-- Table structure for `sc_auth_group`
-- -----------------------------
DROP TABLE IF EXISTS `sc_auth_group`;
CREATE TABLE `sc_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '99',
  `remark` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `sc_auth_group`
-- -----------------------------
INSERT INTO `sc_auth_group` VALUES ('1', '测试', '97', '阿斯顿撒旦', '1', '5,1,2,20,22');
INSERT INTO `sc_auth_group` VALUES ('4', '网站编辑', '98', '编辑测试123', '1', '13,14,15,36,37,38,16');

-- -----------------------------
-- Table structure for `sc_auth_group_access`
-- -----------------------------
DROP TABLE IF EXISTS `sc_auth_group_access`;
CREATE TABLE `sc_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `sc_auth_group_access`
-- -----------------------------
INSERT INTO `sc_auth_group_access` VALUES ('1', '4');
INSERT INTO `sc_auth_group_access` VALUES ('5', '1');
INSERT INTO `sc_auth_group_access` VALUES ('5', '4');
INSERT INTO `sc_auth_group_access` VALUES ('6', '3');
INSERT INTO `sc_auth_group_access` VALUES ('6', '4');

-- -----------------------------
-- Table structure for `sc_auth_rule`
-- -----------------------------
DROP TABLE IF EXISTS `sc_auth_rule`;
CREATE TABLE `sc_auth_rule` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `pid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` char(50) NOT NULL COMMENT '地址',
  `title` char(30) NOT NULL COMMENT '菜单名称',
  `menutype` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1分组，2菜单，3节点',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否验证附加规则',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:正常;  0:关闭',
  `icon` char(20) NOT NULL COMMENT '图标',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `sort` smallint(6) NOT NULL DEFAULT '99' COMMENT '排序',
  `condition` char(100) NOT NULL COMMENT '规则附加条件',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

-- -----------------------------
-- Records of `sc_auth_rule`
-- -----------------------------
INSERT INTO `sc_auth_rule` VALUES ('1', '5', '', '菜单管理', '1', '1', '1', 'th-list', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('2', '1', 'Admin/AuthRule/index', '后台菜单', '2', '1', '1', 'angle-right', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('3', '1', '', '前台菜单', '1', '1', '1', 'angle-right', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('5', '0', '', '系统', '1', '1', '1', 'lock', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('6', '5', '', '数据备份', '1', '1', '1', 'database', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('7', '6', 'Admin/Database/index', '备份数据库', '2', '1', '1', 'angle-right', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('8', '6', 'Admin/Database/importList', '还原数据库', '2', '1', '1', 'angle-right', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('9', '0', '', '用户', '1', '1', '1', 'user', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('10', '9', '', '管理组', '1', '1', '1', 'key', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('11', '10', 'Admin/Manager/index', '管理员', '2', '1', '1', 'angle-right', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('12', '10', 'Admin/AuthGroup/index', '角色管理', '2', '1', '1', 'angle-right', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('13', '0', '', '配置', '1', '1', '1', 'cogs', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('14', '13', '', '参数配置', '1', '1', '1', 'cog', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('15', '14', 'Admin/Config/index', '全部配置', '2', '1', '1', 'angle-right', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('16', '14', 'Admin/Config/group', '常用配置', '2', '1', '1', 'angle-right', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('17', '9', '', '行为管理', '1', '1', '1', 'paw', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('18', '17', 'Admin/Action/index', '用户行为', '2', '1', '0', 'angle-right', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('19', '17', 'Admin/Action/actionlog', '行为日志', '2', '1', '1', 'angle-right', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('20', '2', 'Admin/AuthRule/add', '新增', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('21', '2', 'Admin/AuthRule/edit', '编辑', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('22', '2', 'Admin/AuthRule/del', '删除', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('23', '7', 'Admin/Database/export', '备份优化修复', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('24', '7', 'Admin/Database/frame', '数据结构', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('25', '7', 'Admin/Database/createSql', '数据sql', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('26', '8', 'Admin/Database/import', '还原备份', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('27', '8', 'Admin/Database/delbak', '删除备份', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('28', '11', 'Admin/Manager/add', '新增', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('29', '11', 'Admin/Manager/auth', '授权', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('30', '11', 'Admin/Manager/edit', '编辑', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('31', '11', 'Admin/Manager/del', '删除', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('32', '12', 'Admin/AuthGroup/add', '新增', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('33', '12', 'Admin/AuthGroup/auth', '授权', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('34', '12', 'Admin/AuthGroup/edit', '编辑', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('35', '12', 'Admin/AuthGroup/del', '删除', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('36', '15', 'Admin/Config/add', '新增', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('37', '15', 'Admin/Config/edit', '编辑', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('38', '15', 'Admin/Config/del', '删除', '3', '1', '1', '', '', '99', '');
INSERT INTO `sc_auth_rule` VALUES ('39', '19', 'Admin/Action/dellog', '删除', '3', '1', '1', '', '', '99', '');

-- -----------------------------
-- Table structure for `sc_config`
-- -----------------------------
DROP TABLE IF EXISTS `sc_config`;
CREATE TABLE `sc_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) NOT NULL COMMENT '配置说明',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `value` text NOT NULL COMMENT '配置值',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`),
  KEY `group` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- -----------------------------
-- Records of `sc_config`
-- -----------------------------
INSERT INTO `sc_config` VALUES ('1', 'WEB_SITE_TITLE', '2', '网站标题', '1', '', '', '1473054784', '1473054784', '1', 'SC-CMS内容管理系统', '99');
INSERT INTO `sc_config` VALUES ('2', 'WEB_SITE_KEYWORD', '2', '网站关键字', '1', '', '', '1473062864', '1473069607', '1', '失策,SC-CMS', '99');
INSERT INTO `sc_config` VALUES ('3', 'WEB_SITE_DESCRIPTION', '2', '网站描述', '1', '', '', '1473063059', '1473066464', '1', 'sc-cms内容管理系统', '99');
INSERT INTO `sc_config` VALUES ('5', 'WEB_SITE_CLOSE', '5', '关闭站点', '1', '0:关闭,1:开启', '', '1473063820', '1473129415', '1', '0', '99');
INSERT INTO `sc_config` VALUES ('6', 'WEB_SITE_ICP', '2', '网站备案号', '1', '', '设置在网站底部显示的备案号，如“沪ICP备12007941号-2', '1473066559', '1473066559', '1', '蜀ICP备16012767号', '99');
INSERT INTO `sc_config` VALUES ('7', 'USER_ALLOW_REGISTER', '5', '是否允许用户注册', '5', '0:关闭注册,
1:允许注册', '', '1473066657', '1473129837', '1', '1', '99');
INSERT INTO `sc_config` VALUES ('8', 'SHOW_PAGE_TRACE', '5', '是否显示页面Trace', '5', '0:关闭,
1:开启', '是否显示页面Trace信息', '1473066727', '1473130303', '1', '1', '99');
INSERT INTO `sc_config` VALUES ('11', 'DATA_BACKUP_PATH', '2', '数据库备份根路径', '5', '', '路径必须以 / 结尾', '1473067136', '1473067145', '1', './Data/', '99');
INSERT INTO `sc_config` VALUES ('12', 'HOOKS_TYPE', '4', '钩子的类型', '5', '', '类型 1-用于扩展显示内容，2-用于扩展业务处理', '1473067184', '1473067184', '1', '1:视图
2:控制器', '99');
INSERT INTO `sc_config` VALUES ('13', 'DATA_BACKUP_PART_SIZE', '2', '数据库备份卷大小', '5', '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '1473067242', '1473067242', '1', '2097152000', '99');
INSERT INTO `sc_config` VALUES ('14', 'AUTH_CONFIG', '4', 'Auth配置', '5', '', '自定义Auth.class.php类配置', '1473067292', '1473125242', '1', 'AUTH_ON:1
AUTH_TYPE:2', '99');
INSERT INTO `sc_config` VALUES ('15', 'DATA_BACKUP_COMPRESS', '5', '数据库备份文件是否启用压缩', '5', '0:不压缩,
1:启用压缩', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', '1473122932', '1473130314', '1', '0', '99');
INSERT INTO `sc_config` VALUES ('16', 'DATA_BACKUP_COMPRESS_LEVEL', '5', '数据库备份文件压缩级别', '5', '1:普通,
4:一般,
9:最高', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '1473122974', '1473130325', '1', '9', '99');
INSERT INTO `sc_config` VALUES ('17', 'DEVELOP_MODE', '5', '开启开发者模式', '5', '0:关闭,
1:开启', '是否开启开发者模式', '1473123017', '1473130330', '1', '1', '99');
INSERT INTO `sc_config` VALUES ('18', 'ADMIN_ALLOW_IP', '3', '后台允许访问IP', '5', '', '多个用逗号分隔，如果不配置表示不限制IP访问', '1473123055', '1473123055', '1', '', '99');
INSERT INTO `sc_config` VALUES ('19', 'WEB_SITE_STATISTICS', '3', '统计代码', '1', '', '', '1473123293', '1473123293', '1', '', '99');
INSERT INTO `sc_config` VALUES ('20', 'ADMIN_SUPER', '4', '超级管理员配置', '5', '', '填写超级管理员ID', '1473406877', '1473406877', '1', '0:1,
1:2', '99');

-- -----------------------------
-- Table structure for `sc_manager`
-- -----------------------------
DROP TABLE IF EXISTS `sc_manager`;
CREATE TABLE `sc_manager` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` char(16) NOT NULL COMMENT '用户名',
  `nickname` char(16) NOT NULL COMMENT '昵称/姓名',
  `password` char(32) NOT NULL COMMENT '密码',
  `email` char(32) NOT NULL COMMENT '用户邮箱',
  `mobile` char(15) NOT NULL COMMENT '用户手机',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `reg_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) DEFAULT '0' COMMENT '用户状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='管理员';

-- -----------------------------
-- Records of `sc_manager`
-- -----------------------------
INSERT INTO `sc_manager` VALUES ('1', 'admin', '管理员', 'c1f23cb034c91b0708cfb3218e32c41f', '664709989@qq.com', '18281774033', '0', '0', '1474614365', '2130706433', '1474600972', '1');
INSERT INTO `sc_manager` VALUES ('5', 'root', '测试1', 'bf718be634272ecc25bf48246206ba64', '', '', '1472785914', '2130706433', '1474621094', '2130706433', '1473407613', '1');
