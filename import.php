<?php
require_once('config.php');
require_once('db.php');
require_once('functions.php');
require_once('TMDb-PHP-API/TMDb.php');
require_once('header.php');

$tmdb = new TMDb(TMDB_APIKEY);
?>
<class="row-fluid">
	<div class="span3">
		<ul class="nav nav-list">
          		<li class="active"><a href="import.php"><i class="icon-chevron-right"></i> Import</a></li>
          		<li><a href="logs.php"><i class="icon-chevron-right"></i> Logs</a></li>
        	</ul>
	</div>
	<div class="span9">
		<h2>Imports</h2>


<?	
	if(!isset($_SESSION) || empty($_SESSION['tmdb_session_id'])){
		$token = $tmdb->getAuthToken();
		?><a href="<?=$token['Authentication-Callback']?>?redirect_to=http://<?=$_SERVER["SERVER_NAME"]?><?=SUBDIR?>gensession.php" class="btn">request token</a><?
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
								$ratedArr[] = $rated["results"][$i]['id'];
							}						
						}
					} else {
						for($i=0;$i<count($rated['results']);$i++){
							$ratedArr[] = $rated["results"][$i]['id'];
						}
					}	
					foreach($ratedArr as $r) {
						addedit($tmdb, $r, 'rated');
					}
				} elseif($_GET["action"]=='importsingle') { 		
					$b = addedit($tmdb, intval($_GET['tmdb_id']), 'watchlist');
					
					?>
					<script>location.href = '<?=SUBDIR?><?=$b['url']?>';</script>
					<?
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
						<li><a href="?action=importarray"  class="btn">Import or update all rated movies</a> 
						<p>This will get all your rated movies from the TMDb website and insert or update the movie data. This function can take a while depending on the amount of rated movies.</p></li>
					</ul>
					<?
			}
	}
?>
	</div>
</div>
<? require_once("footer.php")?>
