<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
//require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

/*$objContatostiposcategorias = new Contato();

foreach($_POST as $key=>$val){
	$objContatostiposcategorias->{$key} = post($key);
}

$objContatostiposcategorias->contatoCategoriasSave();*/

$idpessoajuridicatipo = post('idpessoajuridicatipo');
$despessoajuridicatipo = post('despessoajuridicatipo');

Sql::query('SQL_TESTE','VENDAS',"sp_pessoajuridicatipos_update $idpessoajuridicatipo,'$despessoajuridicatipo'");


echo success;
?>