/*
Navicat MySQL Data Transfer

Source Server         : 106.14.44.160
Source Server Version : 50558
Source Host           : 106.14.44.160:3306
Source Database       : taidun_xietong

Target Server Type    : MYSQL
Target Server Version : 50558
File Encoding         : 65001

Date: 2018-10-07 20:55:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_auto_shangpin
-- ----------------------------
DROP TABLE IF EXISTS `tb_auto_shangpin`;
CREATE TABLE `tb_auto_shangpin` (
  `sp_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"商品编号"}',
  `sp_name` varchar(255) DEFAULT NULL COMMENT '{"name":"商品名称"}',
  `sp_type_id` int(11) DEFAULT NULL COMMENT '{"name":"商品分类id"}',
  `sp_type` varchar(255) DEFAULT NULL COMMENT '{"name":"商品分类","select":1,"select_url":"tb_auto_mall_type"}',
  `sp_lingshoujia` float(8,0) DEFAULT NULL COMMENT '{"name":"价格","shuoming":"元"}',
  `sp_beizhu` text COMMENT '{"name":"备注","textarea":1}',
  PRIMARY KEY (`sp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
