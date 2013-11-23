<?php
include('config.php');

if(isset($_POST['foursquare_name']) && isset($_POST['real_name']) && isset($_POST['phonenumber']) && isset($_POST['race_id'])) {


	$participant = array(
		"foursquare_name" => $_POST['foursquare_name'],
		"real_name" => $_POST['real_name'],
		"phonenumber" => $_POST['phonenumber'],
		'raceIndex' => -1
	);

	$id = new MongoId($_POST['race_id']);
	$collection->update(array("_id"=>$id),array('$push' => array("participants"=>$participant)));
	$collection->update(array("_id"=>$id),array('$set' => array($_POST['foursquare_name']=>-1)));
	header("Location: raceInfo.html?id=".$_POST['race_id']);

} else {
	die("FILL IN THE FIELDS YOU FOOL!");
}  
?>