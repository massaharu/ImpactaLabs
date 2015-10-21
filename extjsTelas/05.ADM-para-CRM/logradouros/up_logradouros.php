<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
//require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");



$idlogradouro = post('idlogradouro');
$idlogradourotipo = post('idlogradourotipo');
$idbairro = post('idbairro');
$deslogradouro = post('deslogradouro');

Sql::query('SQL_TESTE','VENDAS',"sp_logradouros_update $idlogradouro, $idlogradourotipo, $idbairro, '$deslogradouro'");


echo success;
?>