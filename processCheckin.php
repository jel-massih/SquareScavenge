<?php
	include('config.php');
	require "Services/Twilio.php";


	global $AccountSid;
	global $AuthToken;
	global $TwilioNumber;
	$client = new Services_Twilio($AccountSid, $AuthToken);

 	
	$_GET['venue_id'] = $_GET['venue_id']."/";

	global $collection;
  	$cursor = $collection->find();
 	$array = iterator_to_array($cursor);

 	foreach($array as $id => $value) {

 		foreach($value['participants'] as $participant) {
 			if($participant['foursquare_name'] == $_GET['lastname']) {
 				$index = 0;
 				$bWaitingForClue = false;
 				foreach($value['checkpoints'] as $location) {
 					if($bWaitingForClue) {
 						checkpointSuccess($index-1, $participant, $location['clue']);
 						die;
 					}
	 				if($index > $value[$participant['foursquare_name']]+1) {
	 					wrongCheckpoint($participant['phonenumber']);
 						die();
	 				}

	 				if($location['id'] == $_GET['venue_id']) {
		 				$raceIndex = $value[$participant['foursquare_name']];
		 				if($index == $raceIndex+1 || $index == 0) {
		 					$bWaitingForClue = true;
		 				}
		 			}

		 			$index += 1;
 				}

 				if($bWaitingForClue) {
 					gameSuccess($participant, $value['currentRanking']);
					$collection->update(array('id' => $id), array('currentRanking' => $value['currentRanking'] += 1));
 					die();
 				} else {
 					wrongCheckpoint($participant['phonenumber']);
 					die();
 				}
 			}
 		}
 	}	

 	function wrongCheckpoint($phoneNumber) {
 		global $client;
		$sms = $client->account->sms_messages->create($TwilioNumber, $phoneNumber, "Sorry! Thats the wrong Checkpoint!", array());
 	}

 	function checkpointSuccess($index, $participant, $clue) {
 		global $collection;
		$collection->update(array('participants.foursquare_name' => $participant['foursquare_name']), array('$set' => array( $participant['foursquare_name'] => $index)));
		$clue = urlencode($clue);
		file_get_contents("http://jel-massih.com/TestingServer/LocTask/callHandler.php?phonenumber=".$participant['phonenumber']."&clue=".$clue);
 	}

 	function gameSuccess($participant, $rank) {
 		global $collection;
 		if($rank == 1) {
			$collection->update(array('participants.foursquare_name' => $participant['foursquare_name']), array('$set' => array( 'winner' => $participant['real_name'])));
		}

 		global $client;
		$sms = $client->account->sms_messages->create($TwilioNumber, $participant['phonenumber'],"Congratulations you have completed the race! You are rank: ".$rank, array());
 	}

?>