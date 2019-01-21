/*
Navicat MySQL Data Transfer

Source Server         : 106.14.44.160
Source Server Version : 50558
Source Host           : 106.14.44.160:3306
Source Database       : taidun_xietong

Target Server Type    : MYSQL
Target Server Version : 50558
File Encoding         : 65001

Date: 2018-10-31 22:31:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_auto_lunbo
-- ----------------------------
DROP TABLE IF EXISTS `tb_auto_shouji`;
CREATE TABLE `tb_auto_shouji` (
  `t_id` int(255) NOT NULL AUTO_INCREMENT COMMENT '{"name":"ID"}',
  `t_shouji` varchar(100) NOT NULL COMMENT '{"name":"手机","search":1}',
  `t_shijian` varchar(255) DEFAULT NULL COMMENT '{"name":"时间"}',
  PRIMARY KEY (`t_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
