-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2016 年 01 月 03 日 13:56
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
-- 資料表結構 `Account`
--

CREATE TABLE IF NOT EXISTS `Account` (
  `Id` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Password` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Exp` bigint(255) NOT NULL DEFAULT '0',
  `Money` bigint(255) NOT NULL DEFAULT '5000',
  `Sex` varchar(1) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Level` int(101) NOT NULL DEFAULT '1',
  `Oven_num` int(100) NOT NULL DEFAULT '1',
  `Package` int(255) NOT NULL DEFAULT '10',
  `Name` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 資料表的匯出資料 `Account`
--

INSERT INTO `Account` (`Id`, `Password`, `Exp`, `Money`, `Sex`, `Level`, `Oven_num`, `Package`, `Name`) VALUES
('user1', '5d0a6a3c8ec4f416e6e0add43ef8ca23', 19, 9200, 'm', 3, 4, 10, '使用者1'),
('user2', '5d0a6a3c8ec4f416e6e0add43ef8ca23', 0, 2000, 'm', 1, 4, 19, '我咖厲害');

-- --------------------------------------------------------

--
-- 資料表結構 `Bread`
--

CREATE TABLE IF NOT EXISTS `Bread` (
  `Name` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Count` int(50) NOT NULL,
  `Cost_time` int(255) NOT NULL,
  `Exp` int(255) NOT NULL,
  `Price` int(255) NOT NULL,
  `Level` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 資料表的匯出資料 `Bread`
--

INSERT INTO `Bread` (`Name`, `Count`, `Cost_time`, `Exp`, `Price`, `Level`) VALUES
('Croissant', 2, 150, 3, 800, 1),
('Donut', 10, 500, 10, 1800, 4),
('Marfin', 5, 300, 6, 1200, 2),
('Toast', 1, 90, 1, 400, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `Level`
--

CREATE TABLE IF NOT EXISTS `Level` (
  `Lev` int(11) NOT NULL,
  `Exp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 資料表的匯出資料 `Level`
--

INSERT INTO `Level` (`Lev`, `Exp`) VALUES
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
-- 資料表結構 `Oven`
--

CREATE TABLE IF NOT EXISTS `Oven` (
  `No` int(255) NOT NULL,
  `Time` timestamp NULL DEFAULT NULL,
  `Now_id` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `State` int(11) NOT NULL DEFAULT '0',
  `Owner` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 資料表的匯出資料 `Oven`
--

INSERT INTO `Oven` (`No`, `Time`, `Now_id`, `State`, `Owner`) VALUES
(1, NULL, NULL, 0, 'user2'),
(2, NULL, NULL, 0, 'user2'),
(3, NULL, NULL, 0, 'user2'),
(4, NULL, NULL, 0, 'user2'),
(5, NULL, NULL, 0, 'user1'),
(6, NULL, NULL, 0, 'user1'),
(7, NULL, NULL, 0, 'user1');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `Account`
--
ALTER TABLE `Account`
  ADD PRIMARY KEY (`Id`);

--
-- 資料表索引 `Bread`
--
ALTER TABLE `Bread`
  ADD PRIMARY KEY (`Name`);

--
-- 資料表索引 `Oven`
--
ALTER TABLE `Oven`
  ADD PRIMARY KEY (`No`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `Oven`
--
ALTER TABLE `Oven`
  MODIFY `No` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
