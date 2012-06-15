-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 06 月 15 日 17:50
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
(1, '2012年互联网业务培训试题1', 101, 122, '2012年互联网业务培训试题1，但是福建师大；了福建师大；了解范德萨；老附件撒旦；了福建师大；老附件撒旦；了福建师大；法律框架撒旦；浪费空间都是', '2012-05-23 16:32:57', '2012-06-13 15:32:47'),
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
-- 表的结构 `input_detail`
--

CREATE TABLE IF NOT EXISTS `input_detail` (
  `input_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `row_count` smallint(6) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`input_detail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `input_detail`
--

INSERT INTO `input_detail` (`input_detail_id`, `question_id`, `row_count`, `create_at`, `modify_at`) VALUES
(1, 5, 10, '2012-06-04 11:42:57', '2012-06-04 11:42:57'),
(2, 6, 10, '2012-06-04 14:08:59', '2012-06-04 14:08:59'),
(3, 7, 30, '2012-06-04 14:09:23', '2012-06-04 14:09:23'),
(4, 11, 10, '2012-06-05 16:28:24', '2012-06-06 14:26:43'),
(5, 19, 10, '2012-06-15 16:59:33', '2012-06-15 16:59:33');

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
-- 表的结构 `option_detail`
--

CREATE TABLE IF NOT EXISTS `option_detail` (
  `option_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `correct_value` tinyint(4) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`option_detail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;

--
-- 转存表中的数据 `option_detail`
--

INSERT INTO `option_detail` (`option_detail_id`, `question_id`, `item_name`, `correct_value`, `create_at`, `modify_at`) VALUES
(1, 1, 'a', 0, '2012-06-02 09:17:04', '2012-06-02 09:17:04'),
(2, 1, 'b', 0, '2012-06-02 09:17:04', '2012-06-02 09:17:04'),
(3, 1, 'c', 1, '2012-06-02 09:17:04', '2012-06-02 09:17:04'),
(4, 1, 'd', 0, '2012-06-02 09:17:04', '2012-06-02 09:17:04'),
(5, 2, 'b', 0, '2012-06-02 09:17:23', '2012-06-02 09:17:23'),
(6, 2, 'b', 1, '2012-06-02 09:17:23', '2012-06-02 09:17:23'),
(7, 2, 'b', 0, '2012-06-02 09:17:23', '2012-06-02 09:17:23'),
(8, 2, 'b', 1, '2012-06-02 09:17:23', '2012-06-02 09:17:23'),
(9, 2, 'b', 0, '2012-06-02 09:17:23', '2012-06-02 09:17:23'),
(10, 2, 'b', 1, '2012-06-02 09:17:23', '2012-06-02 09:17:23'),
(11, 2, 'b', 0, '2012-06-02 09:17:23', '2012-06-02 09:17:23'),
(12, 3, 'c', 0, '2012-06-03 21:04:57', '2012-06-03 21:04:57'),
(13, 3, 'c', 1, '2012-06-03 21:04:57', '2012-06-03 21:04:57'),
(14, 3, 'c', 0, '2012-06-03 21:04:57', '2012-06-03 21:04:57'),
(15, 3, 'c', 1, '2012-06-03 21:04:57', '2012-06-03 21:04:57'),
(16, 3, 'c', 0, '2012-06-03 21:04:57', '2012-06-03 21:04:57'),
(17, 4, 'd', 0, '2012-06-03 21:10:36', '2012-06-03 21:10:36'),
(18, 4, 'd', 0, '2012-06-03 21:10:36', '2012-06-03 21:10:36'),
(19, 4, 'd', 1, '2012-06-03 21:10:36', '2012-06-03 21:10:36'),
(20, 4, 'd', 0, '2012-06-03 21:10:36', '2012-06-03 21:10:36'),
(21, 8, 'h', 0, '2012-06-04 16:50:31', '2012-06-04 16:50:31'),
(22, 8, 'h', 0, '2012-06-04 16:50:31', '2012-06-04 16:50:31'),
(23, 8, 'h', 1, '2012-06-04 16:50:31', '2012-06-04 16:50:31'),
(24, 8, 'h', 0, '2012-06-04 16:50:31', '2012-06-04 16:50:31'),
(25, 9, 'a', 0, '2012-06-05 11:25:45', '2012-06-05 11:25:45'),
(26, 9, 'a', 0, '2012-06-05 11:25:45', '2012-06-05 11:25:45'),
(27, 9, 'a', 1, '2012-06-05 11:25:45', '2012-06-05 11:25:45'),
(28, 9, 'a', 0, '2012-06-05 11:25:45', '2012-06-05 11:25:45'),
(55, 10, 'v-edit24', 1, '2012-06-15 10:55:14', '2012-06-15 10:55:14'),
(56, 10, 'v-edit1', 0, '2012-06-15 10:55:14', '2012-06-15 10:55:14'),
(57, 12, 'a', 0, '2012-06-15 11:22:15', '2012-06-15 11:22:15'),
(58, 12, 'b', 1, '2012-06-15 11:22:15', '2012-06-15 11:22:15'),
(59, 12, 'c', 0, '2012-06-15 11:22:15', '2012-06-15 11:22:15'),
(60, 12, 'd', 0, '2012-06-15 11:22:15', '2012-06-15 11:22:15'),
(61, 13, 'g', 1, '2012-06-15 11:22:27', '2012-06-15 11:22:27'),
(62, 13, 'h', 0, '2012-06-15 11:22:27', '2012-06-15 11:22:27'),
(63, 13, 'j', 0, '2012-06-15 11:22:27', '2012-06-15 11:22:27'),
(64, 13, 'k', 0, '2012-06-15 11:22:27', '2012-06-15 11:22:27'),
(65, 14, 'd', 1, '2012-06-15 11:22:39', '2012-06-15 11:22:39'),
(66, 14, 'u', 0, '2012-06-15 11:22:39', '2012-06-15 11:22:39'),
(67, 14, 'k', 0, '2012-06-15 11:22:39', '2012-06-15 11:22:39'),
(68, 14, 'i', 0, '2012-06-15 11:22:39', '2012-06-15 11:22:39'),
(69, 15, 'p', 0, '2012-06-15 11:22:51', '2012-06-15 11:22:51'),
(70, 15, 'p', 1, '2012-06-15 11:22:51', '2012-06-15 11:22:51'),
(71, 15, 'p', 0, '2012-06-15 11:22:51', '2012-06-15 11:22:51'),
(72, 15, 'p', 0, '2012-06-15 11:22:51', '2012-06-15 11:22:51'),
(73, 16, 'q', 0, '2012-06-15 11:23:01', '2012-06-15 11:23:01'),
(74, 16, 'q', 0, '2012-06-15 11:23:01', '2012-06-15 11:23:01'),
(75, 16, 'q', 1, '2012-06-15 11:23:01', '2012-06-15 11:23:01'),
(76, 16, 'q', 0, '2012-06-15 11:23:01', '2012-06-15 11:23:01'),
(77, 17, 'w', 0, '2012-06-15 11:23:09', '2012-06-15 11:23:09'),
(78, 17, 'w', 0, '2012-06-15 11:23:09', '2012-06-15 11:23:09'),
(79, 17, 'w', 1, '2012-06-15 11:23:09', '2012-06-15 11:23:09'),
(80, 17, 'w', 0, '2012-06-15 11:23:09', '2012-06-15 11:23:09'),
(81, 18, 'z', 0, '2012-06-15 16:59:24', '2012-06-15 16:59:24'),
(82, 18, 'z', 1, '2012-06-15 16:59:24', '2012-06-15 16:59:24'),
(83, 18, 'z', 1, '2012-06-15 16:59:24', '2012-06-15 16:59:24'),
(84, 18, 'z', 0, '2012-06-15 16:59:24', '2012-06-15 16:59:24');

-- --------------------------------------------------------

--
-- 表的结构 `paper_question`
--

CREATE TABLE IF NOT EXISTS `paper_question` (
  `paper_question_id` int(11) NOT NULL AUTO_INCREMENT,
  `paper_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `question_seq` smallint(6) NOT NULL,
  `question_score` tinyint(4) NOT NULL DEFAULT '0',
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`paper_question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `paper_question`
--

INSERT INTO `paper_question` (`paper_question_id`, `paper_id`, `question_id`, `question_seq`, `question_score`, `create_at`, `modify_at`) VALUES
(1, 1, 10, 1, 0, '2012-06-05 13:58:52', '2012-06-05 13:58:52'),
(2, 1, 11, 2, 0, '2012-06-05 16:28:24', '2012-06-05 16:28:24'),
(3, 1, 12, 3, 0, '2012-06-15 11:22:15', '2012-06-15 11:22:15'),
(4, 1, 13, 4, 5, '2012-06-15 11:22:27', '2012-06-15 16:42:36'),
(5, 1, 14, 5, 6, '2012-06-15 11:22:39', '2012-06-15 16:42:46'),
(6, 1, 15, 6, 0, '2012-06-15 11:22:51', '2012-06-15 11:22:51'),
(7, 1, 16, 7, 0, '2012-06-15 11:23:01', '2012-06-15 11:23:01'),
(8, 1, 17, 8, 0, '2012-06-15 11:23:09', '2012-06-15 11:23:09'),
(9, 1, 18, 9, 0, '2012-06-15 16:59:24', '2012-06-15 16:59:24'),
(10, 1, 19, 10, 0, '2012-06-15 16:59:33', '2012-06-15 16:59:33');

-- --------------------------------------------------------

--
-- 表的结构 `question_head`
--

CREATE TABLE IF NOT EXISTS `question_head` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_name` varchar(400) NOT NULL,
  `question_type` varchar(20) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `question_head`
--

INSERT INTO `question_head` (`question_id`, `question_name`, `question_type`, `create_at`, `modify_at`) VALUES
(1, 'a', 'radio', '2012-06-02 09:17:04', '2012-06-02 09:17:04'),
(2, 'b', 'checkbox', '2012-06-02 09:17:23', '2012-06-02 09:17:23'),
(3, 'ccc', 'checkbox', '2012-06-03 21:04:57', '2012-06-03 21:04:57'),
(4, 'ddd', 'radio', '2012-06-03 21:10:36', '2012-06-03 21:10:36'),
(5, 'eee', 'textarea', '2012-06-04 11:42:57', '2012-06-04 11:42:57'),
(6, 'fff', 'textarea', '2012-06-04 14:08:59', '2012-06-04 14:08:59'),
(7, 'ggg', 'textarea', '2012-06-04 14:09:23', '2012-06-04 14:09:23'),
(8, 'hhh', 'radio', '2012-06-04 16:50:31', '2012-06-04 16:50:31'),
(9, 'aaa', 'radio', '2012-06-05 11:25:44', '2012-06-05 11:25:44'),
(10, 'vvv-edit1-edit2-edit3', 'radio', '2012-06-05 13:58:51', '2012-06-06 14:35:34'),
(11, 'sdf;lsdjflsdjflkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk-edit1-edit2', 'textarea', '2012-06-05 16:28:24', '2012-06-06 14:45:07'),
(12, 'sdfsdalf;jsdal;fjsdal', 'radio', '2012-06-15 11:22:15', '2012-06-15 11:22:15'),
(13, 'sdfsdfsdalkfjslda', 'radio', '2012-06-15 11:22:27', '2012-06-15 11:22:27'),
(14, 'sdfsdafasdfsadfasd', 'radio', '2012-06-15 11:22:39', '2012-06-15 11:22:39'),
(15, 'reyt', 'radio', '2012-06-15 11:22:51', '2012-06-15 11:22:51'),
(16, 'p', 'radio', '2012-06-15 11:23:01', '2012-06-15 11:23:01'),
(17, 'w', 'radio', '2012-06-15 11:23:09', '2012-06-15 11:23:09'),
(18, 'z', 'checkbox', '2012-06-15 16:59:24', '2012-06-15 16:59:24'),
(19, 'y', 'textarea', '2012-06-15 16:59:33', '2012-06-15 16:59:33');
