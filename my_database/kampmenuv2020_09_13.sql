-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 13 sep 2020 om 17:18
-- Serverversie: 10.1.32-MariaDB
-- PHP-versie: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kampmenu`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `camp`
--

CREATE TABLE `camp` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `nr_of_participants` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `camp`
--

INSERT INTO `camp` (`id`, `user_id`, `name`, `start_time`, `end_time`, `nr_of_participants`) VALUES
(38, 22, 'het allerleukste kamp ooit', '2020-03-09 10:00:00', '2020-03-11 16:00:00', 30),
(39, 22, 'het kamp van het heden', '2020-02-03 10:00:00', '2020-02-10 18:00:00', 100),
(40, 22, 'een heel kort kampje', '2020-02-03 12:00:00', '2020-02-05 15:00:00', 10),
(41, 22, 'boskamp', '2022-02-02 02:02:00', '2022-03-03 01:01:00', 20),
(42, 21, 'pok po pmak', '2020-02-17 16:00:00', '2020-02-21 14:00:00', 41),
(43, 49, 'Chiro Gerboda', '2020-07-11 09:00:00', '2020-07-21 17:00:00', 100),
(44, 22, 'Feliciens Camp', '2020-02-17 16:00:00', '2020-02-20 10:00:00', 10),
(45, 22, 'test', '2020-02-19 10:00:00', '2020-02-23 16:00:00', 15),
(46, 22, 'volgend kamp', '2020-02-24 16:00:00', '2020-02-28 10:00:00', 30),
(47, 22, 'test', '2010-01-01 01:01:00', '2010-01-02 01:01:00', 10),
(48, 22, 'test', '2020-02-20 01:00:00', '2020-02-21 03:00:00', 10),
(49, 22, 'test', '2020-01-01 10:00:00', '2020-01-01 20:00:00', 10),
(50, 22, 'kdfmsq', '2020-01-10 10:00:00', '2020-01-20 10:00:00', 10),
(51, 22, 'Berk Yates', '2020-04-25 17:00:00', '2020-04-25 17:48:00', 57),
(52, 22, 'test', '2020-01-10 10:00:00', '2020-02-10 10:00:00', 10),
(53, 22, 'test', '2020-12-01 10:00:00', '2020-12-03 10:00:00', 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `campday`
--

CREATE TABLE `campday` (
  `id` int(11) NOT NULL,
  `camp_id` int(11) NOT NULL,
  `campdaycount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `campday`
--

INSERT INTO `campday` (`id`, `camp_id`, `campdaycount`) VALUES
(117, 38, 0),
(118, 38, 1),
(119, 38, 2),
(120, 39, 0),
(121, 39, 1),
(122, 39, 2),
(123, 39, 3),
(124, 39, 4),
(125, 39, 5),
(126, 39, 6),
(127, 39, 7),
(128, 40, 0),
(129, 40, 1),
(130, 40, 2),
(131, 41, 0),
(132, 41, 1),
(133, 41, 2),
(134, 41, 3),
(135, 41, 4),
(136, 41, 5),
(137, 41, 6),
(138, 41, 7),
(139, 41, 8),
(140, 41, 9),
(141, 41, 10),
(142, 41, 11),
(143, 41, 12),
(144, 41, 13),
(145, 41, 14),
(146, 41, 15),
(147, 41, 16),
(148, 41, 17),
(149, 41, 18),
(150, 41, 19),
(151, 41, 20),
(152, 41, 21),
(153, 41, 22),
(154, 41, 23),
(155, 41, 24),
(156, 41, 25),
(157, 41, 26),
(158, 41, 27),
(159, 41, 28),
(160, 41, 29),
(161, 42, 0),
(162, 42, 1),
(163, 42, 2),
(164, 42, 3),
(165, 42, 4),
(166, 43, 0),
(167, 43, 1),
(168, 43, 2),
(169, 43, 3),
(170, 43, 4),
(171, 43, 5),
(172, 43, 6),
(173, 43, 7),
(174, 43, 8),
(175, 43, 9),
(176, 43, 10),
(177, 44, 0),
(178, 44, 1),
(179, 44, 2),
(180, 44, 3),
(181, 45, 0),
(182, 45, 1),
(183, 45, 2),
(184, 45, 3),
(185, 45, 4),
(186, 46, 0),
(187, 46, 1),
(188, 46, 2),
(189, 46, 3),
(190, 46, 4),
(191, 47, 0),
(192, 47, 1),
(193, 48, 0),
(194, 48, 1),
(195, 49, 0),
(196, 50, 0),
(197, 50, 1),
(198, 50, 2),
(199, 50, 3),
(200, 50, 4),
(201, 50, 5),
(202, 50, 6),
(203, 50, 7),
(204, 50, 8),
(205, 50, 9),
(206, 50, 10),
(207, 51, 0),
(208, 52, 0),
(209, 52, 1),
(210, 52, 2),
(211, 52, 3),
(212, 52, 4),
(213, 52, 5),
(214, 52, 6),
(215, 52, 7),
(216, 52, 8),
(217, 52, 9),
(218, 52, 10),
(219, 52, 11),
(220, 52, 12),
(221, 52, 13),
(222, 52, 14),
(223, 52, 15),
(224, 52, 16),
(225, 52, 17),
(226, 52, 18),
(227, 52, 19),
(228, 52, 20),
(229, 52, 21),
(230, 52, 22),
(231, 52, 23),
(232, 52, 24),
(233, 52, 25),
(234, 52, 26),
(235, 52, 27),
(236, 52, 28),
(237, 52, 29),
(238, 52, 30),
(239, 52, 31),
(240, 53, 0),
(241, 53, 1),
(242, 53, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `campmeal`
--

CREATE TABLE `campmeal` (
  `id` int(11) NOT NULL,
  `camp_mealmoment_id` int(11) NOT NULL,
  `campday_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `campmeal`
--

INSERT INTO `campmeal` (`id`, `camp_mealmoment_id`, `campday_id`, `name`) VALUES
(1, 36, 117, 'fishticks met warmoespurree'),
(2, 36, 118, 'Worst, Appelmoes en Patatten'),
(3, 37, 118, 'pannenkoeken'),
(4, 43, 128, 'hete bliksem'),
(5, 42, 129, 'basisontbijt'),
(6, 42, 130, 'basisontbijt'),
(7, 44, 128, 'boterhammen en courgettesoep'),
(8, 43, 129, 'spaghetti en appel'),
(9, 43, 130, 'wraps met tabouleh'),
(10, 44, 129, 'Chicken Lice'),
(11, 40, 122, 'test1'),
(12, 36, 119, 'aardappelen in de oven'),
(13, 40, 123, 'nog een test'),
(14, 46, 131, 'kristof'),
(15, 48, 162, 'spaghetti'),
(16, 41, 124, 'soep met brood'),
(17, 38, 118, 'vogelnestjes met aardappelen'),
(18, 51, 166, 'Tienuurtje 11.07'),
(19, 52, 166, 'Middag 11.07'),
(20, 56, 179, 'spagh'),
(21, 56, 178, 'some random'),
(22, 58, 182, 'eerste'),
(23, 39, 127, 'dfhkql'),
(24, 37, 117, 'yoghurtje'),
(25, 35, 119, 'test'),
(26, 55, 178, 'test');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `camp_mealmoments`
--

CREATE TABLE `camp_mealmoments` (
  `id` int(11) NOT NULL,
  `camp_id` int(11) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `mealmoment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `camp_mealmoments`
--

INSERT INTO `camp_mealmoments` (`id`, `camp_id`, `time`, `mealmoment_id`) VALUES
(35, 38, 480, 1),
(36, 38, 720, 4),
(37, 38, 960, 5),
(38, 38, 1110, 6),
(39, 39, 480, 1),
(40, 39, 720, 4),
(41, 39, 1080, 6),
(42, 40, 480, 1),
(43, 40, 720, 4),
(44, 40, 1080, 6),
(45, 41, 420, 1),
(46, 41, 780, 4),
(47, 42, 480, 1),
(48, 42, 720, 4),
(49, 42, 1080, 6),
(50, 43, 480, 1),
(51, 43, 600, 2),
(52, 43, 720, 4),
(53, 43, 960, 5),
(54, 43, 1080, 6),
(55, 44, 540, 1),
(56, 44, 780, 4),
(57, 45, 540, 1),
(58, 45, 720, 4),
(59, 45, 1080, 6),
(60, 46, 480, 1),
(61, 46, 720, 4),
(62, 46, 960, 5),
(63, 46, 1110, 6),
(64, 47, 600, 1),
(65, 48, 600, 4),
(66, 49, 720, 4),
(67, 50, 600, 1),
(68, 50, 720, 4),
(69, 51, 720, 4),
(70, 52, 720, 4),
(71, 53, 600, 1),
(72, 53, 720, 4);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `herb`
--

CREATE TABLE `herb` (
  `id` int(11) NOT NULL,
  `name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `herb`
--

INSERT INTO `herb` (`id`, `name`) VALUES
(1, 'basilicum'),
(4, 'bieslook'),
(5, 'cayennepeper'),
(6, 'chilipeper'),
(7, 'citroenmelisse'),
(30, 'currypoeder'),
(8, 'dille'),
(9, 'dragon'),
(10, 'gember'),
(11, 'kaneel'),
(12, 'kardemon'),
(13, 'knoflookpoeder'),
(15, 'komijnzaad'),
(16, 'koriander'),
(14, 'kruidnagel'),
(19, 'kurkumma'),
(20, 'marjolein'),
(21, 'nootmuskaat'),
(33, 'olijfolie'),
(22, 'oregano'),
(23, 'paprikapoeder'),
(2, 'peper'),
(24, 'peterselie (gedroogd)'),
(25, 'rozemarijn'),
(26, 'salie'),
(40, 'sml'),
(32, 'spaghettikruiden'),
(31, 'speculaaskruiden'),
(27, 'steranijs'),
(34, 'test'),
(35, 'test1'),
(38, 'test4'),
(36, 'test5'),
(28, 'tijm'),
(3, 'zout');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ingredient`
--

CREATE TABLE `ingredient` (
  `id` int(11) NOT NULL,
  `name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suggestion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rayon_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ingredient`
--

INSERT INTO `ingredient` (`id`, `name`, `suggestion`, `rayon_id`, `unit_id`) VALUES
(17, 'melk', NULL, 12, 6),
(18, 'yoghurt', NULL, 12, 6),
(19, 'sla', NULL, 14, 2),
(20, 'bloemkool', '', 14, 5),
(21, 'appel', '1 appel weegt gemiddeld 200 gram', 26, 5),
(22, 'paprika', NULL, 14, 5),
(23, 'witte kool', NULL, 14, 5),
(24, 'tomaten', NULL, 14, 5),
(25, 'komkommer', NULL, 14, 5),
(26, 'rode biet', NULL, 14, 5),
(27, 'prei', NULL, 14, 5),
(28, 'citroen', NULL, 26, 5),
(29, 'koolrabi', NULL, 14, 5),
(30, 'sjalot', NULL, 14, 5),
(31, 'broccoli', NULL, 14, 5),
(33, 'wortel', '1 wortel weegt gemiddeld 100 gram', 14, 1),
(34, 'courgette', '1 courgette weegt gemiddeld 300 gram', 14, 1),
(35, 'boontjes', NULL, 14, 1),
(36, 'warmoes', NULL, 14, 1),
(37, 'champignon', NULL, 14, 1),
(39, 'pruim', NULL, 26, 5),
(40, 'verse munt', NULL, 40, 3),
(41, 'ei', NULL, 25, 5),
(42, 'ananas in blik', NULL, 22, 4),
(43, 'lasagnevellen', NULL, 21, 5),
(44, 'wraps', NULL, 21, 5),
(45, 'aardappel', '', 25, 1),
(46, 'rijst', NULL, 21, 1),
(47, 'passata', NULL, 22, 6),
(48, 'pasta', NULL, 21, 1),
(49, 'mayonaise', NULL, 22, 6),
(50, 'augurken', NULL, 22, 1),
(51, 'rozijnen', NULL, 25, 1),
(52, 'couscous', NULL, 21, 1),
(53, 'gepelde tomaten (blokjes) in blik', NULL, 22, 1),
(54, 'gepelde tomaten in blik', NULL, 22, 1),
(55, 'fishticks', NULL, 23, 5),
(57, 'chocolade (melk)', NULL, 20, 1),
(58, 'chocolade (wit)', NULL, 20, 1),
(59, 'chocolade (fondant)', NULL, 20, 1),
(60, 'speculoos', NULL, 20, 1),
(61, 'chocoladedruppels (fondant)', NULL, 20, 1),
(62, 'chocoladedruppels (melk)', NULL, 20, 1),
(63, 'bruin brood (groot)', NULL, 15, 5),
(64, 'wit brood (groot)', NULL, 15, 5),
(65, 'mozzerella', NULL, 12, 7),
(66, 'koffie', NULL, 24, 1),
(67, 'water', NULL, 24, 6),
(68, 'verse gist', NULL, 34, 1),
(69, 'honing', NULL, 16, 6),
(70, 'bakboter', NULL, 12, 1),
(71, 'melkerijboter of roomboter', NULL, 12, 1),
(72, 'gemalen kaas', NULL, 12, 1),
(73, 'room', NULL, 12, 6),
(74, 'fetakaas', NULL, 12, 1),
(75, 'kaas (schelletjes)', 'een schelletje kaas is ongeveer 15 gram', 12, 1),
(76, 'worst', NULL, 13, 5),
(77, 'bouillonblokje', NULL, 25, 5),
(78, 'bloem', NULL, 34, 1),
(79, 'gehakt', NULL, 13, 1),
(80, 'ajuin', NULL, 14, 5),
(81, 'kipfilet', NULL, 13, 5),
(82, 'varkenslapje', NULL, 13, 5),
(83, 'bieslook (verse)', NULL, 14, 3),
(84, 'peterselie (verse)', NULL, 14, 3),
(85, 'lente-uien', NULL, 14, 3),
(86, 'munt (verse)', '', 14, 3),
(87, 'rode ui', NULL, 14, 5),
(88, 'peer', 'test', 26, 5),
(89, 'aardbeien', NULL, 26, 1),
(90, 'pompoen', NULL, 14, 1),
(91, 'look', NULL, 40, 10),
(92, 'kristalsuiker', NULL, 34, 1),
(93, 'vanillesuiker', NULL, 34, 11),
(94, 'pastinaak', NULL, 14, 1),
(95, 'test', NULL, 25, 4),
(96, 'choco', NULL, 16, 1),
(97, 'confituur', NULL, 16, 1),
(98, 'banaan', NULL, 26, 5),
(99, 'druif', NULL, 26, 1),
(100, 'salami', NULL, 13, 1),
(101, 'hespeworst', NULL, 13, 1),
(102, 'paneermeel', NULL, 21, 1),
(103, 'bloemsuiker', NULL, 34, 1),
(104, 'aardbeiden', NULL, 26, 1),
(105, 'test4', NULL, 15, 7);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `mealcourse`
--

CREATE TABLE `mealcourse` (
  `id` int(11) NOT NULL,
  `campmeal_id` int(11) NOT NULL,
  `recipe_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `mealcourse`
--

INSERT INTO `mealcourse` (`id`, `campmeal_id`, `recipe_id`) VALUES
(1, 1, 15),
(2, 1, 14),
(3, 2, 3),
(4, 3, 18),
(5, 4, 4),
(6, 5, 21),
(7, 6, 21),
(8, 7, 22),
(9, 7, 23),
(10, 8, 25),
(11, 8, 10),
(12, 9, 8),
(13, 9, 12),
(14, 10, 6),
(15, 11, 16),
(16, 12, 16),
(17, 13, 25),
(18, 13, 15),
(19, 14, 22),
(20, 14, 15),
(21, 15, 10),
(22, 16, 22),
(23, 16, 23),
(24, 17, 16),
(25, 17, 26),
(26, 18, 25),
(27, 19, 10),
(28, 20, 10),
(29, 21, 16),
(30, 21, 13),
(31, 21, 21),
(32, 22, 16),
(33, 23, 13),
(34, 23, 21),
(35, 24, 27),
(36, 25, 16),
(37, 26, 16),
(38, 26, 13);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `mealmoment`
--

CREATE TABLE `mealmoment` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `mealmoment`
--

INSERT INTO `mealmoment` (`id`, `name`) VALUES
(1, 'ontbijt'),
(2, 'tienuurtje'),
(4, 'middagmaal'),
(5, 'vieruurtje'),
(6, 'avondmaal'),
(7, 'avondsnack');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20191210140026', '2019-12-10 14:54:23'),
('20191210145806', '2019-12-10 15:01:30'),
('20191211100413', '2019-12-11 10:04:46'),
('20191211105345', '2019-12-11 10:54:14'),
('20191211111004', '2019-12-11 11:10:47'),
('20191211111543', '2019-12-11 11:16:02'),
('20191212141928', '2019-12-12 14:20:26'),
('20191213083123', '2019-12-13 08:32:00'),
('20191213142542', '2019-12-13 14:25:53'),
('20191216193615', '2019-12-16 19:36:33'),
('20191217124545', '2019-12-17 12:45:54'),
('20191218083005', '2019-12-18 08:30:17'),
('20191218090509', '2019-12-18 09:05:18'),
('20191218145645', '2019-12-18 14:57:01'),
('20191222115205', '2019-12-22 11:52:18'),
('20191222115645', '2019-12-22 11:56:54'),
('20191222125759', '2019-12-22 12:58:05'),
('20200106133203', '2020-01-06 13:32:20'),
('20200106135116', '2020-01-06 13:51:28'),
('20200114142911', '2020-01-14 14:29:25'),
('20200115145938', '2020-01-15 14:59:46'),
('20200116103020', '2020-01-16 10:30:34'),
('20200116103408', '2020-01-16 10:34:21'),
('20200116104012', '2020-01-16 10:40:33'),
('20200116104334', '2020-01-16 10:43:56'),
('20200120152811', '2020-01-20 15:28:22'),
('20200422164614', '2020-04-22 16:46:27');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rayon`
--

CREATE TABLE `rayon` (
  `id` int(11) NOT NULL,
  `name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `rayon`
--

INSERT INTO `rayon` (`id`, `name`) VALUES
(93, 'aa'),
(25, 'andere'),
(34, 'bakken'),
(15, 'brood'),
(17, 'chips/borrelhapjes'),
(22, 'conserven en sauzen'),
(23, 'diepvries'),
(24, 'dranken'),
(21, 'droge voeding'),
(26, 'fruit'),
(69, 'fs'),
(45, 'fzm'),
(14, 'groenten'),
(46, 'hjl'),
(47, 'jjl'),
(20, 'koekjes/chocolade/snoep'),
(16, 'ontbijt'),
(95, 'rgz'),
(92, 'sgd'),
(41, 'test'),
(43, 'test2'),
(44, 'test3'),
(18, 'vegetarische producten'),
(40, 'verse kruiden'),
(19, 'vis'),
(13, 'vlees'),
(57, 'zkla'),
(12, 'zuivel');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructions` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `suggestion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `recipes`
--

INSERT INTO `recipes` (`id`, `name`, `instructions`, `suggestion`, `type_id`, `category_id`) VALUES
(3, 'WAP', 'Breng gezouten water aan de kook. \nSchil de aardappelen, snij ze in kleinere stukken indien nodig, kook ze gaar en giet ze af (zodra ze gaar zijn, want de aardappelen koken verder zo lang ze in het water zitten). \nSchil de appels, snij ze in stukjes en zet ze in een pot op het vuur. Voeg kaneel en eventueel wat suiker toe. Wanneer de appels gaar zijn kan je ze indien gewenst mixen.\nBak de worsten en de vleesvervangers in de pan of in de oven. Kruid deze met wat peper en zout.\n', NULL, 3, 6),
(4, 'hete bliksem', 'Breng gezouten water aan de kook. \nSchil de aardappelen, snij ze in stukjes en kook ze gaar. \nGiet de aardappelen af en laat ze even uitdampen. Doe ze terug in de pot en pureer ze samen met de boter, melk, eieren, nootmuskaat, peper en zout. \nSchil de appels, snij ze in stukjes en zet ze in een pot op het vuur. Voeg kaneel en eventueel wat suiker toe. Wanneer de appels gaar zijn kan je ze indien gewenst mixen.\nBak het gehakt, eventueel met een ajuin, en kruid het met peper en zout. \nNu kan je alles in laagjes in de ovenschotel doen. Begin met het gehakt in de schotel te doen, gevolgd door de appelmoes en dan de puree (de appelmoes zeker niet bovenaan gezien dit begint te spatten als het warm heeft). Strooi kaas op de bovenkant en plaats het voor enkele minuten onder de grill in de oven.                                                                                                                                                                                                                                                                                                                                                                                                             ', 'je kan suiker toevoegen aan de appelmoes', 3, 6),
(6, 'kip met rijst, currysaus en groentjes ', 'Breng het water (eventueel met de bouillon) aan de kook. Wanneer het kookt kan je de rijst toevoegen. Roer meteen eens zodat het niet kleeft en roer tijdens het koken af en toe, zeker op het einde. \nRijst brandt snel aan, zet naar het einde toe het vuur wat lager.\nMaak de groenten schoon en snij ze indien nodig.\nStoof eventueel een ajuin aan in wat olijfolie en voeg de groenten toe. Laat ze garen op een niet te hoog vuur om aanbranden te voorkomen. \nBak de lapjes in de pan of in de oven en kruid ze met peper en zout. \nVoor de currysaus start je met het smelten van de boter op een laag vuur of het opwarmen van de olie. Voeg dan de bloem toe. Nu krijg je een soort papje. Haal de pot van het vuur en voeg al roerend de melk toe. Zet de pot terug op het vuur, laat het verwarmen en voeg dan de curry toe. Laat de saus al roerend indikken. Voeg eventueel nog peper en zout toe naar smaak.\nVoeg de ananas toe aan de saus. Smakelijk!                                                ', NULL, 11, 6),
(7, 'lasagne', 'Begin voor de spaghettisaus met het snijden en aanstoven van de ajuinen in wat olijfolie. Was alle groenten, snij ze en voeg ze bij de ajuinen (begin met de hardste groenten en eindig met de zachtste).  Doe de passata erbij en laat even sudderen. \nBak het vlees in een aparte pan en kruid het. Doe het vlees bij de saus. Voeg nu de kruiden toe. Je kan de saus eventueel mixen.\nVoor de kaassaus start je met de boter op een laag vuurtje te smelten of de olie op te warmen. Voeg dan de bloem toe. Nu krijg je een soort papje. Haal de pot van het vuur en voeg al roerend de melk toe. Zet de pot terug op het vuur, laat het verwarmen en voeg dan de kaas toe. Laat de saus al roerend indikken. Voeg peper, zout en nootmuskaat toe naar smaak.\nNu de sauzen klaar zijn kan je de lasagne beginnen ‘opbouwen’. Begin met een laag spaghettisaus en leg hier een eerste laag lasagnevellen op. Giet hier kaassaus op en bedek het opnieuw met lasagnevellen, vervolg terug met spaghettisaus, enzoverder. \nStrooi de gemalen kaas erbovenop en plaats de lasagne voor 30 minuten in een voorverwarmde oven van 180°C. Smakelijk!', NULL, 10, 6),
(8, 'tabouleh', 'Schil en halveer de komkommer, verwijder de pitjes en snij het vruchtvlees in blokjes. Ontpit de tomaten en snij ze in blokjes. Snij de lente-uitjes in dunne ringetjes. Verkruimel de feta.\nBreng de bouillon aan de kook. Doe de couscous in een schaal en schenk er de bouillon over. Laat afgedekt wellen, volgens de aanwijzingen op de verpakking. Maak de korrels los met een vork. Voeg een scheutje olijfolie toe.\nMaak de wortelen en courgette schoon. Snij ze in stukjes. Spoel met koud water en laat uitlekken.\nMeng de groenten met de tomaten, komkommer, rode ui, lente-uitjes, feta, peterselie en munt door de couscous. Breng op smaak met citroensap, peper en zout.                ', 'Er zijn veel variaties mogelijk', 7, 4),
(9, 'Macaroni met champignons en prei', 'Maak de champignons schoon (niet onder water, want dit slorpen ze op) en snij ze in stukken. Was de preistronken (snij het groene deel in twee en was het zand er zo uit) en snij deze ook in stukken. \nBreng water aan de kook voor de pasta. Als je een grote hoeveelheid moet maken, zorg dan dat je voldoende op voorhand water opzet en de pasta kookt. \nStoof de groenten aan in een beetje olijfolie. \nDoe de pasta in het kokende water (roer meteen zodat de pasta niet plakt), laat ze gaar koken en giet ze af. Laat (warm) water over de pasta stromen om plakken te voorkomen (olie erdoor roeren is minder effectief en minder gezond).\nVoor de saus start je met de boter op een laag vuurtje te smelten of de olie op te warmen. Voeg dan de bloem toe. Nu krijg je een soort papje. Haal de pot van het vuur en voeg al roerend de melk toe. Zet de pot terug op het vuur, laat het verwarmen en voeg dan de kaas toe. Laat de saus al roerend indikken. Voeg peper, zout en nootmuskaat toe naar smaak.\nVoeg de groenten toe aan de saus en meng.\nVoeg de saus met de groenten toe aan de pasta. Je kan eventueel de pasta in een ovenschotel doen, er kaas over strooien en het in de oven steken zodat het een lekker kaaskorstje krijgt.\nSmakelijk! ', NULL, 10, 6),
(10, 'Spaghetti', 'Snij de ajuinen en stoof ze aan in wat olijfolie. \nWas alle groenten, snij ze en voeg ze toe (de harde groenten eerst, de zachte laatst)\nDoe de passata erbij en laat even sudderen. \nBak het vlees in een pan en kruid het. Voeg het toe aan de saus. \nDoe er nu alle kruiden bij. Mix de saus indien gewenst.\nBreng water aan de kook en voeg de spaghettislierten toe. Roer af en toe in de pot zodat de slierten niet kleven.\nWanneer de spaghetti gaar is, giet ze dan af en spoel ze met (warm) water om het kleven tegen te gaan (olie is minder effectief). \nDe gemalen kaas kan je als afwerking op de bordjes strooien.\nSmakelijk!', NULL, 10, 6),
(11, 'Wok met rijst', 'Snij de ajuinen en stoof ze aan in een beetje olijfolie.\nWas de andere groenten en snij ze in fijne stukjes. Voeg eerst de hardere groenten toe en dan de zachtere. Voeg de kruiden toe.\nSnij de lapjes in reepjes en bak deze. Voeg kruiden toe naar smaak. Doe de reepjes bij de groenten.\nBreng water (met bouillon) aan de kook. Als je voor rijst kiest kook deze dan (kijk op de verpakking om te weten hoe lang). Als je voor couscous kiest dan moet je het kokend water over de couscous gieten en het laten opzwellen (dus niet laten koken). Je kan wat boter toevoegen aan de couscous voor de smaak.\nSmakelijk!       ', 'je kan dit ook met couscous maken ipv rijst', 11, 6),
(12, 'Wraps met gehakt en rauwe groenten', 'Warm de wraps op in de oven (kijk op de verpakking op hoeveel graden en voor hoe lang).\nWas alle groenten en snij ze. Als je rode biet gebruikt kan je deze eerst koken.\nBak het gehakt en kruid het.\n ', 'je kan hier aardappelsla of tabouleh bij serveren', 8, 6),
(13, 'Aardappelsla ', '                                                                                                Schil de aardappelen en snij ze in kleinere stukken.\nBreng water aan de kook en kook de aardappelen gaar.\nLaar ze afkoelen en voeg de mayonaise en kruiden toe en fijngesneden augurken.\n                                                                                                                                                            ', NULL, 3, 4),
(14, 'Warmoespuree', 'Breng water aan de kook. Schil de aardappelen, snij ze in stukken en kook ze gaar.\nGiet de aardappelen af en laat ze even uitdampen. Doe ze terug in de pot en pureer ze samen met de boter, melk, eieren, nootmuskaat, peper en zout. \nWas de warmoes en snij ze wat fijner. Stoof de warmoes aan in een kleine hoeveelheid olijfolie (eventueel met wat water bij) totdat ze gekrompen is. \nDoe de gestoofde warmoes bij de puree en stamp nog eens alles goed door elkaar. Proef nog eens en voeg indien gewenst nog wat kruiden toe.        ', 'lekker met fishticks en zelf gemaakte tartaar', 3, 4),
(15, 'fishsticks en zelfgemaakte tartaar', 'Bak de fishsticks in de pan of in de oven. \nOm de tartaar te maken, moet je de augurken, de sjalot of kleine ajuin en de kruiden heel fijn snijden. Voeg deze bij de mayonaise en voeg zout en peper toe.\n                        ', 'lekker met warmoespurree', 14, 4),
(16, 'aardappelen met kruiden in de oven', '                                                Snij de aardappelen in stukken (je kan ze schillen indien gewenst).\nHak de kruiden fijn. \nGiet wat olie in de ovenschotel en doe de aardappelen erin en meng ze met de kruiden en de olijfolie. \nVerwarm de oven voor op 150°C. Plaats de schotel in de oven voor 50 à 60 minuten. Draai ze tussendoor af en toe om zodat ze niet aanbranden.\n                                                ', NULL, 3, 4),
(17, 'tzatziki', 'Was de komkommers en rasp ze. Knijp de geraspte komkommers uit zodat het meeste vocht eruit is.\nMeng dit met de yoghurt en laat het een half uurtje in de koelkast staan.\nBreng dan op smaak met fijngehakte munt, peper en zout. Smakelijk!                                                ', NULL, 8, 4),
(18, 'pannenkoeken', 'Voeg de eieren bij de melk en klop ze los\nNu mag de bloem erbij, meng het er goed onder zodat je geen brokken hebt. Doe nu de vanillesuiker erbij\nRoer de gesmolten boter er onder\nBakken maar en smakelijk!\nKoken maar!                ', 'dit recept is voor 2 pannenkoeken per persoon', 16, 5),
(19, 'koekjes', '                Meng de boter met de suiker tot een glad mengsel. Voeg de eieren toe en zeef de bloem erbij. Meng alles goed en kneed tot een deegbal. \nMaak een worst van het deeg en wikkel het in plastic folie en laat het 30 minuten in de koelkast afkoelen.\nNa 30 minuten kan je de worst in schijfjes snijden of je kan samen met de kinderen vormpjes uit het deeg maken.\nBak de koekjes 12 à 15 minuten in een voorverwarmde oven van 180°C.\nSmakelijk!                                                                                                                ', 'ongeveer 3 koekjes per persoon', 16, 5),
(20, 'pastinaakpuree', 'Schil de pastinaken en snij ze in stukken. \nBreng water aan de kook en kook de pastinaken gaar. Giet ze af en laat ze eventjes uitdampen.\nVoeg de boter, melk, nootmuskaat, peper en zout toe en mix. Smakelijk!\n                   ', NULL, 8, 4),
(21, 'basisontbijt', '                                                                                                ', NULL, 6, 14),
(22, 'basisbroodmaaltijd met kaas', '                                ', 'voeg nog ander beleg toe aan dit recept om een volwaardige broodmaaltijd te hebben', 6, 14),
(23, 'courgettesoep', '                                ', NULL, 12, 4),
(24, 'wortelsoep', '                                ', NULL, 12, 4),
(25, 'appel', '                                                                                                ', NULL, 18, 5),
(26, 'vogelnestjes', 'Kook de eieren gedurende 10 minuten. Laat schrikken in koud water. Pel de eieren.\n\nMeng het gehakt met het paneermeel en de eidooier, en kruid af met peper en zout.\n\nVerdeel het gehakt in 4 bollen, duw een putje in de bol en leg daarin een ei. Verdeel dan het gehakt verder rond het ei. Je pakt het eitje als het ware in met het gehakt.\n\n1ste manier:\nBak de vogelnesten rondom goudbruin in een klontje boter in de pan.\nVoeg de tomatensaus toe aan de vogelnestjes en in een voorverwarmde oven op 190°C gedurende 25 minuten.\n\n2de manier: \nOf bak de rauwe vogelnestjes gaar in hete frituurolie van 180°C.\nLaat ze nadien uitlekken en snijd ze overlangs in tweeën.\nWarm de tomatensaus op en serveer bij de vogelnesten.', NULL, 15, 4),
(27, 'yoghurt met fruit', 'snij de appels\nmeng met de yoghurt', NULL, 18, 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `recipe_category`
--

CREATE TABLE `recipe_category` (
  `id` int(11) NOT NULL,
  `name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `recipe_category`
--

INSERT INTO `recipe_category` (`id`, `name`) VALUES
(2, 'andere'),
(4, 'bijgerecht'),
(14, 'broodmaaltijd'),
(13, 'dranken'),
(6, 'hoofdgerecht'),
(3, 'ontbijt'),
(5, 'vieruurtje / dessert'),
(12, 'voorgerecht');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `recipe_herb`
--

CREATE TABLE `recipe_herb` (
  `id` int(11) NOT NULL,
  `herb_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `recipe_herb`
--

INSERT INTO `recipe_herb` (`id`, `herb_id`, `recipe_id`) VALUES
(1, 11, 3),
(2, 2, 3),
(3, 3, 3),
(4, 11, 4),
(6, 2, 4),
(7, 3, 4),
(11, 2, 6),
(12, 3, 6),
(13, 1, 7),
(14, 21, 7),
(15, 22, 7),
(16, 2, 7),
(17, 25, 7),
(18, 32, 7),
(19, 28, 7),
(20, 3, 7),
(21, 21, 4),
(23, 1, 4),
(24, 33, 8),
(25, 2, 8),
(26, 3, 8),
(27, 21, 9),
(28, 2, 9),
(29, 3, 9),
(30, 32, 10),
(31, 30, 11),
(32, 10, 11),
(33, 23, 11),
(34, 2, 11),
(35, 3, 11),
(36, 2, 12),
(37, 3, 12),
(39, 2, 13),
(40, 25, 13),
(41, 3, 13),
(42, 21, 14),
(43, 2, 14),
(44, 3, 14),
(46, 3, 15),
(48, 2, 15),
(49, 33, 16),
(50, 2, 16),
(51, 25, 16),
(52, 26, 16),
(53, 28, 16),
(54, 3, 16),
(55, 2, 17),
(56, 3, 17),
(57, 2, 23),
(58, 3, 23),
(59, 2, 24),
(60, 3, 24),
(61, 2, 26),
(62, 3, 26),
(63, 22, 13);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `recipe_ingredients`
--

CREATE TABLE `recipe_ingredients` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `quantity` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `recipe_ingredients`
--

INSERT INTO `recipe_ingredients` (`id`, `recipe_id`, `ingredient_id`, `quantity`) VALUES
(2, 3, 45, 0.2),
(3, 3, 21, 2),
(4, 3, 76, 1),
(7, 4, 21, 2),
(8, 4, 41, 0.1),
(9, 4, 79, 0.1),
(10, 4, 72, 0.04),
(11, 4, 17, 0.002),
(12, 4, 71, 0.002),
(21, 6, 80, 0.1),
(22, 6, 42, 0.05),
(23, 6, 78, 0.01),
(24, 6, 35, 0.05),
(25, 6, 34, 0.05),
(26, 6, 81, 1),
(27, 6, 17, 0.1),
(28, 6, 71, 0.01),
(29, 6, 46, 0.065),
(30, 6, 67, 0.065),
(31, 6, 33, 0.1),
(32, 7, 80, 0.3),
(33, 7, 70, 0.01),
(34, 7, 78, 0.01),
(35, 7, 37, 0.05),
(36, 7, 34, 0.03),
(37, 7, 79, 0.1),
(38, 7, 72, 0.06),
(39, 7, 43, 6),
(40, 7, 17, 0.1),
(41, 7, 22, 0.2),
(42, 7, 47, 0.15),
(43, 7, 33, 0.03),
(45, 4, 80, 0.1),
(46, 8, 77, 0.25),
(47, 8, 28, 0.075),
(48, 8, 34, 0.075),
(49, 8, 52, 0.075),
(50, 8, 74, 0.05),
(51, 8, 25, 0.25),
(52, 8, 85, 0.125),
(53, 8, 84, 0.025),
(54, 8, 87, 0.25),
(55, 8, 24, 0.5),
(57, 8, 67, 0.125),
(58, 8, 33, 0.05),
(59, 9, 78, 0.01),
(60, 9, 37, 0.06),
(61, 9, 72, 0.02),
(62, 9, 17, 0.1),
(63, 9, 71, 0.01),
(64, 9, 48, 0.1),
(65, 9, 27, 0.6),
(66, 10, 80, 0.3),
(67, 10, 37, 0.05),
(68, 10, 34, 0.03),
(69, 10, 79, 0.1),
(70, 10, 72, 0.05),
(71, 10, 22, 0.2),
(72, 10, 47, 0.15),
(73, 10, 33, 0.04),
(74, 11, 80, 0.25),
(75, 11, 77, 0.1),
(76, 11, 22, 0.3),
(77, 11, 46, 0.065),
(78, 11, 82, 1),
(79, 11, 23, 0.1),
(80, 11, 33, 0.03),
(81, 12, 79, 0.1),
(82, 12, 25, 0.1),
(83, 12, 26, 0.1),
(84, 12, 19, 0.1),
(85, 12, 24, 0.3),
(86, 12, 33, 0.04),
(87, 12, 44, 2),
(88, 13, 45, 0.05),
(89, 13, 50, 0.01),
(90, 13, 83, 0.03),
(91, 13, 49, 0.004),
(92, 13, 84, 0.03),
(93, 14, 45, 0.2),
(94, 14, 70, 0.005),
(95, 14, 41, 0.1),
(96, 14, 17, 0.005),
(97, 14, 36, 0.05),
(98, 15, 50, 0.02),
(99, 15, 70, 0.01),
(100, 15, 83, 0.03),
(101, 15, 55, 3),
(102, 15, 49, 0.03),
(103, 15, 84, 0.03),
(104, 15, 30, 0.1),
(105, 16, 45, 0.15),
(106, 17, 25, 0.2),
(107, 17, 91, 0.1),
(109, 17, 18, 0.1),
(110, 18, 70, 0.004),
(111, 18, 78, 0.02),
(112, 18, 41, 0.2),
(113, 18, 17, 0.05),
(114, 19, 78, 0.03),
(115, 19, 41, 0.2),
(116, 19, 92, 0.0175),
(117, 19, 71, 0.0225),
(118, 18, 93, 0.1),
(119, 20, 70, 0.002),
(120, 20, 17, 0.002),
(121, 20, 94, 0.25),
(122, 8, 86, 0.025),
(123, 17, 86, 0.03),
(124, 21, 63, 0.1),
(125, 21, 96, 0.03),
(126, 21, 97, 0.015),
(127, 21, 64, 0.1),
(128, 22, 63, 0.125),
(129, 22, 75, 0.05),
(130, 22, 71, 0.00625),
(131, 22, 64, 0.125),
(132, 23, 80, 0.2),
(133, 23, 77, 0.3),
(134, 23, 34, 0.1),
(135, 23, 67, 0.2),
(136, 24, 80, 0.2),
(137, 24, 77, 0.3),
(138, 24, 67, 0.2),
(139, 24, 33, 0.1),
(140, 25, 21, 1),
(141, 26, 41, 1.25),
(142, 26, 79, 0.15),
(143, 26, 102, 0.0075),
(144, 27, 21, 0.5),
(145, 27, 18, 0.25);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `recipe_type`
--

CREATE TABLE `recipe_type` (
  `id` int(11) NOT NULL,
  `name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `recipe_type`
--

INSERT INTO `recipe_type` (`id`, `name`) VALUES
(3, 'aardappel'),
(1, 'andere'),
(6, 'brood'),
(4, 'brood bakken'),
(5, 'brood verwerken'),
(7, 'couscous'),
(13, 'dranken'),
(18, 'fruit'),
(8, 'groenten'),
(9, 'hartig beleg'),
(10, 'pasta'),
(11, 'rijst'),
(12, 'soep'),
(14, 'vis'),
(15, 'vlees'),
(16, 'zoet'),
(17, 'zoet beleg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `single_column_name`
--

CREATE TABLE `single_column_name` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tablename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `single_column_name`
--

INSERT INTO `single_column_name` (`id`, `name`, `tablename`, `translation`) VALUES
(1, 'rayon', 'Rayon', 'rayon'),
(2, 'recipeCategory', 'RecipeCategory', 'recept categorie'),
(3, 'recipeType', 'RecipeType', 'recept type'),
(4, 'unit', 'Unit', 'maateenheid'),
(5, 'herb', 'Herb', 'kruiden'),
(6, 'mealmoment', 'Mealmoment', 'maaltijd moment');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `unit`
--

INSERT INTO `unit` (`id`, `name`) VALUES
(4, 'blik(ken)'),
(9, 'blok'),
(7, 'bolletje'),
(3, 'bussel'),
(1, 'kg'),
(2, 'krop(pen)'),
(6, 'liter'),
(5, 'stuk(s)'),
(8, 'tas'),
(10, 'teentje'),
(12, 'test'),
(11, 'zakje');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(21, 'test0@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$YXhiVFFBZlYySk5hWWpDUw$xC4sfLAsqLaN6Kr17+OSanWLjIVBkUvv4bROoiLswjQ'),
(22, 'test1@test.be', '[\"ROLE_ADMIN\"]', '$argon2i$v=19$m=65536,t=4,p=1$WGlLTEFmRzJNOGlSdFYzLw$6JgKkQehkKlwCEi3wDIBDKgeB5ZRBbuTvy4X4AWhiQs'),
(23, 'test2@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$Tm1tUkZiVUFCQ29mU1FVUQ$RRnY8Jgrx/A+TSQ1ZL17aQFV7/FLcIj/mG8JX+3WScI'),
(24, 'test3@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$WVUyWGRvTVl5ZndhUVhtZg$A5ULgn4doFE32nRnqd5LgSj+rXUjfMaE3LftvYtbKlY'),
(25, 'test4@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$Mnk5cU16d3FqMnZpR0lsYQ$686wVzc+sKJVvXfbAQV/MeQ42nXRu5z2I2tCLGx4MeM'),
(26, 'test5@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$UTNqL05aSnNwaDF3ZS4wcA$0aK9hMyr9tzf1Bef94z1XVz0ymEj4+f1G856i6oSx5c'),
(27, 'test6@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$NTIvdWVZR2dReXoyRW9TVg$ffSt6B5sE1OeRaqbV9pvgMBI44M9kHA8rW1WXl8s9FY'),
(28, 'test7@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$d2VpT0tpYkJFczVnZVRaWA$4gf5O2emPzjVBfwP2uaGWIBKdJU7zrACCmnvhJ+bpjs'),
(29, 'test8@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$MFNSSW0wOHZjYUFXYWxLWA$KqH3OFgKkypGkcD7HlbJnXKMZyUEYCwLykEtL65pEY0'),
(30, 'test9@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$R25Nc3RwLjNQN2ZSSXIwcA$OxpcXFe7f/dwBuI90doP2YCHgW5R3mrdKpBlYuiwg88'),
(31, 'test10@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$QVNsdzlxdWhidWF6SUJpWg$WysPQC9C44C2mVrEKSyrHo8/GZjLTSAcJmjjQu+BSTc'),
(32, 'test11@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$VEZqSlMuNkJYMWU2ck1xVw$Uyxs5CA3jv6chg47sUmHJ3Kn7u80kh2Qjjd9qXcTn8c'),
(33, 'test12@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$M1RsL3htcWEzbS9YMEZTdA$xFMffMbE21HVF5BQuE2LVA0PsGkxDR/B5scec75gd5k'),
(34, 'test13@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$STUzMTF4SloyM05aOC92Yg$V5K11RheDx6kD14eLTSjqHwbeHsGSN2tYO1HtSLQkDQ'),
(35, 'test14@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$YXZDSndtclNwbVZnZjdQWA$cundbwg6dCCaEx7r/LfyIcX+5i576dCdFzzbLnyiB2I'),
(36, 'test15@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$OUlUbDFFc3lHY3cwN0laYQ$70qqJ40ws4PlyeuEbgVATLZa4nX4iv5FlS8SWjsqp0E'),
(37, 'test16@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$em95NUpJVUVRQnUvMkZLRA$uknH9LTHYt6WTOm4MxT//3Pm/1GfWyBUVkm5TA8g3MM'),
(38, 'test17@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$MnFwam1iNmxRNEpFNU01UQ$EHWIZXtUYHDbftkgJ6Bor+1q5XwQFtTcuvA6azqHqzE'),
(39, 'test18@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$TndZV0k1SnlITi5BTG9HaQ$e0CM6fwu4Hi+vuWNXTRYFNANJU1qkdYajn1v5FhcBfg'),
(40, 'test19@test.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$U1JXaGpJSnJrSWpNWC5KOA$0NbJSvQ/fXmXGO6fplyXwPg1fBgD+M4NfHQKl4TRUmw'),
(41, 'jana@jana.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$cW9DUjRYelNJT0hOYU1XcQ$qjBL/BnqyhKwtg4TgdyAen4WczCZHKY+sGKOm/erWUw'),
(42, 'jana1@jana.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$RWNPRzRReGFFYVlveU55Ng$0ytE/Q9i9Sm5RrOurdRxSmuxXTLf38GOlwLwikpmyxI'),
(43, 'jana2@jana.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$WVBwUC8yalhzRWdCbS5Cbg$hC+YikANQy1Z5Kn2Cy7QX8iGiEexjLkXWNIe+rVOiE4'),
(44, 'jana4@jana.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$RnBSSGYuZUlrWG4uUzNxbQ$/hTmILhXyVjeaT2quLMgoMv6qhxYCnfmfLwc3UCg2uE'),
(45, 'jana5@jana.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$dVRrM1Z3TzNDR2sxbVZFaQ$OPS6ykSa32cxeZS9aWlSDIg4eg8usfknlyyVfEN8bqU'),
(46, 'jana123@jana.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$TWRBb3NqVDhNTWh4Rk5KWA$HxTDmIM4jRZlAylfP/HmTn0zyUeG1RjvOsZJV2msV78'),
(47, 'jlmdsfjq', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$eUIvdDBmc1dweGUuem1SLg$f0FMRmMfX18NUqoFTBYNg+JN74V/ni4pAVUtER4yRYA'),
(48, 'fsl@xn--jflqs-5ua', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$TGowaUxZL0tZQlpycy5CTQ$wGQGdN4VyLIWXFFA9T4hPuR5t9/2vAreH1oExYfQ8Kc'),
(49, 'katrijn.lietaer@obelisk.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$S0hIaGxQNFVEenk5akg2NA$FT/cOUZa7DloH+CAykTm/5BqrUB9n7ShlaljLgCLgmM'),
(50, 'nieuw@nieuw.be', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$d1hMOGZhdUxGcDF5TURWQQ$ysFQxjk97zlBcjmelt/7OnH/BZBGFDwghuueE4cWUFY');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `camp`
--
ALTER TABLE `camp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C1944230A76ED395` (`user_id`);

--
-- Indexen voor tabel `campday`
--
ALTER TABLE `campday`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F4E6B61B77075ABB` (`camp_id`);

--
-- Indexen voor tabel `campmeal`
--
ALTER TABLE `campmeal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E48D92AB3792A5F8` (`camp_mealmoment_id`),
  ADD KEY `IDX_E48D92AB8DC4C726` (`campday_id`);

--
-- Indexen voor tabel `camp_mealmoments`
--
ALTER TABLE `camp_mealmoments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1696C08177075ABB` (`camp_id`),
  ADD KEY `IDX_1696C081E13BCF51` (`mealmoment_id`);

--
-- Indexen voor tabel `herb`
--
ALTER TABLE `herb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2F7F123B5E237E06` (`name`);

--
-- Indexen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_6BAF78705E237E06` (`name`),
  ADD KEY `IDX_6BAF7870D3202E52` (`rayon_id`),
  ADD KEY `IDX_6BAF7870F8BD700D` (`unit_id`);

--
-- Indexen voor tabel `mealcourse`
--
ALTER TABLE `mealcourse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_266C6BF363126050` (`campmeal_id`),
  ADD KEY `IDX_266C6BF359D8A214` (`recipe_id`);

--
-- Indexen voor tabel `mealmoment`
--
ALTER TABLE `mealmoment`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexen voor tabel `rayon`
--
ALTER TABLE `rayon`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D5E5BC3C5E237E06` (`name`);

--
-- Indexen voor tabel `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_A369E2B55E237E06` (`name`),
  ADD KEY `IDX_A369E2B5C54C8C93` (`type_id`),
  ADD KEY `IDX_A369E2B512469DE2` (`category_id`);

--
-- Indexen voor tabel `recipe_category`
--
ALTER TABLE `recipe_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_70DCBC5F5E237E06` (`name`);

--
-- Indexen voor tabel `recipe_herb`
--
ALTER TABLE `recipe_herb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_506448E4F631D310` (`herb_id`),
  ADD KEY `IDX_506448E459D8A214` (`recipe_id`);

--
-- Indexen voor tabel `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9F925F2B59D8A214` (`recipe_id`),
  ADD KEY `IDX_9F925F2B933FE08C` (`ingredient_id`);

--
-- Indexen voor tabel `recipe_type`
--
ALTER TABLE `recipe_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F3C50DF65E237E06` (`name`);

--
-- Indexen voor tabel `single_column_name`
--
ALTER TABLE `single_column_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_DCBB0C535E237E06` (`name`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `camp`
--
ALTER TABLE `camp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT voor een tabel `campday`
--
ALTER TABLE `campday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT voor een tabel `campmeal`
--
ALTER TABLE `campmeal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT voor een tabel `camp_mealmoments`
--
ALTER TABLE `camp_mealmoments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT voor een tabel `herb`
--
ALTER TABLE `herb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT voor een tabel `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT voor een tabel `mealcourse`
--
ALTER TABLE `mealcourse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT voor een tabel `mealmoment`
--
ALTER TABLE `mealmoment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `rayon`
--
ALTER TABLE `rayon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT voor een tabel `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT voor een tabel `recipe_category`
--
ALTER TABLE `recipe_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT voor een tabel `recipe_herb`
--
ALTER TABLE `recipe_herb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT voor een tabel `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT voor een tabel `recipe_type`
--
ALTER TABLE `recipe_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT voor een tabel `single_column_name`
--
ALTER TABLE `single_column_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `camp`
--
ALTER TABLE `camp`
  ADD CONSTRAINT `FK_C1944230A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Beperkingen voor tabel `campday`
--
ALTER TABLE `campday`
  ADD CONSTRAINT `FK_F4E6B61B77075ABB` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`);

--
-- Beperkingen voor tabel `campmeal`
--
ALTER TABLE `campmeal`
  ADD CONSTRAINT `FK_E48D92AB3792A5F8` FOREIGN KEY (`camp_mealmoment_id`) REFERENCES `camp_mealmoments` (`id`),
  ADD CONSTRAINT `FK_E48D92AB8DC4C726` FOREIGN KEY (`campday_id`) REFERENCES `campday` (`id`);

--
-- Beperkingen voor tabel `camp_mealmoments`
--
ALTER TABLE `camp_mealmoments`
  ADD CONSTRAINT `FK_1696C08177075ABB` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`),
  ADD CONSTRAINT `FK_1696C081E13BCF51` FOREIGN KEY (`mealmoment_id`) REFERENCES `mealmoment` (`id`);

--
-- Beperkingen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `FK_6BAF7870D3202E52` FOREIGN KEY (`rayon_id`) REFERENCES `rayon` (`id`),
  ADD CONSTRAINT `FK_6BAF7870F8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`);

--
-- Beperkingen voor tabel `mealcourse`
--
ALTER TABLE `mealcourse`
  ADD CONSTRAINT `FK_266C6BF359D8A214` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`),
  ADD CONSTRAINT `FK_266C6BF363126050` FOREIGN KEY (`campmeal_id`) REFERENCES `campmeal` (`id`);

--
-- Beperkingen voor tabel `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `FK_A369E2B512469DE2` FOREIGN KEY (`category_id`) REFERENCES `recipe_category` (`id`),
  ADD CONSTRAINT `FK_A369E2B5C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `recipe_type` (`id`);

--
-- Beperkingen voor tabel `recipe_herb`
--
ALTER TABLE `recipe_herb`
  ADD CONSTRAINT `FK_506448E459D8A214` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`),
  ADD CONSTRAINT `FK_506448E4F631D310` FOREIGN KEY (`herb_id`) REFERENCES `herb` (`id`);

--
-- Beperkingen voor tabel `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD CONSTRAINT `FK_9F925F2B59D8A214` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`),
  ADD CONSTRAINT `FK_9F925F2B933FE08C` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
