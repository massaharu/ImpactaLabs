<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
//require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

$objEstado = new Estado();

//desestado, dessiglaestado, idpais

foreach($_POST as $key=>$val){
	$objEstado->{$key} = post($key);
}

$objEstado->save();





?>