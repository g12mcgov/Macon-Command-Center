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
				header ("Location: signup.php");
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


?>


<html>
<head>
	<title>Login</title>
</head>
<body>

	<FORM NAME ="form1" METHOD ="POST" ACTION ="login.php">

		Username: <INPUT TYPE = 'TEXT' Name ='username' value="" maxlength="20">
		Password: <INPUT TYPE = 'TEXT' Name ='password' value="" maxlength="16">

		<p align = center>
			<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Login">
		</p>

	</FORM>

	<p>
	
	<?php print $errorMessage;?>

</body>
</html>