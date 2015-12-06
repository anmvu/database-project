<!-- Robert Lagomarsino
An Vu
Project 3A Connecting to the Database -->
<?php
	$link = new mysqli("localhost","root","","meetup");
	if ($link->connect_errno) {
	    echo "Failed to connect to MySQL: (" . $link->connect_errno . ") " . $link->connect_error;
	}
	
?>