/*
Navicat MySQL Data Transfer

Source Server         : meiye_47.99.106.117
Source Server Version : 50558
Source Host           : 47.99.106.117:3306
Source Database       : yfmy

Target Server Type    : MYSQL
Target Server Version : 50558
File Encoding         : 65001

Date: 2018-11-02 17:43:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_member
-- ----------------------------
DROP TABLE IF EXISTS `tb_auto_mall_type`;
CREATE TABLE `tb_auto_mall_type` (
  
  `mt_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"ID"}',
  `mt_name` varchar(100) NOT NULL COMMENT '{"name":"分类名称","search":1}',
    `mt_create_time` varchar(100) NOT NULL COMMENT '{"name":"创建时间"}',
  PRIMARY KEY (`mt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
