<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
//require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

$deslogradouro = post('deslogradouro');
$idbairro = post('idbairro');
$idlogradourotipo = post('idlogradourotipo');

Sql::query('SQL_TESTE','VENDAS',"sp_logradouros_save $idlogradourotipo, $idbairro, '$deslogradouro'");



echo success;

?>