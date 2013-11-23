<?php
include('../config.php');
$view_fn="function(doc) { emit(doc.location,null); }";
$design_doc->_id = '_design/all';
$design_doc->language = 'javascript';
$design_doc->views = array ( 'by_date'=> array ('map' => $view_fn ) );
$client->storeDoc($design_doc);
?>