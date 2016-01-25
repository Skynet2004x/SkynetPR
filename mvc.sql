-- phpMyAdmin SQL Dump
-- version 4.4.11
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Янв 25 2016 г., 09:56
-- Версия сервера: 5.5.44-log
-- Версия PHP: 5.4.41

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mvc`
--

-- --------------------------------------------------------

--
-- Структура таблицы `byers`
--

CREATE TABLE IF NOT EXISTS `byers` (
  `id` int(11) unsigned NOT NULL,
  `goods_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=394 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `byers`
--

INSERT INTO `byers` (`id`, `goods_id`, `user_id`, `date_time`) VALUES
(391, 66, 12, '2016-01-22 18:18:12'),
(390, 66, 12, '2016-01-22 18:18:10'),
(389, 66, 13, '2016-01-22 18:17:57'),
(392, 68, 12, '2016-01-23 10:53:10'),
(393, 68, 12, '2016-01-23 10:55:23');

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) unsigned NOT NULL,
  `goods_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`id`, `goods_id`, `user_id`) VALUES
(1, 68, 12);

-- --------------------------------------------------------

--
-- Структура таблицы `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) unsigned NOT NULL,
  `adsperpage` smallint(5) NOT NULL,
  `site_name` varchar(100) NOT NULL,
  `sendemail` smallint(1) DEFAULT '0',
  `default_route` varchar(45) DEFAULT NULL,
  `default_languages` varchar(45) DEFAULT NULL,
  `default_controller` varchar(45) DEFAULT NULL,
  `default_action` varchar(45) DEFAULT NULL,
  `default_num_foto` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `config`
--

INSERT INTO `config` (`id`, `adsperpage`, `site_name`, `sendemail`, `default_route`, `default_languages`, `default_controller`, `default_action`, `default_num_foto`) VALUES
(0, 5, 'ÐÑƒÐºÑ†Ð¸Ð¾Ð½', 0, 'default', 'ua', 'mainlist', 'index', '3');

-- --------------------------------------------------------

--
-- Структура таблицы `curent_buyer`
--

CREATE TABLE IF NOT EXISTS `curent_buyer` (
  `id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `goods_id` int(11) unsigned NOT NULL,
  `set_price` float NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `winer` tinyint(1) unsigned DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `curent_buyer`
--

INSERT INTO `curent_buyer` (`id`, `user_id`, `goods_id`, `set_price`, `date_time`, `winer`) VALUES
(1, 12, 68, 3900, '2016-01-23 10:53:10', 0),
(2, 12, 68, 1500000, '2016-01-23 10:55:23', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE IF NOT EXISTS `goods` (
  `id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `cur_price` float NOT NULL DEFAULT '0',
  `decs` text NOT NULL,
  `start_time` datetime NOT NULL,
  `num_days` smallint(6) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `step_price` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `user_id`, `name`, `price`, `cur_price`, `decs`, `start_time`, `num_days`, `active`, `step_price`) VALUES
(66, 1, 'Ð°Ð²Ñ‚Ð¾ 2', 1800000, 0, 'Ð²Ñ‹Ð°Ñ‹Ð¿Ñ‹Ñ€Ð²Ð°Ð¾Ð°Ñ€Ð¾Ð°Ñ€Ð¾Ð°Ð¿Ð»Ð¾Ð»\r\nÐ¿Ñ€Ð¾Ð»Ð¿Ñ€Ð»Ñ€Ð»Ð´Ñ€Ð´Ð¾Ð»Ð´Ñ€Ð¾Ð¿Ð°Ð¾Ð»\r\nÐ¿Ñ€Ð»Ð¿Ñ€Ð»Ð¿Ð»Ð°Ð»Ð°Ð¿Ñ€Ð¾', '2015-12-23 00:00:00', 0, 0, 1220),
(67, 1, 'Ð°Ð²Ñ‚Ð¾ 3', 1500000, 1000, 'Ð²Ñ‹Ð°Ð°Ð¿Ð¿Ð°Ð¾Ñ€Ð¿Ð´Ð»Ð¾Ñ‰ÑˆÐ³Ñ‰ÑˆÐ³ÐµÐ½Ð³ÑˆÐ³\r\nÑˆÑ‰Ð½ÑˆÑ‰ÐµÑˆÐºÐµÐ³Ð½ÐµÐºÐ½Ð³ÐºÐ³\r\nÐºÐ½Ð³ÐºÐ³ÑˆÐº', '2015-12-22 00:00:00', 45, 1, 1500),
(68, 13, 'Ð°Ð²Ñ‚Ð¾ 1', 1500000, 1500000, 'Ð¼ÑÑ‡Ð¸Ð¼Ð¸Ñ‚Ñ‚Ð¸ÑŒÑ€Ð¾Ð»Ð°Ð¿Ñ€Ð¾Ð²Ð¾ÐµÐ½\r\nÐ¾Ð³Ð°Ð¾Ð¿Ñ€Ñ€Ð¾Ð»Ð¸ÑŒÑ‚ÑŒÑÐ¼Ñ‚Ð¿Ñ€Ð¾\r\nÐ¸ÑŒÑÐ¼ÑŒÑÐ¾Ð¿Ñ€Ð¾Ð¿Ñ€Ñ€Ñ‚ÑŒ\r\n', '2015-12-21 00:00:00', 50, 0, 1200),
(69, 13, 'Ð°Ð²Ñ‚Ð¾ 4', 2000000, 35000, 'Ð²Ð°Ð¿Ð²Ð°Ð¿Ð´Ñ‹Ð¾Ð¿Ñ€Ð»Ð¾Ð²Ñ‹Ñ€Ð¿Ð¾Ñ€Ð²Ñ‹Ð¾Ð¿Ñ€ÑƒÐºÐµÑƒÐºÐµÐ¿Ð¶Ð¿Ñ€Ð»Ð´Ð¾Ð¿Ñ€Ð»Ð´Ð¾Ð²Ð¿Ñ€Ð»Ð¾Ð´Ð²Ð°Ñ€Ð¿Ð²Ð°Ð¾Ð¿\r\nÐ²Ð°Ñ€Ð¿Ð°Ð¾\r\nÐ¿Ñ€Ð¾Ð°Ð´Ð»Ð°ÑŒÑ€Ð´Ð²Ð»Ð¾Ð¶Ð´Ñ€Ð»Ð¾Ñ€Ð°Ð¾Ð²Ð°Ð»Ð¾Ñ€Ð²Ð°Ð¿Ñ‰Ñ€', '2015-12-22 00:00:00', 65, 1, 5000),
(70, 13, 'dsjfhksjfhkj', 1500, 0, 'ÑÐ»Ð¸ ÑƒÐºÐ°Ð·Ð°Ð½ Ð½ÐµÐ¾Ð±ÑÐ·Ð°Ñ‚ÐµÐ»ÑŒÐ½Ñ‹Ð¹ Ð°Ñ€Ð³ÑƒÐ¼ÐµÐ½Ñ‚ split_length, Ð²Ð¾Ð·Ð²Ñ€Ð°Ñ‰Ð°ÐµÐ¼Ñ‹Ð¹ Ð¼Ð°ÑÑÐ¸Ð² Ð±ÑƒÐ´ÐµÑ‚ ÑÐ¾Ð´ÐµÑ€Ð¶Ð°Ñ‚ÑŒ Ñ‡Ð°ÑÑ‚Ð¸ Ð¸ÑÑ…Ð¾Ð´Ð½Ð¾Ð¹ ÑÑ‚Ñ€Ð¾ÐºÐ¸ Ð´Ð»Ð¸Ð½Ð¾Ð¹ split_length ÐºÐ°Ð¶Ð´Ð°Ñ, Ð¸Ð½Ð°Ñ‡Ðµ ÐºÐ°Ð¶Ð´Ñ‹Ð¹ ÑÐ»ÐµÐ¼ÐµÐ½Ñ‚ Ð±ÑƒÐ´ÐµÑ‚ ÑÐ¾Ð´ÐµÑ€Ð¶Ð°Ñ‚ÑŒ Ð¾Ð´Ð¸Ð½ ÑÐ¸Ð¼Ð²Ð¾Ð».\r\n\r\nÐ•ÑÐ»Ð¸ split_length Ð¼ÐµÐ½ÑŒÑˆÐµ 1, Ð²Ð¾Ð·Ð²Ñ€Ð°Ñ‰Ð°ÐµÑ‚ÑÑ FALSE. Ð•ÑÐ»Ð¸ split_length Ð±Ð¾Ð»ÑŒÑˆÐµ Ð´Ð»Ð¸Ð½Ñ‹ ÑÑ‚Ñ€Ð¾ÐºÐ¸ string, Ñ‚Ð¾ Ð²ÑÑ ÑÑ‚Ñ€Ð¾ÐºÐ° Ð±ÑƒÐ´ÐµÑ‚ Ð²Ð¾Ð·Ð²Ñ€Ð°Ñ‰ÐµÐ½Ð° Ð² Ð¿ÐµÑ€Ð²Ð¾Ð¼ Ð¸ ÐµÐ´Ð¸Ð½ÑÑ‚Ð²ÐµÐ½Ð½Ð¾Ð¼ ÑÐ»ÐµÐ¼ÐµÐ½Ñ‚Ðµ Ð¼Ð°ÑÑÐ¸Ð²Ð°.', '2016-01-25 00:00:00', 15, 1, 10),
(71, 13, 'Ñ‚Ð¾Ð²Ð°Ñ€', 1500, 1500, 'Definition and Usage\r\nThe clearInterval() method clears a timer set with the setInterval() method.\r\n\r\nThe ID value returned by setInterval() is used as the parameter for the clearInterval() method.\r\n\r\nNote: To be able to use the clearInterval() method, you must use a global variable when creating the interval method:', '2016-01-22 00:00:00', 50, 1, 100),
(74, 13, 'Ñ‚Ð¾Ð²Ð°Ñ€ 2', 15000, 0, 'ÐžÐ¿ÐµÑ€Ð°Ñ‚Ð¾Ñ€ INSERT Ð²ÑÑ‚Ð°Ð²Ð»ÑÐµÑ‚ Ð½Ð¾Ð²Ñ‹Ðµ ÑÑ‚Ñ€Ð¾ÐºÐ¸ Ð² ÑÑƒÑ‰ÐµÑÑ‚Ð²ÑƒÑŽÑ‰ÑƒÑŽ Ñ‚Ð°Ð±Ð»Ð¸Ñ†Ñƒ. Ð¤Ð¾Ñ€Ð¼Ð° Ð´Ð°Ð½Ð½Ð¾Ð¹ ÐºÐ¾Ð¼Ð°Ð½Ð´Ñ‹ INSERT ... VALUES Ð²ÑÑ‚Ð°Ð²Ð»ÑÐµÑ‚ ÑÑ‚Ñ€Ð¾ÐºÐ¸ Ð² ÑÐ¾Ð¾Ñ‚Ð²ÐµÑ‚ÑÑ‚Ð²Ð¸Ð¸ Ñ Ñ‚Ð¾Ñ‡Ð½Ð¾ ÑƒÐºÐ°Ð·Ð°Ð½Ð½Ñ‹Ð¼Ð¸ Ð² ÐºÐ¾Ð¼Ð°Ð½Ð´Ðµ Ð·Ð½Ð°Ñ‡ÐµÐ½Ð¸ÑÐ¼Ð¸. Ð¤Ð¾Ñ€Ð¼Ð° INSERT ... SELECT Ð²ÑÑ‚Ð°Ð²Ð»ÑÐµÑ‚ ÑÑ‚Ñ€Ð¾ÐºÐ¸, Ð²Ñ‹Ð±Ñ€Ð°Ð½Ð½Ñ‹Ðµ Ð¸Ð· Ð´Ñ€ÑƒÐ³Ð¾Ð¹ Ñ‚Ð°Ð±Ð»Ð¸Ñ†Ñ‹ Ð¸Ð»Ð¸ Ñ‚Ð°Ð±Ð»Ð¸Ñ†. Ð¤Ð¾Ñ€Ð¼Ð° INSERT ... VALUES ÑÐ¾ ÑÐ¿Ð¸ÑÐºÐ¾Ð¼ Ð¸Ð· Ð½ÐµÑÐºÐ¾Ð»ÑŒÐºÐ¸Ñ… Ð·Ð½Ð°Ñ‡ÐµÐ½Ð¸Ð¹ Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶Ð¸Ð²Ð°ÐµÑ‚ÑÑ Ð² Ð²ÐµÑ€ÑÐ¸Ð¸ MySQL 3.22.5 Ð¸ Ð±Ð¾Ð»ÐµÐµ Ð¿Ð¾Ð·Ð´Ð½Ð¸Ñ…. Ð¡Ð¸Ð½Ñ‚Ð°ÐºÑÐ¸Ñ Ð²Ñ‹Ñ€Ð°Ð¶ÐµÐ½Ð¸Ñ col_name=expression Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶Ð¸Ð²Ð°ÐµÑ‚ÑÑ Ð² Ð²ÐµÑ€ÑÐ¸Ð¸ MySQL 3.22.10 Ð¸ Ð±Ð¾Ð»ÐµÐµ Ð¿Ð¾Ð·Ð´Ð½Ð¸Ñ….', '2016-01-22 00:00:00', 45, 1, 500),
(75, 13, 'Ñ‚Ð¾Ð²Ð°Ñ€ 2', 15000, 0, 'ÐžÐ¿ÐµÑ€Ð°Ñ‚Ð¾Ñ€ INSERT Ð²ÑÑ‚Ð°Ð²Ð»ÑÐµÑ‚ Ð½Ð¾Ð²Ñ‹Ðµ ÑÑ‚Ñ€Ð¾ÐºÐ¸ Ð² ÑÑƒÑ‰ÐµÑÑ‚Ð²ÑƒÑŽÑ‰ÑƒÑŽ Ñ‚Ð°Ð±Ð»Ð¸Ñ†Ñƒ. Ð¤Ð¾Ñ€Ð¼Ð° Ð´Ð°Ð½Ð½Ð¾Ð¹ ÐºÐ¾Ð¼Ð°Ð½Ð´Ñ‹ INSERT ... VALUES Ð²ÑÑ‚Ð°Ð²Ð»ÑÐµÑ‚ ÑÑ‚Ñ€Ð¾ÐºÐ¸ Ð² ÑÐ¾Ð¾Ñ‚Ð²ÐµÑ‚ÑÑ‚Ð²Ð¸Ð¸ Ñ Ñ‚Ð¾Ñ‡Ð½Ð¾ ÑƒÐºÐ°Ð·Ð°Ð½Ð½Ñ‹Ð¼Ð¸ Ð² ÐºÐ¾Ð¼Ð°Ð½Ð´Ðµ Ð·Ð½Ð°Ñ‡ÐµÐ½Ð¸ÑÐ¼Ð¸. Ð¤Ð¾Ñ€Ð¼Ð° INSERT ... SELECT Ð²ÑÑ‚Ð°Ð²Ð»ÑÐµÑ‚ ÑÑ‚Ñ€Ð¾ÐºÐ¸, Ð²Ñ‹Ð±Ñ€Ð°Ð½Ð½Ñ‹Ðµ Ð¸Ð· Ð´Ñ€ÑƒÐ³Ð¾Ð¹ Ñ‚Ð°Ð±Ð»Ð¸Ñ†Ñ‹ Ð¸Ð»Ð¸ Ñ‚Ð°Ð±Ð»Ð¸Ñ†. Ð¤Ð¾Ñ€Ð¼Ð° INSERT ... VALUES ÑÐ¾ ÑÐ¿Ð¸ÑÐºÐ¾Ð¼ Ð¸Ð· Ð½ÐµÑÐºÐ¾Ð»ÑŒÐºÐ¸Ñ… Ð·Ð½Ð°Ñ‡ÐµÐ½Ð¸Ð¹ Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶Ð¸Ð²Ð°ÐµÑ‚ÑÑ Ð² Ð²ÐµÑ€ÑÐ¸Ð¸ MySQL 3.22.5 Ð¸ Ð±Ð¾Ð»ÐµÐµ Ð¿Ð¾Ð·Ð´Ð½Ð¸Ñ…. Ð¡Ð¸Ð½Ñ‚Ð°ÐºÑÐ¸Ñ Ð²Ñ‹Ñ€Ð°Ð¶ÐµÐ½Ð¸Ñ col_name=expression Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶Ð¸Ð²Ð°ÐµÑ‚ÑÑ Ð² Ð²ÐµÑ€ÑÐ¸Ð¸ MySQL 3.22.10 Ð¸ Ð±Ð¾Ð»ÐµÐµ Ð¿Ð¾Ð·Ð´Ð½Ð¸Ñ….', '2016-01-22 00:00:00', 45, 1, 500),
(76, 13, 'Ñ‚Ð¾Ð²Ð°Ñ€ 2', 15000, 0, 'ÐžÐ¿ÐµÑ€Ð°Ñ‚Ð¾Ñ€ INSERT Ð²ÑÑ‚Ð°Ð²Ð»ÑÐµÑ‚ Ð½Ð¾Ð²Ñ‹Ðµ ÑÑ‚Ñ€Ð¾ÐºÐ¸ Ð² ÑÑƒÑ‰ÐµÑÑ‚Ð²ÑƒÑŽÑ‰ÑƒÑŽ Ñ‚Ð°Ð±Ð»Ð¸Ñ†Ñƒ. Ð¤Ð¾Ñ€Ð¼Ð° Ð´Ð°Ð½Ð½Ð¾Ð¹ ÐºÐ¾Ð¼Ð°Ð½Ð´Ñ‹ INSERT ... VALUES Ð²ÑÑ‚Ð°Ð²Ð»ÑÐµÑ‚ ÑÑ‚Ñ€Ð¾ÐºÐ¸ Ð² ÑÐ¾Ð¾Ñ‚Ð²ÐµÑ‚ÑÑ‚Ð²Ð¸Ð¸ Ñ Ñ‚Ð¾Ñ‡Ð½Ð¾ ÑƒÐºÐ°Ð·Ð°Ð½Ð½Ñ‹Ð¼Ð¸ Ð² ÐºÐ¾Ð¼Ð°Ð½Ð´Ðµ Ð·Ð½Ð°Ñ‡ÐµÐ½Ð¸ÑÐ¼Ð¸. Ð¤Ð¾Ñ€Ð¼Ð° INSERT ... SELECT Ð²ÑÑ‚Ð°Ð²Ð»ÑÐµÑ‚ ÑÑ‚Ñ€Ð¾ÐºÐ¸, Ð²Ñ‹Ð±Ñ€Ð°Ð½Ð½Ñ‹Ðµ Ð¸Ð· Ð´Ñ€ÑƒÐ³Ð¾Ð¹ Ñ‚Ð°Ð±Ð»Ð¸Ñ†Ñ‹ Ð¸Ð»Ð¸ Ñ‚Ð°Ð±Ð»Ð¸Ñ†. Ð¤Ð¾Ñ€Ð¼Ð° INSERT ... VALUES ÑÐ¾ ÑÐ¿Ð¸ÑÐºÐ¾Ð¼ Ð¸Ð· Ð½ÐµÑÐºÐ¾Ð»ÑŒÐºÐ¸Ñ… Ð·Ð½Ð°Ñ‡ÐµÐ½Ð¸Ð¹ Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶Ð¸Ð²Ð°ÐµÑ‚ÑÑ Ð² Ð²ÐµÑ€ÑÐ¸Ð¸ MySQL 3.22.5 Ð¸ Ð±Ð¾Ð»ÐµÐµ Ð¿Ð¾Ð·Ð´Ð½Ð¸Ñ…. Ð¡Ð¸Ð½Ñ‚Ð°ÐºÑÐ¸Ñ Ð²Ñ‹Ñ€Ð°Ð¶ÐµÐ½Ð¸Ñ col_name=expression Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶Ð¸Ð²Ð°ÐµÑ‚ÑÑ Ð² Ð²ÐµÑ€ÑÐ¸Ð¸ MySQL 3.22.10 Ð¸ Ð±Ð¾Ð»ÐµÐµ Ð¿Ð¾Ð·Ð´Ð½Ð¸Ñ….', '2016-01-22 00:00:00', 45, 1, 500),
(77, 13, 'Ñ‚Ð¾Ð²Ð°Ñ€ 2', 15000, 0, 'ÐžÐ¿ÐµÑ€Ð°Ñ‚Ð¾Ñ€ INSERT Ð²ÑÑ‚Ð°Ð²Ð»ÑÐµÑ‚ Ð½Ð¾Ð²Ñ‹Ðµ ÑÑ‚Ñ€Ð¾ÐºÐ¸ Ð² ÑÑƒÑ‰ÐµÑÑ‚Ð²ÑƒÑŽÑ‰ÑƒÑŽ Ñ‚Ð°Ð±Ð»Ð¸Ñ†Ñƒ. Ð¤Ð¾Ñ€Ð¼Ð° Ð´Ð°Ð½Ð½Ð¾Ð¹ ÐºÐ¾Ð¼Ð°Ð½Ð´Ñ‹ INSERT ... VALUES Ð²ÑÑ‚Ð°Ð²Ð»ÑÐµÑ‚ ÑÑ‚Ñ€Ð¾ÐºÐ¸ Ð² ÑÐ¾Ð¾Ñ‚Ð²ÐµÑ‚ÑÑ‚Ð²Ð¸Ð¸ Ñ Ñ‚Ð¾Ñ‡Ð½Ð¾ ÑƒÐºÐ°Ð·Ð°Ð½Ð½Ñ‹Ð¼Ð¸ Ð² ÐºÐ¾Ð¼Ð°Ð½Ð´Ðµ Ð·Ð½Ð°Ñ‡ÐµÐ½Ð¸ÑÐ¼Ð¸. Ð¤Ð¾Ñ€Ð¼Ð° INSERT ... SELECT Ð²ÑÑ‚Ð°Ð²Ð»ÑÐµÑ‚ ÑÑ‚Ñ€Ð¾ÐºÐ¸, Ð²Ñ‹Ð±Ñ€Ð°Ð½Ð½Ñ‹Ðµ Ð¸Ð· Ð´Ñ€ÑƒÐ³Ð¾Ð¹ Ñ‚Ð°Ð±Ð»Ð¸Ñ†Ñ‹ Ð¸Ð»Ð¸ Ñ‚Ð°Ð±Ð»Ð¸Ñ†. Ð¤Ð¾Ñ€Ð¼Ð° INSERT ... VALUES ÑÐ¾ ÑÐ¿Ð¸ÑÐºÐ¾Ð¼ Ð¸Ð· Ð½ÐµÑÐºÐ¾Ð»ÑŒÐºÐ¸Ñ… Ð·Ð½Ð°Ñ‡ÐµÐ½Ð¸Ð¹ Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶Ð¸Ð²Ð°ÐµÑ‚ÑÑ Ð² Ð²ÐµÑ€ÑÐ¸Ð¸ MySQL 3.22.5 Ð¸ Ð±Ð¾Ð»ÐµÐµ Ð¿Ð¾Ð·Ð´Ð½Ð¸Ñ…. Ð¡Ð¸Ð½Ñ‚Ð°ÐºÑÐ¸Ñ Ð²Ñ‹Ñ€Ð°Ð¶ÐµÐ½Ð¸Ñ col_name=expression Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶Ð¸Ð²Ð°ÐµÑ‚ÑÑ Ð² Ð²ÐµÑ€ÑÐ¸Ð¸ MySQL 3.22.10 Ð¸ Ð±Ð¾Ð»ÐµÐµ Ð¿Ð¾Ð·Ð´Ð½Ð¸Ñ….', '2016-01-24 00:00:00', 45, 1, 500),
(79, 1, 'Ñ‚Ð¾Ð²Ð°Ñ€ 4', 150, 0, 'Ñ‹Ð²Ð»Ð¿Ð¾Ð°Ñ‹Ð²Ð¶Ð¿Ð²Ð¶ÑˆÑ€Ð¾Ð²ÑÐ¾Ñ€\r\nÑ‹Ð²Ð»Ð¿Ð¾Ð°Ñ‹Ð²Ð¶Ð¿Ð²Ð¶ÑˆÑ€Ð¾Ð²ÑÐ¾Ñ€\r\nÑ‹Ð²Ð»Ð¿Ð¾Ð°Ñ‹Ð²Ð¶Ð¿Ð²Ð¶ÑˆÑ€Ð¾Ð²ÑÐ¾Ñ€\r\nÑ‹Ð²Ð»Ð¿Ð¾Ð°Ñ‹Ð²Ð¶Ð¿Ð²Ð¶ÑˆÑ€Ð¾Ð²ÑÐ¾Ñ€\r\nÑ‹Ð²Ð»Ð¿Ð¾Ð°Ñ‹Ð²Ð¶Ð¿Ð²Ð¶ÑˆÑ€Ð¾Ð²ÑÐ¾Ñ€\r\n', '2016-01-24 00:00:00', 20, 1, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` tinyint(3) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text,
  `user_id` int(11) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`, `user_id`) VALUES
(20, 'dsfsdf', 'etr@erer.ru', 'sdfsdf', 1),
(21, 'dfhgh', 'skynet2004x@yahoo.com', 'hfghfghfgh', 1),
(22, 'retertytry', 'yuutu@etrert.ty', 'fggfhgjhjkhjkhjk', 12),
(23, 'ghgjghj', 'tutyutu@rtrt.rt', 'dgdfghfh', 0),
(24, 'dsfdfgdfg', 'dfgdfg@tr.er', 'ghftyu', 0),
(25, 'admin  ', 'admin@au.ua', 'kljhgkhjghjgfhf', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` tinyint(3) unsigned NOT NULL,
  `alias` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text,
  `is_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `alias`, `title`, `content`, `is_published`, `user_id`, `date_time`) VALUES
(11, 'aboutAvto', 'Ð¿Ñ€Ð¾ Ð¼Ð°ÑˆÐ¸Ð½Ñ‹ Ð¸ Ð¿Ñ€Ð¾Ñ‡ÑƒÑŽ Ñ…Ñ€ÐµÐ½ÑŒ', 'Ð¿Ñ€Ð¾ Ð¼Ð°ÑˆÐ¸Ð½Ñ‹ Ð¸ Ð¿Ñ€Ð¾Ñ‡ÑƒÑŽ Ñ…Ñ€ÐµÐ½ÑŒÐ¿Ñ€Ð¾ Ð¼Ð°ÑˆÐ¸Ð½Ñ‹ Ð¸ Ð¿Ñ€Ð¾Ñ‡ÑƒÑŽ Ñ…Ñ€ÐµÐ½ÑŒÐ¿Ñ€Ð¾ Ð¼Ð°ÑˆÐ¸Ð½Ñ‹ Ð¸ Ð¿Ñ€Ð¾Ñ‡ÑƒÑŽ Ñ…Ñ€ÐµÐ½ÑŒÐ¿Ñ€Ð¾ Ð¼Ð°ÑˆÐ¸Ð½Ñ‹ Ð¸ Ð¿Ñ€Ð¾Ñ‡ÑƒÑŽ Ñ…Ñ€ÐµÐ½ÑŒÐ¿Ñ€Ð¾ Ð¼Ð°ÑˆÐ¸Ð½Ñ‹ Ð¸ Ð¿Ñ€Ð¾Ñ‡ÑƒÑŽ Ñ…Ñ€ÐµÐ½ÑŒÐ¿Ñ€Ð¾ Ð¼Ð°ÑˆÐ¸Ð½Ñ‹ Ð¸ Ð¿Ñ€Ð¾Ñ‡ÑƒÑŽ Ñ…Ñ€ÐµÐ½ÑŒÐ¿Ñ€Ð¾ Ð¼Ð°ÑˆÐ¸Ð½Ñ‹ Ð¸ Ð¿Ñ€Ð¾Ñ‡ÑƒÑŽ Ñ…Ñ€ÐµÐ½ÑŒÐ¿Ñ€Ð¾ Ð¼Ð°ÑˆÐ¸Ð½Ñ‹ Ð¸ Ð¿Ñ€Ð¾Ñ‡ÑƒÑŽ Ñ…Ñ€ÐµÐ½ÑŒ', 1, 1, '2015-12-01 08:00:00'),
(2, 'tetsttwtwt', 'etrrteruytuiyouip', 'eouhdfjghjlhgfklhjh;jk;l', 1, 1, '2015-12-01 22:00:00'),
(7, 'rteryyr', 'uyutyut', 'iyuiyiuyi', 1, 1, '0000-00-00 00:00:00'),
(8, 'yryrty', 'tyuiyui', 'yertyeyrty', 1, 1, '0000-00-00 00:00:00'),
(9, 'ggdfhg', 'ytrytryery', 'eurutrurtu', 1, 12, '0000-00-00 00:00:00'),
(16, 'neochem', 'ÑÑ‚Ð°Ñ‚ÑŒÑ Ð½Ðµ Ð¾ Ñ‡ÐµÐ¼', 'bla bla bla', 1, 1, '0000-00-00 00:00:00'),
(17, 'Ð²Ñ‹Ð°Ð²Ñ‹Ð°Ð²Ñ‹Ð°', 'Ð²Ñ‹Ð°Ð²Ñ‹Ð°', 'Ñ‹Ð²Ð°Ð²Ñ‹Ð°', 1, 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `photo`
--

CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) unsigned NOT NULL,
  `goods_id` int(11) unsigned NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `photo`
--

INSERT INTO `photo` (`id`, `goods_id`, `path`) VALUES
(20, 66, '/webroot/uploads/2.png'),
(21, 67, '/webroot/uploads/3.jpg'),
(22, 68, '/webroot/uploads/1.jpg'),
(23, 69, '/webroot/uploads/2.png'),
(25, 71, '/webroot/uploads/222.PNG'),
(28, 70, '/webroot/uploads/12-1453447335.PNG'),
(29, 74, '/webroot/uploads/DSC_0030.JPG'),
(32, 79, '/webroot/uploads/1-1453492776.JPG'),
(33, 75, '/webroot/uploads/1-1453492776.JPG'),
(34, 76, '/webroot/uploads/1-1453492776.JPG');

-- --------------------------------------------------------

--
-- Структура таблицы `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `id` int(11) unsigned NOT NULL,
  `goods_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `value` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `rating`
--

INSERT INTO `rating` (`id`, `goods_id`, `user_id`, `value`) VALUES
(1, 66, 0, 3.88),
(2, 67, 0, 2.25),
(3, 69, 0, 2.5),
(4, 68, 0, 2.5);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `userrestorepass`
--

CREATE TABLE IF NOT EXISTS `userrestorepass` (
  `id` int(2) unsigned NOT NULL,
  `email` varchar(50) NOT NULL,
  `hash` varchar(100) NOT NULL,
  `timedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL,
  `login` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(45) NOT NULL DEFAULT 'admin',
  `password` char(32) NOT NULL,
  `is_active` tinyint(1) unsigned DEFAULT '1',
  `city` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `role`, `password`, `is_active`, `city`) VALUES
(1, 'admin', 'admin@ua.ua', 'admin', 'e420fe894833c5335af53a017f6e77d0', 1, 'Kyev'),
(12, 'test', 'skynet2004x@yahoo.com', 'user', 'cbf485a3d24fbcc1ca01550a60db6507', 1, 'Lvov'),
(13, 'test2', 'qwe@qw.ru', 'user', 'cd30929406197f2761c5c7f83df611b8', 1, 'lo'),
(21, 'bob', 'bob@ta.ua', 'user', 'cd30929406197f2761c5c7f83df611b8', 1, 'Kr'),
(16, 'igor', 'admin@autorshop.com.ua', 'user', 'cbf485a3d24fbcc1ca01550a60db6507', 1, 'Al');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `byers`
--
ALTER TABLE `byers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `curent_buyer`
--
ALTER TABLE `curent_buyer`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `id_2` (`id`);

--
-- Индексы таблицы `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `userrestorepass`
--
ALTER TABLE `userrestorepass`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `byers`
--
ALTER TABLE `byers`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=394;
--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `curent_buyer`
--
ALTER TABLE `curent_buyer`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT для таблицы `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT для таблицы `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `userrestorepass`
--
ALTER TABLE `userrestorepass`
  MODIFY `id` int(2) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
