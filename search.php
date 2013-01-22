<? 
require_once('config.php');
require_once('db.php');
require_once('functions.php');
require_once('TMDb-PHP-API/TMDb.php');


if(isloggedin()){

	$tmdb = new TMDb(TMDB_APIKEY);
	$movies = $tmdb->searchMovie($_GET['search_keyword']);
	
	if(count($movies['results'])>0) {
	
		for($i=0;$i<count($movies['results']);$i++){
			$ratedArr[] = $movies["results"][$i];
		}
	
		foreach($ratedArr as $r){
			$y = addedit($tmdb, $r, 'watchlist');
	?>
			<div class="item external">
				<a href="<?=$y["url"]?>">
					<div class="title"><?=$y["title"]?></div>
					<img src="<?=$y["poster_path_w185"]?>" width="185px" alt="" />
				</a>
			</div>			
	<?
		}
	
	} else {
	?>
	<div class="item">
		No result
	</div>			
	<?	
	}
} else {
	
	$query = "SELECT * from movies where title LIKE '%".mysql_real_escape_string($_GET['search_keyword'])."%' AND rating > 10 LIMIT 25";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	
	if(!mysql_num_rows($result)==0){
		
	
		while ($row = mysql_fetch_assoc($result)) {
	 
	?>
			<div class="item">
				<a href="<?=$row["url"]?>">
					<div class="title"><?=$row["title"]?></div>
					<img src="<?=$row["backdrop_path_w342"]?>" width="342px" alt="" />
				</a>
			</div>			
	<?
		}
	
	} else {
	?>
	<div class="item">
		No result
	</div>			
	<?	
	}
}
?>
