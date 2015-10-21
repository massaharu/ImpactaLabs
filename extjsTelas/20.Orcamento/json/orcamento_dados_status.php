<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$idpedido = post('idpedido');
	
$lista = Sql::arrays("FOCUS","Simpac","sp_orcamentostatus_list ".($idpedido-15000));

echo json_encode(array('myData'=>$lista));
?>
