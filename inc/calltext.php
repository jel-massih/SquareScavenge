<?php

$xml = new XMLWriter();

$xml->openURI("php://output");
$xml->startDocument();
$xml->setIndent(true);

$xml->startElement('Response');

$xml->startElement('Say');
$xml->writeAttribute('voice', 'man');
$xml->writeRaw("Your Next Clue is:");
$xml->endElement();

$xml->startElement('Say');
$xml->writeAttribute('voice', 'man');
$xml->writeRaw($_GET['clue']);
$xml->endElement();

$xml->endElement();

?>