<!DOCTYPE html>
<!-- Robert Lagomarsino
An Vu
Project 3A Interests Page -->
<html>
	<title>Delete Event</title>
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
				if($query = $link->prepare("Select * from an_event where event_id = ?")){
					$query->bind_param('i',$id);
					$query->execute();
					$row = $query->fetch_row();
					echo "<div>"
					echo "</div>"
					echo "Success";
					header("refresh:2;modify.php");
				}
			}
		}
		$link->close();
	?>
</html>