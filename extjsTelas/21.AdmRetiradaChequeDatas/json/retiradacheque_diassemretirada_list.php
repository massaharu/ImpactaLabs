<?
$GLOBALS["JSON"] = true;	
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");


$data = Sql::arrays("Saturn", "Simpac", "sp_retiradadecheque_diasemretirada_list");

echo json_encode(array(
		'myData'=>$data
	));
?>