<?php
$fh = fopen('parse.log', 'w+');

if($fh) {
	fwrite($fh, print_r("Test", true));
	fwrite($fh, print_r($_GET['json'], true));
}

?>