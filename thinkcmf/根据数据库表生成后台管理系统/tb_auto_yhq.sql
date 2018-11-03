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
DROP TABLE IF EXISTS `tb_auto_yhq`;
CREATE TABLE `tb_auto_yhq` (
  
  `yhq_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"ID"}',
  `yhq_name` varchar(100) NOT NULL COMMENT '{"name":"优惠券名称","search":1}',
  `yhq_starttime` varchar(100) NOT NULL COMMENT '{"name":"开始时间"}',
  `yhq_endtime` varchar(100) NOT NULL COMMENT '{"name":"结束时间"}',
   `yhq_create_time` varchar(100) NOT NULL COMMENT '{"name":"创建时间"}',
  PRIMARY KEY (`yhq_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
