<!-- Robert Lagomarsino
An Vu
Project 3A Join Group -->

<?php
	require "connect.php";
	session_start();
	if (isset($_SESSION['username'])){
		$user = $_SESSION['username'];
		if (isset($_POST['e_id'])){
			$join = sprintf('INSERT INTO groupuser(group_id, username, authorized) VALUES (%d,"%s",%d)',$_POST['e_id'],$user,0);
			if($query = $link->query($join)){
				echo "SUCCESS";
				header('refresh:1;homepage.php#groups');
				$query->close();
			}
			else{
				echo "Failed to join group";
				header ('refresh:4;homepage.php#groups');
			}
			
		}
	}


?>