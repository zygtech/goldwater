-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 21, 2017 at 12:28 PM
-- Server version: 10.1.29-MariaDB-6
-- PHP Version: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yourinvoice`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `company` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `www` varchar(50) NOT NULL,
  `info` text NOT NULL,
  `folder` varchar(50) NOT NULL,
  `category` varchar(20) NOT NULL,
  `priority` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `fullname`, `company`, `address`, `mobile`, `mail`, `www`, `info`, `folder`, `category`, `priority`) VALUES
(1, 'Andrew Smith', 'TEST Ltd.', 'West Street 12\r\nLondon, UK', '+44 786 645 3453', 'andrew@test.com', 'http://www.test.com/', '', 'C:\\Clients\\Test\\', 'ACTIVE', 1),
(2, 'Thomas Brown', 'SECOND Inc.', 'North Street 3\r\nLondon, UK', '+44 754 566 3341', 'thomas@second.com', 'http://www.second.com/', '', 'C:\\Clients\\Second\\', 'ACTIVE', 3),
(3, 'Peter Levi', 'Systems Inc.', 'South Street 16\r\nLondon, UK', '+44 843 342 5119', 'peter@systems.com', 'http://www.systems.com/', '', 'C:\\Clients\\Systems\\', 'FREEZE', 3),
(4, '', 'New Company Ltd.', '', '', '', '', '', '', 'NEW', 3);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `clientinfo` text NOT NULL,
  `description` text NOT NULL,
  `quantity` text NOT NULL,
  `amount` text NOT NULL,
  `total` int(11) NOT NULL,
  `creation` date NOT NULL,
  `added` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `client`, `clientinfo`, `description`, `quantity`, `amount`, `total`, `creation`, `added`) VALUES
(1, 1, 'TEST Ltd.\nAndrew Smith\nWest Street 12\r\nLondon, UK\n', 'A6 Leaflets\r\nDesign', '1500\r\n1', '1.45\r\n500', 2675, '2017-09-20', 'test'),
(2, 2, 'SECOND Inc.\nThomas Brown\nNorth Street 3\r\nLondon, UK\n', 'Big posters - printing\r\nBig posters - projects', '3\r\n7', '130\r\n50', 740, '2017-09-20', 'test'),
(3, 3, 'Systems Inc.\nPeter Levi\nSouth Street 16\r\nLondon, UK\n', 'Printing\r\nDesign', '100\r\n1', '10\r\n500', 1500, '2017-11-05', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `client` int(11) NOT NULL,
  `description` text NOT NULL,
  `creation` date NOT NULL,
  `stage` varchar(20) NOT NULL,
  `info` text NOT NULL,
  `added` varchar(20) NOT NULL,
  `finished` date DEFAULT NULL,
  `required` date NOT NULL,
  `priority` smallint(6) NOT NULL,
  `archive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `name`, `client`, `description`, `creation`, `stage`, `info`, `added`, `finished`, `required`, `priority`, `archive`) VALUES
(1, 'A5 Leaflets', 1, '', '2017-09-20', '9-Finished', '', 'test', '2017-09-20', '2017-11-10', 3, 1),
(2, 'Big poster', 2, '', '2017-09-20', '8-Printing', '', 'test', NULL, '2017-11-10', 1, 0),
(3, 'Business cards', 2, '', '2017-09-20', '9-Finished', '', 'test', '2017-09-20', '2017-10-06', 3, 1),
(4, 'Brochures', 3, '', '2017-09-20', '4-Project', '', 'test', NULL, '2017-10-06', 3, 0),
(5, 'Posters printing', 4, '', '2017-09-20', '6-Acceptation', '', 'test', NULL, '2017-10-19', 3, 0),
(6, 'A6 Leaflets', 2, '', '2017-09-20', '5-Send to client', '', 'test', NULL, '2017-11-24', 3, 0),
(7, 'Business cards', 1, '', '2017-09-20', '2-Valuation', '', 'test', NULL, '2017-10-27', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `client` int(11) NOT NULL,
  `clientinfo` text NOT NULL,
  `description` text NOT NULL,
  `creation` date NOT NULL,
  `added` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`id`, `name`, `client`, `clientinfo`, `description`, `creation`, `added`) VALUES
(1, 'Business cards', 1, 'TEST Ltd.\nAndrew Smith\nWest Street 12\r\nLondon, UK\n', 'Business cards\r\nTest', '2017-09-20', 'test'),
(2, 'Our Offer', 3, 'Systems Inc.\nPeter Levi\nSouth Street 16\r\nLondon, UK\n', 'Business Cards\r\nLeaflets\r\nPosters', '2017-09-20', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `job` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `added` varchar(20) NOT NULL,
  `archive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `job`, `name`, `added`, `archive`) VALUES
(2, 4, 'Check brochures', 'test', 1),
(3, 4, 'Send brochures', 'test', 0),
(4, 2, 'Big poster design', 'test', 0),
(5, 2, 'Big poster printing', 'test', 1),
(6, 5, 'Check printer inks', 'test', 0),
(7, 6, 'Leaflets preparation', 'test', 0),
(8, 7, 'Business cards printing', 'test', 1),
(9, 7, 'Business cards cutting', 'test', 0),
(10, 2, 'Prepare our mission', 'thomas', 0),
(11, 5, 'Print those posters', 'thomas', 0),
(12, 6, 'A6 Design', 'johnny', 0),
(13, 6, 'A6 Print and cut', 'johnny', 0),
(14, 7, 'Business cards preparation', 'andrew', 0),
(15, 7, 'Business cards design', 'andrew', 0),
(16, 4, 'Check the design', 'mark', 0),
(17, 4, 'Prepare printers', 'mark', 0),
(18, 5, 'Order new ink', 'mark', 0),
(19, 2, 'Big poster editing', 'andrew', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mail`, `pass`) VALUES
(2, 'test', 'yourmail@company.com', '098f6bcd4621d373cade4e832627b4f6'),
(3, 'johnny', 'johnny@company.com', 'f4eb27cea7255cea4d1ffabf593372e8'),
(4, 'andrew', 'andrew@company.com', 'd914e3ecf6cc481114a3f534a5faf90b'),
(5, 'thomas', 'thomas@company.com', 'ef6e65efc188e7dffd7335b646a85a21'),
(6, 'mark', 'mark@company.com', 'ea82410c7a9991816b5eeeebe195e20a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
