<?
$GLOBALS["JSON"] = true;	
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$dtinicio = post('dtinicio');
$dtfinal = post('dtfinal');

$data = Sql::arrays("SATURN", "FINANCEIRO", "sp_shoplineretorno_list '$dtinicio', '$dtfinal'");

echo json_encode(array(
		'myData'=>$data
	));
	
?>