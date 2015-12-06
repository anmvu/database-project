<!DOCTYPE html>
<<<<<<< HEAD
<!-- Robert Lagomarsino
An Vu
Project 3A Interests Page -->
<html>
	<title>Homepage</title>
	<link href="css/index.css" rel="stylesheet">
	<body>
		<a id='login' href='logout.php'>Logout</a>
		<?php
		include 'index.php';
		?>
	</body>
	<br/>
	<body>
		<h2>My Upcoming Events</h2>
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
			</tr>
		<?php
			$choice = "SELECT * from an_event where event_id in (select event_id from eventuser where username='".$_SESSION['username']."')";
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
					echo "</tr>";
				}
				$query->close();
			}

		?>
		</table>
	</body>
	<br/>
	<body>
		<h2>Create an Event</h2>
		<table style='text-align:center;'>
			<tr>
				<td></td>
				<td>Group ID</td>
				<td>Group Name</td>
				<td>Description</td>
			</tr>
		<?php
			$choice = "SELECT group_id, group_name, description from a_group where group_id in (select group_id from groupuser where authorized = '1' and username='".$_SESSION['username']."')";
			if($query = $link->query($choice)){
				while($row = $query->fetch_row()){
					echo "<tr>";
					echo "<td><a id='login'>Create Event</a></td>";
					echo "<td>".$row[0]."</td>";
					echo "<td>".$row[1]."</td>";
					echo "<td>".$row[2]."</td>";
					echo "</tr>";
				}
				$query->close();
			}

		?>
		</table>
	</body>
	<br/>
	<body>
		<h2>Create group</h2>
		<?php
		echo "<td>Click here to create a new group</td>";
		?>
	</body>
	<br/>
	<body>
		<h2>Join Group</h2>
		<table style='text-align:center;'>
			<tr>
				<td></td>
				<td>Group ID</td>
				<td>Group Name</td>
				<td>Description</td>
			</tr>
		<?php
			$choice = "SELECT group_id, group_name, description from a_group where group_id not in (select group_id from groupuser where username='".$_SESSION['username']."')";
			if($query = $link->query($choice)){
				while($row = $query->fetch_row()){
					echo "<tr>";
					echo "<td><a id='login'>Join Group</a></td>";
					echo "<td>".$row[0]."</td>";
					echo "<td>".$row[1]."</td>";
					echo "<td>".$row[2]."</td>";
					echo "</tr>";
				}
				$query->close();
			}

		?>
		</table>
	</body>
	<br/>
	<body>
		<h2>Grant Ability to Create Events</h2>
		<table style='text-align:center;'>
			<tr>
				<td></td>
				<td>Group ID</td>
				<td>Group Name</td>
				<td>Description</td>
			</tr>
		<?php
			$choice = "SELECT group_id, group_name, description from a_group where username='".$_SESSION['username']."'";
			if($query = $link->query($choice)){
				while($row = $query->fetch_row()){
					echo "<tr>";
					echo "<td><a id='login'>Authorization Page</a></td>";
					echo "<td>".$row[0]."</td>";
					echo "<td>".$row[1]."</td>";
					echo "<td>".$row[2]."</td>";
					echo "</tr>";
				}
				$query->close();
			}

		?>
		</table>
	</body>
	<?php
		$link->close();
	?>
</html>
=======
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
		$user = $_SESSION['username'];
		echo "<h1>Upcoming Events</h1>";
		$events ='Select * from eventuser natural join an_event where username ="'.$user.'"and rsvp= 1 ';
		// echo $events;
		echo "<table>";
		echo "<tr>";
		echo "<td>Event ID</td>";
		echo "<td>Title</td>";
		echo "<td>Description</td>";
		echo "<td>Start</td>";
		echo "<td>Location</td>";
		echo "<td>Zip Code</td>";
		echo "<td>Sponsored Group</td>";
		if($query = $link->query($events)){
			while($row = $query->fetch_row()){
				echo "<tr>";
				$group_name_query = 'Select group_name from a_group where group_id in (Select group_id from an_event where group_id = ?)';
				if($get_group = $link->prepare($group_name_query)){
					$get_group->bind_param('s',$row[8]);
					$get_group->execute();
					$get_group->bind_result($event_group);
					if($get_group->fetch()){
						echo "<td>".$row[0]."</td>";
						echo "<td>".$row[4]."</td>";
						echo "<td>".$row[5]."</td>";
						echo "<td>".$row[6]."</td>";
						echo "<td>".$row[9]."</td>";
						echo "<td>".$row[10]."</td>";
						echo "<td>".$event_group."</td>";
					}
				}
				echo "</tr>";
			}
			echo "</table>";
		}
		else{
			echo "<tr>";
			echo "NO UPCOMING EVENTS FOR YOU";
			echo "</tr>";
		}
	}
?>
>>>>>>> origin/master
