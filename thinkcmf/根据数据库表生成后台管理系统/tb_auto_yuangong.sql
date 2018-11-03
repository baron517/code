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
DROP TABLE IF EXISTS `tb_auto_yuangong`;
CREATE TABLE `tb_auto_yuangong` (
  
  `yg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"ID"}',
  `username` varchar(100) NOT NULL COMMENT '{"name":"微信昵称","search":1}',
  `avatar` varchar(100) NOT NULL COMMENT '{"name":"头像"}',
  `sex` varchar(100) NOT NULL COMMENT '{"name":"性别"}',
  `openid` varchar(100) NOT NULL COMMENT '{"name":"openid"}',
   `birthday` varchar(100) NOT NULL COMMENT '{"name":"生日"}',
   `address` varchar(100) NOT NULL COMMENT '{"name":"省市区"}',
   `id_card_front` varchar(100) NOT NULL COMMENT '{"name":"身份证正面"}',
   `id_card_back` varchar(100) NOT NULL COMMENT '{"name":"身份证背面"}',
   `address_detail` varchar(100) NOT NULL COMMENT '{"name":"地址"}',
    `phone` varchar(100) NOT NULL COMMENT '{"name":"手机","search":1}',
  PRIMARY KEY (`yg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
