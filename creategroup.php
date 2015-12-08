<!-- Robert Lagomarsino
An Vu
Project 3A Create Group -->
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

		if (isset($_POST['group_id']) && isset($_POST['group_name']) && isset($_POST['description'])){
			echo "test";
			$id = $_POST['group_id'];
			$name = $_POST['group_name'];
			$descr = $_POST['description'];
			$user = $_SESSION['username'];
			$query = $link->prepare("INSERT INTO a_group(group_id,group_name,description,username) values (?,?,?,?)");
			if($query){
				$query->bind_param('isss',$id,$name,$descr,$user);
				if(!$query->execute()){
					if (strpos($link->error,'PRIMARY')){
						echo "GROUP ID is not available. Please use another";
					} 
					echo '<button onclick="goBack()">Go Back</button>';
				}
				else{
					echo "Success!";
					header('refresh:3;homepage.php#groups');
				}
			}
			$link->close();
		}
	}
?>