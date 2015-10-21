<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
//require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

$objCargos = new Cargo();

foreach($_POST as $key=>$val){
	$objCargos->{$key} = post($key);
}

$objCargos->save();
?>