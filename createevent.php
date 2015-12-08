<!-- Robert Lagomarsino
An Vu
Project 3A Create Event -->
<script>
function goBack() {
    window.history.back();
}
</script>
<?php
	include "connect.php";
	session_start();
	if(isset($_SESSION['username'])){
		// print_r($_POST);
		if (isset($_POST['e_id']) && isset($_POST['lname']) && isset($_POST['zip']) && isset($_POST['title'])){
			$id = $_POST['e_id'];
			$location = $_POST['lname'];
			$zip = $_POST['zip'];
			$title = $_POST['title'];
			$descr = $_POST['descr'];
			$start = $_POST['start'];
			$end = $_POST['end'];
			$group = $_POST['group'];
			$query = $link->prepare("INSERT INTO an_event(event_id, title, description, start_time, end_time, group_id, lname, zip) values (?,?,?,?,?,?,?,?)");
			if($query){
				$query->bind_param('issssisi',$id,$title,$descr,$start,$end,$group,$location,$zip);
				if(!$query->execute()){
					if (strpos($link->error,'PRIMARY')){
						echo "EVENT ID is not available. Please use another";
					} 
					else if(strpos($link->error,'location')){
						echo "Location is not valid. Please check the location name and zipcode";
					}
					echo '<button onclick="goBack()">Go Back</button>';
				}
				else{
					echo "Success!";
					header('refresh:3;homepage.php#events');
				}
			}
			$link->close();
		}
	}
?>