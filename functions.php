<? session_start(); ?>
<?
function timer($runtime) { 
	$hours =  floor($runtime/60); // No. of mins/60 to get the hours and round down
	$mins =   $runtime % 60; // No. of mins/60 - remainder (modulus) is the minutes
	return $hours . " hrs " . $mins . " mins";
}

function isloggedin(){
	return isset($_SESSION['tmdb_username']);
}

function sanitize($string, $force_lowercase = true, $anal = false) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                   "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                   "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
    return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean) :
        $clean;
}

function addeditgenre($tmdb, $genre) {
	if (mysql_num_rows(mysql_query(sprintf(
			"SELECT id FROM genres WHERE tmdb_id = %d", $genre['id']
		))) != 0) {
			return;
	}

	$query = sprintf(
		"INSERT INTO genres (" .
		"    tmdb_id," .
		"    name" .
		") VALUES (".
		"   '%d',".
		"   '%s'".
		")",
		$genre['id'], mysql_real_escape_string($genre['name'])
	);

	mysql_query($query)
		or die('Query failed: ' . mysql_error());

	echo "new genre added {$genre['name']}\n";
}

function updateMovieGenres($genres,$movie_tmdb_id) {
	$num_genre = count($genres);

	if ($num_genre == 0)
		return;

	$query = sprintf("DELETE from genres_movie where movie_tmdb_id = %d", $movie_tmdb_id);

	$result = mysql_query($query)
		or die('Query failed: ' . mysql_error());

	$rows = array();

	foreach($genres as $genre)
		$rows[] = "(".intval($genre['id']).", ".intval($movie_tmdb_id).")";

	$query = sprintf(
		"INSERT INTO genres_movie (".
		"    genre_tmdb_id,".
		"    movie_tmdb_id".
		") VALUES %s", implode(",", $rows)
	);

	mysql_query($query)
		or die('Query failed: ' . mysql_error());

	return true;
}

function addedit($tmdb, $my_tmdb, $list) {
	
	$movie = $tmdb->getMovie($my_tmdb['id']);
	
	updateMovieGenres($movie["genres"], $my_tmdb['id']);
	
	$my_tmdb['poster_path_w185'] = $tmdb->getImageUrl($my_tmdb['poster_path'], 'poster', "w185");
	$my_tmdb['poster_path_w342'] = $tmdb->getImageUrl($my_tmdb['poster_path'], 'poster', "w342");
	$my_tmdb['poster_path_original'] = $tmdb->getImageUrl($my_tmdb['poster_path'], 'poster', "original");
	$my_tmdb['backdrop_path_w185'] = $tmdb->getImageUrl($my_tmdb['backdrop_path'], 'poster', "w185");
	$my_tmdb['backdrop_path_w342'] = $tmdb->getImageUrl($my_tmdb['backdrop_path'], 'poster', "w342");
	$my_tmdb['backdrop_path_w500'] = $tmdb->getImageUrl($my_tmdb['backdrop_path'], 'poster', "w500");
	$my_tmdb['backdrop_path_original'] = $tmdb->getImageUrl($my_tmdb['backdrop_path'], 'poster', "original");
	$title = mysql_escape_string(utf8_decode($my_tmdb['title']));
	$url = sanitize($title) . "-" .$my_tmdb['id'];
	$query = "SELECT id from movies where tmdb_id = ".$my_tmdb['id']."";	
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	if(mysql_num_rows($result)==0){
		// INSERT
		$query = "
		INSERT INTO 
		`movies` (
		`id`, 
		`backdrop_path_w185`, 
		`backdrop_path_w342`, 
		`backdrop_path_w500`, 
		`backdrop_path_original`, 
		`tmdb_id`, 
		`imdb_id`, 
		`original_title`, 
		`overview`, 
		`homepage`, 
		`release_date`, 
		`runtime`, 
		`poster_path_w185`, 
		`poster_path_w342`, 
		`poster_path_original`, 
		";
		if(isset($my_tmdb['rating'])){ $query = $query. " `rating`,"; }
		$query = $query . "
		`title`,  
		`url`, 
		`vote_average`, 
		`vote_count`, 
		`insertion_date`, 
		`update_date`
		) VALUES (
		NULL,
		'".$my_tmdb['backdrop_path_w185']."', 
		'".$my_tmdb['backdrop_path_w342']."', 
		'".$my_tmdb['backdrop_path_w500']."', 
		'".$my_tmdb['backdrop_path_original']."', 
		'".$my_tmdb['id']."',
		'".$movie['imdb_id']."',
		'".mysql_escape_string(utf8_decode($my_tmdb['original_title']))."' ,
		'".mysql_escape_string(utf8_decode($movie['overview']))."',
		'".$movie['homepage']."' ,
		'".$my_tmdb['release_date']."',
		'".$movie['runtime']."',
		'".$my_tmdb['poster_path_w185']."',
		'".$my_tmdb['poster_path_w342']."',
		'".$my_tmdb['poster_path_original']."',
		";
		if(isset($my_tmdb['rating'])){
		$query = $query. "rating = '".($my_tmdb['rating']*10)."', ";
		}
		$query = $query . "
		'".$title."',
		'".$url."',
		'".$my_tmdb['vote_average']."',
		'".$my_tmdb['vote_count']."',
		CURRENT_TIMESTAMP,
		'0000-00-00 00:00:00'		
		)";
	} else {
		// UPDATE
		while ($row = mysql_fetch_assoc($result)) {
			$id = $row['id'];
		} 
		$query = "
		UPDATE `movies` 
		SET
		backdrop_path_w185 = '".$my_tmdb['backdrop_path_w185']."', 
		backdrop_path_w342 = '".$my_tmdb['backdrop_path_w342']."', 
		backdrop_path_w500 = '".$my_tmdb['backdrop_path_w500']."', 
		backdrop_path_original = '".$my_tmdb['backdrop_path_original']."', 
		tmdb_id = '".$my_tmdb['id']."',
		imdb_id = '".$movie['imdb_id']."',
		original_title = '".mysql_escape_string(utf8_decode($my_tmdb['original_title']))."' ,
		overview = '".mysql_escape_string(utf8_decode($movie['overview']))."',
		homepage = '".$movie['homepage']."' ,
		release_date = '".$my_tmdb['release_date']."',
		runtime = '".$movie['runtime']."',
		poster_path_w185 = '".$my_tmdb['poster_path_w185']."',
		poster_path_w342 = '".$my_tmdb['poster_path_w342']."',
		poster_path_original = '".$my_tmdb['poster_path_original']."',
		";
		if(isset($my_tmdb['rating'])){
		$query = $query. "rating = '".($my_tmdb['rating']*10)."', ";
		}
		$query = $query . "
		title = '".$title."',
		url = '".$url."',
		vote_average = '".$my_tmdb['vote_average']."',
		vote_count = '".$my_tmdb['vote_count']."',
		update_date = CURRENT_TIMESTAMP
		WHERE id = '".$id."'";
	}
	mysql_query($query) or die('Query failed: ' . mysql_error());
	if(!isset($id)) {$id = mysql_insert_id();}
	return array("title"=>$title,"backdrop_path_w185"=>$my_tmdb['backdrop_path_w342'],"poster_path_w185"=>$my_tmdb["poster_path_w185"],"id"=>mysql_insert_id(),"url"=>$url);
}

function truncate($string, $limit, $break=".", $pad="...") {
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) { return $string; }
  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }
  return $string;
}
?>
