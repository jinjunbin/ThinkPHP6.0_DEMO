/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.28-log : Database - goingdata_tp6
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`goingdata_tp6` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `goingdata_tp6`;

/*Table structure for table `t_address` */

DROP TABLE IF EXISTS `t_address`;

CREATE TABLE `t_address` (
  `iAutoID` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `iUserID` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `sRecipient` varchar(20) NOT NULL DEFAULT '' COMMENT '收件人',
  `sContactInformation` varchar(50) NOT NULL DEFAULT '' COMMENT '联系方式',
  `sProvince` varchar(50) NOT NULL DEFAULT '' COMMENT '省',
  `sCity` varchar(50) NOT NULL DEFAULT '' COMMENT '市',
  `sArea` varchar(50) NOT NULL DEFAULT '' COMMENT '区',
  `sContactAddress` varchar(255) NOT NULL DEFAULT '' COMMENT '联系地址',
  `iStatus` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态(0=正常,1=删除)',
  `iCreateUserID` int(11) NOT NULL DEFAULT '0' COMMENT '创建人ID',
  `iUpdateUserID` int(11) NOT NULL DEFAULT '0' COMMENT '更新人ID',
  `iCreateTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `iUpdateTime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`iAutoID`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COMMENT='地址管理表';

/*Data for the table `t_address` */

insert  into `t_address`(`iAutoID`,`iUserID`,`sRecipient`,`sContactInformation`,`sProvince`,`sCity`,`sArea`,`sContactAddress`,`iStatus`,`iCreateUserID`,`iUpdateUserID`,`iCreateTime`,`iUpdateTime`) values (65,76,'测试组地址11','17633969138','上海','上海','静安','上海上海静安上海上海静安上海上海静安上海大学秋',0,76,76,1565166500,1565166506),(66,79,'诸建东','60930888','上海','上海','长宁','上海市闸北区广中路788号',1,79,0,1564638580,1564638580),(67,76,'线上测试','17633969138','上海','上海','宝山','上海上海宝山1112233',1,76,76,1565166550,1565166550),(68,2,'诸建东','60930888','上海','上海','静安','上海市闸北区广中路788号',1,2,0,1569574002,1569574002),(69,5,'沈许亮','18964093608','新疆','和田','和田县','1231231',0,5,0,1569647194,1572413814),(70,5,'沈许亮','189640936014','山东','临沂','临沭','山东临沂临沭山东临沂临沭123213222222',1,5,5,1572488983,1572488983),(71,5,'沈许亮','18516260984','江苏','淮安','清江浦','2131',0,5,0,1569647722,1572424043),(72,5,'沈许亮','18964093608','重庆','重庆','綦江','123',0,5,0,1569647772,1572424122),(73,1,'111','111','内蒙古','乌海','海南','111',1,1,0,1569722606,1569722606),(74,7,'联通公司','17621216853','上海','上海','奉贤','上海上海奉贤工作台',1,7,0,1570501006,1570501006),(75,2,'test2','13122211331','浙江','金华','婺城','12313a订单',1,2,0,1570843223,1570843223),(76,2,'11111','111111','江西','萍乡','上栗','11111',1,2,0,1571211745,1571211745),(77,2,'111111','11111111','河北','沧州','献县','1111111',1,2,0,1571212293,1571212293),(78,11,'247','247247','河北','唐山','古冶','247',1,11,0,1571728810,1571728810),(79,5,'1','2','内蒙古','乌海','海勃湾','内蒙古乌海海勃湾发反反复复',0,5,5,1572423924,1572486163),(80,5,'4','我','内蒙古','鄂尔多斯','鄂托克前旗','内蒙古鄂尔多斯鄂托克前旗得到的',0,5,0,1572423949,1572486158),(81,2,'1111111','15211111111','新疆','克孜勒','','1111111111',1,2,0,1572573930,1572573930),(82,11,'test2','13122211331','河北','石家庄','赞皇','131',1,11,0,1572847614,1572847614),(83,2,'234234','23424','河北','唐山','古冶','24234',1,2,0,1572916692,1572916692),(84,18,'13124','sr13','西藏','拉萨','墨竹工卡','131',1,18,0,1574672410,1574672410),(85,15,'test2','13524636080','山西','晋中','平遥','13213',1,15,0,1574922701,1574922701),(86,24,'13124','sr13','上海','上海','虹口','大学路26号',1,24,0,1574922813,1574922813),(87,15,'dq4','13524636080','江西','景德镇','昌江','s',0,15,0,1574990603,1576118682),(88,24,'13124','sr13','上海','上海','静安','文峰广场',1,24,0,1574991790,1574991790),(89,24,'13124','sr13','上海','上海','杨浦','五角场合生汇24#',1,24,0,1575249620,1575249620),(90,18,'aeqwe','13123','江苏','盐城','亭湖','123',1,18,0,1575859627,1575859627),(91,5,'12453693','15399000001','河北','大厂','','gggg',1,5,0,1576130624,1576130624),(92,5,'21312','15399720001','河北','大厂','','1412213',1,5,0,1576130985,1576130985),(93,5,'65546654','655656','河南','南阳','社旗','56566+',1,5,0,1576131637,1576131637),(94,5,'2323','262323','浙江','义乌','','213123',1,5,0,1576136038,1576136038),(95,24,'13124','sr13','上海','上海','虹口','虹口体育馆',1,24,0,1577015304,1577015304),(96,24,'13124','sr13','上海','上海','长宁','hongqioajichangjn',1,24,0,1577021677,1577021677),(97,27,'13124','sr13','上海','上海','宝山','上海大学宝山校区1号宿舍',1,27,0,1577154161,1577154161),(98,33,'jokkk','15921222541','上海','上海','宝山','223123',1,33,0,1577329024,1577329024);

/*Table structure for table `t_admin_user` */

DROP TABLE IF EXISTS `t_admin_user`;

CREATE TABLE `t_admin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '后端用户主键ID',
  `username` varchar(100) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '用户密码',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态码 1正常 0待审核 99删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` varchar(100) NOT NULL COMMENT '最后登录IP',
  `operate_user` varchar(100) NOT NULL COMMENT '操作人',
  PRIMARY KEY (`id`),
  UNIQUE KEY `udx_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `t_admin_user` */

insert  into `t_admin_user`(`id`,`username`,`password`,`status`,`create_time`,`update_time`,`last_login_time`,`last_login_ip`,`operate_user`) values (1,'admin','e10adc3949ba59abbe56e057f20f883e',1,0,1579675316,1579675316,'::1','11');

/*Table structure for table `t_user` */

DROP TABLE IF EXISTS `t_user`;

CREATE TABLE `t_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '后端用户主键ID',
  `username` varchar(100) NOT NULL DEFAULT '' COMMENT '用户名',
  `phone_number` varchar(20) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '用户密码',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态码 1正常 0待审核 99删除',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` varchar(100) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `operate_user` varchar(100) NOT NULL DEFAULT '0' COMMENT '操作人',
  PRIMARY KEY (`id`),
  UNIQUE KEY `udx_pgone_number` (`phone_number`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `t_user` */

insert  into `t_user`(`id`,`username`,`phone_number`,`password`,`sex`,`type`,`status`,`create_time`,`update_time`,`last_login_time`,`last_login_ip`,`operate_user`) values (1,'用户-13585687317','135856873171','',0,1,1,1579502454,1579502454,0,'0','0'),(4,'用户-13585687311','13585687317','',2,1,1,1579503209,1579503209,0,'0','0');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
