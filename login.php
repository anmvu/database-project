<!DOCTYPE html>
<!-- Robert Lagomarsino
An Vu
Project 3A Login Page -->
<html>
<title>Login</title>

<?php

	include "connect.php";
	session_start();

	if (isset($_SESSION['username'])){
		echo "You are already logged in!\n";
		header("refresh:3;homepage.php#home");
	}

	else{
		if(isset($_POST['username']) && isset($_POST['password'])){
			$user = $_POST['username'];
			$pass = md5($_POST['password']);
			if($query = $link->prepare('Select username,password from member where username= ? and password = ?')){
				$query->bind_param('ss',$user,$pass);
				$query->execute();
				$query->bind_result($username,$password);
				if($query->fetch()){
					$_SESSION['username'] = $username;
					$_SESSION['password'] = $password;
					$_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
					echo "Login successful";
					echo "<br/>";
					echo "Redirecting in 5 seconds..";
					echo "<br/>";
					echo "Or press <a href='homepage.php'>here</a> to continue";
					header("refresh: 5; homepage.php");
				}

				else{
					sleep(1);
					echo "Username and password combination is incorrect";
					echo "<br/>";
					echo "Redirecting in 5 seconds...";
					echo "Or press <a href='login.php'>here</a> to continue";
					header("refresh:5,login.php");
				}

				$query->close();
				$link->close();
			}
		}

		else{
			echo "<link href=\"css/login.css\" rel=\"stylesheet\">";
			echo "<div id='login'>";
			echo "<h1> Login </h1><br/>\n";
			echo "<form action='login.php' method='POST'>";
			echo "\n";
			echo "<p class='label'>Username</p> <input class='input' type='text' name='username' /><br/>";
			echo "<p class='label'>Password</p> <input class='input'  type='password' name='password'/> <br/>";
			echo "\n";
			echo "<a href='index.php' id='back'> Go Back </a>";
			echo "<input id= 'submit' type='submit' value='Submit'/>";
			echo "\n";
			echo "</form>";
			echo "\n";
			echo "</div>";
		}
	}

?>

</body>
</html>