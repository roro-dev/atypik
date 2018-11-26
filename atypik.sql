-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 26 nov. 2018 à 14:31
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `atypik`
--

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

DROP TABLE IF EXISTS `activite`;
CREATE TABLE IF NOT EXISTS `activite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `actvite_logement`
--

DROP TABLE IF EXISTS `actvite_logement`;
CREATE TABLE IF NOT EXISTS `actvite_logement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_logement_id` int(11) NOT NULL,
  `id_activite_id` int(11) NOT NULL,
  `distance` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_35F94A9B40B934A2` (`id_logement_id`),
  KEY `IDX_35F94A9B831D4546` (`id_activite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur_id` int(11) NOT NULL,
  `id_logement_id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` int(11) NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_commentaire` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_67F068BCC6EE5C49` (`id_utilisateur_id`),
  KEY `IDX_67F068BC40B934A2` (`id_logement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `logement`
--

DROP TABLE IF EXISTS `logement`;
CREATE TABLE IF NOT EXISTS `logement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_type_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` int(11) NOT NULL,
  `id_proprietaire_id` int(11) NOT NULL,
  `ville_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F0FD44571BD125E3` (`id_type_id`),
  KEY `IDX_F0FD44579F9BCDC2` (`id_proprietaire_id`),
  KEY `IDX_F0FD4457A73F0036` (`ville_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20181126093908'),
('20181126101019'),
('20181126101945'),
('20181126102513'),
('20181126141747');

-- --------------------------------------------------------

--
-- Structure de la table `parametres_logement`
--

DROP TABLE IF EXISTS `parametres_logement`;
CREATE TABLE IF NOT EXISTS `parametres_logement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parametre_id` int(11) NOT NULL,
  `logement_id` int(11) NOT NULL,
  `valeur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8D459AE06358FF62` (`parametre_id`),
  KEY `IDX_8D459AE058ABF955` (`logement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parametres_type`
--

DROP TABLE IF EXISTS `parametres_type`;
CREATE TABLE IF NOT EXISTS `parametres_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5578281C54C8C93` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payer`
--

DROP TABLE IF EXISTS `payer`;
CREATE TABLE IF NOT EXISTS `payer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_paiement_id` int(11) NOT NULL,
  `id_utilisateur_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_41CB5B99325E898F` (`id_paiement_id`),
  KEY `IDX_41CB5B99C6EE5C49` (`id_utilisateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_logement_id` int(11) NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_14B7841840B934A2` (`id_logement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_logement_id` int(11) DEFAULT NULL,
  `id_utilisateur_id` int(11) DEFAULT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_42C8495540B934A2` (`id_logement_id`),
  KEY `IDX_42C84955C6EE5C49` (`id_utilisateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `roles_utilisateur`
--

DROP TABLE IF EXISTS `roles_utilisateur`;
CREATE TABLE IF NOT EXISTS `roles_utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles_utilisateur`
--

INSERT INTO `roles_utilisateur` (`id`, `role`) VALUES
(1, 'ROLE_ADMIN'),
(2, 'ROLE_USER');

-- --------------------------------------------------------

--
-- Structure de la table `type_logement`
--

DROP TABLE IF EXISTS `type_logement`;
CREATE TABLE IF NOT EXISTS `type_logement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_paiement`
--

DROP TABLE IF EXISTS `type_paiement`;
CREATE TABLE IF NOT EXISTS `type_paiement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mode_paiement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valide_user` tinyint(1) NOT NULL,
  `token_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1D1C63B3E7927C74` (`email`),
  KEY `IDX_1D1C63B3D60322AC` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `role_id`, `nom`, `prenom`, `adresse`, `email`, `telephone`, `password`, `valide_user`, `token_user`) VALUES
(1, 1, 'stefane', 'stefane', '124', 'stefane.rodrigues@aefinfo.fr', '0102030405', '$2y$12$yyEE/3e1yISWlxPkCAiJhuLXWSTwN5nmxVsydG5Ecm9xvLHWjC0qS', 0, '670a76b5c3');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

DROP TABLE IF EXISTS `ville`;
CREATE TABLE IF NOT EXISTS `ville` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `taxe` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `actvite_logement`
--
ALTER TABLE `actvite_logement`
  ADD CONSTRAINT `FK_35F94A9B40B934A2` FOREIGN KEY (`id_logement_id`) REFERENCES `logement` (`id`),
  ADD CONSTRAINT `FK_35F94A9B831D4546` FOREIGN KEY (`id_activite_id`) REFERENCES `activite` (`id`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_67F068BC40B934A2` FOREIGN KEY (`id_logement_id`) REFERENCES `logement` (`id`),
  ADD CONSTRAINT `FK_67F068BCC6EE5C49` FOREIGN KEY (`id_utilisateur_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `logement`
--
ALTER TABLE `logement`
  ADD CONSTRAINT `FK_F0FD44571BD125E3` FOREIGN KEY (`id_type_id`) REFERENCES `type_logement` (`id`),
  ADD CONSTRAINT `FK_F0FD44579F9BCDC2` FOREIGN KEY (`id_proprietaire_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `FK_F0FD4457A73F0036` FOREIGN KEY (`ville_id`) REFERENCES `ville` (`id`);

--
-- Contraintes pour la table `parametres_logement`
--
ALTER TABLE `parametres_logement`
  ADD CONSTRAINT `FK_8D459AE058ABF955` FOREIGN KEY (`logement_id`) REFERENCES `logement` (`id`),
  ADD CONSTRAINT `FK_8D459AE06358FF62` FOREIGN KEY (`parametre_id`) REFERENCES `parametres_type` (`id`);

--
-- Contraintes pour la table `parametres_type`
--
ALTER TABLE `parametres_type`
  ADD CONSTRAINT `FK_5578281C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type_logement` (`id`);

--
-- Contraintes pour la table `payer`
--
ALTER TABLE `payer`
  ADD CONSTRAINT `FK_41CB5B99325E898F` FOREIGN KEY (`id_paiement_id`) REFERENCES `type_paiement` (`id`),
  ADD CONSTRAINT `FK_41CB5B99C6EE5C49` FOREIGN KEY (`id_utilisateur_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `FK_14B7841840B934A2` FOREIGN KEY (`id_logement_id`) REFERENCES `logement` (`id`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `FK_42C8495540B934A2` FOREIGN KEY (`id_logement_id`) REFERENCES `logement` (`id`),
  ADD CONSTRAINT `FK_42C84955C6EE5C49` FOREIGN KEY (`id_utilisateur_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `FK_1D1C63B3D60322AC` FOREIGN KEY (`role_id`) REFERENCES `roles_utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
