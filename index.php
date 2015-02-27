<?php 
	session_start();
	
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
		header ("Location: login.php");
	}
require('header/header.php');
?>

<html>
<head>
	<title>Command Center</title>
</head>
<body>
	<div class="nav">
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="#">
		        <img alt="Brand" src="img/logo.png">
		      </a>
		    </div>
		  </div>
		</nav>
	</div>
	<div class="header">
		<h1><b>Command Center</b></h1>
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
			    <h3 class="panel-title">Air Conditioning</h3>
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