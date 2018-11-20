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
DROP TABLE IF EXISTS `tb_auto_laoshi`;
CREATE TABLE `tb_auto_laoshi` (
  `ls_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"ID"}',
  `ls_name` varchar(100) NOT NULL COMMENT '{"name":"姓名","search":1}',
  `ls_openid` varchar(100) NOT NULL COMMENT '{"name":"openid","table_hide":1,"form_hide":"1"}',
  `ls_avatar` varchar(100) NOT NULL COMMENT '{"name":"头像"}',
  `ls_phone` varchar(20) NOT NULL COMMENT '{"name":"手机","search":1}',
  `ls_sex` varchar(100) NOT NULL COMMENT '{"name":"性别"}',
  `ls_address` varchar(100) NOT NULL COMMENT '{"name":"住址"}',
  `ls_id_card` varchar(100) NOT NULL COMMENT '{"name":"身份证号码"}',
  
  `ls_id_card_front` varchar(100) NOT NULL COMMENT '{"name":"身份证正面","upload":"img"}',
  `ls_id_card_back` varchar(100) NOT NULL COMMENT '{"name":"身份证反面","upload":"img"}',

  `ls_create_time` varchar(100) NOT NULL COMMENT '{"name":"加入时间","create_time":"1"}',
  `ls_status` int(2) NOT NULL DEFAULT '0' COMMENT '{"name":"状态","zhushi":"1代表在职，0辞职"}',
  `ls_beizhu` text NOT NULL COMMENT '{"name":"备注","textarea":"1"}',
  `ls_detail` varchar(100) NOT NULL COMMENT '{"name":"详情","editor":"1"}',

  
  PRIMARY KEY (ls_id)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_auto_order
-- ----------------------------
