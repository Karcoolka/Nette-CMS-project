-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jul 30, 2023 at 11:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
--
-- Database: `nette-cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `date_add` timestamp NOT NULL DEFAULT current_timestamp(),
  `has_picture` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `date_add`, `has_picture`, `title`, `url`, `short_description`, `description`) VALUES
(1, '2023-07-30 10:54:20', 0, 'Hippies', 'hippies', 'CO je to hnutí hippies.', 'Hippies [hipíz], jedn. čís. hippie (děti květin neboli ‚Květinové hnutí‘), je hnutí, které vzniklo v 60. letech v USA.\r\n\r\nJednalo se o  hnutí neorganizované, vycházející z generace beatniků. Samo slovo hippie je zdrobnělinou výrazu hipster, který beatnici často užívali k popisu nonkonformních hrdinů svých děl. Šířit se začalo v polovině 60. let ze západního pobřeží USA, ze San Francisca. Cíle „hippísáků“ byly nejednotné, za základní lze ale považovat vzpouru proti společnosti, mír, lásku, přátelství, svobodu. K naplnění těchto cílů se sdružovali do skupin či komun, které pak často provozovaly volnou lásku (free love). Často se užívaly drogy – zvláště psychedelické (LSD). Častým cílem byl někdy ale jen opak chování většinové společnosti a vyjádření protestu. Hippies propagovali spontánní chování, lásku a prosazovali názor, že si člověk má užít života a nebudovat kariéru, nehonit se za penězi. Příslušníci hippies nosili často dlouhé vlasy, volné oblečení a korálky a celkově prosazovali „primitivní“ vzhled jako projev negativní reakce proti estetice homogenní maskulinity v 30., 40. a 50. letech 20. století.\r\n\r\nDalším poměrně výrazným projevem spojeným s tímto hnutím bylo tíhnutí k mysticismu, různým druhům východních náboženství a filosofií, objevování na Západě doposud neznámých kultur a zvyků a jejich propojování se soudobou kulturou a způsobem uvažování.\r\n\r\nHippie móda měla zásadní vliv na populární hudbu, televizi, film, literaturu a výtvarné umění. Po 60. letech bylo mnoho aspektů asimilováno do většinové společnosti. Dědictví hippies lze pozorovat v soudobé kultuře v různých formách – od zdravé výživy, přes hudební festivaly po kybernetickou revoluci.'),
(2, '2023-07-30 10:05:31', 0, 'VW Transportery', '2-vw-transportery', 'Koukneme se na zoubek tranďákům.', '<p>Osobák nebo busík? :)</p>');

-- --------------------------------------------------------

--
-- Table structure for table `article_category`
--

CREATE TABLE `article_category` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `article_category`
--

INSERT INTO `article_category` (`id`, `article_id`, `category_id`) VALUES
(6, 1, 1),
(3, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `url`) VALUES
(1, 'Hippies', 'hippies'),
(2, 'VW transportery', 'transportery'),
(3, 'Ostatní', 'ostatni');

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `id` int(11) NOT NULL,
  `date_add` timestamp NOT NULL DEFAULT current_timestamp(),
  `on_homepage` int(11) DEFAULT 0,
  `has_picture` int(11) DEFAULT 0,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `date_add`, `on_homepage`, `has_picture`, `title`, `url`, `description`) VALUES
(1, '2020-03-15 10:54:29', 1, 1, 'Vítejte', 'vitejte', 'Toto je úvodní uvítací článek systému ArgoMi - RS.'),
(3, '2020-03-16 14:25:52', 0, 0, 'Servis', 'service', 'Obsah cms stránky servis.'),
(5, '2020-03-22 09:16:08', 0, 0, 'O Nás', 'o-nas', '<p>Stránka o systému ArgoMi - RS.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `date_add` timestamp NOT NULL DEFAULT current_timestamp(),
  `author_name` varchar(255) NOT NULL,
  `author_email` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `house_number` varchar(255) DEFAULT NULL,
  `zip` int(11) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `company`, `street`, `house_number`, `zip`, `city`, `state`, `email`, `phone`) VALUES
(1, 'Adély společnost pro psaní veselého webu.', 'Květinová', '69', 73101, 'Hronov', 'Česká republika', 'admin@local.cz', '+420 123 321 123');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role` enum('member','admin') NOT NULL DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `password`, `role`) VALUES
(1, 'it', 'network', 'cms@itnetwork.cz', '$2y$10$arJIJie/xGoqZayCro4yZ.pPEkt9Ps4DJBNZAHSZ/rvbOkj//K/tq', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article_category`
--
ALTER TABLE `article_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_category_unique` (`article_id`,`category_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_blog_articles_id_fk` (`article_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `article_category`
--
ALTER TABLE `article_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cms`
--
ALTER TABLE `cms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article_category`
--
ALTER TABLE `article_category`
  ADD CONSTRAINT `article_category_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `article_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_blog_posts_id_fk` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE;
COMMIT;
