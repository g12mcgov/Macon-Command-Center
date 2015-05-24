<?php session_start();
/*	
	!// Macon-Command-Center

	Author: Grant McGovern 
	Date: 24 May 2015 

	URL: https://github.com/g12mcgov/Macon-Command-Center/blob/master/logout.php

	Description:

	~ Provides a way to logout from the Macon-Command-Center.

*/
	session_destroy();
	require('header/header.php');
?>

<html>
<head>
</head>
<body>
	<div class="logout">
		<h1>You've been successfully logged out.</h1>
		<p>If this was a mistake, you can log back in <a href="login.php">here</a>.</p>
	</div>
	<footer>
  		<p class="text-muted">Made with <span class="redheart" style="font-size:120%; color:red;">&hearts;</span> by<a href="http://www.grantmcgovern.com"> Grant McGovern</a></p>
	</footer>
</body>
</html>