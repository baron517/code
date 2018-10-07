/*
Navicat MySQL Data Transfer

Source Server         : 106.14.44.160
Source Server Version : 50558
Source Host           : 106.14.44.160:3306
Source Database       : taidun_xietong

Target Server Type    : MYSQL
Target Server Version : 50558
File Encoding         : 65001

Date: 2018-10-07 21:13:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_auto_kehu
-- ----------------------------
DROP TABLE IF EXISTS `tb_auto_gongyingshang`;
CREATE TABLE `tb_auto_gongyingshang` (
  `gys_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"供应商编号","search":1}',
  `gys_name` varchar(255) DEFAULT NULL COMMENT '{"name":"供应商名称","search":1}',
  `gys_type` varchar(255) DEFAULT NULL COMMENT '{"name":"供应商分类","select":1,"search":1,"select_url":"tb_auto_gys_type"}',
  `gys_lianxiren` varchar(255) DEFAULT NULL COMMENT '{"name":"联系人","search":1}',
  `gys_shouji` varchar(20) DEFAULT NULL COMMENT '{"name":"手机","search":1}',
  `gys_zuoji` varchar(20) DEFAULT NULL COMMENT '{"name":"座机"}',
  `gys_qq` varchar(255) DEFAULT NULL COMMENT '{"name":"qq"}',
  `gys_weixin` varchar(255) DEFAULT NULL COMMENT '{"name":"微信"}',
  `gys_dizhi` varchar(255) DEFAULT NULL COMMENT '{"name":"联系地址"}',
  `gys_email` varchar(255) DEFAULT NULL COMMENT '{"name":"邮箱","search":1}',
  `gys_beizhu` text COMMENT '{"name":"备注","textarea":1}',
  PRIMARY KEY (`gys_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_auto_kehu_type
-- ----------------------------
DROP TABLE IF EXISTS `tb_auto_gys_type`;
CREATE TABLE `tb_auto_gys_type` (
  `gl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"ID"}',
  `gl_name` varchar(255) DEFAULT NULL COMMENT '{"name":"分类名称","search":1}',
  PRIMARY KEY (`gl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
