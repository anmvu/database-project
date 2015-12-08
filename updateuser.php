<?php
	include "connect.php";
	session_start();
	if(isset($_SESSION['username'])){
		$user = $_SESSION['username'];
		echo "<h1>WELCOME ".strtoupper($user)."!</h1>";
		if($query= $link->prepare('SELECT * from member where username= ?')){
			$query->bind_param('s',$user);
			echo $link->error;
			$query->execute();
			$query->bind_result($username,$password,$firstname,$lastname,$zip);
			var_dump($username);
			echo "<br>";
			echo $password;
			echo "<br>";
			echo $firstname;
			echo "<br>";
			echo $lastname;
			echo "<br>";
			echo $zip;
			echo "<br>";
			$query->close();
		}
	}
	$link->close();
?>