<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
//require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

$objLogradouros = new Logradouro();

//deslogradouro, idlogradouros

foreach($_POST as $key=>$val){
	$objLogradouros->{$key} = post($key);
}

$objLogradouros->save();
?>