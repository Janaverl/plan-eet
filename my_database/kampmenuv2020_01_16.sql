-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 16 jan 2020 om 19:49
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
(1, 14, 0),
(2, 14, 1),
(3, 14, 2);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `campday`
--
ALTER TABLE `campday`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F4E6B61B77075ABB` (`camp_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `campday`
--
ALTER TABLE `campday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `campday`
--
ALTER TABLE `campday`
  ADD CONSTRAINT `FK_F4E6B61B77075ABB` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
