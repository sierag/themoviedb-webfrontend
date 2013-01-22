<?
require_once('config.php');
require_once('db.php');
require_once('functions.php');
require_once('header.php');
?>
<div class="container">
	<div class="row-fluid">
	<?	
	$query = "SELECT AVG(rating) as avg, MAX(rating) as max, MIN(rating) as min, COUNT(id) as total, SUM(runtime) as runtime FROM `movies` WHERE rating > 10";
	
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	if(mysql_num_rows($result)==0){
		die('no movies found');
	} else {
		while ($r = mysql_fetch_array($result, MYSQL_ASSOC)) {
			echo "<div class='span3'><h1 class='amount'>". round($r['avg']/10,2)."<br><span>Average Rating</span></h1></div>";
			echo "<div class='span3'><h1 class='amount'>". round($r['max']/10,2)."<br><span>Maximum Rating</span></h1></div>";
			echo "<div class='span3'><h1 class='amount'>". round($r['min']/10,2)."<br><span>Minimum Rating</span></h1></div>";
			echo "<div class='span3'><h1 class='amount'>". round($r['total'],2)."<br><span>Seen Movies</span></h1></div>";
			?></div><div class="row-fluid"><?

			echo "<div class='span3'><h1 class='amount'>". round($r['runtime']/60)."<br><span>Hours spent watching movies</span></h1></div>";
			echo "<div class='span3'><h1 class='amount'>". round($r['runtime']/60/60)."<br><span>Days watched</span></h1></div>";				
			echo "<div class='span3'><h1 class='amount'>". round($r['runtime']/60/60/7)."<br><span>Week(s) watched</span></h1></div>";
			echo "<div class='span3'><h1 class='amount'>". round($r['runtime']/60/60/30)."<br><span>Month(s) watched</span></h1></div>";
		};
	}
	?>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<h1>Genres balance</h1>
			<?
				
			$query = "SELECT g.name, count(*) AS genrecount FROM genres_movie gm INNER JOIN genres g ON g.tmdb_id = gm.genre_tmdb_id WHERE gm.movie_tmdb_id IN (
	SELECT tmdb_id FROM movies WHERE rating > 10
)
GROUP BY gm.genre_tmdb_id ORDER BY genrecount desc";
				
			$result = mysql_query($query) or die('Query failed: ' . mysql_error());
			if(mysql_num_rows($result)==0){
				echo 'no movies with genres found';
			} 
			
			$res = array();
			$total = 0;
			$count = 0;
			$show_amount_genres = SHOW_AMOUNT_GENRES;
			while ($r = mysql_fetch_array($result, MYSQL_ASSOC)) {
				if ($count < $show_amount_genres) {
					$res[$count] = $r;
					$count++;
				} else {
					$res[$count]['name'] = "Other";
					if (isset($res[$count]['genrecount'])) {
                                                $res[$count]['genrecount'] += $r['genrecount'];
                                        } else {
                                                $res[$count]['genrecount'] = $r['genrecount'];
                                        }			
				}
				$total += $r['genrecount'];
			}
			?>
			<script>
				var data = [];	
			<? 
			foreach ($res as $i=>$r) {
			?>
				data[<?=$i?>] = { label: "<?=$r["name"]?> <?=round(($r["genrecount"]/$total)*100,1)?>%", data: <?=($r["genrecount"]/$total)*100?> }
			<? 
			$i++;
			} ?>
			</script>
			
			<div id="interactive" class="graph" style="width:100%;height:300px;"></div>
		</div>
		<div class="span8">
			<?
			// YEAR
			$q = "SELECT count(id) as myamount, EXTRACT(YEAR FROM release_date) myyear FROM `movies` where rating > 10 GROUP BY myyear order by myyear asc";
			$y = mysql_query($q) or die('Query failed: ' . mysql_error());
			$firstyear = date("Y");
			$lastyear = 0;
			$arr = array();
			while ($n = mysql_fetch_array($y, MYSQL_ASSOC)) { 	
				if($n['myyear']<$firstyear) {
					$firstyear = $n['myyear'];
				}
				if($n['myyear']>$lastyear) {
					$lastyear = $n['myyear'];
				}
				$arr[$n['myyear']] = $n['myamount'];
			}
			?>
			<h1>Movies seen by year it was made</h1>
			<div id="placeholder" style="width:100%;height:300px;"></div>
		</div>
	</div>
</div>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.lazyload.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="flot/jquery.flot.js"></script>
<script language="javascript" type="text/javascript" src="flot/jquery.flot.pie.js"></script>
<script src="js/functions.js"></script>
<script>
$(function () {// Randomly Generated Data	
	// INTERACTIVE
    $.plot($("#interactive"), data, 
	{
		series: {
			pie: { 
				show: true,
			}
		},
		grid: {
			hoverable: true,
			clickable: true
		}
	});
	//$("#interactive").bind("plothover", pieHover);
	//$("#interactive").bind("plotclick", pieClick);
	
	var yeardata = [ <? for($i=$firstyear;$i<=$lastyear;$i++){ ?>["<?=$i?>", <? if(array_key_exists($i,$arr)){echo $arr[$i];}else{echo '0';}?>],<? } ?> ];

	
	$.plot($("#placeholder"), [{color:"blue"},{color:"green"},yeardata], {
        series: {
            bars: {
                show: true,
                barWidth: 0.3,
                align: "center" }
        }
    });
	
});

</script>
<? require_once('footer.php'); ?>
