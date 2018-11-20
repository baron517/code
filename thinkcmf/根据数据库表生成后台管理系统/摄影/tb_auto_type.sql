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
DROP TABLE IF EXISTS `tb_auto_type`;
CREATE TABLE `tb_auto_type` (
  
  `t_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"ID"}',
  `t_zw_name` varchar(100) NOT NULL COMMENT '{"name":"中文名","search":1}',
  `t_yw_name` varchar(100) NOT NULL COMMENT '{"name":"英文名"}',
  `t_color` varchar(100) NOT NULL COMMENT '{"name":"颜色","color":"1","info":"例如：#ffffff"}',
  `t_img_index` text COMMENT '{"name":"首页图片","table_hide":1,"muinput":{"name":"名称","upload_img":"图片"}}',
  `t_img_detail` text COMMENT '{"name":"详情图片","table_hide":1,"muinput":{"name":"名称","upload_img":"图片"}}',
   `t_taocan` text COMMENT '{"name":"套餐","table_hide":1,"muinput":{"name":"名称","price":"价格"}}',
  `t_info1` varchar(100) NOT NULL COMMENT '{"name":"主题数"}',
  `t_info2` varchar(100) NOT NULL COMMENT '{"name":"拍摄数量"}',
  `t_info3` varchar(100) NOT NULL COMMENT '{"name":"精修"}',
  `t_info4` varchar(100) NOT NULL COMMENT '{"name":"赠送相框"}',
  `t_info5` varchar(100) NOT NULL COMMENT '{"name":"底片"}',
  `t_for_age` varchar(100) NOT NULL COMMENT '{"name":"适合年龄"}',
  `t_shuoming` text COMMENT '{"name":"特别说明","editor":1}',
  
  PRIMARY KEY (`t_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
