<?
# @AUTOR = massaharu #
$GLOBALS['JSON']=true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$desdivisao = utf8_decode(post('caddivisao'));

$a1 = Sql::arrays('FOCUS','Simpac',"sp_novostreinamentos_get '$desdivisao'");

if(!count($a1)){
	Sql::query('FOCUS','SIMPAC',"sp_novostreinamentos_add '$desdivisao'");
	echo "{success:true}";	
} else {
	echo "{failure:true,msg:'Divisao ja existe!!'}";
}


/*$nmusuario = $_SESSION['nmusuario'];*/
acao(''.($_SESSION["nmusuario"]).' adicionou uma nova Divisao');

?>