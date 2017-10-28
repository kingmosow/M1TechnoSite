-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 04 Octobre 2017 à 21:48
-- Version du serveur :  5.6.16
-- Version de PHP :  5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `m1glar2017`
--

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE IF NOT EXISTS `etudiants` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `prenoms` varchar(100) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `login` varchar(100) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `prenoms`, `nom`, `login`, `mdp`, `telephone`, `adresse`, `email`) VALUES
(1, 'Cheikh', 'Diop', 'cheikh', 'cheikh', '2217765432', 'UGB', 'cheikh@gmail.com'),
(2, 'Fallou', 'Ndiaye', 'fallou', 'fallou', '778866222', 'Dakar', 'fallou@gmail.com'),
(3, 'Charles', 'Faye', 'charles', 'charles', '2217765432', 'Pikine', 'charles@gmail.com'),
(4, 'Oumou', 'Sene', 'oumou', 'oumou', '778866222', 'Gossas', 'oumou@yahoo.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
