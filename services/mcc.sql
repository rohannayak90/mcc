-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2016 at 04:14 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mcc`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_map_design_template`
--

CREATE TABLE IF NOT EXISTS `tbl_map_design_template` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_design_id` int(11) NOT NULL,
  `fk_template_id` int(11) NOT NULL,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_map_template_theme`
--

CREATE TABLE IF NOT EXISTS `tbl_map_template_theme` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_template_id` int(11) NOT NULL,
  `fk_theme_id` int(11) NOT NULL,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_map_user_design`
--

CREATE TABLE IF NOT EXISTS `tbl_map_user_design` (
  `pk_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fk_user_id` bigint(20) NOT NULL,
  `fk_design_id` int(11) NOT NULL,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mst_design`
--

CREATE TABLE IF NOT EXISTS `tbl_mst_design` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `image_path` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_mst_design`
--

INSERT INTO `tbl_mst_design` (`pk_id`, `name`, `description`, `image_path`, `status`) VALUES
(1, 'Business Card', 'This is to print your visiting card.', 'app/images/design/business-card.jpg', 1),
(2, 'Poster', 'This is a Poster to show up anywhere you want.', 'app/images/design/poster.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mst_template`
--

CREATE TABLE IF NOT EXISTS `tbl_mst_template` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` int(200) NOT NULL,
  `image_path` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mst_theme`
--

CREATE TABLE IF NOT EXISTS `tbl_mst_theme` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `image_path` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mst_user`
--

CREATE TABLE IF NOT EXISTS `tbl_mst_user` (
  `pk_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_type` int(11) NOT NULL,
  `api_key` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `login_username` varchar(100) NOT NULL,
  `login_password` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pk_id`),
  UNIQUE KEY `api_key` (`api_key`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_mst_user`
--

INSERT INTO `tbl_mst_user` (`pk_id`, `user_type`, `api_key`, `user_name`, `user_email`, `login_username`, `login_password`, `status`, `created_on`, `modified_on`) VALUES
(1, 1, 'dde9ae0028ffa09742613dc013a65154', 'Super Admin', 'superadmin@mcc.com', 'superadmin@mcc.com', '$2a$10$f3bbeb8ed433c425f6954uZg/43PVk3dXWgTI.og4n549DBIxjxG6', 1, '2016-05-04 08:54:43', '2016-05-04 08:54:43'),
(2, 2, '9e765fff2b306fb7103d3b780b5795e8', 'murari', 'murari@murari.com', 'murari@murari.com', '$2a$10$ea76897fe21731007d195us1Cf6qxEwkupUD8tKFaGj.9laeaG9Hu', 1, '2016-05-03 09:32:16', '2016-05-03 09:32:16');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
