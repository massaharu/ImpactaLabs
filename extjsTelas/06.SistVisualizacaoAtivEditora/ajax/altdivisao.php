<?
# @AUTOR = massaharu #
$GLOBALS['JSON']=true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
Sql::query('FOCUS','SIMPAC',"sp_comitesnovostreinamentos_update_divisao '".utf8_decode(post('caddivisao'))."', ".post('id'));
echo "{success:true}";

acao(''.($_SESSION["nmusuario"]).' alterou uma Divisao de treinamento');
?>