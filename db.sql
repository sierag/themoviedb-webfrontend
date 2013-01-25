
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
  `vote_average` float NOT NULL,
  `vote_count` int(11) NOT NULL,
  `onwatchlist` enum('0','1') NOT NULL,
  `insertion_date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `update_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `tmdb_id` (`tmdb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1792 ;


-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
  `id` int(11) NOT NULL auto_increment,
  `tmdb_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `tmdb_id` (`tmdb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `tmdb_id`, `name`) VALUES
(2, 28, 'Action'),
(3, 12, 'Adventure'),
(4, 16, 'Animation'),
(5, 35, 'Comedy'),
(6, 80, 'Crime'),
(7, 105, 'Disaster'),
(8, 99, 'Documentary'),
(9, 18, 'Drama'),
(10, 82, 'Eastern'),
(11, 2916, 'Erotic'),
(12, 10751, 'Family'),
(13, 10750, 'Fan Film'),
(14, 14, 'Fantasy'),
(15, 10753, 'Film Noir'),
(16, 10769, 'Foreign'),
(17, 36, 'History'),
(18, 10595, 'Holiday'),
(19, 27, 'Horror'),
(20, 10756, 'Indie'),
(21, 10402, 'Music'),
(22, 22, 'Musical'),
(23, 9648, 'Mystery'),
(24, 10754, 'Neo-noir'),
(25, 1115, 'Road Movie'),
(26, 10749, 'Romance'),
(27, 878, 'Science Fiction'),
(28, 10755, 'Short'),
(29, 9805, 'Sport'),
(30, 10758, 'Sporting Event'),
(31, 10757, 'Sports Film'),
(32, 10748, 'Suspense'),
(33, 10770, 'TV movie'),
(34, 53, 'Thriller'),
(35, 10752, 'War'),
(36, 37, 'Western');


CREATE TABLE IF NOT EXISTS `genres_movie` (
  `genre_tmdb_id` int(11) NOT NULL,
  `movie_tmdb_id` int(11) NOT NULL,
  KEY `genre_tmdb_id` (`genre_tmdb_id`),
  KEY `movie_tmdb_id` (`movie_tmdb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `sierag1`.`trailers` (
`tmdb_id` INT NOT NULL ,
`type` VARCHAR( 255 ) NOT NULL ,
`name` INT( 255 ) NOT NULL ,
`size` VARCHAR( 255 ) NOT NULL ,
`source` VARCHAR( 255 ) NOT NULL ,
INDEX ( `tmdb_id` )
) ENGINE = MYISAM ;
