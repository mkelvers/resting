-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Feb 25, 2026 at 04:47 PM
-- Server version: 8.4.8
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resting`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`) VALUES
(1, 'The Beatles'),
(2, 'Pink Floyd'),
(3, 'Led Zeppelin'),
(4, 'Queen'),
(5, 'The Rolling Stones'),
(6, 'Michael Jackson'),
(7, 'Prince'),
(8, 'David Bowie'),
(9, 'Freddie Mercury'),
(10, 'Jimi Hendrix'),
(11, 'Bob Dylan'),
(12, 'Elvis Presley'),
(13, 'Madonna'),
(14, 'Beyonce'),
(15, 'Taylor Swift'),
(16, 'Ed Sheeran'),
(17, 'Billie Eilish'),
(18, 'Drake'),
(19, 'Kendrick Lamar'),
(20, 'Eminem'),
(21, 'Daft Punk'),
(22, 'Radiohead'),
(23, 'U2'),
(24, 'Coldplay'),
(25, 'Arctic Monkeys'),
(26, 'Nirvana'),
(27, 'Metallica'),
(28, 'AC/DC'),
(29, 'Guns N Roses'),
(30, 'The Eagles'),
(31, 'Fleetwood Mac'),
(32, 'The Who'),
(33, 'The Doors'),
(34, 'Deep Purple'),
(35, 'Black Sabbath'),
(36, 'Iron Maiden'),
(37, 'Judas Priest'),
(38, 'Red Hot Chili Peppers'),
(39, 'Foo Fighters'),
(40, 'Green Day'),
(41, 'Miles Davis'),
(42, 'John Coltrane'),
(43, 'Ella Fitzgerald'),
(44, 'Louis Armstrong'),
(45, 'Bob Marley'),
(46, 'Tupac Shakur'),
(47, 'Notorious B.I.G'),
(48, 'Snoop Dogg'),
(49, 'Rihanna'),
(50, 'Lady Gaga'),
(51, 'Bruno Mars'),
(52, 'Adele'),
(53, 'Olivia Rodrigo'),
(54, 'Harry Styles'),
(55, 'Dua Lipa'),
(56, 'Post Malone'),
(57, 'Justin Bieber'),
(58, 'Ariana Grande'),
(59, 'The Weeknd'),
(60, 'Kanye West');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`) VALUES
(27, 'Argentina'),
(33, 'Australia'),
(20, 'Austria'),
(39, 'Barbados'),
(18, 'Belgium'),
(4, 'Brazil'),
(35, 'Canada'),
(31, 'Chile'),
(52, 'China'),
(29, 'Colombia'),
(5, 'Cuba'),
(22, 'Czech Republic'),
(16, 'Denmark'),
(40, 'Dominican Republic'),
(44, 'Egypt'),
(15, 'Finland'),
(9, 'France'),
(10, 'Germany'),
(8, 'Ghana'),
(25, 'Greece'),
(23, 'Hungary'),
(51, 'India'),
(43, 'Iran'),
(36, 'Ireland'),
(46, 'Israel'),
(11, 'Italy'),
(3, 'Jamaica'),
(49, 'Japan'),
(28, 'Mexico'),
(45, 'Morocco'),
(17, 'Netherlands'),
(34, 'New Zealand'),
(6, 'Nigeria'),
(14, 'Norway'),
(30, 'Peru'),
(21, 'Poland'),
(26, 'Portugal'),
(41, 'Puerto Rico'),
(24, 'Romania'),
(47, 'Russia'),
(37, 'Scotland'),
(7, 'South Africa'),
(50, 'South Korea'),
(12, 'Spain'),
(13, 'Sweden'),
(19, 'Switzerland'),
(38, 'Trinidad and Tobago'),
(42, 'Turkey'),
(48, 'Ukraine'),
(2, 'United Kingdom'),
(1, 'United States'),
(32, 'Venezuela');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(28, 'Afrobeat'),
(32, 'Alternative'),
(33, 'Ambient'),
(22, 'Bachata'),
(38, 'Bluegrass'),
(5, 'Blues'),
(27, 'Bossa Nova'),
(7, 'Classical'),
(8, 'Country'),
(24, 'Cumbia'),
(16, 'Disco'),
(19, 'Drum & Bass'),
(20, 'Dubstep'),
(41, 'EDM'),
(6, 'Electronic'),
(14, 'Folk'),
(11, 'Funk'),
(37, 'Gospel'),
(46, 'Grime'),
(3, 'Hip Hop'),
(17, 'House'),
(31, 'Indie'),
(43, 'J-Pop'),
(4, 'Jazz'),
(42, 'K-Pop'),
(36, 'Latin'),
(40, 'Lo-Fi'),
(23, 'Merengue'),
(13, 'Metal'),
(39, 'Neo Soul'),
(50, 'New Wave'),
(49, 'Opera'),
(47, 'Phonk'),
(2, 'Pop'),
(48, 'Progressive House'),
(45, 'Psychedelic'),
(12, 'Punk'),
(15, 'R&B'),
(9, 'Reggae'),
(29, 'Reggaeton'),
(1, 'Rock'),
(21, 'Salsa'),
(26, 'Samba'),
(10, 'Soul'),
(34, 'Soundtrack'),
(44, 'Synthwave'),
(25, 'Tango'),
(18, 'Techno'),
(30, 'Trap'),
(35, 'World');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int NOT NULL,
  `url` varchar(500) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `record_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `labels`
--

CREATE TABLE `labels` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `labels`
--

INSERT INTO `labels` (`id`, `name`) VALUES
(1, 'Columbia Records'),
(2, 'Sony Music'),
(3, 'Universal Music Group'),
(4, 'Warner Music Group'),
(5, 'Atlantic Records'),
(6, 'Capitol Records'),
(7, 'Island Records'),
(8, 'Def Jam'),
(9, 'RCA Records'),
(10, 'Motown'),
(11, 'Blue Note'),
(12, 'ECM Records'),
(13, 'Stax Records'),
(14, 'Sun Records'),
(15, 'Apple Records'),
(16, 'Sub Pop'),
(17, 'Domino'),
(18, 'Rough Trade'),
(19, 'XL Recordings'),
(20, '4AD'),
(21, 'Ninja Tune'),
(22, 'Warp Records'),
(23, 'Ghostly International'),
(24, 'Stones Throw'),
(25, 'Nonesuch'),
(26, 'Deutsche Grammophon'),
(27, 'BMG'),
(28, 'EMI'),
(29, 'Interscope'),
(30, 'Geffen Records'),
(31, 'Death Row'),
(32, 'Bad Boy'),
(33, 'Jive'),
(34, 'Arista'),
(35, 'Epic'),
(36, 'Virgin'),
(37, 'Parlophone'),
(38, 'Polydor'),
(39, 'Decca'),
(40, 'Fontana'),
(41, 'Chess Records'),
(42, 'Verve'),
(43, 'Impulse!'),
(44, 'Strata-East'),
(45, 'Prestige'),
(46, 'Blue Note'),
(47, 'RCA'),
(48, 'Elektra'),
(49, 'DreamWorks'),
(50, 'Aftermath');

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `media_condition` enum('mint','near_mint','very_good_plus','very_good','good','fair','poor') DEFAULT NULL,
  `sleeve_condition` enum('mint','near_mint','very_good_plus','very_good','good','fair','poor','generic') DEFAULT NULL,
  `stock` int DEFAULT '0',
  `format` enum('lp','vinyl','12_maxi','7_single','cd_album','cd_single') DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `country_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`id`, `title`, `description`, `price`, `media_condition`, `sleeve_condition`, `stock`, `format`, `release_date`, `country_id`) VALUES
(1, 'Abbey Road', 'Classic Beatles album', 45.00, 'mint', 'near_mint', 10, 'lp', '1969-09-26', 2),
(2, 'The Dark Side of the Moon', 'Pink Floyd masterpiece', 52.00, 'very_good_plus', 'very_good', 8, 'lp', '1973-03-01', 2),
(3, 'Thriller', 'Michael Jackson best seller', 28.00, 'good', 'good', 15, 'cd_album', '1982-11-30', 1),
(4, 'Purple Rain', 'Prince iconic album', 38.00, 'near_mint', 'mint', 6, 'lp', '1984-06-25', 1),
(5, 'Rumours', 'Fleetwood Mac classic', 32.00, 'very_good', 'very_good', 12, 'lp', '1977-02-11', 1),
(6, 'Back in Black', 'AC/DC legend', 48.00, 'near_mint', 'near_mint', 9, 'lp', '1980-07-25', 32),
(7, 'The Joshua Tree', 'U2 masterpiece', 36.00, 'very_good_plus', 'very_good', 7, 'lp', '1987-03-09', 35),
(8, 'Led Zeppelin IV', 'Zeppelin classic', 55.00, 'mint', 'mint', 4, 'lp', '1971-11-08', 2),
(9, 'The Wall', 'Pink Floyd epic', 42.00, 'very_good', 'good', 10, 'lp', '1979-11-30', 2),
(10, 'Kind of Blue', 'Miles Davis jazz masterpiece', 58.00, 'very_good_plus', 'very_good_plus', 5, 'lp', '1959-08-17', 1),
(11, 'Legend', 'Bob Marley best of', 24.00, 'good', 'good', 20, 'lp', '1984-05-08', 3),
(12, 'The Marshall Mathers LP', 'Eminem breakthrough', 32.00, 'very_good', 'very_good', 14, 'cd_album', '2000-05-25', 1),
(13, 'Random Access Memories', 'Daft Punk electronic', 44.00, 'near_mint', 'near_mint', 8, 'lp', '2013-05-17', 10),
(14, 'OK Computer', 'Radiohead masterpiece', 38.00, 'mint', 'mint', 6, 'lp', '1997-05-21', 2),
(15, 'Nevermind', 'Nirvana breakthrough', 28.00, 'good', 'good', 18, 'lp', '1991-09-24', 1),
(16, 'Master of Puppets', 'Metallica thrash', 42.00, 'very_good_plus', 'very_good', 10, 'lp', '1986-03-27', 1),
(17, 'Sgt. Peppers Lonely Hearts Club Band', 'Beatles experimental', 48.00, 'near_mint', 'mint', 7, 'lp', '1967-06-01', 2),
(18, 'The Free Jazz Collective', 'Ornette Coleman avant', 65.00, 'fair', 'poor', 3, 'lp', '1961-01-01', 1),
(19, 'A Love Supreme', 'John Coltrane spiritual', 52.00, 'very_good', 'very_good', 5, 'lp', '1965-12-09', 1),
(20, 'Physical Graffiti', 'Led Zeppelin double', 68.00, 'mint', 'mint', 3, 'lp', '1975-02-24', 2),
(21, 'The Chronic', 'Dr. Dre debut', 34.00, 'good', 'good', 12, 'lp', '1992-12-15', 1),
(22, 'Illmatic', 'Nas debut', 36.00, 'near_mint', 'near_mint', 8, 'lp', '1994-04-19', 1),
(23, 'Discovery', 'Daft Punk classic', 32.00, 'very_good', 'very_good', 10, 'lp', '2001-03-12', 10),
(24, 'Homogenic', 'Bjork electronic masterpiece', 38.00, 'near_mint', 'mint', 6, 'lp', '1997-09-22', 19),
(25, 'The Velvet Underground & Nico', 'Proto punk classic', 72.00, 'fair', 'poor', 2, 'lp', '1967-03-12', 1),
(26, 'Rumble Fish', 'Sly Stone funk', 28.00, 'good', 'good', 15, 'lp', '1983-10-01', 1),
(27, 'Buena Vista Social Club', 'Cuban classics', 32.00, 'very_good', 'very_good', 11, 'lp', '1997-09-16', 5),
(28, 'Exodus', 'Bob Marley masterpiece', 29.00, 'very_good_plus', 'very_good', 9, 'lp', '1977-06-03', 3),
(29, 'Wish You Were Here', 'Pink Floyd tribute', 46.00, 'very_good', 'good', 8, 'lp', '1975-09-12', 2),
(30, 'Blood on the Tracks', 'Bob Dylan masterpiece', 40.00, 'good', 'fair', 7, 'lp', '1975-09-19', 1),
(31, 'Exile on Main St.', 'Rolling Stones double', 58.00, 'near_mint', 'near_mint', 4, 'lp', '1972-05-12', 2),
(32, 'The Song Remains the Same', 'Led Zeppelin live', 54.00, 'very_good', 'very_good', 5, 'lp', '1976-07-14', 2),
(33, 'Bad', 'Michael Jackson follow up', 26.00, 'good', 'good', 16, 'lp', '1987-08-31', 1),
(34, 'A Night at the Opera', 'Queen masterpiece', 44.00, 'near_mint', 'mint', 7, 'lp', '1975-11-21', 2),
(35, 'St. Anger', 'Metallica controversial', 22.00, 'poor', 'poor', 20, 'cd_album', '2003-06-05', 1),
(36, 'Black Star', 'David Bowie final album', 35.00, 'near_mint', 'near_mint', 9, 'lp', '2016-01-01', 2),
(37, 'The Miseducation of Lauryn Hill', 'Neo soul classic', 28.00, 'good', 'good', 14, 'cd_album', '1998-08-25', 1),
(38, 'Blue Train', 'John Coltrane classic', 48.00, 'very_good', 'good', 6, 'lp', '1957-02-21', 1),
(39, 'Time Out', 'Dave Brubeck quartet', 38.00, 'very_good_plus', 'very_good', 8, 'lp', '1959-10-21', 1),
(40, 'Electric Ladyland', 'Jimi Hendrix finale', 52.00, 'fair', 'good', 5, 'lp', '1968-10-25', 1),
(41, 'Are You Experienced', 'Jimi Hendrix debut', 45.00, 'good', 'fair', 7, 'lp', '1967-05-12', 2),
(42, 'Goodbye Yellow Brick Road', 'Elton John epic', 36.00, 'very_good', 'very_good', 11, 'lp', '1973-10-05', 2),
(43, 'Hotel California', 'Eagles classic', 32.00, 'good', 'good', 13, 'lp', '1976-12-10', 1),
(44, 'Saturday Night Fever', 'Bee Gees soundtrack', 24.00, 'good', 'good', 18, 'lp', '1977-11-15', 1),
(45, 'The Bodyguard', 'Whitney Houston soundtrack', 22.00, 'very_good', 'very_good', 15, 'cd_album', '1992-11-25', 1),
(46, 'Back to the Future', 'Alan Silvestri soundtrack', 26.00, 'very_good_plus', 'good', 12, 'lp', '1985-07-03', 1),
(47, 'Purple', 'Stone Temple Pilots grunge', 30.00, 'good', 'good', 10, 'lp', '1992-09-29', 1),
(48, 'Ten', 'Pearl Jam debut', 34.00, 'very_good', 'very_good', 9, 'lp', '1991-08-27', 1),
(49, 'In Utero', 'Nirvana final studio', 38.00, 'near_mint', 'near_mint', 8, 'lp', '1993-09-21', 1),
(50, 'Use Your Illusion I', 'Guns N Roses epic', 42.00, 'very_good', 'very_good', 7, 'lp', '1991-09-17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `record_artists`
--

CREATE TABLE `record_artists` (
  `record_id` int NOT NULL,
  `artist_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `record_artists`
--

INSERT INTO `record_artists` (`record_id`, `artist_id`) VALUES
(1, 1),
(2, 2),
(3, 6),
(4, 7),
(5, 31),
(6, 28),
(7, 23),
(8, 3),
(9, 2),
(10, 41),
(11, 45),
(12, 20),
(13, 21),
(14, 22),
(15, 26),
(16, 27),
(17, 1),
(18, 41),
(19, 42),
(20, 3),
(21, 20),
(22, 22),
(23, 21),
(24, 21),
(25, 25),
(26, 45),
(27, 46),
(28, 47),
(29, 2),
(30, 14),
(31, 5),
(32, 3),
(33, 6),
(34, 9),
(35, 27),
(36, 2),
(37, 45),
(38, 42),
(39, 42),
(40, 15),
(41, 5),
(42, 6),
(43, 14),
(44, 14),
(45, 39),
(46, 26),
(47, 27),
(48, 29),
(49, 28),
(50, 29);

-- --------------------------------------------------------

--
-- Table structure for table `record_credits`
--

CREATE TABLE `record_credits` (
  `id` int NOT NULL,
  `record_id` int NOT NULL,
  `artist_id` int NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `record_credits`
--

INSERT INTO `record_credits` (`id`, `record_id`, `artist_id`, `role`) VALUES
(103, 1, 1, 'Vocals, Guitar'),
(104, 1, 1, 'Producer'),
(105, 2, 2, 'Vocals, Guitar'),
(106, 2, 8, 'Producer'),
(107, 3, 6, 'Vocals'),
(108, 3, 6, 'Dance'),
(109, 4, 7, 'Vocals, Guitar'),
(110, 4, 10, 'Guitar'),
(111, 5, 31, 'Vocals'),
(112, 5, 32, 'Vocals'),
(113, 6, 28, 'Vocals'),
(114, 6, 29, 'Vocals'),
(115, 7, 23, 'Vocals, Guitar'),
(116, 7, 50, 'Vocals'),
(117, 8, 3, 'Main Artist'),
(118, 8, 49, 'Guitar'),
(119, 9, 2, 'Vocals, Guitar'),
(120, 9, 22, 'Guitar'),
(121, 10, 41, 'Trumpet'),
(122, 10, 42, 'Piano'),
(123, 11, 45, 'Vocals'),
(124, 11, 48, 'Guitar'),
(125, 12, 20, 'Vocals'),
(126, 12, 40, 'Producer'),
(127, 13, 21, 'Main Artist'),
(128, 13, 59, 'Keyboards'),
(129, 14, 22, 'Vocals, Guitar'),
(130, 14, 60, 'Bass'),
(131, 15, 26, 'Vocals'),
(132, 15, 27, 'Drums'),
(133, 16, 27, 'Vocals, Guitar'),
(134, 16, 11, 'Drums'),
(135, 17, 1, 'Vocals'),
(136, 17, 4, 'Guitar'),
(137, 18, 41, 'Saxophone'),
(138, 18, 43, 'Drums'),
(139, 19, 42, 'Saxophone'),
(140, 19, 12, 'Saxophone'),
(141, 20, 3, 'Main Artist'),
(142, 20, 31, 'Guitar'),
(143, 21, 20, 'Vocals'),
(144, 21, 19, 'Producer'),
(145, 22, 22, 'Vocals'),
(146, 22, 18, 'Producer'),
(147, 23, 21, 'Main Artist'),
(148, 23, 17, 'Producer'),
(149, 24, 21, 'Main Artist'),
(150, 24, 30, 'Vocals'),
(151, 25, 25, 'Main Artist'),
(152, 25, 26, 'Guitar'),
(153, 26, 45, 'Vocals'),
(154, 26, 46, 'Vocals'),
(155, 27, 46, 'Vocals'),
(156, 27, 47, 'Guitar'),
(157, 28, 47, 'Vocals'),
(158, 28, 48, 'Vocals'),
(159, 29, 2, 'Vocals, Guitar'),
(160, 29, 3, 'Bass'),
(161, 30, 14, 'Vocals, Guitar'),
(162, 30, 15, 'Guitar'),
(163, 31, 5, 'Vocals'),
(164, 31, 6, 'Guitar'),
(165, 32, 3, 'Main Artist'),
(166, 32, 7, 'Guitar'),
(167, 33, 6, 'Vocals'),
(168, 33, 4, 'Vocals'),
(169, 34, 9, 'Vocals'),
(170, 34, 8, 'Guitar'),
(171, 35, 27, 'Vocals'),
(172, 35, 11, 'Vocals'),
(173, 36, 2, 'Vocals'),
(174, 36, 1, 'Guitar'),
(175, 37, 45, 'Vocals'),
(176, 37, 43, 'Piano'),
(177, 38, 42, 'Saxophone'),
(178, 38, 41, 'Saxophone'),
(179, 39, 42, 'Piano'),
(180, 39, 41, 'Piano'),
(181, 40, 15, 'Vocals, Guitar'),
(182, 40, 10, 'Guitar'),
(183, 41, 5, 'Vocals'),
(184, 41, 15, 'Guitar'),
(185, 42, 6, 'Vocals'),
(186, 42, 4, 'Piano'),
(187, 43, 14, 'Vocals'),
(188, 43, 30, 'Guitar'),
(189, 44, 14, 'Vocals'),
(190, 44, 21, 'Vocals'),
(191, 45, 39, 'Vocals'),
(192, 45, 21, 'Vocals'),
(193, 46, 26, 'Composer'),
(194, 46, 18, 'Producer'),
(195, 47, 27, 'Vocals'),
(196, 47, 22, 'Vocals'),
(197, 48, 29, 'Vocals'),
(198, 48, 20, 'Vocals'),
(199, 49, 28, 'Vocals'),
(200, 49, 26, 'Vocals'),
(201, 50, 29, 'Vocals'),
(202, 50, 24, 'Vocals');

-- --------------------------------------------------------

--
-- Table structure for table `record_genres`
--

CREATE TABLE `record_genres` (
  `record_id` int NOT NULL,
  `genre_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `record_genres`
--

INSERT INTO `record_genres` (`record_id`, `genre_id`) VALUES
(1, 1),
(1, 6),
(1, 14),
(2, 1),
(2, 6),
(2, 32),
(3, 2),
(3, 16),
(3, 20),
(4, 1),
(4, 2),
(4, 15),
(5, 1),
(5, 14),
(5, 15),
(6, 1),
(6, 12),
(6, 13),
(7, 1),
(7, 2),
(8, 1),
(8, 12),
(8, 13),
(9, 1),
(9, 6),
(9, 32),
(10, 4),
(10, 37),
(11, 9),
(11, 20),
(12, 2),
(12, 3),
(12, 31),
(13, 18),
(13, 44),
(14, 1),
(14, 6),
(14, 32),
(15, 1),
(15, 12),
(16, 1),
(16, 12),
(16, 13),
(17, 1),
(17, 6),
(17, 14),
(18, 4),
(18, 50),
(19, 4),
(19, 15),
(19, 37),
(20, 1),
(20, 6),
(20, 12),
(21, 2),
(21, 3),
(21, 31),
(22, 2),
(22, 3),
(22, 31),
(23, 18),
(23, 44),
(24, 2),
(24, 6),
(24, 44),
(25, 1),
(25, 12),
(25, 15),
(26, 10),
(26, 15),
(27, 4),
(27, 21),
(27, 35),
(28, 9),
(28, 20),
(29, 1),
(29, 6),
(29, 32),
(30, 1),
(30, 14),
(31, 1),
(31, 10),
(31, 14),
(32, 1),
(32, 6),
(32, 14),
(33, 2),
(33, 15),
(33, 16),
(34, 1),
(34, 12),
(34, 13),
(35, 1),
(35, 12),
(35, 13),
(36, 1),
(36, 32),
(37, 2),
(37, 15),
(37, 37),
(38, 4),
(38, 37),
(39, 4),
(39, 37),
(40, 1),
(40, 12),
(40, 15),
(41, 1),
(41, 12),
(41, 15),
(42, 2),
(42, 16),
(42, 35),
(43, 2),
(43, 16),
(43, 35),
(44, 2),
(44, 15),
(44, 35),
(45, 34),
(45, 35),
(46, 1),
(46, 12),
(46, 31),
(47, 1),
(47, 12),
(47, 31),
(48, 1),
(48, 12),
(48, 31),
(49, 1),
(49, 12),
(49, 32),
(50, 1),
(50, 12),
(50, 31);

-- --------------------------------------------------------

--
-- Table structure for table `record_labels`
--

CREATE TABLE `record_labels` (
  `record_id` int NOT NULL,
  `label_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `record_labels`
--

INSERT INTO `record_labels` (`record_id`, `label_id`) VALUES
(1, 1),
(1, 6),
(1, 37),
(2, 20),
(2, 37),
(3, 1),
(3, 9),
(4, 1),
(4, 4),
(5, 4),
(6, 5),
(6, 10),
(7, 37),
(8, 4),
(9, 20),
(9, 37),
(10, 11),
(10, 47),
(11, 10),
(12, 33),
(12, 50),
(13, 21),
(13, 22),
(14, 18),
(14, 37),
(15, 16),
(16, 10),
(17, 6),
(17, 37),
(18, 47),
(18, 48),
(19, 11),
(19, 47),
(20, 4),
(21, 30),
(21, 33),
(22, 1),
(22, 37),
(23, 21),
(23, 22),
(24, 20),
(24, 21),
(25, 19),
(26, 10),
(27, 1),
(28, 7),
(29, 20),
(29, 37),
(30, 1),
(31, 4),
(32, 4),
(33, 1),
(33, 9),
(34, 6),
(35, 6),
(36, 1),
(36, 2),
(37, 15),
(38, 11),
(38, 47),
(39, 11),
(39, 47),
(40, 6),
(41, 6),
(42, 1),
(42, 37),
(43, 1),
(43, 37),
(44, 1),
(44, 37),
(45, 1),
(45, 37),
(46, 4),
(46, 19),
(47, 4),
(47, 19),
(48, 4),
(48, 19),
(49, 10),
(50, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE `tracks` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `duration` varchar(20) DEFAULT NULL,
  `position` int DEFAULT NULL,
  `side` varchar(10) DEFAULT NULL,
  `record_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tracks`
--

INSERT INTO `tracks` (`id`, `title`, `duration`, `position`, `side`, `record_id`) VALUES
(1, 'Come Together', '4:20', 1, 'A', 1),
(2, 'Something', '3:02', 2, 'A', 1),
(3, 'Here Comes the Sun', '3:05', 3, 'A', 1),
(4, 'Octopus Garden', '2:50', 4, 'A', 1),
(5, 'The End', '2:52', 5, 'B', 1),
(6, 'Speak to Me', '1:30', 1, 'A', 2),
(7, 'Breathe', '2:43', 2, 'A', 2),
(8, 'Time', '6:53', 3, 'A', 2),
(9, 'Money', '6:22', 4, 'A', 2),
(10, 'Eclipse', '2:03', 5, 'B', 2),
(11, 'Wanna Be Startin Somethin', '6:03', 1, 'A', 3),
(12, 'Thriller', '5:57', 2, 'A', 3),
(13, 'Beat It', '4:18', 3, 'A', 3),
(14, 'Billie Jean', '4:54', 4, 'A', 3),
(15, 'Human Nature', '3:44', 5, 'B', 3),
(16, 'Let s Go Crazy', '4:39', 1, 'A', 4),
(17, 'Purple Rain', '8:41', 2, 'A', 4),
(18, 'When Doves Cry', '5:53', 3, 'A', 4),
(19, 'I Would Die 4 U', '2:49', 4, 'A', 4),
(20, 'Baby I m a Star', '4:23', 5, 'B', 4),
(21, 'Second Hand News', '2:56', 1, 'A', 5),
(22, 'Dreams', '4:14', 2, 'A', 5),
(23, 'Don t Stop', '3:13', 3, 'A', 5),
(24, 'Go Your Own Way', '3:43', 4, 'A', 5),
(25, 'The Chain', '4:30', 5, 'B', 5),
(26, 'Shoot to Thrill', '5:17', 1, 'A', 6),
(27, 'Hells Bells', '5:12', 2, 'A', 6),
(28, 'Back in Black', '4:15', 3, 'A', 6),
(29, 'You Shook Me', '6:28', 4, 'A', 6),
(30, 'Rock and Roll Ain t Noise Pollution', '4:04', 5, 'B', 6),
(31, 'Where the Streets Have No Name', '5:56', 1, 'A', 7),
(32, 'I Still Haven t Found What I m Looking For', '4:57', 2, 'A', 7),
(33, 'Bullet the Blue Sky', '4:31', 3, 'A', 7),
(34, 'Running to Stand Still', '4:18', 4, 'A', 7),
(35, 'The Joshua Tree', '5:53', 5, 'B', 7),
(36, 'Black Mountain Side', '2:12', 1, 'A', 8),
(37, 'Immigrant Song', '4:25', 2, 'A', 8),
(38, 'Stairway to Heaven', '8:02', 3, 'A', 8),
(39, 'Rock and Roll', '3:40', 4, 'A', 8),
(40, 'When the Levee Breaks', '7:08', 5, 'B', 8),
(41, 'In the Flesh', '4:19', 1, 'A', 9),
(42, 'The Thin Ice', '2:27', 2, 'A', 9),
(43, 'Another Brick in the Wall Part 2', '3:11', 3, 'A', 9),
(44, 'Mother', '5:32', 4, 'A', 9),
(45, 'Comfortably Numb', '6:24', 5, 'B', 9),
(46, 'So What', '9:22', 1, 'A', 10),
(47, 'Freddie Freeloader', '5:42', 2, 'A', 10),
(48, 'Blue in Green', '5:37', 3, 'A', 10),
(49, 'All Blues', '11:33', 4, 'B', 10),
(50, 'Lively Up Yourself', '5:10', 1, 'A', 11),
(51, 'No Woman No Cry', '3:50', 2, 'A', 11),
(52, 'Them Belly Full', '3:15', 3, 'A', 11),
(53, 'Exodus', '8:33', 4, 'A', 11),
(54, 'One Love', '2:51', 5, 'B', 11),
(55, 'The Real Slim Shady', '4:44', 1, 'A', 12),
(56, 'The Way I m Feeling', '5:08', 2, 'A', 12),
(57, 'Stan', '6:14', 3, 'A', 12),
(58, 'The Bad Guys', '4:37', 4, 'A', 12),
(59, 'Kim', '6:03', 5, 'B', 12),
(60, 'Give Life Back to Music', '4:10', 1, 'A', 13),
(61, 'The Game of Love', '5:23', 2, 'A', 13),
(62, 'Giorgio by Moroder', '8:24', 3, 'A', 13),
(63, 'Instant Crush', '5:37', 4, 'A', 13),
(64, 'Get Lucky', '6:09', 5, 'B', 13),
(65, 'Airbag', '4:33', 1, 'A', 14),
(66, 'Paranoid Android', '6:23', 2, 'A', 14),
(67, 'Subterranean Homesick Alien', '4:27', 3, 'A', 14),
(68, 'Exit Music', '4:24', 4, 'A', 14),
(69, 'Let Down', '4:59', 5, 'B', 14),
(70, 'Smells Like Teen Spirit', '5:01', 1, 'A', 15),
(71, 'In Bloom', '4:14', 2, 'A', 15),
(72, 'Come as You Are', '3:39', 3, 'A', 15),
(73, 'Breed', '3:03', 4, 'A', 15),
(74, 'Lithium', '4:17', 5, 'B', 15),
(75, 'Battery', '5:13', 1, 'A', 16),
(76, 'Master of Puppets', '8:35', 2, 'A', 16),
(77, 'The Thing That Should Not Be', '6:36', 3, 'A', 16),
(78, 'Welcome Home', '6:27', 4, 'A', 16),
(79, 'Orion', '8:27', 5, 'B', 16),
(80, 'Sgt. Peppers Lonely Hearts Club Band', '2:03', 1, 'A', 17),
(81, 'With a Little Help from My Friends', '4:42', 2, 'A', 17),
(82, 'Lucy in the Sky with Diamonds', '5:57', 3, 'A', 17),
(83, 'A Day in the Life', '5:05', 4, 'A', 17),
(84, 'All You Need is Love', '3:50', 5, 'B', 17),
(85, 'Lonely Woman', '5:23', 1, 'A', 18),
(86, 'The Shape of Jazz to Come', '4:45', 2, 'A', 18),
(87, 'Ramblin', '6:12', 3, 'A', 18),
(88, 'Peace', '8:23', 4, 'B', 18),
(89, 'A Love Supreme Part I Acknowledgement', '7:45', 1, 'A', 19),
(90, 'A Love Supreme Part II Resolution', '7:03', 2, 'A', 19),
(91, 'A Love Supreme Part III Pursuance', '10:42', 3, 'A', 19),
(92, 'A Love Supreme Part IV Psalm', '6:59', 4, 'B', 19),
(93, 'Custard Pie', '4:13', 1, 'A', 20),
(94, 'The Rover', '5:38', 2, 'A', 20),
(95, 'In the Light', '8:02', 3, 'A', 20),
(96, 'Kashmir', '8:37', 4, 'A', 20),
(97, 'Ten Years Gone', '6:31', 5, 'B', 20),
(98, 'Straight Outta Compton', '4:18', 1, 'A', 21),
(99, 'F*** Tha Police', '5:45', 2, 'A', 21),
(100, 'Gangsta Gangsta', '4:36', 3, 'A', 21),
(101, 'Express Yourself', '4:25', 4, 'A', 21),
(102, 'No Vaseline', '4:52', 5, 'B', 21),
(103, 'N.Y. State of Mind', '4:53', 1, 'A', 22),
(104, 'Halftime', '4:19', 2, 'A', 22),
(105, 'It Ain t Hard to Tell', '4:26', 3, 'A', 22),
(106, 'The World Is Yours', '4:31', 4, 'A', 22),
(107, 'One Love', '5:27', 5, 'B', 22),
(108, 'One More Time', '5:20', 1, 'A', 23),
(109, 'Digital Love', '4:58', 2, 'A', 23),
(110, 'Harder Better Faster Stronger', '3:44', 3, 'A', 23),
(111, 'Crescendolls', '3:51', 4, 'A', 23),
(112, 'Superheroes', '3:57', 5, 'B', 23),
(113, 'Hunter', '4:14', 1, 'A', 24),
(114, 'JÃ³ga', '5:04', 2, 'A', 24),
(115, 'Unravel', '3:23', 3, 'A', 24),
(116, 'All Is Full of Love', '4:59', 4, 'A', 24),
(117, 'Bachelorette', '5:12', 5, 'B', 24),
(118, 'Sunday Morning', '4:55', 1, 'A', 25),
(119, 'I m Waiting for the Man', '4:00', 2, 'A', 25),
(120, 'Femme Fatale', '2:35', 3, 'A', 25),
(121, 'Venus in Furs', '5:12', 4, 'A', 25),
(122, 'Run Run Run', '4:21', 5, 'B', 25),
(123, 'Family Affair', '5:14', 1, 'A', 26),
(124, 'Everyday People', '2:25', 2, 'A', 26),
(125, 'Thank You Falettinme Be Mice Elf Agin', '4:52', 3, 'A', 26),
(126, 'You Caught Me Smiling', '2:13', 4, 'A', 26),
(127, 'Thank You Love', '6:15', 5, 'B', 26),
(128, 'Chan Chan', '4:15', 1, 'A', 27),
(129, 'De Camino a La Vereda', '4:42', 2, 'A', 27),
(130, 'El Cuarto de Tula', '7:27', 3, 'A', 27),
(131, 'Bucaramanga', '3:12', 4, 'A', 27),
(132, 'La Yuca', '4:26', 5, 'B', 27),
(133, 'Natural Mystic', '3:34', 1, 'A', 28),
(134, 'Positive Vibration', '3:26', 2, 'A', 28),
(135, 'Exodus', '8:33', 3, 'A', 28),
(136, 'One Love', '2:51', 4, 'A', 28),
(137, 'Three Little Birds', '3:02', 5, 'B', 28),
(138, 'Shine On You Crazy Diamond Parts I-V', '13:29', 1, 'A', 29),
(139, 'Welcome to the Machine', '7:31', 2, 'A', 29),
(140, 'Have a Cigar', '5:08', 3, 'A', 29),
(141, 'Wish You Were Here', '5:40', 4, 'A', 29),
(142, 'Shine On You Crazy Diamond Parts VI-IX', '12:28', 5, 'B', 29),
(143, 'Tangled Up in Blue', '5:42', 1, 'A', 30),
(144, 'Simple Twist of Fate', '4:28', 2, 'A', 30),
(145, 'Shelter from the Storm', '5:01', 3, 'A', 30),
(146, 'Buckets of Rain', '3:33', 4, 'A', 30),
(147, 'Idiot Wind', '7:48', 5, 'B', 30),
(148, 'Blue Hawaii', '3:02', 1, 'A', 31),
(149, 'Can t Help Falling in Love', '3:02', 2, 'A', 31),
(150, 'Love Me Tender', '3:08', 3, 'A', 31),
(151, 'Heartbreak Hotel', '2:08', 4, 'A', 31),
(152, 'Hound Dog', '2:14', 5, 'B', 31),
(153, 'Purple Rain', '8:41', 1, 'A', 32),
(154, '1999', '3:43', 2, 'A', 32),
(155, 'Kiss', '3:31', 3, 'A', 32),
(156, 'When Doves Cry', '5:53', 4, 'A', 32),
(157, 'Let s Go Crazy', '4:39', 5, 'B', 32),
(158, 'Bad', '4:02', 1, 'A', 33),
(159, 'The Way You Make Me Feel', '4:58', 2, 'A', 33),
(160, 'Man in the Mirror', '5:19', 3, 'A', 33),
(161, 'Smooth Criminal', '4:17', 4, 'A', 33),
(162, 'Leave Me Alone', '4:05', 5, 'B', 33),
(163, 'Bohemian Rhapsody', '5:55', 1, 'A', 34),
(164, 'Killer Queen', '3:01', 2, 'A', 34),
(165, 'Somebody to Love', '4:56', 3, 'A', 34),
(166, 'Crazy Little Thing Called Love', '2:44', 4, 'A', 34),
(167, 'We Will Rock You', '2:12', 5, 'B', 34),
(168, 'St. Anger', '5:50', 1, 'A', 35),
(169, 'Some Kind of Monster', '4:08', 2, 'A', 35),
(170, 'Dirty Window', '5:24', 3, 'A', 35),
(171, 'Invisible Kid', '8:30', 4, 'A', 35),
(172, 'My World', '5:45', 5, 'B', 35),
(173, 'Blackstar', '10:09', 1, 'A', 36),
(174, 'Lazarus', '6:22', 2, 'A', 36),
(175, 'Tis a Pity She Was a Whore', '4:28', 3, 'A', 36),
(176, 'Girl Who Loves the Stars', '4:54', 4, 'A', 36),
(177, 'Dollar', '3:26', 5, 'B', 36),
(178, 'Intro', '1:28', 1, 'A', 37),
(179, 'Lost Ones', '5:26', 2, 'A', 37),
(180, 'To Zion', '6:08', 3, 'A', 37),
(181, 'Doo Wop', '3:15', 4, 'A', 37),
(182, 'Everything Is Everything', '4:54', 5, 'B', 37),
(183, 'Blue Train', '7:58', 1, 'A', 38),
(184, 'Moment s Notice', '9:10', 2, 'A', 38),
(185, 'Locomotion', '6:52', 3, 'A', 38),
(186, 'Lazy Bird', '7:04', 4, 'B', 38),
(187, 'Take Five', '5:24', 1, 'A', 39),
(188, 'Four Brothers', '7:57', 2, 'A', 39),
(189, 'In Your Own Sweet Way', '5:53', 3, 'A', 39),
(190, 'The Duke', '5:09', 4, 'A', 39),
(191, 'St. Louis Blues', '7:03', 5, 'B', 39),
(192, 'Purple Haze', '2:51', 1, 'A', 40),
(193, 'Hey Joe', '6:58', 2, 'A', 40),
(194, 'Wind Cries Mary', '3:21', 3, 'A', 40),
(195, 'All Along the Watchtower', '3:14', 4, 'A', 40),
(196, 'Voodoo Child', '4:40', 5, 'B', 40),
(197, 'Foxy Lady', '3:19', 1, 'A', 41),
(198, 'Manic Depression', '3:42', 2, 'A', 41),
(199, 'Red House', '3:40', 3, 'A', 41),
(200, 'Can You See Me', '2:33', 4, 'B', 41),
(201, 'Love or Confusion', '3:11', 5, 'B', 41),
(202, 'Funeral for a Friend', '11:09', 1, 'A', 42),
(203, 'Candle in the Wind', '3:50', 2, 'A', 42),
(204, 'Bennie and the Jets', '5:23', 3, 'A', 42),
(205, 'Goodbye Yellow Brick Road', '3:13', 4, 'B', 42),
(206, 'Saturday Night s Alright', '4:57', 5, 'B', 42),
(207, 'Hotel California', '6:30', 1, 'A', 43),
(208, 'New Kid in Town', '5:04', 2, 'A', 43),
(209, 'Life in the Fast Lane', '4:46', 3, 'A', 43),
(210, 'Wasted Time', '4:55', 4, 'B', 43),
(211, 'Victim of Love', '4:11', 5, 'B', 43),
(212, 'Stayin Alive', '4:45', 1, 'A', 44),
(213, 'How Deep Is Your Love', '4:05', 2, 'A', 44),
(214, 'Night Fever', '3:30', 3, 'A', 44),
(215, 'More Than a Woman', '3:17', 4, 'B', 44),
(216, 'If I Can t Have You', '3:00', 5, 'B', 44),
(217, 'I Will Always Love You', '4:31', 1, 'A', 45),
(218, 'I Have Nothing', '4:49', 2, 'A', 45),
(219, 'I m Every Woman', '4:45', 3, 'A', 45),
(220, 'Run to You', '4:24', 4, 'B', 45),
(221, 'Queen of the Night', '3:09', 5, 'B', 45),
(222, 'The Power of Love', '3:53', 1, 'A', 46),
(223, 'Time Bomb', '2:46', 2, 'A', 46),
(224, 'Back in Time', '4:17', 3, 'A', 46),
(225, 'Heaven is One Step Away', '4:08', 4, 'B', 46),
(226, 'Mr. Sandman', '2:04', 5, 'B', 46),
(227, 'Meat Plow', '3:37', 1, 'A', 47),
(228, 'Vasoline', '2:56', 2, 'A', 47),
(229, 'Lounge Fly', '5:18', 3, 'A', 47),
(230, 'Interstate Love Song', '3:14', 4, 'B', 47),
(231, 'Still Remains', '3:33', 5, 'B', 47),
(232, 'Once', '3:51', 1, 'A', 48),
(233, 'Even Flow', '4:53', 2, 'A', 48),
(234, 'Alive', '5:40', 3, 'A', 48),
(235, 'Jeremy', '5:18', 4, 'B', 48),
(236, 'Black', '5:43', 5, 'B', 48),
(237, 'Serve the Servants', '3:36', 1, 'A', 49),
(238, 'Scentless Apprentice', '3:48', 2, 'A', 49),
(239, 'Heart-Shaped Box', '4:41', 3, 'A', 49),
(240, 'Rape Me', '2:50', 4, 'B', 49),
(241, 'Dumb', '2:32', 5, 'B', 49),
(242, 'Right Next Door to Hell', '3:02', 1, 'A', 50),
(243, 'Dust N Bones', '4:58', 2, 'A', 50),
(244, 'Live and Let Die', '3:04', 3, 'A', 50),
(245, 'Don t Cry', '4:44', 4, 'B', 50),
(246, 'November Rain', '8:57', 5, 'B', 50);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_images_product` (`record_id`);

--
-- Indexes for table `labels`
--
ALTER TABLE `labels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_products_country` (`country_id`);

--
-- Indexes for table `record_artists`
--
ALTER TABLE `record_artists`
  ADD PRIMARY KEY (`record_id`,`artist_id`),
  ADD KEY `idx_product_artists_product` (`record_id`),
  ADD KEY `idx_product_artists_artist` (`artist_id`);

--
-- Indexes for table `record_credits`
--
ALTER TABLE `record_credits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_credits_product` (`record_id`),
  ADD KEY `idx_product_credits_artist` (`artist_id`);

--
-- Indexes for table `record_genres`
--
ALTER TABLE `record_genres`
  ADD PRIMARY KEY (`record_id`,`genre_id`),
  ADD KEY `idx_product_genres_product` (`record_id`),
  ADD KEY `idx_product_genres_genre` (`genre_id`);

--
-- Indexes for table `record_labels`
--
ALTER TABLE `record_labels`
  ADD PRIMARY KEY (`record_id`,`label_id`),
  ADD KEY `idx_product_labels_product` (`record_id`),
  ADD KEY `idx_product_labels_label` (`label_id`);

--
-- Indexes for table `tracks`
--
ALTER TABLE `tracks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tracks_product` (`record_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `labels`
--
ALTER TABLE `labels`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `record_credits`
--
ALTER TABLE `record_credits`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `tracks`
--
ALTER TABLE `tracks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `records` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `records`
--
ALTER TABLE `records`
  ADD CONSTRAINT `records_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `record_artists`
--
ALTER TABLE `record_artists`
  ADD CONSTRAINT `record_artists_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `records` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `record_artists_ibfk_2` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `record_credits`
--
ALTER TABLE `record_credits`
  ADD CONSTRAINT `record_credits_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `records` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `record_credits_ibfk_2` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `record_genres`
--
ALTER TABLE `record_genres`
  ADD CONSTRAINT `record_genres_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `records` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `record_genres_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `record_labels`
--
ALTER TABLE `record_labels`
  ADD CONSTRAINT `record_labels_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `records` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `record_labels_ibfk_2` FOREIGN KEY (`label_id`) REFERENCES `labels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tracks`
--
ALTER TABLE `tracks`
  ADD CONSTRAINT `tracks_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `records` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
