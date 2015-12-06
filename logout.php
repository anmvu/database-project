<!DOCTYPE html>
<<<<<<< HEAD
<!-- Robert Lagomarsino
An Vu
Project 3A Login Page -->
=======
>>>>>>> origin/master
<html>
<title>Logout</title>

<?php
<<<<<<< HEAD
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
=======
	session_start();
	session_destroy();
	echo "You are logged out. You will be redirected in 3 seconds\n";
	echo "or press <a href='index.php'>here</a> to go home.";
	header("refresh: 3; index.php");
?>

>>>>>>> origin/master
</html>