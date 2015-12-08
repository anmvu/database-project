<!-- Robert Lagomarsino
An Vu
Project 3A Authorize User -->

<?php

	require "connect.php";
	if (isset($_POST['user'])){
		// $check = sprintf('UPDATE groupuser SET authorized=1 WHERE username="%s" and group_id="%d"',$_POST['user'],$_POST['group'])
		if ($check = $link->prepare('UPDATE groupuser SET authorized=1 WHERE username=? and group_id=?')){
			$check->bind_param('si',$_POST['user'],$_POST['group']);
			$check->execute();
			if ($check->num_rows != 0){
				echo 'Authorized '.$_POST['user'];
				echo "<br>";
				echo "Refreshing in 5 seconds...";
				echo "Or click <a href='homepage.php#groups'>here</a>";
				header("refresh: 5; homepage.php#groups");
			}
			else{
				echo $_POST['user']." is not in group ".$_POST['group'];
				echo "<br>";
				echo "Returning to previous page";
				echo "<br>";
				echo "Refreshing in 5 seconds...";
				echo "Or click <a href='homepage.php#groups'>here</a>";
				header("refresh: 5; homepage.php#groups");
			}
			$check->close();
		}
	}

?>