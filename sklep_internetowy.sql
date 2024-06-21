-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 21 Cze 2024, 15:42
-- Wersja serwera: 10.4.18-MariaDB
-- Wersja PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `sklep_internetowy`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `created_at`, `image_url`) VALUES
(1, 'banan', 'kisc', '5.00', '2024-06-18 13:05:13', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTN0PoYZLXvJ7skerTdZeo6x2TQnFKLLMPtLA&s'),
(2, 'jabłko', 'sztuka', '10.00', '2024-06-18 13:10:37', 'https://bonavita.pl/data/2015/09/jabko.jpg'),
(3, 'kalmar', 'gram', '100.00', '2024-06-18 13:11:17', 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjD5EaS1NjHO9mdtokcOKo3hYJjIX7_zzfCdY7gHwn-EF0Ipk0HKQKs5Gl2OibDoZn4s2qoUbaopLorQpGhfwMxmXFl0uPfPzi3V6F9WOp428AGzu0PCzB-MjEZOsAzBNPNUEanyYSLjCM/s1600/kalmaryp.jpg'),
(8, 'jogurt', 'sztuka', '5.00', '2024-06-19 19:51:55', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS3M4ccD6IqowNdK6Pz4Zzrmwn82CdGXV9TVQ&s'),
(9, 'pomarańcza', 'kilogram', '6.00', '2024-06-19 19:53:11', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR9Krc6N1Xtr5sMZf7L17660_rGcR0JMNe6ag&s'),
(10, 'borówki', 'gram', '12.00', '2024-06-19 20:08:43', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5AoQDxifU2GcbGEiRwdh8QORVhmhCerBKog&s'),
(11, 'maliny', 'gram', '12.00', '2024-06-19 20:09:58', 'https://www.izielnik.pl/img/uploads/Blog/2019_08/malina.jpg'),
(12, 'pomidory', 'sztuka', '5.00', '2024-06-19 20:10:37', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRaUNNEva_D-smTb8bE66W0Bn2ei5-dF3MiIA&s');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('user','moderator','administrator') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$1oB006khzWB/9BnQCTQtWeqJAD2ubbFJ48gnOnb2eeNeD6aqZQk3.', 'admin@gmail.com', 'administrator', '2024-06-18 12:21:14'),
(2, 'user', '$2y$10$OCZiZE07v7HAP5ANyiTMtuXgpX4VrScGM0tWdIQjEQP9mWESHLGhC', 'user@gmail.com', 'user', '2024-06-18 12:35:20'),
(3, 'moderator', '$2y$10$K8UJSH0ogu41qPwFnwGOUuzHkT1AEvapm91p7tlUqKDIT82aQp8aq', 'moderator@gmail.com', 'moderator', '2024-06-18 12:35:47');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeksy dla tabeli `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
