-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 22 Juin 2017 à 12:16
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `annonceo`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `id_annonce` int(3) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description_courte` varchar(255) NOT NULL,
  `description_longue` varchar(255) DEFAULT NULL,
  `prix` int(5) NOT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `pays` varchar(20) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `cp` int(5) DEFAULT NULL,
  `membre_id` int(3) DEFAULT NULL,
  `photo_id` int(3) DEFAULT NULL,
  `categorie_id` int(3) DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `annonce`
--

INSERT INTO `annonce` (`id_annonce`, `titre`, `description_courte`, `description_longue`, `prix`, `photo`, `pays`, `ville`, `adresse`, `cp`, `membre_id`, `photo_id`, `categorie_id`, `date_enregistrement`) VALUES
(1, 'Mercedes 140', 'La dernière vraie voiture produite par Mercedes', 'Mercedes W140 de 1999 version 7.2 Brabus culeur noir', 50000, 'http://localhost/annonceo/photo/mb1.jpg', 'France', 'Paris', '45 avenue de la Liberation', 75019, NULL, NULL, NULL, '2017-06-22 00:00:00'),
(2, 'Mercedes 140', 'La dernière vraie voiture produite par Mercedes', 'Mercedes W140 de 1999 version 7.2 Brabus culeur noir', 50000, 'http://localhost/annonceo/photo/mb1.jpg', 'France', 'Paris', '45 avenue de la Liberation', 75019, NULL, NULL, NULL, '2017-06-22 00:00:00'),
(3, 'Mercedes 140', 'La dernière vraie voiture produite par Mercedes', 'Mercedes W140 de 1999 version 7.2 Brabus culeur noir', 50000, 'http://localhost/annonceo/photo/mb1.jpg', 'France', 'Paris', '45 avenue de la Liberation', 75019, NULL, NULL, NULL, '2017-06-22 00:00:00'),
(4, 'Mercedes 140', 'La dernière vraie voiture produite par Mercedes', 'Mercedes W140 de 1999 version 7.2 Brabus culeur noir', 50000, 'http://localhost/annonceo/photo/mb1.jpg', 'France', 'Paris', '45 avenue de la Liberation', 75019, NULL, NULL, NULL, '2017-06-22 00:00:00'),
(5, 'Mercedes 140', 'La dernière vraie voiture produite par Mercedes', 'Mercedes W140 de 1999 version 7.2 Brabus culeur noir', 50000, 'http://localhost/annonceo/photo/mb1.jpg', 'France', 'Paris', '45 avenue de la Liberation', 75019, NULL, NULL, NULL, '2017-06-22 00:00:00'),
(6, 'Mercedes 140', 'La dernière vraie voiture produite par Mercedes', 'Mercedes W140 de 1999 version 7.2 Brabus culeur noir', 50000, 'http://localhost/annonceo/photo/mb1.jpg', 'France', 'Paris', '45 avenue de la Liberation', 75019, NULL, NULL, NULL, '2017-06-22 00:00:00'),
(7, 'Mercedes 140', 'La dernière vraie voiture produite par Mercedes', 'Mercedes W140 de 1999 version 7.2 Brabus culeur noir', 50000, 'http://localhost/annonceo/photo/mb1.jpg', 'France', 'Paris', '45 avenue de la Liberation', 75019, NULL, NULL, NULL, '2017-06-22 00:00:00'),
(8, 'Mercedes 140', 'La dernière vraie voiture produite par Mercedes', 'Mercedes W140 de 1999 version 7.2 Brabus culeur noir', 50000, 'http://localhost/annonceo/photo/mb1.jpg', 'France', 'Paris', '45 avenue de la Liberation', 75019, NULL, NULL, NULL, '2017-06-22 00:00:00'),
(9, 'Mercedes 140', 'La dernière vraie voiture produite par Mercedes', 'Mercedes W140 de 1999 version 7.2 Brabus culeur noir', 50000, 'http://localhost/annonceo/photo/mb1.jpg', 'France', 'Paris', '45 avenue de la Liberation', 75019, NULL, NULL, NULL, '2017-06-22 00:00:00'),
(10, 'Mercedes 140', 'La dernière vraie voiture produite par Mercedes', 'Mercedes W140 de 1999 version 7.2 Brabus culeur noir', 50000, 'http://localhost/annonceo/photo/mb1.jpg', 'France', 'Paris', '45 avenue de la Liberation', 75019, NULL, NULL, NULL, '2017-06-22 00:00:00'),
(11, 'Mercedes 140', 'La dernière vraie voiture produite par Mercedes', 'Mercedes W140 de 1999 version 7.2 Brabus culeur noir', 50000, 'http://localhost/annonceo/photo/mb1.jpg', 'France', 'Paris', '45 avenue de la Liberation', 75019, NULL, NULL, NULL, '2017-06-22 00:00:00'),
(12, 'Mercedes 140', 'La dernière vraie voiture produite par Mercedes', 'Mercedes W140 de 1999 version 7.2 Brabus culeur noir', 50000, 'http://localhost/annonceo/photo/mb1.jpg', 'France', 'Paris', '45 avenue de la Liberation', 75019, NULL, NULL, NULL, '2017-06-22 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(3) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `motscles` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int(3) NOT NULL,
  `membre_id` int(3) DEFAULT NULL,
  `annonce_id` int(3) DEFAULT NULL,
  `commentaire` text,
  `date_enregistrement` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(3) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(60) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `statut` int(1) DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id_note` int(3) NOT NULL,
  `membre_id1` int(3) DEFAULT NULL,
  `membre_id2` int(3) DEFAULT NULL,
  `note` int(3) DEFAULT NULL,
  `avis` text,
  `date_enregistrement` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id_photo` int(3) NOT NULL,
  `photo1` varchar(255) NOT NULL,
  `photo2` varchar(255) NOT NULL,
  `photo3` varchar(255) NOT NULL,
  `photo4` varchar(255) NOT NULL,
  `photo5` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`id_annonce`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_commentaire`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id_note`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id_photo`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `id_annonce` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `id_note` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id_photo` int(3) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
