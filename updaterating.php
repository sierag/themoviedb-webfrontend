<?
require_once('config.php');
require_once('db.php');
require_once('functions.php');
require_once('TMDb-PHP-API/TMDb.php');

if(isloggedin()) {
	if (!isset($_GET['rating'])) die();
	if (!isset($_GET['tmdb_id'])) die();

	$rating  = intval($_GET['rating']);
	$tmdb_id = intval($_GET['tmdb_id']);

	mysql_query("UPDATE movies set rating = ".$rating." where tmdb_id = '".$tmdb_id."'") or die('Query failed: ' . mysql_error());
	$tmdb = new TMDb(TMDB_APIKEY);
	$tmdb->addMovieRating($_SESSION['tmdb_session_id'], $tmdb_id, $rating/10);
	
	die("ok");
}
?>
