<?php 
	session_start();
	
	// If not logged in, redirect to login page.
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
		header("Location: login.php");
	}

require('header/header.php');
?>

<html>
<head>
	<title>Macon Command Center</title>
</head>
<body>
	<div class="nav">
		<nav class="navbar navbar-inverse" id="primaryNavbar">
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
			    <h3 class="panel-title">Lights</h3>
			  </div>
			  <div class="panel-body">
			    Panel content
			  </div>
			</div>
		  </div>
		  <div class="col-md-4">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Security Camera</h3>
			  </div>
			  <div class="panel-body">
			    Panel content
			  </div>
			</div>
		  </div>
		  <div class="col-md-4">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Blinds</h3>
			  </div>
			  <div class="panel-body">
			    Panel content
			  </div>
			</div>
		  </div>
		</div>
	</div>
</body>
</html>