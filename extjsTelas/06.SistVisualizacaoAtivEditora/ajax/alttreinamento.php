<?
# @AUTOR = massaharu #
$GLOBALS['JSON']=true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
Sql::query('FOCUS','SIMPAC',"sp_comitenovostreinamentos_update_treinamento '".utf8_decode(post('nmcurso'))."', ".post('inprioridade').", ".post('iddivisao').", ".post('inrelatorio').", ".post('id'));
echo "{success:true}";

acao(''.($_SESSION["nmusuario"]).' alterou um treinamento');
?>