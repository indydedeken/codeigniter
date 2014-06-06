-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 06 Juin 2014 à 09:13
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `markus`
--
CREATE DATABASE IF NOT EXISTS `markus` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `markus`;

-- --------------------------------------------------------

--
-- Structure de la table `annotation`
--

CREATE TABLE IF NOT EXISTS `annotation` (
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

--
-- Vider la table avant d'insérer `annotation`
--

TRUNCATE TABLE `annotation`;
-- --------------------------------------------------------

--
-- Structure de la table `document`
--

CREATE TABLE IF NOT EXISTS `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emailUtilisateur` varchar(100) NOT NULL,
  `auteur` varchar(100) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` mediumtext,
  `contenuOriginal` longtext CHARACTER SET utf8 NOT NULL,
  `etat` int(11) NOT NULL,
  `dateCreation` varchar(50) NOT NULL,
  `dateModification` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Vider la table avant d'insérer `document`
--

TRUNCATE TABLE `document`;
--
-- Contenu de la table `document`
--

INSERT INTO `document` (`id`, `emailUtilisateur`, `auteur`, `titre`, `description`, `contenuOriginal`, `etat`, `dateCreation`, `dateModification`) VALUES
(2, 'luis@luis.fr', 'Didier C.', 'Cours de BADA numero 1', 'Premier cours de BADA en M1 Miage', './filesUploaded/user_6b2710860069ce7e18a540219b459d5c/CoursBADA_1-html.html', 0, '06/06/2014', NULL),
(3, 'indy@indy.fr', 'Axel A.', 'Extrait d''examen AD', 'Extrait de 2011-2012', './filesUploaded/user_a5e673e5d6dfd2aed96f51881037fe89/ExtraitExamenAD_M1_2011-2012-html.html', 0, '06/06/2014', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `etatdocument`
--

CREATE TABLE IF NOT EXISTS `etatdocument` (
  `id` int(11) NOT NULL,
  `libelle` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vider la table avant d'insérer `etatdocument`
--

TRUNCATE TABLE `etatdocument`;
--
-- Contenu de la table `etatdocument`
--

INSERT INTO `etatdocument` (`id`, `libelle`) VALUES
(0, 'Ouvert'),
(1, 'Publié'),
(2, 'Terminé');

-- --------------------------------------------------------

--
-- Structure de la table `gestionacces`
--

CREATE TABLE IF NOT EXISTS `gestionacces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idGroupe` int(11) NOT NULL,
  `emailAdministrateur` varchar(250) NOT NULL,
  `emailUtilisateur` varchar(250) NOT NULL,
  `dateDemande` varchar(250) NOT NULL,
  `dateValidation` varchar(250) DEFAULT NULL,
  `avis` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Vider la table avant d'insérer `gestionacces`
--

TRUNCATE TABLE `gestionacces`;
--
-- Contenu de la table `gestionacces`
--

INSERT INTO `gestionacces` (`id`, `idGroupe`, `emailAdministrateur`, `emailUtilisateur`, `dateDemande`, `dateValidation`, `avis`) VALUES
(4, 3, 'axel@axel.fr', 'indy@indy.fr', '22/05/2014', NULL, 0),
(5, 1, 'luis@luis.fr', 'indy@indy.fr', '06/06/2014', '06/06/2014', 1);

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE IF NOT EXISTS `groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intitule` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `dateCreation` varchar(50) NOT NULL,
  `emailAdministrateur` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Vider la table avant d'insérer `groupe`
--

TRUNCATE TABLE `groupe`;
--
-- Contenu de la table `groupe`
--

INSERT INTO `groupe` (`id`, `intitule`, `description`, `dateCreation`, `emailAdministrateur`) VALUES
(0, 'Bibliothèque', 'Bibliothèque personnelles', '16/04/2014', ''),
(1, 'Faculté d''Évry', 'Ce groupe est un rassemblement de professeurs issus de l''université d''Évry', '25/01/2014', 'luis@luis.fr'),
(2, 'MIAGE Université d''Évry Val d''Essonne', 'Groupement des élèves de toutes les promotions MIAGE.', '25/01/2014', 'indy@indy.fr'),
(3, 'Groupe de recherche', 'description', '30/01/2014', 'axel@axel.fr');

-- --------------------------------------------------------

--
-- Structure de la table `groupedocument`
--

CREATE TABLE IF NOT EXISTS `groupedocument` (
  `idGroupe` int(11) NOT NULL,
  `idDocument` int(11) NOT NULL,
  `contenu` longtext NOT NULL,
  PRIMARY KEY (`idGroupe`,`idDocument`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vider la table avant d'insérer `groupedocument`
--

TRUNCATE TABLE `groupedocument`;
--
-- Contenu de la table `groupedocument`
--

INSERT INTO `groupedocument` (`idGroupe`, `idDocument`, `contenu`) VALUES
(0, 2, ''),
(0, 3, ''),
(1, 2, '');

-- --------------------------------------------------------

--
-- Structure de la table `groupeutilisateur`
--

CREATE TABLE IF NOT EXISTS `groupeutilisateur` (
  `idGroupe` int(11) NOT NULL,
  `emailUtilisateur` varchar(100) NOT NULL,
  `dateInscriptionGroupe` varchar(50) NOT NULL,
  PRIMARY KEY (`idGroupe`,`emailUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vider la table avant d'insérer `groupeutilisateur`
--

TRUNCATE TABLE `groupeutilisateur`;
--
-- Contenu de la table `groupeutilisateur`
--

INSERT INTO `groupeutilisateur` (`idGroupe`, `emailUtilisateur`, `dateInscriptionGroupe`) VALUES
(1, 'indy@indy.fr', '06/06/2014'),
(1, 'luis@luis.fr', '15/05/2014'),
(2, 'indy@indy.fr', '15/05/2014'),
(2, 'luis@luis.fr', '23/05/2014'),
(3, 'axel@axel.fr', '15/05/2014');

-- --------------------------------------------------------

--
-- Structure de la table `typeannotation`
--

CREATE TABLE IF NOT EXISTS `typeannotation` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vider la table avant d'insérer `typeannotation`
--

TRUNCATE TABLE `typeannotation`;
--
-- Contenu de la table `typeannotation`
--

INSERT INTO `typeannotation` (`id`, `libelle`) VALUES
(1, 'commentaire'),
(2, 'surlignage');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `email` varchar(100) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  PRIMARY KEY (`email`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vider la table avant d'insérer `utilisateur`
--

TRUNCATE TABLE `utilisateur`;
--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`email`, `nom`, `prenom`, `mdp`) VALUES
('axel@axel.fr', 'axel', 'axel', 'axel'),
('cart@man.us', 'Le mécano', 'Paulo', 'cartman'),
('indy@indy.fr', 'De Deken', 'Indy', 'indy'),
('luis@luis.fr', 'Luis', 'José', 'luis');
