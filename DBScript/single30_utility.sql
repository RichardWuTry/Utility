-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 04 月 27 日 17:34
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.5

CREATE DATABASE IF NOT EXISTS 
	`single30_utility` 
DEFAULT CHARACTER SET 
	utf8 
COLLATE 
	utf8_general_ci;
	
GRANT ALL PRIVILEGES ON
	single30_utility.*
TO
	'single30_utlapp'@'localhost'
IDENTIFIED BY
	'BaoChangJi';


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
  `create_at` timestamp NULL DEFAULT NULL,
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`major_research_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `major_research`
--

INSERT INTO `major_research` (`major_research_id`, `gender`, `major`, `highest_edu`, `work_year`, `job`, `school_help`, `info_source`, `understand_level`, `major_imagine_diff`, `job_major_match`, `major_important`, `choose_current_major`, `choose_major`, `change_reason`, `create_at`, `modify_at`) VALUES
(1, '男', '通信工程', '硕士', 4, '软件工程师', '很有作用', '父母的意见', '很清楚这个专业', '基本一致', '非常匹配', '非常重要', '否', '其他', '发现自己不喜欢原来的专业', NULL, '2012-04-27 17:27:39');
