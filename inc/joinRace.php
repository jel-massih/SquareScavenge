<?php
include('config.php');

if(isset($_POST['foursquare_name']) && isset($_POST['username']) && isset($_POST['phonenumber']) && isset($_POST['race_id'])) {


	$newParticipant = array(
		"foursquare_name" => $_POST['foursquare_name'],
		"username" => $_POST['username'],
		"phonenumber" => $_POST['phonenumber'],
		'raceIndex' => -1
	);
	$doc = $client->asCouchDocuments()->getDoc($_POST['race_id']);
	$participants = $doc->participants;

	foreach($participants as $participant) {
		if($participant->username == $_POST['username'])
		{
			header("Location: ../raceInfo.html?id=".$_POST['race_id']);
			exit;
		}
	}

	array_push($participants, $newParticipant);
	$doc->participants = $participants;
	header("Location: ../raceInfo.html?id=".$_POST['race_id']);

} else {
	die("FILL IN THE FIELDS YOU FOOL!");
}  
?>