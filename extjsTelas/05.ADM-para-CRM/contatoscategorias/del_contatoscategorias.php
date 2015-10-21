<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
/*require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");*/
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idcontatotipocategoria = post('idcontatotipocategoria');

Sql::query('SQL_TESTE','VENDAS',"sp_contatotipocategorias_instatus $idcontatotipocategoria");

echo success;

/*$objContatocategorias = new Contato(post('idcontatotipocategoria'));

echo json_encode(array('success'=>true,'myData'=>$objContatocategorias->destroyContatocategorias()));*/

?>





























