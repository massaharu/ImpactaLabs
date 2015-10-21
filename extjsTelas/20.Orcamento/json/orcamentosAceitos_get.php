<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$idpedido = post('idpedido');
	
$data = Sql::arrays('Saturn','Orcamento',"sp_orcamentotosaceitos_get ".$idpedido);

echo json_encode(array('myData'=>$data));
?>
