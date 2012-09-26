-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 08 月 20 日 18:00
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `single30_utility_db`
--

-- --------------------------------------------------------

--
-- 表的结构 `contact_us`
--

CREATE TABLE IF NOT EXISTS `contact_us` (
  `contact_us_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `content` varchar(500) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`contact_us_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
