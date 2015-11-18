<? session_start(); 

$page = SUBSTR(strrchr($_SERVER["REQUEST_URI"],'/'),1);
if($page <> "install.php" && !file_exists( dirname( __FILE__ ) . '/config.php' )){
	header("location: install.php");
	die();
}	

function timer($runtime) { 
	$hours =  floor($runtime/60); // No. of mins/60 to get the hours and round down
	$mins =   $runtime % 60; // No. of mins/60 - remainder (modulus) is the minutes
	return $hours . " hrs " . $mins . " mins";
}

function isloggedin(){
	return isset($_SESSION['tmdb_username']);
}

function updatesite($db_name,$db_host,$db_username,$db_password) {
	
	
}

function sanitize($string, $force_lowercase = true, $anal = true) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                   "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                   "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "-", $clean) : $clean ;
    return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean) :
        $clean;
}


function h($input) {
	return htmlentities($input);
}

function logg($desc) {
	$desc = mysql_real_escape_string($desc);
	$query = "INSERT INTO logs (log)VALUES('".$desc."')";
	return mysql_query($query) or die('Query failed: ' . mysql_error());
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
function addeditcastcrew($tmdb, $tmdb_id) {
	$crew = $tmdb->getMovieCast($tmdb_id);

	// Add/update crew
	$query = "DELETE from crews where movie_id = ".$tmdb_id."";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	if (count($crew["crew"]) > 0) {
		foreach ($crew["crew"] as $c) {
			$c['name'] = preg_replace("/'/", "\\'", $c['name']);
			$c['name'] = preg_replace("/\"/", "\\\"", $c['name']);
			$c['job'] = preg_replace("/'/", "\\'", $c['job']);
			$c['job'] = preg_replace("/\"/", "\\\"", $c['job']);
			$query = "INSERT INTO `crews` (person_id, movie_id, name, job, profile_path) VALUES (".$c["id"]. ",$tmdb_id,'".$c["name"]."','".$c["job"]."','".$c["profile_path"]."')";
			$result = mysql_query($query) or die('Query failed: ' . mysql_error());
			logg("new crew person added {$c['name']}");
		}
	}

	// Add/update cast
	$query = "DELETE from casts where movie_id = ".$tmdb_id."";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	if (count($crew["cast"]) > 0) {
		foreach ($crew["cast"] as $c) {
			$c['name'] = preg_replace("/'/", "\\'", $c['name']);
			$c['character'] = preg_replace("/'/", "\\'", $c['character']);
			$c['name'] = preg_replace("/\"/", "\\\"", $c['name']);
			$c['character'] = preg_replace("/\"/", "\\\"", $c['character']);
			$query = "INSERT INTO `casts` (person_id, movie_id, name, character_name, ordered, cast_id, profile_path) VALUES (".$c["id"]. ",$tmdb_id,'".$c["name"]."','".$c["character"]."',".$c["order"].",".$c["cast_id"].",'".$c["profile_path"]."')";
			$result = mysql_query($query) or die('Query failed: ' . mysql_error());
			logg("new cast person added {$c['name']}");
		}
	}
}
function addedit($tmdb, $tmdb_id, $list) {
	
	$movie = $tmdb->getMovie($tmdb_id);

	$trailers = $tmdb->getMovieTrailers($tmdb_id);
	addeditcastcrew($tmdb, $tmdb_id);
	
	$query = "DELETE from trailers where tmdb_id = ".$tmdb_id."";	
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	if (count($trailers["youtube"]) > 0) {
		foreach($trailers['youtube'] as $t){
			$t['name'] = preg_replace("/'/", "\\'", $t['name']);
			$t['name'] = preg_replace("/\"/", "\\\"", $t['name']);
			$query = "INSERT INTO trailers (tmdb_id,type,name,size,source)VALUES (".$tmdb_id.",'youtube','".$t["name"]."','".$t["size"]."','".$t["source"]."')";	
			$result = mysql_query($query) or die('Query failed: ' . mysql_error());
		}
	}
	updateMovieGenres($movie["genres"], $tmdb_id);
	
	$my_tmdb['poster_path_w185'] = $tmdb->getImageUrl($movie['poster_path'], 'poster', "w185");
	$my_tmdb['poster_path_w342'] = $tmdb->getImageUrl($movie['poster_path'], 'poster', "w342");
	$my_tmdb['poster_path_original'] = $tmdb->getImageUrl($movie['poster_path'], 'poster', "original");
	$my_tmdb['backdrop_path_w185'] = $tmdb->getImageUrl($movie['backdrop_path'], 'poster', "w185");
	$my_tmdb['backdrop_path_w342'] = $tmdb->getImageUrl($movie['backdrop_path'], 'poster', "w342");
	$my_tmdb['backdrop_path_w500'] = $tmdb->getImageUrl($movie['backdrop_path'], 'poster', "w500");
	$my_tmdb['backdrop_path_original'] = $tmdb->getImageUrl($movie['backdrop_path'], 'poster', "original");
	$title = mysql_real_escape_string(utf8_decode($movie['title']));
	$url = sanitize($title) . "-" .$tmdb_id;
	$query = "SELECT id from movies where tmdb_id = ".$tmdb_id."";	
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
		if(isset($movie['rating'])){ $query = $query. " `rating`,"; }
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
		'".$tmdb_id."',
		'".$movie['imdb_id']."',
		'".mysql_real_escape_string(utf8_decode($movie['original_title']))."' ,
		'".mysql_real_escape_string(utf8_decode($movie['overview']))."',
		'".$movie['homepage']."' ,
		'".$movie['release_date']."',
		'".$movie['runtime']."',
		'".$my_tmdb['poster_path_w185']."',
		'".$my_tmdb['poster_path_w342']."',
		'".$my_tmdb['poster_path_original']."',
		";
		if(isset($movie['rating'])){
			$query = $query. "rating = '".($movie['rating']*10)."', ";
		}
		$query = $query . "
		'".$title."',
		'".$url."',
		'".$movie['vote_average']."',
		'".$movie['vote_count']."',
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
		tmdb_id = '".$tmdb_id."',
		imdb_id = '".$movie['imdb_id']."',
		original_title = '".mysql_real_escape_string(html_entity_decode($movie['original_title']))."' ,
		overview = '".mysql_real_escape_string(utf8_decode($movie['overview']))."',
		homepage = '".$movie['homepage']."' ,
		release_date = '".$movie['release_date']."',
		runtime = '".$movie['runtime']."',
		poster_path_w185 = '".$my_tmdb['poster_path_w185']."',
		poster_path_w342 = '".$my_tmdb['poster_path_w342']."',
		poster_path_original = '".$my_tmdb['poster_path_original']."',
		";
		if(isset($movie['rating'])){
			$query = $query. "rating = '".($movie['rating']*10)."', ";
		}
		$query = $query . "
		title = '".$title."',
		url = '".$url."',
		vote_average = '".$movie['vote_average']."',
		vote_count = '".$movie['vote_count']."',
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
