/*
Navicat MySQL Data Transfer

Source Server         : 47.99.190.127_sheying
Source Server Version : 50562
Source Host           : 47.99.190.127:3306
Source Database       : sheying

Target Server Type    : MYSQL
Target Server Version : 50562
File Encoding         : 65001

Date: 2019-03-05 14:11:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_auto_type_lunbo
-- ----------------------------
DROP TABLE IF EXISTS `tb_auto_type_lunbo`;
CREATE TABLE `tb_auto_type_lunbo` (
  `tl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"ID"}',
  `tl_t_id` varchar(100) NOT NULL COMMENT '{"name":"分类","select":1,"select_id":"t_id","select_url":"tb_auto_type"}',
  `tl_img_index` text COMMENT '{"name":"轮播图片","table_hide":1,"muinput":{"name":"名称","upload_img":"图片"}}',
  `tl_title` text COMMENT '{"name":"标题","search":1}',
  `tl_sub_tile` varchar(100) NOT NULL COMMENT '{"name":"适合年龄"}',
  `tl_px` int(10) NOT NULL COMMENT '{"name":"排序"}',
  PRIMARY KEY (`tl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COMMENT='{"no_create":1}';
