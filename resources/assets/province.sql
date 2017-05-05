/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : larose-02

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-05-05 23:51:07
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `province`
-- ----------------------------
DROP TABLE IF EXISTS province;
CREATE TABLE province (
  id int(5) NOT NULL,
  name varchar(100) NOT NULL,
  type varchar(30) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of province
-- ----------------------------
-- INSERT INTO `province` VALUES ('1', 'Hà Nội', 'Thành Phố');
-- INSERT INTO `province` VALUES ('2', 'Hà Giang', 'Tỉnh');
-- INSERT INTO `province` VALUES ('4', 'Cao Bằng', 'Tỉnh');
-- INSERT INTO `province` VALUES ('6', 'Bắc Kạn', 'Tỉnh');
-- INSERT INTO `province` VALUES ('8', 'Tuyên Quang', 'Tỉnh');
-- INSERT INTO `province` VALUES ('10', 'Lào Cai', 'Tỉnh');
-- INSERT INTO `province` VALUES ('11', 'Điện Biên', 'Tỉnh');
-- INSERT INTO `province` VALUES ('12', 'Lai Châu', 'Tỉnh');
-- INSERT INTO `province` VALUES ('14', 'Sơn La', 'Tỉnh');
-- INSERT INTO `province` VALUES ('15', 'Yên Bái', 'Tỉnh');
-- INSERT INTO `province` VALUES ('17', 'Hòa Bình', 'Tỉnh');
-- INSERT INTO `province` VALUES ('19', 'Thái Nguyên', 'Tỉnh');
-- INSERT INTO `province` VALUES ('20', 'Lạng Sơn', 'Tỉnh');
-- INSERT INTO `province` VALUES ('22', 'Quảng Ninh', 'Tỉnh');
-- INSERT INTO `province` VALUES ('24', 'Bắc Giang', 'Tỉnh');
-- INSERT INTO `province` VALUES ('25', 'Phú Thọ', 'Tỉnh');
-- INSERT INTO `province` VALUES ('26', 'Vĩnh Phúc', 'Tỉnh');
-- INSERT INTO `province` VALUES ('27', 'Bắc Ninh', 'Tỉnh');
-- INSERT INTO `province` VALUES ('30', 'Hải Dương', 'Tỉnh');
-- INSERT INTO `province` VALUES ('31', 'Hải Phòng', 'Thành Phố');
-- INSERT INTO `province` VALUES ('33', 'Hưng Yên', 'Tỉnh');
-- INSERT INTO `province` VALUES ('34', 'Thái Bình', 'Tỉnh');
-- INSERT INTO `province` VALUES ('35', 'Hà Nam', 'Tỉnh');
-- INSERT INTO `province` VALUES ('36', 'Nam Định', 'Tỉnh');
-- INSERT INTO `province` VALUES ('37', 'Ninh Bình', 'Tỉnh');
-- INSERT INTO `province` VALUES ('38', 'Thanh Hóa', 'Tỉnh');
-- INSERT INTO `province` VALUES ('40', 'Nghệ An', 'Tỉnh');
-- INSERT INTO `province` VALUES ('42', 'Hà Tĩnh', 'Tỉnh');
-- INSERT INTO `province` VALUES ('44', 'Quảng Bình', 'Tỉnh');
-- INSERT INTO `province` VALUES ('45', 'Quảng Trị', 'Tỉnh');
-- INSERT INTO `province` VALUES ('46', 'Thừa Thiên Huế', 'Tỉnh');
-- INSERT INTO `province` VALUES ('48', 'Đà Nẵng', 'Thành Phố');
-- INSERT INTO `province` VALUES ('49', 'Quảng Nam', 'Tỉnh');
-- INSERT INTO `province` VALUES ('51', 'Quảng Ngãi', 'Tỉnh');
-- INSERT INTO `province` VALUES ('52', 'Bình Định', 'Tỉnh');
-- INSERT INTO `province` VALUES ('54', 'Phú Yên', 'Tỉnh');
-- INSERT INTO `province` VALUES ('56', 'Khánh Hòa', 'Tỉnh');
-- INSERT INTO `province` VALUES ('58', 'Ninh Thuận', 'Tỉnh');
-- INSERT INTO `province` VALUES ('60', 'Bình Thuận', 'Tỉnh');
-- INSERT INTO `province` VALUES ('62', 'Kon Tum', 'Tỉnh');
-- INSERT INTO `province` VALUES ('64', 'Gia Lai', 'Tỉnh');
-- INSERT INTO `province` VALUES ('66', 'Đắk Lắk', 'Tỉnh');
-- INSERT INTO `province` VALUES ('67', 'Đắk Nông', 'Tỉnh');
-- INSERT INTO `province` VALUES ('68', 'Lâm Đồng', 'Tỉnh');
-- INSERT INTO `province` VALUES ('70', 'Bình Phước', 'Tỉnh');
-- INSERT INTO `province` VALUES ('72', 'Tây Ninh', 'Tỉnh');
-- INSERT INTO `province` VALUES ('74', 'Bình Dương', 'Tỉnh');
-- INSERT INTO `province` VALUES ('75', 'Đồng Nai', 'Tỉnh');
-- INSERT INTO `province` VALUES ('77', 'Bà Rịa - Vũng Tàu', 'Tỉnh');
-- INSERT INTO `province` VALUES ('79', 'Hồ Chí Minh', 'Thành Phố');
-- INSERT INTO `province` VALUES ('80', 'Long An', 'Tỉnh');
-- INSERT INTO `province` VALUES ('82', 'Tiền Giang', 'Tỉnh');
-- INSERT INTO `province` VALUES ('83', 'Bến Tre', 'Tỉnh');
-- INSERT INTO `province` VALUES ('84', 'Trà Vinh', 'Tỉnh');
-- INSERT INTO `province` VALUES ('86', 'Vĩnh Long', 'Tỉnh');
-- INSERT INTO `province` VALUES ('87', 'Đồng Tháp', 'Tỉnh');
-- INSERT INTO `province` VALUES ('89', 'An Giang', 'Tỉnh');
-- INSERT INTO `province` VALUES ('91', 'Kiên Giang', 'Tỉnh');
-- INSERT INTO `province` VALUES ('92', 'Cần Thơ', 'Thành Phố');
-- INSERT INTO `province` VALUES ('93', 'Hậu Giang', 'Tỉnh');
-- INSERT INTO `province` VALUES ('94', 'Sóc Trăng', 'Tỉnh');
-- INSERT INTO `province` VALUES ('95', 'Bạc Liêu', 'Tỉnh');
-- INSERT INTO `province` VALUES ('96', 'Cà Mau', 'Tỉnh');
