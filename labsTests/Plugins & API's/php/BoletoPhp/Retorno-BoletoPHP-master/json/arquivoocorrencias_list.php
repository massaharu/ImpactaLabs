<?
$GLOBALS["JSON"] = true;	
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$data = Sql::arrays("SATURN", "FINANCEIRO", "sp_shoplineocorrencia_list");

echo json_encode(array(
		'myData'=>$data
	));
?>