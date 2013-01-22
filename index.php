<?
require_once('config.php');
require_once('db.php');
require_once('functions.php');
require_once('header.php');

if(isset($_GET["url"])){
	$id = $_GET["url"];
	$query = "SELECT * from movies where url = '$id'";
	
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	if(mysql_num_rows($result)==0){
		die('no movies found');
	} else {
		while ($r = mysql_fetch_array($result, MYSQL_ASSOC)) {
			?>
<div id="bg">
	<img src="<?=$r["backdrop_path_original"]?>" alt="">
</div>
					<div class="movie_content">
						<div class="movie_sidebar trailer_complement smaller">
							<a class="movie_poster" href="<?=$r["poster_path_original"]?>">
								<img src="<?=$r["poster_path_w185"]?>">
							</a>
						</div>
						<div class="title"><?=$r["title"]?> <span class="year"><?=substr($r["release_date"],0,4)?></span>
						
						</div>
						<? if(isloggedin()){ ?>
						<div class="movie_rating">
							<select id="rating" rel='<?=$r["tmdb_id"]?>'>
								<? for($i=0;$i<=10;$i=($i+0.5)) {?>
									<option value='<?=$i*10;?>' <? if($r["rating"]==($i*10)){ ?>selected<? } ?>><?=$i;?></option>
								<? } ?>
							</select>
						</div>
						<? } else { ?>
							<div class="movie_rating">
								<span class="movie_rating_value"><?=($r["rating"]/10)?></span>
								<span class="movie_rating_stars"><? for($i=0;$i<(round($r["rating"]/10));$i++){?><i class="icon-star"></i><? } ?><? for($i=0;$i<(10-(round($r["rating"]/10)));$i++){?><i class="icon-star-empty"></i><? } ?></span>
								(Yours)
							</div>
						<? } ?>
						<div class="movie_rating">
							<span class="movie_rating_value"><?=$r["vote_average"]?></span>
							<span class="movie_rating_stars"><? for($i=0;$i<(round($r["vote_average"]));$i++){?><i class="icon-star"></i><? } ?><? for($i=0;$i<(10-(round($r["vote_average"])));$i++){?><i class="icon-star-empty"></i><? } ?></span>
							(Average)
							</div>
						<div class="trailer_complement">
							<div class="movie_plot">
								<p><?=$r["overview"]?></p>
							</div>
						</div>
						<div class="length"><?=timer($r["runtime"])?></div>
						<div class="clear"></div>
						<div class="length">
							External info:&nbsp;&nbsp;
							<a class="fakebutton tmdb" href="http://www.themoviedb.org/movie/<?=$r["tmdb_id"]?>">TMBd</a> |
							<a class="fakebutton imdb" href="http://www.imdb.com/title/<?=$r["tmdb_id"]?>/">IMBd</a>
						</div>
						<div class="clear"></div>
					</div>
			<?
		}
	}
	?>
	<?
			$nextprev = "SELECT * FROM `movies` WHERE rating > 10 ORDER BY release_date desc";
//			$nextprev = "SELECT * FROM `movies` ORDER BY release_date desc";
			$nextprevr = mysql_query($nextprev) or die('Query failed: ' . mysql_error());
			$next = false;
			$prev = false;
			while ($np = mysql_fetch_array($nextprevr, MYSQL_ASSOC)) {
				if($next == true) {
					$nextid = $np['url'];
					break;
				}
				if($id == $np['url']) {
					$previd = $prev;
					$next = true;				
				}
				$prev = $np['url'];
			}
	?>
		<div class="footernav">
			<? if(isset($previd) && $previd!=false) { ?>
				<a class="prev" href="<?=$previd?>?from=left"><i class="icon-step-backward"></i></a>
			<? } else { ?>	
				<i class="icon-step-backward"></i>
			<? } ?>
			<?
			$rand = "SELECT * FROM `movies` WHERE rating > 10  ORDER BY RAND() LIMIT 0,1";
			$randresult = mysql_query($rand) or die('Query failed: ' . mysql_error());
			while ($rand = mysql_fetch_array($randresult, MYSQL_ASSOC)) { 
			?>
			<a class="overview" href="<?=SUBDIR?>"><i class="icon-th"></i></a>
			<a class="rand" href="<?=$rand['url']?>"><i class="icon-refresh"></i></a>
			<? } ?>
			<a class="next" href="<?=$nextid?>?from=right"><i class="icon-step-forward"></i></a>
		</div>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/jquery.masonry.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.lazyload.js"></script>
<script src="js/functions.js"></script>
<script>
$(document).ready(function () {

<? if(isset($_GET["from"])) { ?> 
$("#bg").fadeIn(1000);

<? if($_GET["from"]=="left"){ ?>
		$('.movie_content').animate({
			opacity: 0,
			marginLeft: '200px',
		}, 0, function() {
			$('.movie_content').animate({
				opacity: 100,
				marginLeft: '100px',
			}, 300);
		});
<? } elseif($_GET["from"]=="right"){ ?>
		$('.movie_content').animate({
			opacity: 0,
			marginLeft: '0px',
		}, 0, function() {
			$('.movie_content').animate({
				opacity: 100,
				marginLeft: '100px',
			}, 300);
		});


	<? } 
   } else { ?>
   $("#bg").fadeIn(1000);
   $('.movie_content').animate({
			opacity: 0,
			marginLeft: '100px',
			marginTop: '0px',
		}, 0, function() {
			$('.movie_content').animate({
				opacity: 100,
				marginLeft: '100px',
				marginTop: '20%',
			}, 300);
		});

<? } ?>

  $('body').keyup(function (event) {
    // handle cursor keys
    if (event.keyCode == 37) {
	    <? if(isset($previd) && $previd!=false) { ?>	
	    doLeft();
	    <? } ?>
    } else if (event.keyCode == 39) {
	    doRight();
    } else if (event.keyCode == 38) {
	    doUp();
    } else if (event.keyCode == 40) {
	    doDown();
    }
  });
  
  $('.prev').click(function(){ doLeft();return false; });
  $('.next').click(function(){ doRight();return false; });
  $('.overview').click(function(){ doUp();return false; });
  $('.rand').click(function(){ doDown();return false; });
  
});

function doDown(){
	$('.movie_content, #bg').animate({
		opacity: 0,
		marginTop: '1000px',
	}, 300, function() {
		location.href= $('.rand').attr("href");
	});
}

function doUp(){
	$('.movie_content, #bg').animate({
		opacity: 0,
		marginTop: '-1000px',
	}, 300, function() {
		location.href= $('.overview').attr("href");
	});
}

function doLeft(){
	$('.movie_content, #bg').animate({
		opacity: 0,
		marginLeft: '-500px',
	}, 300, function() {
		location.href= $('.prev').attr("href");
	});
}

function doRight(){
	$('.movie_content, #bg').animate({
		opacity: 0,
		marginLeft: '500px',
	}, 300, function() {
		location.href= $('.next').attr("href");
	});
}


</script>
<? } else {  

$ascdesc = 'desc';
$sort = "release_date";
if(isset($_GET["sort"])) {
	if($_GET["sort"]=="release_date" || $_GET["sort"]=="title" || $_GET["sort"]=="runtime" || $_GET["sort"]=="rating") {
		
		$sort = $_GET["sort"];
		if($_SESSION["sort"]==$sort) {
			if($_SESSION["ascdesc"]=='asc') {
				$ascdesc = 'desc';
 			} else {
				$ascdesc = 'asc';
			}
		}
		$_SESSION["sort"] = $sort;		
		$_SESSION["ascdesc"] = $ascdesc;
	}
}

$query = "SELECT * from movies WHERE rating > 10 order by ".$sort." ".$ascdesc . " ";	
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

?>
<div class="container">
	<div class="row-fluid">
	<?
		if(mysql_num_rows($result)==0){
			die('no movies found');
		} else {
			$i=2;
			while ($r = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$i++;
				if($i>2) {
					 ?></div><div class="row-fluid"><?
					 $i=0;
				}
	?>
		<div class="item span4">
			<a href="<?=$r["url"]?>">
				<div class="title">
					<?=truncate($r["title"],20,' ','..')?> 
					<span class="year" style='float:left'>
						<?=substr($r["release_date"],0,4)?>
					</span> 
					<span style="float:right">
						<?=$r["rating"]/10?>
					</span>
				</div>
				<img src="img/grey.gif" data-original="<?=$r["backdrop_path_w342"]?>" width="100%" alt="" />
			</a>
		</div>
	<?
			}
		}
	?>
	</div>
</div>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.lazyload.js"></script>
<script src="js/jquery.infinitescroll.js"></script>
<script src="js/functions.js"></script>
<? } ?>
<? require_once('footer.php'); ?>
