<?
# @AUTOR = massaharu #
$GLOBALS['JSON']=true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
$order = post('order');
$save = split(',',$order);
$i = 0;
foreach ($save as $value){			
	Sql::query('FOCUS','SIMPAC',"sp_comitenovostreinamentos_update_posicao $i, $value");
	$i++;
}
echo "{success:true}";

acao(''.($_SESSION["nmusuario"]).' alterou a prioridade do treinamento');
?>