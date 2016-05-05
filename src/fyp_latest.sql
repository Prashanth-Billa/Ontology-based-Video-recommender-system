-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 11, 2014 at 04:36 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fyp`
--

-- --------------------------------------------------------

--
-- Table structure for table `concepts`
--

CREATE TABLE IF NOT EXISTS `concepts` (
  `conceptid` int(11) NOT NULL,
  `conceptname` varchar(100) NOT NULL,
  PRIMARY KEY (`conceptid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `concepts`
--

INSERT INTO `concepts` (`conceptid`, `conceptname`) VALUES
(1, 'Searching'),
(2, 'DivideAndConquer'),
(3, 'DynamicProgramming'),
(4, 'Arrays'),
(5, 'MinimumSpanningTree'),
(6, 'ShortestPath'),
(7, 'Stacks'),
(8, 'BitManipulation'),
(9, 'Graphs'),
(10, 'Sorting'),
(11, 'Greedy'),
(12, 'Trees'),
(13, 'LinkedList'),
(14, 'Heaps'),
(15, 'Queues'),
(16, 'Recursion'),
(17, 'Strings');

-- --------------------------------------------------------

--
-- Table structure for table `following`
--

CREATE TABLE IF NOT EXISTS `following` (
  `name1` varchar(100) NOT NULL,
  `name2` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `following`
--

INSERT INTO `following` (`name1`, `name2`) VALUES
('devarshi', 'prashanth'),
('prashanth', 'devarshi'),
('amrit', 'devarshi'),
('devarshi', 'amrit'),
('ajit', 'arun'),
('ajit', 'alok'),
('abhijit', 'angelyn'),
('abhijit', 'amrit'),
('abhijit', 'devarshi'),
('abhijit', 'chino'),
('abhijit', 'prashanth'),
('akshay', 'arun'),
('alok', 'prashanth'),
('alok', 'arun'),
('angelyn', 'abhijit'),
('angelyn', 'amrit'),
('anushree', 'devarshi'),
('anushree', 'akshay'),
('anushree', 'ajit'),
('chino', 'akshay'),
('chino', 'devarshi'),
('chino', 'prashanth'),
('arun', 'prashanth'),
('arun', 'anushree'),
('arun', 'angelyn'),
('ajit', 'prashanth'),
('akshay', 'prashanth'),
('akshay', 'amrit'),
('prashanth', 'amrit'),
('amrit', 'anushree'),
('amrit', 'akshay'),
('amrit', 'ajit'),
('prashanth', 'akshay');

-- --------------------------------------------------------

--
-- Table structure for table `instanceclass`
--

CREATE TABLE IF NOT EXISTS `instanceclass` (
  `instance` varchar(100) NOT NULL,
  `class` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  UNIQUE KEY `instance` (`instance`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `instanceclass`
--

INSERT INTO `instanceclass` (`instance`, `class`, `url`) VALUES
('ActivitySelection_eg_1', 'Greedy', 'http://www.youtube.com/watch?v=pN7RzOWIOn4\n'),
('Array_eg_1', 'Arrays', 'https://www.youtube.com/watch?v=jP4A2JTr1Qw'),
('Avl_eg_1', 'Trees', 'https://www.youtube.com/watch?v=lQp431QjrWI'),
('BalanceParentheses_eg_1', 'DynamicProgramming', 'http://www.youtube.com/watch?v=DtVLwspTf8Q'),
('Bellmanford_eg_1', 'ShortestPath', 'https://www.youtube.com/watch?v=W2fKGISUAtM'),
('Bfs_eg_1', 'Graphs', 'http://www.youtube.com/watch?v=s-CYnVz-uh4'),
('Binarysearch_eg_1', 'Searching', 'http://www.youtube.com/watch?v=pRKPgAiY6-g'),
('Bitmanipulation_eg_1', 'BitManipulation', 'https://www.youtube.com/watch?v=uUtb0BaeosQ'),
('Bst_eg_1', 'Trees', 'https://www.youtube.com/watch?v=pYT9F8_LFTM'),
('Bubblesort_eg_1', 'Sorting', 'https://www.youtube.com/watch?v=P00xJgWzz2c'),
('Circularlist_eg_1', 'LinkedList', 'https://www.youtube.com/watch?v=pBaZl9B448g'),
('Coinchange_eg_1', 'DynamicProgramming', 'http://www.youtube.com/watch?v=GafjS0FfAC0'),
('Dfs_eg_1', 'Graphs', 'http://www.youtube.com/watch?v=CIm6RzdoPCI'),
('Dijkstra_eg_1', 'ShortestPath', 'https://www.youtube.com/watch?v=qJ5Ozb2ZSxM'),
('Doublylist_eg_1', 'LinkedList', 'https://www.youtube.com/watch?v=VOQNf1VxU3Q'),
('Heapsort_eg_1', 'Sorting', 'https://www.youtube.com/watch?v=6NB0GHY11Iw'),
('Huffmancoding_eg_1', 'Greedy', 'http://www.youtube.com/watch?v=-eJF0gs8OY0'),
('Insertionsort_eg_1', 'Sorting', 'https://www.youtube.com/watch?v=c4BRHC7kTaQ'),
('Kruskals_eg_1', 'MinimumSpanningTree', 'https://www.youtube.com/watch?v=5xosHRdxqHA'),
('Linearsearch_eg_1', 'Searching', 'http://www.youtube.com/watch?v=SGU9duLE30w'),
('Longestcommonsubsequence_eg_1', 'DynamicProgramming', 'http://www.youtube.com/watch?v=ml0i13Uvmuc'),
('Mergesort_eg_1', 'DivideAndConquer', 'https://www.youtube.com/watch?v=TzeBrDU-JaY'),
('Prims_eg_1', 'MinimumSpanningTree', 'https://www.youtube.com/watch?v=7FtGk9yr66A'),
('Priorityqueue_eg_1', 'Heaps', 'https://www.youtube.com/watch?v=P4toxusBX9M\n'),
('Queues_eg_1', 'Queues', 'https://www.youtube.com/watch?v=PjQdvpWfCmE'),
('Quicksort_eg_1', 'DivideAndConquer', 'https://www.youtube.com/watch?v=gtWw_8VvHjk'),
('Recursion_eg_1', 'Recursion', 'http://www.youtube.com/watch?v=7lrJAlWlkro'),
('Redblack_eg_1', 'Trees', 'https://www.youtube.com/watch?v=iumaOUqoSCk'),
('Selectionsort_eg_1', 'Sorting', 'https://www.youtube.com/watch?v=6nDMgr0-Yyo'),
('Singlylist_eg_1', 'LinkedList', 'https://www.youtube.com/watch?v=pBrz9HmjFOs'),
('Stacks_eg_1', 'Stacks', 'https://www.youtube.com/watch?v=g1USSZVWDsY'),
('Stringsearching_eg_1', 'Strings', 'https://www.youtube.com/watch?v=Zj_er99KMb8');

-- --------------------------------------------------------

--
-- Table structure for table `learntvideos`
--

CREATE TABLE IF NOT EXISTS `learntvideos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  `class` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `learntvideos`
--

INSERT INTO `learntvideos` (`id`, `name`, `url`, `class`) VALUES
(40, 'Binarysearch_eg_1', 'http://www.youtube.com/watch?v=pRKPgAiY6-g', 'Binary'),
(41, 'Linearsearch_eg_1', 'http://www.youtube.com/watch?v=SGU9duLE30w', 'Linear'),
(42, 'Longestcommonsubsequence_eg_1', 'http://www.youtube.com/watch?v=ml0i13Uvmuc', 'LongestCommonSubsequnce'),
(43, 'BalanceParentheses_eg_1', 'http://www.youtube.com/watch?v=DtVLwspTf8Q', 'BalanceParentheses'),
(44, 'Coinchange_eg_1', 'http://www.youtube.com/watch?v=GafjS0FfAC0', 'CoinChange'),
(45, 'Dijkstra_eg_1', 'https://www.youtube.com/watch?v=qJ5Ozb2ZSxM', 'Dijkstra'),
(46, 'BalanceParentheses_eg_1', 'http://www.youtube.com/watch?v=DtVLwspTf8Q', 'BalanceParentheses'),
(47, 'Stacks_eg_1', 'https://www.youtube.com/watch?v=g1USSZVWDsY', 'Stacks'),
(48, 'Huffmancoding_eg_1', 'http://www.youtube.com/watch?v=-eJF0gs8OY0', 'HuffmanCoding'),
(49, 'Longestcommonsubsequence_eg_1', 'http://www.youtube.com/watch?v=ml0i13Uvmuc', 'LongestCommonSubsequnce'),
(50, 'BalanceParentheses_eg_1', 'http://www.youtube.com/watch?v=DtVLwspTf8Q', 'BalanceParentheses'),
(52, 'Dfs_eg_1', 'http://www.youtube.com/watch?v=CIm6RzdoPCI', 'DepthFirstSearch'),
(53, 'Circularlist_eg_1', 'https://www.youtube.com/watch?v=pBaZl9B448g', 'LinkedList'),
(54, 'Bst_eg_1', 'https://www.youtube.com/watch?v=pYT9F8_LFTM', 'Trees'),
(55, 'BalanceParentheses_eg_1', 'http://www.youtube.com/watch?v=DtVLwspTf8Q', 'DynamicProgramming'),
(56, 'Stacks_eg_1', 'https://www.youtube.com/watch?v=g1USSZVWDsY', 'Stacks'),
(57, 'Huffmancoding_eg_1', 'http://www.youtube.com/watch?v=-eJF0gs8OY0', 'Greedy'),
(59, 'Stacks_eg_1', 'https://www.youtube.com/watch?v=g1USSZVWDsY', 'Stacks'),
(60, 'Dfs_eg_1', 'http://www.youtube.com/watch?v=CIm6RzdoPCI', 'Graphs'),
(61, 'Dijkstra_eg_1', 'https://www.youtube.com/watch?v=qJ5Ozb2ZSxM', 'ShortestPath');

-- --------------------------------------------------------

--
-- Table structure for table `userconcept`
--

CREATE TABLE IF NOT EXISTS `userconcept` (
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userconcept`
--

INSERT INTO `userconcept` (`uid`, `cid`) VALUES
(11, 4),
(11, 5),
(14, 13),
(15, 5),
(15, 17),
(15, 11),
(14, 6),
(14, 9),
(14, 3),
(16, 2),
(16, 16),
(17, 1),
(17, 2),
(17, 3),
(18, 13),
(18, 14),
(18, 12),
(19, 13),
(19, 2),
(19, 17),
(20, 2),
(20, 5),
(20, 16),
(21, 5),
(21, 9),
(21, 16),
(11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `userlearnt`
--

CREATE TABLE IF NOT EXISTS `userlearnt` (
  `likeid` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) NOT NULL,
  `videoid` int(11) NOT NULL,
  PRIMARY KEY (`likeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `userlearnt`
--

INSERT INTO `userlearnt` (`likeid`, `user_name`, `videoid`) VALUES
(45, 'devarshi', 40),
(46, 'devarshi', 41),
(47, 'devarshi', 42),
(48, 'devarshi', 43),
(49, 'devarshi', 44),
(50, 'prashanth', 45),
(51, 'prashanth', 43),
(52, 'prashanth', 47),
(53, 'prashanth', 48),
(54, 'amrit', 42),
(55, 'amrit', 43),
(57, 'prashanth', 52),
(58, 'angelyn', 53),
(59, 'angelyn', 54),
(60, 'akshay', 43),
(61, 'akshay', 47),
(62, 'akshay', 48),
(64, 'amrit', 47),
(65, 'amrit', 52),
(66, 'amrit', 45);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `profilepic` varchar(200) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `user_email`, `profilepic`) VALUES
(11, 'prashanth', '123', '106110014@nitt.edu', 'profileimages/prash.jpg'),
(12, 'amrit', '123', '106110005@nitt.edu', 'profileimages/amrit.jpg'),
(13, 'devarshi', '123', '106110020@nitt.edu', 'profileimages/devarshi.jpg'),
(14, 'abhijit', 'abhijit', 'abhijit@gmail.com', 'profileimages/abhijit.jpg'),
(15, 'ajit', 'ajit', 'ajit@gmail.com', 'profileimages/ajit.jpg'),
(16, 'akshay', 'akshay', 'akshay@gmail.com', 'profileimages/10001479_747666865278009_4303640659514758116_n.jpg'),
(17, 'alok', 'alok', 'alok@gmail.com', 'profileimages/alok.jpg'),
(18, 'angelyn', 'angelyn', 'angelyn@gmail.com', 'profileimages/10172598_678820572185719_3249042737382506868_n.jpg'),
(19, 'anushree', 'anushree', 'anushree@gmail.com', 'profileimages/anushree.jpg'),
(20, 'chino', 'chino', 'chino@gmail.com', 'profileimages/chinu.jpg'),
(21, 'arun', 'arun', 'arun@gmail.com', 'profileimages/arun.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
