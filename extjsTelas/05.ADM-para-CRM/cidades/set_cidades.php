<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
//require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

$objCidade = new Cidade();

//descidade, dessiglacidade, idcidade

foreach($_POST as $key=>$val){
	$objCidade->{$key} = post($key);
}

$objCidade->save();
?>