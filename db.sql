
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Table structure for table `movies`
--

CREATE TABLE IF NOT EXISTS `movies` (
  `id` int(11) NOT NULL auto_increment,
  `backdrop_path_w185` varchar(255) NOT NULL,
  `backdrop_path_w342` varchar(255) NOT NULL,
  `backdrop_path_w500` varchar(255) NOT NULL,
  `backdrop_path_original` varchar(255) NOT NULL,
  `tmdb_id` int(11) NOT NULL,
  `imdb_id` varchar(255) NOT NULL,
  `original_title` text NOT NULL,
  `overview` text NOT NULL,
  `homepage` varchar(255) NOT NULL,
  `release_date` varchar(255) NOT NULL,
  `runtime` int(11) NOT NULL,
  `poster_path_w185` varchar(255) NOT NULL,
  `poster_path_w342` varchar(255) NOT NULL,
  `poster_path_original` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `title` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `vote_average` int(11) NOT NULL,
  `vote_count` int(11) NOT NULL,
  `onwatchlist` enum('0','1') NOT NULL,
  `insertion_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `update_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `tmdb_id` (`tmdb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1792 ;
