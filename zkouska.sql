-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Ned 21. kvě 2023, 20:25
-- Verze serveru: 10.4.27-MariaDB
-- Verze PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `zkouska`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230422174826', '2023-04-22 19:50:13', 88),
('DoctrineMigrations\\Version20230423163524', '2023-04-23 18:35:47', 304),
('DoctrineMigrations\\Version20230423185527', '2023-04-23 20:55:39', 117),
('DoctrineMigrations\\Version20230423193131', '2023-04-23 21:31:38', 122),
('DoctrineMigrations\\Version20230423193620', '2023-04-23 21:36:23', 84),
('DoctrineMigrations\\Version20230423194451', '2023-04-23 21:44:58', 45),
('DoctrineMigrations\\Version20230501192341', '2023-05-01 21:24:10', 224),
('DoctrineMigrations\\Version20230504180624', '2023-05-04 20:06:58', 474),
('DoctrineMigrations\\Version20230511190611', '2023-05-11 21:06:18', 144);

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) NOT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Vypisuji data pro tabulku `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`) VALUES
(1, 'Šíma', '[]', '$2y$13$42qusXQ203RZEys3ZsdH5ein3E.evOuPlMsCQFp7u7m28p2Q7gOSm'),
(2, 'Šašek', '[]', '$2y$13$f0i.I1fBXHsNuihczi49ueQTj2wm1PjIk9qAwflT2YhstqdfI18ia'),
(3, 'admin', '[]', '$2y$13$LVV7yIbVxNRj8CFZXvn13epQBotA8PsFhBPWmC7eJanIF5lKxqmrO');

-- --------------------------------------------------------

--
-- Struktura tabulky `zkouska`
--

CREATE TABLE `zkouska` (
  `id` int(11) NOT NULL,
  `jmeno` varchar(255) NOT NULL,
  `informace` varchar(255) NOT NULL,
  `height` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `frajer` tinyint(1) NOT NULL,
  `smradoch` tinyint(1) NOT NULL,
  `img` varchar(500) NOT NULL,
  `hodnoceni` int(11) NOT NULL,
  `datum` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Vypisuji data pro tabulku `zkouska`
--

INSERT INTO `zkouska` (`id`, `jmeno`, `informace`, `height`, `weight`, `frajer`, `smradoch`, `img`, `hodnoceni`, `datum`) VALUES
(1, 'Boháč', 'Majitel a je fakt dobrej', '187', '77', 1, 0, 'yeti-646521df62225.jpg', 18, '2023-03-08'),
(2, 'Zdenda', 'Smolař', '15', '623', 0, 1, 'yeti.jpg', 12, NULL),
(3, 'Luďan', 'uhlobaron', '150', '123', 1, 1, 'yeti.jpg', 3, NULL),
(4, 'Pašoun', 'Milovník motýlů', '150', '80', 0, 1, 'yeti.jpg', 8, NULL),
(5, 'Jenda', 'Je to proste Janek', '178', '80', 1, 0, 'yeti.jpg', 5, NULL),
(6, 'Franta', 'Pouziva Gripper', '250', '100', 1, 0, 'yeti.jpg', 8, NULL),
(7, 'Přemysl', 'Umí orat', '135', '65', 0, 1, 'yeti.jpg', -3, NULL),
(8, 'Tuturutum', 'Hodně se klouže', '190', '60', 0, 1, 'yeti.jpg', 5, NULL),
(9, 'Igor', 'Pozor na nej', '210', '90', 1, 0, 'yeti.jpg', 0, NULL),
(10, 'Fiddlesticks', 'Strasidelny ale pratelsky', '100', '20', 1, 1, 'yeti.jpg', 5, NULL),
(11, 'Yetiáš', 'Je to podrazák', '50', '15', 0, 0, 'yeti.jpg', -24, NULL),
(14, 'Říďa', 'Dokáže řídit lidi', '135', '200', 1, 0, 'yeti.jpg', 11, NULL),
(15, 'Špunt', 'maličkej :((', '30', '15', 0, 0, 'yeti.jpg', -2, NULL),
(16, 'Poslíček', 'Koktá jako dost', '90', '50', 0, 1, 'yeti.jpg', 2, NULL),
(17, 'Jarda', 'sasek', '15', '623', 1, 0, 'yeti-6459585c33a76.jpg', -1, NULL),
(18, 'Čočka', 'Má pořádný skla', '150', '71', 0, 1, 'yeti-64595f585bc87.jpg', -2, NULL),
(20, 'Vagabund', 'má ve všem nepořádek', '190', '90', 0, 0, 'yeti-6465228df129c.jpg', 0, NULL);

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexy pro tabulku `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- Indexy pro tabulku `zkouska`
--
ALTER TABLE `zkouska`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `zkouska`
--
ALTER TABLE `zkouska`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
