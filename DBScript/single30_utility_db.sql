-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 04 月 27 日 17:34
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `single30_utility`
--

-- --------------------------------------------------------

--
-- 表的结构 `major_research`
--

use single30_utility_db;

CREATE TABLE IF NOT EXISTS `major_research` (
  `major_research_id` int(11) NOT NULL AUTO_INCREMENT,
  `gender` char(1) NOT NULL,
  `major` varchar(15) NOT NULL,
  `highest_edu` char(2) NOT NULL,
  `work_year` tinyint(4) NOT NULL,
  `job` varchar(15) NOT NULL,
  `school_help` varchar(10) NOT NULL,
  `info_source` varchar(10) NOT NULL,
  `understand_level` varchar(10) NOT NULL,
  `major_imagine_diff` varchar(10) NOT NULL,
  `job_major_match` varchar(10) NOT NULL,
  `major_important` varchar(10) NOT NULL,
  `choose_current_major` char(1) NOT NULL,
  `choose_major` varchar(15) NOT NULL,
  `change_reason` varchar(30) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`major_research_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `major_research`
--