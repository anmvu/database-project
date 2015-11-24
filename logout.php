<!DOCTYPE html>
<html>
<title>Logout</title>

<?php
	session_start();
	session_destroy();
	echo "You are logged out. You will be redirected in 3 seconds";
	echo "or press <a href='index.php'>here</a> to go home.";
	header("refresh: 3; index.php");
?>

</html>