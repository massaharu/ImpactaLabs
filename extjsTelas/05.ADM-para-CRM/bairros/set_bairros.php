<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
//require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

$objBairro = new Bairro();

//desbairro, idbairro

foreach($_POST as $key=>$val){
	$objBairro->{$key} = post($key);
}

$objBairro->save();
?>