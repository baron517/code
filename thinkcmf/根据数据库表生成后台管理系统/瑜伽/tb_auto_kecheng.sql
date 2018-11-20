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
DROP TABLE IF EXISTS `tb_auto_kecheng`;
CREATE TABLE `tb_auto_kecheng` (
  
  `k_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"ID"}',
  `k_name` varchar(100) NOT NULL COMMENT '{"name":"课程名称","search":1}',
  `k_img` varchar(100) NOT NULL COMMENT '{"name":"图片","upload":1}',
  `k_info` varchar(100) NOT NULL COMMENT '{"name":"课程简介"}',
  `k_time` varchar(100) NOT NULL COMMENT '{"name":"时长"}',
  `k_img_index` text COMMENT '{"name":"轮播图片","table_hide":1,"muinput":{"name":"名称","upload_img":"图片"}}',
  `k_kcjs` text COMMENT '{"name":"课程介绍","editor":1}',
  `k_zysx` text COMMENT '{"name":"注意事项","editor":1}',
  `k_xdxz` text COMMENT '{"name":"下单须知","editor":1}',
  
  PRIMARY KEY (`k_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
