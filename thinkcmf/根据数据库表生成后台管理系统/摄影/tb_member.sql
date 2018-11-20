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
DROP TABLE IF EXISTS `tb_auto_member`;
CREATE TABLE `tb_auto_member` (
  
  `m_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"ID","caozuo":"hide"}',
  `username` varchar(100) NOT NULL COMMENT '{"name":"微信昵称","search":1}',
  `avatar` varchar(100) NOT NULL COMMENT '{"name":"头像"}',
  `sex` varchar(100) NOT NULL COMMENT '{"name":"性别"}',
  `openid` varchar(100) NOT NULL COMMENT '{"name":"openid"}',
  `phone` varchar(100) NOT NULL COMMENT '{"name":"手机","search":1}',
  
  `lianxiren` varchar(100) NOT NULL COMMENT '{"name":"联系人"}',
  `lx_phone` varchar(20) NOT NULL COMMENT '{"name":"联系人"}',
  `address` varchar(100) NOT NULL COMMENT '{"name":"省市区"}',
  `address_detail` varchar(100) NOT NULL COMMENT '{"name":"详细地址"}',
  `youbian` varchar(100) NOT NULL COMMENT '{"name":"邮编"}',
  
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
