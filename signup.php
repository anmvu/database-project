<!DOCTYPE html>
<!-- Robert Lagomarsino
An Vu
Project 3A SignUp Page -->
<html>
<title>Sign Up</title>

<?php

	include "connect.php";
	session_start();

	if (isset($_SESSION['username'])){
		echo "You are already logged!\n";
		header("refresh:3;homepage.php#home");
	}

	else{
		if(isset($_POST['username']) && isset($_POST['password'])){
			$user = $_POST['username'];
			$pass = md5($_POST['password']);
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$zip = $_POST['zip'];
			if($query = $link->prepare('INSERT INTO member(username, password, firstname, lastname, zipcode) values (?,?,?,?,?)')){
				echo "test";
				$query->bind_param('ssssi',$user,$pass,$fname,$lname,$zip);
				if(!$query->execute()){
					if (strpos($link->error,'PRIMARY')){
						echo "Username is not available. Please use another";
					} 
					echo '<button onclick="goBack()">Go Back</button>';
				}
				else{
					$_SESSION['username'] = $user;
					$_SESSION['password'] = $pass;
					$_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
					echo "Success!";
					header('refresh:3;homepage.php#events');
				}
			$query->close();
			$link->close();
			}
		}

		else{
			echo "<link href=\"css/login.css\" rel=\"stylesheet\">";
			echo "<div id='login'>";
			echo "<h1> Create Account </h1><br/>\n";
			echo "<form action='signup.php' method='POST'>";
			echo "\n";
			echo "<p class='label'>Username</p> <input class='input' type='text' name='username' /><br/>";
			echo "<p class='label'>Password</p> <input class='input'  type='password' name='password'/> <br/>";
			echo "<p class='label'>First Name</p> <input class='input'  type='text' name='fname'/> <br/>";
			echo "<p class='label'>Last Name</p> <input class='input'  type='text' name='lname'/> <br/>";
			echo "<p class='label'>Zip Code</p> <input class='input'  type='text' name='zip'/> <br/>";
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