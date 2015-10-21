<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
//require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

$desdocumentotipo = post('desdocumentotipo');

Sql::query('SQL_TESTE','VENDAS',"sp_documentotipos_save $desdocumentotipo");

echo success;


/*$objPessoajuridicatipos = new Pessoa();

foreach($_POST as $key=>$val){
	$objPessoajuridicatipos->{$key} = post($key);
}

$objPessoajuridicatipos->save();*/
?>