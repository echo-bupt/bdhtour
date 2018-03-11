-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-05-02 11:50:01
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jiacheng`
--

-- --------------------------------------------------------

--
-- 表的结构 `jia_address`
--

CREATE TABLE IF NOT EXISTS `jia_address` (
  `aid` int(8) NOT NULL AUTO_INCREMENT,
  `aname` varchar(16) NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `jia_address`
--

INSERT INTO `jia_address` (`aid`, `aname`) VALUES
(1, '北戴河'),
(2, '秦皇岛'),
(3, '山海关'),
(4, '南戴河'),
(5, '昌黎黄金海岸'),
(6, '其他');

-- --------------------------------------------------------

--
-- 表的结构 `jia_admin`
--

CREATE TABLE IF NOT EXISTS `jia_admin` (
  `aid` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `lock` int(2) NOT NULL DEFAULT '0',
  `passwd` varchar(32) NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `jia_admin`
--

INSERT INTO `jia_admin` (`aid`, `username`, `lock`, `passwd`) VALUES
(1, 'admin', 0, 'cdda86c062f189e948c9755cf1caea19');

-- --------------------------------------------------------

--
-- 表的结构 `jia_hotel`
--

CREATE TABLE IF NOT EXISTS `jia_hotel` (
  `hid` int(8) NOT NULL AUTO_INCREMENT,
  `type` int(8) NOT NULL,
  `hname` varchar(16) NOT NULL,
  `tprice` int(8) NOT NULL DEFAULT '0',
  `time` int(16) NOT NULL DEFAULT '0',
  `is_hui` int(8) NOT NULL DEFAULT '0',
  `des` text,
  `aid` int(8) NOT NULL,
  `del` int(8) NOT NULL DEFAULT '0',
  `rel_ad` varchar(128) NOT NULL DEFAULT '""',
  PRIMARY KEY (`hid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jia_hotel_imgs`
--

CREATE TABLE IF NOT EXISTS `jia_hotel_imgs` (
  `hid` int(8) NOT NULL,
  `img` varchar(64) NOT NULL,
  `alt` varchar(32) NOT NULL,
  `type` int(2) NOT NULL,
  `time` int(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `jia_hotel_room`
--

CREATE TABLE IF NOT EXISTS `jia_hotel_room` (
  `hid` int(8) NOT NULL,
  `price_shi` int(8) NOT NULL DEFAULT '0',
  `price_ping` int(8) NOT NULL DEFAULT '0',
  `price_mo` int(8) NOT NULL DEFAULT '0',
  `cid` int(8) NOT NULL,
  `device` varchar(168) NOT NULL DEFAULT '""'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `jia_order`
--

CREATE TABLE IF NOT EXISTS `jia_order` (
  `oid` int(8) NOT NULL AUTO_INCREMENT,
  `oname` varchar(32) NOT NULL,
  `onum` int(8) NOT NULL,
  `days` int(2) NOT NULL DEFAULT '0',
  `begin` varchar(16) NOT NULL,
  `end` varchar(16) NOT NULL,
  `price_total` int(8) NOT NULL,
  `name` varchar(128) NOT NULL,
  `state` int(2) NOT NULL,
  `order_time` varchar(16) NOT NULL,
  `order_num` int(11) NOT NULL,
  `price` int(8) NOT NULL,
  `hid` int(8) NOT NULL DEFAULT '0',
  `cid` int(2) NOT NULL DEFAULT '0',
  `tid` int(8) NOT NULL DEFAULT '0',
  `telephone` varchar(16) NOT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `jia_order`
--

INSERT INTO `jia_order` (`oid`, `oname`, `onum`, `days`, `begin`, `end`, `price_total`, `name`, `state`, `order_time`, `order_num`, `price`, `hid`, `cid`, `tid`, `telephone`) VALUES
(11, '王新', 1, 1, '1462032000', '1462118400', 600, '北戴河邮电疗养院', 3, '1462088740', 1462088740, 780, 4, 10, 0, '13933501234'),
(14, '黎明', 2, 1, '1462118400', '1462204800', 1176, '北戴河邮电疗养院', 3, '1462150359', 1462150359, 588, 5, 1, 0, '13933592610'),
(15, '试试', 1, 1, '1462118400', '1462204800', 180, '天工东院近海酒店', 3, '1462172778', 1462172778, 180, 8, 7, 0, '13811176234');

-- --------------------------------------------------------

--
-- 表的结构 `jia_room_cat`
--

CREATE TABLE IF NOT EXISTS `jia_room_cat` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(64) NOT NULL,
  `time` int(16) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `jia_room_cat`
--

INSERT INTO `jia_room_cat` (`cid`, `cname`, `time`) VALUES
(1, '标准间', 1461123232),
(4, '大床房', 1461883696),
(5, '情侣房', 1462086947),
(6, '套房', 1462086970),
(7, '三人间', 1462086980),
(8, '四人间', 1462086989),
(9, '五人间', 1462086997),
(10, '主题房', 1462087013);

-- --------------------------------------------------------

--
-- 表的结构 `jia_ticket`
--

CREATE TABLE IF NOT EXISTS `jia_ticket` (
  `tid` int(8) NOT NULL AUTO_INCREMENT,
  `tname` varchar(32) NOT NULL,
  `aid` int(8) NOT NULL,
  `rel_ad` varchar(128) NOT NULL DEFAULT '""',
  `is_hui` int(8) NOT NULL DEFAULT '0',
  `time` int(16) NOT NULL,
  `price` int(8) NOT NULL,
  `tprice` int(8) NOT NULL DEFAULT '0',
  `del` int(8) NOT NULL DEFAULT '0',
  `des` text NOT NULL,
  `descri` varchar(32) NOT NULL DEFAULT '""',
  `man` varchar(16) NOT NULL DEFAULT '99.6%',
  `worktime` varchar(32) NOT NULL DEFAULT '""',
  `notice` text NOT NULL,
  `t1` text NOT NULL,
  `t2` text NOT NULL,
  `t3` text NOT NULL,
  `valid` varchar(64) NOT NULL DEFAULT '一天',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jia_ticket_imgs`
--

CREATE TABLE IF NOT EXISTS `jia_ticket_imgs` (
  `tid` int(8) NOT NULL,
  `img` varchar(64) NOT NULL,
  `type` int(8) NOT NULL,
  `time` int(16) NOT NULL,
  `alt` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `jia_ticket_order`
--

CREATE TABLE IF NOT EXISTS `jia_ticket_order` (
  `oid` int(8) NOT NULL AUTO_INCREMENT,
  `tid` int(8) NOT NULL DEFAULT '1',
  `oname` varchar(64) NOT NULL,
  `onum` int(11) NOT NULL,
  `order_time` varchar(16) NOT NULL,
  `order_num` int(11) NOT NULL,
  `type` varchar(128) NOT NULL,
  `name` varchar(32) NOT NULL,
  `telephone` varchar(16) NOT NULL,
  `price_total` int(8) NOT NULL,
  `state` int(2) NOT NULL DEFAULT '0',
  `idnum` varchar(32) NOT NULL,
  `num` int(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jia_ticket_type`
--

CREATE TABLE IF NOT EXISTS `jia_ticket_type` (
  `tid` int(2) NOT NULL,
  `pid` int(2) NOT NULL,
  `price` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `jia_type`
--

CREATE TABLE IF NOT EXISTS `jia_type` (
  `pid` int(2) NOT NULL AUTO_INCREMENT,
  `pname` varchar(16) NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `jia_type`
--

INSERT INTO `jia_type` (`pid`, `pname`) VALUES
(1, '成人票'),
(2, '学生票'),
(3, '老年人票'),
(4, '儿童票');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
