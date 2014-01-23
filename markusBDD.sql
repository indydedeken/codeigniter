-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 23 Janvier 2014 à 11:28
-- Version du serveur: 5.5.25
-- Version de PHP: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `markus`
--
DROP DATABASE `markus`;
CREATE DATABASE `markus` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `markus`;

-- --------------------------------------------------------

--
-- Structure de la table `Annotation`
--

CREATE TABLE `Annotation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idDocument` int(11) NOT NULL,
  `emailUtilisateur` varchar(100) NOT NULL,
  `contenu` longtext NOT NULL,
  `coordX` varchar(10) DEFAULT NULL,
  `coodY` varchar(10) DEFAULT NULL,
  `idTypeAnnotation` int(11) DEFAULT NULL,
  `dateCreation` varchar(50) NOT NULL,
  `dateModification` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Document`
--

CREATE TABLE `Document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emailUtilisateur` varchar(100) NOT NULL,
  `auteur` varchar(100) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `contenu` longtext NOT NULL,
  `etat` int(11) NOT NULL,
  `dateCreation` varchar(50) NOT NULL,
  `dateModification` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `Groupe`
--

CREATE TABLE `Groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intitule` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `dateCreation` varchar(50) NOT NULL,
  `emailAdministrateur` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `GroupeDocument`
--

CREATE TABLE `GroupeDocument` (
  `idGroupe` int(11) NOT NULL,
  `idDocument` int(11) NOT NULL,
  PRIMARY KEY (`idGroupe`,`idDocument`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `GroupeUtilisateur`
--

CREATE TABLE `GroupeUtilisateur` (
  `idGroupe` int(11) NOT NULL,
  `emailUtilisateur` varchar(100) NOT NULL,
  `dateInscriptionGroupe` varchar(50) NOT NULL,
  PRIMARY KEY (`idGroupe`),
  UNIQUE KEY `idGroupe` (`idGroupe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `TypeAnnotation`
--

CREATE TABLE `TypeAnnotation` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `email` varchar(100) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  PRIMARY KEY (`email`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`email`, `nom`, `prenom`, `mdp`) VALUES
('luis@luis.fr', 'Luis', 'Pépito del muerte', 'luisluis');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
