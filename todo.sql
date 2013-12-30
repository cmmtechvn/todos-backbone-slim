/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50141
Source Host           : localhost:3306
Source Database       : todo

Target Server Type    : MYSQL
Target Server Version : 50141
File Encoding         : 65001

Date: 2013-12-30 13:58:24
*/
CREATE DATABASE `todo` CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `todo`;
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `todos`
-- ----------------------------
DROP TABLE IF EXISTS `todos`;
CREATE TABLE `todos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `completed` tinyint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

