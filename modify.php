<!DOCTYPE html>
<!-- Robert Lagomarsino
An Vu
Project 3A Interests Page -->
<html>
	<title>Delete Event</title>
	<?php
		include "connect.php";
		// session_start();
		if(isset($_POST['delete'])){
			echo "yay";
			$id = $_POST['event'];
			echo $id;
			$del_query = "delete from an_event where event_id = ?";
			if($query = $link->prepare("delete from an_event where event_id = ?")){
				$query->bind_param('i',$id);
				$query->execute();
				echo "Success";
				header("refresh:2;homepage.php#groups");
			}
		}
	?>
</html>