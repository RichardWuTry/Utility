-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 05 月 25 日 18:06
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
-- 表的结构 `exam_paper`
--

CREATE TABLE IF NOT EXISTS `exam_paper` (
  `paper_id` int(11) NOT NULL AUTO_INCREMENT,
  `paper_name` varchar(40) NOT NULL,
  `total_score` smallint(6) NOT NULL,
  `total_mins` smallint(6) NOT NULL,
  `paper_desc` varchar(200) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`paper_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `exam_paper`
--

INSERT INTO `exam_paper` (`paper_id`, `paper_name`, `total_score`, `total_mins`, `paper_desc`, `create_at`, `modify_at`) VALUES
(1, '2012年互联网业务培训试题', 100, 120, '2012年互联网业务培训试题', '2012-05-23 16:32:57', '2012-05-23 16:32:57'),
(2, '2012年互联网业务培训试题', 100, 120, '2012年互联网业务培训试题', '2012-05-23 16:39:48', '2012-05-23 16:39:48'),
(3, 'safsfsd', 20, 50, 'safsdfsdfsfsdfsdf', '2012-05-23 16:59:33', '2012-05-23 16:59:33'),
(4, 'sdfsdf', 12, 12, 'sdfsdfsdfsdfsdfsd', '2012-05-24 14:39:41', '2012-05-24 14:39:41'),
(5, 'sdfsdfsda', 34, 354, 'sfsdafsadfasd', '2012-05-24 14:48:02', '2012-05-24 14:48:02'),
(6, 'sdfsdf', 4, 5, 'dsfsdfsad', '2012-05-24 14:49:20', '2012-05-24 14:49:20'),
(7, 'sdfsdafsda', 6, 7, 'sdfasdfsadfa', '2012-05-24 14:51:08', '2012-05-24 14:51:08'),
(8, 'sdfasdfsadf', 9, 12, 'sdfsdafsdafsdaf', '2012-05-24 14:51:51', '2012-05-24 14:51:51'),
(9, 'fsdafsdafsda', 9, 6, 'sdafasdfsadfdsaf', '2012-05-24 14:54:16', '2012-05-24 14:54:16'),
(10, 'sdfsdafasd', 7, 7, 'dsfasdfsadf', '2012-05-24 14:55:45', '2012-05-24 14:55:45'),
(11, 'sdfsadfasd', 5, 5, 'dsfsdafsdaf', '2012-05-24 14:59:36', '2012-05-24 14:59:36'),
(12, 'fasdfsadfsd', 6, 7, 'sdfsdafsdafasd', '2012-05-24 15:05:54', '2012-05-24 15:05:54'),
(13, 'sadfsdaf', 45, 12, 'sdfsdlfjsda;ljfsda;lfj', '2012-05-24 16:25:39', '2012-05-24 16:25:39');

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
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`major_research_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `major_research`
--

INSERT INTO `major_research` (`major_research_id`, `gender`, `major`, `highest_edu`, `work_year`, `job`, `school_help`, `info_source`, `understand_level`, `major_imagine_diff`, `job_major_match`, `major_important`, `choose_current_major`, `choose_major`, `change_reason`, `create_at`, `modify_at`) VALUES
(1, '女', '景观设计', '本科', 6, '景观设计', '完全没用', '父母的意见', '不太了解', '有些不同', '很少匹配', '非常重要', '是', '', '', '2012-04-30 20:18:43', '2012-04-30 20:18:43'),
(2, '男', '力学', '本科', 10, 'Business Analys', '完全没用', '学校组织的指导', '不太了解', '很不一样', '完全没关系', '非常重要', '否', '金融', '不喜欢原专业', '2012-04-30 22:05:58', '2012-05-04 15:03:01'),
(3, '男', '软件工程', '本科', 5, '软件工程师', '很有作用', '学校组织的指导', '较为了解', '基本一致', '较为匹配', '较为重要', '是', '', '', '2012-05-01 23:01:25', '2012-05-01 23:01:25'),
(4, '男', '通信工程', '硕士', 4, '软件工程师', '完全没用', '父母的意见', '不太了解', '很不一样', '很少匹配', '较为重要', '否', '计算机', '不喜欢原专业', '2012-05-04 15:01:00', '2012-05-04 15:01:00'),
(5, '女', '英语', '本科', 7, '文档工程师', '有些作用', '同学之间讨论', '较为了解', '基本一致', '较为匹配', '较为重要', '否', '心理学', '其他原因', '2012-05-04 15:45:35', '2012-05-04 15:45:35'),
(6, '男', '计算科学', '本科', 0, '学生', '完全没用', '自己查资料研究', '较为了解', '基本一致', '很少匹配', '不太重要', '是', '', '', '2012-05-04 22:21:50', '2012-05-07 09:53:27'),
(7, '男', '计算机科学与技术', '本科', 5, '软件工程师', '比没有强', '自己查资料研究', '较为了解', '有些不同', '较为匹配', '较为重要', '是', '', '', '2012-05-07 09:20:51', '2012-05-07 09:20:51');

-- --------------------------------------------------------

--
-- 表的结构 `paper_question`
--

CREATE TABLE IF NOT EXISTS `paper_question` (
  `paper_question_id` int(11) NOT NULL AUTO_INCREMENT,
  `paper_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `question_seq` smallint(6) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`paper_question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `paper_question`
--


-- --------------------------------------------------------

--
-- 表的结构 `question_detail`
--

CREATE TABLE IF NOT EXISTS `question_detail` (
  `question_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `correct_value` tinyint(4) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`question_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `question_detail`
--


-- --------------------------------------------------------

--
-- 表的结构 `question_head`
--

CREATE TABLE IF NOT EXISTS `question_head` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_name` varchar(400) NOT NULL,
  `question_type` varchar(20) NOT NULL,
  `question_score` tinyint(4) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `question_head`
--

