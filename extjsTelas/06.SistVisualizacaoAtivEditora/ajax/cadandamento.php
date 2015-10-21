<?
# @AUTOR = massaharu #
$GLOBALS['JSON']=true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$desstatus = utf8_decode(post('desstatus'));
$instatus = post('instatus');
$id = post('id');

if (post('dtprevisao') == ''){
	Sql::query('FOCUS','SIMPAC',"sp_comitenovostreinamentoscadastramento_save $id, '$desstatus', $instatus, null");
} else {
	$dtprevisao = formatdatetime(post('dtprevisao'),8);
    Sql::query('FOCUS','SIMPAC',"sp_comitenovostreinamentoscadastramento_save $id, '$desstatus', $instatus, '$dtprevisao'");
}

echo "{success:true}";

acao(''.($_SESSION["nmusuario"]).' alterou o status de cadastro do curso');
?>