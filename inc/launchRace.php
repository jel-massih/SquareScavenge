<?php
	include('config.php');
	
 	$doc = $client->getDoc($_GET['event_name']);

 	foreach($doc->participants as $participant) {
 		giveFirstClue($participant->phonenumber, $doc->checkpoints[0]->clue);
 	}

 	function giveFirstClue($number, $clue) {
 		$clue = urlencode($clue);
		file_get_contents("http://jel-massih.com/SquareScavenge/inc/callHandler.php?phonenumber=".$number."&clue=".$clue);
		header("Location: ../index.html");
 	}
?>