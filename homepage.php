<!DOCTYPE html>
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