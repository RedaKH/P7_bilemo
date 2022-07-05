-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 05 juil. 2022 à 00:01
-- Version du serveur : 5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bilemo`
--

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_81398E09E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `customer`
--

INSERT INTO `customer` (`id`, `email`, `password`, `company`, `firstname`, `lastname`, `roles`) VALUES
(10, 'heisenberg@gmail.com', '$2y$13$6xF0u/R2SLSl/ziI2x5/Gejy82AYwnVsP52Cdb5YReJM78wm9Ygy.', 'Free', 'Walter', 'White', '[\"ROLE_USER\"]'),
(11, 'wolverine@gmail.com', '$2y$13$MbIRRM5QQKQYdl/9XD/Wv.tB2bDu7lEqQtlHLwmTucrKE1EFssHG.', 'Fnac', 'Logan', 'Wolverine', '[\"ROLE_USER\"]'),
(12, 'ragnar@gmail.com', '$2y$13$5iBgp/YPg5pBPexFfsnNdOYO/IsZ8rxx8YfpmAF.Km6fLmlzL27kC', 'Vodafone', 'Ragnar', 'Lothbrok', '[\"ROLE_USER\"]'),
(13, 'ivar@gmail.com', '$2y$13$hnQ95OaRQtMeRPmbwhbiru8Im50oMiGeMf6PBZSXP8QfmZeuS3TDG', NULL, 'Ivar', 'Lothbrok', '[\"ROLE_USER\"]');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220530085143', '2022-05-30 08:52:19', 13667),
('DoctrineMigrations\\Version20220531084201', '2022-05-31 09:02:34', 4323),
('DoctrineMigrations\\Version20220531171244', '2022-05-31 17:12:49', 4355);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(555) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `created_at`) VALUES
(1, 'iPhone X', 'Ecran : large 5,8 soit 14,5 cm Mémoire interne : 256 Go Mémoire RAM : 3 Go - Processeur : Puce A11', 256.99, '2022-06-03 09:45:00'),
(2, 'iPhone 12', 'Ecran : large 5,8 soit 14,5 cm Mémoire interne : 500 Go Mémoire RAM : 3 Go - Processeur : Puce A11', 1000, '2022-06-03 09:46:31'),
(3, 'Samsung Galaxy 12', 'Ecran : large 5,8 soit 14,5 cm Mémoire interne : 500 Go Mémoire RAM : 3 Go - Processeur : Puce A11', 1000, '2022-06-03 10:42:32');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  KEY `IDX_8D93D6499395C3F3` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `customer_id`, `email`, `roles`, `password`, `firstname`, `lastname`) VALUES
(4, 10, 'jessepinkman@gmail.com', '[\"ROLE_USER\"]', '$2y$13$aSKH9V8.vlEjs0Lm2W0iaO3Nn9MNvVzw.dsqUL1epIuq78jgcKpkm', 'Jesse', 'Pinkman'),
(5, 10, 'tucosalamanca@gmail.com', '[\"ROLE_USER\"]', '$2y$13$ekGZK4I7DVteL26XCcmE7ufWtLSJ9Kz9YGgij93Fq2yk.0xP1A6yO', 'Tuco', 'Salamanca'),
(7, 10, 'lalosalamanca@gmail.com', '[\"ROLE_USER\"]', '$2y$13$nOveEFq/IZcZPVs.ww2Vtuh664ySMBzO5w.1o9ry0wQ8ig/ajZeSa', 'Lalo', 'Salamanca'),
(8, 10, 'gus@gmail.com', '[\"ROLE_USER\"]', '$2y$13$e5u9WkWn.ETFRvdVwgO9E.ZjlqyK9MMFB6lClqG3awMhpBX71hMgG', 'Gustavo', 'Frings'),
(9, 12, 'ecbert@gmail.com', '[\"ROLE_USER\"]', '$2y$13$3aMhFYG2x9e0.rYvZXCB9ejE.JGCmqTiwwQ6USCG9TZ/y0k7iLuS.', 'King', 'Ecbert');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6499395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
