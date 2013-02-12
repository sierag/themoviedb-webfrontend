<?
	if(!$link = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD)){
		header("location: install.php?error=".urlencode(mysql_error()));
		die();		
	}
	mysql_select_db(DB_DATABASE) or die('Could not select database');
?>