<?php
	include('config.php');
	
 	$doc = $client->asCouchDocuments()->getDoc($_GET['event_name']);
 	$participants = $doc->participants;
 	foreach($participants as $participant) {
 		if($participant->raceIndex < 0) {
 			$participant->raceIndex = 0;
 		}
 		giveFirstClue($participant->phonenumber, $doc->checkpoints[0]->clue);
 	}

 	$doc->participants = $participants;

 	function giveFirstClue($number, $clue) {
 		$clue = urlencode($clue);
		file_get_contents("http://jel-massih.com/SquareScavenge/inc/callHandler.php?phonenumber=".$number."&clue=".$clue);
 	}

	header("Location: ../index.html");
?>