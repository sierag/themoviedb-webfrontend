<?php
require_once('config.php');
require_once('db.php');
require_once('functions.php');
require_once('TMDb-PHP-API/TMDb.php');
require_once('header.php');
?>

		<style type="text/css">
	        .wizard-modal p {
	        	margin: 0 0 10px;
	        	padding: 0;
	        }
	        
			#wizard-ns-detail-servers, .wizard-additional-servers {
				font-size:12px;
				margin-top:10px;
				margin-left:15px;
			}
			#wizard-ns-detail-servers > li, .wizard-additional-servers li {
				line-height:20px;
				list-style-type:none;
			}
			#wizard-ns-detail-servers > li > img {
				padding-right:5px;
			}
			
			.wizard-modal .chzn-container .chzn-results {
				max-height:150px;
			}
			.wizard-addl-subsection {
				margin-bottom:40px;
			}
		</style>
	
		<div class="wizard" id="wizard-demo">
			<h1>Config: <?=truncate(SITE_TITLE,30);?></h1>
		
			<div class="wizard-card" data-onValidated="setServerName" data-cardname="name">
				<h3>Database</h3>
				<p>MySQL settings - You can get this info from your web host</p>	
				<div class="wizard-input-section">
					<div class="control-group">
						<input id="databasename" type="text" placeholder="Database Name" value="<?=DB_DATABASE?>" data-validate="" />
					</div>
					<div class="control-group">
						<input id ="databaseusername" type="text" placeholder="Username" value="<?=DB_USERNAME?>" data-validate="" />
					</div>
					<div class="control-group">
						<input id ="databasepassword" type="password" placeholder="Password" value="<?=DB_PASSWORD?>" data-validate="" />
					</div>
					<div class="control-group">
						<input id ="databasehost" type="text" placeholder="Host" value="<?=DB_HOST?>" data-validate="" />
					</div>
				</div>
			</div>
		
			<div class="wizard-card" data-cardname="tmdb">
				<h3>TMdb</h3>
				<div class="alert hide">
					It's recommended that you select at least one
					service, like ping.
				</div>
				<div class="wizard-input-section">
					<div class="control-group">
						<input id="tmdbapikey" type="text" placeholder="TMdb API Key" value="<?=TMDB_APIKEY?>" data-validate="validateAPIkey" />
					</div>
				</div>
			</div>
		
			<div class="wizard-card" data-cardname="services">
				<h3>Site Settings</h3>
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
					<p>
						We determined <strong>Chicago</strong> to be
						the closest location to monitor
						<strong class="create-server-name"></strong>
						If you would like to change this, or you think this is
						incorrect, please select a different
						monitoring location.
					</p>
		
					<select data-placeholder="Service List" style="width:350px;"
						class="chzn-select create-server-service-list">		
		                <option value="true">Turn on</option>
		                <option value="false">Turn off</option>
		            </select>		
				</div>
			</div>
				
		
			<div class="wizard-card">
				<h3>Statistics</h3>
		
				<div class="wizard-input-section">
					<p>The <a target="_blank" href="http://www.panopta.com/support/knowledgebase/support-questions/how-do-i-install-the-panopta-monitoring-agent/">Panopta Agent</a> allows
						you to monitor local resources (disk usage, cpu usage, etc).
						If you would like to set that up now, please download
						and follow the <a target="_blank" href="http://www.panopta.com/support/knowledgebase/support-questions/how-do-i-install-the-panopta-monitoring-agent/">install instructions.</a>
					</p>
		
		
					<div class="btn-group">
						<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
							Download
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#">.rpm</a></li>
							<li><a href="#">.deb</a></li>
							<li><a href="#">.tar.gz</a></li>
						</ul>
					</div>
		
				</div>
		
		
				<div class="wizard-input-section">
					<p>You will be given a server key after you install the Agent
						on <strong class="create-server-name"></strong>.
						If you know your server key now, please enter it
						below.</p>
		
					<div class="control-group">
						<input type="text" class="create-server-agent-key"
							placeholder="Server key (optional)" data-validate="" />
					</div>
				</div>
			</div>
		
			<div class="wizard-card" data-cardname="services">
				<h3>Google Analytics</h3>
				<div class="alert hide">
					It's recommended that you select at least one
					service, like ping.
				</div>
		
				<div class="wizard-input-section">
					<p>
						Please choose the services you'd like Panopta to
						monitor.  Any service you select will be given a default
						check frequency of 1 minute.
					</p>
		
					<select data-placeholder="Service List" style="width:350px;"
						class="chzn-select create-server-service-list" multiple>		
		                <option value="true">Turn on</option>
		                <option value="false">Turn off</option>
		            </select>
				</div>
			</div>		
		
			<div class="wizard-error">
				<div class="alert alert-error">
					<strong>There was a problem</strong> with your submission.
					Please correct the errors and re-submit.
				</div>
			</div>
		
			<div class="wizard-failure">
				<div class="alert alert-error">
					<strong>There was a problem</strong> submitting the form.
					Please try again in a minute.
				</div>
			</div>
		
			<div class="wizard-success">
				<div class="alert alert-success">
					<span class="create-server-name"></span>
					was created <strong>successfully.</strong>
				</div>
		
				<a class="btn create-another-server">Create another server</a>
				<span style="padding:0 10px">or</span>
				<a class="btn im-done">Done</a>
			</div>
		
		</div>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-wizard.js"></script>
<script src="js/jquery.lazyload.js"></script>
<script src="js/functions.js"></script>
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
	$.fn.wizard.logging = true;
	
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
		var submit = {
			"hostname": $("#new-server-fqdn").val()
		};

		setTimeout(function() {
			wizard.trigger("success");
			wizard.hideButtons();
			wizard._submitting = false;
			wizard.showSubmitCard("success");
			wizard._updateProgressBar(0);
		}, 2000);
	});

	wizard.on("reset", function(wizard) {
		wizard.setSubtitle("");
		wizard.el.find("#new-server-fqdn").val("");
		wizard.el.find("#new-server-name").val("");
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