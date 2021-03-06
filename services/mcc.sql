-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2016 at 05:12 PM
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
-- Table structure for table `tbl_map_template_template_size`
--

CREATE TABLE IF NOT EXISTS `tbl_map_template_template_size` (
  `pk_id` int(11) NOT NULL,
  `fk_template_id` int(11) NOT NULL,
  `fk_template_size_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `tbl_map_user_module`
--

CREATE TABLE IF NOT EXISTS `tbl_map_user_module` (
  `pk_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fk_user_id` bigint(20) NOT NULL,
  `fk_module_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `tbl_map_user_module`
--

INSERT INTO `tbl_map_user_module` (`pk_id`, `fk_user_id`, `fk_module_id`, `status`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 1),
(5, 1, 5, 1),
(6, 1, 6, 1),
(7, 1, 7, 1),
(8, 2, 1, 1),
(9, 2, 2, 1),
(10, 2, 3, 1),
(11, 2, 4, 1),
(12, 2, 5, 0),
(13, 2, 6, 0),
(14, 2, 7, 0),
(15, 1, 8, 1),
(16, 2, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mst_module`
--

CREATE TABLE IF NOT EXISTS `tbl_mst_module` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `image_path` varchar(200) NOT NULL,
  `fa_icon` varchar(50) NOT NULL,
  `link` varchar(100) NOT NULL,
  `sequence` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pk_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_mst_module`
--

INSERT INTO `tbl_mst_module` (`pk_id`, `name`, `description`, `image_path`, `fa_icon`, `link`, `sequence`, `status`) VALUES
(1, 'New Order', 'Start a new order.', '', 'fa fa-4x fa-cloud', 'app/flash/customizer', 1, 1),
(2, 'Saved Orders', 'View your saved orders.', '', 'fa fa-4x fa-save', 'pages/saved-orders', 2, 1),
(3, 'Edit Profile', 'Update your user account information from here.', '', 'fa fa-4x fa-edit', 'pages/profile', 3, 1),
(4, 'Shopping Cart', 'View your shopping cart.', '', 'fa fa-4x fa-shopping-cart', 'pages/cart', 4, 1),
(5, 'View Templates', 'View your templates and add/edit them here.', '', 'fa fa-4x fa-cloud', 'pages/templates', 5, 1),
(6, 'Template Sizes', 'View your template sizes and add/edit them here.', '', 'fa fa-4x fa-cloud', 'pages/template-sizes', 6, 1),
(7, 'View Themes', 'View your themes and add/edit them here.', '', 'fa fa-4x fa-cloud', 'pages/themes', 7, 1),
(8, 'View Modules', 'View/Edit all the modules from here.', '', 'fa fa-4x fa-cloud', 'pages/modules', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mst_pricing`
--

CREATE TABLE IF NOT EXISTS `tbl_mst_pricing` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `sequence` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_mst_pricing`
--

INSERT INTO `tbl_mst_pricing` (`pk_id`, `name`, `description`, `price`, `sequence`, `status`) VALUES
(1, 'Free Plan', 'Great for starters', '0.00', 1, 1),
(2, 'Single Plan', 'Great for single use', '0.99', 2, 1),
(3, 'Monthly Plan', 'Great for small companies', '9.99', 3, 1),
(4, 'Yearly Plan', 'Great for Enterprise', '99.99', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mst_template`
--

CREATE TABLE IF NOT EXISTS `tbl_mst_template` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `image_path` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_mst_template`
--

INSERT INTO `tbl_mst_template` (`pk_id`, `name`, `description`, `image_path`, `status`) VALUES
(1, 'Business Card', 'This is to print your visiting card.', 'app/images/design/business-card.jpg', 1),
(2, 'Poster', 'This is a Poster to show up anywhere you want.', 'app/images/design/poster.jpg', 1),
(3, 'First Design', 'This is the first design via admin', 'app/images/design/business-card.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mst_template_size`
--

CREATE TABLE IF NOT EXISTS `tbl_mst_template_size` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_template_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `image_path` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_mst_template_size`
--

INSERT INTO `tbl_mst_template_size` (`pk_id`, `fk_template_id`, `name`, `description`, `width`, `height`, `image_path`, `status`, `created_on`, `modified_on`) VALUES
(1, 0, 'one', 'Jut basix', 536, 842, 'app/images/templates/business-card.jpg', 1, '2016-05-10 15:50:18', '2016-05-10 15:50:18'),
(2, 0, 'Basic Two', 'This is kist a basic tempalte', 592, 592, 'app/images/templates/business-card.jpg', 1, '2016-05-10 15:53:04', '2016-05-10 15:53:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mst_theme`
--

CREATE TABLE IF NOT EXISTS `tbl_mst_theme` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `image_path` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_mst_theme`
--

INSERT INTO `tbl_mst_theme` (`pk_id`, `name`, `description`, `image_path`, `status`) VALUES
(1, 'Theme 1', 'This is the theme 1 description', 'app/images/templates/business-card.jpg', 1),
(2, 'Theme 2', 'This is theme 2 description', 'app/images/templates/business-card.jpg', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_mst_user`
--

INSERT INTO `tbl_mst_user` (`pk_id`, `user_type`, `api_key`, `user_name`, `user_email`, `login_username`, `login_password`, `status`, `created_on`, `modified_on`) VALUES
(1, 1, 'dde9ae0028ffa09742613dc013a65154', 'Super Admin', 'superadmin@mcc.com', 'superadmin@mcc.com', '$2a$10$f3bbeb8ed433c425f6954uZg/43PVk3dXWgTI.og4n549DBIxjxG6', 1, '2016-05-04 08:54:43', '2016-05-04 08:54:43'),
(2, 2, '9e765fff2b306fb7103d3b780b5795e8', 'murari', 'murari@murari.com', 'murari@murari.com', '$2a$10$ea76897fe21731007d195us1Cf6qxEwkupUD8tKFaGj.9laeaG9Hu', 1, '2016-05-03 09:32:16', '2016-05-03 09:32:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ord_order`
--

CREATE TABLE IF NOT EXISTS `tbl_ord_order` (
  `pk_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fk_user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
