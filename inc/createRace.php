<?php
include('config.php');

if(isset($_POST['event_name']) && isset($_POST['location']) && isset($_POST['prize'])) {

	$checkpoints = json_decode(stripslashes($_POST['checkpoints']));
	$goodcp = array();
	foreach($checkpoints as $checkpoint) {
		$checkpoint->clue = urldecode($checkpoint->clue);
		array_push($goodcp, $checkpoint);
	}

	$doc = new stdClass();
	$doc->_id = $_POST['event_name'];
	$doc->location = $_POST['location'];
	$doc->prize = $_POST['prize'];
	$doc->participants = array();
	$doc->checkpoints = $goodcp;
	$doc->currentRanking = 1;
	$doc->winner = "";

	try {
		$response = $client->storeDoc($doc);
		header("Location: ../launchGame.html?event_name=".$_POST['event_name']);
	} catch(Exception $e) {
		echo("Error! ".$e->getMessage());
	}


} else {
	die("FILL IN THE FIELDS YOU FOOL!");
}  
?>