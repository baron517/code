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
DROP TABLE IF EXISTS `tb_auto_kc_order`;
CREATE TABLE `tb_auto_kc_order` (
  
  `kc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"ID"}',
  `kc_phone` varchar(100) NOT NULL COMMENT '{"name":"下单手机","search":1}',
  `kc_create_time` varchar(100) NOT NULL COMMENT '{"name":"订单时间","search":1}',
  `kc_money` varchar(100) NOT NULL COMMENT '{"name":"订单金额"}',
  `kc_sp_name` varchar(100) NOT NULL COMMENT '{"name":"课程名称"}',
  `kc_sp_openid` varchar(100) NOT NULL COMMENT '{"name":"下单openid"}',
  `kc_sp_id` int(11) NOT NULL COMMENT '{"name":"课程id"}',
  `kc_beizhu` varchar(100) NOT NULL COMMENT '{"name":"老师姓名"}',
  `kc_phone` varchar(100) NOT NULL COMMENT '{"name":"老师手机"}',
  
    
  PRIMARY KEY (`kc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
