<?php session_start();
/*
	!// Macon-Command-Center
	
	Author: Grant McGovern 
	Date: 24 May 2015 

	URL: https://github.com/g12mcgov/Macon-Command-Center/blob/master/connections.php

	Description:

	~ Provides a way to test connectivity to Raspberry Pi.
*/

require("header/header.php");

$raspberry_pi_host = "192.168.1.13";
$raspberry_pi_port = 22;

function ping($host, $port, $timeout) {
	$fsock = fsockopen($host, $port, $errno, $errstr, $timeout);
	
	if (!$fsock){
		return FALSE;
	}
	else {
		return TRUE;
	}
}

?>

<html>
<body>
	<div class="nav">
		<nav class="navbar navbar-inverse navbar-static-top" id="primaryNavbar">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="index.php">
		        <img alt="Brand" src="img/logo.png">
		      </a>
		      <h2 class="nav navbar-text">Macon Command Center</h2> 
		    </div>
		    <!-- Collect the nav links, forms, and other content for toggling -->
    		<div class="collapse navbar-collapse">
			    <ul class="nav navbar-nav navbar-right">
	        	<li><a href="#">Connections</a></li>
	        	<li><a href="logout.php">Logout</a></li>
	        	</ul>
	        </div>
		  </div>
		</nav>
	</div>
	<p id="loadtext">Testing Raspberry Pi Connection</p>
	<script>
		$(document).ready(function() {
			var loadText = document.getElementById('loadtext');
			var count = 0;

			setInterval(function() {
				if (count > 4) {
					document.getElementById('statusText').style.visibility = "visible";
					return;
				}
				else {
					loadText.innerHTML += ".";
					count += 1;
				}	
			}, 1000);
		});
	</script>

	<div id="statusText" style="visibility:hidden;">
	<?php 
		if (ping($raspberry_pi_host, $raspberry_pi_port, 6)) {
			echo "<p style='color:green;'>Connection to Raspberry Pi Established</p>";
			echo "<p><b>IP Address</b>: $raspberry_pi_host</p>";
			echo "<p><b>Port:</b> $raspberry_pi_port</p>";
		}
		else {
			echo "<p style='color:red;'>Could not Establish Connection</p>";
		}
	?>
	</div>
	<footer>
  		<p class="text-muted">Made with <span class="redheart" style="font-size:120%; color:red;">&hearts;</span> by<a href="http://www.grantmcgovern.com"> Grant McGovern</a></p>
	</footer>
</body>
</html>