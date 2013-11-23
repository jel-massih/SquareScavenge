<?php
include('config.php');

if(isset($_POST['event_name']) && isset($_POST['location']) && isset($_POST['prize'])) {

	$checkpoints = json_decode($_POST['checkpoints']);
	$goodcp = array();
	foreach($checkpoints as $checkpoint) {
		$checkpoint->clue = urldecode($checkpoint->clue);
		array_push($goodcp, $checkpoint);
	}

	$doc = array(
		"event_name" => $_POST['event_name'],
		"location" => $_POST['location'],
		"prize" => $_POST['prize'],
		"participants" => array(),
		"checkpoints" => $goodcp,
		"currentRanking" => 1,
		"winner" => ""
	);

	global $collection;
	$collection->insert($doc);
	header("Location: launchGame.html?event_name=".$_POST['event_name']);

} else {
	die("FILL IN THE FIELDS YOU FOOL!");
}  
?>