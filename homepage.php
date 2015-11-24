<!DOCTYPE html>
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