-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2016-01-05 18:27:19
-- 伺服器版本: 5.6.26
-- PHP 版本： 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `kitchen`
--

-- --------------------------------------------------------

--
-- 資料表結構 `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `Id` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Password` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Exp` bigint(255) NOT NULL DEFAULT '0',
  `Money` bigint(255) NOT NULL DEFAULT '5000',
  `Sex` varchar(1) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Level` int(101) NOT NULL DEFAULT '1',
  `Oven_num` int(100) NOT NULL DEFAULT '1',
  `Package` int(255) NOT NULL DEFAULT '10',
  `Name` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `filename` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `filetype` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `filepic` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 資料表的匯出資料 `account`
--

INSERT INTO `account` (`Id`, `Password`, `Exp`, `Money`, `Sex`, `Level`, `Oven_num`, `Package`, `Name`, `filename`, `filetype`, `filepic`) VALUES
('user1', '5d0a6a3c8ec4f416e6e0add43ef8ca23', 19, 9200, 'm', 3, 4, 10, '使用者1', '', '', ''),
('user2', '5d0a6a3c8ec4f416e6e0add43ef8ca23', 0, 2000, 'm', 1, 4, 19, '我咖厲害', '', '', '');

-- --------------------------------------------------------

--
-- 資料表結構 `bread`
--

CREATE TABLE IF NOT EXISTS `bread` (
  `Name` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Count` int(50) NOT NULL,
  `Cost_time` int(255) NOT NULL,
  `Exp` int(255) NOT NULL,
  `Price` int(255) NOT NULL,
  `Level` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 資料表的匯出資料 `bread`
--

INSERT INTO `bread` (`Name`, `Count`, `Cost_time`, `Exp`, `Price`, `Level`) VALUES
('Croissant', 2, 150, 3, 800, 1),
('Donut', 10, 500, 10, 1800, 4),
('Marfin', 5, 300, 6, 1200, 2),
('Toast', 1, 90, 1, 400, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `level`
--

CREATE TABLE IF NOT EXISTS `level` (
  `Lev` int(11) NOT NULL,
  `Exp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 資料表的匯出資料 `level`
--

INSERT INTO `level` (`Lev`, `Exp`) VALUES
(2, 10),
(3, 15),
(4, 25),
(5, 36),
(6, 48),
(7, 60),
(8, 72),
(9, 85),
(10, 100),
(11, 118),
(12, 135),
(14, 155),
(15, 180);

-- --------------------------------------------------------

--
-- 資料表結構 `oven`
--

CREATE TABLE IF NOT EXISTS `oven` (
  `No` int(255) NOT NULL,
  `Time` timestamp NULL DEFAULT NULL,
  `Now_id` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `State` int(11) NOT NULL DEFAULT '0',
  `Owner` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 資料表的匯出資料 `oven`
--

INSERT INTO `oven` (`No`, `Time`, `Now_id`, `State`, `Owner`) VALUES
(1, NULL, NULL, 0, 'user2'),
(2, NULL, NULL, 0, 'user2'),
(3, NULL, NULL, 0, 'user2'),
(4, NULL, NULL, 0, 'user2'),
(5, NULL, NULL, 0, 'user1'),
(6, NULL, NULL, 0, 'user1'),
(7, NULL, NULL, 0, 'user1'),
(8, NULL, 'Croissant', 2, '102213015'),
(9, NULL, 'Toast', 2, '102213015'),
(10, NULL, 'Toast', 2, '102213015'),
(11, NULL, 'Toast', 2, '102213015'),
(12, NULL, 'Toast', 2, '102213015'),
(13, NULL, 'Croissant', 2, '102213015'),
(14, NULL, NULL, 0, '123456');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`Id`);

--
-- 資料表索引 `bread`
--
ALTER TABLE `bread`
  ADD PRIMARY KEY (`Name`);

--
-- 資料表索引 `oven`
--
ALTER TABLE `oven`
  ADD PRIMARY KEY (`No`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `oven`
--
ALTER TABLE `oven`
  MODIFY `No` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
