<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$idperiodo = (post('idperiodo'))? (int)post('idperiodo') : '';

echo json_encode(array(
		'success'=>true,
		'data'=>Sql::arrays('SATURN', 'FIT_NEW', "sp_turmapai_list $idperiodo")
	)
);
?>