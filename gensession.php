<?php
 include('TMDb-PHP-API/TMDb.php');
 $apikey = 'a764caade490450dedcd4918e211b738';

 // Default English language
 $tmdb = new TMDb($apikey);
 $token = $_GET['request_token'];
 $session = $tmdb->getAuthSession($token);

session_start();
$_SESSION['tmdb_session_id'] = $session['session_id'];
session_write_close(); 
header("Location: import.php");
die();
?>
