-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 15 jan 2020 om 20:39
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
(1, 22, 'test', '2020-01-16 10:00:00', '2020-01-23 10:00:00', 10),
(2, 22, 'test2', '2020-01-24 20:03:00', '2020-02-01 21:54:00', 20);

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
(32, 'spaghettikruiden'),
(31, 'speculaaskruiden'),
(27, 'steranijs'),
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
(86, 'mult (verse)', NULL, 14, 3),
(87, 'rode ui', NULL, 14, 5),
(88, 'peer', 'test', 26, 5),
(89, 'aardbeien', NULL, 26, 1),
(90, 'pompoen', NULL, 14, 1),
(91, 'look', NULL, 40, 10);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `meal_moment`
--

CREATE TABLE `meal_moment` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `meal_moment`
--

INSERT INTO `meal_moment` (`id`, `name`) VALUES
(1, 'ontbijt'),
(2, 'middagmaal'),
(3, 'avondmaal'),
(4, 'tienuurtje'),
(5, 'vieruurtje'),
(6, 'avondsnack');

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
('20200115145938', '2020-01-15 14:59:46');

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
(25, 'andere'),
(34, 'bakken'),
(15, 'brood'),
(17, 'chips/borrelhapjes'),
(22, 'conserven en sauzen'),
(23, 'diepvries'),
(24, 'dranken'),
(21, 'droge voeding'),
(26, 'fruit'),
(14, 'groenten'),
(20, 'koekjes/chocolade/snoep'),
(16, 'ontbijt'),
(18, 'vegetarische producten'),
(40, 'verse kruiden'),
(19, 'vis'),
(13, 'vlees'),
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
(5, 'Jagerschotel', 'Breng gezouten water aan de kook. Schil de aardappelen, snij ze in stukjes en kook ze gaar.  \nGiet de aardappelen af en laat ze even uitdampen. Doe ze terug in de pot en pureer ze samen met de boter, melk, eieren, nootmuskaat, peper en zout. \nSnij 1 van de ajuinen fijn. Was de groenten en snij ze in stukken (indien nodig).\nStoof de ajuin aan in wat olijfolie en voeg de groenten toe. Stoof ze tot ze beetgaar zijn.\nSnij de tweede ajuin en stoof deze aan. Voeg het gehakt toe en kruid het met peper en zout. \nNu kan je alles in laagjes in de ovenschotel doen. Begin met het gehakt in de schotel te doen, gevolgd door de groenten en dan de puree. Strooi kaas op de bovenkant en plaats het voor enkele minuten onder de grill in de oven. ', 'je kan dit recept ook met andere groenten maken, vb boontjes, warmoes, courgette, ...', 3, 6),
(6, 'kip met rijst, currysaus en groentjes ', 'Breng het water (eventueel met de bouillon) aan de kook. Wanneer het kookt kan je de rijst toevoegen. Roer meteen eens zodat het niet kleeft en roer tijdens het koken af en toe, zeker op het einde. \nRijst brandt snel aan, zet naar het einde toe het vuur wat lager.\nMaak de groenten schoon en snij ze indien nodig.\nStoof eventueel een ajuin aan in wat olijfolie en voeg de groenten toe. Laat ze garen op een niet te hoog vuur om aanbranden te voorkomen. \nBak de lapjes in de pan of in de oven en kruid ze met peper en zout. \nVoor de currysaus start je met het smelten van de boter op een laag vuur of het opwarmen van de olie. Voeg dan de bloem toe. Nu krijg je een soort papje. Haal de pot van het vuur en voeg al roerend de melk toe. Zet de pot terug op het vuur, laat het verwarmen en voeg dan de curry toe. Laat de saus al roerend indikken. Voeg eventueel nog peper en zout toe naar smaak.\nVoeg de ananas toe aan de saus. Smakelijk!', NULL, 11, 6),
(7, 'lasagne', 'Begin voor de spaghettisaus met het snijden en aanstoven van de ajuinen in wat olijfolie. Was alle groenten, snij ze en voeg ze bij de ajuinen (begin met de hardste groenten en eindig met de zachtste).  Doe de passata erbij en laat even sudderen. \nBak het vlees in een aparte pan en kruid het. Doe het vlees bij de saus. Voeg nu de kruiden toe. Je kan de saus eventueel mixen.\nVoor de kaassaus start je met de boter op een laag vuurtje te smelten of de olie op te warmen. Voeg dan de bloem toe. Nu krijg je een soort papje. Haal de pot van het vuur en voeg al roerend de melk toe. Zet de pot terug op het vuur, laat het verwarmen en voeg dan de kaas toe. Laat de saus al roerend indikken. Voeg peper, zout en nootmuskaat toe naar smaak.\nNu de sauzen klaar zijn kan je de lasagne beginnen ‘opbouwen’. Begin met een laag spaghettisaus en leg hier een eerste laag lasagnevellen op. Giet hier kaassaus op en bedek het opnieuw met lasagnevellen, vervolg terug met spaghettisaus, enzoverder. \nStrooi de gemalen kaas erbovenop en plaats de lasagne voor 30 minuten in een voorverwarmde oven van 180°C. Smakelijk!', NULL, 10, 6),
(8, 'tabouleh', 'Schil en halveer de komkommer, verwijder de pitjes en snij het vruchtvlees in blokjes. Ontpit de tomaten en snij ze in blokjes. Snij de lente-uitjes in dunne ringetjes. Verkruimel de feta.\nBreng de bouillon aan de kook. Doe de couscous in een schaal en schenk er de bouillon over. Laat afgedekt wellen, volgens de aanwijzingen op de verpakking. Maak de korrels los met een vork. Voeg een scheutje olijfolie toe.\nMaak de wortelen en courgette schoon. Snij ze in stukjes. Spoel met koud water en laat uitlekken.\nMeng de groenten met de tomaten, komkommer, rode ui, lente-uitjes, feta, peterselie en munt door de couscous. Breng op smaak met citroensap, peper en zout.', 'Er zijn veel variaties mogelijk', 7, 4),
(9, 'Macaroni met champignons en prei', 'Maak de champignons schoon (niet onder water, want dit slorpen ze op) en snij ze in stukken. Was de preistronken (snij het groene deel in twee en was het zand er zo uit) en snij deze ook in stukken. \nBreng water aan de kook voor de pasta. Als je een grote hoeveelheid moet maken, zorg dan dat je voldoende op voorhand water opzet en de pasta kookt. \nStoof de groenten aan in een beetje olijfolie. \nDoe de pasta in het kokende water (roer meteen zodat de pasta niet plakt), laat ze gaar koken en giet ze af. Laat (warm) water over de pasta stromen om plakken te voorkomen (olie erdoor roeren is minder effectief en minder gezond).\nVoor de saus start je met de boter op een laag vuurtje te smelten of de olie op te warmen. Voeg dan de bloem toe. Nu krijg je een soort papje. Haal de pot van het vuur en voeg al roerend de melk toe. Zet de pot terug op het vuur, laat het verwarmen en voeg dan de kaas toe. Laat de saus al roerend indikken. Voeg peper, zout en nootmuskaat toe naar smaak.\nVoeg de groenten toe aan de saus en meng.\nVoeg de saus met de groenten toe aan de pasta. Je kan eventueel de pasta in een ovenschotel doen, er kaas over strooien en het in de oven steken zodat het een lekker kaaskorstje krijgt.\nSmakelijk! ', NULL, 10, 6),
(10, 'Spaghetti', 'Snij de ajuinen en stoof ze aan in wat olijfolie. \nWas alle groenten, snij ze en voeg ze toe (de harde groenten eerst, de zachte laatst)\nDoe de passata erbij en laat even sudderen. \nBak het vlees in een pan en kruid het. Voeg het toe aan de saus. \nDoe er nu alle kruiden bij. Mix de saus indien gewenst.\nBreng water aan de kook en voeg de spaghettislierten toe. Roer af en toe in de pot zodat de slierten niet kleven.\nWanneer de spaghetti gaar is, giet ze dan af en spoel ze met (warm) water om het kleven tegen te gaan (olie is minder effectief). \nDe gemalen kaas kan je als afwerking op de bordjes strooien.\nSmakelijk!', NULL, 10, 6),
(11, 'Wok met rijst', 'Snij de ajuinen en stoof ze aan in een beetje olijfolie.\nWas de andere groenten en snij ze in fijne stukjes. Voeg eerst de hardere groenten toe en dan de zachtere. Voeg de kruiden toe.\nSnij de lapjes in reepjes en bak deze. Voeg kruiden toe naar smaak. Doe de reepjes bij de groenten.\nBreng water (met bouillon) aan de kook. Als je voor rijst kiest kook deze dan (kijk op de verpakking om te weten hoe lang). Als je voor couscous kiest dan moet je het kokend water over de couscous gieten en het laten opzwellen (dus niet laten koken). Je kan wat boter toevoegen aan de couscous voor de smaak.\nSmakelijk!       ', 'je kan dit ook met couscous maken ipv rijst', 11, 6),
(12, 'Wraps met gehakt en rauwe groenten', 'Warm de wraps op in de oven (kijk op de verpakking op hoeveel graden en voor hoe lang).\nWas alle groenten en snij ze. Als je rode biet gebruikt kan je deze eerst koken.\nBak het gehakt en kruid het.\n ', 'je kan hier aardappelsla of tabouleh bij serveren', 8, 6),
(13, 'Aardappelsla ', 'Schil de aardappelen en snij ze in kleinere stukken.\nBreng water aan de kook en kook de aardappelen gaar.\nLaar ze afkoelen en voeg de mayonaise en kruiden toe en fijngesneden augurken.\n            ', '', 3, 4),
(14, 'Warmoespuree', 'Breng water aan de kook. Schil de aardappelen, snij ze in stukken en kook ze gaar.\nGiet de aardappelen af en laat ze even uitdampen. Doe ze terug in de pot en pureer ze samen met de boter, melk, eieren, nootmuskaat, peper en zout. \nWas de warmoes en snij ze wat fijner. Stoof de warmoes aan in een kleine hoeveelheid olijfolie (eventueel met wat water bij) totdat ze gekrompen is. \nDoe de gestoofde warmoes bij de puree en stamp nog eens alles goed door elkaar. Proef nog eens en voeg indien gewenst nog wat kruiden toe.        ', 'lekker met fishticks en zelf gemaakte tartaar', 3, 4),
(15, 'fishsticks	en zelfgemaakte tartaar', 'Bak de fishsticks in de pan of in de oven. \nOm de tartaar te maken, moet je de augurken, de sjalot of kleine ajuin en de kruiden heel fijn snijden. Voeg deze bij de mayonaise en voeg zout en peper toe.\n                        ', 'lekker met warmoespurree', 14, 4),
(16, 'aardappelen met kruiden in de oven', 'Snij de aardappelen in stukken (je kan ze schillen indien gewenst).\nHak de kruiden fijn. \nGiet wat olie in de ovenschotel en doe de aardappelen erin en meng ze met de kruiden en de olijfolie. \nVerwarm de oven voor op 150°C. Plaats de schotel in de oven voor 50 à 60 minuten. Draai ze tussendoor af en toe om zodat ze niet aanbranden.\n', NULL, 3, 4),
(17, 'tzatziki', 'Was de komkommers en rasp ze. Knijp de geraspte komkommers uit zodat het meeste vocht eruit is.\nMeng dit met de yoghurt en laat het een half uurtje in de koelkast staan.\nBreng dan op smaak met fijngehakte munt, peper en zout. Smakelijk!', NULL, 8, 4);

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
(8, 21, 5),
(9, 2, 5),
(10, 3, 5),
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
(47, 22, 13),
(48, 2, 15),
(49, 33, 16),
(50, 2, 16),
(51, 25, 16),
(52, 26, 16),
(53, 28, 16),
(54, 3, 16),
(55, 2, 17),
(56, 3, 17);

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
(13, 5, 45, 0.25),
(14, 5, 80, 0.2),
(15, 5, 70, 0.002),
(16, 5, 41, 0.1),
(17, 5, 79, 0.1),
(18, 5, 72, 0.04),
(19, 5, 17, 0.002),
(20, 5, 33, 0.2),
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
(56, 8, 40, 0.025),
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
(108, 17, 40, 0.03),
(109, 17, 18, 0.1);

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
  `api` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `single_column_name`
--

INSERT INTO `single_column_name` (`id`, `name`, `tablename`, `api`, `translation`) VALUES
(1, 'rayon', 'Rayon', '\\/fetch\\/add\\/rayon', 'rayon'),
(2, 'recipeCategory', 'RecipeCategory', '/fetch/add/recipeCategory', 'recept categorie'),
(3, 'recipeType', 'RecipeType', '/fetch/add/recipeType', 'recept type'),
(4, 'unit', 'Unit', '/fetch/add/unit', 'maateenheid'),
(5, 'herb', 'Herb', '/fetch/add/herb', 'kruiden'),
(6, 'mealMoment', 'MealMoment', '/fetch/add/mealMoment', 'maaltijd moment');

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
(10, 'teentje');

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
(48, 'fsl@xn--jflqs-5ua', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$TGowaUxZL0tZQlpycy5CTQ$wGQGdN4VyLIWXFFA9T4hPuR5t9/2vAreH1oExYfQ8Kc');

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
-- Indexen voor tabel `meal_moment`
--
ALTER TABLE `meal_moment`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `herb`
--
ALTER TABLE `herb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT voor een tabel `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT voor een tabel `meal_moment`
--
ALTER TABLE `meal_moment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `rayon`
--
ALTER TABLE `rayon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT voor een tabel `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT voor een tabel `recipe_category`
--
ALTER TABLE `recipe_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT voor een tabel `recipe_herb`
--
ALTER TABLE `recipe_herb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT voor een tabel `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT voor een tabel `recipe_type`
--
ALTER TABLE `recipe_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT voor een tabel `single_column_name`
--
ALTER TABLE `single_column_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `camp`
--
ALTER TABLE `camp`
  ADD CONSTRAINT `FK_C1944230A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Beperkingen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `FK_6BAF7870D3202E52` FOREIGN KEY (`rayon_id`) REFERENCES `rayon` (`id`),
  ADD CONSTRAINT `FK_6BAF7870F8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`);

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
