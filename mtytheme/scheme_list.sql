-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- 主机: w.rdc.sae.sina.com.cn:3307
-- 生成日期: 2014 年 07 月 16 日 22:23
-- 服务器版本: 5.5.23
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `app_mtytheme`
--

-- --------------------------------------------------------

--
-- 表的结构 `scheme_list`
--

CREATE TABLE IF NOT EXISTS `scheme_list` (
  `scheme_id` varchar(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `cate` varchar(6) NOT NULL,
  `keyword` varchar(11) NOT NULL,
  `wx_level` varchar(20) NOT NULL,
  `level` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `scheme_path` varchar(100) NOT NULL,
  `logo` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `install_times` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`scheme_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `scheme_list`
--

INSERT INTO `scheme_list` (`scheme_id`, `name`, `cate`, `keyword`, `wx_level`, `level`, `description`, `scheme_path`, `logo`, `status`, `install_times`, `create_time`) VALUES
('yongqi', '永琪定制方案', 'hair', '美发 预约', '认证订阅号，服务号', '大型连锁店', '永琪美业定制的方案，包含微信预约，我型我秀，多门店支持。用户在微信预约后获得积分奖励，使用累计的积分，可以换取活动奖品。用户可以分享造型设计到朋友圈，提升设计师的人气。', '/themes/hair/yongqi', 'thumb/hair_logo.png', 1, 0, '2014-04-08 15:31:57'),
('hair_common', '美发通用方案', 'hair', '美发 预约', '认证订阅号，服务号', '一般美发店铺', '本方案实用于一般的美发店铺，主要功能为客户的预约，客户分享造型，制定造型预约等功能，加强造型师与客户的互动，长久留住客户。', '/themes/hair/hair_common', 'thumb/common_logo.png', 1, 0, '2014-04-09 10:18:07'),
('languan', '蓝馆七号定制方案', 'club', '健身会所', '认证订阅号，服务号', '大型健身会所', '蓝馆七号定制方案，主要以微网站为主要内容，将会所的情况展示给客户，让客户更简单方便的了解会所的具体情况也配置，同时还以抽奖活动的形式，与客户互动，同时还配有加盟、招聘等信息采集功能。', '/themes/club/languan', 'thumb/club_logo.png', 1, 0, '2014-04-08 15:31:47'),
('feima', '飞马健身定制方案', 'club', '健身会所', '认证订阅号，服务号', '大型健身会所', '飞马健身定制方案，主要以连锁店铺的形式，展示多个门店的不同介绍，名星教练的展示。 微信会员卡管理。以及后期即将推出的，跨店铺、跨行业的优质会员共享等。', '/themes/club/feima', 'thumb/club_logo.png', 1, 0, '2014-04-08 15:31:44');
