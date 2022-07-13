-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 13 juil. 2022 à 14:06
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `customer`
--

INSERT INTO `customer` (`id`, `email`, `password`, `company`, `firstname`, `lastname`, `roles`) VALUES
(4, 'gustavo@test.com', '$2y$13$c3/KzHviJ84fj9F.8ZCr6ukQBbNfvTTkrnU0zLHfAe752mTelV.8S', 'Free', 'Gustavo', 'Frings', '[\"ROLE_USER\"]'),
(5, 'ragnar@test.com', '$2y$13$Ll47jlhCFpJvh.ewiXYzLOHnh5EtnVkF.qeQdvipBBQMHZ3MYCUCG', 'Vodafone', 'Ragnar', 'Lothbrock', '[\"ROLE_USER\"]'),
(6, 'logan@test.com', '$2y$13$hId9jcPjPn.xdKu9Z3IU5OmrJk53dmv7G1qvpsMI5vjqKrvrWtaR.', 'SFR', 'Logan', 'Wolverine', '[\"ROLE_USER\"]');

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
('DoctrineMigrations\\Version20220531171244', '2022-05-31 17:12:49', 4355),
('DoctrineMigrations\\Version20220712113707', '2022-07-12 11:39:04', 10097);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `created_at`) VALUES
(5, 'Iphone X', 'Système d\'exploitation: iOS\n                Taille d\'écran: Écran 6,1 po\n                Fonctions de sécurité: Reconnaissance faciale, Lecteur d\'empreintes digitales', 899.99, '2022-07-13 12:48:16'),
(6, 'Samsung S20', 'Marque: Samsung\n                Système d\'exploitation: Android\n                Taille d\'écran: Écran 6,2 po', 1000.99, '2022-07-13 12:48:16');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  KEY `IDX_8D93D6499395C3F3` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`, `customer_id`) VALUES
(1, 'rosa.boyer@runte.com', '[\"ROLE_USER\"]', '$2y$13$KA6uCERVv4JKYs9xPV2Me.9UjG7PoTbcsdS9de3jvtn4e2L7f6Qq2', 'Raven Howell', 'Abner Mueller', 4),
(3, 'cummings.sydnie@fay.com', '[\"ROLE_USER\"]', '$2y$13$CXsrg60OqXQicFotdrcYleiBmaIfXSUIqeTOhfLAHbnyGaiAGp8G2', 'Prof. Arch Lakin IV', 'Aurelio McKenzie', 4),
(4, 'wmorissette@blanda.org', '[\"ROLE_USER\"]', '$2y$13$Rc5zRb3SBj/EAbgIcQY1PeQCyUJ4Z.gc8ZNXBmJNRbHbRv4WHPffG', 'Bennie Ernser', 'Ms. Amalia Collins IV', 4),
(5, 'ricky14@gmail.com', '[\"ROLE_USER\"]', '$2y$13$rEmqsZ0w.3zPiE3TDamOMO0l02YKqMpN6gmcBuyGPoJGZ7Kjnoio6', 'Cassidy Jaskolski PhD', 'Vella Kunde DDS', 4),
(6, 'zachery45@lubowitz.com', '[\"ROLE_USER\"]', '$2y$13$b4.mULH//CyFNlKt3nBhP.dxu00qtUKduc575zGH9QArpOiI8Y2Sm', 'Carlie Bauch', 'Dr. Adam Hickle II', 4),
(7, 'orn.samanta@mills.com', '[\"ROLE_USER\"]', '$2y$13$xDH9WA1WeyPHVDWngIH6v.6Wayu0NBInMDIouk3OcEM9IVr1/79QC', 'Elyse Lang', 'Millie Beatty', 4),
(8, 'jedidiah23@rosenbaum.biz', '[\"ROLE_USER\"]', '$2y$13$0Jylxon/XC6r/Y4x8jvWDeet6.TgWQd3ca83/bhjAd7i4Wqil8rWS', 'Germaine D\'Amore', 'Wiley Emmerich', 4),
(9, 'wratke@turner.org', '[\"ROLE_USER\"]', '$2y$13$zSJD5pZJNQKNPzd9cXca2uoEP4.5/2wT4Y1eOrLJ1hqxzMcwEth8O', 'Garret Halvorson PhD', 'Aliya Crist', 4),
(10, 'ebert.ruben@yahoo.com', '[\"ROLE_USER\"]', '$2y$13$cf.4mbeTtxFbswxQSc/4SO/AZr56FpmnlJ3zWng19W/V0DTgCoGaW', 'Lizzie Dicki PhD', 'Prof. Brayan Little', 4),
(11, 'mertz.arnold@konopelski.com', '[\"ROLE_USER\"]', '$2y$13$WDLW7ontaSBjB1bsVWcx7e92cHr95eHjqBF8CAgYttw2sba8D5j5a', 'Clarissa Franecki', 'Burley Walsh', 4),
(12, 'nick35@hotmail.com', '[\"ROLE_USER\"]', '$2y$13$6NTNA07KHpFYThKQGMNXkesk5rv.vXvvTpACNcgfFIIaH95G3ez0O', 'Dr. Janie Abernathy', 'Grayce Keeling', 4),
(13, 'kristy.franecki@gmail.com', '[\"ROLE_USER\"]', '$2y$13$yNn86XRPR1/2HPXCxXq5kelPfL0TLxZvc7lgIOS807Puz4kzKyNku', 'Edd Kautzer', 'Aryanna Ziemann', 5),
(14, 'lsmith@legros.com', '[\"ROLE_USER\"]', '$2y$13$OEdEDCJG4l45oXELxG/PLOxee8nKOyoDxGDHWcZqyMTHtvOCj8OKq', 'Anita Kris', 'Dena Casper', 5),
(15, 'katheryn.bradtke@hotmail.com', '[\"ROLE_USER\"]', '$2y$13$3lw70Vtq9YiBd9ExFCeZB.MoWtwExSXM8OjKBhZwASha6NGFWQdXi', 'Kenton Miller', 'Name Howe', 5),
(16, 'imitchell@sporer.com', '[\"ROLE_USER\"]', '$2y$13$l4Q0oAluq0zdmfNbrfoSeewN89lBHre3qXzDD3ho4R6Z5koArKdt2', 'Yasmine', 'Hettinger', 6),
(17, 'rene.yost@schmitt.com', '[\"ROLE_USER\"]', '$2y$13$V9BDqXYHyPHglnKLoOE/9uqPtpx8Z6hC/KuHiZpgqsXzb4NHpzPNO', 'Abel', 'Strosin', 6),
(18, 'quitzon.perry@larkin.org', '[\"ROLE_USER\"]', '$2y$13$SHdMoyJas5.7ULH1yCh8vupG.lN1jb8xO9NcvLfISJ0NN7OHCNcH6', 'Guido', 'Lynch', 6),
(19, 'jgibson@veum.com', '[\"ROLE_USER\"]', '$2y$13$oZm9Fb9PHP1RP0S9md8hq.PWH1nTbZm6RdUdw/sAQyL2jnJSrEKze', 'Elfrieda', 'Runolfsson', 6),
(20, 'barrows.glenda@hotmail.com', '[\"ROLE_USER\"]', '$2y$13$.GTKoyxSI.Im4qM0GSIaUOxAu.EyCWh36tnxAA0JE0qsHy5do5nfm', 'Araceli', 'Heller', 6),
(21, 'nikko99@yahoo.com', '[\"ROLE_USER\"]', '$2y$13$vrzAflxdhdW26DEH/e98yOmClKpVIL1IklByjyOKcY9AyykeQXBB.', 'Bud', 'Abshire', 6),
(22, 'herman.karlie@hotmail.com', '[\"ROLE_USER\"]', '$2y$13$xpv00377U4PDGBgkpQAvhumexHlE7ZVcSpWEqfi7qBfWSPeSldCma', 'Reina', 'Watsica', 6),
(23, 'vincenzo.lynch@gerlach.com', '[\"ROLE_USER\"]', '$2y$13$jNSZjawyMSEnpRyppPiZWuivJTzmvl9arOhKpRencnQY9bxoNqchC', 'Gina', 'Kihn', 6),
(24, 'renee.frami@kozey.com', '[\"ROLE_USER\"]', '$2y$13$bqCSmTLDwqJl3am79uChF.YASKS/ii6y97YFERvmphajMRxbve05O', 'Lucienne', 'Osinski', 6),
(25, 'loki@gmail.com', '[\"ROLE_USER\"]', '$2y$13$EBjOhxPTkaj70OF7d5Bauu16Q/62Gg0nGi.VfxcRCo53ZcEQTu.eS', 'loki', 'thor', 4);

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
