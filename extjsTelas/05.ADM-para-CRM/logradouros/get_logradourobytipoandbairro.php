<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");


$idlogradourotipo = post('idlogradourotipo');
$idbairro = post('idbairro');

echo json_encode(array("myData"=>Sql::arrays('SQL_TESTE','VENDAS',"sp_logradourobytipo_bairro_get $idlogradourotipo, $idbairro")))






/*$idlogradourotipo = post('idlogradourotipo');
$idbairro = post('idbairro');

echo json_encode(array("myData"=>Sql::arrays('SATURN','VENDAS',"sp_logradouro_by_tipo_bairro_get $idlogradourotipo, $idbairro")))
*/
?>