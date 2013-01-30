<!DOCTYPE html>
<html lang="en">
<head>
<title><?=SITE_TITLE?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<link href="<?=SUBDIR?>css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="<?=SUBDIR?>css/bootstrap-responsive.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<link href='<?=SUBDIR?>css/font-awesome.min.css' rel='stylesheet' type='text/css'>
<link href='<?=SUBDIR?>css/style.css' rel='stylesheet' type='text/css'>

</head>
<body>
<div class="container-fluid" id="container">
<!-- NAVBAR
    ================================================== -->
        <div class="navbar navbar-inverse navbar-fixed-top">
          <div class="navbar-inner">
	    <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-reorder"></span>
            </a>
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".searchcollapse">
              <i class="icon-search"></i>
            </a>
            <a class="brand" href="<?=SUBDIR?>"><?=SITE_TITLE?></a>
            <div class="nav-collapse searchcollapse collapse">
		<ul class="nav pull-right">
		<li><form class="form-search">
	  	  <div class="input-append">
	 	   	<input type="text" class="span2 search-query inverse" placeholder="search" name='search' id='search'>
  			<button type="submit" class="btn btn-inverse"><i class="icon-search" id='searchicon'></i></button>
  		  </div>
		</form></li>
<!--		<li><a href="#fullscreen" id="fullscreen" class="btn btn-inverse"><i class="icon-fullscreen"></i></a></li>
-->	        </ul>
	    </div>
	    <div class="nav-collapse collapse">
		<ul class="nav">
		  <li <? if(SUBDIR . "index.php" == $_SERVER['SCRIPT_NAME']) { ?>class="active"<? } ?>><a href="<?=SUBDIR?>">Rated</a></li>
		<? if(!isset($_GET["url"])){ ?>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sort<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="<?=SUBDIR?>?sort=release_date" class="active">Release Date</a></li>
                      <li><a href="<?=SUBDIR?>?sort=title">Title</a></li>
                      <li><a href="<?=SUBDIR?>?sort=runtime">Runtime</a></li>
                      <li><a href="<?=SUBDIR?>?sort=rating">My Rating</a></li>
                    </ul>
                  </li>
            	<? } ?>
	          <li <? if(SUBDIR . "stats.php" == $_SERVER['SCRIPT_NAME']) { ?>class="active"<? } ?>><a href="<?=SUBDIR?>stats.php">Stats</a></li>
	          <? if(isloggedin()){ ?>
		  <li <? if(SUBDIR . "logs.php" == $_SERVER['SCRIPT_NAME']) { ?>class="active"<? } ?>><a href="<?=SUBDIR?>logs.php">Admin</a></li>
		  <? } ?>
              </ul>
            </div><!--/.nav-collapse -->
            </div>
            </div>
	  </div><!-- /.navbar-inner -->
        </div><!-- /.navbar -->
