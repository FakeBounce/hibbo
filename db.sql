-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Sam 18 Février 2017 à 16:29
-- Version du serveur :  10.1.9-MariaDB
-- Version de PHP :  5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `hibbo`
--

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE `classe` (
  `Name` varchar(50) NOT NULL COMMENT 'Nom de la classe',
  `Life` bigint(10) NOT NULL COMMENT 'Points de vie initiaux',
  `Mana` bigint(10) NOT NULL,
  `Armor` bigint(10) NOT NULL COMMENT 'Armure de base',
  `Damage` bigint(10) NOT NULL COMMENT 'Degats de base',
  `Range` tinyint(2) NOT NULL COMMENT 'Portee de base',
  `Movement` tinyint(2) NOT NULL COMMENT 'Deplacement possible initial',
  `SpecialPower` varchar(50) NOT NULL COMMENT 'Pouvoir spécial de la classe',
  `PDamageReduce` bigint(10) NOT NULL,
  `FDamageReduce` bigint(10) NOT NULL,
  `DamageReturn` bigint(10) NOT NULL,
  `NbAction` tinyint(2) NOT NULL COMMENT 'Le nombre d''actions par tour'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `classe`
--

INSERT INTO `classe` (`Name`, `Life`, `Mana`, `Armor`, `Damage`, `Range`, `Movement`, `SpecialPower`, `PDamageReduce`, `FDamageReduce`, `DamageReturn`, `NbAction`) VALUES
('Elite fighter', 15000, 1000, 0, 100, 1, 2, 'Réduit 50 dégâts', 0, 50, 0, 10);

-- --------------------------------------------------------

--
-- Structure de la table `mobs`
--

CREATE TABLE `mobs` (
  `Name` varchar(40) NOT NULL COMMENT 'Le nom du monstre',
  `Life` bigint(10) NOT NULL COMMENT 'La vie totale du monstre',
  `Armor` int(5) NOT NULL,
  `Damage` bigint(10) NOT NULL COMMENT 'Les degats du monstre',
  `Range` tinyint(2) NOT NULL COMMENT 'La portee du monstre',
  `Movement` tinyint(2) NOT NULL COMMENT 'Le deplacement possible du monstre',
  `XP` bigint(10) NOT NULL,
  `SpecialATK` varchar(40) NOT NULL COMMENT 'Le nom de lattaque speciale',
  `FDamageReduce` bigint(10) NOT NULL,
  `PDamageReduce` bigint(10) NOT NULL,
  `DamageReturn` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contient les statistiques des monstres';

--
-- Contenu de la table `mobs`
--

INSERT INTO `mobs` (`Name`, `Life`, `Armor`, `Damage`, `Range`, `Movement`, `XP`, `SpecialATK`, `FDamageReduce`, `PDamageReduce`, `DamageReturn`) VALUES
('BasicBoss', 10000, 0, 1000, 2, 0, 500, 'Non', 0, 0, 0),
('Ectoplasm', 500, 0, 550, 1, 1, 40, 'Non', 0, 0, 0),
('HealingOrb', 100, 0, 0, 1, 0, 50, 'Petit soin', 0, 0, 0),
('Man', 200, 0, 150, 1, 1, 4, 'Non', 0, 0, 0),
('Warrior', 300, 100, 250, 1, 1, 20, 'Non', 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `skills`
--

CREATE TABLE `skills` (
  `Name` varchar(40) NOT NULL COMMENT 'Nom de la competence',
  `Damage` bigint(10) NOT NULL COMMENT 'Les degats instantanes',
  `TimeDamage` bigint(10) NOT NULL,
  `BuffDamage` bigint(10) NOT NULL COMMENT 'Le bonus aux degats',
  `DebuffDamage` bigint(10) NOT NULL COMMENT 'Le malus aux degats',
  `TypeDamage` varchar(40) NOT NULL,
  `PDamageReduce` bigint(10) NOT NULL COMMENT 'Le bonus darmure',
  `PDamageUp` bigint(10) NOT NULL COMMENT 'Le malus darmure',
  `FDamageReduce` bigint(10) NOT NULL,
  `FDamageUp` bigint(10) NOT NULL,
  `DamageReturn` bigint(10) NOT NULL,
  `LifeBuff` bigint(10) NOT NULL,
  `LifeDebuff` bigint(10) NOT NULL,
  `InstantHeal` bigint(10) NOT NULL COMMENT 'Le soin instantane',
  `TimeHeal` bigint(10) NOT NULL COMMENT 'Le soin sur le temps',
  `ForcedMovement` tinyint(2) NOT NULL,
  `BuffMovement` tinyint(2) NOT NULL COMMENT 'Le bonus de deplacement',
  `DebuffMovement` tinyint(2) NOT NULL COMMENT 'Le malus de deplacement',
  `Duration` tinyint(2) NOT NULL,
  `ManaGain` bigint(10) NOT NULL,
  `ManaCost` bigint(10) NOT NULL COMMENT 'Le cout en mana',
  `LifeCost` bigint(10) NOT NULL COMMENT 'Le cout en vie',
  `LinearRange` tinyint(2) NOT NULL COMMENT 'La portee en ligne droite',
  `DiagonalRange` tinyint(2) NOT NULL COMMENT 'La portee en diagonale',
  `LinearAoe` tinyint(2) NOT NULL,
  `CircleAoe` tinyint(2) NOT NULL,
  `BonusEffect` varchar(40) NOT NULL COMMENT 'Effet particulier',
  `Cast` tinyint(2) NOT NULL COMMENT 'Nombre de fois total ou l''action peut etre effectue',
  `ActionPoint` tinyint(2) NOT NULL COMMENT 'points d''actions utilisés pour la compétence',
  `CastReset` tinyint(2) NOT NULL COMMENT 'Le nombre de tours avant qu''on puisse réutiliser laction',
  `Description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `skills`
--

INSERT INTO `skills` (`Name`, `Damage`, `TimeDamage`, `BuffDamage`, `DebuffDamage`, `TypeDamage`, `PDamageReduce`, `PDamageUp`, `FDamageReduce`, `FDamageUp`, `DamageReturn`, `LifeBuff`, `LifeDebuff`, `InstantHeal`, `TimeHeal`, `ForcedMovement`, `BuffMovement`, `DebuffMovement`, `Duration`, `ManaGain`, `ManaCost`, `LifeCost`, `LinearRange`, `DiagonalRange`, `LinearAoe`, `CircleAoe`, `BonusEffect`, `Cast`, `ActionPoint`, `CastReset`, `Description`) VALUES
('Attaque du belier', 3000, 0, 0, 0, 'Aoe', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 0, 0, 0, 0, 1000, 0, 1, 0, 4, 0, 'Peut casser certains murs', 1, 10, 0, 'Vous foncez en ligne droite sur 4 cases, infligeant 3000dégâts sur votre passage. Coûte 1000 mana'),
('Attaque tournoyante', 0, 0, 400, 0, 'Aoe', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 300, 0, 0, 0, 0, 1, 'Non', -1, 10, 0, 'Vous tournez sur vous même infligeant 400 dégâts en plus à tout les ennemis proches. Coûte 300mana.'),
('Coupe veine', 0, 150, 0, 0, 'Dot', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 250, 0, 1, 0, 0, 0, 'Non', -1, 10, 0, 'Vous tailladez sauvagement l\'ennemi, le faisant saigner de 150hp pendant 10tours. Coûte 250mana.'),
('Fuite', 0, 0, 0, 0, 'Buff', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 2, 0, 100, 0, 0, 0, 0, 0, 'Non', 3, 0, 0, 'Vous gagnez 2 en déplacement pendant 2tours, coûte 100mana'),
('Guerison des plaies', 0, 0, 0, 0, 'Heal', 0, 0, 0, 0, 0, 0, 0, 1000, 0, 0, 0, 0, 0, 0, 200, 0, 0, 0, 0, 0, 'Non', -1, 10, 0, 'Vous vous soignez de 1000hp, coûte 200mana.'),
('Guillotine', 0, 0, 1400, 0, 'Buff', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 700, 0, 0, 0, 0, 0, 'Non', -1, 0, 0, 'Vos prochaines attaques infligeront 1400 dégâts en plus, dure 2tours. Coûte 700 mana.'),
('Petit soin', 0, 0, 0, 0, 'Heal', 0, 0, 0, 0, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 'Non', -1, 10, 0, 'Soigne un allié proche de 100hp'),
('Resistance a la douleur', 0, 0, 0, 0, 'Buff', 0, 0, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 0, 400, 0, 0, 0, 0, 0, 'Non', 1, 0, 10, 'Vous réduisez de 200 les dégâts des 3 prochains tours. Coûte 400mana, utilisable 1fois par 10tours.');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `classe`
--
ALTER TABLE `classe`
  ADD PRIMARY KEY (`Name`),
  ADD KEY `Life` (`Life`,`Armor`,`Damage`,`Range`,`Movement`,`SpecialPower`,`Mana`);

--
-- Index pour la table `mobs`
--
ALTER TABLE `mobs`
  ADD PRIMARY KEY (`Name`),
  ADD KEY `Life` (`Life`,`Damage`,`Range`,`Movement`,`SpecialATK`);

--
-- Index pour la table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`Name`),
  ADD KEY `Castreset` (`CastReset`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
