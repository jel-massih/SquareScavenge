<?php
$fh = fopen('parse.log', 'a+');

if($fh) {
	fwrite($fh, print_r($_REQUEST["checkin"], true));
	fwrite($fh, print_r("Test", true));
}

file_put_contents("test.txt", "FACNY HATS");

echo("turtles");

?>