<?php
	$checkin = json_decode($_POST['checkin']);
	file_get_contents("http://jel-massih.com/SquareScavenge/inc/processCheckin.php?venue_id=".$checkin->venue->id."&lastname=".$checkin->user->lastName);
?>