-- phpMyAdmin SQL Dump
-- version 5.0.4deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql.info.unicaen.fr:3306
-- Généré le : Dim 14 nov. 2021 à 17:04
-- Version du serveur :  10.5.11-MariaDB-1
-- Version de PHP : 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `21903735_bd`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `utilisateur` varchar(255) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `utilisateur`, `mdp`) VALUES
(12, 'admin', '$2y$10$H1NjL.Rr9etbytO4GAZmB.9RCWoF5k//lRBRsSn6aoBtG52j4gThy'),
(14, 'lecarpentier', '$2y$10$JQo9OuT1BoePvlzf4rwrsuFUIYvre5tWA8w/u659jiTxT72jIjv2u'),
(23, 'manon', '$2y$10$l9IHOsjNVe/fBuQIt.A/PueTxPLrcbX1Aa7ZvqmDhfhIRpvk5XXli'),
(24, 'vanier', '$2y$10$xR9B.zoNBSffz/2aba4Rx.dl9QRuXOyWIfPa9xHmfYD.7X/Tkzf/K');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
