<!DOCTYPE html>
<!-- Robert Lagomarsino
An Vu
Project 3A Interests Page -->
<html>
	<title>Delete Event</title>
	<script>
function goBack() {
    window.history.back();
}
</script>
<link href='css/homepage.css' rel='stylesheet'>
<p id ='nav'>
	<a href='#home'>Home</a>
	<a href='index.php' > All Events </a>
	<a href='#events'>My Events</a>
	<a href='#groups' >Groups</a>
	<a href='updateuser.php'> My Account</a>
	<a href='logout.php'>Logout</a>
</p>

	<?php
		include "connect.php";
		session_start();

		if (isset($_SESSION['username'])){
			if(isset($_POST['delete'])){
				$id = $_POST['event'];
				$del_query = "delete from an_event where event_id = ?";
				if($query = $link->prepare("delete from an_event where event_id = ?")){
					$query->bind_param('i',$id);
					$query->execute();
					echo "Success";
					$query->close();
					header("refresh:2;homepage.php#events");
				}
			}
			else if (isset($_POST['modify'])){
				$id = $_POST['event'];
				if($query = $link->query(sprintf("Select * from an_event where event_id = '%d'",$id))){
					$row = $query->fetch_row();
					$row[6] = str_replace(' ','',$row[6]);
					echo "<h2> Modify Event</h2>";
					echo "<div>";
					echo "<form  id = 'select_interest' action='modify.php' method ='post' name ='modify_form'>";
					$event_id = $row[0];
					echo "<p class='modlabel'style='display:inline-block;width:100px;'>Title</p> <input   type='text' name='title' value=".$row[1]."> <br/>";
					echo "<p class='modlabel' style='display:inline-block;width:100px;'>Description</p> <input type='text' name='desc' value='".$row[2]."'> <br/>";
					echo "<p class='modlabel'style='display:inline-block;width:100px;'>Start Time</p> <input   type='text' name='stime' value=".$row[3]."> <br/>";
					echo "<p class='modlabel' style='display:inline-block;width:100px;'>End Time</p> <input type='text' name='etime' value='".$row[4]."''> <br/>";
					echo "<p class='modlabel' style='display:inline-block;width:100px;'>Location</p> <input type='text' name='loc' value='".$row[6]."'> <br/>";
					echo "<p class='modlabel' style='display:inline-block;width:100px;'>Zip Code</p> <input   type='text' name='zip' value=".$row[7]."> <br/>";
					echo "<input type='hidden' name='event' value='".$id."'>";
					echo "<input name='change' type='submit' value='Submit'>";
					echo "</form>";
					echo "</div>";
					$query->close();
				}
			}
			else if (isset($_POST['change'])) {
				$title = $_POST['title'];
				$desc = $_POST['desc'];
				$stime = $_POST['stime'];
				$etime = $_POST['etime'];
				$loc = $_POST['loc'];
				$zip = $_POST['zip'];
				$event_id = $_POST['event'];
				if ($query = $link->prepare('UPDATE an_event SET title=?, description=?, start_time=?, end_time=?, lname=?, zip=? WHERE event_id=?')){
					$query->bind_param('sssssii', $title, $desc, $stime, $etime, $loc, $zip, $event_id);
    				$query->execute();
    				$query->close();
    				if (strpos($link->error,'location')){
						echo "Location is invalid. Please check Location and Zip Code";
						echo '<button onclick="goBack()">Go Back</button>';
					} 
    				else{
    					echo "Success";
						header("refresh:2;homepage.php#events");}
					}
    			} 
			}
		$link->close();
	?>
</html>