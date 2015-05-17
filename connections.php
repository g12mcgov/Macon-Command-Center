<?php 
session_start();
ob_start();

require("header/header.php");

$raspberry_pi_host = "192.168.1.12";
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
<head>
</head>
<body>
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
</body>
</html>