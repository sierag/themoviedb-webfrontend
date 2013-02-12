<?php
require_once('functions.php');
require_once('config.php');
require_once('db.php');
require_once('TMDb-PHP-API/TMDb.php');

 // Default English language
 $tmdb = new TMDb(TMDB_APIKEY);
 $token = $_GET['request_token'];
 $session = $tmdb->getAuthSession($token);

$_SESSION['tmdb_session_id'] = $session['session_id'];
logg("New session started with token:{$token} and tmdb_session_id:".$session['session_id']);
session_write_close(); 
header("Location: import.php");
die();
?>
