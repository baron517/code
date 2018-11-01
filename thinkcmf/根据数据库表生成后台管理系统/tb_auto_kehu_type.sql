/*
Navicat MySQL Data Transfer

Source Server         : 106.14.44.160
Source Server Version : 50558
Source Host           : 106.14.44.160:3306
Source Database       : taidun_xietong

Target Server Type    : MYSQL
Target Server Version : 50558
File Encoding         : 65001

Date: 2018-10-07 21:13:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_auto_kehu_type
-- ----------------------------
DROP TABLE IF EXISTS `tb_auto_kehu_type`;
CREATE TABLE `tb_auto_kehu_type` (
  `kl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"ID"}',
  `kl_name` varchar(255) DEFAULT NULL COMMENT '{"name":"分类名称","search":1}',
  PRIMARY KEY (`kl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
