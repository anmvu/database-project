<!DOCTYPE html>
<!-- Robert Lagomarsino
An Vu
Project 3A Interests Page -->
<html>
	<title>Homepage</title>
	<link href='css/homepage.css' rel='stylesheet'>
	<script type='text/javascript'>
		function toggle_visibility(id){
			var e = document.getElementById(id);
			console.log(e);
			if (e.style.display =='block'){ e.style.display = 'none';}
			else
				{e.style.display = 'block';}
		}
	</script>	
	<body>
		<p id ='nav'>
			<a href='#home'>Home</a>
			<a href='index.php' > All Events </a>
			<a href='#events' >My Events</a>
			<a href='#groups' >Groups</a>
			<a href='logout.php'>Logout</a>
		</p>
		<div class='items'>
			<div id='home'>
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
					include "connect.php";
					session_start();
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
			</div>
			<div id='events'>
				<h2> Events </h2>
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
					</tr>
				<?php
					$choice = 'SELECT * from an_event';
					if(isset($_POST['interests'])){
						$interest_choice =  $_POST['interests'];
						if ($interest_choice != 'all'){
							$choice = "SELECT * from an_event where group_id in (select group_id from groupinterest where interest_name='".$interest_choice."')";
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
								echo "<td><a id='login'>RSVP</a></td>";
							}
							echo "</tr>";
						}
						$query->close();
					}
				?>
				</table>
				<h2>Create an Event</h2>
				<?php
					$choice = "SELECT group_name from a_group where group_id in (select group_id from groupuser where authorized = '1' and username='".$_SESSION['username']."')";
					if($query = $link->query($choice)){
						while($row = $query->fetch_row()){
							echo "<li><h3>".$row[0]."</h3>";
							echo "<ul>";
							echo "<form>";
							echo "</ul>";
							echo "</li>";
						}
						$query->close();
					}

				?>
				</table>
			</div>
			<div id='groups'>
				<p>
					<a id='button' >Create group</a>
				</p>
				
				<h2> The Groups You're In </h2>
				<?php
					$groups_query = "SELECT group_name from a_group natural join groupuser where username = '".$_SESSION['username']."'";
					if($groups = $link->query($groups_query)){
						echo "<ul>";
						while($groups_row = $groups->fetch_row()){
							echo "<li><h3>".$groups_row[0]."</h3></li>";
						}
						echo "</ul>";
						$groups->close();
					}
				?>
				<h2>Join Group</h2>
				<table style='text-align:center;'>
					<tr>
						<td>Group ID</td>
						<td>Group Name</td>
						<td>Description</td>
						<td></td>
					</tr>
				<?php
					$choice = "SELECT group_id, group_name, description from a_group where group_id not in (select group_id from groupuser where username='".$_SESSION['username']."')";
					if($query = $link->query($choice)){
						while($row = $query->fetch_row()){
							echo "<tr>";
							echo "<td>".$row[0]."</td>";
							echo "<td>".$row[1]."</td>";
							echo "<td>".$row[2]."</td>";
							echo "<td><a id='button'>Join Group</a></td>";
							echo "</tr>";
						}
						$query->close();
					}

				?>
				</table>
				<h2>Grant Ability to Create Events</h2>
				<table style='text-align:center;'>
					<tr>
						<td>Group ID</td>
						<td>Group Name</td>
						<td>Description</td>
						<td></td>
					</tr>
				<?php
					$choice = "SELECT group_id, group_name, description from a_group where username='".$_SESSION['username']."'";
					if($query = $link->query($choice)){
						while($row = $query->fetch_row()){
							echo "<tr>";
							echo "<td>".$row[0]."</td>";
							echo "<td>".$row[1]."</td>";
							echo "<td>".$row[2]."</td>";
							echo "<td>";
							if (isset($_POST['authorize'])){
								$user = $_POST['authorize'];
								$check = "Select * from groupuser where username = '".$user."' and group_id =".$row[0]."'";
								if($check_result = $link->query($check)){
									echo 'yes';
									$result_row = $check_result->fetch_row();
									if ($result->num_rows == 0){
										echo "User,".$user." , is not in this group";
									}
									else if ($result_row[2]==1){
										echo "User,".$user." , is has already been authorized";
									}
									else{
										$update = "Update groupuser SET authorized = 1 where username = '".$user."' and group_id =".$row[0]."'";
										echo "Success!";
									}
								}
							}
							echo "<a href='javascript:;' id='button' onclick='toggle_visibility(\"addUser".$row[0]."\")'>Authorize another user</a>";
							$form = "<form id ='addUser".$row[0]."' action='homepage.php#groups' method='POST' style='display:none;'>";
							echo $form;
							echo "<input class='input' type='text' name='authorize'>";
							echo "<input id= 'submit' type='submit' value='Submit'>";
							echo "</form>";
							echo "</td>";
							echo "</tr>";
						}
						$query->close();
					}

				?>
				</table>
		</div>
		<?php
			$link->close();
		?>
	</body>
</html>