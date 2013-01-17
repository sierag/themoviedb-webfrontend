<?
require_once('config.php');
require_once('db.php');
require_once('functions.php');
require_once('TMDb-PHP-API/TMDb.php');

if(isloggedin()) {
	mysql_query("UPDATE movies set rating = ".intval($_GET["rating"])." where tmdb_id = '".$_GET["tmdb_id"]."'") or die('Query failed: ' . mysql_error());
	$tmdb = new TMDb(TMDB_APIKEY);
	$tmdb->addMovieRating($_SESSION['tmdb_session_id'], $_GET["tmdb_id"], intval($_GET["rating"]/10));
	
	die("ok");
}
?>