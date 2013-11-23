<?php
	include('config.php');
	
	global $collection;
 	$race = $collection->findOne(array('event_name' => $_GET['event_name']));

 	foreach($race['participants'] as $participant) {
 		giveFirstClue($participant['phonenumber'], $race['checkpoints'][0]['clue']);
 	}

 	function giveFirstClue($number, $clue) {
 		$clue = urlencode($clue);
		file_get_contents("http://jel-massih.com/TestingServer/LocTask/callHandler.php?phonenumber=".$number."&clue=".$clue);
		header("Location: index.html");
 	}
?>