<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
//require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

$descontatotipo = post('descontatotipo');

Sql::query('SQL_TESTE','VENDAS',"sp_contatotipos_save $descontatotipo");

echo success;


/*$objPessoajuridicatipos = new Pessoa();

foreach($_POST as $key=>$val){
	$objPessoajuridicatipos->{$key} = post($key);
}

$objPessoajuridicatipos->save();*/
?>