<?
# @AUTOR = massaharu #
$GLOBALS['JSON']=true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

Sql::query('FOCUS','SIMPAC',"sp_comitenovostreinamentosexcluirdivisao_remove ".post('id'));

echo "{success:true}";

acao(''.($_SESSION["nmusuario"]).' excluiu uma Divisao');

?>