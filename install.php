<?php
/**
 * WordPress Installer
 *
 * @package WordPress
 * @subpackage Administration
 */

// Sanity check.
if ( false ) {
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Error: PHP is not running</title>
</head>
<body class="wp-core-ui">
	<h1 id="logo"><a href="http://wordpress.org/">WordPress</a></h1>
	<h2>Error: PHP is not running</h2>
	<p>WordPress requires that your web server is running PHP. Your server does not have PHP installed, or PHP is turned off.</p>
</body>
</html>
<?php
}

if(!file_exists( dirname( __FILE__ ) . '/config.php')) {
	if(!copy(dirname( __FILE__ ) . "/config.php.default", dirname( __FILE__ ) . "/config.php")) {
		die('could not move the config.php.default to config.php, please do this manualy.');
	}
}

require_once('config.php');
require_once('functions.php');
require_once('header.php');
?>
<div class="wizard" id="wizard-demo">
	<h1><? if(INSTALLED) { ?>Installation<? } else {?>Configuration<? } ?>: <?=truncate(SITE_TITLE,30);?></h1>

	<div class="wizard-card" data-onValidated="setServerName" data-cardname="name">
		<h3>MySQL Database</h3>
		<p>If you don't have your database info you can get this from your web host</p>	
		<div class="wizard-input-section">
			<div class="control-group">
				<input id="databasename" type="text" placeholder="Database Name" value="<?=DB_DATABASE?>" data-validate="" />
			</div>
			<div class="control-group">
				<input id ="databaseusername" type="text" placeholder="Username" value="<?=DB_USERNAME?>" data-validate="" />
			</div>
			<div class="control-group">
				<input id ="databasepassword" type="password" placeholder="Password" value="" data-validate="" />
			</div>
			<div class="control-group">
				<input id ="databasehost" type="text" placeholder="Host" value="<?=DB_HOST?>" data-validate="" />
			</div>
		</div>
	</div>

	<div class="wizard-card" data-cardname="tmdb">
		<h3>TMdb</h3>
		<div class="alert hide">
			It's recommended that you select at least one service, like ping.
		</div>
		<p>Your TMdb username is required so that no other user wil be updating your personal movie information</p>
		<div class="wizard-input-section">
			<div class="control-group">
				<input  id="tmdbusername" type="text" placeholder="TMdb Username" class="span2" value="<?=TMDB_USERNAME?>" maxlength="32" cols="32" data-validate="validateAPIkey" />
			</div>
		</div>
		<p>To register for an API key, head into your <a href="https://www.themoviedb.org/account" target="_blank">account page</a> on The Movie Database and generate a new key from within the "API Details" section.</p>
		<div class="wizard-input-section">
			<div class="control-group">
				<input  id="tmdbapikey" type="text" placeholder="TMdb API Key" class="span4" value="<?=TMDB_APIKEY?>" maxlength="32" cols="32" data-validate="validateAPIkey" />
			</div>
		</div>
	</div>

	<div class="wizard-card" data-cardname="services">
		<h3>Site Settings</h3>
		<p>Website title, displayed on screen and in the code.</p>
		<div class="alert hide">
			It's recommended that you select at least one
			service, like ping.
		</div>
		<div class="wizard-input-section">
			<div class="control-group">
				<input id="sitetile" type="text" placeholder="Website title" value="<?=SITE_TITLE?>" data-validate="" />
			</div>
		</div>
	</div>

		
	<div class="wizard-card" data-onload="" data-cardname="caching">
		<h3>Caching</h3>
		<div class="wizard-input-section">
			<p>To make sure this website works stand alone (frontpage & movie details) without the CDN's of TMdb, please turn caching on. Also it will be more bandwidth friendly towards TMdb.
			</p>
			<div class="switch">
				<input type="checkbox" <?if(CACHING){?>checked<?}?>>
			</div>
		</div>
	</div>
		
	<div class="wizard-card">
		<h3>Statistics</h3>		
		<div class="wizard-input-section">
			<p>Show the amount of genres by the piechart</p>
			<input  id="SHOW_AMOUNT_GENRES" type="number" placeholder="15" class="span1" value="<?=SHOW_AMOUNT_GENRES?>" maxlength="2" cols="2" />
			<p>Show the amount of Actors & Directors in the list</p>
			<input  id="SHOW_AMOUNT_TOPX" type="number" placeholder="20" class="span1" value="<?=SHOW_AMOUNT_TOPX?>" maxlength="2" cols="2" />
		</div>
	</div>

	<div class="wizard-card" data-cardname="services">
		<h3>Google Analytics</h3>
		<div class="alert hide">
			It's recommended that you select at least one service, like ping.
		</div>

		<div class="wizard-input-section">
			<p>If you place you own TRACKING ID here it automaticly will place it in the footer of the website.</p>
			<input  id="GOOGLE_TRACKING_ID" type="text" placeholder="UA-263097-7" class="span2" value="<?=GOOGLE_TRACKING_ID?>" maxlength="12" cols="12" />
		</div>
	</div>		

	<div class="wizard-error">
		<div class="alert alert-error">
			<strong>There was a problem</strong> with your submission. Please correct the errors and re-submit.
		</div>
	</div>
		
	<div class="wizard-success">
		<div class="alert alert-success">
			<span class="create-server-name"></span>
			was created <strong>successfully.</strong>
		</div>
		<a class="btn im-done">Done</a>
	</div>		
</div>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-wizard.js"></script>
<script src="js/jquery.lazyload.js"></script>
<script src="js/functions.js"></script>
<script src="js/jquery.switch.js"></script>
<script type="text/javascript">

function setServerName(card) {
	var host = $("#new-server-fqdn").val();
	var name = $("#new-server-name").val();
	var displayName = host;

	if (name) {
		displayName = name + " ("+host+")";
	};

	card.wizard.setSubtitle(displayName);
	card.wizard.el.find(".create-server-name").text(displayName);
}

function validateAPIkey(el){
	var val = el.val();
	return (val.length == 32);
}

function validateIP(ipaddr) {
    //Remember, this function will validate only Class C IP.
    //change to other IP Classes as you need
    ipaddr = ipaddr.replace(/\s/g, "") //remove spaces for checking
    var re = /^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/; //regex. check for digits and in
                                          //all 4 quadrants of the IP
    if (re.test(ipaddr)) {
        //split into units with dots "."
        var parts = ipaddr.split(".");
        //if the first unit/quadrant of the IP is zero
        if (parseInt(parseFloat(parts[0])) == 0) {
            return false;
        }
        //if the fourth unit/quadrant of the IP is zero
        if (parseInt(parseFloat(parts[3])) == 0) {
            return false;
        }
        //if any part is greater than 255
        for (var i=0; i<parts.length; i++) {
            if (parseInt(parseFloat(parts[i])) > 255){
                return false;
            }
        }
        return true;
    }
    else {
        return false;
    }
}

function validateFQDN(val) {
	return /^[a-z0-9-_]+(\.[a-z0-9-_]+)*\.([a-z]{2,4})$/.test(val);
}

function fqdn_or_ip(el) {
	var val = el.val();
	ret = {
		status: true
	};
	if (!validateFQDN(val)) {
		if (!validateIP(val)) {
			ret.status = false;
			ret.msg = "Invalid IP address or FQDN";
		}
	}
	return ret;
}

$(function() {

	$.fn.wizard.logging = false;
	
	var wizard = $("#wizard-demo").wizard();

	wizard.el.find(".wizard-ns-select").change(function() {
		wizard.el.find(".wizard-ns-detail").show();
	});

	wizard.el.find(".create-server-service-list").change(function() {
		var noOption = $(this).find("option:selected").length == 0;
		wizard.getCard(this).toggleAlert(null, noOption);
	});

	wizard.cards["name"].on("validated", function(card) {
		var hostname = card.el.find("#new-server-fqdn").val();
	});

	wizard.on("submit", function(wizard) {
		
		$("#databasename").val();
		$("#databaseusername").val();
		$("#databasepassword").val();
		$("#databasehost").val();
		
		/*
		var submit = {
			"hostname": 
		};

		setTimeout(function() {
			wizard.trigger("success");
			wizard.hideButtons();
			wizard._submitting = false;
			wizard.showSubmitCard("success");
			wizard._updateProgressBar(0);
		}, 2000);
		*/
	});


	wizard.el.find(".wizard-success .im-done").click(function() {
		wizard.reset().close();
	});

	wizard.el.find(".wizard-success .create-another-server").click(function() {
		wizard.reset();
	});
	
	$(".wizard-group-list").click(function() {
		alert("Disabled for demo.");
	});

	wizard.show();
});
</script>	
<? require_once("footer.php")?>