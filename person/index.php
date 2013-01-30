<?
require_once('../config.php');
require_once('../db.php');
require_once('../functions.php');
require_once('../TMDb-PHP-API/TMDb.php');
require_once('../header.php');

$id = $_GET['url'];

$tmdb = new TMDb(TMDB_APIKEY);
$person = $tmdb->getPerson($id);
echo "<pre>";
echo "<h1>Person credits</h1>";
print_r($person);

$personcredits = $tmdb->getPersonCredits($id);
echo "<h1>Person</h1>";
print_r($personcredits);

$personimages = $tmdb->getPersonImages($id);
echo "<h1>Person images</h1>";
print_r($personimages);

?>
<script>
	$(document).ready(function () {
		
	});
</script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.lazyload.js"></script>
<script src="js/functions.js"></script>
