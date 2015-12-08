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
					echo "<div>";
					echo "<form  id = 'select_interest' action='modify.php' method ='post' name ='modify_form'>";
					$event_id = $row[0];
					echo "<p class='label'>Title</p> <input class='input'  type='text' name='title' value=".$row[1]."> <br/>";
					echo "<p class='label'>Description</p> <input class='input'  type='text' name='desc' value=".$row[2]."> <br/>";
					echo "<p class='label'>Start Time</p> <input class='input'  type='text' name='stime' value=".$row[3]."> <br/>";
					echo "<p class='label'>End Time</p> <input class='input'  type='text' name='etime' value=".$row[4]."> <br/>";
					echo "<p class='label'>Location</p> <input class='input'  type='text' name='loc' value=".$row[6]."> <br/>";
					echo "<p class='label'>Zip Code</p> <input class='input'  type='text' name='zip' value=".$row[7]."> <br/>";
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