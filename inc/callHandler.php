<?php
	require "Services/Twilio.php";
	include_once "config.php";

	$client = new Services_Twilio($AccountSid, $AuthToken);
	$_GET['clue'] = urlencode($_GET['clue']);
	try {
		$call = $client->account->calls->create($TwilioNumber, $_GET['phonenumber'], 'http://jel-massih.com/SquareScavenge/inc/calltext.php?clue='.$_GET['clue']);
	} catch (Exception $e) {
	}
	
	$_GET['clue'] = urldecode($_GET['clue']);

	$sms = $client->account->sms_messages->create($TwilioNumber, $_GET['phonenumber'],"Next Clue: ".$_GET['clue'], array());
?>