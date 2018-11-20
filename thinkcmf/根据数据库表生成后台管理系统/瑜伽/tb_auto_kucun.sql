/*
Navicat MySQL Data Transfer

Source Server         : meiye_47.99.106.117
Source Server Version : 50558
Source Host           : 47.99.106.117:3306
Source Database       : sheying

Target Server Type    : MYSQL
Target Server Version : 50558
File Encoding         : 65001

Date: 2018-11-05 21:54:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_auto_order
-- ----------------------------
DROP TABLE IF EXISTS `tb_auto_kucun`;
CREATE TABLE `tb_auto_kucun` (
  `kc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"ID"}',
  `kc_sp_type` varchar(100) NOT NULL COMMENT '{"name":"分类","url":"tb_auto_mall_type"}',
  `kc_sp_name` varchar(100) NOT NULL COMMENT '{"name":"商品名称"}',
  `kc_sku` varchar(100) NOT NULL COMMENT '{"name":"库存"}',
  `kc_beizhu` varchar(255) NOT NULL COMMENT '{"name":"头像","textare":1}',

  PRIMARY KEY (kc_id)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_auto_order
-- ----------------------------
