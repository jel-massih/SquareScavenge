<?php
require "Services/Twilio.php";
include_once("config.php");

$fh = fopen('parse.log', 'a+');

if($fh) {
	$_POST['subject'] = strtolower($_POST['subject']);
	$guid = getGuid();

	fwrite($fh, print_r($thing, true));
	mail($_POST['from'], "Your Request!", $response);
	if(strtolower($_POST['subject']) == "sms") {
		sendSms($_POST['text']);
	} else if (strtolower($_POST['subject']) == "call") {
		makeCall('5084791878');
	}
} 	

function getGuid() {
	 mt_srand((double)microtime()*10000);
    $charid = strtoupper(md5(uniqid(rand(), true)));
    $hyphen = chr(45);// "-"
    $uuid = chr(123)// "{"
        .substr($charid, 0, 8).$hyphen
        .substr($charid, 8, 4).$hyphen
        .substr($charid,12, 4).$hyphen
        .substr($charid,16, 4).$hyphen
        .substr($charid,20,12)
        .chr(125);// "}"
    return $uuid;
}

function sendSms($reciever) {
	global $AccountSid;
	global $AuthToken;
	global $TwilioNumber;
	$client = new Services_Twilio($AccountSid, $AuthToken);
	$sms = $client->account->sms_messages->create($TwilioNumber, $reciever, "Home Skizzle", array());
}

function makeCall($reciever) {
	global $AccountSid;
	global $AuthToken;
	global $TwilioNumber;
	$client = new Services_Twilio($sid, $token);
	try {
	$call = $client->account->calls->create(
		$TwilioNumber, 
		$reciever, 
		'http://jel-massih.com/TestingServer/LocTask/calltext.php?intro='.$scanname.'&text='.$message."&seaturl=".$seaturl."&parkurl=".$parkurl
	);
	echo 'Started call: ' . $call->sid;
	} catch (Exception $e) {
	echo 'Error: ' . $e->getMessage();
	}
}
?>