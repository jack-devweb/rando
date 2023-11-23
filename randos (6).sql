-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 20 nov. 2023 à 14:10
-- Version du serveur : 8.0.30
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `randos`
--

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE `notes` (
  `id` int NOT NULL,
  `id_utilisateur` int DEFAULT NULL,
  `id_randonnee` int DEFAULT NULL,
  `note` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notes`
--

INSERT INTO `notes` (`id`, `id_utilisateur`, `id_randonnee`, `note`, `created_at`) VALUES
(30, NULL, 43, 5, '2023-11-20 09:00:53'),
(31, NULL, 43, 4, '2023-11-20 09:02:05'),
(32, NULL, 43, 3, '2023-11-20 09:49:39'),
(33, NULL, 43, 2, '2023-11-20 09:50:46'),
(34, NULL, 43, 2, '2023-11-20 09:52:16'),
(35, NULL, 49, 2, '2023-11-20 10:03:36'),
(36, NULL, 43, 2, '2023-11-20 10:20:42'),
(37, NULL, 43, 1, '2023-11-20 10:21:24'),
(38, NULL, 43, 2, '2023-11-20 10:33:58'),
(39, NULL, 43, 1, '2023-11-20 10:34:05'),
(40, NULL, 43, 2, '2023-11-20 10:34:50'),
(41, NULL, 43, 2, '2023-11-20 10:35:02'),
(42, 7, 43, 1, '2023-11-20 10:37:34'),
(47, 7, 49, 1, '2023-11-20 12:08:47'),
(53, NULL, 49, 2, '2023-11-20 13:27:42'),
(54, NULL, 50, 2, '2023-11-20 13:27:58'),
(55, NULL, 43, 2, '2023-11-20 13:32:56'),
(56, NULL, 43, 1, '2023-11-20 13:34:00');

-- --------------------------------------------------------

--
-- Structure de la table `randonnees`
--

CREATE TABLE `randonnees` (
  `id` int NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `adresse_depart` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `popularite` decimal(3,2) DEFAULT '0.00',
  `photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `note` decimal(2,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `randonnees`
--

INSERT INTO `randonnees` (`id`, `nom`, `description`, `adresse_depart`, `latitude`, `longitude`, `popularite`, `photo`, `created_at`, `note`) VALUES
(43, 'randonnee de la dent du chat', ' Située dans le massif de la Chartreuse, la dent du Chat donne la possibilité d\' une jolie randonnée avec une vue magnifique sur le lac du Bourget. C\' est une randonnée assez facile au départ du parking du relais du chat, seuls les 50 derniers mètres équipés d\' échelles et de câbles rendent l\'itinéraire plus sportif et surtout plus aérien ! C\'est surtout sur le plateau sommital que la sensation de vertige . . . gagne ! Prévoir  1h pour parvenir à la dent du chat et autant pour le retour, pour 350 m de dénivelé environ', NULL, '45.65986135', '5.82079176', '4.00', 'R.jpeg', '2023-11-17 13:37:20', NULL),
(49, 'Croix du Nivolet ,depart parking du sire ', 'Si vous cherchez la randonnée la plus célèbre du secteur de Chambéry, Aix les Bains, la voici !! La Croix du Nivolet ! Tellement célèbre, qu’elle fait partie des 10 incontournables à faire lors d’une visite à Chambéry. \r\nNiveau de difficulté : si ce n’est une petite montée un peu raide en tout début de randonnée, accéder à La Croix du Nivolet est une randonnée familiale par excellence.\r\nAltitude maximale : 1547m\r\nDistance : A/R environ 7,5 km\r\nTemps de parcours : environ 2h pour l’A/R, un peu plus si vous décidez de pique-niquer au pied de la croix…', NULL, '45.63637500', '5.96341900', '4.00', 'la-croix-du-nivolet-28.jpg', '2023-11-18 15:23:18', NULL),
(50, 'Le Sommet du Mont Granier', 'Au cœur de la Réserve Naturelle des Hauts de Chartreuse, sa majesté le Mont Granier vous accueille. Bien que la croix soit inaccessible pour raison de sécurité, cette randonnée révèle une géologie étonnante et une biodiversité remarquable.\r\n↔\r\nDistance : 8,73 km\r\n◔\r\nDurée moyenne : 5h 20 \r\n▲\r\nDifficulté : Difficile\r\n∞\r\nRetour point de départ : Oui\r\n↗\r\nDénivelé positif : + 991 m\r\n↘\r\nDénivelé négatif : - 987 m\r\n▲\r\nPoint haut : 1 924 m\r\n▼\r\nPoint bas : 1 092 m\r\n⚐\r\nRégions : Alpes, Chartreuse\r\n⚐\r\nCommune : Entremont-le-Vieux (73670)\r\n⚑\r\nDépart/Arrivée : N 45.442406° / E 5.905751°\r\n❏\r\nCarte(s) IGN : Ref. 3333OT, 3333OTR', NULL, '45.44240600', '5.90575100', '5.00', '3fe964ef5bed72d4e4767f19aeacb293.jpg', '2023-11-18 15:48:19', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `admin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `username`, `password`, `created_at`, `admin`) VALUES
(4, 'jo', '$2y$10$YyuynDTJ6c4JU07uT8W6FuDQxn1EoIhQRK6E3inGHBdYtcOFCOvIO', '2023-11-14 10:54:36', 1),
(5, 'admin', '$2y$10$vxBugUo6zA3updUVGpT0Hur3/soG8988j0xhZAherAhntrFZLqFyC', '2023-11-14 14:17:16', 1),
(6, 'jim', '$2y$10$MincNc1GMLioNXOeQa72dusaRZDA3rD4Qjo10QYr5m1AQ7HkWr2qi', '2023-11-18 16:13:01', 0),
(7, 'jak', '$2y$10$6xMhJJ5YO.QWfww3MqhqKuZ/1BnE/ShLUA5oDGV4hgwESILCjTcJi', '2023-11-18 16:26:54', 0),
(8, 'lin', '$2y$10$pI01NleoZyBnZwrad28I7.0KJLAnlUUEXR/bwbGFqg.Y8TfDqVKUq', '2023-11-20 09:51:56', 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_randonnees`
--

CREATE TABLE `utilisateur_randonnees` (
  `id` int NOT NULL,
  `utilisateur_id` int DEFAULT NULL,
  `randonnee_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur_randonnees`
--

INSERT INTO `utilisateur_randonnees` (`id`, `utilisateur_id`, `randonnee_id`) VALUES
(1, NULL, 43),
(2, NULL, 43),
(3, NULL, 43),
(4, NULL, 43),
(5, NULL, 43),
(6, 7, 43),
(7, 7, 49),
(8, 7, 50);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_randonnee` (`id_utilisateur`,`id_randonnee`),
  ADD KEY `id_randonnee` (`id_randonnee`);

--
-- Index pour la table `randonnees`
--
ALTER TABLE `randonnees`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur_randonnees`
--
ALTER TABLE `utilisateur_randonnees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `randonnee_id` (`randonnee_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `randonnees`
--
ALTER TABLE `randonnees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `utilisateur_randonnees`
--
ALTER TABLE `utilisateur_randonnees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`id_randonnee`) REFERENCES `randonnees` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `utilisateur_randonnees`
--
ALTER TABLE `utilisateur_randonnees`
  ADD CONSTRAINT `utilisateur_randonnees_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `utilisateur_randonnees_ibfk_2` FOREIGN KEY (`randonnee_id`) REFERENCES `randonnees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
