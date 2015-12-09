<!-- Robert Lagomarsino
An Vu
Project 3A RSVP to an event -->

<?php
	include "connect.php";
	session_start();
	if (isset($_SESSION['username'])){
		$username = $_SESSION['username'];
		$rating = 0;
		$rsvp = 1;
		if(isset($_POST['event'])){
			if($rsvp_query = $link->prepare('UPDATE eventuser SET rsvp = 1 where username= ? and event_id = ?')){
					
					if ($rsvp_query->num_rows == 0){ 
						$insert = sprintf('INSERT INTO eventuser (event_id, username, rsvp, rating) values (%d,"%s",%d,%d)',$_POST['event'],$username,1,0);
						if($rsvp_insert = $link->query($insert)){
							echo "SUCCESS";
							header('refresh:1;homepage.php#home');
						}
					}
					else{
						$rsvp_query->bind_param('si',$username,$_POST['event']);
						if($rsvp_query->execute()){
								echo 'Success';
								header('refresh:1;homepage.php#home');
						}
					}
			}
			
		}
	}
?>