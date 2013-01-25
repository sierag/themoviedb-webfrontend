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
		echo "<div class='row-fluid'>";
		$i=3;
		foreach($ratedArr as $r){
			$i++;
                        if($i>3) {
                        	echo "</div><div class='row-fluid'>";
                                $i=0;
                        }
			$y = addedit($tmdb, $r, 'watchlist');
	?>
			<div class="item span3">
				<a href="<?=$y["url"]?>">
					<div class="title"><?=$y["title"]?></div>
					<img src="<?=$y["poster_path_w185"]?>" width="185px" alt="" />
				</a>
			</div>			
	<?
		}
		echo "</div>";
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
		echo "<div class='row-fluid'>";
		$i=2;
		while ($row = mysql_fetch_assoc($result)) {
			$i++;
                        if($i>2) {
                        	echo "</div><div class='row-fluid'>";
                                $i=0;
                        }
	?>
			<div class="item span4">
				<a href="<?=$row["url"]?>">
					<div class="title"><?=$row["title"]?></div>
					<img src="<?=$row["backdrop_path_w342"]?>" width="100%" alt="" />
                                	<div class="title">
                                        	<?=truncate($row["title"],20,' ','..')?>
	        	                        <span class="year" style='float:left'>
       	                	                        <?=substr($row["release_date"],0,4)?>
       	                        	         </span>
       	                                	 <span style="float:right">
       	                                        	 <?=$row["rating"]/10?>
       	                                 	</span>
       		                         </div>
				</a>
			</div>			
	<?
		}
		echo "</div>";
	
	} else {
	?>
	<div class="item">
		No result
	</div>			
	<?	
	}
}
?>
