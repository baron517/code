/*
Navicat MySQL Data Transfer

Source Server         : 106.14.44.160
Source Server Version : 50558
Source Host           : 106.14.44.160:3306
Source Database       : taidun_xietong

Target Server Type    : MYSQL
Target Server Version : 50558
File Encoding         : 65001

Date: 2018-10-07 20:35:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_auto_caigou
-- ----------------------------
DROP TABLE IF EXISTS `tb_auto_caigou`;
CREATE TABLE `tb_auto_caigou` (
  `cg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '{"name":"编号"}',
  `cg_name` varchar(255) DEFAULT NULL COMMENT '{"name":"商品名称","select":1,"select_url":"tb_auto_shangpin","search":1}',
  `cg_danwei` varchar(255) DEFAULT NULL COMMENT '{"name":"单位"}',
  `cg_shijian` varchar(255) DEFAULT NULL COMMENT '{"name":"时间","search":1,"date":1}',
  `cg_shuliang` varchar(255) DEFAULT NULL COMMENT '{"name":"数量"}',
  `cg_danjia` float(8,0) DEFAULT NULL COMMENT '{"name":"购货单价(元)","search":1}',
  `cg_zhekoulv` varchar(255) DEFAULT NULL COMMENT '{"name":"折扣率(%)"}',
  `cg_zhekoue` varchar(255) DEFAULT NULL COMMENT '{"name":"折扣额"}',
  `cg_jine` float(8,0) DEFAULT NULL COMMENT '{"name":"购货金额(元)"}',
  `cg_beizhu` text COMMENT '{"name":"备注","textarea":1}',
  PRIMARY KEY (`cg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

