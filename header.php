<!DOCTYPE html>
<html lang="en">
<head>
<title>Sierag Movie Archive</title>
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<link href='css/style.css' rel='stylesheet' type='text/css'>
<link href='css/font-awesome.min.css' rel='stylesheet' type='text/css'>

</head>
<body>
<!-- NAVBAR
    ================================================== -->
        <div class="navbar navbar-inverse navbar-fixed-top">
          <div class="navbar-inner">
            <!-- Responsive Navbar Part 1: Button for triggering responsive navbar (not covered in tutorial). Include responsive CSS to utilize. -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
            <a class="brand" href="/movie">My Movie DB</a>
            <? if(!isset($_GET["url"])){ ?>

            <!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->
            <div class="nav-collapse collapse">
              <ul class="nav">
	              <li class="active"><a href="/movie">Rated</a></li>
	        <!--  <li><a href="/movie/watchlist">On watchlist</a></li> -->
              
                <!-- Read about Bootstrap dropdowns at http://twitter.github.com/bootstrap/javascript.html#dropdowns -->
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sort<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="?sort=release_date" class="active">Release Date</a></li>
                    <li><a href="?sort=title">Title</a></li>
                    <li><a href="?sort=runtime">Runtime</a></li>
                    <li><a href="?sort=rating">My Rating</a></li>
                  </ul>
                </li>
                <? if(!isloggedin()){
                require_once('TMDb-PHP-API/TMDb.php');
				$apikey = 'a764caade490450dedcd4918e211b738';
				$tmdb = new TMDb($apikey);

	                $token = $tmdb->getAuthToken();
	                ?><li><a href="<?=$token['Authentication-Callback']?>?redirect_to=http://www.sierag.nl/movie/gensession.php">login</a></li>
	                <?
		        }?>
		        
              </ul>
            </div><!--/.nav-collapse -->
                <div class="pull-right">
                	<input type="text" placeholder="Keyword" name="search" id="search">
                	<!--<button type="submit" value="Search" class="btn"><i class="icon-search"></i>-->
                	</button>
                </div>

            <? } ?>
          </div><!-- /.navbar-inner -->
        </div><!-- /.navbar -->
