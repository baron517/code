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
DROP TABLE IF EXISTS `tb_auto_order`;
CREATE TABLE `tb_auto_order` (
  `o_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"ID","caozuo":"hide"}',
  `out_trade_no` varchar(100) NOT NULL COMMENT '{"name":"订单编号","search":1}',
  `o_money` varchar(100) NOT NULL COMMENT '{"name":"金额"}',
  `o_openid` varchar(100) NOT NULL COMMENT '{"name":"openid"}',
  `o_type_zw` varchar(100) NOT NULL COMMENT '{"name":"中文类型名称"}',
  `o_type_yw` varchar(100) NOT NULL COMMENT '{"name":"英文类型名称"}',
  `o_taocan` varchar(100) NOT NULL COMMENT '{"name":"套餐名称"}',
  `o_time` varchar(100) NOT NULL COMMENT '{"name":"预约时间"}',
  `o_create_time` varchar(100) NOT NULL COMMENT '{"name":"下单时间"}',
  `o_status` int(2) NOT NULL DEFAULT '0' COMMENT '{"name":"状态","zhushi":"1代表已支付，0代表未支付"}',
  
  `jiazhang_name` varchar(100) NOT NULL COMMENT '{"name":"家长称呼"}',
  `jz_phone` varchar(20) NOT NULL COMMENT '{"name":"手机","search":1}',
  `email` varchar(100) NOT NULL COMMENT '{"name":"邮箱"}',
  
  `bb_name` varchar(100) NOT NULL COMMENT '{"name":"宝宝姓名"}',
  `bb_xiaoming` varchar(100) NOT NULL COMMENT '{"name":"宝宝小名"}',
  `bb_sex` varchar(100) NOT NULL COMMENT '{"name":"性别"}',
  `bb_birthday` varchar(100) NOT NULL COMMENT '{"name":"生日"}',
  
  `address` varchar(255) NOT NULL COMMENT '{"name":"收件地址"}',
  `sj_name` varchar(100) NOT NULL COMMENT '{"name":"收件地址"}',
  `lx_phone` varchar(100) NOT NULL COMMENT '{"name":"联系电话"}',
  
  `is_agree` varchar(100) NOT NULL COMMENT '{"name":"是否同意展示"}',
  
  PRIMARY KEY (`o_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_auto_order
-- ----------------------------
