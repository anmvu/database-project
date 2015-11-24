<!DOCTYPE html>
<html>
<title>MeetUp</title>
<link href="css/index.css" rel="stylesheet">

<?php
	session_start();
	include "connect.php";
	// create group
	// join group
	// grant ability to create events
	echo "<div>";
	echo "<a id='login' href='logout.php'>Logout</a>";
	echo "</div>";
	if (isset($_SESSION['username'])){
		echo "<h1>Upcoming Events</h1>"
		
	}
?>