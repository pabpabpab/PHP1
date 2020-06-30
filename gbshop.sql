-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 30 2020 г., 17:31
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
-- База данных: `gbshop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `total_price` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `status` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `items`, `total_price`, `status`) VALUES
(4, 7, '{\"11\":3}', '29997.00', 3),
(5, 7, '{\"6\":2,\"7\":3}', '28218.00', 2),
(6, 8, '{\"6\":1,\"11\":1}', '10776.00', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `product_name` varchar(30) NOT NULL,
  `product_price` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `product_description` text NOT NULL,
  `img_folder` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `number_of_images` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `main_img_name` varchar(30) NOT NULL DEFAULT '',
  `view_number` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `number_of_comments` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `user_id`, `product_name`, `product_price`, `product_description`, `img_folder`, `number_of_images`, `main_img_name`, `view_number`, `number_of_comments`) VALUES
(6, 5, 'просто товар 777', '777.00', 'просто очень классный товар 777', 1, 3, '6_5eefd49b18723.jpg', 32, 6),
(7, 5, 'просто товар 888', '8888.00', 'просто очень классный товар 888', 1, 2, '7_5ef08bfbae9cb.jpg', 19, 5),
(11, 5, 'просто товар 999', '9999.00', 'просто очень классный товар 999', 1, 3, '11_5ef092c076120.jpg', 16, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `products_comments`
--

CREATE TABLE `products_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products_comments`
--

INSERT INTO `products_comments` (`id`, `product_id`, `text`) VALUES
(1, 6, 'Да и правда очень классный товар.'),
(2, 6, 'Да и правда очень классный товар 22222.'),
(3, 6, 'Да и правда очень классный товар 33333.'),
(4, 7, 'Это не очень классный товар.'),
(5, 7, 'Это не очень классный товар 222.'),
(6, 7, 'Это не очень классный товар 333.'),
(7, 7, 'Это не очень классный товар 44444.'),
(8, 7, 'Это не очень классный товар 55555.'),
(9, 6, 'Это новый комментарий на новом движке'),
(10, 11, 'привет это новый комментарий'),
(11, 6, 'Это новый комментарий на новом движке 222'),
(12, 6, 'Это новый комментарий на новом движке 333');

-- --------------------------------------------------------

--
-- Структура таблицы `products_images`
--

CREATE TABLE `products_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `img_name_info` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products_images`
--

INSERT INTO `products_images` (`id`, `product_id`, `img_name_info`) VALUES
(1, 6, '6_5eefd49b18723.jpg'),
(2, 6, '6_5eefd49b19001.jpg'),
(3, 6, '6_5eefd49b196de.jpg'),
(4, 7, '7_5ef08bfbae9cb.jpg'),
(6, 7, '7_5ef08bfbaf252.jpg'),
(23, 11, '11_5ef092c076120.jpg'),
(25, 11, '11_5ef092c0766a8.jpg'),
(26, 11, '11_5ef092c076918.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(70) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `number_of_products` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `number_of_orders` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_admin`, `number_of_products`, `number_of_orders`) VALUES
(5, 'Alex', '123123@123.ru', '$2y$10$tYoSTP.zMJQfDdh9suD8weD167nTN3sHs7R8gCa6WNDM.3MEWpbSi', 1, 3, 0),
(7, 'Vova', '333@333.ru', '$2y$10$RK.4CR4hdNjCMvIEy8D3y.7xgrhbKfeMyAFeexUoJX3orULXDhrfW', 0, 0, 2),
(8, 'Qwerty', 'qwerty@qwerty.ru', '$2y$10$NPWVtAZih936KWcQ0CdUAO3vuEHQXx4LN6d4rdYldL.0WKiOMUY/q', 0, 0, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_price` (`product_price`),
  ADD KEY `view_number` (`view_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `products_comments`
--
ALTER TABLE `products_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `products_images`
--
ALTER TABLE `products_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `products_comments`
--
ALTER TABLE `products_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `products_images`
--
ALTER TABLE `products_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
