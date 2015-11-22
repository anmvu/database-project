<!DOCTYPE html>
<html>
<title>Home</title>
<link href="css/index.css" rel="stylesheet">
<body>
	Interests
	<form  id = 'form' action='<?php echo $_SERVER['PHP_SELF'];?>' method ='post' name ='interest_form'>
		<select name='interests'>
			<option value='all'>All</option>
			<?php
				include "connect.php";
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
	<a id='login' href='login.php'>Login</a>
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
				echo "</tr>";
			}
			$query->close();
			$link->close();
		}

	?>
	</table>
</body>

</html>