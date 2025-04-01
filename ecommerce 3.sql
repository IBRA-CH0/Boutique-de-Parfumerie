-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 26, 2025 at 02:47 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nom`) VALUES
(2, 'Femme'),
(1, 'Homme'),
(3, 'Mixte');

-- --------------------------------------------------------

--
-- Table structure for table `commandes`
--

CREATE TABLE `commandes` (
  `id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `parfum_id` int NOT NULL,
  `quantite` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `date_commande` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `adresse_livraison` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `commandes`
--

INSERT INTO `commandes` (`id`, `utilisateur_id`, `nom`, `prenom`, `parfum_id`, `quantite`, `total`, `date_commande`, `adresse_livraison`, `telephone`, `email`) VALUES
(24, 8, 'CHORFI', 'IBRAHIM', 2, 1, '89.99', '2025-03-26 12:02:22', '4 RUE GEOROGE SAND', '0664982021', 'admin@example.com'),
(25, 8, 'assia', 'chorfi', 5, 1, '65.00', '2025-03-26 13:40:46', '4 rue george sand 69007 lyon', '0664982021', 'admin@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `parfums`
--

CREATE TABLE `parfums` (
  `id` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `prix_promo` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `categorie_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `parfums`
--

INSERT INTO `parfums` (`id`, `nom`, `description`, `prix`, `prix_promo`, `image`, `categorie_id`) VALUES
(1, 'Dior Sauvage', 'Un parfum frais et épicé avec des notes de bergamote et de bois d\'ambre.', '99.99', '79.99', 'dior_sauvage.jpg', 1),
(2, 'Bleu de Chanel', 'Un parfum boisé aromatique avec des notes d\'agrumes et de santal.', '110.00', '89.99', 'bleu_chanel.jpg', 1),
(3, 'YSL La Nuit de L\'Homme', 'Un parfum séduisant aux notes de cardamome et de lavande.', '89.99', '69.99', 'ysl_nuit.jpg', 1),
(4, 'Giorgio Armani Code', 'Un parfum oriental épicé aux notes de bergamote et de fève tonka.', '95.00', '75.00', 'armani_code.jpg', 1),
(5, 'Paco Rabanne 1 Million', 'Un parfum luxueux aux notes de cuir et d\'épices.', '85.00', '65.00', 'million.jpg', 1),
(6, 'Versace Eros', 'Un parfum masculin intense aux notes de menthe et de vanille.', '92.00', '72.00', 'versace_eros.jpg', 1),
(7, 'Chanel No. 5', 'Un classique intemporel aux notes florales et sophistiquées.', '120.00', '95.00', 'chanel_no5.jpg', 2),
(8, 'Miss Dior', 'Une fragrance florale avec des notes de rose et de jasmin.', '105.00', '85.00', 'miss_dior.jpg', 2),
(9, 'Lancôme La Vie Est Belle', 'Un parfum féminin élégant et gourmand aux notes de vanille.', '110.00', '90.00', 'lancome_lavie.jpg', 2),
(10, 'YSL Black Opium', 'Un parfum gourmand avec du café et de la vanille.', '115.00', '92.00', 'black_opium.jpg', 2),
(11, 'Guerlain Mon Guerlain', 'Un parfum oriental avec de la lavande et de la vanille.', '98.00', '78.00', 'mon_guerlain.jpg', 2),
(12, 'Chloé Eau de Parfum', 'Une fragrance florale fraîche aux notes de rose et de pivoine.', '95.00', '75.00', 'chloe_edp.jpg', 2),
(13, 'Tom Ford Black Orchid', 'Un parfum mixte riche et mystérieux aux notes de truffe noire.', '150.00', '130.00', 'tomford_black.jpg', 3),
(14, 'Calvin Klein CK One', 'Un parfum frais et citronné unisexe.', '75.00', '60.00', 'ck_one.jpg', 3),
(15, 'Jo Malone Wood Sage & Sea Salt', 'Une fragrance fraîche et boisée.', '135.00', '110.00', 'jo_malone.jpg', 3),
(16, 'Maison Margiela Jazz Club', 'Notes de tabac, rhum et vanille.', '125.00', '100.00', 'jazz_club.jpg', 3),
(17, 'Byredo Gypsy Water', 'Un mélange de bergamote, d\'encens et de vanille.', '180.00', '150.00', 'gypsy_water.jpg', 3),
(18, 'Le Labo Santal 33', 'Un parfum boisé avec des notes de santal et de cuir.', '165.00', '140.00', 'santal33.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `date_inscription` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `date_inscription`) VALUES
(1, 'Jean Dupont', NULL, 'jean.dupont@example.com', '5504b4f70ca78f97137ff8ad5f910248', '2025-03-06 14:12:49'),
(2, 'Sophie Martin', NULL, 'sophie.martin@example.com', 'ab4f63f9ac65152575886860dde480a1', '2025-03-06 14:12:49'),
(3, 'Lucas Bernard', NULL, 'lucas.bernard@example.com', 'e10adc3949ba59abbe56e057f20f883e', '2025-03-06 14:12:49'),
(4, 'ibrahim', NULL, 'ibrahimchr@gmail.com', '$2y$10$MZgP1w5BFg2qsinhnnj6ru36FiIyPDSM0rxYnYaBiuUTUc/X2MVEi', '2025-03-06 14:14:21'),
(5, 'ibrahim', NULL, 'ibrahimchr777@gmail.com', '$2y$10$vEcmeopuJZHBpH75aiSrg.9yL1ivtazoU/9vWOIa/TXZ8IysLmXcu', '2025-03-06 15:11:51'),
(6, 'ibrahim', NULL, 'ibrahimchrr@gmail.com', '$2y$10$MCTa3gxlSo6iS.nMVFwdf.qAx7.biUjuM94OgBR40Rud6VKjw0mTm', '2025-03-07 13:37:18'),
(8, 'ibrahim', NULL, 'admin@example.com', '$2y$10$3n8Uh.9IRrZDBZJMW0zvsOPQF8lxcG0BA82siVdSmdNhEFm9CIRp.', '2025-03-25 12:25:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Indexes for table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `parfum_id` (`parfum_id`);

--
-- Indexes for table `parfums`
--
ALTER TABLE `parfums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `parfums`
--
ALTER TABLE `parfums`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `commandes_ibfk_2` FOREIGN KEY (`parfum_id`) REFERENCES `parfums` (`id`);

--
-- Constraints for table `parfums`
--
ALTER TABLE `parfums`
  ADD CONSTRAINT `parfums_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
