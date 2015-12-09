<!DOCTYPE html>
<!-- Robert Lagomarsino
An Vu
Project 3A Logout Page -->
<html>
<title>Logout</title>

<?php
	include "connect.php";
	session_start();
	session_destroy();
	sleep(1);
	echo "Logged out";
	echo "<br/>";
	echo "Redirecting in 5 seconds...";
	echo "Or press <a href='index.php'>here</a> to continue";
	header("refresh:5,index.php");
?>

</html>