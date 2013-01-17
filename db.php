<?
	
	if(defined(DB_HOST)) { 
		die('no db host given');
	};
	
	if(defined(DB_USERNAME)) { 
		die('no db username given'); 
	}
	
	if(defined(DB_PASSWORD)) { 
		die('no db password given'); 
	}
	
	if(defined(DB_DATABASE)) { 
		die('no db name given'); 
	}

	$link = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die('Could not connect: ' . mysql_error());
	mysql_select_db(DB_DATABASE) or die('Could not select database');
?>