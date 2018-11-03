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
DROP TABLE IF EXISTS `tb_auto_mall_order`;
CREATE TABLE `tb_auto_mall_order` (
  
  `mo_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"ID"}',
  `mo_phone` varchar(100) NOT NULL COMMENT '{"name":"下单手机","search":1}',
  `mo_create_time` varchar(100) NOT NULL COMMENT '{"name":"订单时间","search":1}',
  `mo_money` varchar(100) NOT NULL COMMENT '{"name":"订单金额"}',
  `mo_sp_name` varchar(100) NOT NULL COMMENT '{"name":"商品名称"}',
  `mo_sp_id` varchar(100) NOT NULL COMMENT '{"name":"商品id"}',
  `mo_beizhu` varchar(100) NOT NULL COMMENT '{"name":"订单金额"}',
  
    
  PRIMARY KEY (`mo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
