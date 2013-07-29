/*
Navicat MySQL Data Transfer

Source Server         : 192.168.10.41
Source Server Version : 50095
Source Host           : 192.168.10.41:3306
Source Database       : zf2

Target Server Type    : MYSQL
Target Server Version : 50095
File Encoding         : 65001

Date: 2013-07-26 17:19:22
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `display_name` varchar(50) default NULL,
  `password` varchar(128) NOT NULL,
  `state` smallint(5) unsigned default NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', null, 'chenliang@iihaveu.net', 'Leon', '$2y$14$KWc3MfXi.jzH8qRPCJxxO.oGD4CDhV5bY221eoeINzmZsyCtQ9ore', null);

-- ----------------------------
-- Table structure for `admin_department`
-- ----------------------------
DROP TABLE IF EXISTS `admin_department`;
CREATE TABLE `admin_department` (
  `id` int(11) NOT NULL auto_increment,
  `department_id` int(11) default NULL,
  `department_name` int(100) default NULL,
  `admin_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_department
-- ----------------------------

-- ----------------------------
-- Table structure for `department`
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `add_time` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of department
-- ----------------------------
INSERT INTO `department` VALUES ('1', '产品部', '1374138428');
INSERT INTO `department` VALUES ('2', '财务部', '1374139349');

-- ----------------------------
-- Table structure for `department_roles`
-- ----------------------------
DROP TABLE IF EXISTS `department_roles`;
CREATE TABLE `department_roles` (
  `id` int(11) NOT NULL auto_increment,
  `department_id` int(11) default NULL,
  `roles_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of department_roles
-- ----------------------------

-- ----------------------------
-- Table structure for `menu`
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL auto_increment,
  `label` varchar(255) default NULL,
  `module` varchar(255) default NULL,
  `controller` varchar(255) default NULL,
  `action` varchar(255) default NULL,
  `is_module` tinyint(1) unsigned zerofill default NULL,
  `is_menu` tinyint(1) unsigned zerofill default NULL,
  `add_time` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=140 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('131', '系统管理', 'admin', 'Roles', '#', '1', '1', '1374830168');
INSERT INTO `menu` VALUES ('132', '角色管理', 'admin', 'roles', 'index', '0', '1', '1374830168');
INSERT INTO `menu` VALUES ('133', '角色管理-创建', 'admin', 'Roles', 'add', '0', '0', '1374830168');
INSERT INTO `menu` VALUES ('134', '角色管理-编辑', 'admin', 'Roles', 'edit', '0', '0', '1374830168');
INSERT INTO `menu` VALUES ('135', '角色管理-删除', 'admin', 'Roles', 'delete', '0', '0', '1374830168');
INSERT INTO `menu` VALUES ('136', '用户管理', 'admin', 'admin', 'index', '0', '1', '1374830273');
INSERT INTO `menu` VALUES ('137', '用户管理-创建', 'admin', 'Admin', 'add', '0', '0', '1374830273');
INSERT INTO `menu` VALUES ('138', '用户管理-编辑', 'admin', 'Admin', 'edit', '0', '0', '1374830273');
INSERT INTO `menu` VALUES ('139', '用户管理-删除', 'admin', 'Admin', 'delete', '0', '0', '1374830273');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `add_time` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `roles_menu`
-- ----------------------------
DROP TABLE IF EXISTS `roles_menu`;
CREATE TABLE `roles_menu` (
  `id` int(11) NOT NULL auto_increment,
  `roles_id` int(11) default NULL,
  `menu_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

