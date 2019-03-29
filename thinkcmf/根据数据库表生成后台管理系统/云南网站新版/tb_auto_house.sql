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
-- Table structure for tb_auto_house
-- ----------------------------
DROP TABLE IF EXISTS `tb_auto_house`;
CREATE TABLE `tb_auto_house` (
  `h_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"ID"}',
  `h_px` int(10) NOT NULL COMMENT '{"name":"排序"}',
  `h_tile` varchar(255) NOT NULL COMMENT '{"name":"标题"}',
  `h_sub_tile` varchar(255) NOT NULL COMMENT '{"name":"二级标题"}',
  
  `h_is_tui` varchar(255) NOT NULL COMMENT '{"name":"是否推荐"}',
  
  
  `h_area` varchar(255) NOT NULL COMMENT '{"name":"星星数","select":1,"type":{"1":"景洪","2":"市中心","3":"告庄西双景","4":"嘎栋","5":"嘎洒","6":"橄榄坝","7":"勐海","8":"勐腊","9":"曼弄枫"}}',
  `h_price` int(10) NOT NULL COMMENT '{"name":"价格"}',
  `h_huxing` varchar(255) NOT NULL COMMENT '{"name":"星星数","select":1,"type":{"1":"一房","2":"二房","3":"三房","4":"别墅","5":"其他"}}',
  `h_type` varchar(255) NOT NULL COMMENT '{"name":"类型","select":1,"type":{"1":"住宅","2":"公寓","3":"洋房","4":"别墅","5":"商铺","6":"其他"}}',
  `h_img_index` text COMMENT '{"name":"轮播图片","table_hide":1,"muinput":{"name":"名称","upload_img":"图片"}}',
  
  `h_mianji` int(10) NOT NULL COMMENT '{"name":"建筑面积"}',
  
  `h_danjia` varchar(255) NOT NULL COMMENT '{"name":"单价"}',
  `h_guapai` varchar(255) NOT NULL COMMENT '{"name":"挂牌"}',
  `h_chaoxiang` varchar(255) NOT NULL COMMENT '{"name":"朝向"}',
  `h_louceng` varchar(255) NOT NULL COMMENT '{"name":"楼层"}',
  `h_louxing` varchar(255) NOT NULL COMMENT '{"name":"楼型"}',
  `h_dianti` varchar(255) NOT NULL COMMENT '{"name":"电梯"}',

  
  
  `h_zhuangxiu` varchar(255) NOT NULL COMMENT '{"name":"装修"}',
  `h_niandai` varchar(255) NOT NULL COMMENT '{"name":"年代"}',
  `h_yongtu` varchar(255) NOT NULL COMMENT '{"name":"用途"}',
  `h_quanshu` varchar(255) NOT NULL COMMENT '{"name":"权属"}',
  `h_xiaoqu` varchar(255) NOT NULL COMMENT '{"name":"小区"}',
  
  
  `h_keting` varchar(255) NOT NULL COMMENT '{"name":"客厅"}',
  
  `h_cangting` varchar(255) NOT NULL COMMENT '{"name":"餐厅"}',
  
  `h_shufang` varchar(255) NOT NULL COMMENT '{"name":"书房"}',	
  
  `h_huxingimg` varchar(255) NOT NULL COMMENT '{"name":"户型图"}',
  
  `h_ditu` varchar(255) NOT NULL COMMENT '{"name":"地图"}',
  
  PRIMARY KEY (h_id)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COMMENT='{"no_create":1}';
