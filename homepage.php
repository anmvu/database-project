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
			<a href='#events'>My Events</a>
			<a href='#groups' >Groups</a>
			<a href='updateuser.php'> My Account</a>
			<a href='logout.php'>Logout</a>
		</p>
		<div class='items'>
			<div id='home' class=
			'item'>
				<h2>My Upcoming Events</h2>
				<table style='text-align:center;'>
					<tr>
						<td>Event ID</td>
						<td>Title</td>
						<td>Description</td>
						<td>Start Time</td>
						<td>End Time</td>
						<td>Location</td>
						<td>Zip Code</td>
						<td>Sponsored By</td>
					</tr>
				<?php
					include "connect.php";
					session_start();
					$range = [];
					for ($x=0; $x<4; $x++){
						$day = time()+($x*24*60*60);
						$nextday = date('Y-m-d',$day);
						array_push($range,$nextday);
					}
					$choice = "SELECT * from an_event where event_id in (select event_id from eventuser where username='".$_SESSION['username']."') order by start_time asc";
					if($query = $link->query($choice)){
						while($row = $query->fetch_row()){
							$event_start = substr($row[3],0,10);
							if (in_array($event_start,$range)){
								echo "<tr>";
								echo "<td>".$row[0]."</td>";
								echo "<td>".$row[1]."</td>";
								echo "<td>".$row[2]."</td>";
								echo "<td>".$row[3]."</td>";
								echo "<td>".$row[4]."</td>";
								echo "<td>".$row[6]."</td>";
								echo "<td>".$row[7]."</td>";
								if($group_query = $link->prepare('Select group_name from a_group where group_id= ?')){
									$group_query->bind_param('s',$row[5]);
									$group_query->execute();
									$group_query->bind_result($group);
									if($group_query->fetch()){
										echo "<td>".$group."</td>";
									}
									$group_query->close();
								}
								echo "</tr>";
							}
						}
						$query->close();
					}

				?>
				</table>
			</div>
			<div id='events' class='item'>
				<h2> Events </h2>
				<form  id = 'select_interest' action="homepage.php#events" method ='post' name ='interest_form'>
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
						<td>Group</td>
						<td>Location</td>
						<td>Zip Code</td>
					</tr>
					<?php
						$choice = 'SELECT * from an_event order by start_time asc';
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
								if($group_query = $link->prepare('Select group_name from a_group where group_id= ?')){
									$group_query->bind_param('s',$row[5]);
									$group_query->execute();
									$group_query->bind_result($group);
									if($group_query->fetch()){
										echo "<td>".$group."</td>";
									}
									$group_query->close();
								}
								echo "<td>".$row[6]."</td>";
								echo "<td>".$row[7]."</td>";
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
								if ($delete = $link->query('Select username from groupuser where authorized = 1 and group_id in (Select group_id from an_event where event_id ='.$row[0].')')){
									if ($delrow = $delete->fetch_row()){
										if ($delrow[0] == $_SESSION['username']){
											echo "<td><form action='modify.php' method='post'><input type='hidden' value='".$row[0]."' name='event'><input type='submit' name='modify' value='Modify'><input type='submit' name='delete' value='Delete'></form></td>";
										}
									}
								}
								echo "</tr>";
							}
							$query->close();
						}
					?>
				</table>
				<h2>Create an Event</h2>
				<?php
					$choice = "SELECT group_name,group_id from a_group where group_id in (select group_id from groupuser where authorized = '1' and username='".$_SESSION['username']."')";
					if($query = $link->query($choice)){
						while($row = $query->fetch_row()){
							echo "<li><h3>".$row[0]."</h3>";
							echo "<div class='event_form'>";
							echo "<form action='createevent.php' method ='post' id ='create_event'>";
							echo "<div style='display:inline-block; width:150px;'><label style='display:block;float:left;'>Event ID</label></div>";
							echo "<input type='text' name='e_id'>";
							echo "<br>";
							echo "<div style='display:inline-block; width:150px;'><label style='display:block;float:left;'>Event Title</label></div>";
							echo "<input type='text' name='title'>";
							echo "<br>";
							echo "<div style='display:inline-block; width:150px;float:left;'><label>Event Description</label></div>";
							echo "<textarea rows='4' cols='50' name='descr' form='create_event' style='margin-top:3px;'></textarea>";
							echo "<br>";
							echo "<div style='display:inline-block; width:150px;'><label style='display:block;float:left;'>Start</label></div>";
							echo "<input type='text' name='start' placeholder='2015-12-31 09:30 AM'>";
							echo "<br>";
							echo "<div style='display:inline-block; width:150px;'><label style='display:block;float:left;'>End</label></div>";
							echo "<input type='text' name='end' placeholder='2015-12-31 09:30 AM'>";
							echo "<br>";
							echo "<div style='display:inline-block; width:150px;'><label style='display:block;float:left;'>Location Name</label></div>";
							echo "<input type='text' name='lname'>";
							echo "<br>";
							echo "<div style='display:inline-block; width:150px;'><label style='display:block;float:left;'>Location Zip Code</label></div>";
							echo "<input type='text' name='zip'>";
							echo "<br>";
							echo "<input type='hidden' value='".$row[1]."' name='group'>";
							echo "<input type='submit' value='Create an event for ".$row[0]."'>";
							echo "</form>";
							echo "</div>";
							echo "</li>";
						}
						$query->close();
					}

				?>
				</table>
			</div>
			<div id='groups'class='item'>
				<p>
					<a id='button' href='homepage.php#groups' onclick='toggle_visibility("group-form")'>Create group</a>
					<div id='group-form'style='display:none'>
						<form action='creategroup.php' method ='post' id='create-group'>
							<div style='display:inline-block; width:150px;'><label>Group ID</label></div>
							<input type='text' name='group_id'>
							<br>
							<div style='display:inline-block; width:150px;margin-top:3px;'><label>Group Name</label></div>
							<input type='text' name='group_name'>
							<br>
							<div style='display:inline-block; width:150px;float:left; margin-top:3px;'><label>Description</label></div>
							<textarea rows='4' cols='21' type='text' name='description' form='create-group' style='margin-top:3px; margin-left:4px;'></textarea>
							<br>
							<input type='submit' value='Create Group'>
						</form>
					</div>
				</p>
				
				<h2> The Groups You're In </h2>
				<?php
					$groups_query = "SELECT distinct group_name from a_group join groupuser on groupuser.group_id = a_group.group_id where groupuser.username = '".$_SESSION['username']."'";
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
				
				<?php
					$choice = "SELECT group_id, group_name, description from a_group where group_id not in (select group_id from groupuser where username='".$_SESSION['username']."')";
					if($query = $link->query($choice)){
						if ($query->num_rows == 0){
							echo "There are no more groups to join";
						}
						else{
							echo "<table style='text-align:center;'>
									<tr>
										<td>Group ID</td>
										<td>Group Name</td>
										<td>Description</td>
										<td></td>
									</tr>";
							while($row = $query->fetch_row()){
								echo "<tr>";
								echo "<td>".$row[0]."</td>";
								echo "<td>".$row[1]."</td>";
								echo "<td>".$row[2]."</td>";
								echo "<td>";
								echo "<form action='joingroup.php' method='post' name='join-group'>";
								echo "<input type='hidden' name='e_id' value='".$row[0]."'>";
								echo "<input type='submit' value='Join Group'>";
								echo "</form>";
								echo "</td>";
								echo "</tr>";
							}
							echo "</table>";
							$query->close();
						}
					}
					
				?>
				
				<h2>Grant Ability to Create Events</h2>
				<div>
					<table style='text-align:center; display:inline-block; float:left;'>
						<tr>
							<td>Group ID</td>
							<td>Group Name</td>
							<td>Description</td>
						</tr>
					<?php
						$choice = "SELECT group_id, group_name, description from a_group where username='".$_SESSION['username']."'";
						if($query = $link->query($choice)){
							while($row = $query->fetch_row()){
								echo "<tr>";
								echo "<td>".$row[0]."</td>";
								echo "<td>".$row[1]."</td>";
								echo "<td>".$row[2]."</td>";
								echo "</tr>";
							}
							$query->close();
						}

					?>
					</table>
					<div class='authorize'>
						<p style='margin:4px;'> Authorize User </p>
					<?php
						$choice = "SELECT group_id, group_name, description from a_group where username='".$_SESSION['username']."'";
						if($query = $link->query($choice)){
							while($row = $query->fetch_row()){
								?>
								<form action="authorizeuser.php" method="post" name="authorize-user">
								<input type="text" name="user" style="display:inline-block">
								<input name="group" type="hidden" value="<?php echo $row[0];?>">
								<input type="submit" value="Authorize" style="display:inline-block">
								</form>
								<?php
							}
							$query->close();
						}
					?>
					</div>
				</div>
			</div>
		</div>
		<?php
			$link->close();
		?>
	</body>
</html>