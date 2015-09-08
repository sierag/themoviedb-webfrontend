<?
require_once('../functions.php');
require_once('../config.php');
require_once('../db.php');
require_once('../TMDb-PHP-API/TMDb.php');
require_once('../header.php');

$id = htmlspecialchars($_GET['url']);

$tmdb = new TMDb(TMDB_APIKEY);
$person = $tmdb->getPerson($id);
?>
<div class="container">
<div style="opacity: 100; margin-left: 100px; margin-top: 0%;" class="person_content">
	<div class='title'><?=$person['name']?></div>
        <div class="row-fluid">
		<div class="span3">
<?
echo "<img src=\"".$tmdb->getImageUrl($person['profile_path'],'profile', 'w185')."\" class=\"person_profile\" width=\"100%\">\n";
echo "<strong>Born:</strong><br />".$person['birthday']." in ".$person['place_of_birth'];
if ($person['deathday'] != "") {
	echo "<br /><strong>Died:</strong><br />".$person['deathday'];
}
?>
		</div>
		<div class="span9">
			<h2>Biography</h2>
			<p><?=nl2br($person['biography'])?></p>
		</div>
	</div>
	<p>&nbsp;</p>
	<div class="row-fluid">
		<div class="span6">
<?
// Actor overview
$query = "SELECT * FROM casts AS c, movies AS m WHERE c.person_id = $id AND c.movie_id = m.tmdb_id AND m.rating > 0 ORDER BY m.release_date";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$films = array();
while ($row = mysql_fetch_array($result)) {
	$films[]= $row;
}

echo "<h2>Movies Seen (as actor)</h2>";
if (count($films) > 0 ) {
	echo "<table>\n";
	foreach ($films as $movie) {
		echo "<tr>";
		echo "<td valign=\"top\">".substr($movie['release_date'],0,4)."</td>";
		echo "<td><a href='".SUBDIR.$movie['url']."'>".$movie['original_title']."</a> ";
		echo "as ".$movie['character_name']."</td>";
		echo "</tr>\n";
	}
	echo "</table>\n";
} else {
	echo "<p>None.</p>";
}

?>
		</div>
		<div class="span6">
<?
// Director overview
$query = "SELECT * FROM crews AS c, movies AS m WHERE c.person_id = $id AND c.job = 'Director' AND c.movie_id = m.tmdb_id AND m.rating > 0 ORDER BY m.release_date";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$films = array();
while ($row = mysql_fetch_array($result)) {
	$films[]= $row;
}

echo "<h2>Movies Seen (as director)</h2>";
if (count($films) > 0 ) {
	echo "<table>\n";
	foreach ($films as $movie) {
		echo "<tr>";
		echo "<td align=\"top\">".substr($movie['release_date'],0,4)."</td>";
		echo "<td><a href='".SUBDIR.$movie['url']."'>".$movie['original_title']."</a></td>";
		echo "</tr>\n";
	}
	echo "</table>\n";
} else {
	echo "<p>None.</p>";
}
?>
		</div>
	</div>
	<div class="row-fluid">
<?
//$personcredits = $tmdb->getPersonCredits($id);
//echo "<pre>";
//print_r($person);
//print_r($personcredits);

//$personimages = $tmdb->getPersonImages($id);
//echo "<h1>Person images</h1>";
//print_r($personimages);

?>
	</div>
</div>
<p>&nbsp;</p>
<? require_once('../footer.php'); ?>
