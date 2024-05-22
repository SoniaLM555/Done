-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 22 mai 2024 à 13:55
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `done`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `idCategory` int(10) UNSIGNED NOT NULL,
  `titleCategory` varchar(50) NOT NULL,
  `icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`idCategory`, `titleCategory`, `icon`) VALUES
(1, 'Ménage', 'house'),
(2, 'Administratif', 'folder'),
(3, 'Bien être', 'emoji-smile-upside-down');

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE `item` (
  `idItem` int(10) UNSIGNED NOT NULL,
  `titleItem` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `idList` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`idItem`, `titleItem`, `status`, `idList`) VALUES
(1, 'Vider lave-vaisselle', 0, 5),
(2, 'Nettoyer le frigo', 0, 5),
(3, 'Dégivrer le congélateur', 0, 5),
(4, 'Faire photo identité', 0, 13),
(5, 'prendre rendez-vous mairie', 0, 13),
(6, 'Nettoyer machine à laver à vide', 0, 3),
(7, 'Nettoyer bouche aération', 0, 3),
(8, 'Détartrer robinets', 0, 3),
(15, 'Nouvelle tache', 0, 3),
(16, 'Nouvelle tache', 0, 3),
(17, 'test', 0, 3),
(18, 'test', 0, 3),
(19, 'test', 0, 3),
(20, 'gfegsghfh', 0, 3),
(21, 'gfegsghfh', 0, 3),
(22, 'gfegsghfh', 0, 3),
(23, 'gfegsghfh', 0, 3),
(24, 'gfegsghfh', 0, 3),
(25, 'gfegsghfh', 0, 5),
(26, 'test', 0, 3),
(27, 'gfegsghfh', 0, 3),
(28, 'faire la vaisselle', 0, 5),
(29, 'faire la vaisselle', 0, 5);

-- --------------------------------------------------------

--
-- Structure de la table `list`
--

CREATE TABLE `list` (
  `idList` int(10) UNSIGNED NOT NULL,
  `titleList` varchar(255) NOT NULL,
  `idUser` int(10) UNSIGNED NOT NULL,
  `idCategory` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `list`
--

INSERT INTO `list` (`idList`, `titleList`, `idUser`, `idCategory`) VALUES
(3, 'Salle de bain', 1, 1),
(5, 'Cuisine', 1, 1),
(13, 'Renouveler CNI', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `idUser` int(10) UNSIGNED NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`idUser`, `pseudo`, `email`, `password`) VALUES
(1, 'test', 'test@test.com', '$2y$10$Mjjg6tF34lWz5DZBiwGerORTX.rk3EGYzqAj94.EZRVKqiYAbwDUu');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`idCategory`);

--
-- Index pour la table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`idItem`),
  ADD KEY `item_ibfk_1` (`idList`);

--
-- Index pour la table `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`idList`),
  ADD KEY `idCategory` (`idCategory`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `idCategory` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `idItem` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `list`
--
ALTER TABLE `list`
  MODIFY `idList` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`idList`) REFERENCES `list` (`idList`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `list`
--
ALTER TABLE `list`
  ADD CONSTRAINT `list_ibfk_1` FOREIGN KEY (`idCategory`) REFERENCES `category` (`idCategory`),
  ADD CONSTRAINT `list_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
