<?
$GLOBALS["JSON"] = true;	
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");


$idpedido = post('idpedido')-15000;

//$idpedido = 521730-15000;

$data = Sql::arrays("Saturn", "Simpac", "sp_OrcamentoAtend_e_Cliente $idpedido");

echo json_encode(array(
		'myData'=>$data
	));
?>