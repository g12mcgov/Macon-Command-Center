<?php session_start();

//error_reporting(E_ERROR);

ob_start();

//h

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$uname = $_POST['username'];
	$pword = $_POST['password'];

	$uname = htmlspecialchars($uname);
	$pword = htmlspecialchars($pword);

	// Connect to the production ClearDB database
	$user_name = "b7bdf492597fd9";
	$pass_word = "6b44c078";
	$database = "heroku_1fd6a6b63ed5496";
	$server = "us-cdbr-iron-east-02.cleardb.net";

	$db_handle = mysql_connect($server, $user_name, $pass_word);
	$db_found = mysql_select_db($database, $db_handle);

	if($db_found) {

		$uname = quote_smart($uname, $db_handle);
		$pword = quote_smart($pword, $db_handle);

		$SQL = "SELECT * FROM users WHERE username = $uname AND password = $pword";
		$ACCREDITED = mysql_query($SQL);
		
		$num_rows = mysql_num_rows($ACCREDITED);

		// if ($num_rows > 0) { 
		// 	print "Authenticated"; 
		// }

		if ($ACCREDITED) {
			if ($num_rows > 0) {
				$_SESSION['login'] = "1";
				header("Location: index.php");
			}
			else {
				$_SESSION['login'] = "";
			}	
		}
		else {
			$errorMessage = "Error logging on";
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

