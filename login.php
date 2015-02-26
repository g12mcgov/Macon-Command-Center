<?php session_start();

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$uname = $_POST['username'];
	$pword = $_POST['password'];

	$uname = htmlspecialchars($uname);
	$pword = htmlspecialchars($pword);

	// Connect to the local dateabase 
	$user_name = "root";
	$pass_word = "nantucket";
	$database = "dashboard";
	$server = "127.0.0.1";

	$db_handle = mysql_connect($server, $user_name, $pass_word);
	$db_found = mysql_select_db($database, $db_handle);

	if ($db_found) {

		$uname = quote_smart($uname, $db_handle);
		$pword = quote_smart($pword, $db_handle);

		$SQL = "SELECT * FROM users WHERE username = $uname AND password = $pword";
		$ACCREDITED = mysql_query($SQL);
		
		$num_rows = mysql_num_rows($ACCREDITED);

		if ($num_rows > 0) { print "Authenticated"; }

		if ($ACCREDITED) {
			if ($num_rows > 0) {
				$_SESSION['login'] = "1";
				header ("Location: index.php");
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
		$errorMessage = "Error logging on";
	}

}

// Include our styles, imports, etc... 
require('header/header.php');
?>
<body>
	<div class="login">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<form NAME ="form1" METHOD ="POST" ACTION ="login.php">
			  <div class="form-group">
			    <label for="exampleInputEmail1">Username</label>
			    <input type="text" name="username" value="" class="form-control" id="exampleInputEmail1" maxlength="20">
			  </div>
			  <div class="form-group">
			    <label for="exampleInputPassword1">Password</label>
			    <input type="password" name="password" value="" class="form-control" id="exampleInputPassword1" maxlength="20">
			  </div>
			  <input type="submit" name="Submit1" value="Login">
			</form>			
		</div>
		<div class="col-md-4"></div>
	</div>
	</div>
	<?php print $errorMessage;?>
</body>
