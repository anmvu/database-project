<?php
	include "connect.php";
	session_start();
	if(isset($_SESSION['username'])){
		$user = $_SESSION['username'];
		if (isset($_POST['change'])){
			if (isset($_POST['current']) && isset($_POST['new']) && isset($_POST['retype'])){
				$pass = md5($_POST['new']);
				$old = md5($_POST['current']);
				echo $pass;
				// $check_pass = sprintf('SELECT * from member where password = "%s" and username= "%s"',$old,$user);
				// if ($query = $link->query($check_pass)){
				if($query = $link->prepare('SELECT * from member where password = ? and username= ?')){
					$query->bind_param('ss',$old,$user);
					$query->execute();
					print $query->num_rows();
					if($query->num_rows() != 0  && $_POST['new'] == $_POST['retype']){
						echo "yes";
						if ($check = $link->prepare('UPDATE member SET password = ? WHERE username=?')){
							$check->bind_param('ss',$pass,$user);
							$check->execute();
							echo "Update password";
						}
						echo 'right password';
					}
					
					$query->close();
				}
			}
			if($query = $link->prepare('UPDATE member set firstname = ?, lastname = ?, zipcode = ? where user = ?')){
				$query->bind_param('ssis',$first,$last,$zip,$user);
				$query->execute();
				echo "SUCCESS!";
				header("refresh:2;homepage.php#home");
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