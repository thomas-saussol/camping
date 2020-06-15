-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 29 jan. 2020 à 14:57
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `camping`
--
CREATE DATABASE IF NOT EXISTS `camping` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `camping`;

-- --------------------------------------------------------

--
-- Structure de la table `emplacements`
--

DROP TABLE IF EXISTS `emplacements`;
CREATE TABLE IF NOT EXISTS `emplacements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `emplacements`
--

INSERT INTO `emplacements` (`id`, `Nom`) VALUES
(1, 'La Plage'),
(2, 'Les Pins'),
(3, 'Le Maquis');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `type` int(11) NOT NULL,
  `Bornes` tinyint(1) NOT NULL,
  `Disco` tinyint(1) NOT NULL,
  `Packs Activités` tinyint(1) NOT NULL,
  `id_emplacements` int(11) NOT NULL,
  `Nom` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `date_debut`, `date_fin`, `type`, `Bornes`, `Disco`, `Packs Activités`, `id_emplacements`, `Nom`) VALUES
(2, '2020-02-10', '2020-02-16', 2, 1, 0, 1, 1, 'Gonzalez'),
(3, '2020-02-10', '2020-02-16', 2, 1, 0, 1, 1, 'admin'),
(4, '2020-01-31', '2020-02-05', 1, 1, 0, 0, 2, 'Monto'),
(5, '2020-02-17', '2020-02-21', 1, 0, 0, 0, 1, 'Gonzalez'),
(6, '2020-01-31', '2020-02-05', 1, 1, 0, 0, 1, 'Gonzalez'),
(10, '2020-07-14', '2020-07-20', 2, 1, 0, 1, 1, 'Adan');

-- --------------------------------------------------------

--
-- Structure de la table `tarifs`
--

DROP TABLE IF EXISTS `tarifs`;
CREATE TABLE IF NOT EXISTS `tarifs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prix` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tarifs`
--

INSERT INTO `tarifs` (`id`, `nom`, `prix`) VALUES
(1, 'Bornes', 2),
(2, 'Disco', 17),
(3, 'Packs_Activités', 20);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL DEFAULT 'utilisateur',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `password`, `grade`) VALUES
(1, 'Firefou', '$2y$12$Im202YfWWjd0l5PiHAOPke09BwsFnieduor1KRyt49m8j6YQTujQK', 'admin'),
(2, 'Walken99', '$2y$12$Jk7bMyycNmxl2ICTuLDgM.5irnbzzNKfy66UDqsvBm19dd7nmsyKS', 'utilisateur');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
