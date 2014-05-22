-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Jeu 22 Mai 2014 à 15:37
-- Version du serveur :  5.5.34
-- Version de PHP :  5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données :  `markus`
--
CREATE DATABASE IF NOT EXISTS `markus` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `markus`;

-- --------------------------------------------------------

--
-- Structure de la table `Annotation`
--

CREATE TABLE `Annotation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idDocument` int(11) NOT NULL,
  `idGroupe` int(11) NOT NULL,
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
  `auteur` varchar(100) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` mediumtext,
  `contenuOriginal` longtext NOT NULL,
  `etat` int(11) NOT NULL,
  `dateCreation` varchar(50) NOT NULL,
  `dateModification` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `EtatDocument`
--

CREATE TABLE `EtatDocument` (
  `id` int(11) NOT NULL,
  `libelle` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `EtatDocument`
--

INSERT INTO `EtatDocument` (`id`, `libelle`) VALUES
(0, 'Ouvert'),
(1, 'Publié'),
(2, 'Terminé');

-- --------------------------------------------------------

--
-- Structure de la table `GestionAcces`
--

CREATE TABLE `GestionAcces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idGroupe` int(11) NOT NULL,
  `emailAdministrateur` varchar(250) NOT NULL,
  `emailUtilisateur` varchar(250) NOT NULL,
  `dateDemande` varchar(250) NOT NULL,
  `dateValidation` varchar(250) DEFAULT NULL,
  `avis` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `Groupe`
--

INSERT INTO `Groupe` (`id`, `intitule`, `description`, `dateCreation`, `emailAdministrateur`) VALUES
(0, 'Bibliothèque', 'Bibliothèque personnelles', '16/04/2014', ''),
(1, 'Faculté d''Évry', 'Ce groupe est un rassemblement de professeurs issus de l''université d''Évry', '25/01/2014', 'luis@luis.fr'),
(2, 'MIAGE Université d''Évry Val d''Essonne', 'Groupement des élèves de toutes les promotions MIAGE.', '25/01/2014', 'indy@indy.fr'),
(3, 'Groupe de recherche', 'description', '30/01/2014', 'axel@axel.fr');

-- --------------------------------------------------------

--
-- Structure de la table `GroupeDocument`
--

CREATE TABLE `GroupeDocument` (
  `idGroupe` int(11) NOT NULL,
  `idDocument` int(11) NOT NULL,
  `contenu` longtext NOT NULL,
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
  PRIMARY KEY (`idGroupe`,`emailUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `GroupeUtilisateur`
--

INSERT INTO `GroupeUtilisateur` (`idGroupe`, `emailUtilisateur`, `dateInscriptionGroupe`) VALUES
(1, 'luis@luis.fr', '15/05/2014'),
(2, 'indy@indy.fr', '15/05/2014'),
(3, 'axel@axel.fr', '15/05/2014');

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

--
-- Contenu de la table `TypeAnnotation`
--

INSERT INTO `TypeAnnotation` (`id`, `libelle`) VALUES
(1, 'commentaire'),
(2, 'surlignage');

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
('axel@axel.fr', 'axel', 'axel', 'axel'),
('cart@man.us', 'Le mécano', 'Paulo', 'cartman'),
('indy@indy.fr', 'De Deken', 'Indy', 'indy'),
('luis@luis.fr', 'Luis', 'José', 'luis');
COMMIT;
