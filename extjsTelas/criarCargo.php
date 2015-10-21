<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");


pre($GLOBALS);exit;
//$data = Cargo::createStore();
$data = Cargo::createStore();
if($data){
	echo success;
}

?>