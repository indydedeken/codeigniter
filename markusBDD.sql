-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 07 Février 2014 à 15:41
-- Version du serveur: 5.5.25
-- Version de PHP: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
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
  `idGroupe` int(11) NOT NULL,
  `emailUtilisateur` varchar(100) NOT NULL,
  `contenu` longtext NOT NULL,
  `coordX` varchar(10) DEFAULT NULL,
  `coodY` varchar(10) DEFAULT NULL,
  `idTypeAnnotation` int(11) DEFAULT NULL,
  `dateCreation` varchar(50) NOT NULL,
  `dateModification` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `Annotation`
--

INSERT INTO `Annotation` (`id`, `idDocument`, `idGroupe`, `emailUtilisateur`, `contenu`, `coordX`, `coodY`, `idTypeAnnotation`, `dateCreation`, `dateModification`) VALUES
(1, 1, 1, 'indy@indy.fr', 'test de contenu', '100', '200', 0, '27/01/2014', ''),
(2, 1, 0, 'indy@indy.fr', 'test de contenu2', '100', '250', 0, '27/01/2014', ''),
(3, 2, 0, 'axel@axel.fr', 'test de contenu3', '100', '270', 0, '27/01/2014', ''),
(5, 1, 2, 'indy@indy.fr', 'test de contenu', '100', '200', 0, '27/01/2014', '');

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
  `contenuOriginal` longtext NOT NULL,
  `etat` int(11) NOT NULL,
  `dateCreation` varchar(50) NOT NULL,
  `dateModification` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `Document`
--

INSERT INTO `Document` (`id`, `emailUtilisateur`, `auteur`, `titre`, `description`, `contenuOriginal`, `etat`, `dateCreation`, `dateModification`) VALUES
(1, 'indy@indy.fr', 'Axel Ajavon & Luis Braga Miguel Seixas José & Indy De Deken', 'Un titre de document peut-être très long comme celui-ci. Alors comment est-ce que l''affichage réagit ?', '', '<html><head><style>p{color:red;}</style></head><body><h1>Ma Vie</h1><p>Bonjour, c''est ma vie. Voilà le texte qui sert de test.</p></body></html>', 0, '25/01/2014', ''),
(2, 'luis@luis.fr', 'Guy de Maupassant', 'Pierre et Jean', '', '<html><head><style>p{color:red;}</style></head><body><h1>Ma Vie</h1><p>Bonjour, c''est ma vie. Voilà le texte qui sert de test.</p></body></html>', 2, '26/01/2014', ''),
(3, 'indy@indy.fr', 'Guy de Maupassant', 'Le horlat', '', '<html><head><style>p{color:red;}</style></head><body><h1>Ma Vie</h1><p>Bonjour, c''est ma vie. Voilà le texte qui sert de test.</p></body></html>', 0, '27/01/2014', ''),
(4, 'indy@indy.fr', 'Pedro Porto', 'La cuisine portugaise au Moyen-Âge', 'Ce recueil de poésie datant du XXIè siècle est une ôde à la maçonnerie contractuelle.\r\nLes jambes de mon fauteuil sont en vinyl de soie.', 'contenu du pdf', 1, '30/01/2014', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `Groupe`
--

INSERT INTO `Groupe` (`id`, `intitule`, `description`, `dateCreation`, `emailAdministrateur`) VALUES
(1, 'Faculté d''Évry', 'Ce groupe est un rassemblement de professeurs issus de l''université d''Évry', '25/01/2014', 'indy@indy.fr'),
(2, 'MIAGE Université d''Évry Val d''Essonne', 'Groupement des élèves de toutes les promotions MIAGE.', '25/01/2014', 'indy@indy.fr'),
(3, 'hello GRP', 'description ', '30/01/2014', 'indy@indy.fr'),
(6, 'Test3', 'Description 3', '30/01/2014', 'indy@indy.fr'),
(7, 'Test4', 'Description 4', '30/01/2014', 'indy@indy.fr'),
(8, 'Groupe de Luis Moustache', 'Mon crew de lecture est ici.', '30/01/2014', 'luis@luis.fr'),
(9, 'Groupe de Indy', 'Bienvenue dans le groupe', '31/01/2014', 'indy@indy.fr'),
(10, 'Groupe de Joséba', 'Hello Josh', '31/01/2014', 'indy@indy.fr'),
(11, 'Je suis pas ton pote mon gars', 'A bon ?', '31/01/2014', 'indy@indy.fr'),
(12, 'Le groupe des Nachos', 'On aime les Nachos', '31/01/2014', 'indy@indy.fr'),
(14, 'Bonjour  Groupe', 'Bonjour', '31/01/2014', 'indy@indy.fr'),
(15, 'Au revoir Groupe', 'Groupe', '31/01/2014', 'indy@indy.fr'),
(16, 'Mon énième groupe', '', '06/02/2014', 'indy@indy.fr');

-- --------------------------------------------------------

--
-- Structure de la table `GroupeDocument`
--

DROP TABLE IF EXISTS `GroupeDocument`;
CREATE TABLE `GroupeDocument` (
  `idGroupe` int(11) NOT NULL,
  `idDocument` int(11) NOT NULL,
  `contenu` longtext NOT NULL,
  PRIMARY KEY (`idGroupe`,`idDocument`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `GroupeDocument`
--

INSERT INTO `GroupeDocument` (`idGroupe`, `idDocument`, `contenu`) VALUES
(1, 1, ''),
(1, 2, ''),
(1, 4, ''),
(2, 3, ''),
(3, 4, ''),
(6, 1, ''),
(7, 1, ''),
(7, 3, ''),
(8, 2, '');

-- --------------------------------------------------------

--
-- Structure de la table `GroupeUtilisateur`
--

DROP TABLE IF EXISTS `GroupeUtilisateur`;
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
(1, 'indy@indy.fr', '25/01/2014'),
(2, 'indy@indy.fr', '25/01/2014'),
(6, 'indy@indy.fr', '30/01/2014'),
(7, 'indy@indy.fr', '30/01/2014'),
(8, 'luis@luis.fr', '30/01/2014'),
(16, 'indy@indy.fr', '06/02/2014');

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
('axel@axel.fr', 'axel', 'axel', 'axel'),
('cart@man.us', 'Le mécano', 'Paulo', 'cartman'),
('indy@indy.fr', 'De Deken', 'Indy', 'indy'),
('luis@luis.fr', 'Luis', 'José', 'luis');
