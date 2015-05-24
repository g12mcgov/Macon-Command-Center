<?php session_start();
/*
	!// Macon-Command-Center

	Author: Grant McGovern 
	Date: 24 May 2015 

	URL: https://github.com/g12mcgov/Macon-Command-Center/blob/master/login.php

	Description:

	~ Provides a login system for the Macon-Command-Center.
*/

// Turn off errors
//error_reporting(E_ERROR);

ob_start();

$uname = "";
$pword = "";
$errorMessage = "";

function quote_smart($value, $handle) {
	
   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }

   if (!is_numeric($value)) {
       $value = "'" . mysql_real_escape_string($value, $handle) . "'";
   }
   return $value;
}

// Get config info
$config_parameters = parse_ini_file("config.ini");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Login credentials
	$uname = $_POST['username'];
	$pword = $_POST['password'];

	$uname = htmlspecialchars($uname);
	$pword = htmlspecialchars($pword);

	// If we're running in production
	if($config_parameters["PRODUCTION"] == "TRUE") {
		// Production runs on ClearDB remote host.
		$user_name = $config_parameters["PRODUCTION_DB_USERNAME"];
		$pass_word = $config_parameters["PRODUCTION_DB_PASSWORD"];
		$database = $config_parameters["PRODUCTION_DB_DATABASE"];
		$server = $config_parameters["PRODUCTION_DB_HOST"];
	}
	// Otherwise we're in dev mode
	else {
		$user_name = $config_parameters["DEVELOPMENT_DB_USERNAME"];
		$pass_word = $config_parameters["DEVELOPMENT_DB_PASSWORD"];
		$database = $config_parameters["DEVELOPMENT_DB_DATABASE"];
		$server = $config_parameters["DEVELOPMENT_DB_HOST"];
	}

	$db_handle = mysql_connect($server, $user_name, $pass_word);
	$db_found = mysql_select_db($database, $db_handle);

	if($db_found) {

		$uname = quote_smart($uname, $db_handle);
		$pword = quote_smart($pword, $db_handle);

		$SQL = "SELECT * FROM users WHERE username = $uname AND password = $pword";
		$ACCREDITED = mysql_query($SQL);
		
		$num_rows = mysql_num_rows($ACCREDITED);

		if ($ACCREDITED) {
			if ($num_rows > 0) {
				$_SESSION['login'] = "1";
				$_SESSION['user'] = $uname;

				header("Location: index.php");
			}
			else {
				$_SESSION['login'] = "";
				$errorMessage = "Invalid Password";
			}	
		}
		else {
			$errorMessage = "Invalid Password";
		}

	mysql_close($db_handle);

	}
	else {
		$errorMessage = "Failed to Establish Database Connection";
	}
}

// Include our styles, imports, etc... 
require('header/header.php');
?>

<html>
<body>
<div class="login">
	<div class="container">
	
		<div class="row">
			<div class="col-md-4"></div>

			<div class="col-md-4">
				<form name="form1" method="POST" action="login.php">
					<h1><b>Macon Command Center</b></h1>
					  <div class="form-group">
					    <input type="text" name="username" value="" class="form-control" id="exampleInputEmail1" maxlength="20" placeholder="Username">
					  </div>
					  <div class="form-group">
					    <input type="password" name="password" value="" class="form-control" id="exampleInputPassword1" maxlength="20" placeholder="Password">
					  </div>
					  <input class="button" type="submit" name="Submit1" value="Login">
				</form>	
				<p style="margin-top:5px;"> <?php if($errorMessage) { echo $errorMessage; } ?> </p>		
			</div>

			<div class="col-md-4"></div>
		</div>
	</div>
</div>
<footer>
  <p class="text-muted">Made with <span class="redheart" style="font-size:120%; color:red;">&hearts;</span> by<a href="http://www.grantmcgovern.com"> Grant McGovern</a></p>
</footer>
</body>
</html>

