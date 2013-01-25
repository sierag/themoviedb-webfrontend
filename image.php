<?
require_once('config.php');

// placed this config feature to this file because that's the only way where able to manage to keep it in the .gitignore file. Hardcoded.
define("CACHEDIR","img/cache/");

if(CACHING==true){
	if(!is_dir(CACHEDIR)) { 
		if (!mkdir(CACHEDIR, 0, true)) {
    			die('Failed to create cache dir folder, check config settings..');
		} else {
			if(!chmod(CACHEDIR,0775)){
    				die('Failed to change chmod for CACHEDIR folder, check config settings, or do it manualy');
			}
		}
	}
}

$image = CACHEDIR . md5(urldecode($_GET['url'])).".jpg";

if (CACHING==true && file_exists($image)) {
    	$getimage = file_get_contents($image);
} else {
   	$getimage = file_get_contents(urldecode($_GET['url']));
	if(CACHING==true) {
		file_put_contents($image, $getimage);
	}
}

header('Content-Type: image/jpeg');
die($getimage);
?>
