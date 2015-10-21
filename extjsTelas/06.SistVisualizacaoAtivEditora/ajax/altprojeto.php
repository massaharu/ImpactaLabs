<?
# @AUTOR = massaharu #
$GLOBALS['JSON']=true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
Sql::query('FOCUS','SIMPAC',"sp_comitenovostreinamentos_update_instatus 1, ".post('id'));
echo "{success:true}";

acao(''.($_SESSION["nmusuario"]).' alterou o Status do treinamento');
?>