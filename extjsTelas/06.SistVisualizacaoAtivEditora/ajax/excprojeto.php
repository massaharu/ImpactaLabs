<?
# @AUTOR = massaharu #
$GLOBALS['JSON']=true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$id = post('id');

Sql::query('FOCUS','SIMPAC',"sp_comitenovostreinamentos_update_instatus 3,$id");

echo "{success:true}";

acao(/*''.($_SESSION["nmusuario"]).*/' Confirmou a exclusao do Treinamento');
?>