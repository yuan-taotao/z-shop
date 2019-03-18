/*
Navicat MySQL Data Transfer

Source Server         : yt
Source Server Version : 50711
Source Host           : localhost:3306
Source Database       : project

Target Server Type    : MYSQL
Target Server Version : 50711
File Encoding         : 65001

Date: 2018-10-25 16:15:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for goods
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeid` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `company` varchar(50) DEFAULT NULL,
  `descr` text NOT NULL,
  `pic` char(37) NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0',
  `store` smallint(6) NOT NULL DEFAULT '0',
  `num` int(11) NOT NULL DEFAULT '0',
  `clicknum` int(10) unsigned NOT NULL DEFAULT '0',
  `price` double(8,2) NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goods
-- ----------------------------
INSERT INTO `goods` VALUES ('20', '65', '创维 43M9 43英寸HDR 人工智能 4K超高清 网络液晶平板电视机', '创维', '人工智能，15核，A73芯片，4K HDR，爱奇艺影视！', '12675afbf871505e34ba8367211bee0b.jpg', '0', '12', '0', '5', '5599.00', '1540197131');
INSERT INTO `goods` VALUES ('21', '65', 'TCL电视 60A730U 60寸4K超薄 30核64位 智能LED液晶电视', 'TCL', 'AI超薄金属机身，海量视频，畅享4K超清观影！', 'b6f9a78703e063c703906ce5c35971e3.jpg', '0', '8', '0', '4', '2999.00', '1540197221');
INSERT INTO `goods` VALUES ('22', '65', 'TCL电视 55A950C 55寸4K 曲面32核人工智能超薄 HDR智能LED液晶电视', 'TCL', '超薄AI曲面，3万+好评力荐，好口碑好品质', '277a2dcd51c7f1d5aa6bc08acdce0c5d.jpg', '1', '11', '0', '3', '4019.00', '1540197282');
INSERT INTO `goods` VALUES ('23', '65', 'TCL电视 49A660U 49英寸4K 30核 网络智能LED液晶电视 热销', 'TCL', '4K纤薄金属机身', 'dd9d8d6da7eb40bb5e53d738645fb3fd.jpg', '1', '27', '0', '2', '3699.00', '1540197351');
INSERT INTO `goods` VALUES ('18', '65', '创维 65M9 65英寸人工智能HDR 4K超高清智能网络液晶电视机', '创维', '65英寸大屏爆款！人工智能，A73芯片，15核，4K HDR！', 'e0323d907089fba23680b4975e0b0641.jpg', '1', '10', '0', '1', '4799.00', '1540196964');
INSERT INTO `goods` VALUES ('19', '65', '创维 60V1 60英寸 超薄HDR人工智能4K超高清智能电视', '创维', 'HDR 人工智能！', '788bb59ba79299e8195b914b2fd58688.jpg', '2', '20', '0', '0', '4799.00', '1540197063');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `linkman` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` char(11) NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  `total` double(8,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `goodsid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `sc` int(10) NOT NULL DEFAULT '0',
  `goodsname` varchar(255) NOT NULL,
  `goodspic` varchar(37) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('16', '14', '康寒', '四川成都市高兴区', '15281491179', '1540297013', '5599.00', '1', '20', '1', '5599.00', '0', '创维 43M9 43英寸HDR 人工智能 4K超高清 网络液晶平板电视机', '12675afbf871505e34ba8367211bee0b.jpg');
INSERT INTO `orders` VALUES ('17', '13', '林阳', '四川成都市锦江区', '17726499745', '1540342175', '4799.00', '1', '19', '1', '4799.00', '0', '创维 60V1 60英寸 超薄HDR人工智能4K超高清智能电视', '788bb59ba79299e8195b914b2fd58688.jpg');
INSERT INTO `orders` VALUES ('23', '13', '袁涛', '四川成都市高兴区', '15281491179', '1540451109', '15197.00', '2', '19', '2', '4799.00', '0', '创维 60V1 60英寸 超薄HDR人工智能4K超高清智能电视', '788bb59ba79299e8195b914b2fd58688.jpg');
INSERT INTO `orders` VALUES ('22', '21', '张程', '四川成都市高兴区', '15281491179', '1540447741', '10398.00', '1', '20', '1', '5599.00', '0', '创维 43M9 43英寸HDR 人工智能 4K超高清 网络液晶平板电视机', '12675afbf871505e34ba8367211bee0b.jpg');
INSERT INTO `orders` VALUES ('21', '21', '张程', '四川成都市高兴区', '15281491179', '1540447741', '10398.00', '1', '19', '1', '4799.00', '0', '创维 60V1 60英寸 超薄HDR人工智能4K超高清智能电视', '788bb59ba79299e8195b914b2fd58688.jpg');
INSERT INTO `orders` VALUES ('24', '13', '袁涛', '四川成都市高兴区', '15281491179', '1540451109', '15197.00', '0', '20', '1', '5599.00', '0', '创维 43M9 43英寸HDR 人工智能 4K超高清 网络液晶平板电视机', '12675afbf871505e34ba8367211bee0b.jpg');

-- ----------------------------
-- Table structure for type
-- ----------------------------
DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6376 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of type
-- ----------------------------
INSERT INTO `type` VALUES ('1', '手机', '0', '0,');
INSERT INTO `type` VALUES ('2', '电脑', '0', '0,');
INSERT INTO `type` VALUES ('3', '移动电源', '1', '0,1,');
INSERT INTO `type` VALUES ('4', '笔记本电脑', '2', '0,2,');
INSERT INTO `type` VALUES ('5', 'DIV', '0', '0,');
INSERT INTO `type` VALUES ('6', '耳机', '1', '0,1,');
INSERT INTO `type` VALUES ('7', '手机贴膜', '1', '0,1,');
INSERT INTO `type` VALUES ('8', '保护套', '1', '0,1,');
INSERT INTO `type` VALUES ('9', '华为数据线', '1', '0,1,');
INSERT INTO `type` VALUES ('10', '充电器', '1', '0,1,');
INSERT INTO `type` VALUES ('11', '手机维修', '1', '0,1,');
INSERT INTO `type` VALUES ('12', '游戏本', '2', '0,2,');
INSERT INTO `type` VALUES ('13', ' 超极本', '2', '0,2,');
INSERT INTO `type` VALUES ('14', '二合一平板电脑', '2', '0,2,');
INSERT INTO `type` VALUES ('15', '平板电脑', '2', '0,2,');
INSERT INTO `type` VALUES ('16', '品牌整机一体机', '2', '0,2,');
INSERT INTO `type` VALUES ('17', ' 笔记本配件', '2', '0,2,');
INSERT INTO `type` VALUES ('18', '笔记本电池', '2', '0,2,');
INSERT INTO `type` VALUES ('19', '笔记本包', '2', '0,2,');
INSERT INTO `type` VALUES ('20', 'DIY主机', '5', '0,5,');
INSERT INTO `type` VALUES ('21', '团购钜惠', '5', '0,5,');
INSERT INTO `type` VALUES ('22', '硬盘 ', '5', '0,5,');
INSERT INTO `type` VALUES ('23', '电源', '5', '0,5,');
INSERT INTO `type` VALUES ('24', '散热器', '5', '0,5,');
INSERT INTO `type` VALUES ('25', 'CPU', '5', '0,5,');
INSERT INTO `type` VALUES ('26', '机箱', '5', '0,5,');
INSERT INTO `type` VALUES ('27', '主板', '5', '0,5,');
INSERT INTO `type` VALUES ('28', '内存固态硬盘', '5', '0,5,');
INSERT INTO `type` VALUES ('29', '显卡', '5', '0,5,');
INSERT INTO `type` VALUES ('30', '数码', '0', '0,');
INSERT INTO `type` VALUES ('31', '数码相机', '30', '0,30,');
INSERT INTO `type` VALUES ('32', '摄像机', '30', '0,30,');
INSERT INTO `type` VALUES ('33', '相机镜头', '30', '0,30,');
INSERT INTO `type` VALUES ('34', '相机电池', '30', '0,30,');
INSERT INTO `type` VALUES ('35', '闪光灯', '30', '0,30,');
INSERT INTO `type` VALUES ('36', '滤镜', '30', '0,30,');
INSERT INTO `type` VALUES ('37', '电子教育拍立得', '30', '0,30,');
INSERT INTO `type` VALUES ('38', '相机包', '30', '0,30,');
INSERT INTO `type` VALUES ('39', '相机遥控器', '30', '0,30,');
INSERT INTO `type` VALUES ('40', '闪存卡', '30', '0,30,');
INSERT INTO `type` VALUES ('41', '外设', '0', '0,');
INSERT INTO `type` VALUES ('42', '键盘', '41', '0,41,');
INSERT INTO `type` VALUES ('43', '鼠标', '41', '0,41,');
INSERT INTO `type` VALUES ('44', '键鼠套装', '41', '0,41,');
INSERT INTO `type` VALUES ('45', '鼠标垫', '41', '0,41,');
INSERT INTO `type` VALUES ('46', '耳机', '41', '0,41,');
INSERT INTO `type` VALUES ('47', '音响', '41', '0,41,');
INSERT INTO `type` VALUES ('48', '投影仪', '41', '0,41,');
INSERT INTO `type` VALUES ('49', '录音笔路由器', '41', '0,41,');
INSERT INTO `type` VALUES ('50', '移动硬盘', '41', '0,41,');
INSERT INTO `type` VALUES ('51', 'U盘', '41', '0,41,');
INSERT INTO `type` VALUES ('52', '摄像头', '41', '0,41,');
INSERT INTO `type` VALUES ('53', '手柄', '41', '0,41,');
INSERT INTO `type` VALUES ('54', '智能', '0', '0,');
INSERT INTO `type` VALUES ('55', '智能手环', '54', '0,54,');
INSERT INTO `type` VALUES ('56', '智能手表', '54', '0,54,');
INSERT INTO `type` VALUES ('57', 'VR眼镜', '54', '0,54,');
INSERT INTO `type` VALUES ('58', '健康监测', '54', '0,54,');
INSERT INTO `type` VALUES ('59', '智能机器人', '54', '0,54,');
INSERT INTO `type` VALUES ('60', '智能电子秤', '54', '0,54,');
INSERT INTO `type` VALUES ('61', '智能灯', '54', '0,54,');
INSERT INTO `type` VALUES ('62', '智能投影', '54', '0,54,');
INSERT INTO `type` VALUES ('63', 'HTC VIVE', '54', '0,54,');
INSERT INTO `type` VALUES ('64', '手机', '1', '0,1,');
INSERT INTO `type` VALUES ('65', '口碑单品', '69', '0,69,');
INSERT INTO `type` VALUES ('66', '大牌钜惠', '69', '0,69,');
INSERT INTO `type` VALUES ('67', '袁涛', '69', '0,69,');
INSERT INTO `type` VALUES ('69', '家电优选', '0', '0,');
INSERT INTO `type` VALUES ('6375', '袁涛', '0', '0,');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(18) NOT NULL,
  `pwd` char(32) NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1',
  `addtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('19', 'yt', '4297f44b13955235245b2497399d7a93', '1', '1540446803');
INSERT INTO `user` VALUES ('15', 'xiangduanjia', 'e10adc3949ba59abbe56e057f20f883e', '1', '1539856263');
INSERT INTO `user` VALUES ('13', 'lingyang', 'e10adc3949ba59abbe56e057f20f883e', '3', '1539848602');
INSERT INTO `user` VALUES ('14', 'hanhan', 'e10adc3949ba59abbe56e057f20f883e', '3', '1539849214');
INSERT INTO `user` VALUES ('21', 'zhangcheng', '4297f44b13955235245b2497399d7a93', '1', '1540446888');
INSERT INTO `user` VALUES ('16', 'jiangcan', 'e10adc3949ba59abbe56e057f20f883e', '1', '1539865265');

-- ----------------------------
-- Table structure for user_hangye
-- ----------------------------
DROP TABLE IF EXISTS `user_hangye`;
CREATE TABLE `user_hangye` (
  `hid` int(11) NOT NULL AUTO_INCREMENT,
  `hname` varchar(200) NOT NULL,
  PRIMARY KEY (`hid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_hangye
-- ----------------------------
INSERT INTO `user_hangye` VALUES ('1', '按摩师');
INSERT INTO `user_hangye` VALUES ('2', 'IT');
INSERT INTO `user_hangye` VALUES ('3', '服务业');
INSERT INTO `user_hangye` VALUES ('4', '个体户');
INSERT INTO `user_hangye` VALUES ('5', '工程师');
INSERT INTO `user_hangye` VALUES ('6', '理发师');
INSERT INTO `user_hangye` VALUES ('7', '钢筋工');

-- ----------------------------
-- Table structure for user_info
-- ----------------------------
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `uid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `sex` tinyint(4) NOT NULL DEFAULT '0',
  `age` tinyint(4) NOT NULL,
  `code` char(18) NOT NULL,
  `phone` char(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `hobby` varchar(255) NOT NULL,
  `ysr` tinyint(4) NOT NULL,
  `xueli` tinyint(4) NOT NULL DEFAULT '0',
  `email` varchar(60) NOT NULL,
  `hunfou` tinyint(4) NOT NULL DEFAULT '0',
  `pic` char(37) NOT NULL,
  `hangyeid` tinyint(4) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_info
-- ----------------------------
INSERT INTO `user_info` VALUES ('13', '林阳', '1', '23', '513822199510029117', '15281491179', '四川金堂', '1', '0', '0', '1228638809@qq.com', '1', '43a34bf578fc2d60cbcacbac32f1e1e8.jpg', '3');
INSERT INTO `user_info` VALUES ('4', '袁涛', '1', '23', '513822199510029117', '17726499745', '四川省眉山市', '0,2', '0', '0', '1228638809@qq.com', '0', '5ee0edb53f41270a30f12cf7abfe68a8.jpg', '4');
INSERT INTO `user_info` VALUES ('14', '康寒', '1', '23', '513822199510029117', '15281491178', '四川成都市机投镇', '0,2', '0', '0', '1228638809@qq.com', '0', '8464532444fd1a8cbe460757a951ecf0.jpg', '5');
INSERT INTO `user_info` VALUES ('15', '向段佳', '1', '22', '513822199510029117', '15281491179', '四川绵阳市', '0,2', '0', '0', '1228638809@qq.com', '1', 'a4cf317ae104f34b4d30d4af91252469.jpg', '2');
INSERT INTO `user_info` VALUES ('16', '蒋灿', '1', '22', '513822199510029117', '15281491134', '四川省资阳市', '1,3,6', '0', '0', '704824571@qq.com', '2', 'a3c1b7a4ed42345cece6b377a778e2bf.jpg', '5');
