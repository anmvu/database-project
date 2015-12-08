<html>
<body>
<?php
	require "connect.php";
	session_start();
	if(isset($_SESSION['username'])){
		echo "<h1>WELCOME ".$_SESSION['username']."</h1>"
	}
?>

</body>
</html>