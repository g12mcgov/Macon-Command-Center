<?php
	session_start();
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
</body>
</html>