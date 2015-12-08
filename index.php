<!DOCTYPE html>
<!-- Robert Lagomarsino
An Vu
Project 3A Interests Page -->
<html>
<title>Home</title>
<link href="css/index.css" rel="stylesheet">
<body>
	<?php
		include "connect.php";
		session_start();
		if (!isset($_SESSION['username'])){
			echo "<p id ='nav'>";
			echo "<a href='login.php'>Login</a>";
			echo "<a href='signup.php'>Sign Up </a>";
			echo "</p>";
		}
		if (isset($_SESSION['username'])){
			echo "<p id ='nav'>
				<a href='homepage.php#home' >Home</a>
				<a href='index.php'> All Events </a>
				<a href='homepage.php#events'>My Events</a>
				<a href='homepage.php#groups'>Groups</a>
				<a href='logout.php'>Logout</a>
			</p>";
		}
	?>
	<h2>Interests</h2>
	<form  id = 'form' action='<?php echo $_SERVER['PHP_SELF'];?>' method ='post' name ='interest_form'>
		<select name='interests'>
			<option value='all'>All</option>
			<?php
				if ($query = $link->prepare('select * from interest')){
					$query->execute();
					$query->bind_result($interest);
					while($query->fetch()){
						echo "<option value='".$interest."'>".$interest."</option>\n";
					}
					$query->close();
				}
			?>
		</select>
		<input type='submit' value='Filter'>
	</form>
	<table style='text-align:center;'>
		<tr>
			<td>Event ID</td>
			<td>Title</td>
			<td>Description</td>
			<td>Start Time</td>
			<td>End Time</td>
			<td>Group ID</td>
			<td>Location</td>
			<td>Zip Code</td>
			<td></td>
		</tr>
	<?php
		$choice = 'SELECT * from an_event';
		if(isset($_POST['interests'])){
			$interest_choice =  $_POST['interests'];
			if ($interest_choice != 'all'){
				$choice = "SELECT * from an_event where group_id in (select group_id from groupinterest where interest_name='".$interest_choice."' order by start_time asc)";
			}
		}
		// echo $choice;
		if($query = $link->query($choice)){
			while($row = $query->fetch_row()){
				echo "<tr>";
				echo "<td>".$row[0]."</td>";
				echo "<td>".$row[1]."</td>";
				echo "<td>".$row[2]."</td>";
				echo "<td>".$row[3]."</td>";
				echo "<td>".$row[4]."</td>";
				echo "<td>".$row[5]."</td>";
				echo "<td>".$row[6]."</td>";
				echo "<td>".$row[7]."</td>";
				if (isset($_SESSION['username'])){
					if($rsvp_query = $link->prepare('Select rsvp from eventuser where username= ? and event_id = ?')){

						$rsvp_query->bind_param('si',$_SESSION['username'],$row[0]);
						$rsvp_query->execute();
						$rsvp_query->bind_result($rsvp);
						
						if($rsvp_query->fetch()){
							echo "<td>";
							echo ($rsvp == 0) ? "<a id='login'>RSVP</a>" : "Attending &#10004";
							echo "</td>";
						}
						else{
							echo "<td><form action='rsvp.php' method='POST' style='float:right;'> <input type='hidden' value='".$row[0]."'name='event'><input type='submit' value='RSVP'></form></td>";
						}
						$rsvp_query->close();
					}
				}
				echo "</tr>";
			}
			$query->close();
		}

	?>
	</table>
</body>

</html>