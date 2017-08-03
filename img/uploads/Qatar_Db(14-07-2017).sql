-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2017 at 09:11 AM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shahzaib_qatar`
--

-- --------------------------------------------------------

--
-- Table structure for table `calculator`
--

CREATE TABLE IF NOT EXISTS `calculator` (
`id` int(11) NOT NULL,
  `skeleton` int(30) NOT NULL DEFAULT '1100',
  `turnkey` int(30) NOT NULL DEFAULT '1700'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calculator`
--

INSERT INTO `calculator` (`id`, `skeleton`, `turnkey`) VALUES
(6, 1500, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
`id` int(11) NOT NULL,
  `imageurl` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `location` varchar(60) NOT NULL,
  `description` longtext NOT NULL,
  `project_cat` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `imageurl`, `name`, `location`, `description`, `project_cat`) VALUES
(76, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/assets/uploads/projects/1499146734.jpg', 'Recent Project Name 2', 'Location 2', 'Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc', 1),
(77, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/assets/uploads/projects/1499146898.jpg', 'Active Project Name 1', 'Location 3', 'Active Project Desc 1', 2),
(78, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/assets/uploads/projects/1499146928.jpg', 'Recent Project Name 2', 'Location 4', 'Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2Recent Project Desc 2', 2),
(79, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/assets/uploads/projects/1499146978.jpg', 'Feature Project Name 1', 'Location 5', 'Feature Project Desc 1', 3),
(80, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/assets/uploads/projects/1499147005.jpg', 'Feature Project Name 2', 'Location 6', 'Feature Project Desc 2', 3),
(81, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/assets/uploads/projects/1499148969.jpg', 'Feature Project Name 2', 'Location 6', 'Feature Project Desc 2', 3),
(82, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/assets/uploads/projects/1499153440.jpg', 'test image 1', 'test location  1', 'test description 1', 1),
(83, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/assets/uploads/projects/1499810394.jpg', 'abcd', 'QATAR', 'This is the latest project', 1),
(85, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/assets/uploads/projects/1499810943.jpg', 'pqr', 'Doha', 'abcd efg', 1),
(86, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/assets/uploads/projects/1499810984.jpg', 'abcdef', 'Doha', 'adfgg hghghg ', 1),
(87, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/assets/uploads/projects/1499811091.jpg', 'fjhgjfgffgf', 'ndmmmfm', 'fdffdfdf', 2),
(88, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/assets/uploads/projects/1500004186.jpg', 'recent', 'recent', 'recent', 1);

-- --------------------------------------------------------

--
-- Table structure for table `header`
--

CREATE TABLE IF NOT EXISTS `header` (
`id` int(11) NOT NULL,
  `fb` varchar(70) NOT NULL,
  `twitter` varchar(70) NOT NULL,
  `insta` varchar(70) NOT NULL,
  `email` varchar(70) NOT NULL,
  `number` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `header`
--

INSERT INTO `header` (`id`, `fb`, `twitter`, `insta`, `email`, `number`) VALUES
(7, 'https://www.facebook.com/', 'https://twitter.com/Qatarislamic', 'https://www.instagram.com/', 'contactus@qatarislamic.com', 40164787);

-- --------------------------------------------------------

--
-- Table structure for table `linksorting`
--

CREATE TABLE IF NOT EXISTS `linksorting` (
`id` int(11) NOT NULL,
  `link` varchar(100) NOT NULL,
  `name` varchar(70) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `linksorting`
--

INSERT INTO `linksorting` (`id`, `link`, `name`, `order`) VALUES
(13, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/', 'Home', 1),
(14, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/home/about_view', 'About Us', 2),
(15, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/home/project_view', 'Our Projects', 3),
(16, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/home/calculate_view', 'Calculate Cost', 4),
(17, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/home/servicesmen_view', 'Services', 5),
(18, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/home/contact_view', 'CONTACT US', 6);

-- --------------------------------------------------------

--
-- Table structure for table `linksortingfooter`
--

CREATE TABLE IF NOT EXISTS `linksortingfooter` (
`id` int(11) NOT NULL,
  `link` varchar(150) NOT NULL,
  `name` varchar(70) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `linksortingfooter`
--

INSERT INTO `linksortingfooter` (`id`, `link`, `name`, `order`) VALUES
(1, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/home/about_view', 'About Us', 1),
(2, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/home/contact_view', 'Contact Us', 2),
(3, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/home/calculate_view', 'Calculate Cost', 3),
(4, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/home/servicesmen_view', 'Our Location', 4),
(5, 'http://110.37.221.34:7777/qatar/dev/qatarislamic/home/project_view', 'Our Projects', 5);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
`id` int(11) NOT NULL,
  `name1` varchar(150) NOT NULL,
  `description1` longtext NOT NULL,
  `name2` varchar(150) NOT NULL,
  `description2` longtext NOT NULL,
  `name3` varchar(150) NOT NULL,
  `description3` longtext NOT NULL,
  `name4` varchar(150) NOT NULL,
  `description4` longtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name1`, `description1`, `name2`, `description2`, `name3`, `description3`, `name4`, `description4`) VALUES
(38, 'GENERAL CONTRACTING FOR BUILDINGS', 'We work based on modern philosophy to integrate latest technology and best practices in order to complete projects efficiently and in a timely manner. We take a partnership approach to our client relationships tailoring our services to suit our client’s requirements guiding them through each step of the construction process. We provide construction, construction-management services to our clients; we will also manage your programme requirements through to successful delivery', 'BUILDING MATERIALS TRADING', 'We provide a range of construction material, tools and machinery for the industry. We host the best brands in the field.', 'CONTRACTING FOR BUILDINGS', '	We work based on modern philosophy to integrate latest technology and best practices in order to complete projects efficiently and in a timely manner. ', 'CONSTRUCTION TRANSPORTATION', 'We provide construction transportation machinery and equipments');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calculator`
--
ALTER TABLE `calculator`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `header`
--
ALTER TABLE `header`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `linksorting`
--
ALTER TABLE `linksorting`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `linksortingfooter`
--
ALTER TABLE `linksortingfooter`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calculator`
--
ALTER TABLE `calculator`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=90;
--
-- AUTO_INCREMENT for table `header`
--
ALTER TABLE `header`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `linksorting`
--
ALTER TABLE `linksorting`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `linksortingfooter`
--
ALTER TABLE `linksortingfooter`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
