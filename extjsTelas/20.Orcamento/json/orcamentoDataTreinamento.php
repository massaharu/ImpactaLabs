<?
$GLOBALS["JSON"] = true;	
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");


$idpedido = post('idpedido')-15000;

//$idpedido = 506730;

$data = Sql::arrays("Saturn", "Simpac", "sp_OrcamentoDataTreins $idpedido");

echo json_encode(array(
		'myData'=>$data
	));
?>