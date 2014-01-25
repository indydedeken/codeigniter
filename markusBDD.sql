-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Sam 25 Janvier 2014 à 17:20
-- Version du serveur: 5.5.25
-- Version de PHP: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données: `markus`
--

-- --------------------------------------------------------

--
-- Structure de la table `Annotation`
--

DROP TABLE IF EXISTS `Annotation`;
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

DROP TABLE IF EXISTS `Document`;
CREATE TABLE `Document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emailUtilisateur` varchar(100) NOT NULL,
  `auteur` varchar(100) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` mediumtext,
  `contenu` longtext NOT NULL,
  `etat` int(11) NOT NULL,
  `dateCreation` varchar(50) NOT NULL,
  `dateModification` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `Document`
--

INSERT INTO `Document` (`id`, `emailUtilisateur`, `auteur`, `titre`, `description`, `contenu`, `etat`, `dateCreation`, `dateModification`) VALUES
(1, 'indy@indy.fr', 'Guy de Maupassant', 'Ma vie', '', '<html><head><style>p{color:red;}</style></head><body><h1>Ma Vie</h1><p>Bonjour, c''est ma vie. Voilà le texte qui sert de test.</p></body></html>', 0, '25/01/2014', ''),
(2, 'indy@indy.fr', 'Guy de Maupassant', 'Pierre et Jean', '', '<html><head><style>p{color:red;}</style></head><body><h1>Ma Vie</h1><p>Bonjour, c''est ma vie. Voilà le texte qui sert de test.</p></body></html>', 0, '26/01/2014', ''),
(3, 'indy@indy.fr', 'Guy de Maupassant', 'Le horlat', '', '<html><head><style>p{color:red;}</style></head><body><h1>Ma Vie</h1><p>Bonjour, c''est ma vie. Voilà le texte qui sert de test.</p></body></html>', 0, '27/01/2014', '');

-- --------------------------------------------------------

--
-- Structure de la table `EtatDocument`
--

DROP TABLE IF EXISTS `EtatDocument`;
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
-- Structure de la table `Groupe`
--

DROP TABLE IF EXISTS `Groupe`;
CREATE TABLE `Groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intitule` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `dateCreation` varchar(50) NOT NULL,
  `emailAdministrateur` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `Groupe`
--

INSERT INTO `Groupe` (`id`, `intitule`, `description`, `dateCreation`, `emailAdministrateur`) VALUES
(1, 'Faculté d''Évry', 'Ce groupe est un rassemblement de professeurs issus de l''université d''Évry', '25/01/2014', 'indy@indy.fr');

-- --------------------------------------------------------

--
-- Structure de la table `GroupeDocument`
--

DROP TABLE IF EXISTS `GroupeDocument`;
CREATE TABLE `GroupeDocument` (
  `idGroupe` int(11) NOT NULL,
  `idDocument` int(11) NOT NULL,
  PRIMARY KEY (`idGroupe`,`idDocument`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `GroupeUtilisateur`
--

DROP TABLE IF EXISTS `GroupeUtilisateur`;
CREATE TABLE `GroupeUtilisateur` (
  `idGroupe` int(11) NOT NULL,
  `emailUtilisateur` varchar(100) NOT NULL,
  `dateInscriptionGroupe` varchar(50) NOT NULL,
  PRIMARY KEY (`idGroupe`),
  UNIQUE KEY `idGroupe` (`idGroupe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `GroupeUtilisateur`
--

INSERT INTO `GroupeUtilisateur` (`idGroupe`, `emailUtilisateur`, `dateInscriptionGroupe`) VALUES
(1, 'indy@indy.fr', '25/01/2014');

-- --------------------------------------------------------

--
-- Structure de la table `TypeAnnotation`
--

DROP TABLE IF EXISTS `TypeAnnotation`;
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

DROP TABLE IF EXISTS `Utilisateur`;
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
('axel@axel.fr', 'axel', 'axel', 'axelaxel'),
('indy@indy.fr', 'De Deken', 'Indy', 'indyindy'),
('luis@luis.fr', 'Luis', 'Pépito del muerte', 'luisluis');
COMMIT;
