<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$idperiodo = (post('idperiodo'))? post('idperiodo') : '';

echo json_encode(
	array(
		'data'=>Sql::arrays('SATURN', 'FIT_NEW', "sp_turmapai_periodo_list $idperiodo"),
		'success'=> true
	)
)
?>