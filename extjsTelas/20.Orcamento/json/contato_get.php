<?
$GLOBALS["JSON"] = true;	
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idcontato = post('idcontato');


$data = Sql::arrays("Saturn", "Atendimento", "sp_contato_get $idcontato");

echo json_encode(array(
		'myData'=>$data
	));
?>