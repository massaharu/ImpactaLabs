<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

echo json_encode(array(
		'success'=>true,
		'data'=>DescontoFit::tiposList()
	)
);
?>