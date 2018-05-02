-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2018 at 09:09 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbcms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcategories`
--

CREATE TABLE `tblcategories` (
  `category_id` int(3) NOT NULL,
  `category_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tblcategories`
--

INSERT INTO `tblcategories` (`category_id`, `category_title`) VALUES
(1, 'Bootstrap'),
(2, 'Javascript'),
(3, 'PHP'),
(4, 'HTML');

-- --------------------------------------------------------

--
-- Table structure for table `tblcomments`
--

CREATE TABLE `tblcomments` (
  `comment_id` int(11) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_email` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` varchar(255) NOT NULL,
  `comment_date` date NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcomments`
--

INSERT INTO `tblcomments` (`comment_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`, `post_id`) VALUES
(1, 'Mark', 'email@example.com', 'This is a cool blog!', 'Approved', '2017-10-04', 1),
(2, 'Hachiman', 'hikigaya@hachiman.com', 'Lorem ipsum dolor', 'Approved', '2017-10-11', 4),
(4, 'Mak', 'mak@test.com', 'PHP is really awesome', 'Approved', '2017-10-11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblposts`
--

CREATE TABLE `tblposts` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_author` int(11) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text NOT NULL,
  `post_content` text NOT NULL,
  `post_tags` varchar(255) NOT NULL,
  `post_comment_count` int(11) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'draft',
  `post_views_count` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblposts`
--

INSERT INTO `tblposts` (`post_id`, `post_title`, `post_author`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_views_count`, `category_id`) VALUES
(1, 'PHP is awesome!', 1, '2017-08-19', 'main-image-min.jpeg', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>This is a really a powerful language to learn in web development!</p>\r\n</body>\r\n</html>', 'PHP, JS', 2, 'Published', 28, 3),
(4, 'Javascript is the future', 1, '2017-04-24', 'ARCHITECTS-All-Our-Gods-Have-Abandoned-Us-620x330.jpg', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Javascript is progressing rapidly. At first it is only used on front-end development, but now it can now be used as a back-end language for web and mobile development.</p>\r\n</body>\r\n</html>', 'Javascript', 1, 'Published', 3, 2),
(6, 'Another PHP post', 1, '2017-09-17', 'oil.jpg', '<!DOCTYPE html>\n<html>\n<head>\n</head>\n<body>\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\n</body>\n</html>', 'PHP', 0, 'Published', 0, 3),
(8, 'PHP is awesome!', 1, '2017-08-19', 'main-image-min.jpeg', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>This is a really a powerful language to learn in web development!</p>\r\n</body>\r\n</html>', 'PHP, JS', 0, 'Published', 0, 3),
(9, 'Javascript is the future', 1, '2017-04-24', 'ARCHITECTS-All-Our-Gods-Have-Abandoned-Us-620x330.jpg', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Javascript is progressing rapidly. At first it is only used on front-end development, but now it can now be used as a back-end language for web and mobile development.</p>\r\n</body>\r\n</html>', 'Javascript', 0, 'Published', 2, 2),
(10, 'Another PHP post', 1, '2017-09-17', 'oil.jpg', '<!DOCTYPE html>\n<html>\n<head>\n</head>\n<body>\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\n</body>\n</html>', 'PHP', 0, 'Published', 2, 3),
(11, 'Test', 12, '2018-05-03', '', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>Test</p>\r\n</body>\r\n</html>', 'Test', 0, 'Published', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblsessions`
--

CREATE TABLE `tblsessions` (
  `id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblsessions`
--

INSERT INTO `tblsessions` (`id`, `session`, `time`) VALUES
(1, 'tilaerqmu7jd643koakgogbce6', 1525288164),
(2, 'm1550rani278skmekd4b3acg73', 1525190847),
(3, '', 1525109117);

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `user_role` varchar(255) NOT NULL DEFAULT 'Subscriber'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`user_id`, `username`, `password`, `firstname`, `lastname`, `email`, `image`, `user_role`) VALUES
(1, 'admin', '$2y$10$yCFtRW5W4el3CvrzdMiKse8z7vOPLQg1KGGYzZMjtiZowisBjTVoG', 'Mark Ian', 'Pamintuan', 'markian@php-cms.com', '', 'Admin'),
(12, 'hikki', '$2y$10$8zurIcBwFisr.7qf9C07PeI7s7R8E...70eCe31AoPgW6nBuLz8zK', 'Hikigaya', 'Hachiman', 'hikki@gmail.com', '', 'Subscriber'),
(14, 'test', '$2y$10$Cgh25VCob7VDQnLnM.lx6.LHjJBH2lJMa1znK5wddOr4YR9T15nE2', 'Test', 'Test', 'test@test.com', '', 'Subscriber');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcategories`
--
ALTER TABLE `tblcategories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tblcomments`
--
ALTER TABLE `tblcomments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `tblposts`
--
ALTER TABLE `tblposts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tblsessions`
--
ALTER TABLE `tblsessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcategories`
--
ALTER TABLE `tblcategories`
  MODIFY `category_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tblcomments`
--
ALTER TABLE `tblcomments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tblposts`
--
ALTER TABLE `tblposts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tblsessions`
--
ALTER TABLE `tblsessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
