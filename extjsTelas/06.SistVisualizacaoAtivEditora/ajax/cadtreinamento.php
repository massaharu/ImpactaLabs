<?
# @AUTOR = massaharu #
$GLOBALS['JSON']=true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$destreinamento = utf8_decode(post('destreinamento'));
$inprioridade = utf8_decode(post('inprioridade'));
$indivisao = utf8_decode(post('indivisao'));
$inrelatorio = utf8_decode(post('inrelatorio'));

$a = Sql::select('FOCUS','SIMPAC',"sp_comitenovostreinamentos_get");

$inposicao = $a['inposicao'];

if($inposicao == ''){
	$inposicao = 0;
} else {
	$inposicao++;
}

Sql::query('FOCUS','SIMPAC',"sp_comitenovostreinamentos_add '$destreinamento', $inprioridade,'$indivisao','".$_SESSION["nmusuario"]."',$inposicao, $inrelatorio");

echo "{success:true}";
?>