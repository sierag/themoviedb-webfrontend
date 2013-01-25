<?php
require_once('config.php');
require_once('db.php');
require_once('functions.php');
require_once('TMDb-PHP-API/TMDb.php');
require_once('header.php');

$tmdb = new TMDb(TMDB_APIKEY);
?>
<div class="container">
<br />
<br />
<br />
<br />
<br />
<br />
<?	
	if(!isset($_SESSION) || empty($_SESSION['tmdb_session_id'])){
		$token = $tmdb->getAuthToken();
		?><a href="<?=$token['Authentication-Callback']?>?redirect_to=http://<?=SERVER_NAME?><?=SUBDIR?>gensession.php" class="btn" target="_blank">request token</a><?
	} else {

			if(empty($_SESSION['tmdb_id'])){
				$account = $tmdb->getAccount($_SESSION['tmdb_session_id']);	
				$_SESSION['tmdb_username'] = $account['username'];
				$_SESSION['tmdb_id'] = $account['id'];
				$_SESSION['tmdb_language'] = $account['iso_3166_1'];
			}
			if(isset($_GET["action"])) {
				if($_GET["action"]=='updategenres') { 		
					$query = "SELECT * from movies";	
					$result = mysql_query($query) or die('Query failed: ' . mysql_error());
					ob_flush();flush();
					while ($row = mysql_fetch_assoc($result)) {
						$movie = $tmdb->getMovie($row['tmdb_id']);
						updateMovieGenres($movie["genres"],$row['tmdb_id']);
						echo "movie " . $row['title'] . " has " . count($movie["genres"]) . " genres updated<br>";
					} 
				} elseif($_GET["action"]=='importall') { 		
					ob_end_flush();
					$movies = $tmdb->getMoviesByGenre('28');
					echo "<pre>";
					var_dump($movies);
				}elseif($_GET["action"]=='sanatizeall') { 		
					$query = "SELECT * from movies";	
					$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	
					$i=0;
					while ($row = mysql_fetch_assoc($result)) {
						$query = "
						UPDATE `sierag1`.`movies` 
						SET
						url = '".sanitize($row['title'] . "-" . $row['tmdb_id'])."'
						WHERE id = '".$row['id']."'";
						mysql_query($query) or die('Query failed: ' . mysql_error());
						$i++;
					} 
					echo $i." sanatized";
					echo "<a href='import.php' class='btn'>Ready, go back</a>";
				} elseif($_GET["action"]=='importarray') { 		
					ob_end_flush();
					$rated = $tmdb->getAccountRatedMovies($_SESSION['tmdb_id'],$_SESSION['tmdb_session_id']);
					$ratedArr = array();
						
					if($rated['total_pages']>1) {
						for($page=1;$page<($rated['total_pages']+1);$page++){
							$rated = $tmdb->getAccountRatedMovies($_SESSION['tmdb_id'],$_SESSION['tmdb_session_id'],$page);
							for($i=0;$i<count($rated['results']);$i++){
								$ratedArr[] = $rated["results"][$i];
							}						
						}
					} else {
						for($i=0;$i<count($rated['results']);$i++){
							$ratedArr[] = $rated["results"][$i];
						}
					}	
					foreach($ratedArr as $r){
						addedit($tmdb, $r, 'watchlist');
					}
				} elseif($_GET["action"]=='importgenres') { 		
					ob_end_flush();
					$genres = $tmdb->getGenres();
					foreach($genres["genres"] as $g) {
						addeditgenre($tmdb, $g);
					}
					echo "<a href='import.php' class='btn'>Ready, go back</a>";
				}
			} else { 
					?>
					<ul>
						<li><a href="?action=updategenres"  class="btn">updategenres</a></li>
						<li><a href="?action=importratings"  class="btn">import rated movies</a></li>
						<li><a href="?action=sanatizeall" class="btn">sanatize urls</a></li>
						<li><a href="?action=importall" class="btn">import all movies per genre</a></li>
						<li><a href="?action=importgenres" class="btn">import genres</a></li>
					</ul>
					<?
			}
	}
?>
</div>
<? require_once("footer.php")?>
