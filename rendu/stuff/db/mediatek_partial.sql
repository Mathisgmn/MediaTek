-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 19 mars 2025 à 10:03
-- Version du serveur : 8.0.41-0ubuntu0.24.04.1
-- Version de PHP : 8.3.6

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mediatek`
--
CREATE DATABASE IF NOT EXISTS `mediatek` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `mediatek`;

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `isbn` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `publication_year` smallint NOT NULL,
  `issue_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `isbn_UNIQUE` (`isbn`),
  KEY `fk_book_user_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci PACK_KEYS=0;

--
-- Déchargement des données de la table `book`
--

INSERT INTO `book` (`id`, `user_id`, `isbn`, `title`, `summary`, `publication_year`, `issue_date`, `created_at`, `updated_at`) VALUES
(1, NULL, '9781491952023', 'JavaScript - The Definitive Guide (7th ed.)', 'Ce livre est une ressource essentielle pour tout développeur JavaScript, qu\'il soit débutant ou expérimenté. Il couvre en profondeur le langage JavaScript, son exécution dans les navigateurs et les environnements serveur. Cette édition met à jour les nouvelles fonctionnalités d\'ES6+, la programmation asynchrone, et les API modernes. C\'est un guide complet pour comprendre JavaScript de manière détaillée et avancée.', 2020, NULL, '2025-03-05 10:20:46', '2025-03-05 10:20:46'),
(2, NULL, '9781801819312', 'Machine Learning with PyTorch and Scikit-Learn', 'Ce livre offre une introduction pratique au machine learning avec Python, en utilisant Scikit-Learn pour les modèles classiques et PyTorch pour l\'apprentissage profond. Il couvre la préparation des données, les algorithmes essentiels, le deep learning et le déploiement des modèles. Illustré d\'exemples et de code, il s\'adresse aux développeurs souhaitant appliquer l\'IA à des projets concrets.', 2022, NULL, '2025-03-05 10:20:46', '2025-03-05 10:20:46'),
(3, NULL, '9781492051725', 'Learning React (2nd ed.)', 'Un guide pratique pour comprendre React et son écosystème. Il explique les concepts fondamentaux tels que les composants, les hooks, le state management et le Virtual DOM. Cette édition inclut les nouvelles fonctionnalités de React, notamment les hooks et le suspense. Idéal pour les développeurs souhaitant maîtriser la création d\'interfaces dynamiques et réactives.', 2020, NULL, '2025-03-05 10:20:46', '2025-03-05 10:20:46'),
(4, NULL, '9781492056355', 'Fluent Python (2nd ed.)', 'Un ouvrage avancé qui enseigne aux développeurs comment écrire un code Python efficace et idiomatique. Il couvre les structures de données, les classes, la programmation fonctionnelle et asynchrone. Cette seconde édition intègre les dernières évolutions du langage et propose des conseils pratiques pour améliorer la performance et la lisibilité du code.', 2022, NULL, '2025-03-05 10:20:46', '2025-03-05 10:20:46'),
(5, NULL, '9781260463415', 'Java: A Beginner\'s Guide (9th ed.)', 'Ce livre est une introduction complète au langage Java, abordant les bases de la syntaxe, les structures de contrôle, la POO et les nouvelles fonctionnalités de Java 17. Chaque chapitre comprend des exercices pratiques pour renforcer l\'apprentissage. Une ressource précieuse pour les débutants souhaitant apprendre Java de manière progressive et efficace.', 2022, NULL, '2025-03-05 10:20:46', '2025-03-05 10:20:46'),
(6, NULL, '9781484200773', 'Pro Git (2nd ed.)', 'Pro Git est un guide complet sur Git, expliquant son fonctionnement interne et ses meilleures pratiques. Il couvre les bases de la gestion de versions, la gestion avancée des branches, la collaboration avec GitHub, et l\'automatisation des workflows. Accessible aux débutants comme aux experts, ce livre aide à maîtriser Git pour des projets individuels ou en équipe, avec des exemples concrets et des explications claires.', 2014, NULL, '2025-03-05 10:20:46', '2025-03-05 10:20:46'),
(7, NULL, '9781492078005', 'Head First Design Patterns (2nd ed.)', 'Cet ouvrage rend les design patterns accessibles grâce à une approche pédagogique et interactive. Il explique comment appliquer les patterns de conception pour rendre le code plus flexible, réutilisable et maintenable. Une ressource essentielle pour les développeurs souhaitant améliorer leurs compétences en conception logicielle.', 2020, NULL, '2025-03-05 10:20:46', '2025-03-05 10:20:46'),
(8, NULL, '9781617292231', 'Grokking Algorithms', 'Un livre illustré et interactif qui explique les concepts clés des algorithmes de manière intuitive. Il aborde des notions comme le tri, la recherche, la récursivité et les graphes, en les rendant accessibles aux débutants. Idéal pour ceux qui veulent apprendre les algorithmes sans trop de formalismes mathématiques.', 2016, NULL, '2025-03-05 10:20:46', '2025-03-05 10:20:46'),
(9, NULL, '9781800568408', 'Large Scale Apps with Svelte and TypeScript', 'Un guide détaillé sur le développement d\'applications évolutives avec Svelte et TypeScript. Il couvre la structuration du code, la gestion des états et les meilleures pratiques pour construire des applications performantes et maintenables.', 2023, NULL, '2025-03-05 10:20:46', '2025-03-05 10:20:46'),
(10, NULL, '9781642002145', 'Svelte Succinctly', 'Un livre concis qui introduit Svelte, un framework JavaScript innovant. Il couvre les concepts fondamentaux comme les composants, la réactivité et la gestion des événements, permettant aux développeurs d\'exploiter pleinement Svelte pour créer des applications web modernes.', 2023, NULL, '2025-03-05 10:20:46', '2025-03-05 10:20:46'),
(11, NULL, '9781492057413', 'Python in a Nutshell (4th ed.)', 'Une mise à jour du guide de référence sur Python, intégrant les dernières évolutions du langage et des bibliothèques. Ce livre est conçu pour être une ressource incontournable pour les développeurs souhaitant une maîtrise approfondie de Python.', 2023, NULL, '2025-03-05 10:20:46', '2025-03-05 10:20:46'),
(12, NULL, '9781801816867', 'Learning DevOps (2nd ed.)', 'Une introduction aux concepts fondamentaux du DevOps, incluant l\'intégration et le déploiement continu, l\'automatisation des infrastructures et les conteneurs. Ce livre propose des études de cas et des exemples pratiques pour faciliter l\'apprentissage.', 2022, NULL, '2025-03-05 10:20:46', '2025-03-05 10:20:46'),
(13, NULL, '9781119790297', 'Cybersecurity for Dummies (2nd ed.)', 'Un guide simple et accessible pour comprendre les principes de la cybersécurité, les menaces courantes et les meilleures pratiques de protection. Il couvre également les concepts de cryptographie, de gestion des identités et de prévention des attaques.', 2022, NULL, '2025-03-05 10:20:46', '2025-03-05 10:20:46'),
(14, NULL, '9789355514582', 'Unlock PHP 8: From Basic to Advanced', 'Un livre qui couvre PHP 8 en profondeur, expliquant ses nouvelles fonctionnalités, ses performances améliorées et ses meilleures pratiques pour le développement web. Il offre un apprentissage progressif allant des bases aux concepts avancés.', 2024, NULL, '2025-03-05 10:20:46', '2025-03-05 10:20:46'),
(15, NULL, '9781492047117', 'Web Development with Node and Express (2nd ed.)', 'Un guide pratique pour apprendre à construire des applications web performantes avec Node.js et Express. Il couvre l\'authentification, les bases de données, la gestion des sessions et les API REST.', 2019, NULL, '2025-03-05 10:20:46', '2025-03-05 10:20:46');

-- --------------------------------------------------------

--
-- Structure de la table `book_author`
--

DROP TABLE IF EXISTS `book_author`;
CREATE TABLE IF NOT EXISTS `book_author` (
  `book_id` int NOT NULL,
  `author_id` int NOT NULL,
  PRIMARY KEY (`book_id`,`author_id`),
  KEY `fk_author_book_book_idx` (`book_id`),
  KEY `fk_author_book_author_idx` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `book_author`
--

INSERT INTO `book_author` (`book_id`, `author_id`) VALUES
(1, 1),
(2, 20),
(2, 21),
(2, 24),
(3, 5),
(3, 6),
(4, 7),
(5, 8),
(6, 22),
(6, 23),
(7, 10),
(7, 11),
(8, 12),
(9, 13),
(10, 14),
(11, 2),
(11, 3),
(11, 4),
(11, 15),
(12, 16),
(13, 17),
(14, 18),
(15, 19);

-- --------------------------------------------------------

--
-- Structure de la table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci PACK_KEYS=0;

--
-- Déchargement des données de la table `country`
--

INSERT INTO `country` (`id`, `code`, `name`) VALUES
(1, 'AF', 'AFGHANISTAN'),
(2, 'ZA', 'AFRIQUE DU SUD'),
(3, 'AX', 'ÅLAND, ÎLES'),
(4, 'AL', 'ALBANIE'),
(5, 'DZ', 'ALGÉRIE'),
(6, 'DE', 'ALLEMAGNE'),
(7, 'AD', 'ANDORRE'),
(8, 'AO', 'ANGOLA'),
(9, 'AI', 'ANGUILLA'),
(10, 'AQ', 'ANTARCTIQUE'),
(11, 'AG', 'ANTIGUA-ET-BARBUDA'),
(12, 'AN', 'ANTILLES NÉERLANDAISES'),
(13, 'SA', 'ARABIE SAOUDITE'),
(14, 'AR', 'ARGENTINE'),
(15, 'AM', 'ARMÉNIE'),
(16, 'AW', 'ARUBA'),
(17, 'AU', 'AUSTRALIE'),
(18, 'AT', 'AUTRICHE'),
(19, 'AZ', 'AZERBAÏDJAN'),
(20, 'BS', 'BAHAMAS'),
(21, 'BH', 'BAHREÏN'),
(22, 'BD', 'BANGLADESH'),
(23, 'BB', 'BARBADE'),
(24, 'BY', 'BÉLARUS'),
(25, 'BE', 'BELGIQUE'),
(26, 'BZ', 'BELIZE'),
(27, 'BJ', 'BÉNIN'),
(28, 'BM', 'BERMUDES'),
(29, 'BT', 'BHOUTAN'),
(30, 'BO', 'BOLIVIE'),
(31, 'BA', 'BOSNIE-HERZÉGOVINE'),
(32, 'BW', 'BOTSWANA'),
(33, 'BV', 'BOUVET, ÎLE'),
(34, 'BR', 'BRÉSIL'),
(35, 'BN', 'BRUNÉI DARUSSALAM'),
(36, 'BG', 'BULGARIE'),
(37, 'BF', 'BURKINA FASO'),
(38, 'BI', 'BURUNDI'),
(39, 'KY', 'CAÏMANES, ÎLES'),
(40, 'KH', 'CAMBODGE'),
(41, 'CM', 'CAMEROUN'),
(42, 'CA', 'CANADA'),
(43, 'CV', 'CAP-VERT'),
(44, 'CF', 'CENTRAFRICAINE, RÉPUBLIQUE'),
(45, 'CL', 'CHILI'),
(46, 'CN', 'CHINE'),
(47, 'CX', 'CHRISTMAS, ÎLE'),
(48, 'CY', 'CHYPRE'),
(49, 'CC', 'COCOS (KEELING), ÎLES'),
(50, 'CO', 'COLOMBIE'),
(51, 'KM', 'COMORES'),
(52, 'CG', 'CONGO'),
(53, 'CD', 'CONGO, LA RÉPUBLIQUE DÉMOCRATIQUE DU'),
(54, 'CK', 'COOK, ÎLES'),
(55, 'KR', 'CORÉE, RÉPUBLIQUE DE'),
(56, 'KP', 'CORÉE, RÉPUBLIQUE POPULAIRE DÉMOCRATIQUE DE'),
(57, 'CR', 'COSTA RICA'),
(58, 'CI', 'CÔTE D\'IVOIRE'),
(59, 'HR', 'CROATIE'),
(60, 'CU', 'CUBA'),
(61, 'DK', 'DANEMARK'),
(62, 'DJ', 'DJIBOUTI'),
(63, 'DO', 'DOMINICAINE, RÉPUBLIQUE'),
(64, 'DM', 'DOMINIQUE'),
(65, 'EG', 'ÉGYPTE'),
(66, 'SV', 'EL SALVADOR'),
(67, 'AE', 'ÉMIRATS ARABES UNIS'),
(68, 'EC', 'ÉQUATEUR'),
(69, 'ER', 'ÉRYTHRÉE'),
(70, 'ES', 'ESPAGNE'),
(71, 'EE', 'ESTONIE'),
(72, 'US', 'ÉTATS-UNIS'),
(73, 'ET', 'ÉTHIOPIE'),
(74, 'FK', 'FALKLAND, ÎLES (MALVINAS)'),
(75, 'FO', 'FÉROÉ, ÎLES'),
(76, 'FJ', 'FIDJI'),
(77, 'FI', 'FINLANDE'),
(78, 'FR', 'FRANCE'),
(79, 'GA', 'GABON'),
(80, 'GM', 'GAMBIE'),
(81, 'GE', 'GÉORGIE'),
(82, 'GS', 'GÉORGIE DU SUD ET LES ÎLES SANDWICH DU SUD'),
(83, 'GH', 'GHANA'),
(84, 'GI', 'GIBRALTAR'),
(85, 'GR', 'GRÈCE'),
(86, 'GD', 'GRENADE'),
(87, 'GL', 'GROENLAND'),
(88, 'GP', 'GUADELOUPE'),
(89, 'GU', 'GUAM'),
(90, 'GT', 'GUATEMALA'),
(91, 'GN', 'GUINÉE'),
(92, 'GW', 'GUINÉE-BISSAU'),
(93, 'GQ', 'GUINÉE ÉQUATORIALE'),
(94, 'GY', 'GUYANA'),
(95, 'GF', 'GUYANE FRANÇAISE'),
(96, 'HT', 'HAÏTI'),
(97, 'HM', 'HEARD, ÎLE ET MCDONALD, ÎLES'),
(98, 'HN', 'HONDURAS'),
(99, 'HK', 'HONG-KONG'),
(100, 'HU', 'HONGRIE'),
(101, 'UM', 'ÎLES MINEURES ÉLOIGNÉES DES ÉTATS-UNIS'),
(102, 'VG', 'ÎLES VIERGES BRITANNIQUES'),
(103, 'VI', 'ÎLES VIERGES DES ÉTATS-UNIS'),
(104, 'IN', 'INDE'),
(105, 'ID', 'INDONÉSIE'),
(106, 'IR', 'IRAN, RÉPUBLIQUE ISLAMIQUE D\''),
(107, 'IQ', 'IRAQ'),
(108, 'IE', 'IRLANDE'),
(109, 'IS', 'ISLANDE'),
(110, 'IL', 'ISRAËL'),
(111, 'IT', 'ITALIE'),
(112, 'JM', 'JAMAÏQUE'),
(113, 'JP', 'JAPON'),
(114, 'JO', 'JORDANIE'),
(115, 'KZ', 'KAZAKHSTAN'),
(116, 'KE', 'KENYA'),
(117, 'KG', 'KIRGHIZISTAN'),
(118, 'KI', 'KIRIBATI'),
(119, 'KW', 'KOWEÏT'),
(120, 'LA', 'LAO, RÉPUBLIQUE DÉMOCRATIQUE POPULAIRE'),
(121, 'LS', 'LESOTHO'),
(122, 'LV', 'LETTONIE'),
(123, 'LB', 'LIBAN'),
(124, 'LR', 'LIBÉRIA'),
(125, 'LY', 'LIBYENNE, JAMAHIRIYA ARABE'),
(126, 'LI', 'LIECHTENSTEIN'),
(127, 'LT', 'LITUANIE'),
(128, 'LU', 'LUXEMBOURG'),
(129, 'MO', 'MACAO'),
(130, 'MK', 'MACÉDOINE, L\'EX-RÉPUBLIQUE YOUGOSLAVE DE'),
(131, 'MG', 'MADAGASCAR'),
(132, 'MY', 'MALAISIE'),
(133, 'MW', 'MALAWI'),
(134, 'MV', 'MALDIVES'),
(135, 'ML', 'MALI'),
(136, 'MT', 'MALTE'),
(137, 'MP', 'MARIANNES DU NORD, ÎLES'),
(138, 'MA', 'MAROC'),
(139, 'MH', 'MARSHALL, ÎLES'),
(140, 'MQ', 'MARTINIQUE'),
(141, 'MU', 'MAURICE'),
(142, 'MR', 'MAURITANIE'),
(143, 'YT', 'MAYOTTE'),
(144, 'MX', 'MEXIQUE'),
(145, 'FM', 'MICRONÉSIE, ÉTATS FÉDÉRÉS DE'),
(146, 'MD', 'MOLDOVA, RÉPUBLIQUE DE'),
(147, 'MC', 'MONACO'),
(148, 'MN', 'MONGOLIE'),
(149, 'MS', 'MONTSERRAT'),
(150, 'MZ', 'MOZAMBIQUE'),
(151, 'MM', 'MYANMAR'),
(152, 'NA', 'NAMIBIE'),
(153, 'NR', 'NAURU'),
(154, 'NP', 'NÉPAL'),
(155, 'NI', 'NICARAGUA'),
(156, 'NE', 'NIGER'),
(157, 'NG', 'NIGÉRIA'),
(158, 'NU', 'NIUÉ'),
(159, 'NF', 'NORFOLK, ÎLE'),
(160, 'NO', 'NORVÈGE'),
(161, 'NC', 'NOUVELLE-CALÉDONIE'),
(162, 'NZ', 'NOUVELLE-ZÉLANDE'),
(163, 'IO', 'OCÉAN INDIEN, TERRITOIRE BRITANNIQUE DE L\''),
(164, 'OM', 'OMAN'),
(165, 'UG', 'OUGANDA'),
(166, 'UZ', 'OUZBÉKISTAN'),
(167, 'PK', 'PAKISTAN'),
(168, 'PW', 'PALAOS'),
(169, 'PS', 'PALESTINIEN OCCUPÉ, TERRITOIRE'),
(170, 'PA', 'PANAMA'),
(171, 'PG', 'PAPOUASIE-NOUVELLE-GUINÉE'),
(172, 'PY', 'PARAGUAY'),
(173, 'NL', 'PAYS-BAS'),
(174, 'PE', 'PÉROU'),
(175, 'PH', 'PHILIPPINES'),
(176, 'PN', 'PITCAIRN'),
(177, 'PL', 'POLOGNE'),
(178, 'PF', 'POLYNÉSIE FRANÇAISE'),
(179, 'PR', 'PORTO RICO'),
(180, 'PT', 'PORTUGAL'),
(181, 'QA', 'QATAR'),
(182, 'RE', 'RÉUNION'),
(183, 'RO', 'ROUMANIE'),
(184, 'GB', 'ROYAUME-UNI'),
(185, 'RU', 'RUSSIE, FÉDÉRATION DE'),
(186, 'RW', 'RWANDA'),
(187, 'EH', 'SAHARA OCCIDENTAL'),
(188, 'SH', 'SAINTE-HÉLÈNE'),
(189, 'LC', 'SAINTE-LUCIE'),
(190, 'KN', 'SAINT-KITTS-ET-NEVIS'),
(191, 'SM', 'SAINT-MARIN'),
(192, 'PM', 'SAINT-PIERRE-ET-MIQUELON'),
(193, 'VA', 'SAINT-SIÈGE (ÉTAT DE LA CITÉ DU VATICAN)'),
(194, 'VC', 'SAINT-VINCENT-ET-LES GRENADINES'),
(195, 'SB', 'SALOMON, ÎLES'),
(196, 'WS', 'SAMOA'),
(197, 'AS', 'SAMOA AMÉRICAINES'),
(198, 'ST', 'SAO TOMÉ-ET-PRINCIPE'),
(199, 'SN', 'SÉNÉGAL'),
(200, 'CS', 'SERBIE-ET-MONTÉNÉGRO'),
(201, 'SC', 'SEYCHELLES'),
(202, 'SL', 'SIERRA LEONE'),
(203, 'SG', 'SINGAPOUR'),
(204, 'SK', 'SLOVAQUIE'),
(205, 'SI', 'SLOVÉNIE'),
(206, 'SO', 'SOMALIE'),
(207, 'SD', 'SOUDAN'),
(208, 'LK', 'SRI LANKA'),
(209, 'SE', 'SUÈDE'),
(210, 'CH', 'SUISSE'),
(211, 'SR', 'SURINAME'),
(212, 'SJ', 'SVALBARD ET ÎLE JAN MAYEN'),
(213, 'SZ', 'SWAZILAND'),
(214, 'SY', 'SYRIENNE, RÉPUBLIQUE ARABE'),
(215, 'TJ', 'TADJIKISTAN'),
(216, 'TW', 'TAÏWAN, PROVINCE DE CHINE'),
(217, 'TZ', 'TANZANIE, RÉPUBLIQUE-UNIE DE'),
(218, 'TD', 'TCHAD'),
(219, 'CZ', 'TCHÈQUE, RÉPUBLIQUE'),
(220, 'TF', 'TERRES AUSTRALES FRANÇAISES'),
(221, 'TH', 'THAÏLANDE'),
(222, 'TL', 'TIMOR-LESTE'),
(223, 'TG', 'TOGO'),
(224, 'TK', 'TOKELAU'),
(225, 'TO', 'TONGA'),
(226, 'TT', 'TRINITÉ-ET-TOBAGO'),
(227, 'TN', 'TUNISIE'),
(228, 'TM', 'TURKMÉNISTAN'),
(229, 'TC', 'TURKS ET CAÏQUES, ÎLES'),
(230, 'TR', 'TURQUIE'),
(231, 'TV', 'TUVALU'),
(232, 'UA', 'UKRAINE'),
(233, 'UY', 'URUGUAY'),
(234, 'VU', 'VANUATU'),
(235, 'VE', 'VENEZUELA'),
(236, 'VN', 'VIET NAM'),
(237, 'WF', 'WALLIS ET FUTUNA'),
(238, 'YE', 'YÉMEN'),
(239, 'ZM', 'ZAMBIE'),
(240, 'ZW', 'ZIMBABWE'),
(241, 'NS', '(NON SPECIFIE)');

-- --------------------------------------------------------

--
-- Structure de la table `illustration`
--

DROP TABLE IF EXISTS `illustration`;
CREATE TABLE IF NOT EXISTS `illustration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `book_id` int NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Sans description',
  `filename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_cover` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_cover_book1_idx` (`book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci PACK_KEYS=0;

--
-- Déchargement des données de la table `illustration`
--

INSERT INTO `illustration` (`id`, `book_id`, `description`, `filename`, `is_cover`) VALUES
(1, 1, '', '67d44a912e0a5_JavaScript - The Definitive Guide (7th ed.).jpg', 1),
(2, 2, '', '67d44ae79e7c5_Machine Learning with {PyTorch} and {Scikit-Learn}.jpg', 1),
(3, 3, '', '67d44af6bbc4e_Learning React (2nd ed.).jpg', 1),
(4, 4, '', '67d44b059f08a_Fluent Python (2nd ed.).jpg', 1),
(5, 5, '', '67d44b30753e4_Java: A Beginner\'s Guide (9th ed.).jpg', 1),
(6, 6, '', '67d44b414af99_Pro Git (2nd ed.).jpg', 1),
(7, 7, '', '67d44b515529f_Head First Design Patterns (2nd ed.).jpg', 1),
(8, 8, '', '67d44b8504736_Grokking Algorithms.jpg', 1),
(9, 9, '', '67d44b96d4729_Large Scale Apps with Svelte and TypeScript.jpg', 1),
(10, 10, '', '67d44bab9b088_Svelte Succinctly.jpg', 1),
(11, 11, '', '67d44bbb132f1_Python in a Nutshell (4th ed.).jpg', 1),
(12, 12, '', '67d44bce661d1_Learning DevOps (2nd ed.).jpg', 1),
(13, 13, '', '67d44bdd90c71_Cybersecurity for Dummies (2nd ed.).jpg', 1),
(14, 14, '', '67d44bed077e5_Unlock PHP 8: From Basic to Advanced.jpg', 1),
(15, 15, '', '67d44bfcdbf0f_Web Development with Node and Express (2nd ed.).jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rank_UNIQUE` (`rank`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci PACK_KEYS=0;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `last_name`, `first_name`, `birth_date`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Doe', 'John', '2001-06-12', 'john.doe@mailbox.com', '$2y$10$0Atb..mXEynuYGnya1Ouwu1nmMJ1b1svyVbSOVZaWPiYqOF.oZXra', '2025-03-19 08:39:12', '2025-03-19 08:39:12');

-- --------------------------------------------------------

--
-- Structure de la table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `user_id` int NOT NULL,
  `role_id` int NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_user_role_role_idx` (`role_id`) USING BTREE,
  KEY `fk_user_role_user_idx` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `fk_book_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `book_author`
--
ALTER TABLE `book_author`
  ADD CONSTRAINT `fk_author_book_author` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`),
  ADD CONSTRAINT `fk_author_book_book` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`);

--
-- Contraintes pour la table `illustration`
--
ALTER TABLE `illustration`
  ADD CONSTRAINT `fk_cover_book1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`);

--
-- Contraintes pour la table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `fk_user_has_role_role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `fk_user_has_role_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
