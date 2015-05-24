<?php session_start();
/*
	!// Macon-Command-Center

	Author: Grant McGovern 
	Date: 24 May 2015 

	URL: https://github.com/g12mcgov/Macon-Command-Center/blob/master/index.php

	Description:

	~ The main dashboard (index) page for the Macon-Command-Center.
*/
	
	// If not logged in, redirect to login page.
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
		header("Location: login.php");
	}

require('header/header.php');
?>

<html>
<body>
	<div class="nav">
		<nav class="navbar navbar-inverse navbar-static-top" id="primaryNavbar">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="#">
		        <img alt="Brand" src="img/logo.png">
		      </a>
		      <h2 class="nav navbar-text">Macon Command Center</h2> 
		    </div>
		    <!-- Collect the nav links, forms, and other content for toggling -->
    		<div class="collapse navbar-collapse">
			    <ul class="nav navbar-nav navbar-right">
			    <p class="nav navbar-text">Welcome, <i><?php echo str_replace("'", "", $_SESSION['user']); ?></i></p>
	        	<li><a href="connections.php">Connections</a></li>
	        	<li><a href="logout.php">Logout</a></li>
	        	</ul>
	        </div>
		  </div>
		</nav>
	</div>
	<div class="header">
		<h3 id="date"><b></b></h3>
		<script>
			$(document).ready(function() {
				setInterval(function(){
				  $("#date").text(moment().format('h:mma MMMM, Do YYYY'));
				},1000);
			});
		</script>	
		<hr>
	</div>
	<div class="control">
		<div class="row">
		  <div class="col-md-4">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title"><b>Lights</b></h3>
			  </div>
			  <div class="panel-body">
			  	<div class="ColorPicker">
			  		<p>Phillips Hue</p>
			  		<div class="light-switch" id="light-switch-id">
				  		<input type="checkbox" id="light" data-off-text="Off" data-on-text="On" checked>
				  	</div>
					<div id="cpDiv2" style="display:inline-block;"></div>
				</div>
				<script>
					$(document).ready(function(){
						// Default light color to nice white.
						$('#cpDiv2').colorpicker({color:'#ffffcc', defaultPalette:'web'});
						$('#light').bootstrapSwitch();
					});
				</script>
			  </div>
			</div>
		  </div>
		  <div class="col-md-4">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title"><b>Security Camera</b></h3>
			  </div>
			  <div class="panel-body">
			  	<p>Grant's Room</p>
			  	<div id="securityCameraFootage"></div>
			  </div>
			</div>
		  </div>
		  <div class="col-md-4">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title"><b>Blinds</b></h3>
			  </div>
			  <div class="panel-body">
			  	<div class="blind-switches">
			  		<p>Backyard Blinds</p>
			  		<input type="checkbox" id="backyard-blinds" data-off-text="Close" data-on-text="Open" checked>
			    	<p>Side Blinds</p>
			    	<input type="checkbox" id="side-blinds" data-off-text="Close" data-on-text="Open" checked>
			  		</div>
			    <script>
			    	$(document).ready(function(){
			    		$('#backyard-blinds').bootstrapSwitch();
			    		$('#side-blinds').bootstrapSwitch();
			    	});
			    </script>
			  </div>
			</div>
		  </div>
		</div>
	</div>
	<footer>
  		<p class="text-muted">Made with <span class="redheart" style="font-size:120%; color:red;">&hearts;</span> by<a href="http://www.grantmcgovern.com"> Grant McGovern</a></p>
	</footer>
</body>
</html>