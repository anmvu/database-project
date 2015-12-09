<!-- Robert Lagomarsino
An Vu
Project 3A SignUp Page -->
<link href='css/homepage.css' rel='stylesheet'>
<?php
	include "connect.php";
	session_start();
?>
<p id ='nav'>
	<a href='#home'>Home</a>
	<a href='index.php' > All Events </a>
	<a href='#events'>My Events</a>
	<a href='#groups' >Groups</a>
	<a href='updateuser.php'> My Account(<?php echo $_SESSION['username']?>)</a>
	<a href='logout.php'>Logout</a>
</p>
<?php
	if(isset($_SESSION['username'])){
		$user = $_SESSION['username'];
		if (isset($_POST['change'])){
			if (isset($_POST['current']) && isset($_POST['new']) && isset($_POST['retype'])){
				$pass = md5($_POST['new']);
				$old = md5($_POST['current']);
				$check_pass = sprintf('SELECT * from member where password = "%s" and username= "%s"',$old,$user);
				if ($query = $link->query($check_pass)){
					if(mysqli_num_rows($query) != 0  && $_POST['new'] == $_POST['retype']){
						if ($check = $link->prepare('UPDATE member SET password = ? WHERE username=?')){
							$check->bind_param('ss',$pass,$user);
							$check->execute();
							echo "Updated password";
							echo "<br>";
						}
					}
					
					$query->close();
				}
			}
			// $update = 'UPDATE member set firstname = "%s",lastname="%s",zipcode=%d where '
			$first = ($_POST['first']);
			$last = ($_POST['last']);
			$zip = ($_POST['zip']);
			if($query = $link->prepare('UPDATE member set firstname = ?, lastname = ?, zipcode = ? where username = ?')){
				$query->bind_param('ssis',$first,$last,$zip,$user);
				$query->execute();
				echo "SUCCESS!";
				header("refresh:1;updateuser.php");
				$query->close();
			}
		}
		else{
			echo "<h1>WELCOME ".strtoupper($user)."!</h1>";
			$member = sprintf('SELECT * from member where username= "%s"',$user);
			if($query = $link->query($member)){
				if($row = $query->fetch_row()){
					echo "<form action='updateuser.php' method='post'>";
					echo "<div style='display:inline-block;width:150px;'><label>Current Password</label></div>";
					echo "<input type='password' name='current'>";
					echo "<br>";
					echo "<div style='display:inline-block;width:150px;'><label>New Password</label></div>";
					echo "<input type='password' name='new'>";
					echo "<br>";
					echo "<div style='display:inline-block;width:150px;'><label>Retype New Password</label></div>";
					echo "<input type='password' name='retype'>";
					echo "<br>";
					echo "<div style='display:inline-block;width:150px;'><label>First Name</label></div>";
					echo "<input type='text' name='first' value='".$row[2]."'>";
					echo "<br>";
					echo "<div style='display:inline-block;width:150px;'><label>Last Name</label></div>";
					echo "<input type='text' name='last'value='".$row[3]."'>";
					echo "<br>";
					echo "<div style='display:inline-block;width:150px;'><label>Zip Code</label></div>";
					echo "<input type='text' name='zip' value='".$row[4]."'>";
					echo "<br>";
					echo "<input type='submit' name='change' value='change'>";
					echo "</form>";
				}
				$query->close();
			}
		}
	}
	$link->close();
?>