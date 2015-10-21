<?
$GLOBALS["JSON"] = true;	
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idarquivo = post('idarquivo');

$data = Sql::arrays("SATURN", "FINANCEIRO", "sp_shoplineretorno_transacaobyarquivo_list $idarquivo");

echo json_encode(array(
		'myData'=>$data
	));
	
?>