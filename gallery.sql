-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 18 2020 г., 11:21
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `gbphp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `gallery`
--

CREATE TABLE `gallery` (
  `id` int(10) UNSIGNED NOT NULL,
  `img_folder` int(10) UNSIGNED NOT NULL,
  `name_of_small_img` varchar(30) NOT NULL,
  `name_of_big_img` varchar(30) NOT NULL,
  `weight_of_small_img` int(10) UNSIGNED NOT NULL,
  `weight_of_big_img` int(10) UNSIGNED NOT NULL,
  `number_of_viewings` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `gallery`
--

INSERT INTO `gallery` (`id`, `img_folder`, `name_of_small_img`, `name_of_big_img`, `weight_of_small_img`, `weight_of_big_img`, `number_of_viewings`) VALUES
(1, 1, 'i5eea589ae7fea.jpg', 'i5eea589ae7fea.jpg', 644915, 644915, 1),
(2, 1, 'i5eea6926b8f65.bmp', 'i5eea6926b8f65.bmp', 1423302, 1423302, 14),
(3, 1, 'i5eea6d5c85424.jpg', 'i5eea6d5c85424.jpg', 42272, 42272, 5),
(4, 1, 'i5eeaa99a23095.jpg', 'i5eeaa99a23095.jpg', 151280, 151280, 3),
(5, 1, 'i5eeaaa4332af6.jpg', 'i5eeaaa4332af6.jpg', 110953, 110953, 2),
(6, 1, 'i5eeaab1561b25.jpg', 'i5eeaab1561b25.jpg', 126622, 126622, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `number_of_viewings` (`number_of_viewings`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
