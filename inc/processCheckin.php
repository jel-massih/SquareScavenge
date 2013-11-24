<?php
	include('config.php');
	require "Services/Twilio.php";

	$twilioClient = new Services_Twilio($AccountSid, $AuthToken);
	$_GET['venue_id'] = $_GET['venue_id']."/";

  	$result = $client->getView('all', 'by_participant');

 	foreach($result->rows as $row) {
 		foreach($row->key as $participant) {
 			if($participant->foursquare_name == $_GET['lastname']) {
 				$index = 0;
 				$bBroke = false;
 				$bWaitingForClue = false;
 				foreach($row->value as $checkpoint) {
 					if($bWaitingForClue) {
 						checkpointSuccess($index, $participant, $checkpoint->clue, $row->id);
 						die;
 					}
	 				if($index > $participant->raceIndex) {
	 					wrongCheckpoint($participant->phonenumber);
	 					$bBroke = true;
 						break;
	 				}
	 				if($checkpoint->id == $_GET['venue_id'] && $index == $participant->raceIndex) {
	 					$bWaitingForClue = true;
		 			}

		 			$index += 1;
 				}

 				if($bWaitingForClue) {
 					gameSuccess($participant, $row->id);
					$collection->update(array('id' => $id), array('currentRanking' => $value['currentRanking'] += 1));
 					die();
 				} else if(!$bBroke) {
 					wrongCheckpoint($participant['phonenumber']);
 					die();
 				}
 			}
 		}
 	}	

 	function wrongCheckpoint($phoneNumber) {
 		global $twilioClient;
 		global $TwilioNumber;
		$sms = $twilioClient->account->sms_messages->create($TwilioNumber, $phoneNumber, "Sorry! Thats the wrong Checkpoint!");
 	}

 	function checkpointSuccess($index, $participant, $clue, $docId) {
 		global $client;

 		$doc = $client->asCouchDocuments()->getDoc($docId);
 		$participants = $doc->participants;
 		foreach($participants as $docParticipant)
 		{
 			if($docParticipant->username == $participant->username) {
 				$docParticipant->raceIndex++;
		 		$doc->participants = $participants;
 				break;
 			}
 		}
		$clue = urlencode($clue);
		file_get_contents("http://jel-massih.com/SquareScavenge/inc/callHandler.php?phonenumber=".$participant->phonenumber."&clue=".$clue);
 	}

 	function gameSuccess($participant, $docId) {
 		global $twilioClient;
 		global $client;
 		$doc = $client->asCouchDocuments()->getDoc($docId);

 		if($doc->currentRanking == 1) {
 			$doc->winner = $participant->username;
		}

		$sms = $twilioClient->account->sms_messages->create($TwilioNumber, $participant->phonenumber,"Congratulations you have completed the race! You are rank: ".$doc->currentRanking);
		$doc->currentRanking+=1;
 	}

?>